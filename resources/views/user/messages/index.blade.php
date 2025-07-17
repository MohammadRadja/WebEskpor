@extends('user.layout.index')

@section('title', 'Message')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Daftar Pesan</h3>

    {{-- Flash Message contoh --}}
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Pesan berhasil dikirim!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    {{-- Pesan 1 --}}
    <div class="list-group mb-3">
        <div class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">Notifikasi Pembayaran</h5>
                <small>5 menit yang lalu</small>
            </div>
            <p class="mb-1">Pembayaran Anda telah berhasil dikonfirmasi.</p>
            <small>Dari: Admin Toko</small>
        </div>

        {{-- Pesan 2 --}}
        <div class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">Pesanan Dikirim</h5>
                <small>2 jam yang lalu</small>
            </div>
            <p class="mb-1">Pesanan Anda sedang dalam perjalanan ke alamat tujuan.</p>
            <small>Dari: Sistem Pengiriman</small>
        </div>

        {{-- Pesan 3 --}}
        <div class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">Penilaian Produk</h5>
                <small>1 hari yang lalu</small>
            </div>
            <p class="mb-1">Berikan penilaian untuk produk yang telah Anda beli.</p>
            <small>Dari: Customer Service</small>
        </div>
    </div>

    {{-- Tidak ada pesan --}}
    {{--
  <div class="alert alert-info">Tidak ada pesan saat ini.</div> 
  --}}
</div>
@endsection