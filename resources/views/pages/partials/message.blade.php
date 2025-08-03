@extends('layouts.guest.index')

@section('title', 'Message')

@section('content')
    <div class="container py-4">
        <h3 class="fw-bold mb-4 text-primary">
            📩 Daftar Pesan
        </h3>

        <!-- Filter -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div class="btn-group">
                <a href="{{ route('message.index') }}"
                    class="btn btn-outline-secondary btn-sm {{ request('status') == '' ? 'active' : '' }}">Semua</a>
                <a href="{{ route('message.index', ['status' => 'dibayar']) }}"
                    class="btn btn-outline-success btn-sm {{ request('status') == 'dibayar' ? 'active' : '' }}">Dibayar</a>
                <a href="{{ route('message.index', ['status' => 'gagal']) }}"
                    class="btn btn-outline-danger btn-sm {{ request('status') == 'gagal' ? 'active' : '' }}">Gagal</a>
                <a href="{{ route('message.index', ['status' => 'proses']) }}"
                    class="btn btn-outline-warning btn-sm {{ request('status') == 'proses' ? 'active' : '' }}">Proses</a>
                <a href="{{ route('message.index', ['status' => 'menunggu']) }}"
                    class="btn btn-outline-info btn-sm {{ request('status') == 'menunggu' ? 'active' : '' }}">Menunggu</a>
            </div>
            <a href="{{ route('message.markAllRead') }}" class="btn btn-primary btn-sm">✅ Tandai Semua Dibaca</a>
        </div>

        @if ($notifications->isEmpty())
            <div class="alert alert-info text-center shadow-sm">Tidak ada pesan saat ini.</div>
        @else
            <div class="row g-3">
                @foreach ($notifications as $notify)
                    @php
                        $status = $notify->transaksi->status ?? '';
                        $badgeColor = match ($status) {
                            'menunggu' => 'secondary',
                            'proses' => 'warning',
                            'dibayar' => 'success',
                            'gagal' => 'danger',
                            'expired' => 'danger',
                            default => 'info',
                        };
                    @endphp

                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100 {{ $notify->is_read ? '' : 'border border-warning' }}">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0 fw-semibold">{{ $notify->title }}</h5>
                                    @if ($status)
                                        <span class="badge bg-{{ $badgeColor }} px-2 py-1">{{ ucfirst($status) }}</span>
                                    @endif
                                </div>

                                <p class="text-muted small flex-grow-1">{{ $notify->message }}</p>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <small class="text-muted">{{ $notify->created_at->diffForHumans() }}</small>
                                    <div class="d-flex gap-2">
                                        @if ($notify->id_transaksi)
                                            <button type="button" class="btn btn-sm btn-outline-info"
                                                data-bs-toggle="modal" data-bs-target="#modalTransaksi{{ $notify->id }}">
                                                <i class="bi bi-info-circle"></i> Detail
                                            </button>
                                        @endif

                                        @if ($status === 'proses')
                                            <form action="{{ route('checkout.xendit') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="id_transaksi"
                                                    value="{{ $notify->transaksi->id }}">
                                                <button type="submit" class="btn btn-sm btn-outline-success">
                                                    <i class="bi bi-credit-card"></i> Bayar
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Detail Transaksi -->
                    @if ($notify->transaksi)
                        <div class="modal fade" id="modalTransaksi{{ $notify->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content shadow-lg">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">🧾 Detail Transaksi</h5>
                                        <button type="button" class="btn-close btn-close-white"
                                            data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">

                                        {{-- 👤 Detail Pelanggan --}}
                                        <h6 class="border-bottom pb-2 mb-3">👤 Detail Pelanggan</h6>
                                        <table class="table table-sm table-striped">
                                            <tr>
                                                <th width="30%">Nama Pelanggan</th>
                                                <td>{{ $notify->user->username ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td>{{ $notify->user->email ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Alamat</th>
                                                <td>{{ $notify->transaksi->alamat ?? '-' }}</td>
                                            </tr>
                                        </table>

                                        {{-- 📦 Detail Transaksi --}}
                                        <h6 class="border-bottom pb-2 mt-4 mb-3">📦 Detail Transaksi</h6>
                                        <table class="table table-sm table-bordered">
                                            <tr>
                                                <th width="30%">ID Transaksi</th>
                                                <td>{{ $notify->transaksi->id }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td><span
                                                        class="badge bg-{{ $badgeColor }}">{{ ucfirst($status) }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Total Harga</th>
                                                <td><strong>{{ rupiah($notify->transaksi->total_harga) }}</strong></td>
                                            </tr>
                                        </table>

                                        {{-- 📮 Informasi Pengiriman --}}
                                        <h6 class="border-bottom pb-2 mt-4 mb-3">📮 Informasi Pengiriman</h6>
                                        <table class="table table-sm table-bordered">
                                            <tr>
                                                <th width="30%">Jenis Pengiriman</th>
                                                <td>{{ ucwords(str_replace('_', ' ', $notify->transaksi->jenis_pengiriman)) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>No Resi</th>
                                                <td>{{ $notify->transaksi->no_resi ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nama Ekspedisi</th>
                                                <td>{{ $notify->transaksi->ekspedisi ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Biaya Pengiriman</th>
                                                <td>{{ rupiah($notify->transaksi->biaya_pengiriman) }}</td>
                                            </tr>
                                        </table>

                                        {{-- 🛒 Detail Produk --}}
                                        <h6 class="border-bottom pb-2 mt-4 mb-3">🛒 Detail Produk</h6>
                                        <table class="table table-sm table-hover">
                                            @php $detail = $notify->transaksi->detailTransaksi->first(); @endphp
                                            @if ($detail)
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
                                                    <td>{{ rupiah($detail->sub_total) }}</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="2" class="text-center text-muted">Tidak ada detail
                                                        produk.</td>
                                                </tr>
                                            @endif
                                        </table>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="mt-4">
                {{ $notifications->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection
