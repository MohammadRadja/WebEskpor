<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Konten;
use Illuminate\Support\Str;
use Carbon\Carbon;

class KontenSeeder extends Seeder
{
    public function run(): void
    {
        // 2. Tentang Kami
        // Profil Perusahaan
        Konten::create([
            'judul' => 'Profil Perusahaan',
            'slug' => Str::slug('profil-perusahaan'),
            'jenis' => 'komponen',
            'kutipan' => 'Pelopor pertanian berkelanjutan sejak 2005.',
            'konten' => 'PT Rajawali Prima Andalas adalah perusahaan ekspor hasil pertanian yang berlokasi di Kota Padang, Sumatera Barat. Didirikan oleh Zulhendra Putra, perusahaan ini bertujuan membantu petani lokal memasarkan produknya ke pasar internasional. Kami fokus pada kualitas produk, kemitraan jangka panjang, dan efisiensi proses ekspor.',
            'gambar' => 'logo1.jpg',
            'tautan' => '/about',
            'status' => 'terbit',
            'diterbitkan_pada' => Carbon::now(),
            'penulis' => '',
        ]);

        // Layanan Kami
        Konten::create([
            'judul' => 'Layanan Kami',
            'slug' => Str::slug('layanan-kami'),
            'jenis' => 'komponen',
            'kutipan' => 'Beragam layanan kami untuk ekspor dan kemitraan.',
            'konten' => 'Berisi daftar layanan yang kami tawarkan.',
            'meta' => json_encode([
                [
                    'judul' => 'Ekspor Sayuran',
                    'deskripsi' => 'Layanan ekspor berbagai jenis sayuran segar dan organik.',
                ],
                [
                    'judul' => 'Kemitraan Petani',
                    'deskripsi' => 'Kemitraan jangka panjang dengan petani lokal.',
                ],
                [
                    'judul' => 'Distribusi Global',
                    'deskripsi' => 'Jaringan distribusi ke berbagai negara.',
                ],
                [
                    'judul' => 'Konsultasi Pertanian',
                    'deskripsi' => 'Konsultasi untuk meningkatkan hasil pertanian.',
                ],
            ]),
            'status' => 'terbit',
            'diterbitkan_pada' => now(),
            'penulis' => '',
        ]);
        // Visi Misi
        Konten::create([
            'judul' => 'Visi & Misi',
            'slug' => Str::slug('visi-misi'),
            'jenis' => 'komponen',
            'kutipan' => 'Tujuan dan komitmen kami.',
            'konten' => 'Berisi visi dan misi perusahaan.',
            'meta' => json_encode([
                'visi' => 'Menjadi perusahaan ekspor hasil pertanian terpercaya di Asia Tenggara.',
                'misi' => ['Meningkatkan daya saing produk pertanian Indonesia.', 'Membuka akses pasar global bagi petani lokal.', 'Menjaga kualitas dan keberlanjutan produk ekspor.'],
            ]),
            'status' => 'terbit',
            'diterbitkan_pada' => now(),
            'penulis' => '',
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
            'penulis' => '',
        ]);

        // 4. Berita
        $beritaList = [
            [
                'judul' => 'Panen Organik Meningkat',
                'penulis' => 'Budi Santoso',
                'kutipan' => 'Produksi panen organik meningkat signifikan tahun ini.',
                'konten' => 'Para petani lokal berhasil meningkatkan hasil panen...',
                'gambar' => 'berita1.jpg',
                'tautan' => 'https://www.twitter.com/',
            ],
            [
                'judul' => 'Kerja Sama dengan Lembaga Internasional',
                'penulis' => 'Siti Rahmawati',
                'kutipan' => 'Kebun organik menjalin kemitraan internasional.',
                'konten' => 'Kami bekerja sama dengan organisasi global...',
                'gambar' => 'berita2.jpg',
                'tautan' => 'https://www.twitter.com/',
            ],
            [
                'judul' => 'Pelatihan Pertanian Berkelanjutan',
                'penulis' => 'Andi Wijaya',
                'kutipan' => 'Petani mendapat pelatihan tentang teknik pertanian berkelanjutan.',
                'konten' => 'Pelatihan ini meliputi penggunaan pupuk alami...',
                'gambar' => 'berita3.jpg',
                'tautan' => 'https://www.twitter.com/',
            ],
            [
                'judul' => 'Pameran Produk Organik Nasional',
                'penulis' => 'Rina Puspita',
                'kutipan' => 'Kami ikut serta dalam pameran produk organik tingkat nasional.',
                'konten' => 'Dalam pameran ini kami memperkenalkan berbagai produk unggulan...',
                'gambar' => 'berita4.jpg',
                'tautan' => 'https://www.twitter.com/',
            ],
            [
                'judul' => 'Kunjungan Menteri Pertanian',
                'penulis' => 'Agus Prabowo',
                'kutipan' => 'Menteri Pertanian mengapresiasi kegiatan petani organik.',
                'konten' => 'Kunjungan ini menunjukkan dukungan pemerintah...',
                'gambar' => 'berita5.jpg',
                'tautan' => 'https://www.twitter.com/',
            ],
            [
                'judul' => 'Program Edukasi Sekolah Alam',
                'penulis' => 'Dewi Kartika',
                'kutipan' => 'Anak-anak belajar langsung tentang pertanian organik.',
                'konten' => 'Program ini bertujuan menanamkan kesadaran lingkungan...',
                'gambar' => 'berita6.jpg',
                'tautan' => 'https://www.twitter.com/',
            ],
            [
                'judul' => 'Distribusi Produk ke Supermarket Nasional',
                'penulis' => 'Hendra Wijaya',
                'kutipan' => 'Produk kami kini tersedia di berbagai supermarket besar.',
                'konten' => 'Kerja sama dengan jaringan ritel ini memperluas akses...',
                'gambar' => 'berita7.jpg',
                'tautan' => 'https://www.twitter.com/',
            ],
            [
                'judul' => 'Panen Perdana di Lahan Baru',
                'penulis' => 'Nur Aini',
                'kutipan' => 'Panen pertama di lahan baru berjalan sukses.',
                'konten' => 'Lahan ini merupakan hasil kerja sama dengan koperasi petani...',
                'gambar' => 'berita8.jpg',
                'tautan' => 'https://www.twitter.com/',
            ],
            [
                'judul' => 'Workshop Kompos dan Pupuk Organik',
                'penulis' => 'Yudi Saputra',
                'kutipan' => 'Warga diajarkan cara membuat kompos dari limbah rumah tangga.',
                'konten' => 'Workshop ini mendorong kemandirian pangan...',
                'gambar' => 'berita9.jpg',
                'tautan' => 'https://www.twitter.com/',
            ],
            [
                'judul' => 'Program Subsidi Benih Organik',
                'penulis' => 'Fitri Handayani',
                'kutipan' => 'Pemerintah daerah memberikan bantuan benih organik.',
                'konten' => 'Bantuan ini bertujuan meningkatkan produksi petani kecil...',
                'gambar' => 'berita10.jpg',
                'tautan' => 'https://www.twitter.com/',
            ],
        ];

        foreach ($beritaList as $data) {
            Konten::create([
                'judul' => $data['judul'],
                'slug' => Str::slug('berita/' . $data['judul']),
                'jenis' => 'artikel',
                'kutipan' => $data['kutipan'],
                'konten' => $data['konten'],
                'gambar' => $data['gambar'],
                'tautan' => $data['tautan'],
                'status' => 'terbit',
                'diterbitkan_pada' => Carbon::now(),
                'penulis' => $data['penulis'],
            ]);
        }

        // 5. Kontak
        Konten::create([
            'judul' => 'Kontak',
            'slug' => Str::slug('Kontak'),
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
            'penulis' => '',
        ]);

        // 6. Footer
        Konten::create([
            'judul' => 'Footer',
            'slug' => Str::slug('Footer'),
            'jenis' => 'komponen',
            'kutipan' => 'PT. Rajawali Prima Andalas Indonesia',
            'konten' => 'Hak cipta dilindungi.',
            'meta' => json_encode([
                'sosial' => [
                    'facebook' => 'https://facebook.com/kebunorganik',
                    'instagram' => 'https://instagram.com/kebunorganik',
                ],
                'alamat' => 'Jl. Ripan III No.11, RT.05/RW.19, Lubuk Buaya, Kec. Koto Tangah, Kota Padang, Sumatera Barat 25173',
            ]),
            'status' => 'terbit',
            'diterbitkan_pada' => now(),
            'penulis' => '',
        ]);
    }
}
