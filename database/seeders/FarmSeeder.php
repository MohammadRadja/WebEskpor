<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Farm;

class FarmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Farm::create([
            'name' => 'Kebun Sayur Subur',
            'location' => 'Bogor, Jawa Barat',
        ]);
    }
}
