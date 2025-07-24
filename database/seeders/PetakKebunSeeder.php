<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PetakKebun;
use App\Models\Kebun;
use App\Models\Tanaman;

class PetakKebunSeeder extends Seeder
{
    public function run(): void
    {
        PetakKebun::create([
            'nama' => 'Petakan A1',
            'ukuran' => '10x10 m',
            'penanggung_jawab' => 'Pak Darto',
            'status' => 'Aktif',
            'id_kebun' => Kebun::first()->id,
            'id_tanaman' => Tanaman::first()->id,
            'tanggal_tanam' => now()->subDays(7),
            'jumlah_tanaman' => 100,
            'jumlah_panen' => 500,
        ]);
    }
}
