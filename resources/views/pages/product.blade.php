@extends('layouts.guest.index')
@section('title', 'Product - PT.RAJAWALI PRIMA ANDALAS')
@section('content')
{{-- Hero Section --}}
<x-hero-section title="Product" background="assets/img/page-title-bg.webp" :breadcrumbs="[['label' => 'Home', 'url' => '/'], ['label' => 'Product']]" />

<!-- Services Section -->
<section id="services" class="services section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>SERVICES</h2>
        <p>Providing Fresh Produce Every Single Day</p>
    </div><!-- End Section Title -->
    <div class="content">
        <div class="container">
            <div class="row g-0">
                @forelse ($product as $index => $item)
                <div class="col-lg-3 col-md-6">
                    <div class="service-item">
                        <span class="number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <div class="service-item-icon text-center">
                            {{-- Ganti SVG ini dengan dynamic icon jika ada --}}
                            <img
                                src="{{asset('assets/img/default.png')}}"
                                alt="{{ $item->name }}"
                                class="img-fluid mb-3"
                                style="max-height: 150px; object-fit: cover;">
                        </div>
                        <div class="service-item-content">
                            <h3 class="service-heading">{{ $item->nama ?? 'Nama Produk' }}</h3>
                            <p>{{ $item->deskripsi ?? 'Deskripsi produk belum tersedia.' }}</p>
                        </div>
                        <ul class="mt-2 text-sm text-muted">
                            <li><strong>Harga:</strong> Rp{{ number_format($item->harga, 0, ',', '.') }}</li>
                            <li><strong>Stok:</strong> {{ $item->stok }} unit</li>
                        </ul>
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item->id }}">
                            <button type="submit" class="btn btn-success">Add to Cart</button>
                        </form>

                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p class="text-center text-muted">Produk belum tersedia.</p>
                </div>
                @endforelse

            </div>
        </div>
    </div>
</section><!-- /Services Section -->

<!-- About Section -->
<section id="about" class="about section">

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="assets/img/img_long_5.jpg" alt="Image " class="img-fluid img-overlap"
                        data-aos="zoom-out">
                </div>
                <div class="col-lg-5 ml-auto" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="content-subtitle text-white opacity-50">Why Choose Us</h3>
                    <h2 class="content-title mb-4">
                        More than <strong>50 year experience</strong> in agriculture
                        industry
                    </h2>
                    <p class="opacity-50">
                        Reprehenderit, odio laboriosam? Blanditiis quae ullam quasi illum
                        minima nostrum perspiciatis error consequatur sit nulla.
                    </p>

                    <div class="row my-5">
                        <div class="col-lg-12 d-flex align-items-start mb-4">
                            <i class="bi bi-cloud-rain me-4 display-6"></i>
                            <div>
                                <h4 class="m-0 h5 text-white">Plants needs rain</h4>
                                <p class="text-white opacity-50">Lorem ipsum dolor sit amet.</p>
                            </div>
                        </div>
                        <div class="col-lg-12 d-flex align-items-start mb-4">
                            <i class="bi bi-heart me-4 display-6"></i>
                            <div>
                                <h4 class="m-0 h5 text-white">Love organic foods</h4>
                                <p class="text-white opacity-50">Lorem ipsum dolor sit amet.</p>
                            </div>
                        </div>
                        <div class="col-lg-12 d-flex align-items-start">
                            <i class="bi bi-shop me-4 display-6"></i>
                            <div>
                                <h4 class="m-0 h5 text-white">Sell vegies</h4>
                                <p class="text-white opacity-50">Lorem ipsum dolor sit amet.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- /About Section -->

<!-- Testimonials Section -->
<section class="testimonials-12 testimonials section" id="testimonials">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>TESTIMONIALS</h2>
        <p>Necessitatibus eius consequatur</p>
    </div><!-- End Section Title -->

    <div class="testimonial-wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-4">
                    <div class="testimonial">
                        <img src="assets/img/testimonials/testimonials-1.jpg" alt="Testimonial author">
                        <blockquote>
                            <p>
                                “Lorem ipsum dolor sit, amet consectetur adipisicing
                                elit. Provident deleniti iusto molestias, dolore vel fugiat
                                ab placeat ea?”
                            </p>
                        </blockquote>
                        <p class="client-name">James Smith</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4 mb-md-4">
                    <div class="testimonial">
                        <img src="assets/img/testimonials/testimonials-2.jpg" alt="Testimonial author">
                        <blockquote>
                            <p>
                                “Lorem ipsum dolor sit, amet consectetur adipisicing
                                elit. Provident deleniti iusto molestias, dolore vel fugiat
                                ab placeat ea?”
                            </p>
                        </blockquote>
                        <p class="client-name">Kate Smith</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4 mb-md-4">
                    <div class="testimonial">
                        <img src="assets/img/testimonials/testimonials-3.jpg" alt="Testimonial author">
                        <blockquote>
                            <p>
                                “Lorem ipsum dolor sit, amet consectetur adipisicing
                                elit. Provident deleniti iusto molestias, dolore vel fugiat
                                ab placeat ea?”
                            </p>
                        </blockquote>
                        <p class="client-name">Claire Anderson</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4 mb-md-4">
                    <div class="testimonial">
                        <img src="assets/img/testimonials/testimonials-4.jpg" alt="Testimonial author">
                        <blockquote>
                            <p>
                                “Lorem ipsum dolor sit, amet consectetur adipisicing
                                elit. Provident deleniti iusto molestias, dolore vel fugiat
                                ab placeat ea?”
                            </p>
                        </blockquote>
                        <p class="client-name">Dan Smith</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection