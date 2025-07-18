<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use Illuminate\Http\Request;

class FarmController extends Controller
{
    public function index()
    {
        $farms = Farm::all();
        return view('farm-manager.farms.index', compact('farms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'location' => 'required|string',
        ]);

        Farm::create($validated);

        return redirect()->back()->with('success', 'Farm berhasil ditambahkan.');
    }

    public function edit(Farm $farm)
    {
        return view('farms.edit', compact('farm'));
    }

    public function update(Request $request, Farm $farm)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'location' => 'required|string',
        ]);

        $farm->update($validated);

        return redirect()->back()->with('success', 'Farm berhasil diupdate.');
    }

    public function destroy(Farm $farm)
    {
        $farm->delete();

        return redirect()->back()->with('success', 'Farm berhasil dihapus.');
    }
}
