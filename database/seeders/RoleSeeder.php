<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        Role::findOrCreate('admin', 'web');
        Role::findOrCreate('photographer', 'web');
        Role::findOrCreate('user', 'web');
    }
}
