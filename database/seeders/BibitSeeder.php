<?php

namespace Database\Seeders;

use App\Models\Bibit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BibitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bibit::create([
            'tanggal_beli' => '2025-07-14',
            'nama_penjual' => 'Toko Pertanian Makmur',
            'harga_satuan' => 10000,
            'qty' => 20,
            'total_harga' => 200000,
        ]);

        Bibit::create([
            'tanggal_beli' => '2025-07-10',
            'nama_penjual' => 'CV Agro Sejahtera',
            'harga_satuan' => 12000,
            'qty' => 10,
            'total_harga' => 120000,
        ]);
    }
}
