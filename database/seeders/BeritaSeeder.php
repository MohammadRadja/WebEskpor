<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Berita;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        Berita::create([
            'judul' => 'Panen Raya Bayam Organik',
            'slug' => 'panen-raya-bayam-organik',
            'image_url' => 'panen.jpg',
        ]);
    }
}
