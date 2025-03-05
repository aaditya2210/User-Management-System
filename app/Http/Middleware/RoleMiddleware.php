<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            Log::error("❌ Access Denied: User not authenticated");
            return response('Unauthorized access', 403);
        }

        $user = Auth::user();

        // Ensure correct user instance
        if (!$user instanceof User) {
            Log::error("❌ Invalid User Instance.");
            return response('Unauthorized access', 403);
        }

        Log::info("🔍 Checking role '{$role}' for user ID: {$user->id}");

        // Debugging: Check all assigned roles
        Log::info("👤 User {$user->id} has roles: " . json_encode($user->getRoleNames()));

        // Check role (supports multiple roles using '|' separator)
        if (!$user->hasRole(explode('|', $role))) { 
            Log::warning("🚫 Access Denied: User {$user->id} does NOT have role '{$role}'");
            abort(403, 'You do not have permission to access this resource.');
        }

        Log::info("✅ Access Granted: User {$user->id} has the required role '{$role}'");

        return $next($request);
    }
}
