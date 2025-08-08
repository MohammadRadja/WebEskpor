<?php

namespace App\Exports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProdukExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Produk::with('tanaman')
            ->get()
            ->map(function ($produk) {
                return [
                    'nama' => $produk->nama,
                    'nama_tanaman' => $produk->tanaman->nama ?? '-',
                    'stok' => format_stok($produk->stok),
                    'harga' => rupiah($produk->harga),
                    'deskripsi' => $produk->deskripsi,
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama Produk', 'Nama Tanaman', 'Stok', 'Harga', 'Deskripsi'];
    }
}
