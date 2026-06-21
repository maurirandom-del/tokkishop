<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class UserSeeder extends Seeder
{
    public function run(): void
    {

    Role::firstOrCreate(['name' => 'admin']);
    Role::firstOrCreate(['name' => 'user']);

        $admin = User::create([
            'name' => 'Ale',
            'email' => 'aleadmin@miapp.com',
            'password' => bcrypt('12345678'),
        ]);
        $admin->assignRole('admin');

        $user1 = User::create([
            'name' => 'Mau',
            'email' => 'mauadmin@miapp.com',
            'password' => bcrypt('12345678'),
        ]);
        $user1->assignRole('user');

        $user2 = User::create([
            'name' => 'Cris',
            'email' => 'crisadmin@miapp.com',
            'password' => bcrypt('12345678'),
        ]);
        $user2->assignRole('user');

        $user3 = User::create([
            'name' => 'Usuario1',
            'email' => 'user1@miapp.com',
            'password' => bcrypt('12345678'),
        ]);
        $user3->assignRole('user');

        $user4 = User::create([
            'name' => 'Usuario2',
            'email' => 'user2@miapp.com',
            'password' => bcrypt('12345678'),
        ]);
        $user4->assignRole('user');

        $user5 = User::create([
            'name' => 'Usuario3',
            'email' => 'user3@miapp.com',
            'password' => bcrypt('12345678'),
        ]);
        $user5->assignRole('user');

        $user6 = User::create([
            'name' => 'Usuario4',
            'email' => 'user4@miapp.com',
            'password' => bcrypt('12345678'),
        ]);
        $user6->assignRole('user');

        $user7 = User::create([
            'name' => 'Usuario5',
            'email' => 'user5@miapp.com',
            'password' => bcrypt('12345678'),
        ]);
        $user7->assignRole('user');        
    }
}
