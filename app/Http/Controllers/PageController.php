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
        $konten = Konten::where('jenis', 'komponen')->get()->keyBy('judul');
        $product = Produk::take(4)->get();
        $visiMisi = $konten->get('Visi & Misi');
        $blog = Konten::where('jenis', 'artikel')->get();

        return view('pages.index', compact('product', 'visiMisi', 'blog'));
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
