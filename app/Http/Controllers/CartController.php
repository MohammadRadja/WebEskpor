<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $product = Produk::where('id', $request->product_id)->first();

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $cart = session()->get('cart', []);

        // Jika produk sudah ada di keranjang, tambah qty
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            // Kalau belum ada, tambahkan produk baru ke keranjang
            $cart[$product->id] = [
                "nama" => $product->nama,
                "harga" => $product->harga,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }


    public function update(Request $request)
    {
        if ($request->product_id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->product_id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Cart updated!');
        }
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart');
        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang!');
    }

    public function checkoutForm()
    {
        $cart = session()->get('cart', []);
        $totalHarga = 0;
        $totalJumlah = 0;

        foreach ($cart as $item) {
            $totalHarga += $item['harga'] * $item['quantity'];
            $totalJumlah += $item['quantity'];
        }

        return view('pages.checkout', [
            'cartItems' => $cart,
            'totalHarga' => $totalHarga,
            'totalJumlah' => $totalJumlah
        ]);
    }

    public function checkout(Request $request)
    {
        // Validasi form
        $request->validate([
            'alamat' => 'required|string|max:255',
            'pembayaran' => 'required|string'
        ]);

        // Proses checkout (simulasi)
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Checkout berhasil!');
    }
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('pages.cart', compact('cart'));
    }
}
