<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([UserSeeder::class, KebunSeeder::class, BenihSeeder::class, TanamanSeeder::class, PetakKebunSeeder::class, ProdukSeeder::class, TransaksiSeeder::class, DetailTransaksiSeeder::class, BeritaSeeder::class, ProdukEksternalSeeder::class]);
    }
}
