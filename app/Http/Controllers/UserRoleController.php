<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


use Illuminate\Routing\Controller;

class UserRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin'); // Restrict access to admins only
    }

    public function index()
    {
        try {
            $users = User::with('roles')->get();
            $roles = Role::with('permissions')->get();
            $permissions = Permission::all();
            
            return view('user_roles.index', compact('users', 'roles', 'permissions'));
        } catch (\Exception $e) {
            Log::error("❌ Error fetching data: " . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to load users, roles, and permissions.']);
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

            $user->removeRole($role->name);

            return redirect()->back()->with('success', 'Role removed successfully.');
        } catch (\Exception $e) {
            Log::error("❌ Error removing role: " . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to remove role.']);
        }
    }

    public function assignPermission(Request $request, Role $role)
    {
        try {
            $permission = Permission::findByName($request->permission);
            if (!$permission) {
                return back()->withErrors(['error' => 'Permission not found.']);
            }

            $role->givePermissionTo($permission);

            return redirect()->back()->with('success', 'Permission assigned successfully.');
        } catch (\Exception $e) {
            Log::error("❌ Error assigning permission: " . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to assign permission.']);
        }
    }

    public function removePermission(Request $request, Role $role)
    {
        try {
            $permission = Permission::findByName($request->permission);
            if (!$permission) {
                return back()->withErrors(['error' => 'Permission not found.']);
            }

            $role->revokePermissionTo($permission);

            return redirect()->back()->with('success', 'Permission removed successfully.');
        } catch (\Exception $e) {
            Log::error("❌ Error removing permission: " . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to remove permission.']);
        }
    }



    public function testPermissions()
{
    $user = Auth::user();

    dd([
        'roles' => $user->roles->pluck('name'),
        'permissions' => $user->permissions->pluck('name'),
    ]);
}
}
