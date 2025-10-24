<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@ngaosbareng.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Member User
        User::create([
            'name' => 'Santri Member',
            'email' => 'member@ngaosbareng.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'email_verified_at' => now(),
        ]);
    }
}
