@extends('layouts.guest.index')

@section('title', 'About - PT. RAJAWALI PRIMA ANDALAS')

@section('content')
    {{-- Hero Section --}}
    <x-hero-section title="About Us" background="{{ asset('assets/img/page-title-bg.webp') }}" :breadcrumbs="[['label' => 'Home', 'url' => '/'], ['label' => 'About Us']]" />

    <!-- Company Profile -->
    <section class="section py-5 bg-white">
        <div class="container">
            <div class="row gy-4 justify-content-between align-items-center">
                <div class="col-lg-6 order-lg-2" data-aos="zoom-out" data-aos-delay="100">
                    <img src="{{ asset('assets/img/logo1.jpg') }}" alt="Profil Perusahaan"
                        class="img-fluid rounded shadow-sm" />
                </div>
                <div class="col-lg-5 order-lg-1" data-aos="fade-right" data-aos-delay="200">
                    <h2 class="content-title mb-4">Profil Perusahaan</h2>
                    <p><strong>PT RAJAWALI PRIMA ANDALAS</strong><br>
                        Alamat: Jalan Ripan 3, No.11, KOTA PADANG, Sumatera Barat</p>
                    <p>PT Rajawali Prima Andalas adalah perusahaan ekspor hasil pertanian yang bertujuan memperkenalkan
                        produk unggulan Indonesia ke pasar global. Didirikan oleh <strong>Zulhendra Putra</strong>, kami
                        menjembatani petani lokal dengan dunia internasional.</p>
                    <p>Berlokasi di Kota Padang, kami fokus pada kualitas produk, efisiensi ekspor, dan kerja sama jangka
                        panjang dengan para mitra.</p>
                    <p>Dengan inovasi dan integritas, kami berkomitmen tumbuh bersama petani serta memberikan kontribusi
                        nyata bagi perekonomian nasional.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="section py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="content-title">Layanan Kami</h2>
                <p class="text-muted">Mendukung rantai pasok ekspor hasil pertanian secara profesional dan berkelanjutan.
                </p>
            </div>

            <div class="row gy-4 justify-content-center">
                @php
                    $services = [
                        [
                            'title' => 'Pengadaan Hasil Pertanian',
                            'desc' =>
                                'Menyediakan komoditas unggulan seperti kopi, rempah-rempah, kelapa, dan hasil bumi lainnya dari petani lokal.',
                        ],
                        [
                            'title' => 'Prosesing & Quality Control',
                            'desc' =>
                                'Memastikan kualitas produk sesuai standar ekspor internasional melalui pemrosesan dan kontrol mutu ketat.',
                        ],
                        [
                            'title' => 'Manajemen Ekspor',
                            'desc' =>
                                'Mengelola logistik dan dokumentasi ekspor hingga produk tiba di tangan buyer internasional.',
                        ],
                        [
                            'title' => 'Konsultasi & Kemitraan',
                            'desc' =>
                                'Membuka peluang kolaborasi ekspor dan membangun kemitraan strategis dengan pelaku pertanian dan distributor global.',
                        ],
                    ];
                @endphp

                @foreach ($services as $i => $service)
                    <div class="col-lg-5 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="{{ 100 + $i * 100 }}">
                        <div class="service-box w-100 text-center bg-white shadow-sm p-4 border rounded">
                            <h4 class="mb-3">{{ $service['title'] }}</h4>
                            <p>{{ $service['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Visi Misi -->
    <section class="section py-5 bg-white">
        <div class="container" data-aos="fade-up">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Visi & Misi Kami</h2>
                <p class="text-muted">Landasan arah dan tujuan dari PT Rajawali Prima Andalas</p>
            </div>

            <!-- Visi -->
            <div class="row justify-content-center mb-4">
                <div class="col-lg-10" data-aos="fade-right" data-aos-delay="100">
                    <div class="p-4 shadow-sm rounded bg-light border-start border-success border-5">
                        <h4 class="fw-semibold text-success mb-3">Visi</h4>
                        <p class="mb-0">Menjadi perusahaan ekspor hasil pertanian terkemuka yang berdaya saing global,
                            mendukung pertumbuhan ekonomi nasional, dan meningkatkan kesejahteraan petani lokal.</p>
                    </div>
                </div>
            </div>

            <!-- Misi -->
            <div class="row justify-content-center">
                <div class="col-lg-10" data-aos="fade-left" data-aos-delay="200">
                    <div class="p-4 shadow-sm rounded bg-light border-start border-success border-5">
                        <h4 class="fw-semibold text-success mb-3">Misi</h4>
                        <ul class="list-unstyled ps-3">
                            <li class="mb-3 d-flex align-items-start"><i
                                    class="bi bi-check-circle-fill text-success me-2"></i><span>Meningkatkan kualitas dan
                                    kuantitas hasil pertanian untuk pasar ekspor.</span></li>
                            <li class="mb-3 d-flex align-items-start"><i
                                    class="bi bi-check-circle-fill text-success me-2"></i><span>Menjalin kemitraan
                                    berkelanjutan dengan petani lokal dan pelaku agribisnis.</span></li>
                            <li class="mb-3 d-flex align-items-start"><i
                                    class="bi bi-check-circle-fill text-success me-2"></i><span>Menerapkan standar
                                    internasional dalam proses produksi dan distribusi.</span></li>
                            <li class="mb-3 d-flex align-items-start"><i
                                    class="bi bi-check-circle-fill text-success me-2"></i><span>Memperluas jaringan pasar
                                    ekspor ke berbagai negara potensial.</span></li>
                            <li class="d-flex align-items-start"><i
                                    class="bi bi-check-circle-fill text-success me-2"></i><span>Mendorong inovasi dan
                                    teknologi dalam sektor pertanian.</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
