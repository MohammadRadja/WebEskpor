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
                                <th>Jenis Pengiriman</th>
                                <th>Biaya Pengiriman</th>
                                <th>No Resi</th>
                                <th>Status</th>
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
                                    <td>{{ ucwords(str_replace('_', ' ', $t->jenis_pengiriman)) }}</td>
                                    <td>{{ rupiah($t->biaya_pengiriman) }}</td>
                                    <td>{{ $t->no_resi }}</td>
                                    <td><span class="badge bg-success">{{ ucfirst($t->status) }}</span></td>
                                    <td class="text-center">
                                        <div class="d-flex flex-wrap justify-content-center gap-1">
                                            <!-- Tombol Detail -->
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                data-bs-target="#detailModal{{ $t->id }}" title="Lihat Detail">
                                                <i class="fas fa-info-circle"></i>
                                            </button>

                                            @if ($t->status === 'menunggu')
                                                <!-- Tombol Isi Pengiriman -->
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#pengirimanModal{{ $t->id }}"
                                                    title="Isi Biaya & Resi">
                                                    <i class="fas fa-shipping-fast"></i>
                                                </button>
                                            @else
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

    <!-- Modal Pengiriman -->
    @foreach ($transaksi as $t)
        <div class="modal fade" id="pengirimanModal{{ $t->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('transaksi.update', $t->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title text-warning"><i class="fas fa-shipping-fast me-2"></i>Pengiriman</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Biaya Pengiriman</label>
                                <input type="number" name="biaya_pengiriman" class="form-control" required min="0">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor Resi</label>
                                <input type="text" name="no_resi" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
