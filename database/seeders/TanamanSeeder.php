<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tanaman;
use App\Models\Bibit;

class TanamanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Bayam Hijau',
                'jenis' => 'sayur',
            ],
            [
                'nama' => 'Kangkung Darat',
                'jenis' => 'sayur',
            ],
            [
                'nama' => 'Tomat Merah',
                'jenis' => 'buah',
            ],
            [
                'nama' => 'Cabe Rawit',
                'jenis' => 'buah',
            ],
            [
                'nama' => 'Terong Ungu',
                'jenis' => 'sayur',
            ],
            [
                'nama' => 'Selada Hijau',
                'jenis' => 'sayur',
            ],
        ];

        $bibits = Bibit::all();

        foreach ($data as $index => $item) {
            if (isset($bibits[$index])) {
                Tanaman::create([
                    'nama' => $item['nama'],
                    'jenis' => $item['jenis'],
                    'id_bibit' => $bibits[$index]->id,
                    'sumber_eksternal' => null,
                ]);
            }
        }
    }
}
