<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Services\DatabaseNotify;

class TransaksiController extends Controller
{
    public function __construct(protected DatabaseNotify $notify) {}

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
                'status' => 'required|in:menunggu,proses,diterima,ditolak',
                'id_pelanggan' => 'required|exists:users,id',
                'checkout_items' => 'required',
                'checkout_items.*' => 'required'
            ]);

            if ($request->hasFile('bukti_pembayaran') && $request->file('bukti_pembayaran')->isValid()) {
                $file = $request->file('bukti_pembayaran');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/bukti_pembayaran'), $filename);
                $validated['bukti_pembayaran'] = 'uploads/bukti_pembayaran/' . $filename;
            }

            $transaksi = Transaksi::create($validated);

            $selectedItems = CartItem::with('produk')
                ->whereIn('id', $validated['checkout_items'])
                ->get();

            foreach ($selectedItems as $item) {
                $subtotal = $item->produk->harga * $item->quantity;

                $transaksi->detailTransaksi()->create([
                    'id_produk' => $item->produk_id,
                    'jumlah' => $item->quantity,
                    'harga_satuan' => $item->produk->harga,
                    'sub_total' => $subtotal,
                ]);

                $item->delete();
            }

            $this->notify->success(
                'Transaksi berhasil dibuat dan sedang menunggu verifikasi pembayaran.',
                'Sukses',
                $transaksi->id
            );
            return redirect()->route('message.index');

        } catch (\Exception $e) {
            $this->notify->withPopup()->error('Gagal menambahkan transaksi: '.$e->getMessage(), 'Error');
            return back()->withInput();
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

    public function approve($id)
    {
        try {
            $transaksi = Transaksi::findOrFail($id);
            $transaksi->status = 'diterima';
            $transaksi->save();

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil di-approve.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal meng-approve transaksi.');
        }
    }

    public function reject($id)
    {
        try {
            $transaksi = Transaksi::findOrFail($id);
            $transaksi->status = 'ditolak';
            $transaksi->save();

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditolak.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menolak transaksi.');
        }
    }
}
