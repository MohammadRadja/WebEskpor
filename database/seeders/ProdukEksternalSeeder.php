<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProdukEksternal;
use App\Models\Produk;
use Illuminate\Support\Str;

class ProdukEksternalSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['nama' => 'UD Agro Sejahtera', 'kontak' => '085712345678'],
            ['nama' => 'CV Tani Nusantara', 'kontak' => '081234567890'],
            ['nama' => 'PT Agro Makmur', 'kontak' => '082212345678'],
            ['nama' => 'UD Segar Abadi', 'kontak' => '087812345678'],
            ['nama' => 'CV Hasil Bumi', 'kontak' => '089912345678'],
        ];

        foreach (Produk::all() as $produk) {
            $supplier = $suppliers[array_rand($suppliers)];
            $jumlah = rand(50, 300);
            $harga_satuan = rand(6000, 15000);
            $total_harga = $harga_satuan * $jumlah;

            ProdukEksternal::create([
                'nama_supplier' => $supplier['nama'],
                'kontak' => $supplier['kontak'],
                'id_produk' => $produk->id,
                'jenis_perjanjian' => ['pembelian-putus', 'konsinyasi'][rand(0, 1)],
                'komisi' => rand(3, 10),
                'harga_satuan' => $harga_satuan,
                'jumlah' => $jumlah,
                'tanggal_pembelian' => now()->subDays(rand(1, 15)),
                'total_harga' => $total_harga,
            ]);
        }
    }
}
