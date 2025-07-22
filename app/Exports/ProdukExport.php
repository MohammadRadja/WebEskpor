<?php

namespace App\Exports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProdukExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Produk::select('nama', 'id_tanaman','stok', 'harga', 'deskripsi', 'gambar')->get();
    }

    public function headings(): array
    {
        return ['Nama', 'ID Tanaman', 'Stok', 'Harga', 'Deskripsi', 'Gambar'];
    }
}
