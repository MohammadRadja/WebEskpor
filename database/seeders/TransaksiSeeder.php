<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\User;
use Carbon\Carbon;

class TransaksiSeeder extends Seeder
{
    public function run()
    {
        $tahun = Carbon::now()->year;
        $idPelangganSample = User::where('role', 'pelanggan')->inRandomOrder()->first()->id;
        $produkSample = Produk::inRandomOrder()->take(5)->get();

        // DATA MINGGUAN AGUSTUS
        for ($minggu = 1; $minggu <= 4; $minggu++) {
            $tanggal = Carbon::create($tahun, 8, ($minggu - 1) * 7 + 1);

            for ($i = 0; $i < 3; $i++) {
                $transaksi = Transaksi::create([
                    'id' => Str::uuid(),
                    'id_pelanggan' => $idPelangganSample,
                    'telepon' => '08123456789',
                    'alamat' => 'Jl. Lorem Ipsum Dolor Sit Amet No. ' . ($i + 1) . ', Blok A-17, Gang Mawar Melati Sepanjang Jalan Menuju Ke Utara RT 09/RW 12 Kelurahan Contohpanjang Kecamatan Simulasidata Kota Fiktifindonesia Provinsi Ipsum Raya 12345',
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

                // Tambah detail transaksi
                $produk = $produkSample->random();
                $jumlah = rand(1, 5);
                $hargaSatuan = $produk->harga ?? rand(20000, 50000);

                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id,
                    'id_produk' => $produk->id,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $hargaSatuan,
                    'sub_total' => $jumlah * $hargaSatuan,
                ]);
            }
        }

        // DATA BULANAN JUNI - AGUSTUS
        for ($bulan = 6; $bulan <= 8; $bulan++) {
            $tanggalAwalBulan = Carbon::create($tahun, $bulan, 1);

            for ($i = 0; $i < 5; $i++) {
                $transaksi = Transaksi::create([
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
                    'created_at' => $tanggalAwalBulan->copy()->addDays($i * 3),
                    'updated_at' => now(),
                ]);

                // Tambah detail transaksi
                $produk = $produkSample->random();
                $jumlah = rand(1, 8);
                $hargaSatuan = $produk->harga ?? rand(25000, 60000);

                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id,
                    'id_produk' => $produk->id,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $hargaSatuan,
                    'sub_total' => $jumlah * $hargaSatuan,
                ]);
            }
        }
    }
}
