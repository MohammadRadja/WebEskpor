<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tanaman;
use App\Models\Produk;
use Illuminate\Support\Str;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $deskripsi = [
            'Segar dan sehat, langsung dari kebun organik kami.',
            'Ditanam tanpa pestisida, cocok untuk konsumsi harian.',
            'Kualitas terbaik dari panen lokal.',
            'Dipanen dengan hati-hati untuk menjaga kesegaran.',
            'Produk pertanian lokal berkualitas ekspor.'
        ];

        foreach (Tanaman::all() as $tanaman) {
            Produk::create([
                'nama' => Str::title($tanaman->nama) . ' Organik',
                'stok' => rand(100, 1000),
                'harga' => rand(10000, 25000),
                'deskripsi' => $deskripsi[array_rand($deskripsi)],
                'gambar' => 'produk/' . Str::slug($tanaman->nama) . '.jpg',
                'id_tanaman' => $tanaman->id,
            ]);
        }
    }
}
