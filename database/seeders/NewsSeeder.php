<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        News::create([
            'title' => 'Panen Raya Bayam Organik',
            'slug' => 'panen-raya-bayam-organik',
            'image_url' => 'panen.jpg',
        ]);
    }
}
