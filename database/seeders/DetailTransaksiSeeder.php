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
        $transaksi = Transaksi::all();
        $produkList = Produk::all();

        // Detail untuk transaksi dalam negeri
        if ($transaksi->count() >= 1 && $produkList->count() >= 1) {
            DetailTransaksi::create([
                'id_transaksi' => $transaksi[0]->id,
                'id_produk' => $produkList[0]->id,
                'jumlah' => 5,
                'harga_satuan' => 9000,
                'sub_total' => 5 * 9000,
            ]);
        }

        // Detail untuk transaksi luar negeri
        if ($transaksi->count() >= 2 && $produkList->count() >= 2) {
            DetailTransaksi::create([
                'id_transaksi' => $transaksi[1]->id,
                'id_produk' => $produkList[1]->id ?? $produkList[0]->id,
                'jumlah' => 3,
                'harga_satuan' => 12000,
                'sub_total' => 3 * 12000,
            ]);
        }
    }
}
