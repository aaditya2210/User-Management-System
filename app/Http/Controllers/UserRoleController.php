<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Log;

class UserRoleController extends Controller
{
    public function index()
    {
        try {
            $users = User::with('roles')->get();
            $roles = Role::all();
            return view('user_roles.index', compact('users', 'roles'));
        } catch (\Exception $e) {
            Log::error("❌ Error fetching users and roles: " . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to load users and roles.']);
        }
    }

    public function attachRole(Request $request, User $user)
    {
        try {
            $user->roles()->attach($request->role_id);
            return redirect()->back()->with('success', 'Role assigned successfully.');
        } catch (\Exception $e) {
            Log::error("❌ Error attaching role to user (User ID: {$user->id}): " . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to assign role.']);
        }
    }

    public function detachRole(User $user, Role $role)
    {
        try {
            $user->roles()->detach($role->id);
            return redirect()->back()->with('success', 'Role removed successfully.');
        } catch (\Exception $e) {
            Log::error("❌ Error detaching role from user (User ID: {$user->id}, Role ID: {$role->id}): " . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to remove role.']);
        }
    }
}
