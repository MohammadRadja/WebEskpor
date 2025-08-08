<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\PetakKebun;
use App\Models\Kebun;
use App\Models\Tanaman;

class PetakKebunController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $petakan = PetakKebun::with(['kebun', 'tanaman'])->get();
        $kebunList = Kebun::all()->map(fn($k) => ['value' => $k->id, 'label' => $k->nama])->values();
        $tanamanList = Tanaman::all()->map(fn($t) => ['value' => $t->id, 'label' => $t->nama])->values();

        return view('dashboard.shared.petak-kebun', compact('petakan', 'kebunList', 'tanamanList'));
    }

    public function store(Request $request)
{
    $this->authorize('create', PetakKebun::class);

    try {
        $request->validate([
            'id_kebun' => 'required|exists:kebun,id',
            'id_tanaman' => 'required|exists:tanaman,id',
            'nama' => 'required|string',
            'ukuran' => 'required|string',
            'penanggung_jawab' => 'required|string',
            'status' => 'required|in:aktif,non-aktif',
            'tanggal_tanam' => 'required|date',
            'tanggal_panen' => 'nullable|date',
            'jumlah_tanaman' => 'nullable|integer',
            'jumlah_panen' => 'nullable|integer',
        ]);

        // CEK STOK BIBIT
        $jumlah = $request->jumlah_tanaman ?? 0;
        $tanaman = Tanaman::findOrFail($request->id_tanaman);

        if ($jumlah > $tanaman->stok_bibit) {
            $pesan = 'Jumlah tanaman melebihi stok bibit yang tersedia.';
            return $request->ajax()
                ? response()->json(['errors' => ['jumlah_tanaman' => [$pesan]]], 422)
                : redirect()->back()->withErrors(['jumlah_tanaman' => $pesan])->withInput();
        }

        PetakKebun::create($request->all());

        return $request->ajax()
            ? response()->json(['message' => 'Petakan berhasil ditambahkan'])
            : redirect()->route('petak.kebun')->with('success', 'Petakan berhasil ditambahkan.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        return $request->ajax()
            ? response()->json(['errors' => $e->errors()], 422)
            : redirect()->back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        return $request->ajax()
            ? response()->json(['error' => 'Terjadi kesalahan server.'], 500)
            : redirect()->back()->with('error', 'Gagal menambahkan petakan.');
    }
}


    public function update(Request $request, $id)
{
    $petakan = PetakKebun::findOrFail($id);
    $this->authorize('update', $petakan);

    try {
        $request->validate([
            'id_kebun' => 'required|exists:kebun,id',
            'id_tanaman' => 'required|exists:tanaman,id',
            'nama' => 'required|string',
            'ukuran' => 'required|string',
            'penanggung_jawab' => 'required|string',
            'status' => 'required|in:aktif,non-aktif',
            'tanggal_tanam' => 'required|date',
            'tanggal_panen' => 'nullable|date',
            'jumlah_tanaman' => 'nullable|integer',
            'jumlah_panen' => 'nullable|integer',
        ]);

        $jumlahBaru = $request->jumlah_tanaman ?? 0;
        $jumlahLama = $petakan->jumlah_tanaman ?? 0;
        $selisih = $jumlahBaru - $jumlahLama;

        $tanaman = Tanaman::findOrFail($request->id_tanaman);

        if ($selisih > 0 && $selisih > $tanaman->stok_bibit) {
            $pesan = 'Penambahan jumlah tanaman melebihi stok bibit yang tersedia.';
            return $request->ajax()
                ? response()->json(['errors' => ['jumlah_tanaman' => [$pesan]]], 422)
                : redirect()->back()->withErrors(['jumlah_tanaman' => $pesan])->withInput();
        }

        $petakan->update($request->all());

        return $request->ajax()
            ? response()->json(['message' => 'Petakan berhasil diperbarui'])
            : redirect()->route('petak.kebun')->with('success', 'Petakan berhasil diperbarui.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        return $request->ajax()
            ? response()->json(['errors' => $e->errors()], 422)
            : redirect()->back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        return $request->ajax()
            ? response()->json(['error' => 'Terjadi kesalahan server.'], 500)
            : redirect()->back()->with('error', 'Gagal memperbarui petakan.');
    }
}


    public function destroy(Request $request, $id)
    {
        $petakan = PetakKebun::findOrFail($id);
        $this->authorize('delete', $petakan);

        try {
            $petakan->delete();

            if ($request->ajax()) {
                return response()->json(['message' => 'Petakan berhasil dihapus']);
            }

            return redirect()->route('petak.kebun')->with('success', 'Petakan berhasil dihapus.');
        } catch (\Exception $e) {
            return $request->ajax()
                ? response()->json(['error' => 'Terjadi kesalahan saat menghapus.'], 500)
                : redirect()->back()->with('error', 'Gagal menghapus petakan.');
        }
    }
}
