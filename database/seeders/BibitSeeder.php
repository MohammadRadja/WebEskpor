<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bibit;
use Carbon\Carbon;

class BibitSeeder extends Seeder
{
<<<<<<< HEAD
    /**
     * Jalankan seed data ke database.
     */
=======
>>>>>>> 6e3bd2e (feat(UI): Add Update)
    public function run(): void
    {
        $data = [
            [
<<<<<<< HEAD
=======
                'nama' => 'Bayam Hijau',
>>>>>>> 6e3bd2e (feat(UI): Add Update)
                'tanggal_pembelian' => Carbon::now()->subDays(10),
                'nama_penjual' => 'Toko Tani Makmur',
                'harga_satuan' => 1000,
                'jumlah' => 100,
            ],
            [
                'nama' => 'Kangkung Darat',
                'tanggal_pembelian' => Carbon::now()->subDays(15),
                'nama_penjual' => 'CV Agro Sejahtera',
                'harga_satuan' => 1500,
                'jumlah' => 80,
            ],
            [
                'nama' => 'Tomat Merah',
                'tanggal_pembelian' => Carbon::now()->subDays(20),
                'nama_penjual' => 'PT Tanam Hijau',
                'harga_satuan' => 1200,
                'jumlah' => 120,
            ],
            [
                'nama' => 'Cabe Rawit',
                'tanggal_pembelian' => Carbon::now()->subDays(5),
                'nama_penjual' => 'UD Sumber Tani',
                'harga_satuan' => 900,
                'jumlah' => 200,
            ],
            [
                'nama' => 'Terong Ungu',
                'tanggal_pembelian' => Carbon::now()->subDays(2),
                'nama_penjual' => 'Toko Bibit Subur',
                'harga_satuan' => 1100,
                'jumlah' => 150,
            ],
            [
                'nama' => 'Selada Hijau',
                'tanggal_pembelian' => Carbon::now()->subDays(30),
                'nama_penjual' => 'Tani Organik Nusantara',
                'harga_satuan' => 1300,
                'jumlah' => 90,
            ],
        ];

        foreach ($data as $item) {
            Bibit::create($item);
        }
    }
}
