<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaksi;
use App\Models\User;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        // Transaksi dalam negeri
        Transaksi::create([
            'telepon' => '08123456789',
            'alamat' => 'Jl. Kebun Raya No.10, Jakarta',
            'negara' => 'Indonesia',
            'biaya_pengiriman' => 10000,
            'jumlah' => 5,
            'total_harga' => 55000,
            'bukti_pembayaran' => 'bukti_transfer.jpg',
            'status' => 'dibayar',
            'id_pelanggan' => User::where('role', 'pelanggan')->first()->id,
        ]);

        // Transaksi luar negeri
        Transaksi::create([
            'telepon' => '+14155552671',
            'alamat' => '123 Main Street, Los Angeles, CA 90001',
            'negara' => 'Amerika Serikat',
            'biaya_pengiriman' => 75000,
            'jumlah' => 3,
            'total_harga' => 111000, // 3 produk x 12000 + ongkir
            'bukti_pembayaran' => 'payment_proof_us.jpg',
            'status' => 'dibayar',
            'id_pelanggan' => User::where('role', 'pelanggan')->inRandomOrder()->first()->id,
        ]);
    }
}
