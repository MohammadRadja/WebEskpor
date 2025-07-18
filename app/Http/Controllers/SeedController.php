<?php

namespace App\Http\Controllers;

use App\Models\Seed;
use Illuminate\Http\Request;

class SeedController extends Controller
{
    public function index()
    {
        $data = Bibit::all();
        return view('kepalakebun.bibit.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_beli' => 'required|date',
            'nama_penjual' => 'required|string|max:255',
            'harga_satuan' => 'required|numeric',
            'qty' => 'required|integer',
        ]);

        $validated['total_harga'] = $validated['harga_satuan'] * $validated['qty'];

        Bibit::create($validated);

        return redirect()->back()->with('success', 'Bibit berhasil ditambahkan');
    }
}
