@extends('layouts.guest.index')
@section('title', 'Form Pemesanan - PT.RAJAWALI PRIMA ANDALAS')
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
                <h2 class="mb-4 text-success">Form Pemesanan</h2>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <h5>Daftar Produk:</h5>
                            <ul>
                                @foreach ($cartItems as $item)
                                    <li>{{ $item->produk->nama }} ({{ $item->quantity }}) -
                                        {{ rupiah($item->produk->harga) }}</li>
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
                                    <input type="number" name="jumlah" class="form-control" min="1"
                                        value="{{ $totalJumlah }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Total Berat</label>
                                    <input type="text" name="total_berat" class="form-control"
                                        value="{{ format_stok($totalBerat) }}" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jenis Pengiriman</label>
                                <select name="jenis_pengiriman" class="form-select" required>
                                    <option value="ditanggung_pembeli">Ditanggung Pembeli</option>
                                    <option value="ditanggung_penjual">Ditanggung Penjual</option>
                                    <option value="ditanggung_bersama">Ditanggung Bersama</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Total Harga <small class="text-muted">*Belum Termasuk
                                        Ongkir</small></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="total_harga" class="form-control"
                                        value="{{ $totalHarga }}" readonly>
                                </div>
                                <small class="text-danger">
                                    *Catatan: Total harga di atas <b>belum termasuk biaya pengiriman</b>.
                                    Admin akan mengkonfirmasi biaya pengiriman dan mengirimkan nomor resi setelah pesanan
                                    diproses.
                                </small>
                            </div>

                            <input type="hidden" name="no_resi" value="">
                            <input type="hidden" name="id_pelanggan" value="{{ auth()->user()->id }}">

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Proses Pesanan</button>
                                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
