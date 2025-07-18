<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Farm;
use App\Models\FarmPlot;
use App\Models\Plant;
use Illuminate\Database\Seeder;

class FarmPlotSeeder extends Seeder
{
    public function run(): void
    {
        FarmPlot::create([
            'name' => 'Petakan A1',
            'size' => '10x10 m',
            'responsible_person' => 'Pak Darto',
            'status' => 'Aktif',
            'farm_id' => Farm::first()->id,
            'plant_id' => Plant::first()->id,
            'planting_date' => now()->subDays(7),
            'plant_quantity' => 80,
            'harvest_quantity' => 0,
        ]);
    }
}
