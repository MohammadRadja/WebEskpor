@extends('layouts.panel.index')
@section('title', 'Kelola Transaksi')

@section('content')
    <div class="container-fluid py-4">

        <!-- Header -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-success fw-bold mb-1">
                        <i class="fas fa-shopping-cart me-2"></i>Kelola Transaksi
                    </h2>
                    <p class="text-muted mb-0">Data transaksi pelanggan</p>
                </div>
                <button class="btn btn-success" data-crud="add" data-method="POST" data-title="Tambah Transaksi"
                    data-url="{{ route('transaksi.store') }}"
                    data-fields='{
        "id_pelanggan": {"label": "Nama Pembeli", "type": "select", "options": "pelangganOptions"},
        "telepon": {"label": "Telepon"},
        "alamat": {"label": "Alamat"},
        "negara": {"label": "Negara"},
        "jumlah": {"label": "Jumlah"},
        "total_harga": {"label": "Total Harga"},
        "biaya_pengiriman": {"label": "Biaya Pengiriman"},
        "status": {"label": "Status", "type": "select", "options": ["menunggu", "dibayar", "dikirim", "selesai"]},
        "bukti_pembayaran": {"label": "Bukti Pembayaran", "type": "file"}
    }'>
                    <i class="fas fa-plus me-1"></i> Tambah Transaksi
                </button>

            </div>
        </div>

        <!-- Tabel Transaksi -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0 text-success"><i class="fas fa-list me-2"></i>Daftar Transaksi</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
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
                                    <td>
                                        <span class="badge bg-success">{{ ucfirst($t->status) }}</span>
                                    </td>
                                    <td>
                                        @if ($t->bukti_pembayaran)
                                            <a href="{{ url($t->bukti_pembayaran) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                Lihat
                                            </a>
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
                                                "status": {"label": "Status", "value": "{{ $t->status }}", "type": "select", "options": ["menunggu", "dibayar", "dikirim", "selesai"]}                                            }'>
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
                                    <td colspan="9" class="text-center py-4 text-muted">
                                        Belum ada data transaksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        window.pelangganOptions = @json($pelangganList);
    </script>
@endpush
