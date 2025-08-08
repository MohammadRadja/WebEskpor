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
use App\Models\Notifications;

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

    // Redirect Sukses Xendit
    public function checkoutSuccess(Request $request)
    {
        $transaksi = Transaksi::find($request->trx);
        Log::info($transaksi);

        if (!$transaksi) {
            return redirect('/')->with('error', 'Transaksi tidak ditemukan.');
        }

        // Fallback status menjadi dibayar
        if ($transaksi->status == 'proses') {
            $transaksi->update(['status' => 'dibayar']);
        }

        // Notifikasi By Jenis Pengiriman
        if (in_array($transaksi->jenis_pengiriman, ['ditanggung_penjual', 'ditanggung_bersama'])) {
            $message = 'Pembayaran untuk transaksi #' . $transaksi->id . ' berhasil. Harap tunggu nomor resi dari admin.';
        } else {
            // Notifikasi ditanggung_pembeli
            $message = 'Pembayaran untuk transaksi #' . $transaksi->id . ' berhasil. Pesanan Anda sedang diproses dan segera dikirim.';
        }

        // Update Notifikasi
        $notify = Notifications::where('id_transaksi', $transaksi->id)->latest()->first();
        if ($notify) {
            $notify->update([
                'type' => 'success',
                'title' => 'Pembayaran Berhasil',
                'message' => $message,
            ]);
        }

        return view('pages.partials.checkout.checkout-success', compact('transaksi'));
    }

    // Redirect Gagal Xendit
    public function checkoutFailed(Request $request)
    {
        $transaksi = Transaksi::find($request->trx);
        Log::info($transaksi);

        if (!$transaksi) {
            return redirect('/')->with('error', 'Transaksi tidak ditemukan.');
        }

        // Fallback status menjadi gagal
        if ($transaksi->status === 'proses') {
            $transaksi->update(['status' => 'gagal']);
        }

        // Update Notifikasi
        $notify = Notifications::where('id_transaksi', $transaksi->id)->latest()->first();
        if ($notify) {
            $notify->update([
                'type' => 'error',
                'title' => 'Pembayaran Gagal',
                'message' => 'Pembayaran untuk transaksi #' . $transaksi->id . ' gagal. Silakan coba lagi.',
            ]);
        }

        return view('pages.partials.checkout.checkout-failed', compact('transaksi'));
    }

    // Store/Create Transaksi
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'telepon' => 'required|string',
                'alamat' => 'required|string',
                'negara' => 'required|string',
                'ekspedisi' => 'nullable|string',
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

            // Notifikasi berdasarkan jenis pengiriman
            if ($validated['jenis_pengiriman'] === 'ditanggung_pembeli') {
                $transaksi->update(['status' => 'proses']);
                $this->notify->success('Transaksi berhasil dibuat. Silakan segera melakukan pembayaran karena biaya pengiriman ditanggung pembeli.', 'Pembayaran Segera', $transaksi->id);
            } else {
                $this->notify->success('Transaksi berhasil dibuat. Silakan menunggu, admin akan menginput detail ekspedisi dan biaya pengiriman sebelum Anda melakukan pembayaran.', 'Menunggu Konfirmasi', $transaksi->id);
            }

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
$subquantity = 500 * $validated['jumlah']; // jumlah dalam satuan kecil (misal gram)

// ✅ Cek apakah stok mencukupi sebelum buat transaksi
if ($produk->stok < $subquantity) {
    $this->notify->error('Stok produk tidak mencukupi. Minimal pembelian adalah 500 satuan dan stok harus cukup.', 'Stok Tidak Cukup');

    // Redirect ke halaman produk, atau sesuaikan
    return redirect('/product')->with('stok_kurang', 'Stok produk tidak mencukupi. Silakan kurangi jumlah pembelian.');
}

// ✅ Buat detail transaksi
$transaksi->detailTransaksi()->create([
    'id_produk' => $produk->id,
    'jumlah' => $validated['jumlah'],
    'harga_satuan' => $produk->harga,
    'sub_total' => $subtotal,
]);

// ✅ Kurangi stok
$produk->stok -= $subquantity;
$produk->save();

            }

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
                'success_redirect_url' => url('/checkout/success?trx=' . $transaksi->id),
                'failure_redirect_url' => url('/checkout/failed?trx=' . $transaksi->id),
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

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'ekspedisi' => 'nullable|string',
                'biaya_pengiriman' => 'nullable|numeric|min:0',
                'no_resi' => 'nullable|string',
            ]);

            $transaksi = Transaksi::findOrFail($id);

            // Jika biaya_pengiriman diisi, tambahkan ke total_harga
            if (isset($validated['biaya_pengiriman'])) {
                // Jika biaya_pengiriman lama ada, kurangi dulu untuk menghindari double counting
                $total_harga_sebelumnya = $transaksi->total_harga - ($transaksi->biaya_pengiriman ?? 0);
                $validated['total_harga'] = $total_harga_sebelumnya + $validated['biaya_pengiriman'];
            }

            $notifikasiPengiriman = false;
            $notifikasiSelesai = false;

            // Jika no_resi diisi
            if (!empty($validated['no_resi'])) {
                $validated['status'] = 'selesai';
                $notifikasiSelesai = true;
            }

            // Jika kedua field diisi, ubah status menjadi proses
            if (!empty($validated['biaya_pengiriman']) && !empty($validated['ekspedisi'])) {
                $validated['status'] = 'proses';
                $notifikasiPengiriman = true;
            }

            $transaksi->update($validated);

            $notify = Notifications::where('id_transaksi', $transaksi->id)->latest()->first();

            if ($notifikasiSelesai) {
                if ($notify) {
                    $notify->update([
                        'type' => 'success',
                        'title' => 'Pesanan Selesai',
                        'message' => 'Pesanan Anda dengan transaksi #' . $transaksi->id . ' telah selesai dan sedang dalam perjalanan dengan nomor resi ' . $validated['no_resi'] . '.',
                    ]);
                }
            } elseif ($notifikasiPengiriman) {
                if ($notify) {
                    $notify->update([
                        'type' => 'info',
                        'title' => 'Pengiriman Diproses',
                        'message' => 'Biaya pengiriman dan ekspedisi untuk transaksi #' . $transaksi->id . ' telah ditentukan oleh admin. Silakan melanjutkan pembayaran agar pesanan Anda dapat segera diproses.',
                    ]);
                }
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
