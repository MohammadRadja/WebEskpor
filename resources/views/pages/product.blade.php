@extends('layouts.guest.index')
@section('title', 'Product - PT.RAJAWALI PRIMA ANDALAS')
@section('content')
    @php use Illuminate\Support\Str; @endphp

    {{-- Hero Section --}}
    <x-hero-section title="Produk" background="assets/img/page-title-bg.webp" :breadcrumbs="[['label' => 'Home', 'url' => '/'], ['label' => 'Produk']]" />

    <!-- Product Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Produk Kami</h2>
                <p class="text-muted">Produk segar dan berkualitas setiap hari</p>
            </div>
            @if (session('stok_kurang'))
                <div class="alert alert-danger">
                    {{ session('stok_kurang') }}
                </div>
            @endif

            <div class="row">
                @forelse ($product as $item)
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset_or_default($item->gambar) }}" class="card-img-top"
                                alt="{{ $item->nama }}">

                            {{-- style="height: 180px; object-fit: cover;"> --}}
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $item->nama }}</h5>
                                <p class="card-text text-muted small mb-2">
                                    {{ Str::words($item->deskripsi, 10, '...') ?? 'Deskripsi tidak tersedia.' }}
                                </p>
                                {{-- Informasi Harga dan Stok --}}

                                <ul class="list-unstyled small mb-3">
                                    <li><strong>Harga:</strong> {{ rupiah($item->harga) }} / 500 Kg</li>
                                    <li><strong>Stok:</strong> {{ format_stok($item->stok) }}</li>
                                </ul>
                                {{-- Form Tambah ke Keranjang --}}
                                <form action="{{ route('cart.add') }}" method="POST" class="mt-auto mb-2">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->id }}">
                                    <button type="submit" class="btn btn-success w-100">Tambah ke Keranjang</button>
                                </form>

                                {{-- Form Beli Sekarang --}}
                                <form action="{{ route('cart.buyNow') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->id }}">
                                    <input type="hidden" name="jumlah" value="1"> {{-- atau input sesuai jumlah yg dibeli --}}
                                    <button type="submit" class="btn btn-primary w-100">Beli Sekarang</button>
                                </form>

                                {{-- Tombol Lihat Detail --}}
                                <button type="button" class="btn btn-outline-secondary w-100 mt-2" data-bs-toggle="modal"
                                    data-bs-target="#productModal{{ $item->id }}">
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Detail Produk --}}
                    <div class="modal fade" id="productModal{{ $item->id }}" tabindex="-1"
                        aria-labelledby="productModalLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold" id="productModalLabel{{ $item->id }}">
                                        {{ $item->nama }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body row">
                                    <div class="col-md-5 mb-3 mb-md-0">
                                        <img src="{{ asset_or_default($item->gambar) }}"
                                            class="card-img-top" alt="{{ $item->nama }}">

                                    </div>
                                    <div class="col-md-7">
                                        <h6 class="fw-semibold mb-2">Deskripsi</h6>
                                        <div class="deskripsi-produk">
                                            {!! nl2br(e($item->deskripsi)) !!}
                                        </div>



                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item px-0 d-flex justify-content-between">
                                                <strong>Harga</strong>
                                                <span>{{ rupiah($item->harga) }} / 500 Kg</span>
                                            </li>
                                            <li class="list-group-item px-0 d-flex justify-content-between">
                                                <strong>Stok</strong>
                                                <span>{{ format_stok($item->stok) }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
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
