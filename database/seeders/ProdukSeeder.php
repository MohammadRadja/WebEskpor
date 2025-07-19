<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tanaman;
use App\Models\Produk;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        Produk::create([
            'deskripsi' => 'Bayam segar hasil panen organik',
            'gambar' => 'bayam.jpg',
            'id_tanaman' => Tanaman::first()->id,
        ]);
    }
}
