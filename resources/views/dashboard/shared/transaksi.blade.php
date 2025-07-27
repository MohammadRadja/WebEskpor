@extends('layouts.panel.index')
@section('title', 'Kelola Transaksi')

@section('content')
    <div class="container-fluid py-4">

        <!-- Header -->
        <div class="mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                <div>
                    <h2 class="text-success fw-bold mb-1">
                        <i class="fas fa-shopping-cart me-2"></i>Kelola Transaksi
                    </h2>
                    <p class="text-muted mb-0">Data transaksi pelanggan</p>
                </div>
            </div>
        </div>

        <!-- Tabel Transaksi -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0 text-success"><i class="fas fa-list me-2"></i>Daftar Transaksi</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-sm align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Nama Pembeli</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th>Negara</th>
                                <th>Jumlah</th>
                                <th>Total Harga</th>
                                <th>Biaya Pengiriman</th>
                                <th>Status</th>
                                <th>Bukti Pembayaran</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksi as $t)
                                <tr>
                                    <td>{{ $t->pelanggan->username }}</td>
                                    <td>{{ $t->telepon }}</td>
                                    <td>{{ $t->alamat }}</td>
                                    <td>{{ $t->negara }}</td>
                                    <td>{{ format_stok($t->jumlah) }}</td>
                                    <td>{{ rupiah($t->total_harga) }}</td>
                                    <td>{{ rupiah($t->biaya_pengiriman) }}</td>
                                    <td><span class="badge bg-success">{{ ucfirst($t->status) }}</span></td>
                                    <td>
                                        @if ($t->bukti_pembayaran)
                                            <a href="{{ asset_or_default('uploads/bukti_pembayaran/' . $t->bukti_pembayaran) }}"
                                                class="btn btn-sm btn-outline-primary" target="">Lihat</a>
                                        @else
                                            <img src="{{ asset('assets/img/default.png') }}" alt="No Bukti" width="40">
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-wrap justify-content-center gap-1">
                                            <!-- Tombol Detail -->
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                data-bs-target="#detailModal{{ $t->id }}" title="Lihat Detail">
                                                <i class="fas fa-info-circle"></i>
                                            </button>

                                            @if ($t->status === 'proses')
                                                <!-- Tombol Approve -->
                                                <form action="{{ route('transaksi.approve', $t->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-success"
                                                        title="Setujui Transaksi">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>

                                                <!-- Tombol Reject -->
                                                <form action="{{ route('transaksi.reject', $t->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        title="Tolak Transaksi">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4 text-muted">Belum ada data transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Transaksi -->
    @foreach ($transaksi as $t)
        <div class="modal fade" id="detailModal{{ $t->id }}" tabindex="-1"
            aria-labelledby="detailModalLabel{{ $t->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title text-success">
                            <i class="fas fa-info-circle me-2"></i>Detail Transaksi - {{ $t->pelanggan->username }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produk</th>
                                        <th>Jumlah</th>
                                        <th>Harga Satuan</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($t->detailTransaksi as $d)
                                        <tr>
                                            <td>{{ $d->produk->nama }}</td>
                                            <td>{{ format_stok($d->jumlah) }}</td>
                                            <td>{{ rupiah($d->harga_satuan) }}</td>
                                            <td>{{ rupiah($d->subtotal) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
