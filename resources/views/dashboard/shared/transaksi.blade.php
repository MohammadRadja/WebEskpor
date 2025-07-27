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
                                    <td>{{ $t->jumlah }}</td>
                                    <td>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($t->biaya_pengiriman, 0, ',', '.') }}</td>
                                    <td><span class="badge bg-success">{{ ucfirst($t->status) }}</span></td>
                                    <td>
                                        @if ($t->bukti_pembayaran)
                                            <a href="{{ url($t->bukti_pembayaran) }}" class="btn btn-sm btn-outline-primary">Lihat</a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-success me-1" data-crud="edit"
                                            data-title="Edit Transaksi" data-method="PATCH"
                                            data-url="{{ route('transaksi.update', $t->id) }}"
                                            data-fields='{
                                                "id_pelanggan": {"label": "Nama Pembeli", "value": "{{ $t->id_pelanggan }}", "type": "select", "options": "pelangganOptions"},
                                                "telepon": {"label": "Telepon", "value": "{{ $t->telepon }}"},
                                                "alamat": {"label": "Alamat", "value": "{{ $t->alamat }}"},
                                                "negara": {"label": "Negara", "value": "{{ $t->negara }}"},
                                                "jumlah": {"label": "Jumlah", "value": "{{ $t->jumlah }}"},
                                                "total_harga": {"label": "Total Harga", "value": "{{ $t->total_harga }}"},
                                                "biaya_pengiriman": {"label": "Biaya Pengiriman", "value": "{{ $t->biaya_pengiriman }}"},
                                                "bukti_pembayaran": {"label": "Bukti Pembayaran", "type": "file"},
                                                "status": {"label": "Status", "value": "{{ $t->status }}", "type": "select", "options": ["menunggu", "dibayar", "dikirim", "selesai"]}
                                            }'>
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-crud="delete"
                                            data-title="Hapus Transaksi" data-method="DELETE"
                                            data-url="{{ route('transaksi.destroy', $t->id) }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
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

        <!-- Tabel Detail Transaksi -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0 text-success"><i class="fas fa-info-circle me-2"></i>Detail Transaksi</h5>
            </div>
            <div class="card-body p-3">
                @forelse($transaksi as $t)
                    <div class="mb-4">
                        <h6 class="text-success fw-bold">
                            <i class="fas fa-user me-2"></i>{{ $t->pelanggan->username }} - {{ ucfirst($t->status) }}
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm mb-2">
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
                @empty
                    <p class="text-muted">Belum ada data transaksi.</p>
                @endforelse
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        window.pelangganOptions = @json($pelangganList);
    </script>
@endpush
