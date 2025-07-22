<?php

namespace App\Exports;

use App\Models\Bibit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BibitExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Bibit::select('tanggal_pembelian', 'nama_penjual', 'harga_satuan', 'jumlah')->get();
    }

    public function headings(): array
    {
        return ['Tanggal Pembelian', 'Nama Penjual', 'Harga Satuan', 'Jumlah'];
    }
}
