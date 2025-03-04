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
        $admin = Role::create(['name' => 'admin']);
        $customerManager = Role::create(['name' => 'customer_manager']);
        $supplierManager = Role::create(['name' => 'supplier_manager']);

        // Define permissions
        $permissions = [
            'manage users',
            'manage customers',
            'manage suppliers'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to roles
        $admin->givePermissionTo($permissions);
        $customerManager->givePermissionTo('manage customers');
        $supplierManager->givePermissionTo('manage suppliers');
    }
}
