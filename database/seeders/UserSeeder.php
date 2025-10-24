<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create User 1
        User::create([
            'name' => 'Ahmad Santri',
            'email' => 'ahmad@ngaosbareng.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create User 2
        User::create([
            'name' => 'Fatimah Santri',
            'email' => 'fatimah@ngaosbareng.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create User 3
        User::create([
            'name' => 'Ali Santri',
            'email' => 'ali@ngaosbareng.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}
