<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Benih;

class BenihSeeder extends Seeder
{
    /**
     * Jalankan seed data ke database.
     */
    public function run(): void
    {
        Benih::create([
            'tanggal_pembelian' => now()->subDays(10),
            'nama_penjual' => 'Toko Tani Makmur',
            'harga_satuan' => 1000,
            'jumlah' => 100,
        ]);
    }
}
