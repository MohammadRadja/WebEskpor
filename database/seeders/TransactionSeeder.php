<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        Transaction::create([
            'buyer_name' => 'Budi Santoso',
            'phone' => '08123456789',
            'address' => 'Jl. Kebun Raya No.10, Jakarta',
            'country' => 'Indonesia',
            'shipping_cost' => 10000,
            'qty' => 5,
            'total_price' => 55000,
            'payment_proof' => 'bukti_transfer.jpg',
            'status' => 'paid',
            'user_id' => User::where('role', 'customer')->first()->id,
        ]);
    }
}
