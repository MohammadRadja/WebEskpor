<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\TransactionItem;
use Illuminate\Database\Seeder;

class TransactionItemSeeder extends Seeder
{
    public function run(): void
    {
        TransactionItem::create([
            'transaction_id' => Transaction::first()->id,
            'product_id' => Product::first()->id,
            'qty' => 5,
            'unit_price' => 9000,
            'subtotal' => 45000,
        ]);
    }
}
