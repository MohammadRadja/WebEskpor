<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PetakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_petakan_kebun')->insert([
            [
                'nama' => 'Lahan A1',
                'ukuran' => '20x30',
                'penanggung_jawab' => 'Budi',
                'status' => 'aktif',
                'kebun_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Lahan B1',
                'ukuran' => '15x25',
                'penanggung_jawab' => 'Siti',
                'status' => 'nonaktif',
                'kebun_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Lahan C1',
                'ukuran' => '10x10',
                'penanggung_jawab' => 'Rudi',
                'status' => 'aktif',
                'kebun_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
