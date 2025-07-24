<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class TransaksiController extends Controller
{
    public function index()
    {
        try {
            $transaksi = Transaksi::with(['pelanggan', 'detailTransaksi.produk'])->get();
            $pelangganList = User::where('role', 'pelanggan')
                ->get()
                ->map(function ($user) {
                    return [
                        'value' => $user->id,
                        'label' => $user->username,
                    ];
                })
                ->values();

            return view('dashboard.shared.transaksi', compact('transaksi', 'pelangganList'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat data transaksi.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'telepon' => 'required|string',
                'alamat' => 'required|string',
                'negara' => 'required|string',
                'biaya_pengiriman' => 'required|numeric|min:0',
                'jumlah' => 'required|integer|min:1',
                'total_harga' => 'required|numeric|min:0',
                'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'status' => 'required|in:menunggu,dibayar,dikirim,selesai',
                'id_pelanggan' => 'required|exists:users,id',
            ]);

            if ($request->hasFile('bukti_pembayaran') && $request->file('bukti_pembayaran')->isValid()) {
    $file = $request->file('bukti_pembayaran');
    $filename = uniqid() . '.' . $file->getClientOriginalExtension();
    $file->move(public_path('uploads/bukti_pembayaran'), $filename);
    $validated['bukti_pembayaran'] = 'uploads/bukti_pembayaran/' . $filename;
}

            Transaksi::create($validated);

            if ($request->ajax()) {
                return response()->json(['message' => 'Berhasil ditambahkan']);
            }

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan.');
        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return response()->json(['errors' => $e->errors()], 422);
            }

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Terjadi kesalahan saat menambahkan transaksi.'], 500);
            }

            return redirect()->back()->with('error', 'Gagal menambahkan transaksi.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'telepon' => 'required|string',
                'alamat' => 'required|string',
                'negara' => 'required|string',
                'biaya_pengiriman' => 'required|numeric|min:0',
                'jumlah' => 'required|integer|min:1',
                'total_harga' => 'required|numeric|min:0',
                'bukti_pembayaran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'status' => 'required|in:menunggu,dibayar,dikirim,selesai',
                'id_pelanggan' => 'required|exists:users,id',
            ]);

            $transaksi = Transaksi::findOrFail($id);

            if ($request->hasFile('bukti_pembayaran') && $request->file('bukti_pembayaran')->isValid()) {
    $file = $request->file('bukti_pembayaran');
    $filename = uniqid() . '.' . $file->getClientOriginalExtension();
    $file->move(public_path('uploads/bukti_pembayaran'), $filename);
    $validated['bukti_pembayaran'] = 'uploads/bukti_pembayaran/' . $filename;
}

            $transaksi->update($validated);

            if ($request->ajax()) {
                return response()->json(['message' => 'Berhasil diperbarui']);
            }

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return response()->json(['errors' => $e->errors()], 422);
            }

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Terjadi kesalahan saat memperbarui transaksi.'], 500);
            }

            return redirect()->back()->with('error', 'Gagal memperbarui transaksi.');
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $transaksi = Transaksi::findOrFail($id);
            $transaksi->delete();

            if ($request->ajax()) {
                return response()->json(['message' => 'Berhasil dihapus']);
            }

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Gagal menghapus transaksi.'], 500);
            }

            return redirect()->back()->with('error', 'Gagal menghapus transaksi.');
        }
    }
}
