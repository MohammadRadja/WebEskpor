<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kebun;

class KebunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kebun::create([
            'nama' => 'Kebun Sayur Subur',
            'lokasi' => 'Bogor, Jawa Barat',
        ]);
    }
}
