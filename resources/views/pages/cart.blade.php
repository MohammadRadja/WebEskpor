@extends('layouts.guest.index')
@section('title', 'CONTACT-PT.RAJAWALI PRIMA ANDALAS')
@section('content')

<div class="container-fluid px-4 py-3">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex align-items-center mb-4">
                <h2 class="mb-0 text-success fw-bold">Keranjang Belanja</h2>
            </div>

            <!-- Success Message -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Cart Content -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    @php $total = 0; @endphp

                    @forelse ($cart as $id => $item)
                    @php $total += $item['harga'] * $item['quantity']; @endphp

                    <div class="row align-items-center p-3 border-bottom">
                        <!-- Product Name -->
                        <div class="col-md-3">
                            <h6 class="mb-1 fw-semibold">{{ $item['nama'] }}</h6>
                            <small class="text-muted">ID: {{ $id }}</small>
                        </div>

                        <!-- Quantity Update -->
                        <div class="col-md-2">
                            <form action="{{ route('cart.update') }}" method="POST" class="d-flex align-items-center">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $id }}">
                                <div class="input-group input-group-sm">
                                    <input type="number"
                                        name="quantity"
                                        value="{{ $item['quantity'] }}"
                                        min="1"
                                        class="form-control text-center"
                                        style="max-width: 70px;">
                                    <button type="submit" class="btn btn-outline-success btn-sm">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Unit Price -->
                        <div class="col-md-2 text-center">
                            <span class="fw-semibold">Rp{{ number_format($item['harga'], 0, ',', '.') }}</span>
                        </div>

                        <!-- Total Price -->
                        <div class="col-md-3 text-center">
                            <span class="fw-bold text-success fs-6">
                                Rp{{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- Remove Button -->
                        <div class="col-md-2 text-end">
                            <form action="{{ route('cart.remove') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $id }}">
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    @empty
                    <div class="text-center py-5">
                        <i class="bi bi-cart-x display-1 text-muted mb-3"></i>
                        <h5 class="text-muted">Keranjang Belanja Kosong</h5>
                        <p class="text-muted mb-4">Belum ada produk yang ditambahkan ke keranjang</p>
                        <a href="{{ url('/product') }}" class="btn btn-primary">
                            <i class="bi bi-shop me-2"></i>Mulai Berbelanja
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Cart Summary -->
            @if(count($cart))
            <div class="row mt-4">
                <div class="col-md-8"></div>
                <div class="col-md-4">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Ringkasan Belanja</h5>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal ({{ count($cart) }} item)</span>
                                <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between mb-3">
                                <strong>Total</strong>
                                <strong class="text-success fs-5">Rp{{ number_format($total, 0, ',', '.') }}</strong>
                            </div>

                            <div class="d-grid gap-2">
                                <a href="{{route('checkout.form')}}" class="btn btn-primary btn-lg">
                                    <i class="bi bi-credit-card me-2"></i>Lanjut ke Checkout
                                </a>
                                <a href="{{ url('/product') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Lanjut Belanja
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 12px;
    }

    .btn {
        border-radius: 8px;
    }

    .input-group .form-control {
        border-radius: 6px 0 0 6px;
    }

    .input-group .btn {
        border-radius: 0 6px 6px 0;
    }

    .alert {
        border-radius: 10px;
        border: none;
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }

    @media (max-width: 768px) {
        .row.align-items-center.p-3>div {
            margin-bottom: 10px;
        }

        .col-md-2.text-end {
            text-align: center !important;
        }

        .col-md-2.text-center,
        .col-md-3.text-center {
            text-align: center !important;
        }
    }
</style>






@endsection