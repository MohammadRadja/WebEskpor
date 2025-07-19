<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProdukEksternal;
use App\Models\Produk;

class ProdukEksternalSeeder extends Seeder
{
    public function run(): void
    {
        ProdukEksternal::create([
            'nama_supplier' => 'UD Agro Sejahtera',
            'kontak' => '085712345678',
            'id_produk' => Produk::first()->id,
            'jenis_perjanjian' => 'pembelian_putus',
            'komisi' => null,
            'harga_satuan' => 8000,
            'jumlah' => 100,
            'tanggal_pembelian' => now()->subDays(3),
            'total_harga' => 800000,
        ]);
    }
}
