<?php

namespace App\Exports;

use App\Models\ProdukEksternal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProdukEksternalExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return ProdukEksternal::with('tanaman')
            ->get()
            ->map(function ($item) {
                $totalHarga = $item->total_harga;
                $komisiNominal = ($item->komisi / 100) * $totalHarga;

                return [
                    'nama_tanaman' => $item->tanaman->nama ?? '-',
                    'nama_supplier' => $item->nama_supplier,
                    'kontak' => $item->kontak,
                    'jenis_perjanjian' => ucwords(str_replace('-', ' ', $item->jenis_perjanjian)),
                    'komisi' => $item->komisi . '%',
                    'komisi_didapat' => rupiah($komisiNominal),
                    'harga_satuan' => rupiah($item->harga_satuan),
                    'jumlah' => format_jumlah_tanam($item->jumlah),
                    'tanggal_pembelian' => format_tanggal($item->tanggal_pembelian),
                    'total_harga' => rupiah($totalHarga),
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama Tanaman', 'Nama Supplier', 'Kontak', 'Jenis Perjanjian', 'Komisi', 'Komisi Didapat', 'Harga Satuan', 'Jumlah', 'Tanggal Pembelian', 'Total Harga'];
    }
}
