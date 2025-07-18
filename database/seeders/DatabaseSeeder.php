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
        $this->call([UserSeeder::class, FarmSeeder::class, SeedSeeder::class, PlantSeeder::class, FarmPlotSeeder::class, ProductSeeder::class, TransactionSeeder::class, TransactionItemSeeder::class, NewsSeeder::class, ExternalProductSeeder::class]);
    }
}
