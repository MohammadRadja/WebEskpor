@extends('layouts.guest.index')
@section('title', 'Home - PT. Rajawali Prima Andalas')

@section('content')
<section id="hero" class="hero section dark-background">
    <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

        <!-- End Carousel Item -->
        @forelse ($carouselItems as $item)
        <div class="carousel-item active">
            <img src="{{ asset_or_default('assets/img/' . ($item['media'] ?? 'default.jpg')) }}" alt="">
            <div class="carousel-container">
                <h2 class="mb-3">{{ $item['judul'] ?? '-' }}</h2>
                <p>{{ $item['deskripsi'] ?? '-' }}</p>
            </div>
        </div>
        @empty
        <div class="carousel-item active">
            <img src="{{ asset('assets/img/default.jpg') }}" alt="">
            <div class="carousel-container">
                <h2 class="mb-3">Belum ada judul</h2>
                <p>Belum ada deskripsi tersedia.</p>
            </div>
        </div>
        @endforelse


        <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
        </a>

        <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
        </a>

        <ol class="carousel-indicators"></ol>

    </div>
</section>
<!-- Services Section -->
<section id="services" class="services section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">

        <h2>{{$service -> judul ?? 'belum ada judul' }}</h2>
        <p>{{$service -> slug ?? 'belum ada deskripsi' }}</p>
    </div><!-- End Section Title -->
    <div class="content">
        <div class="container">
            <div class="row g-0">
                @forelse ($serviceItems as $index => $item)
                <div class="col-lg-3 col-md-6">
                    <div class="service-item">
                        <span class="number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <div class="service-item-icon">
                            <img src="{{ asset_or_default('assets/img/' . ($item['media'] ?? 'default.jpg')) }}" style="width: 200px;" alt="">
                        </div>
                        <div class="service-item-content">
                            <h3 class="service-heading">{{ $item['judul'] ?? '-' }}</h3>
                            <p>{{ $item['deskripsi'] ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada layanan yang ditambahkan.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section><!-- /Services Section -->
<!-- Services 2 Section -->
<section id="services-2" class="services-2 section bg-primary   ">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <p>{{$perkebunan -> slug ?? 'Konten Belum Ditambahkan'}}</p>
    </div><!-- End Section Title -->
    <div class="services-carousel-wrap">
        <div class="container position-relative">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <!-- Ulangi item seperti ini -->

                    @forelse ($perkebunanItems as $item)
                    <div class="swiper-slide">
                        <div class="service-item">
                            <div class="service-item-contents">
                                <a href="#">
                                    <h4 class="service-item-category">{{ $item['judul'] ?? 'Kami Melakukan' }}</h4>
                                    <p class="service-item-category">{{ $item['deskripsi'] ?? '-' }}</p>
                                </a>
                            </div>
                            <img src="{{ asset_or_default('assets/img/' . ($item['media'] ?? 'default.jpg')) }}" alt="Gambar" class="img-fluid">
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <p class="text-center text-muted">Belum ada data hasil perkebunan.</p>
                    </div>
                    @endforelse

                    <!-- Tambahkan slide lainnya seperti yang sudah kamu buat -->
                </div>

                <!-- Navigasi dan Pagination -->
                <div class="swiper-pagination"></div>
                <div class="navigation-prev js-custom-prev btn-primary"><i class="bi bi-arrow-left-short"></i></div>
                <div class="navigation-next js-custom-next btn-primary"><i class="bi bi-arrow-right-short"></i></div>
            </div>
        </div>
    </div>

</section><!-- /Services 2 Section -->
<script>
    const swiper = new Swiper('.mySwiper', {
        loop: true,
        speed: 600,
        autoplay: {
            delay: 5000,
        },
        slidesPerView: 1,
        spaceBetween: 30,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.js-custom-next',
            prevEl: '.js-custom-prev',
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
                spaceBetween: 30
            },
            1200: {
                slidesPerView: 1,
                spaceBetween: 40
            }
        }
    });
</script>
@endsection