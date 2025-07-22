<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Kebun;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KebunExport;

class KebunController extends Controller
{
    public function index()
    {
        try {
            $kebunList = Kebun::all();
            return view('dashboard.shared.kebun', compact('kebunList'));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memuat data kebun.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'lokasi' => 'required|string',
        ]);

        try {
            Kebun::create($request->all());
            return redirect()->route('kebun.index')->with('success', 'Kebun berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menambahkan kebun.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'lokasi' => 'required|string',
        ]);

        try {
            $kebun = Kebun::findOrFail($id);
            $kebun->update($request->all());
            return redirect()->route('kebun.index')->with('success', 'Kebun berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memperbarui kebun.');
        }
    }

    public function destroy($id)
    {
        try {
            $kebun = Kebun::findOrFail($id);
            $kebun->delete();
            return redirect()->route('kebun.index')->with('success', 'Kebun berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus kebun.');
        }
    }

    public function exportExcel()
    {
        try {
            return Excel::download(new KebunExport, 'kebun.xlsx');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengekspor data kebun.');
        }
    }
}
