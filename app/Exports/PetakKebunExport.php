<?php

namespace App\Exports;

use App\Models\PetakKebun;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PetakKebunExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return PetakKebun::with(['kebun', 'tanaman'])
            ->get()
            ->map(function ($p) {
                return [
                    'nama' => $p->nama,
                    'ukuran' => $p->ukuran,
                    'kebun' => $p->kebun->nama ?? '-',
                    'tanaman' => $p->tanaman->nama ?? '-',
                    'penanggung_jawab' => $p->penanggung_jawab,
                    'status' => $p->status,
                    'tanggal_tanam' => format_tanggal($p->tanggal_tanam),
                    'jumlah_tanaman' => format_jumlah_tanam($p->jumlah_tanaman),
                    'jumlah_panen' => format_stok($p->jumlah_panen),
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama', 'Ukuran', 'Kebun', 'Tanaman', 'Penanggung Jawab', 'Status', 'Tanggal Tanam', 'Jumlah Tanaman', 'Jumlah Panen'];
    }
}
