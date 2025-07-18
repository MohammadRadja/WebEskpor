<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Plant;
use App\Models\Seed;
use Illuminate\Database\Seeder;

class PlantSeeder extends Seeder
{
    public function run(): void
    {
        $seed = Seed::first();

        Plant::create([
            'name' => 'Bayam Hijau',
            'type' => 'vegetable',
            'harvest_stock' => 0,
            'seed_id' => $seed->id,
            'source' => 'internal',
            'external_source' => null,
        ]);
    }
}