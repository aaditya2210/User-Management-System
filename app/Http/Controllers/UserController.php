<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\State;
use App\Models\City;
use App\Events\UserRegistered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;


use App\Exports\UsersExport;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreUserRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

    public function index(Request $request)
{
    try {
        
        $query = User::with(['city', 'state', 'roles'])->where('id', '!=', Auth::id());

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        if ($request->ajax()) {
            $users = $query->paginate(3); // Single instance

            return response()->json([
                'data' => $users->items(),
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
            ]);
        }

        $users = $query->paginate(3);
        return view('users.index', compact('users'));
    } catch (\Exception $e) {
        Log::error('❌ Error Fetching Users: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Something went wrong!']);
    }
}


    public function create() {
        try {
            $states = State::all();
            $roles = Role::all();
            return view('users.create', compact('states','roles'));
        } catch (\Exception $e) {
            Log::error('❌ Error Loading Create User Form: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Something went wrong!']);
        }
    }

    


    public function store(StoreUserRequest $request) {
        Log::info('📝 Form Submitted Data: ', $request->all());
    
        try {
            $validated = $request->validated();
            
            // Handle file uploads
            $uploadedFiles = [];
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $filePath = $file->storeAs('uploads', $file->getClientOriginalName(), 'public');
                    Storage::setVisibility('uploads/' . $file->getClientOriginalName(), 'public');
                    Log::info('📂 File uploaded: ' . $filePath);
                    $uploadedFiles[] = $filePath;
                }
            }
    
            // Create the user
            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'contact_number' => $validated['contact_number'],
                'postcode' => $validated['postcode'],
                'password' => Hash::make($validated['password']),
                'gender' => $validated['gender'],
                'state_id' => $validated['state_id'],
                'city_id' => $validated['city_id'],
                'hobbies' => json_encode($validated['hobbies'] ?? []),
                'uploaded_files' => json_encode($uploadedFiles)
            ]);
    
            // Attach roles to user
           
            // 🔹 Convert roles to integers before attaching
            $roleIds = array_map('intval', $request->roles);

            // Debug roles before attaching
            Log::info('Attaching Roles:', ['roles' => $roleIds]);

            // Attach roles
            $user->roles()->attach($roleIds);

    
            Log::info('✅ User Created Successfully: ', ['id' => $user->id]);
            event(new UserRegistered($user));
    
            return redirect()->route('users.index')->with('success', 'User Created Successfully');
        } catch (\Exception $e) {
            Log::error('❌ Error Saving User: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Something went wrong!'])->withInput();
        }
    }





    public function edit(User $user) {
        try {
            $states = State::all();
            $cities = City::where('state_id', $user->state_id)->get();
            return view('users.edit', compact('user', 'states', 'cities'));
        } catch (\Exception $e) {
            Log::error('❌ Error Loading Edit User Form: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Something went wrong!']);
        }
    }

    public function update(UpdateUserRequest $request, User $user) {
        Log::info('📝 Updating User Data: ', $request->all());
    
        try {
            $validated = $request->validated();
    
            $uploadedFiles = json_decode($user->uploaded_files, true) ?? [];
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $filePath = $file->storeAs('uploads', $file->getClientOriginalName(), 'public');
                    Storage::setVisibility('uploads/' . $file->getClientOriginalName(), 'public');
                    Log::info('📂 File uploaded: ' . $filePath);
                    $uploadedFiles[] = $filePath;
                }
            }
    
            $user->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'contact_number' => $validated['contact_number'],
                'postcode' => $validated['postcode'],
                'gender' => $validated['gender'],
                'state_id' => $validated['state_id'],
                'city_id' => $validated['city_id'],
                'hobbies' => json_encode($validated['hobbies'] ?? []),
                // 'roles' => json_encode($validated['roles']),
                'uploaded_files' => json_encode($uploadedFiles)
            ]);
    
            Log::info('✅ User Updated Successfully: ', ['id' => $user->id]);
    
            return redirect()->route('users.index')->with('success', 'User Updated Successfully');
        } catch (\Exception $e) {
            Log::error('❌ Error Updating User: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Something went wrong!'])->withInput();
        }
    }

    public function destroy($id): JsonResponse
{
    try {
        DB::beginTransaction(); // Start transaction

        // Fetch user manually
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        // Prevent users from deleting their own account
        if ($user->id === Auth::id()) {
            return response()->json(['error' => 'You cannot delete your own account.'], 403);
        }

        // Delete associated files if any
        $uploadedFiles = json_decode($user->uploaded_files, true) ?? [];
        foreach ($uploadedFiles as $file) {
            if (Storage::disk('public')->exists($file)) {
                Storage::disk('public')->delete($file);
                Log::info("🗑️ File deleted: $file");
            }
        }

        // Delete the user
        $user->delete();

        DB::commit(); // Commit transaction

        Log::info("✅ User Deleted Successfully: ID {$user->id}");

        return response()->json(['message' => 'User deleted successfully'], 200);
    } catch (\Exception $e) {
        DB::rollBack(); // Rollback transaction on failure
        Log::error("❌ Error Deleting User: " . $e->getMessage());
        return response()->json(['error' => 'Something went wrong while deleting the user.'], 500);
    }
}


    public function getCities(Request $request) {
        try {
            $cities = City::where('state_id', $request->state_id)->get();
            return response()->json($cities);
        } catch (\Exception $e) {
            Log::error('❌ Error Fetching Cities: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }

    public function assignUserRole($userId, $roleId)
    {
        try {
            $user = User::find($userId);
            $role = Role::find($roleId);

            if (!$user || !$role) {
                return back()->with('error', 'User or role not found.');
            }

            $user->assignRole($role);
            return back()->with('success', 'Role assigned successfully!');
        } catch (\Exception $e) {
            Log::error('❌ Error Assigning Role: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong!');
        }
    }

    // public function getUsers(Request $request)
    // {
    //     try {
    //         // Exclude the logged-in user and paginate with relationships
    //         return response()->json(
    //             User::where('id', '!=', Auth::id())
    //                 ->with(['city', 'state', 'roles'])
    //                 ->paginate(5)
    //         );
    //     } catch (\Exception $e) {
    //         Log::error('❌ Error Fetching Users: ' . $e->getMessage());
    //         return response()->json(['error' => 'Something went wrong!'], 500);
    //     }
    // }

   





    public function getUsers(Request $request)
{
    try {
        $query = User::where('id', '!=', Auth::id())->with(['city', 'state', 'roles']);

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = trim($request->search); // Remove extra spaces
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Paginate the results
        $users = $query->paginate(5);

        return response()->json($users);

    } catch (\Exception $e) {
        Log::error('❌ Error Fetching Users: ' . $e->getMessage());

        // Debug error response
        return response()->json([
            'error' => 'Something went wrong!',
            'message' => $e->getMessage(), // Show actual error message
        ], 500);
    }
}
  
    









    // CSV Export
    public function exportCSV() {
        try {
            return Excel::download(new UsersExport, 'users.csv');
        } catch (\Exception $e) {
            Log::error('❌ Error Exporting CSV: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Something went wrong!']);
        }
    }

    // Excel Export
    public function exportExcel() {
        try {
            return Excel::download(new UsersExport, 'users.xlsx');
        } catch (\Exception $e) {
            Log::error('❌ Error Exporting Excel: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Something went wrong!']);
        }
    }

    // PDF Export
    public function exportPDF() {
        try {
            $users = User::with(['city', 'state', 'roles'])->where('id', '!=', Auth::id())->get();
            $pdf = Pdf::loadView('exports.users_pdf', compact('users'));
            return $pdf->download('users.pdf');
        } catch (\Exception $e) {
            Log::error('❌ Error Exporting PDF: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Something went wrong!']);
        }
    }
}
