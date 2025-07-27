@extends('layouts.guest.index')
@section('title', 'Product - PT.RAJAWALI PRIMA ANDALAS')
@section('content')

{{-- Hero Section --}}
<x-hero-section title="Product" background="assets/img/page-title-bg.webp" :breadcrumbs="[['label' => 'Home', 'url' => '/'], ['label' => 'Product']]" />

<!-- Product Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Produk Kami</h2>
            <p class="text-muted">Produk segar dan berkualitas setiap hari</p>
        </div>

        <div class="row">
            @forelse ($product as $item)
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('assets/img/default.png') }}" class="card-img-top" alt="{{ $item->nama }}" style="height: 180px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $item->nama }}</h5>
                            <p class="card-text text-muted small mb-2">{{ $item->deskripsi ?? 'Deskripsi tidak tersedia.' }}</p>
                            <ul class="list-unstyled small mb-3">
                                <li><strong>Harga:</strong> {{ rupiah($item->harga) }}</li>
                                <li><strong>Stok:</strong> {{ format_stok($item->stok) }}</li>
                            </ul>
                            <form action="{{ route('cart.add') }}" method="POST" class="mt-auto">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->id }}">
                                <button type="submit" class="btn btn-success w-100">Tambah ke Keranjang</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">
                    <p>Produk belum tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
