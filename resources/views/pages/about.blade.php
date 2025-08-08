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
                    <img src="{{ asset('assets/img/' . $profil->gambar) }}" alt="{{ $profil->slug }}"
                        class="img-fluid rounded shadow-sm" />
                </div>
                <div class="col-lg-5 order-lg-1" data-aos="fade-right" data-aos-delay="200">
                    <h2 class="content-title mb-4">{{ $profil->judul }}</h2>
                    <p class="text-muted mb-4">{{ $profil->kutipan }}</p>
                    <p>{{ $profil->konten }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="section py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="content-title fw-bold">{{ $layanan->judul ?? '' }}</h2>
                <p class="text-muted">
                    {{ $layanan->kutipan ?? '' }} </p>
            </div>

            <div class="row gy-4 justify-content-center">
                @foreach (meta($layanan, null, []) as $i => $service)
                    <div class="col-lg-5 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-box w-100 text-center bg-white shadow-sm p-4 border rounded">
                            <h4 class="mb-3">{{ $service['judul'] ?? '-' }}</h4>
                            <p>{{ $service['deskripsi'] ?? '-' }}</p>
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
                <h2 class="content-title fw-bold">{{ $visiMisi->judul ?? '' }}</h2>
                <p class="text-muted">{{ $visiMisi->kutipan ?? '' }}</p>
            </div>

            <!-- Visi -->
            <div class="row justify-content-center mb-4">
                <div class="col-lg-10" data-aos="fade-right" data-aos-delay="100">
                    <div class="p-4 shadow-sm rounded bg-light border-start border-success border-5">
                        <h4 class="fw-semibold text-success mb-3">Visi</h4>
                        <p class="mb-0">{{ meta($visiMisi, 'visi') }}</p>
                    </div>
                </div>
            </div>

            <!-- Misi -->
            <div class="row justify-content-center">
                <div class="col-lg-10" data-aos="fade-left" data-aos-delay="200">
                    <div class="p-4 shadow-sm rounded bg-light border-start border-success border-5">
                        <h4 class="fw-semibold text-success mb-3">Misi</h4>
                        <ul class="list-unstyled ps-3">
                            @foreach (meta($visiMisi, 'misi', []) as $item)
                                <li class="mb-3 d-flex align-items-start">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    <span>{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
