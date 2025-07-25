<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bibit;
use Carbon\Carbon;

class BibitSeeder extends Seeder
{
    /**
     * Jalankan seed data ke database.
     */
    public function run(): void
    {
        $data = [
            [
                'tanggal_pembelian' => Carbon::now()->subDays(10),
                'nama_penjual' => 'Toko Tani Makmur',
                'harga_satuan' => 1000,
                'jumlah' => 100,
            ],
            [
                'tanggal_pembelian' => Carbon::now()->subDays(15),
                'nama_penjual' => 'CV Agro Sejahtera',
                'harga_satuan' => 1500,
                'jumlah' => 80,
            ],
            [
                'tanggal_pembelian' => Carbon::now()->subDays(20),
                'nama_penjual' => 'PT Tanam Hijau',
                'harga_satuan' => 1200,
                'jumlah' => 120,
            ],
            [
                'tanggal_pembelian' => Carbon::now()->subDays(5),
                'nama_penjual' => 'UD Sumber Tani',
                'harga_satuan' => 900,
                'jumlah' => 200,
            ],
            [
                'tanggal_pembelian' => Carbon::now()->subDays(2),
                'nama_penjual' => 'Toko Bibit Subur',
                'harga_satuan' => 1100,
                'jumlah' => 150,
            ],
            [
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
