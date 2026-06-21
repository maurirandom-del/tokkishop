<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {

        Permission::create(['name' => 'add to cart']);
        Permission::create(['name' => 'make payments']);
        Permission::create(['name' => 'view favorites']);

        Permission::create(['name' => 'manage products']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'view admin dashboard']);

        $userRole = Role::create(['name' => 'user']);
        $adminRole = Role::create(['name' => 'admin']);

        $userRole->givePermissionTo(['add to cart', 'make payments', 'view favorites']);
        $adminRole->givePermissionTo(Permission::all());
    }
}

