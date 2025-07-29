<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cart = $user->cart; // dapatkan cart milik user

        if (!$cart) {
            return view('pages.partials.cart', ['cartItems' => collect()]); // jika cart kosong
        }

        $cartItems = $cart->items()->with('produk')->get();
        return view('pages.partials.cart', compact('cartItems'));
    }

    public function add(Request $request)
    {
        $user = auth()->user();
        $produk = Produk::findOrFail($request->product_id);

        // Ambil atau buat cart
        $cart = $user->cart()->firstOrCreate([]);

        // Cek apakah produk sudah ada di cart
        $item = $cart->items()->where('produk_id', $produk->id)->first();

        if ($item) {
            $item->increment('quantity');
        } else {
            $cart->items()->create([
                'produk_id' => $produk->id,
                'quantity' => 1,
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function updateQuantity(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|',
            'quantity' => 'required|min:1',
        ]);

        $cartItem = CartItem::findOrFail($validated['item_id']);
        $cartItem->quantity = $validated['quantity'];
        $cartItem->save();

        return response()->json([
            'message' => 'Item updated successfully',
            'item_id' => $cartItem->id,
            'new_quantity' => $cartItem->quantity,
        ]);
    }

    public function remove(Request $request)
    {
        $user = auth()->user();
        $cart = $user->cart;

        if ($cart) {
            $cart->items()->where('produk_id', $request->product_id)->delete();
        }

        return back()->with('success', 'Produk dihapus dari keranjang!');
    }

    public function checkoutForm(Request $request)
    {
        try {
            $userId = auth()->id();
            $cart = Cart::where('user_id', $userId)->first();

            if (!$cart) {
                return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
            }

            $itemIds = array_filter(explode(',', $request->query('items', '')));
            if (empty($itemIds)) {
                return redirect()->route('cart.index')->with('error', 'Tidak ada item yang dipilih untuk checkout.');
            }

            $cartItems = CartItem::with('produk')->where('cart_id', $cart->id)->whereIn('id', $itemIds)->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Item yang dipilih tidak ditemukan.');
            }

            // Total Harga dan Jumlah Item
            $totalHarga = $cartItems->sum(fn($item) => $item->produk->harga * $item->quantity);
            $totalJumlah = $cartItems->sum('quantity');

            // Total Berat
            $totalBerat = $cartItems->sum(fn($item) => 500 * $item->quantity);
            return view('pages.partials.checkout', compact('cartItems', 'totalHarga', 'totalBerat', 'totalJumlah'));
        } catch (Exception $e) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Gagal memuat halaman checkout: ' . $e->getMessage());
        }
    }

    public function buyNow(Request $request)
    {
        try {
            $user = Auth::user();
            $produk = Produk::findOrFail($request->product_id);

            // Buat data sementara untuk checkout (tidak disimpan di database)
            $cartItems = collect([
                (object) [
                    'id' => 0, // karena bukan dari cart
                    'produk' => $produk,
                    'quantity' => 1,
                ],
            ]);

            // Total Harga dan Jumlah Item
            $totalHarga = $produk->harga;
            $totalJumlah = 1;

            // Total Berat
            $totalBerat = 500;

            // Kirim data langsung ke view checkout tanpa menggunakan cart
            return view('pages.partials.checkout', compact('cartItems', 'totalHarga', 'totalBerat', 'totalJumlah'))->with('success', 'Lanjutkan ke checkout.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal memproses pembelian: ' . $e->getMessage());
        }
    }
}
