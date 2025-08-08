<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PetakKebun;
use App\Models\Kebun;
use App\Models\Tanaman;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PetakKebunSeeder extends Seeder
{
    public function run(): void
    {
        $penanggungJawab = ['Pak Darto', 'Bu Sari', 'Pak Joni', 'Bu Ani', 'Pak Bambang'];
        $tanamanList = Tanaman::all()->values();
        $kebunList = Kebun::all()->values();

        $jumlah = min($kebunList->count(), $tanamanList->count());

        for ($i = 0; $i < $jumlah; $i++) {
            // Panen bervariasi per bulan
            $tanggalPanen = Carbon::now()->subMonths(rand(0, 5));
            $jumlahPanen = rand(800, 2500);

            PetakKebun::create([
                'nama' => 'Petakan ' . Str::upper(chr(65 + $i)) . ($i + 1),
                'ukuran' => rand(5, 20) . 'x' . rand(5, 20) . ' m',
                'penanggung_jawab' => $penanggungJawab[array_rand($penanggungJawab)],
                'status' => 'aktif',
                'id_kebun' => $kebunList[$i]->id,
                'id_tanaman' => $tanamanList[$i]->id,
                'tanggal_tanam' => $tanggalPanen->copy()->subDays(30),
                'tanggal_panen' => $tanggalPanen,
                'jumlah_tanaman' => rand(80, 150),
                'jumlah_panen' => $jumlahPanen,
            ]);
        }
    }
}
