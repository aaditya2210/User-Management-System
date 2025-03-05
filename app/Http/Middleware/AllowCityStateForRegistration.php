<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AllowCityStateForRegistration
{
    public function handle(Request $request, Closure $next)
    {
        // Get the referer URL from the request headers
        $referer = $request->headers->get('Referer');

        // Define allowed pages where the request is valid
        $allowedPages = [
            route('register'), // Registration Page
            url('users/create') // User Creation Page
        ];

        // Check if the referer matches any allowed pages
        if ($referer && in_array($referer, $allowedPages)) {
            return $next($request);
        }

        // Redirect to registration page if unauthorized
        return Redirect::route('register')->with('error', 'Unauthorized access to this resource.');
    }
}
