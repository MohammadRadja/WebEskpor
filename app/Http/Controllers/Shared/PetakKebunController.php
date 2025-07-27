<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PetakKebun;
use App\Models\Kebun;
use App\Models\Tanaman;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PetakKebunExport;

class PetakKebunController extends Controller
{
    public function index(Request $request)
    {
        try {
            $petakan = PetakKebun::with(['kebun', 'tanaman'])->get();

            $kebunList = Kebun::all()->map(fn($k) => ['value' => $k->id, 'label' => $k->nama])->values();
            $tanamanList = Tanaman::all()->map(fn($t) => ['value' => $t->id, 'label' => $t->nama])->values();

            return view('dashboard.shared.petak-kebun', compact('petakan', 'kebunList', 'tanamanList'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat data petak kebun.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_kebun' => 'required|exists:kebun,id',
                'id_tanaman' => 'required|exists:tanaman,id',
                'nama' => 'required|string',
                'ukuran' => 'required|string',
                'penanggung_jawab' => 'required|string',
                'status' => 'required|in:aktif,non-aktif',
                'tanggal_tanam' => 'required|date',
                'jumlah_panen' => 'nullable|integer',
            ]);

            PetakKebun::create($request->all());

            if ($request->ajax()) {
                return response()->json(['message' => 'Berhasil ditambahkan']);
            }

            return redirect()->route('petak.kebun')->with('success', 'Petakan berhasil ditambahkan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json(['errors' => $e->errors()], 422);
            }

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Terjadi kesalahan server.'], 500);
            }

            return redirect()->back()->with('error', 'Gagal menambahkan petakan.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'id_kebun' => 'required|exists:kebun,id',
                'id_tanaman' => 'required|exists:tanaman,id',
                'nama' => 'required|string',
                'ukuran' => 'required|string',
                'penanggung_jawab' => 'required|string',
                'status' => 'required|in:aktif,non-aktif',
                'tanggal_tanam' => 'required|date',
                'jumlah_panen' => 'nullable|integer',
            ]);

            $petakan = PetakKebun::findOrFail($id);
            $petakan->update($request->all());

            if ($request->ajax()) {
                return response()->json(['message' => 'Berhasil diperbarui']);
            }

            return redirect()->route('petak.kebun')->with('success', 'Petakan berhasil diupdate.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json(['errors' => $e->errors()], 422);
            }

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Terjadi kesalahan server.'], 500);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan server.');
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $petakan = PetakKebun::findOrFail($id);
            $petakan->delete();

            if ($request->ajax()) {
                return response()->json(['message' => 'Berhasil dihapus']);
            }

            return redirect()->route('petak.kebun')->with('success', 'Petakan berhasil dihapus.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Gagal menghapus petakan.'], 500);
            }

            return redirect()->back()->with('error', 'Gagal menghapus petakan.');
        }
    }

    public function exportExcel()
    {
        try {
            return Excel::download(new PetakKebunExport(), 'petak_kebun.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengekspor data ke Excel.');
        }
    }
}
