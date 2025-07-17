<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KebunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_kebun')->insert([
            [
                'nama' => 'Kebun Mawar',
                'lokasi' => 'Bandung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Kebun Melati',
                'lokasi' => 'Bogor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Kebun Kenanga',
                'lokasi' => 'Garut',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
