<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Produk;
use App\Models\Tanaman;

class ProdukController extends Controller
{
    public function index()
    {
        try {
            $produk = Produk::with('tanaman')->get();
            // List untuk Tambah Produk
            $tanamanListAdd = Tanaman::whereDoesntHave('produk')
                ->get()
                ->map(
                    fn($t) => [
                        'value' => $t->id,
                        'label' => $t->nama,
                    ],
                )
                ->values();

            if ($tanamanListAdd->isEmpty()) {
                $tanamanListAdd = collect([['value' => null, 'label' => 'Semua tanaman sudah digunakan di produk']]);
            }

            // List untuk Edit Produk
            $tanamanListEdit = Tanaman::all()
                ->map(
                    fn($t) => [
                        'value' => $t->id,
                        'label' => $t->nama,
                    ],
                )
                ->values();

            return view('dashboard.shared.produk', compact('produk', 'tanamanListAdd', 'tanamanListEdit'));
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

            // Cek apakah tanaman sudah dipakai
            $exists = Produk::where('id_tanaman', $request->id_tanaman)->exists();
            if ($exists) {
                return response()->json(
                    [
                        'errors' => ['id_tanaman' => ['Tanaman ini sudah digunakan pada produk lain.']],
                    ],
                    422,
                );
            }

            $data = $request->only(['nama', 'id_tanaman', 'harga', 'deskripsi']);
            if ($request->filled('stok')) {
                $data['stok'] = $request->stok;
            }
            $data['id'] = Str::uuid();

            if ($request->hasFile('gambar')) {
                $filename = uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension();
                $path = 'uploads/produk/' . $filename;
                $request->file('gambar')->move(public_path('uploads/produk'), $filename);
                $data['gambar'] = $path;
            }

            Produk::create($data);

            return response()->json(['message' => 'Produk berhasil ditambahkan.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menambahkan produk.'], 500);
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

            // Pastikan jika ID tanaman baru tidak dipakai di produk lain
            if ($request->id_tanaman !== $produk->id_tanaman) {
                $exists = Produk::where('id_tanaman', $request->id_tanaman)->exists();
                if ($exists) {
                    return response()->json(
                        [
                            'errors' => ['id_tanaman' => ['Tanaman ini sudah digunakan pada produk lain.']],
                        ],
                        422,
                    );
                }
            }

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

            return response()->json(['message' => 'Produk berhasil diperbarui.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui produk.'], 500);
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

            return response()->json(['message' => 'Produk berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus produk.'], 500);
        }
    }
}
