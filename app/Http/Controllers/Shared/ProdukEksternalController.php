<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProdukEksternal;
use App\Models\Produk;
use Illuminate\Validation\ValidationException;

class ProdukEksternalController extends Controller
{
    public function index()
    {
        try {
            $produkEksternal = ProdukEksternal::with('produk')->get();
            $produkList = Produk::all()->map(fn($p) => [
                'value' => $p->id,
                'label' => $p->nama
            ])->values();

            return view('dashboard.shared.produk-eksternal', compact('produkEksternal', 'produkList'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat data produk eksternal.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_supplier' => 'required|string',
                'kontak' => 'required|string',
                'id_produk' => 'required|exists:produk,id',
                'jenis_perjanjian' => 'required|string',
                'komisi' => 'required|numeric|min:0',
                'harga_satuan' => 'required|numeric|min:0',
                'jumlah' => 'required|integer|min:1',
                'tanggal_pembelian' => 'required|date',
            ]);

            $validated['total_harga'] = $validated['harga_satuan'] * $validated['jumlah'];
            ProdukEksternal::create($validated);

            if ($request->ajax()) {
                return response()->json(['message' => 'Berhasil ditambahkan']);
            }

            return redirect()->route('produk-eksternal.index')->with('success', 'Produk eksternal berhasil ditambahkan.');
        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return response()->json(['errors' => $e->errors()], 422);
            }

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
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
                'id_produk' => 'required|exists:produk,id',
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
            $produkEksternal = ProdukEksternal::findOrFail($id);
            $produkEksternal->delete();

            if ($request->ajax()) {
                return response()->json(['message' => 'Berhasil dihapus']);
            }

            return redirect()->route('produk-eksternal.index')->with('success', 'Produk eksternal berhasil dihapus.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Gagal menghapus produk eksternal.'], 500);
            }

            return redirect()->back()->with('error', 'Gagal menghapus produk eksternal.');
        }
    }
}
