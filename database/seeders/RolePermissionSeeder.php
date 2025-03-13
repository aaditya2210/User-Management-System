<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Define roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $customerManager = Role::firstOrCreate(['name' => 'customer_manager']);
        $supplierManager = Role::firstOrCreate(['name' => 'supplier_manager']);

        // Define CRUD permissions for each module
        $modules = ['users', 'customers', 'suppliers'];
        $actions = ['create', 'read', 'update', 'delete'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "{$action}-{$module}"]);
            }
        }

        // Assign all permissions to Admin
        $admin->syncPermissions(Permission::all());

        // Assign specific permissions to roles
        $customerManager->syncPermissions([
            'read-customers',
            'create-customers',
            'update-customers',
            'delete-customers'
        ]);

        $supplierManager->syncPermissions([
            'read-suppliers',
            'create-suppliers',
            'update-suppliers',
            'delete-suppliers'
        ]);
    }
}
