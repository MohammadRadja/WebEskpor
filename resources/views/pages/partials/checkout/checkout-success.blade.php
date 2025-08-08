@extends('layouts.guest.index')

@section('content')
    <div class="container my-4">
        <div class="card shadow-lg">
            <div class="card-header bg-success text-white">
                <h4>🎉 Pembayaran Berhasil!</h4>
            </div>
            <div class="card-body">

                {{-- 👤 Detail Pelanggan --}}
                <h6 class="border-bottom pb-2 mb-3">👤 Detail Pelanggan</h6>
                <table class="table table-sm table-striped">
                    <tr>
                        <th width="30%">Nama Pelanggan</th>
                        <td>{{ $transaksi->pelanggan->username ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $transaksi->pelanggan->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $transaksi->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $transaksi->telepon ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Negara</th>
                        <td>{{ $transaksi->negara ?? '-' }}</td>
                    </tr>
                </table>

                {{-- 📦 Detail Transaksi --}}
                <h6 class="border-bottom pb-2 mt-4 mb-3">📦 Detail Transaksi</h6>
                <table class="table table-sm table-bordered">
                    <tr>
                        <th width="30%">ID Transaksi</th>
                        <td>{{ $transaksi->id }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        @php
                            $badgeColor = match ($transaksi->status) {
                                'dibayar' => 'success',
                                'proses' => 'warning',
                                'gagal' => 'danger',
                                'expired' => 'secondary',
                                default => 'info',
                            };
                        @endphp
                        <td><span class="badge bg-{{ $badgeColor }}">{{ ucfirst($transaksi->status) }}</span></td>
                    </tr>
                    <tr>
                        <th>Total Harga</th>
                        <td><strong>Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong></td>
                    </tr>
                </table>

                {{-- 📮 Informasi Pengiriman --}}
                <h6 class="border-bottom pb-2 mt-4 mb-3">📮 Informasi Pengiriman</h6>
                <table class="table table-sm table-bordered">
                    <tr>
                        <th width="30%">Jenis Pengiriman</th>
                        <td>{{ ucwords(str_replace('_', ' ', $transaksi->jenis_pengiriman)) }}</td>
                    </tr>
                    <tr>
                        <th>Biaya Pengiriman</th>
                        <td>{{ rupiah($transaksi->biaya_pengiriman) }}</td>
                    </tr>
                </table>

                {{-- 🛒 Detail Produk --}}
                <h6 class="border-bottom pb-2 mt-4 mb-3">🛒 Detail Produk</h6>
                @if ($transaksi->detailTransaksi->count() > 0)
                    <table class="table table-sm table-hover">
                        @foreach ($transaksi->detailTransaksi as $detail)
                            <tr>
                                <th width="30%">Nama Produk</th>
                                <td>{{ $detail->produk->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Deskripsi Produk</th>
                                <td>{{ $detail->produk->deskripsi ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah</th>
                                <td>{{ $detail->jumlah }}</td>
                            </tr>
                            <tr>
                                <th>Berat Barang</th>
                                <td>{{ format_stok($detail->jumlah * 500) }}</td>
                            </tr>
                            <tr>
                                <th>Harga Barang</th>
                                <td>{{ rupiah($detail->harga_satuan) }}</td>
                            </tr>
                            <tr>
                                <th>Subtotal</th>
                                <td><strong>{{ rupiah($detail->sub_total) }}</strong>
                                </td>
                            </tr>
                            <tr class="table-secondary">
                                <td colspan="2"></td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <p class="text-muted text-center">Tidak ada detail produk.</p>
                @endif

            </div>

            <div class="card-footer text-end">
                <a href="{{ route('message.index') }}" class="btn btn-success">Kembali</a>
            </div>
        </div>
    </div>
@endsection
