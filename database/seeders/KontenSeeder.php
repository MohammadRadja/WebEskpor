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
            'id_penulis' => $penulis->id,
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
            'id_penulis' => $penulis->id,
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
        $beritaList = [
            [
                'judul' => 'Panen Organik Meningkat',
                'kutipan' => 'Produksi panen organik meningkat signifikan tahun ini.',
                'konten' => 'Para petani lokal berhasil meningkatkan hasil panen berkat metode pertanian alami tanpa bahan kimia.',
                'gambar' => 'berita1.jpg',
            ],
            [
                'judul' => 'Kerja Sama dengan Lembaga Internasional',
                'kutipan' => 'Kebun organik menjalin kemitraan internasional.',
                'konten' => 'Kami bekerja sama dengan organisasi global untuk meningkatkan mutu dan jangkauan produk organik kami.',
                'gambar' => 'berita2.jpg',
            ],
            [
                'judul' => 'Pelatihan Pertanian Berkelanjutan',
                'kutipan' => 'Petani mendapat pelatihan tentang teknik pertanian berkelanjutan.',
                'konten' => 'Pelatihan ini meliputi penggunaan pupuk alami, rotasi tanaman, dan pengendalian hama ramah lingkungan.',
                'gambar' => 'berita3.jpg',
            ],
            [
                'judul' => 'Pameran Produk Organik Nasional',
                'kutipan' => 'Kami ikut serta dalam pameran produk organik tingkat nasional.',
                'konten' => 'Dalam pameran ini kami memperkenalkan berbagai produk unggulan dan inovasi di bidang pertanian organik.',
                'gambar' => 'berita4.jpg',
            ],
            [
                'judul' => 'Kunjungan Menteri Pertanian',
                'kutipan' => 'Menteri Pertanian mengapresiasi kegiatan petani organik.',
                'konten' => 'Kunjungan ini menunjukkan dukungan pemerintah terhadap pertanian berkelanjutan dan mandiri.',
                'gambar' => 'berita5.jpg',
            ],
            [
                'judul' => 'Program Edukasi Sekolah Alam',
                'kutipan' => 'Anak-anak belajar langsung tentang pertanian organik.',
                'konten' => 'Program ini bertujuan menanamkan kesadaran lingkungan dan cinta alam sejak dini.',
                'gambar' => 'berita6.jpg',
            ],
            [
                'judul' => 'Distribusi Produk ke Supermarket Nasional',
                'kutipan' => 'Produk kami kini tersedia di berbagai supermarket besar.',
                'konten' => 'Kerja sama dengan jaringan ritel ini memperluas akses masyarakat terhadap produk sehat.',
                'gambar' => 'berita7.jpg',
            ],
            [
                'judul' => 'Panen Perdana di Lahan Baru',
                'kutipan' => 'Panen pertama di lahan baru berjalan sukses.',
                'konten' => 'Lahan ini merupakan hasil kerja sama dengan koperasi petani desa untuk memperluas kapasitas produksi.',
                'gambar' => 'berita8.jpg',
            ],
            [
                'judul' => 'Workshop Kompos dan Pupuk Organik',
                'kutipan' => 'Warga diajarkan cara membuat kompos dari limbah rumah tangga.',
                'konten' => 'Workshop ini mendorong kemandirian pangan dan pengurangan sampah organik.',
                'gambar' => 'berita9.jpg',
            ],
            [
                'judul' => 'Program Subsidi Benih Organik',
                'kutipan' => 'Pemerintah daerah memberikan bantuan benih organik.',
                'konten' => 'Bantuan ini bertujuan meningkatkan produksi petani kecil dengan bibit berkualitas.',
                'gambar' => 'berita10.jpg',
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
                'tautan' => '/berita/' . Str::slug($data['judul']),
                'status' => 'terbit',
                'diterbitkan_pada' => Carbon::now(),
                'id_penulis' => $penulis->id,
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
            'id_penulis' => $penulis->id,
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
            'id_penulis' => $penulis->id,
        ]);
        // hasil perkebunan
        Konten::create([
            'id' => '73c5bc8e-69f6-11f0-8606-544810de48fd',
            'judul' => 'Hasil Perkebunan',
            'slug' => 'Hasil Perkebunan Kami',
            'jenis' => 'komponen',
            'kutipan' => 'KAMI MELAKUKAN',
            'konten' => '-',
            'gambar' => 'gambar.jpg',
            'tautan' => 'https://contoh.com',
            'meta' => json_encode([['deskripsi' => 'Menutup Tanah (Mulching)'], ['deskripsi' => 'Pemupukan'], ['deskripsi' => 'Panen'], ['deskripsi' => ' Menyemai Tanaman'], ['deskripsi' => 'Memotong Rumput'], ['deskripsi' => 'Menyiram']]),
            'media' => json_encode(['img_sq_1.jpg', 'gambar2.jpg']),
            'status' => 'terbit',
            'diterbitkan_pada' => now(),
            'id_penulis' => $penulis->id,
        ]);

        // carousel
        Konten::create([
            'id' => 'ac1726e6-69d0-11f0-8606-544810de48fd',
            'judul' => 'Carousel',
            'slug' => 'carausel',
            'jenis' => 'komponen',
            'kutipan' => 'Ini adalah kutipan singkat.',
            'konten' => 'Konten lengkap artikel di sini.',
            'gambar' => 'gambar.jpg',
            'tautan' => 'https://contoh.com',
            'meta' => json_encode([
                [
                    'judul' => 'Hasil Ladang Terpilih, Menjawab Kebutuhan Pasar Dunia',
                    'deskripsi' => 'PT Prima Andalas — Pilar Kepercayaan dalam Menyediakan Hasil Perkebunan Premium, Siap Melayani Pasar Ekspor dengan Standar Mutu Tinggi dan Komitmen Tanpa Kompromi.',
                ],
                [
                    'judul' => 'Sayuran organik baik untuk kesehatan',
                    'deskripsi' => 'Dengan Dedikasi pada Keaslian dan Kesegaran, Kami Menyediakan Sayuran Organik yang Menyehatkan, Mendukung Anda dalam Menjalani Hidup Berkualitas dan Harmonis dengan Alam.',
                ],
                [
                    'judul' => 'Menyediakan Hasil Panen Segar Setiap Hari',
                    'deskripsi' => 'Kesegaran hasil panen setiap hari, untuk kebutuhan pasar yang terpercaya.',
                ],
                [
                    'judul' => 'Bertani sebagai Sebuah Passion',
                    'deskripsi' => 'Kami percaya bahwa bertani bukan sekadar pekerjaan, tapi panggilan hati. Dengan penuh dedikasi dan cinta terhadap tanah serta tanaman, kami berkomitmen menghadirkan hasil panen terbaik yang alami dan berkualitas tinggi, sebagai wujud nyata dari passion kami di dunia pertanian.',
                ],
            ]),
            'media' => json_encode(['perkebunan1.jpg', 'perkebunan2.jpg', 'hero_3.jpg']),
            'status' => 'terbit',
            'diterbitkan_pada' => now(),
            'id_penulis' => $penulis->id,
        ]);

        // service
        Konten::create([
            'id' => '46506e48-69e4-11f0-8606-544810de48fd',
            'judul' => 'SERVICES',
            'slug' => Str::slug('Services'),
            'kutipan' => 'SERVICE YANG KAMI LAKUKAN SETIAP HARI DI PERKEBUNAN',
            'jenis' => 'komponen',
            'konten' => 'SERVICE YANG KAMI LAKUKAN SETIAP HARI DI PERKEBUNAN',
            'gambar' => 'gambar.jpg',
            'tautan' => 'https://contoh.com',
            'meta' => json_encode([['judul' => 'Pembersihan Lahan', 'deskripsi' => 'Kami membersihkan lahan dengan teknik ramah lingkungan untuk memastikan kesiapan sebelum penanaman.'], ['judul' => 'Penanaman', 'deskripsi' => 'Layanan penanaman tanaman dengan metode yang tepat untuk hasil yang subur dan tahan lama.'], ['judul' => 'Penyiraman', 'deskripsi' => 'Gravida sodales condimentum pellen tesq accumsan orci quam sagittis sapie'], ['judul' => 'Konsultasi Pertanian', 'deskripsi' => 'Gravida sodales condimentum pellen tesq accumsan orci quam sagittis sapie']]),
            'media' => json_encode(['gambar1.jpg', 'gambar2.jpg']),
            'status' => 'terbit',
            'diterbitkan_pada' => now(),
            'id_penulis' => $penulis->id,
        ]);
    }
}
