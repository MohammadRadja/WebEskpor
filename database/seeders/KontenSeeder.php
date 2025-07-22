<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Konten;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class KontenSeeder extends Seeder
{
    public function run(): void
    {
        $penulis = User::where('role', 'administrator')->first();

        if (!$penulis) {
            $this->command->error('Gagal menjalankan KontenSeeder: tidak ditemukan user dengan role administrator.');
            return;
        }

        // 1. Beranda
        Konten::create([
            'judul' => 'Beranda',
            'slug' => Str::slug('Beranda'),
            'jenis' => 'halaman',
            'kutipan' => 'Selamat datang di situs resmi kami.',
            'konten' => 'Ini adalah halaman utama dari situs pertanian organik.',
            'gambar' => 'beranda.jpg',
            'tautan' => '/',
            'status' => 'terbit',
            'diterbitkan_pada' => Carbon::now(),
            'id_penulis' => $penulis->id,
        ]);

        // 2. Tentang Kami
        Konten::create([
            'judul' => 'Tentang Kami',
            'slug' => Str::slug('Tentang Kami'),
            'jenis' => 'halaman',
            'kutipan' => 'Pelopor pertanian berkelanjutan sejak 2005.',
            'konten' => 'Kami adalah komunitas petani yang berfokus pada pertanian ramah lingkungan dan berkelanjutan.',
            'gambar' => 'tentang-kami.jpg',
            'tautan' => '/tentang-kami',
            'status' => 'terbit',
            'diterbitkan_pada' => Carbon::now(),
            'id_penulis' => $penulis->id,
        ]);

        // 3. Produk
        Konten::create([
            'judul' => 'Produk',
            'slug' => Str::slug('Produk'),
            'jenis' => 'halaman',
            'kutipan' => 'Lihat produk unggulan kami.',
            'konten' => 'Kami menyediakan berbagai macam sayur dan buah organik dari kebun terbaik.',
            'gambar' => 'produk.jpg',
            'tautan' => '/produk',
            'status' => 'terbit',
            'diterbitkan_pada' => Carbon::now(),
            'id_penulis' => $penulis->id,
        ]);

        // 4. Berita
        Konten::create([
            'judul' => 'Berita',
            'slug' => Str::slug('Berita'),
            'jenis' => 'artikel',
            'kutipan' => 'Informasi dan berita terbaru dari kebun kami.',
            'konten' => 'Temukan kabar terbaru tentang pertanian organik, kegiatan komunitas, dan panen musim ini.',
            'gambar' => 'berita.jpg',
            'tautan' => '/berita',
            'status' => 'terbit',
            'diterbitkan_pada' => Carbon::now(),
            'id_penulis' => $penulis->id,
        ]);

        // 5. Kontak
        Konten::create([
            'judul' => 'Kontak',
            'slug' => 'kontak',
            'jenis' => 'halaman',
            'kutipan' => 'Hubungi kami untuk kerja sama dan pertanyaan.',
            'konten' => 'Silakan hubungi kami melalui informasi berikut.',
            'gambar' => 'kontak.jpg',
            'tautan' => '/kontak',
            'meta' => json_encode([
                'alamat' => 'Jl. Pertanian No.123, Jakarta',
                'email' => 'info@kebunorganik.com',
                'telepon' => '0812-3456-7890',
                'iframe_map' => '<iframe class="w-100 border-0" height="400"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.037232410178!2d100.36196731416502!3d-0.9500474352572055!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e2d62c273a5c23b%3A0x6e3d66c96a99b212!2sJalan%20Ripan%203%20No.11%2C%20Padang%2C%20Sumatera%20Barat!5e0!3m2!1sid!2sid!4v1685298123456"
                    allowfullscreen loading="lazy">
                </iframe>',
            ]),
            'status' => 'terbit',
            'diterbitkan_pada' => now(),
            'id_penulis' => $penulis->id,
        ]);

        Konten::create([
            'judul' => 'Footer',
            'slug' => 'footer',
            'jenis' => 'komponen',
            'kutipan' => '© 2025 Kebun Organik',
            'konten' => 'Hak cipta dan informasi footer lainnya.',
            'meta' => json_encode([
                'sosial' => [
                    'facebook' => 'https://facebook.com/kebunorganik',
                    'instagram' => 'https://instagram.com/kebunorganik',
                ],
                'alamat' => 'Jl. Pertanian No.123, Jakarta',
            ]),
            'status' => 'terbit',
            'diterbitkan_pada' => now(),
            'id_penulis' => $penulis->id,
        ]);
    }
}
