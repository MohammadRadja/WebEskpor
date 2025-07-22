<?php

namespace App\Exports;

use App\Models\Kebun;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KebunExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Kebun::select('nama', 'lokasi', 'created_at')->get();
    }

    public function headings(): array
    {
        return ['Nama Kebun', 'Lokasi', 'Tanggal Dibuat'];
    }
}
