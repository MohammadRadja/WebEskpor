<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Konten;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class KontenController extends Controller
{
    public function index()
    {
        try {
            $halaman = Konten::where('jenis', 'halaman')->paginate(10);
            $artikel = Konten::where('jenis', 'artikel')->paginate(10);
            $spanduk = Konten::where('jenis', 'spanduk')->paginate(10);
            $komponen = Konten::where('jenis', 'komponen')->paginate(10);

            return view('dashboard.penjual.konten', compact('halaman', 'artikel', 'spanduk', 'komponen'));
        } catch (\Exception $e) {
            Log::error('Gagal memuat data konten:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Gagal memuat data konten.');
        }
    }

   public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'jenis' => 'required|in:halaman,artikel,spanduk,komponen',
            'konten' => 'required|string|max:255',
            'kutipan' => 'required|string|max:255',
            'gambar' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'tautan' => 'nullable|string|regex:/^(\/[a-zA-Z0-9_\-\/]*)?$/',
            'meta' => 'nullable|array',
            'media' => 'nullable|array',
            'diterbitkan_pada' => 'required|date',
            'status' => 'nullable|in:terbit,draf',
            'penulis' => 'nullable|string',
        ]);

        // Proses upload file
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $path = public_path('uploads/konten');

            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            $file->move($path, $namaFile);
            $gambarPath = 'uploads/konten/' . $namaFile;
        }

        $penulis = User::whereIn('role', ['administrator', 'penjual'])->first();

        if (!$penulis) {
            throw new \Exception('Penulis dengan role administrator atau penjual tidak ditemukan.');
        }

        Konten::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'jenis' => $request->jenis,
            'kutipan' => $request->kutipan,
            'konten' => $request->konten,
            'gambar' => $gambarPath, // path permanen
            'tautan' => $request->tautan,
            'meta' => $request->meta,
            'media' => $request->media,
            'status' => $request->status ?? 'draf',
            'diterbitkan_pada' => $request->diterbitkan_pada,
            'penulis' => $request->penulis,
        ]);

        return redirect()->route('konten.index')->with('success', 'Konten berhasil ditambahkan.');
    } catch (ValidationException $e) {
        return redirect()->back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menambahkan konten.');
    }
}


   public function update(Request $request, Konten $konten)
{
    try {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'jenis' => 'required|in:halaman,artikel,spanduk,komponen',
            'konten' => 'required|string|max:255',
            'kutipan' => 'required|string|max:255',
            'gambar' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'tautan' => 'nullable|string',
            'meta' => 'nullable|json',
            'media' => 'nullable|json',
            'status' => 'nullable|in:terbit,draf',
            'diterbitkan_pada' => 'required|date',
            'penulis' => 'nullable|string',
        ]);

        $gambarPath = $konten->gambar; // default gambar lama
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $path = public_path('uploads/konten');

            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            $file->move($path, $namaFile);
            $gambarPath = 'uploads/konten/' . $namaFile;
        }

        $konten->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'jenis' => $request->jenis,
            'kutipan' => $request->kutipan,
            'konten' => $request->konten,
            'gambar' => $gambarPath, // simpan path permanen
            'tautan' => $request->tautan,
            'status' => $request->status ?? 'draf',
            'diterbitkan_pada' => $request->diterbitkan_pada,
            'penulis' => $request->penulis,
        ]);

        return redirect()->route('konten.index')->with('success', 'Konten berhasil diperbarui.');
    } catch (ValidationException $e) {
        return redirect()->back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal memperbarui konten.');
    }
}

    public function destroy(Request $request, Konten $konten)
    {
        try {
            $konten->delete();

            if ($request->ajax()) {
                return response()->json(['message' => 'Konten berhasil dihapus.']);
            }

            return redirect()->route('konten.index')->with('success', 'Konten berhasil dihapus.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Gagal menghapus konten.'], 500);
            }

            return redirect()->back()->with('error', 'Gagal menghapus konten.');
        }
    }
}
