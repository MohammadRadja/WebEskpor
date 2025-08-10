<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProdukEksternal;
use App\Models\Tanaman;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class ProdukEksternalController extends Controller
{
    public function index()
    {
        try {
            $produkEksternal = ProdukEksternal::with('tanaman')->orderBy('created_at', 'desc')->paginate(10);
            $tanamanList = Tanaman::all()
                ->map(
                    fn($p) => [
                        'value' => $p->id,
                        'label' => $p->nama,
                    ],
                )
                ->values();

            return view('dashboard.shared.produk-eksternal', compact('produkEksternal', 'tanamanList'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat data produk eksternal.');
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Memulai proses penyimpanan Produk Eksternal', [
                'input' => $request->all(),
            ]);

            $validated = $request->validate([
                'nama_supplier' => 'required|string',
                'kontak' => 'required|string',
                'id_tanaman' => 'required|exists:tanaman,id',
                'jenis_perjanjian' => 'required|string',
                'komisi' => 'required|numeric|min:0',
                'harga_satuan' => 'required|numeric|min:0',
                'jumlah' => 'required|integer|min:1',
                'tanggal_pembelian' => 'required|date',
            ]);

            Log::info('Validasi berhasil', ['validated_data' => $validated]);

            $validated['total_harga'] = $validated['harga_satuan'] * $validated['jumlah'];

            $produk = ProdukEksternal::create($validated);

            Log::info('Produk eksternal berhasil disimpan', [
                'produk_id' => $produk->id,
                'total_harga' => $validated['total_harga'],
            ]);

            if ($request->ajax()) {
                return response()->json(['message' => 'Berhasil ditambahkan']);
            }

            return redirect()->route('produk-eksternal.index')->with('success', 'Produk eksternal berhasil ditambahkan.');
        } catch (ValidationException $e) {
            Log::warning('Validasi gagal saat menambahkan produk eksternal', [
                'errors' => $e->errors(),
            ]);

            if ($request->ajax()) {
                return response()->json(['errors' => $e->errors()], 422);
            }

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan saat menambahkan produk eksternal', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            if ($request->ajax()) {
                return response()->json(['error' => 'Terjadi kesalahan saat menambahkan.'], 500);
            }

            return redirect()->back()->with('error', 'Gagal menambahkan produk eksternal.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'nama_supplier' => 'required|string',
                'kontak' => 'required|string',
                'id_tanaman' => 'required|exists:tanaman,id',
                'jenis_perjanjian' => 'required|string',
                'komisi' => 'required|numeric|min:0',
                'harga_satuan' => 'required|numeric|min:0',
                'jumlah' => 'required|integer|min:1',
                'tanggal_pembelian' => 'required|date',
            ]);

            $validated['total_harga'] = $validated['harga_satuan'] * $validated['jumlah'];

            $produkEksternal = ProdukEksternal::findOrFail($id);
            $produkEksternal->update($validated);

            if ($request->ajax()) {
                return response()->json(['message' => 'Berhasil diperbarui']);
            }

            return redirect()->route('produk-eksternal.index')->with('success', 'Produk eksternal berhasil diperbarui.');
        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return response()->json(['errors' => $e->errors()], 422);
            }

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Terjadi kesalahan saat memperbarui.'], 500);
            }

            return redirect()->back()->with('error', 'Gagal memperbarui produk eksternal.');
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            Log::info('Memulai proses hapus Produk Eksternal', ['produk_eksternal_id' => $id]);

            $produkEksternal = ProdukEksternal::findOrFail($id);

            Log::info('Produk Eksternal ditemukan', ['produk_eksternal' => $produkEksternal->toArray()]);

            $produkEksternal->delete();

            Log::info('Produk Eksternal berhasil dihapus', ['produk_eksternal_id' => $id]);

            if ($request->ajax()) {
                return response()->json(['message' => 'Berhasil dihapus']);
            }

            return redirect()->route('produk-eksternal.index')->with('success', 'Produk eksternal berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus Produk Eksternal', [
                'produk_eksternal_id' => $id,
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            if ($request->ajax()) {
                return response()->json(['error' => 'Gagal menghapus produk eksternal.'], 500);
            }

            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus produk eksternal. ' . $e->getMessage());
        }
    }
}
