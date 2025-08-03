@extends('layouts.guest.index')
@section('title', 'Berita - PT.RAJAWALI PRIMA ANDALAS')
@section('content')

    {{-- Hero Section --}}
    <x-hero-section title="Berita" background="{{ asset('assets/img/page-title-bg.webp') }}" :breadcrumbs="[['label' => 'Home', 'url' => '/'], ['label' => 'Berita']]" />

    <!-- Blog Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <!-- Judul Blog -->
            <div class="text-center mb-5">
                <h2 class="fw-bold">Berita & Artikel</h2>
                <p class="text-muted">Update terbaru seputar kegiatan dan informasi menarik lainnya</p>
            </div>

            <div class="swipper" data-slider-id="blog-slider" data-per-page="3" data-rows="1">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        @forelse ($blog as $item)
                            @php
                                $isExternal = Str::startsWith($item->tautan, ['http://', 'https://']);
                            @endphp

                            <div class="swiper-slide">
                                <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden">
                                    <a href="{{ $item->tautan }}" class="text-decoration-none text-dark"
                                        @if ($isExternal) target="_blank" rel="noopener noreferrer" @endif>
                                        <div class="ratio ratio-16x9">
                                            <img src="{{ asset_or_default('assets/img/blog/' . $item->gambar) }}"
                                                class="card-img-top object-fit-cover" alt="{{ $item->slug }}">
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="fw-semibold mb-2">{{ $item->kutipan }}</h5>
                                            <div
                                                class="d-flex justify-content-between align-items-center text-muted small mb-2">
                                                <span><i class="bi bi-calendar"></i>
                                                    {{ format_tanggal($item->diterbitkan_pada) }}</span>
                                                <span><i class="bi bi-person"></i>
                                                    {{ $item->penulis ?? 'Admin' }}</span>
                                            </div>

                                            <p class="card-text text-muted small flex-grow-1">
                                                {{ Str::limit($item->konten, 100) }}
                                            </p>
                                            <span class="text-primary mt-2 fw-semibold">Baca Selengkapnya →</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center text-muted">
                                <p>Tidak ada berita saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Navigasi Slider -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <button id="blog-prev" class="btn btn-outline-primary">
                        <i class="bi bi-chevron-left"></i> Sebelumnya
                    </button>
                    <button id="blog-next" class="btn btn-outline-primary">
                        Selanjutnya <i class="bi bi-chevron-right"></i>
                    </button>
                </div>

                <!-- Indikator -->
                <ul class="carousel-indicators-banner d-flex justify-content-center gap-2 mt-3 list-unstyled"></ul>
            </div>
        </div>
    </section>
@endsection
