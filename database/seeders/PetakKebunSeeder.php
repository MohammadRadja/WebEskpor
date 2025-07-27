<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PetakKebun;
use App\Models\Kebun;
use App\Models\Tanaman;
use Illuminate\Support\Str;

class PetakKebunSeeder extends Seeder
{
    public function run(): void
    {
        $penanggungJawab = ['Pak Darto', 'Bu Sari', 'Pak Joni', 'Bu Ani', 'Pak Bambang'];
        $statuses = ['aktif', 'non-aktif'];

        $tanamanList = Tanaman::all();
        $kebunList = Kebun::all();
        $count = 1;

        foreach ($kebunList as $kebun) {
            foreach ($tanamanList->random(min(2, $tanamanList->count())) as $tanaman) {
                PetakKebun::create([
                    'nama' => 'Petakan ' . Str::upper(chr(64 + $count)) . $count,
                    'ukuran' => rand(5, 20) . 'x' . rand(5, 20) . ' m',
                    'penanggung_jawab' => $penanggungJawab[array_rand($penanggungJawab)],
                    'status' => $statuses[array_rand($statuses)],
                    'id_kebun' => $kebun->id,
                    'id_tanaman' => $tanaman->id,
                    'tanggal_tanam' => now()->subDays(rand(5, 30)),
                    'jumlah_tanaman' => 50,
                    'jumlah_panen' => rand(200, 800),
                ]);
                $count++;
            }
        }
    }
}
