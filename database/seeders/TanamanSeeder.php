<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tanaman;

class TanamanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Bayam Hijau', 'jenis' => 'sayur'],
            ['nama' => 'Kangkung Darat', 'jenis' => 'sayur'],
            ['nama' => 'Tomat Merah', 'jenis' => 'buah'],
            ['nama' => 'Cabe Rawit', 'jenis' => 'buah'],
            ['nama' => 'Terong Ungu', 'jenis' => 'sayur'],
            ['nama' => 'Selada Hijau', 'jenis' => 'sayur'],
        ];

        foreach ($data as $item) {
            Tanaman::create([
                'nama' => $item['nama'],
                'jenis' => $item['jenis'],
                'stok_barang_jadi' => 0,
                'stok_bibit' => 0,
            ]);
        }
    }
}
