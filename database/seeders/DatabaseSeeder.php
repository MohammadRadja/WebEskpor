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
        $this->call(UserSeeder::class);
        $this->call(TanamanSeeder::class);
        $this->call(BibitSeeder::class);
        $this->call(KebunSeeder::class);
        $this->call(PetakKebunSeeder::class);
        $this->call(ProdukSeeder::class);
        $this->call(KontenSeeder::class);
        $this->call(ProdukEksternalSeeder::class);
    }
}
