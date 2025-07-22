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
            'nama' => 'Bayam Organik',
            'stok' => 150,
            'harga' => 12000,
            'deskripsi' => 'Bayam segar hasil panen organik langsung dari kebun kami.',
            'gambar' => 'produk/bayam.jpg',
            'id_tanaman' => Tanaman::first()->id,
        ]);
    }
}
