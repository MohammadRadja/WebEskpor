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
                'sumber' => 'internal',
            ],
            [
                'nama' => 'Kangkung Darat',
                'jenis' => 'sayur',
                'sumber' => 'internal',
            ],
            [
                'nama' => 'Tomat Merah',
                'jenis' => 'buah',
                'sumber' => 'internal',
            ],
            [
                'nama' => 'Cabe Rawit',
                'jenis' => 'buah',
                'sumber' => 'internal',
            ],
            [
                'nama' => 'Terong Ungu',
                'jenis' => 'sayur',
                'sumber' => 'internal',
            ],
            [
                'nama' => 'Selada Hijau',
                'jenis' => 'sayur',
                'sumber' => 'internal',
            ],
        ];

        $bibits = Bibit::all();

        foreach ($data as $index => $item) {
            if (isset($bibits[$index])) {
                Tanaman::create([
                    'nama' => $item['nama'],
                    'jenis' => $item['jenis'],
                    'id_bibit' => $bibits[$index]->id,
                    'sumber' => $item['sumber'],
                    'sumber_eksternal' => null,
                ]);
            }
        }
    }
}
