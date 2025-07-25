<?php

namespace App\Http\Controllers;

use App\Models\Konten;
use App\Models\Produk;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }

    public function about()
    {
        return view('pages.about');
    }
    public function contact()
    {
        return view('pages.contact');
    }
    public function product()
    {
        $product = Produk::all();
        return view('pages.product', compact('product'));
    }
    public function blog()
    {
        $blog = Konten::where('jenis', 'artikel')->get();
        return view('pages.blog', compact('blog'));
    }
    public function cart()
    {
        return view('pages.cart');
    }
    public function message()
    {
        return view('pages.messages');
    }
}
