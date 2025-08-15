<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@railway.com',
            'password' => bcrypt('password'),
            'mobile' => '01700000000',
            'gender' => 'male',
            'is_active' => true,
        ]);

        // Create sample users
        User::factory(10)->create();
    }
}
