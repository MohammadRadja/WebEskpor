<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransaksiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Transaksi::with('pelanggan')
            ->get()
            ->map(function ($item) {
                return [
                    'nama_pelanggan' => $item->pelanggan->username ?? '-',
                    'telepon' => $item->telepon,
                    'alamat' => $item->alamat,
                    'negara' => $item->negara,
                    'jumlah' => $item->jumlah,
                    'ekspedisi' => $item->ekspedisi,
                    'biaya_pengiriman' => rupiah($item->biaya_pengiriman),
                    'no_resi' => $item->no_resi,
                    'jenis_pengiriman' => ucwords(str_replace('_', ' ', $item->jenis_pengiriman)),
                    'total_harga' => rupiah($item->total_harga),
                    'status' => $item->status,
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama Pelanggan', 'Telepon', 'Alamat', 'Negara', 'Jumlah', 'Ekspedisi', 'Biaya Pengiriman', 'No Resi', 'Jenis Pengiriman', 'Total Harga', 'Status'];
    }
}
