<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    public function index()
    {
        try {
            $roles = Role::all();
            return view('roles.index', compact('roles'));
        } catch (\Exception $e) {
            Log::error('Error fetching roles: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load roles.');
        }
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
            $request->validate([
                'name' => 'required|unique:roles,name'
            ]);

            Role::create($request->all());
            return redirect()->route('roles.index')->with('success', 'Role created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating role: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create role.');
        }
    }

    public function edit(Role $role)
    {
        try {
            return view('roles.edit', compact('role'));
        } catch (\Exception $e) {
            Log::error('Error opening role edit page: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to open edit role page.');
        }
    }

    public function update(Request $request, Role $role)
    {
        try {
            $request->validate([
                'name' => 'required|unique:roles,name,' . $role->id
            ]);

            $role->update($request->all());
            return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating role: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update role.');
        }
    }

    public function destroy(Role $role)
    {
        try {
            $role->delete();
            return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting role: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete role.');
        }
    }
}
