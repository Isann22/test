<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $photoRole = Role::firstOrCreate(['name' => 'photographer']);
        $userRole  = Role::firstOrCreate(['name' => 'user']);

        $admin = User::create([
            'name'     => 'User',
            'email'    => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole($adminRole);

        $photographer = User::create([
            'name'     => 'Photographer',
            'email'    => 'photographer@example.com',
            'password' => bcrypt('password'),
        ]);
        $photographer->assignRole($photoRole);

        $regularUser = User::create([
            'name'     => 'User',
            'email'    => 'user@example.com',
            'password' => bcrypt('password'),
        ]);
        $regularUser->assignRole($userRole);
    }
}
