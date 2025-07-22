<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bibit;
use App\Exports\BibitExport;
use Maatwebsite\Excel\Facades\Excel;

class BibitController extends Controller
{
    public function index()
    {
        $bibit = Bibit::latest()->get();
        return view('dashboard.shared.bibit', compact('bibit'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pembelian' => 'required|date',
            'nama_penjual' => 'required|string',
            'harga_satuan' => 'required|numeric',
            'jumlah' => 'required|integer',
        ]);

        Bibit::create($request->all());

        return redirect()->route('bibit.index')->with('success', 'Data bibit berhasil ditambahkan.');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_pembelian' => 'required|date',
            'nama_penjual' => 'required|string',
            'harga_satuan' => 'required|numeric',
            'jumlah' => 'required|integer',
        ]);

        $bibit = Bibit::findOrFail($id);
        $bibit->update($request->all());

        return redirect()->route('bibit.index')->with('success', 'Data bibit berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $bibit = Bibit::findOrFail($id);
        $bibit->delete();

        return redirect()->route('bibit.index')->with('success', 'Data bibit berhasil dihapus.');
    }

    public function exportExcel()
    {
        return Excel::download(new BibitExport, 'data-bibit.xlsx');
    }
}
