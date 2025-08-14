<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Tanaman;
use App\Models\Bibit;

class BibitController extends Controller
{
    use AuthorizesRequests; // Wajib ditambahkan untuk authorize()

    public function index()
    {
        $bibit = Bibit::latest()->orderBy('created_at', 'desc')->paginate(10);
        $tanamanList = Tanaman::all()
            ->map(
                fn($p) => [
                    'value' => $p->id,
                    'label' => $p->nama,
                ],
            )
            ->values();
        return view('dashboard.shared.bibit', compact('bibit', 'tanamanList'));
    }

   public function store(Request $request)
{
    $this->authorize('create', Bibit::class);

    // Hilangkan titik ribuan sebelum validasi
    $request->merge([
        'harga_satuan' => str_replace('.', '', $request->harga_satuan)
    ]);

    $request->validate([
        'id_tanaman' => 'required|exists:tanaman,id',
        'nama' => 'required|string',
        'tanggal_pembelian' => 'required|date',
        'nama_penjual' => 'required|string',
        'harga_satuan' => 'required|numeric',
        'jumlah' => 'required|integer',
    ]);

    Bibit::create($request->all());

    return redirect()->route('bibit.index')->with('success', 'Data bibit berhasil ditambahkan.');
}

public function update(Request $request, $id)
{
    $bibit = Bibit::findOrFail($id);
    $this->authorize('update', $bibit);

    // Hilangkan titik ribuan sebelum validasi
    $request->merge([
        'harga_satuan' => str_replace('.', '', $request->harga_satuan)
    ]);

    $request->validate([
        'id_tanaman' => 'required|exists:tanaman,id',
        'nama' => 'required|string',
        'tanggal_pembelian' => 'required|date',
        'nama_penjual' => 'required|string',
        'harga_satuan' => 'required|numeric',
        'jumlah' => 'required|integer',
    ]);

    $bibit->update($request->all());

    return redirect()->route('bibit.index')->with('success', 'Data bibit berhasil diperbarui.');
}


    public function destroy($id)
    {
        $bibit = Bibit::findOrFail($id);
        $this->authorize('delete', $bibit); // Cek hak akses

        $bibit->delete();

        return redirect()->route('bibit.index')->with('success', 'Data bibit berhasil dihapus.');
    }
}
