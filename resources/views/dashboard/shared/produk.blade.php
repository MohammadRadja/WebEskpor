@extends('layouts.panel.index')
@section('title', 'Kelola Produk')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between mb-4">
            <div>
                <h2 class="text-success fw-bold"><i class="fas fa-box me-2"></i>Produk</h2>
                <p class="text-muted mb-0">Daftar produk hasil panen</p>
            </div>
            <div>
                <a href="{{ route('produk.export.excel') }}" class="btn btn-outline-success me-2">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
                <button class="btn btn-success" data-crud="add" data-method="POST" data-title="Tambah Produk"
                    data-url="{{ route('produk.store') }}"
                    data-fields='{
                        "nama": {"label": "Nama Produk"},
                        "id_tanaman": {"label": "Tanaman", "type": "select", "options": "tanamanOptions"},
                        "stok": {"label": "Stok"},
                        "harga": {"label": "Harga"},
                        "deskripsi": {"label": "Deskripsi"},
                        "gambar": {"label": "Gambar", "type": "file"}
                    }'>
                    <i class="fas fa-plus me-1"></i> Tambah Produk
                </button>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0 text-success"><i class="fas fa-leaf me-2"></i>Daftar Produk</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Nama</th>
                                <th>Tanaman</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th>Deskripsi</th>
                                <th>Gambar</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produk as $p)
                                <tr>
                                    <td>{{ $p->nama }}</td>
                                    <td>{{ $p->tanaman->nama ?? '-' }}</td>
                                    <td>{{ format_stok($p->stok) }}</td>
                                    <td>{{ rupiah($p->harga) }}</td>
                                    <td>{{ $p->deskripsi }}</td>
                                    <td>
                                        @if ($p->gambar)
                                            <img src="{{ asset($p->gambar) }}" width="60" class="img-thumbnail">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-success me-1" data-crud="edit"
                                            data-title="Edit Produk" data-method="PUT"
                                            data-url="{{ route('produk.update', $p->id) }}"
                                            data-fields='{
                                                "nama": {"label": "Nama Produk", "value": "{{ $p->nama }}"},
                                                        "id_tanaman": {"label": "Tanaman", "value": "{{ $p->id_tanaman }}", "type": "select", "options": "tanamanOptions"},
                                                "stok": {"label": "Stok", "value": "{{ $p->stok }}"},
                                                "harga": {"label": "Harga", "value": "{{ $p->harga }}"},
                                                "deskripsi": {"label": "Deskripsi", "value": "{{ $p->deskripsi }}"},
                                                "gambar": {"label": "Gambar", "type": "file"}
                                            }'>
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-crud="delete"
                                            data-title="Hapus Produk" data-method="DELETE"
                                            data-url="{{ route('produk.destroy', $p->id) }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Belum ada produk.</td>
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
        window.tanamanOptions = @json($tanamanList);
    </script>
@endpush
