<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = collect(['Admin', 'supplier_manager', 'customer_manager'])->map(fn($role) => ['name' => $role, 'created_at' => now(), 'updated_at' => now()])->toArray();

        Role::insertOrIgnore($roles);

        $this->command->info("✅ Roles seeded successfully!");
    }
}
