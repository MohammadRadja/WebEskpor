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

        // Ambil carousel
        $carousel = $konten->get('Carousel');

        $meta = json_decode($carousel->meta ?? '[]', true);
        $media = json_decode($carousel->media ?? '[]', true);

        $carouselItems = [];
        foreach ($meta as $i => $item) {
            $item['media'] = $media[$i] ?? null;
            $carouselItems[] = $item;
        }

        // Ambil SERVICES
        $services = $konten->get('SERVICES');
        $metaService = json_decode($services->meta ?? '[]', true);
        $mediaService = json_decode($services->media ?? '[]', true);

        $serviceItems = [];
        foreach ($metaService as $i => $item) {
            $item['media'] = $mediaService[$i] ?? null;
            $serviceItems[] = $item;
        }

        // Ambil HASIL PERKEBUNAN
        $hasilPerkebunan = $konten->get('Hasil Perkebunan');
        $metaPerkebunan = json_decode($hasilPerkebunan->meta ?? '[]', true);
        $mediaPerkebunan = json_decode($hasilPerkebunan->media ?? '[]', true);

        $perkebunanItems = [];
        foreach ($metaPerkebunan as $i => $item) {
            $item['media'] = $mediaPerkebunan[$i] ?? null;
            $perkebunanItems[] = $item;
        }
        return view('pages.index', [
            'serviceItems' => $serviceItems,
            'carouselItems' => $carouselItems,
            'service' => $konten->get('SERVICES'),
            'perkebunanItems' => $perkebunanItems,
            'perkebunan' => $hasilPerkebunan,
        ]);
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
