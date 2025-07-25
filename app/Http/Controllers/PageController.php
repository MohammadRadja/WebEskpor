<?php

namespace App\Http\Controllers;

use App\Models\Konten;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }

    public function about()
    {
        $konten = Konten::where('jenis', 'komponen')->get()->keyBy('judul');
        log::info('Konten Komponen:', $konten->toArray());

        return view('pages.about', [
            'profil' => $konten->get('Profil Perusahaan'),
            'layanan' => $konten->get('Layanan Kami'),
            'visiMisi' => $konten->get('Visi & Misi'),
        ]);
    }

    public function contact()
    {
        $contact = Konten::where('slug', 'kontak')->first();
        return view('pages.contact', compact('contact'));
    }
    public function product()
    {
        $product = Produk::all();
        return view('pages.product', compact('product'));
    }
    public function blog()
    {
        $blog = Konten::where('slug', 'berita')->get();
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
