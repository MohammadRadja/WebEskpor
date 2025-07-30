<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Services\DatabaseNotify;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;

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
                'biaya_pengiriman' => 'nullable|numeric|min:0',
                'jumlah' => 'required|integer|min:1',
                'total_harga' => 'required|numeric|min:0',
                'jenis_pengiriman' => 'required|in:ditanggung_pembeli,ditanggung_penjual,ditanggung_bersama',
                'no_resi' => 'nullable|string',
                'status' => 'required|in:menunggu,proses,diterima,ditolak',
                'id_pelanggan' => 'required|exists:users,id',
                'checkout_items' => 'nullable|array',
                'checkout_items.*' => 'nullable',
                'buy_now' => 'nullable|boolean',
                'produk_id' => 'nullable|exists:produk,id',
            ]);

            $transaksi = Transaksi::create($validated);

            // Jika berasal dari keranjang
            if (empty($validated['buy_now'])) {
                $selectedItems = CartItem::with('produk')->whereIn('id', $validated['checkout_items'])->get();

                foreach ($selectedItems as $item) {
                    $subtotal = $item->produk->harga * $item->quantity;
                    $subquantity = 500 * $item->quantity;

                    $transaksi->detailTransaksi()->create([
                        'id_produk' => $item->produk_id,
                        'jumlah' => $item->quantity,
                        'harga_satuan' => $item->produk->harga,
                        'sub_total' => $subtotal,
                    ]);

                    // Kurangi stok
                    $item->produk->stok -= $subquantity;
                    $item->produk->save();

                    // Hapus dari keranjang
                    $item->delete();
                }
            } else {
                Log::info('Store Transaksi - Buy Now:', $request->all());
                // Jika Buy Now → buat detail dari produk langsung
                $produk = Produk::findOrFail($request->produk_id);
                $subtotal = $produk->harga * $validated['jumlah'];
                $subquantity = 500 * $validated['jumlah'];

                $transaksi->detailTransaksi()->create([
                    'id_produk' => $produk->id,
                    'jumlah' => $validated['jumlah'],
                    'harga_satuan' => $produk->harga,
                    'sub_total' => $subtotal,
                ]);

                // Kurangi stok
                $produk->stok -= $subquantity;
                $produk->save();
            }

            $this->notify->success('Transaksi berhasil dibuat dan sedang menunggu verifikasi pembayaran.', 'Sukses', $transaksi->id);
            return redirect()->route('message.index');
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan transaksi: ' . $e->getMessage());
            $this->notify->error('Gagal menambahkan transaksi: ' . $e->getMessage(), 'Error');
            return back()->withInput();
        }
    }

    public function checkoutXendit(Request $request)
    {
        try {
            // Ambil transaksi berdasarkan ID yang dikirim dari tombol "Bayar Sekarang"
            $transaksi = Transaksi::findOrFail($request->id_transaksi);

            // Update status menjadi proses jika belum
            if ($transaksi->status !== 'proses') {
                $transaksi->update(['status' => 'proses']);
            }

            // Jika sudah ada payment_url, langsung redirect
            if ($transaksi->payment_url) {
                return redirect($transaksi->payment_url);
            }

            Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));
            $apiInstance = new InvoiceApi();

            $params = [
                'external_id' => 'order-' . $transaksi->id,
                'payer_email' => $transaksi->pelanggan->email,
                'description' => 'Pembayaran pesanan #' . $transaksi->id,
                'amount' => $transaksi->total_harga,
                'success_redirect_url' => url('/checkout/success'),
                'failure_redirect_url' => url('/checkout/failed'),
            ];

            $invoice = $apiInstance->createInvoice($params);

            // Simpan payment_url ke database
            $transaksi->update(['payment_url' => $invoice['invoice_url']]);

            return redirect($invoice['invoice_url']);
        } catch (\Exception $e) {
            Log::error('Gagal memproses pembayaran: ' . $e->getMessage());
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function handleCallback(Request $request)
    {
        Log::info('Xendit Callback:', $request->all());

        $data = $request->all();
        $orderId = str_replace('order-', '', $data['external_id']);
        $transaksi = Transaksi::find($orderId);

        if (!$transaksi) {
            return response()->json(['error' => 'Transaksi tidak ditemukan'], 404);
        }

        // Mapping status dari Xendit ke status lokal sesuai enum
        $statusMap = [
            'PAID' => 'dibayar',
            'SETTLED' => 'dibayar',
            'EXPIRED' => 'expired',
            'FAILED' => 'gagal',
            'VOIDED' => 'gagal',
        ];

        // Update status jika cocok
        if (isset($statusMap[$data['status']])) {
            $transaksi->status = $statusMap[$data['status']];
            $transaksi->save();
        }

        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'biaya_pengiriman' => 'nullable|numeric|min:0',
                'no_resi' => 'nullable|string',
            ]);

            $transaksi = Transaksi::findOrFail($id);

            // Jika kedua field diisi, ubah status menjadi proses
            if (!empty($validated['biaya_pengiriman']) && !empty($validated['no_resi'])) {
                $validated['status'] = 'proses';
            }

            $transaksi->update($validated);

            // Jika transaksi sudah memiliki payment_url, redirect ke payment
            if ($transaksi->payment_url && ($validated['status'] ?? null) === 'proses') {
                return redirect($transaksi->payment_url);
            }

            return redirect()->route('transaksi.index')->with('success', 'Biaya pengiriman & No Resi berhasil diperbarui.');
        } catch (ValidationException $e) {
            Log::error('Gagal memperbarui transaksi: ' . $e->getMessage());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui transaksi: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui transaksi: ' . $e->getMessage());
        }
    }
}
