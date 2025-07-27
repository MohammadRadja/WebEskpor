<?php

namespace App\Exports;

use App\Models\Tanaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TanamanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Tanaman::select('nama', 'jenis', 'stok', 'id_bibit', 'sumber', 'sumber_eksternal')->get();
    }

    public function headings(): array
    {
        return ['Nama', 'Jenis', 'Stok', 'ID Bibit', 'Sumber', 'Sumber Eksternal'];
    }
}
