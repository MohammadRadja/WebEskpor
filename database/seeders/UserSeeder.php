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
        User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'username' => 'kepalakebun',
            'email' => 'kebun@example.com',
            'password' => Hash::make('password'),
            'role' => 'kepala_kebun',
        ]);

        User::create([
            'username' => 'sales',
            'email' => 'sales@example.com',
            'password' => Hash::make('password'),
            'role' => 'sales',
        ]);

        User::create([
            'username' => 'pembeli',
            'email' => 'pembeli@example.com',
            'password' => Hash::make('password'),
            'role' => 'pembeli',
        ]);
    }
}
