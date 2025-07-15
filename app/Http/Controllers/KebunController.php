<?php

namespace App\Http\Controllers;

use App\Models\Kebun;
use App\Models\PetakanKebun;
use Illuminate\Http\Request;
use Laravel\Prompts\Key;

class KebunController extends Controller
{
    // Tampilkan halaman kebun beserta petakan
    public function show()
    {
        $kebun = Kebun::all();
        return view('kepalakebun.kebun.show', compact('kebun'));
    }

    public function storeKebun(Request $request){
        $request->validate([
            'nama' => 'required',
            'lokasi' => 'required',
        ]);

        Kebun::create([
            'nama' => $request->nama,
            'lokasi' => $request->lokasi,
        ]);

        return back()->with('success', 'Data kebun berhasil diperbarui.');
    }

    public function showPetakan($id)
    {
        $kebun = Kebun::with('petakan')->findOrFail($id);

        return view('kepalakebun.kebun.petakan', compact('kebun'));
    }
    // Update data kebun
    public function updateKebun(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'lokasi' => 'required',
        ]);

        $kebun = Kebun::findOrFail($id);
        $kebun->update([
            'nama' => $request->nama,
            'lokasi' => $request->lokasi,
        ]);

        return back()->with('success', 'Data kebun berhasil diperbarui.');
    }
    public function destroyKebun($id)
    {
        $petakan = Kebun::findOrFail($id);
        $petakan->delete();

        return back()->with('success', 'Petakan berhasil dihapus.');
    }
    // Tambah petakan baru ke kebun tertentu
    public function storePetakan(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'ukuran' => 'required',
            'penanggung_jawab' => 'required',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        PetakanKebun::create([
            'nama' => $request->nama,
            'ukuran' => $request->ukuran,
            'penanggung_jawab' => $request->penanggung_jawab,
            'status' => $request->status,
            'kebun_id' => $id,
        ]);

        return back()->with('success', 'Petakan berhasil ditambahkan.');
    }

    // Hapus petakan
    public function destroyPetakan($id)
    {
        $petakan = PetakanKebun::findOrFail($id);
        $petakan->delete();

        return back()->with('success', 'Petakan berhasil dihapus.');
    }
}
