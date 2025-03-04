<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

use Illuminate\Routing\Controller;

class UserRoleController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('role:admin'); // Restrict access to admins only
    // }

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

    public function assignRole(Request $request, User $user)
    {
        try {
            $role = Role::findByName($request->role);
            if (!$role) {
                return back()->withErrors(['error' => 'Role not found.']);
            }
            $user->assignRole($role);
            return redirect()->back()->with('success', 'Role assigned successfully.');
        } catch (\Exception $e) {
            Log::error("❌ Error assigning role: " . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to assign role.']);
        }
    }

    public function removeRole(Request $request, User $user)
    {
        try {
            $role = Role::findByName($request->role);
            if (!$role) {
                return back()->withErrors(['error' => 'Role not found.']);
            }
    
            // Correct method for removing a role
            $user->removeRole($role->name);
    
            return redirect()->back()->with('success', 'Role removed successfully.');
        } catch (\Exception $e) {
            Log::error("❌ Error removing role: " . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to remove role.']);
        }
    }
    }
