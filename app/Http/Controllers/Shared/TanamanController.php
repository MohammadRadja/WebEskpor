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
            $tanaman = Tanaman::orderBy('created_at', 'desc')->paginate(10);

            return view('dashboard.shared.tanaman', compact('tanaman'));
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal memuat data tanaman: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Request data untuk tambah tanaman:', $request->all());

            $request->validate([
                'nama' => 'required|string',
                'jenis' => 'required|in:sayur,buah,rempah,lainnya',
                'stok_barang_jadi' => 'nullable|integer',
                'stok_bibit' => 'nullable|integer',
            ]);

            $tanaman = Tanaman::create($request->only(['nama', 'jenis', 'stok_panen', 'id_bibit', 'sumber', 'sumber_eksternal']));

            Log::info('Data tanaman berhasil dibuat:', $tanaman->toArray());

            return redirect()->route('tanaman.index')->with('success', 'Tanaman berhasil ditambahkan.');
        } catch (Exception $e) {
            Log::error('Gagal menambahkan tanaman: ' . $e->getMessage());

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
                'stok_barang_jadi' => 'nullable|integer',
                'stok_bibit' => 'nullable|integer',
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
