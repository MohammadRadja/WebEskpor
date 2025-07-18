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
            'password' => Hash::make('admin123'),
            'role' => 'administrator',
        ]);

        User::create([
            'username' => 'kepala kebun',
            'email' => 'kebun@example.com',
            'password' => Hash::make('kebun123'),
            'role' => 'farm_manager',
        ]);

        User::create([
            'username' => 'sales',
            'email' => 'sales@example.com',
            'password' => Hash::make('sales123'),
            'role' => 'sales',
        ]);

        User::create([
            'username' => 'pembeli',
            'email' => 'pembeli@example.com',
            'password' => Hash::make('pembeli123'),
            'role' => 'customer',
        ]);
    }
}
