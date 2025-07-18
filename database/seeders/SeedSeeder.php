<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seed;

class SeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Seed::create([
            'purchase_date' => now()->subDays(10),
            'seller_name' => 'Toko Tani Makmur',
            'unit_price' => 1000,
            'quantity' => 100,
        ]);
    }
}
