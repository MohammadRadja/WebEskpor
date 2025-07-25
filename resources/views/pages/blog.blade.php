@extends('layouts.guest.index')
@section('title', 'Blog - PT.RAJAWALI PRIMA ANDALAS')
@section('content')
{{-- Hero Section --}}
<x-hero-section title="Blog" background="{{ asset('assets/img/page-title-bg.webp') }}" :breadcrumbs="[['label' => 'Home', 'url' => '/'], ['label' => 'Blog']]" />

<!-- Blog Section -->
<div class="container mt-5">
    <div class="row g-4">
        <!-- Blog Post  -->
        @forelse ($blog as $item)
        <div class="col-md-6 col-lg-4">
            <div class="card blog-card h-100">
                <img src="{{asset('assets/img/default.png')}}"
                    class="card-img-top" alt="Perkebunan Kelapa Sawit">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{$item -> kutipan}}</h5>
                    <p class="blog-meta mb-3">
                        <i class="bi bi-calendar"></i> {{$item -> diterbitkan_pada}}
                    </p>
                    <p class="card-text flex-grow-1">{{$item -> konten}}</p>
                </div>
            </div>
        </div>
        @empty
        <p class="center">Tidak ada berita saat ini.</p>
        @endforelse
    </div>

    <!-- Pagination -->
    <nav aria-label="Blog pagination" class="mt-5">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
            </li>
            <li class="page-item active" aria-current="page">
                <a class="page-link" href="#">1</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">2</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">3</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">Next</a>
            </li>
        </ul>
    </nav>
</div>

@endsection