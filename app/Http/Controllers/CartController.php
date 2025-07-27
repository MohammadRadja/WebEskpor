<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $cart = $user->cart; // dapatkan cart milik user

        if (!$cart) {
            return view('pages.cart', ['cartItems' => collect()]); // kosong
        }

        $cartItems = $cart->items()->with('produk')->get();
        $cartid = $cart->items()->with('produk')->first();
        return view('pages.cart', compact('cartItems'));
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
            'item_id' => 'required',
            'quantity' => 'required'
        ]);

        $cartItem = CartItem::findOrFail($validated['item_id']);
        $cartItem->quantity = $validated['quantity'];
        $cartItem->save();

        return response()->json([
            'message' => 'Item updated successfully',
            'item_id' => $cartItem->id,
            'new_quantity' => $cartItem->quantity
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
        $userId = auth()->id();
        $cart = Cart::where('user_id', $userId)->first();

        $itemIds = explode(',', $request->query('items', '')); // dari query string
        $cartItems = CartItem::with('produk')
            ->where('cart_id', $cart->id)
            ->whereIn('id', $itemIds)
            ->get();

        $totalHarga = $cartItems->sum(fn($item) => $item->produk->harga * $item->quantity);
        $totalJumlah = $cartItems->sum('quantity');

        return view('pages.checkout', [
            'cartItems' => $cartItems,
            'totalHarga' => $totalHarga,
            'totalJumlah' => $totalJumlah,
        ]);
    }

    
}
