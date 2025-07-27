<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Produk;
use App\Models\Tanaman;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProdukExport;

class ProdukController extends Controller
{
    public function index()
    {
        try {
            $produk = Produk::with('tanaman')->get();
            $tanamanList = Tanaman::all()->map(fn($t) => ['value' => $t->id, 'label' => $t->nama])->values();

            return view('dashboard.shared.produk', compact('produk', 'tanamanList'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat data produk.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string',
                'id_tanaman' => 'required|exists:tanaman,id',
                'stok' => 'nullable|integer',
                'harga' => 'required|numeric',
                'deskripsi' => 'nullable|string',
                'gambar' => 'nullable|image|max:2048',
            ]);

            $data = $request->only(['nama', 'id_tanaman', 'stok', 'harga', 'deskripsi']);
            $data['id'] = Str::uuid();

            if ($request->hasFile('gambar')) {
                $filename = uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension();
                $path = 'uploads/produk/' . $filename;
                $request->file('gambar')->move(public_path('uploads/produk'), $filename);
                $data['gambar'] = $path;
            }

            Produk::create($data);

            if ($request->ajax()) {
                return response()->json(['message' => 'Produk berhasil ditambahkan.']);
            }

            return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json(['errors' => $e->errors()], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Gagal menambahkan produk.'], 500);
            }
            return redirect()->back()->with('error', 'Gagal menambahkan produk.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $produk = Produk::findOrFail($id);

            $request->validate([
                'nama' => 'required|string',
                'id_tanaman' => 'required|exists:tanaman,id',
                'stok' => 'nullable|integer',
                'harga' => 'required|numeric',
                'deskripsi' => 'nullable|string',
                'gambar' => 'nullable|image|max:2048',
            ]);

            $data = $request->only(['nama', 'id_tanaman', 'stok', 'harga', 'deskripsi']);

            if ($request->hasFile('gambar')) {
                if ($produk->gambar && file_exists(public_path($produk->gambar))) {
                    unlink(public_path($produk->gambar));
                }

                $filename = uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension();
                $path = 'uploads/produk/' . $filename;
                $request->file('gambar')->move(public_path('uploads/produk'), $filename);
                $data['gambar'] = $path;
            }

            $produk->update($data);

            if ($request->ajax()) {
                return response()->json(['message' => 'Produk berhasil diperbarui.']);
            }

            return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json(['errors' => $e->errors()], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Gagal memperbarui produk.'], 500);
            }
            return redirect()->back()->with('error', 'Gagal memperbarui produk.');
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $produk = Produk::findOrFail($id);

            if ($produk->gambar && file_exists(public_path($produk->gambar))) {
                unlink(public_path($produk->gambar));
            }

            $produk->delete();

            if ($request->ajax()) {
                return response()->json(['message' => 'Produk berhasil dihapus.']);
            }

            return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Gagal menghapus produk.'], 500);
            }

            return redirect()->back()->with('error', 'Gagal menghapus produk.');
        }
    }

    public function exportExcel()
    {
        try {
            return Excel::download(new ProdukExport(), 'data-produk.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengekspor data produk.');
        }
    }
}
