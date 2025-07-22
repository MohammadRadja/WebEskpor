<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tanaman;
use App\Models\Bibit;
use Exception;
use Illuminate\Support\Facades\Log;

class TanamanController extends Controller
{
    public function index()
    {
        try {
            $tanaman = Tanaman::with('bibit')->get();
            $bibitList = Bibit::all()
                ->map(function ($b) {
                    return [
                        'value' => $b->id,
                        'label' => $b->nama_penjual,
                    ];
                })
                ->values();

            return view('dashboard.shared.tanaman', compact('tanaman', 'bibitList'));
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal memuat data tanaman: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string',
                'jenis' => 'required|in:sayur,buah,rempah,lainnya',
                'stok_panen' => 'nullable|integer',
                'id_bibit' => 'required|exists:bibit,id',
                'sumber' => 'required|in:internal,eksternal',
                'sumber_eksternal' => 'nullable|string|required_if:sumber,eksternal',
            ]);

            Tanaman::create($request->all());

            return redirect()->route('tanaman.index')->with('success', 'Tanaman berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan tanaman: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'required|string',
                'jenis' => 'required|in:sayur,buah,rempah,lainnya',
                'stok_panen' => 'nullable|integer',
                'id_bibit' => 'required|exists:bibit,id',
                'sumber' => 'required|in:internal,eksternal',
                'sumber_eksternal' => 'nullable|string|required_if:sumber,eksternal',
            ]);

            $tanaman = Tanaman::findOrFail($id);
            $tanaman->update($request->all());

            return redirect()->route('tanaman.index')->with('success', 'Tanaman berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui tanaman: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $tanaman = Tanaman::findOrFail($id);
            $tanaman->delete();

            return redirect()->route('tanaman.index')->with('success', 'Tanaman berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus tanaman: ' . $e->getMessage());
        }
    }
}
