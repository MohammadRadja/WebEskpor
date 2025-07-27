@extends('layouts.panel.index')
@section('title', 'Kelola Produk Eksternal')

@section('content')
    <div class="container-fluid py-4">

        <!-- Header -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-success fw-bold mb-1">
                        <i class="fas fa-handshake me-2"></i>Kelola Produk Eksternal
                    </h2>
                    <p class="text-muted mb-0">Data produk dari mitra eksternal</p>
                </div>
                <button class="btn btn-success" data-crud="add" data-method="POST" data-title="Tambah Produk Eksternal"
                    data-url="{{ route('produk-eksternal.store') }}"
                    data-fields='{
                        "nama_supplier": {"label": "Nama Supplier"},
                        "kontak": {"label": "Kontak"},
                        "id_produk": {"label": "Produk" , "type": "select", "options": "produkList"},
                        "jenis_perjanjian": {"label": "Jenis Perjanjian", "type": "select", "options": ["konsinyasi", "pembelian-putus"]},
                        "komisi": {"label": "Komisi (%)"},
                        "harga_satuan": {"label": "Harga Satuan"},
                        "jumlah": {"label": "Jumlah"},
                        "total_harga": {"label": "Total Harga"},
                        "tanggal_pembelian": {"label": "Tanggal Pembelian", "type": "date"}
                    }'>
                    <i class="fas fa-plus me-1"></i> Tambah Produk Eksternal
                </button>
            </div>
        </div>

        <!-- Tabel Produk Eksternal -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0 text-success"><i class="fas fa-list me-2 text-success"></i>Daftar Produk Eksternal</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Supplier</th>
                                <th>Kontak</th>
                                <th>Produk</th>
                                <th>Jenis Perjanjian</th>
                                <th>Komisi (%)</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>Total Harga</th>
                                <th>Tanggal Pembelian</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produkEksternal as $pe)
                                <tr>
                                    <td>{{ $pe->nama_supplier }}</td>
                                    <td>{{ $pe->kontak }}</td>
                                    <td>{{ $pe->produk->nama ?? '-' }}</td>
                                    <td>{{ ucwords(str_replace('-', ' ', $pe->jenis_perjanjian)) }}</td>
                                    <td>{{ $pe->komisi }}%</td>
                                    <td>{{ rupiah($pe->harga_satuan) }}</td>
                                    <td>{{ format_stok($pe->jumlah) }}</td>
                                    <td>{{ rupiah($pe->total_harga) }}</td>
                                    <td>{{ format_tanggal($pe->tanggal_pembelian) }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-success me-1" data-crud="edit"
                                            data-title="Edit Produk Eksternal" data-method="PATCH"
                                            data-url="{{ route('produk-eksternal.update', $pe->id) }}"
                                            data-fields='{
                                                "nama_supplier": {"label": "Nama Supplier", "value": "{{ $pe->nama_supplier }}"},
                                                "kontak": {"label": "Kontak", "value": "{{ $pe->kontak }}"},
                                                "id_produk": {"label": "Produk", "value": "{{ $pe->id_produk }}", "type": "select", "options": "produkList"},
                                                "jenis_perjanjian": {"label": "Jenis Perjanjian", "value": "{{ $pe->jenis_perjanjian }}", "type": "select", "options": ["konsinyasi", "pembelian-putus"]},
                                                "komisi": {"label": "Komisi (%)", "value": "{{ $pe->komisi }}"},
                                                "harga_satuan": {"label": "Harga Satuan", "value": "{{ $pe->harga_satuan }}"},
                                                "jumlah": {"label": "Jumlah", "value": "{{ $pe->jumlah }}"},
                                                "total_harga": {"label": "Total Harga", "value": "{{ $pe->total_harga }}"},
                                                "tanggal_pembelian": {"label": "Tanggal Pembelian", "value": "{{ $pe->tanggal_pembelian }}" }
                                            }'>
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-crud="delete"
                                            data-title="Hapus Produk Eksternal" data-method="DELETE"
                                            data-url="{{ route('produk-eksternal.destroy', $pe->id) }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4 text-muted">
                                        Belum ada produk eksternal.
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
        window.produkList = @json($produkList);
    </script>
@endpush
