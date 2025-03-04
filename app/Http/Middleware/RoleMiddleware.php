<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            Log::error("❌ User not authenticated");
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();
        Log::info("🔍 Checking role for user ID: " . $user->id);
        
        if (!$user->hasRole($role)) {
            Log::error("❌ User {$user->id} does not have role: {$role}");
            abort(403, 'Unauthorized');
        }

        Log::info("✅ User {$user->id} has role: {$role}");
        return $next($request);
    }
}
