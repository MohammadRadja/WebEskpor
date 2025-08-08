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

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // Buat data pembelian mingguan untuk minggu ke 1-4 bulan ini
        foreach ($data as $item) {
            for ($week = 1; $week <= 4; $week++) {
                // Tanggal random dalam minggu ke-$week bulan ini
                $startDay = ($week - 1) * 7 + 1;
                $endDay = $week * 7;
                $randomDay = rand($startDay, $endDay);

                $tanggalPembelian = Carbon::create($currentYear, $currentMonth, $randomDay);

                $tanaman = Tanaman::where('nama', $item['nama'])->first();

                Bibit::create([
                    'nama' => $item['nama'],
                    'tanggal_pembelian' => $tanggalPembelian,
                    'nama_penjual' => $item['nama_penjual'],
                    'harga_satuan' => $item['harga_satuan'],
                    'jumlah' => $item['jumlah'],
                    'id_tanaman' => $tanaman?->id,
                ]);
            }
        }

        // Buat data pembelian bulanan untuk bulan 6-8 tahun ini (Juni-Agustus)
        for ($month = 6; $month <= 8; $month++) {
            foreach ($data as $item) {
                // Tanggal acak di bulan ini (1-28 supaya aman)
                $randomDay = rand(1, 28);
                $tanggalPembelian = Carbon::create($currentYear, $month, $randomDay);

                $tanaman = Tanaman::where('nama', $item['nama'])->first();

                Bibit::create([
                    'nama' => $item['nama'],
                    'tanggal_pembelian' => $tanggalPembelian,
                    'nama_penjual' => $item['nama_penjual'],
                    'harga_satuan' => $item['harga_satuan'],
                    'jumlah' => $item['jumlah'],
                    'id_tanaman' => $tanaman?->id,
                ]);
            }
        }
    }
}
