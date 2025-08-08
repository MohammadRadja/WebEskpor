<?php

namespace App\Exports;

use App\Models\Bibit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BibitExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Bibit::with('tanaman')
            ->get()
            ->map(function ($bibit) {
                return [
                    'nama_tanaman' => $bibit->tanaman->nama ?? '-',
                    'tanggal_pembelian' => format_tanggal($bibit->tanggal_pembelian),
                    'nama_penjual' => $bibit->nama_penjual,
                    'harga_satuan' => rupiah($bibit->harga_satuan),
                    'jumlah' => format_jumlah_tanam($bibit->jumlah),
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama Tanaman', 'Tanggal Pembelian', 'Nama Penjual', 'Harga Satuan', 'Jumlah'];
    }
}
