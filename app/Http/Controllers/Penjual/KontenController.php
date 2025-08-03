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
                'id_penulis' => 'required|exists:users,id',
            ]);

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
                'gambar' => $request->gambar,
                'tautan' => $request->tautan,
                'meta' => $request->meta,
                'media' => $request->media,
                'status' => $request->status ?? 'draf',
                'diterbitkan_pada' => Carbon::now(),
                'id_penulis' => $penulis->id,
            ]);

            if ($request->ajax()) {
                return response()->json(['message' => 'Konten berhasil ditambahkan.']);
            }

            return redirect()->route('konten.index')->with('success', 'Konten berhasil ditambahkan.');
        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return response()->json(['errors' => $e->errors()], 422);
            }

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(
                    [
                        'error' => 'Terjadi kesalahan saat menambahkan konten.',
                        'message' => $e->getMessage(),
                    ],
                    500,
                );
            }

            return redirect()->back()->with('error', 'Gagal menambahkan konten.');
        }
    }

    public function update(Request $request, Konten $konten)
    {
        \Log::info('Data sebelum update:', $konten->toArray());

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
                'id_penulis' => 'required|exists:users,id',
            ]);

            $penulis = User::whereIn('role', ['administrator', 'penjual'])->first();

            if (!$penulis) {
                throw new \Exception('Penulis dengan role administrator atau penjual tidak ditemukan.');
            }

            \Log::info('Data sesudah update:', $validated);

            $konten->update([
                'judul' => $validated['judul'],
                'slug' => Str::slug($validated['judul']),
                'jenis' => $validated['jenis'],
                'kutipan' => $request->kutipan,
                'konten' => $validated['konten'],
                'gambar' => $request->gambar,
                'tautan' => $request->tautan,
                'status' => $request->status ?? 'draf',
                'diterbitkan_pada' => Carbon::now(),
                'id_penulis' => $penulis->id,
            ]);

            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $namaFile = time() . '_' . $file->getClientOriginalName();
                $path = public_path('uploads/konten');

                // Pastikan direktori ada
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }

                $file->move($path, $namaFile);

                $validated['gambar'] = 'uploads/konten/' . $namaFile;
            }

            if ($request->ajax()) {
                return response()->json(['message' => 'Konten berhasil diperbarui.']);
            }

            return redirect()->route('konten.index')->with('success', 'Konten berhasil diperbarui.');
        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return response()->json(['errors' => $e->errors()], 422);
            }

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(
                    [
                        'error' => 'Terjadi kesalahan saat memperbarui konten.',
                        'message' => $e->getMessage(),
                    ],
                    500,
                );
            }

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
