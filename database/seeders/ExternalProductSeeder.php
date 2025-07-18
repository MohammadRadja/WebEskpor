<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ExternalProduct;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ExternalProductSeeder extends Seeder
{
    public function run(): void
    {
        ExternalProduct::create([
            'supplier_name' => 'UD Agro Sejahtera',
            'contact' => '085712345678',
            'product_id' => Product::first()->id,
            'agreement_type' => 'buyout',
            'commission' => null,
            'unit_price' => 8000,
            'quantity' => 100,
            'purchase_date' => now()->subDays(3),
            'total_price' => 800000,
        ]);
    }
}
