<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\State;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Cookie;
// use App\Models\Role;
use Spatie\Permission\Models\Role;

use App\Events\UserRegistered;
use App\Http\Requests\RegisterUserRequest;

use Illuminate\Support\Facades\Cache;
// use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
// use Laravel\Passpor;
use App\Mail\OTPMail;


class AuthController extends Controller
{
    /**
     * Register a new user and return access token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
   public function register(RegisterUserRequest $request)
    {
        try {

            $validatedData = $request->validated();

            // Create the user using validated data
            $user = User::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                'contact_number' => $validatedData['contact_number'],
                'postcode' => $validatedData['postcode'],
                'password' => bcrypt($validatedData['password']),
                'gender' => $validatedData['gender'],
                'state_id' => $validatedData['state_id'],
                'city_id' => $validatedData['city_id'],
                'hobbies' => json_encode($validatedData['hobbies'] ?? []), // Handle nullable hobbies
                'uploaded_files' => json_encode($validatedData['uploaded_files'] ?? []),
            ]);

            // 🔹 Convert roles to integers before attaching
            $roleIds = array_map('intval', $request->roles);
            Log::info('Attaching Roles:', ['roles' => $roleIds]);

            // Attach roles
            $user->roles()->attach($roleIds);

            // Handle file uploads
            if ($request->hasFile('files')) {
                $uploadedFiles = [];
                foreach ($request->file('files') as $file) {
                    $filePath = $file->store('uploads', 'public');
                    $uploadedFiles[] = $filePath;
                }
                $user->uploaded_files = json_encode($uploadedFiles);
                $user->save();
            }

            // Generate OAuth token
            $oauthClient = Client::where('password_client', 1)->latest()->first();
            if (!$oauthClient) {
                Log::error('OAuth password client not found during registration.');
                return response()->json(['error' => 'OAuth password client not found'], 500);
            }

            $data = [
                'grant_type' => 'password',
                'client_id' => $oauthClient->id,
                'client_secret' => $oauthClient->secret,
                'username' => $request->email,
                'password' => $request->password,
            ];

            $tokenRequest = app('request')->create('/oauth/token', 'POST', $data);
            $tokenResponse = json_decode(app()->handle($tokenRequest)->getContent());

            if (isset($tokenResponse->access_token)) {
                session(['access_token' => $tokenResponse->access_token]);
                event(new UserRegistered($user));
                // return redirect()->to('http://127.0.0.1:8000/users')->with('success', 'Registration successful!');
                Auth::login($user);
                return redirect()->to('http://127.0.0.1:8000/login')->with('success', 'Registration successful!');
                
            
            }

            Log::error('Token generation failed during registration.');
            return response()->json(['error' => 'Token generation failed'], 500);
        } catch (\Exception $e) {
            Log::error('Error in register method:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
        }
    }

    /**
     * Login user and create token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function login(Request $request)
    // {
    //     try {
    //         $credentials = [
    //             'email' => $request->email,
    //             'password' => $request->password,
    //         ];

    //         if (!Auth::attempt($credentials)) {
    //             return response()->json(['error' => 'Invalid credentials'], 401);
    //         }

    //         $user = Auth::user();

    //         // Fetch OAuth client for password grant
    //         $oauthClient = Client::where('password_client', 1)->latest()->first();
    //         if (!$oauthClient) {
    //             Log::error('OAuth password client not found during login.');
    //             return response()->json(['error' => 'OAuth password client not found'], 500);
    //         }

    //         // Prepare data for OAuth token request
    //         $data = [
    //             'grant_type' => 'password',
    //             'client_id' => $oauthClient->id,
    //             'client_secret' => $oauthClient->secret,
    //             'username' => $request->email,
    //             'password' => $request->password,
    //         ];

    //         $tokenRequest = app('request')->create('/oauth/token', 'POST', $data);
    //         $tokenResponse = json_decode(app()->handle($tokenRequest)->getContent());

    //         if (isset($tokenResponse->access_token)) {
    //             return response()->json([
    //                 'access_token' => $tokenResponse->access_token,
    //                 'token_type' => 'Bearer',
    //                 'expires_in' => $tokenResponse->expires_in,
    //             ]);
    //         }

    //         Log::error('Token generation failed during login.');
    //         return response()->json(['error' => 'Token generation failed'], 500);
    //     } catch (\Exception $e) {
    //         Log::error('Error in login method:', ['message' => $e->getMessage()]);
    //         return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
    //     }
    // }

    // ------------------------------------------------------------------------------------------------------
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['error' => 'Invalid Credentials']);
        }

        $user = Auth::user();

        // Generate OTP
        $otp = rand(100000, 999999);
        Cache::put('otp_' . $user->id, $otp, now()->addMinutes(5));

        // Send OTP via email (Modify as per your mail configuration)
        Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Your Security Verification Code');
        });

        // Store user ID in session for verification
        session(['user_id' => $user->id]);

        return redirect()->route('otp.page')->with('message', 'OTP sent to your email.');
    }


    public function verifyOtp(Request $request)
    {
        try {
            Log::info('Starting OTP verification', ['request' => $request->all()]);

            // Validate the OTP request
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'otp' => 'required|numeric',
            ]);

            // Find user
            $user = User::find($request->user_id);
            Log::info('User found', ['user' => $user]);

            // Retrieve OTP from cache
            $cachedOtp = Cache::get('otp_' . $user->id);
            Log::info('Cached OTP Retrieved', ['cachedOtp' => $cachedOtp]);

            // Validate OTP
            if (!$cachedOtp || $cachedOtp != $request->otp) {
                Log::warning('Invalid OTP', ['provided_otp' => $request->otp, 'cached_otp' => $cachedOtp]);
                return response()->json(['error' => 'Invalid or expired OTP'], 401);
            }

            // OTP is valid, clear cache
            Cache::forget('otp_' . $user->id);
            Log::info('OTP cache cleared');

            // Authenticate the user
            Auth::login($user);
            Log::info('User logged in', ['user_id' => $user->id]);

            // Generate a Personal Access Token
            $tokenResult = $user->createToken('User Personal Token');
            $token = $tokenResult->accessToken;
            Log::info('Access token generated', ['token' => $token]);

            // Return JSON response with token (to store in localStorage)
            return response()->json([
                'success' => true,
                'message' => 'OTP Verified Successfully!',
                'token' => $token
            ]);

        } catch (\Exception $e) {
            Log::error('Error in verifyOtp method:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
        }
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Get Authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        try {
            return response()->json(Auth::user());
        } catch (\Exception $e) {
            Log::error('Error in user method:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to retrieve user details.'], 500);
        }
    }

    public function showLoginForm()
    {
        return view('auth.login'); // Ensure this file exists in `resources/views/auth/`
    }

    public function showRegisterForm()
    {
        try {
            $states = State::all(); // Fetch all states from the database
            $roles = Role::all(); // Fetch all roles from the database

            return view('auth.register', compact('states', 'roles')); // Pass both states and roles to the view
        } catch (\Exception $e) {
            Log::error('Error in showRegisterForm:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to load registration form.'], 500);
        }
    }

    public function logout(Request $request)
{

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/'); // Redirect to homepage or another public page
}
}
