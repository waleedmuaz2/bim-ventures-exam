<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $consumerRole = Role::create(['name' => 'customer']);

        // Create permissions
        $createPermission = Permission::create(['name' => 'create_transaction']);
        $viewPermission = Permission::create(['name' => 'view_transaction']);
        $editPermission = Permission::create(['name' => 'edit_transaction']);

        // Assign permissions to roles
        $adminRole->givePermissionTo($createPermission, $viewPermission, $editPermission);
        $consumerRole->givePermissionTo($viewPermission);

    }
}
