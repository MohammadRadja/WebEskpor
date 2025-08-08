<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;

class TransaksiSeeder extends Seeder
{
    public function run()
    {
        $tahun = Carbon::now()->year;
        $idPelangganSample = User::where('role', 'pelanggan')->inRandomOrder()->first()->id;

        // DATA MINGGUAN AGUSTUS (Minggu ke 1 sampai 4)
        // Asumsi: minggu ke-1 adalah hari 1-7 Agustus, dst.
        for ($minggu = 1; $minggu <= 4; $minggu++) {
            $tanggal = Carbon::create($tahun, 8, ($minggu - 1) * 7 + 1);

            // Insert 3 transaksi per minggu contoh
            for ($i = 0; $i < 3; $i++) {
                Transaksi::create([
                    'id' => Str::uuid(),
                    'id_pelanggan' => $idPelangganSample,
                    'telepon' => '08123456789',
                    'alamat' => 'Jl. Contoh Alamat No. ' . ($i + 1),
                    'negara' => 'Indonesia',
                    'ekspedisi' => 'JNE',
                    'biaya_pengiriman' => 15000,
                    'jumlah' => rand(1, 5),
                    'total_harga' => rand(100000, 500000),
                    'no_resi' => null,
                    'jenis_pengiriman' => 'ditanggung_pembeli',
                    'status' => 'selesai',
                    'payment_url' => null,
                    'created_at' => $tanggal->copy()->addDays($i),
                ]);
            }
        }

        // DATA BULANAN JUNI - AGUSTUS TAHUN INI (bulan 6-8)
        for ($bulan = 6; $bulan <= 8; $bulan++) {
            $tanggalAwalBulan = Carbon::create($tahun, $bulan, 1);

            // Insert 5 transaksi per bulan contoh
            for ($i = 0; $i < 5; $i++) {
                Transaksi::create([
                    'id' => Str::uuid(),
                    'id_pelanggan' => $idPelangganSample,
                    'telepon' => '08123456789',
                    'alamat' => 'Jl. Contoh Alamat No. ' . ($i + 1),
                    'negara' => 'Indonesia',
                    'ekspedisi' => 'J&T',
                    'biaya_pengiriman' => 12000,
                    'jumlah' => rand(1, 10),
                    'total_harga' => rand(200000, 1000000),
                    'no_resi' => null,
                    'jenis_pengiriman' => 'ditanggung_penjual',
                    'status' => 'selesai',
                    'payment_url' => null,
                    'created_at' => $tanggalAwalBulan->copy()->addDays($i * 3), // Setiap 3 hari
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
