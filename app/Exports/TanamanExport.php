<?php

namespace App\Exports;

use App\Models\Tanaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TanamanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Tanaman::with('bibit')
            ->get()
            ->map(function ($tanaman) {
                return [
                    'nama' => $tanaman->nama,
                    'jenis' => ucfirst($tanaman->jenis),
                    'stok_barang_jadi' => format_jumlah_tanam($tanaman->stok_barang_jadi),
                    'stok_bibit' => format_jumlah_tanam($tanaman->stok_bibit),
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama Tanaman', 'Jenis', 'Stok Barang Jadi', 'Stok Bibit'];
    }
}
