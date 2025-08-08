<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kebun;

class KebunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Kebun Sayur Subur',
                'lokasi' => 'Pasaman, Sumatera Barat',
            ],
            [
                'nama' => 'Kebun Organik Bukittinggi',
                'lokasi' => 'Bukittinggi, Sumatera Barat',
            ],
            [
                'nama' => 'Kebun Tani Sejahtera',
                'lokasi' => 'Padang Panjang, Sumatera Barat',
            ],
            [
                'nama' => 'Kebun Lestari',
                'lokasi' => 'Solok, Sumatera Barat',
            ],
            [
                'nama' => 'Kebun Alam Hijau',
                'lokasi' => 'Payakumbuh, Sumatera Barat',
            ],
            [
                'nama' => 'Kebun Agro Mandiri',
                'lokasi' => 'Pariaman, Sumatera Barat',
            ],
            [
                'nama' => 'Kebun Raya Sawahlunto',
                'lokasi' => 'Sawahlunto, Sumatera Barat',
            ],
        ];

        foreach ($data as $item) {
            Kebun::create($item);
        }
    }
}
