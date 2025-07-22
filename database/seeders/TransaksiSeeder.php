<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaksi;
use App\Models\User;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
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
    }
}
