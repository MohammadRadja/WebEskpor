<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tanaman;
use App\Models\Bibit;
use Illuminate\Database\Seeder;

class TanamanSeeder extends Seeder
{
    public function run(): void
    {
        Tanaman::create([
            'nama' => 'Bayam Hijau',
            'jenis' => 'sayur',
            'stok_panen' => 0,
            'id_bibit' => Bibit::first()->id,
            'sumber' => 'internal',
            'sumber_eksternal' => null,
        ]);
    }
}