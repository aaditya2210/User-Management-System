<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AllowCityStateForRegistration
{
    public function handle(Request $request, Closure $next)
    {
        // Get the referer URL from the request headers
        $referer = $request->headers->get('Referer');

        // If the referer contains '/users/{user}/edit', store it in session
        // if ($referer && str_contains($referer, '/users/') && str_contains($referer, '/edit')) {
        //     Session::put('edit_page', $referer);
        // }


        // If the referer contains '/users/{user}/edit' or '/suppliers/{supplier}/edit', store it in session
        if (
            $referer &&
            (preg_match('/\/users\/\d+\/edit/', $referer) || preg_match('/\/suppliers\/\d+\/edit/', $referer))
        ) {
            Session::put('edit_page', $referer);
        }


        // Retrieve the stored edit page from the session
        $editPage = Session::get('edit_page');

        // Define allowed pages where the request is valid
        $allowedPages = [
            route('register'), // Registration Page
            url('users/create'), // User Creation Page
            url('suppliers/create'), // User Creation Page
            $editPage // Store and use the edit page referer
        ];

        // Log for debugging
        Log::info('Referer:', ['referer' => $referer]);
        Log::info('Allowed Pages:', ['allowedPages' => $allowedPages]);

        // Check if the referer matches any allowed pages
        if ($referer && in_array($referer, $allowedPages)) {
            return $next($request);
        }

        // Redirect to registration page if unauthorized
        return Redirect::route('register')->with('error', 'Unauthorized access to this resource.');
    }
}
