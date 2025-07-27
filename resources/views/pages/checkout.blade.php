@extends('layouts.guest.index')
@section('title', 'CONTACT-PT.RAJAWALI PRIMA ANDALAS')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="col-md-8">
            <h2 class="mb-4 text-succes">Form Pemesanan</h2>

            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h5>Daftar Produk:</h5>
                        <ul>
                            @foreach ($cartItems as $item)
                            <li>
                                {{ $item->produk->nama }} ({{ $item->quantity }}) - Rp{{ number_format($item->produk->harga, 0, ',', '.') }}
                            </li>

                            <!-- Kirim ID cart item agar bisa diproses di TransaksiController -->
                            <input type="hidden" name="checkout_items[]" value="{{ $item->id }}">
                            @endforeach
                        </ul>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="tel" name="telepon" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Negara</label>
                                <select name="negara" class="form-select" required>
                                    <option value="">Pilih Negara</option>
                                    <option value="Indonesia" selected>Indonesia</option>
                                    <option value="Malaysia">Malaysia</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="jumlah" class="form-control" min="1" value="{{ $totalJumlah }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Biaya Pengiriman</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="biaya_pengiriman" class="form-control" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Total Harga</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="total_harga" class="form-control" min="0" value="{{ $totalHarga }}" readonly required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Bukti Pembayaran</label>
                            <input type="file" name="bukti_pembayaran" class="form-control"
                                accept=".jpg,.jpeg,.png,.pdf">
                            <div class="form-text">Format: JPG, PNG, PDF</div>
                        </div>

                        <input type="hidden" name="status" value="menunggu">
                        <input type="hidden" name="id_pelanggan" value="{{ auth()->user()->id }}">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Proses Pesanan</button>
                            <a href="" class="btn btn-outline-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection