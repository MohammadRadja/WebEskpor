<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\DetailTransaksi;

class DetailTransaksiSeeder extends Seeder
{
    public function run(): void
    {
        DetailTransaksi::create([
            'id_transaksi' => Transaksi::first()->id,
            'id_produk' => Produk::first()->id,
            'jumlah' => 5,
            'harga_satuan' => 9000,
            'sub_total' => 45000,
        ]);
    }
}
