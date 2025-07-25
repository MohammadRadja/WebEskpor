@extends('layouts.guest.index')
@section('title', 'Blog - PT.RAJAWALI PRIMA ANDALAS')
@section('content')

    {{-- Hero Section --}}
    <x-hero-section title="Berita" background="{{ asset('assets/img/page-title-bg.webp') }}" :breadcrumbs="[['label' => 'Home', 'url' => '/'], ['label' => 'Berita']]" />

    <!-- Blog Section -->
    <div class="container mt-5">
        <div class="swipper" data-slider-id="blog-slider" data-per-page="3" data-rows="1">
            <div class="swiper">
                <div class="swiper-wrapper">
                    @forelse ($blog as $item)
                        <div class="swiper-slide">
                            <div class="card h-100 shadow-sm border-0">
                                <img src="{{ asset_or_default('assets/img/blog/' . $item->gambar) }}"
                                    class="card-img-top object-fit-cover" style="height: 200px;" alt="{{ $item->slug }}">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $item->kutipan }}</h5>
                                    <p class="text-muted mb-2">
                                        <i class="bi bi-calendar"></i> {{ format_tanggal($item->diterbitkan_pada) }}
                                    </p>
                                    <p class="card-text flex-grow-1">{{ $item->konten }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">Tidak ada berita saat ini.</p>
                    @endforelse
                </div>
            </div>

            {{-- Tombol Navigasi --}}
            <div class="d-flex justify-content-between align-items-center mt-4">
                <button id="blog-prev" class="btn btn-outline-primary">
                    <i class="bi bi-chevron-left"></i> Sebelumnya
                </button>
                <button id="blog-next" class="btn btn-outline-primary">
                    Selanjutnya <i class="bi bi-chevron-right"></i>
                </button>
            </div>

            {{-- Indikator Halaman --}}
            <ul class="carousel-indicators-banner d-flex justify-content-center gap-2 mt-3 list-unstyled"></ul>
        </div>
    </div>
@endsection
