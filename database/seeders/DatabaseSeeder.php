<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        // User::factory(10)->create();
        $role = Role::find('019bdc2f-45af-73b5-bf4b-d48fe77361e0');
        $user = User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
        ]);
    }
}
