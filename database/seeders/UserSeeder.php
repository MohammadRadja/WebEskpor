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
            'username' => 'Kepala Kebun',
            'email' => 'kebun@example.com',
            'password' => Hash::make('kebun123'),
            'role' => 'manajer_kebun',
        ]);

        User::create([
            'username' => 'Penjual',
            'email' => 'sales@example.com',
            'password' => Hash::make('sales123'),
            'role' => 'penjual',
        ]);

        User::create([
            'username' => 'Pelanggan',
            'email' => 'pelanggan@example.com',
            'password' => Hash::make('pelanggan123'),
            'role' => 'pelanggan',
        ]);
    }
}
