<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Plant;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'description' => 'Bayam segar hasil panen organik',
            'image' => 'bayam.jpg',
            'plant_id' => Plant::first()->id,
        ]);
    }
}
