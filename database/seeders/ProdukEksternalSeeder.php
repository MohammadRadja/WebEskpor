<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProdukEksternal;
use App\Models\Tanaman;
use Illuminate\Support\Str;

class ProdukEksternalSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['nama' => 'UD Agro Sejahtera', 'kontak' => '085712345678'],
            ['nama' => 'CV Tani Nusantara', 'kontak' => '081234567890'],
            ['nama' => 'PT Agro Makmur', 'kontak' => '082212345678'],
        ];

        foreach (Tanaman::all() as $tanaman) {
            for ($i = 0; $i < 3; $i++) {
                $supplier = $suppliers[array_rand($suppliers)];
                $jumlah = rand(300, 1500);
                $harga_satuan = rand(6000, 12000);
                $tanggalPembelian = now()->subMonths(rand(0, 5))->subDays(rand(1, 10));

                ProdukEksternal::create([
                    'nama_supplier' => $supplier['nama'],
                    'kontak' => $supplier['kontak'],
                    'id_tanaman' => $tanaman->id,
                    'jenis_perjanjian' => ['pembelian-putus', 'konsinyasi'][rand(0, 1)],
                    'komisi' => rand(3, 10),
                    'harga_satuan' => $harga_satuan,
                    'jumlah' => $jumlah,
                    'tanggal_pembelian' => $tanggalPembelian,
                    'total_harga' => $harga_satuan * $jumlah,
                ]);
            }
        }
    }
}
