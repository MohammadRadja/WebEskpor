<?php

namespace App\Exports;

use App\Models\Kebun;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KebunExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $data = Kebun::select('nama', 'lokasi', 'created_at')->get();

        return $data->map(function ($item) {
            return [
                'nama' => $item->nama,
                'lokasi' => $item->lokasi,
                'created_at' => format_tanggal($item->created_at),
            ];
        });
    }

    public function headings(): array
    {
        return ['Nama Kebun', 'Lokasi', 'Tanggal Dibuat'];
    }
}
