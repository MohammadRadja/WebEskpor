<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bibit;
use App\Models\Tanaman;
use Carbon\Carbon;

class BibitSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Bayam Hijau',
                'nama_penjual' => 'Toko Tani Makmur',
                'harga_satuan' => 1000,
                'jumlah' => 200,
            ],
            [
                'nama' => 'Kangkung Darat',
                'nama_penjual' => 'CV Agro Sejahtera',
                'harga_satuan' => 1500,
                'jumlah' => 200,
            ],
            [
                'nama' => 'Tomat Merah',
                'nama_penjual' => 'PT Tanam Hijau',
                'harga_satuan' => 1200,
                'jumlah' => 200,
            ],
            [
                'nama' => 'Cabe Rawit',
                'nama_penjual' => 'UD Sumber Tani',
                'harga_satuan' => 900,
                'jumlah' => 200,
            ],
            [
                'nama' => 'Terong Ungu',
                'nama_penjual' => 'Toko Bibit Subur',
                'harga_satuan' => 1100,
                'jumlah' => 200,
            ],
            [
                'nama' => 'Selada Hijau',
                'nama_penjual' => 'Tani Organik Nusantara',
                'harga_satuan' => 1300,
                'jumlah' => 200,
            ],
        ];

        foreach ($data as $item) {
            $tanaman = Tanaman::where('nama', $item['nama'])->first();

            Bibit::create([
                'nama' => $item['nama'],
                'tanggal_pembelian' => Carbon::now()->subMonths(rand(0,5))->subDays(rand(1,20)),
                'nama_penjual' => $item['nama_penjual'],
                'harga_satuan' => $item['harga_satuan'],
                'jumlah' => $item['jumlah'],
                'id_tanaman' => $tanaman?->id,
            ]);
        }
    }
}
