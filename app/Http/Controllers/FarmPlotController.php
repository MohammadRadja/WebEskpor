<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use App\Models\FarmPlot;
use Illuminate\Http\Request;

class FarmPlotController extends Controller
{
    public function index($id)
    {
        $farmsPlots = Farm::findOrFail($id);    
        $plots = FarmPlot::where('farm_id', $id)->get();   
        return view('dashboard.farm-manager.farm-plot.index', compact('farmsPlots','plots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'farm_id' => 'required|exists:farms,id',
            'plant_id' => 'required|exists:plants,id',
            'name' => 'required|string',
            'size' => 'required|string',
            'responsible_person' => 'required|string',
            'status' => 'required|string',
            'planting_date' => 'required|date',
            'plant_quantity' => 'required|integer',
            'harvest_quantity' => 'required|integer',
        ]);

        FarmPlot::create([
            'farm_id' => $request->farm_id,
            'plant_id' => $request->plant_id,
            'name' => $request->name,
            'size' => $request->size,
            'responsible_person' => $request->responsible_person,
            'status' => $request->status,
            'planting_date' => $request->planting_date,
            'plant_quantity' => $request->plant_quantity,
            'harvest_quantity' => $request->harvest_quantity,
        ]);

        return redirect()->back()->with('success', 'Petakan berhasil ditambahkan.');
    }

    public function edit(FarmPlot $farmPlot)
    {
        return view('farm-manager.farm-plot.edit', compact('farmPlot'));
    }

    public function update(Request $request, FarmPlot $farmPlot)
    {
        $request->validate([
            'farm_id' => 'required|exists:farms,id',
            'plant_id' => 'required|exists:plants,id',
            'name' => 'required|string',
            'size' => 'required|string',
            'responsible_person' => 'required|string',
            'status' => 'required|string',
            'planting_date' => 'required|date',
            'plant_quantity' => 'required|integer',
            'harvest_quantity' => 'required|integer',
        ]);

        $farmPlot->update([
            'farm_id' => $request->farm_id,
            'plant_id' => $request->plant_id,
            'name' => $request->name,
            'size' => $request->size,
            'responsible_person' => $request->responsible_person,
            'status' => $request->status,
            'planting_date' => $request->planting_date,
            'plant_quantity' => $request->plant_quantity,
            'harvest_quantity' => $request->harvest_quantity,
        ]);

        return redirect()->back()->with('success', 'Petakan berhasil diupdate.');
    }

    public function destroy(FarmPlot $farmPlot)
    {
        $farmPlot->delete();
        return redirect()->back()->with('success', 'Petakan berhasil dihapus.');
    }
}
