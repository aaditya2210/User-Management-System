<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    public function index(Request $request)
{
    $roles = Role::all();

    if ($request->ajax()) {
        return response()->json(['roles' => $roles]);
    }

    return view('roles.index', compact('roles'));
}


    public function create()
    {
        try {
            return view('roles.create');
        } catch (\Exception $e) {
            Log::error('Error opening role creation page: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to open create role page.');
        }
    }

    public function store(Request $request)
{
    try {
        $request->validate(['name' => 'required|unique:roles,name']);
        $role = Role::create(['name' => $request->name]);

        return response()->json(['message' => 'Role created successfully.', 'role' => $role]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to create role.'], 500);
    }
}

    public function edit(Role $role)
    {
        try {
            $role = Role::findOrFail($role);
            if (!view()->exists('roles.edit')) {
                abort(404, 'View not found');
            }
            
            return view('roles.edit', compact('role'));
        } catch (\Exception $e) {
            Log::error('Error opening role edit page: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to open edit role page.');
        }
    }

    public function update(Request $request, Role $role)
{
    try {
        $request->validate(['name' => 'required|unique:roles,name,' . $role->id]);
        $role->update(['name' => $request->name]);

        return response()->json(['message' => 'Role updated successfully.']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to update role.'], 500);
    }
}

public function destroy($id)
{
    try {
        $role = Role::findOrFail($id);

        // Detach users and permissions before deleting the role
        $role->users()->detach();
        $role->permissions()->detach();

        $role->delete();

        return response()->json(['success' => 'Role deleted successfully.']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to delete role: ' . $e->getMessage()], 500);
    }
}

}
