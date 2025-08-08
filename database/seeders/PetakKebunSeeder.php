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

        $bulanIni = Carbon::now()->startOfMonth();

        // Data tanggal_tanam minggu 1-4 bulan ini
        $tanggalTanamMinggu1_4 = [];
        for ($week = 0; $week < 4; $week++) {
            $startDay = $week * 7 + 1;
            $endDay = min($startDay + 6, $bulanIni->daysInMonth);
            $randomDay = rand($startDay, $endDay);
            $tanggalTanamMinggu1_4[] = $bulanIni->copy()->addDays($randomDay - 1);
        }

        // Data tanggal_tanam bulan 6 - 8 tahun ini
        $tahunIni = now()->year;
        $tanggalTanamBulan6_8 = [];
        for ($bulan = 6; $bulan <= 8; $bulan++) {
            $tanggalAwalBulan = Carbon::create($tahunIni, $bulan, 1);
            $randomDay = rand(1, $tanggalAwalBulan->daysInMonth);
            $tanggalTanamBulan6_8[] = $tanggalAwalBulan->copy()->addDays($randomDay - 1);
        }

        $tanggalTanamList = array_merge($tanggalTanamMinggu1_4, $tanggalTanamBulan6_8);

        for ($i = 0; $i < min($jumlah, count($tanggalTanamList)); $i++) {
            $tanggalTanam = $tanggalTanamList[$i];
            $tanggalPanen = $tanggalTanam->copy()->addDays(30);
            $jumlahPanen = rand(800, 2500);

            PetakKebun::create([
                'nama' => 'Petakan ' . Str::upper(chr(65 + $i)) . ($i + 1),
                'ukuran' => rand(5, 20) . 'x' . rand(5, 20) . ' m',
                'penanggung_jawab' => $penanggungJawab[array_rand($penanggungJawab)],
                'status' => 'aktif',
                'id_kebun' => $kebunList[$i]->id,
                'id_tanaman' => $tanamanList[$i]->id,
                'tanggal_tanam' => $tanggalTanam,
                'tanggal_panen' => $tanggalPanen,
                'jumlah_tanaman' => rand(80, 150),
                'jumlah_panen' => $jumlahPanen,
                'created_at' => $tanggalTanam,
                'updated_at' => $tanggalTanam,
            ]);
        }
    }
}
