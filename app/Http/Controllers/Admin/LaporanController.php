<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\BibitExport;
use App\Exports\TanamanExport;
use App\Exports\KebunExport;
use App\Exports\PetakKebunExport;
use App\Exports\ProdukExport;
use App\Exports\ProdukEksternalExport;
use App\Exports\TransaksiExport;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class LaporanController extends Controller
{
    public function index()
    {
        return view('dashboard.admin.laporan');
    }

    public function export($jenis, $format = 'excel')
    {
        // Mapping Export
        $exports = [
            'bibit' => new BibitExport(),
            'tanaman' => new TanamanExport(),
            'kebun' => new KebunExport(),
            'petak-kebun' => new PetakKebunExport(),
            'produk' => new ProdukExport(),
            'produk-eksternal' => new ProdukEksternalExport(),
            'transaksi' => new TransaksiExport(),
            'user' => new UserExport(),
        ];

        if (!array_key_exists($jenis, $exports)) {
            abort(404, 'Jenis laporan tidak ditemukan.');
        }

        $fileName = "laporan-{$jenis}." . ($format === 'pdf' ? 'pdf' : ($format === 'csv' ? 'csv' : 'xlsx'));

        // Export Excel
        if ($format === 'excel') {
            $jenisWithCharts = ['transaksi', 'bibit', 'petak-kebun'];
            $extraOptions = [];

            if (in_array($jenis, $jenisWithCharts)) {
                $extraOptions['withCharts'] = true;
            }
            return Excel::download($exports[$jenis], $fileName, \Maatwebsite\Excel\Excel::XLSX, $extraOptions);
        }

        if ($format === 'csv') {
            return Excel::download($exports[$jenis], $fileName, \Maatwebsite\Excel\Excel::CSV);
        }

        // Export PDF
        if ($format === 'pdf') {
            // Ambil data dari export
            $data = $exports[$jenis]->collection();
            $pdf = PDF::loadView('dashboard.admin.pdf-template', compact('data', 'jenis'));
            return $pdf->download($fileName);
        }

        abort(400, 'Format laporan tidak didukung.');
    }
}
