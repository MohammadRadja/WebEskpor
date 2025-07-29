@extends('layouts.panel.index')
@section('title', 'Kelola Tanaman')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="text-success fw-bold mb-1">
                    <i class="fas fa-seedling me-2"></i>Kelola Tanaman
                </h2>
                <p class="text-muted">Tambah dan kelola data tanaman</p>
            </div>
            <div>
                <a href="{{ route('tanaman.export.excel') }}" class="btn btn-outline-success me-2">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
                <button class="btn btn-success" data-crud="add" data-method="POST" data-title="Tambah Tanaman"
                    data-url="{{ route('tanaman.store') }}"
                    data-fields='{
        "nama": {"label": "Nama Tanaman"},
        "jenis": {"label": "Jenis", "type": "select", "options": ["sayur", "buah", "rempah", "herbal", "biji", "kacang", "umbi", "hias"]}
    }'>
                    <i class="fas fa-plus me-1"></i> Tambah Tanaman
                </button>

            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0 text-succes"><i class="fas fa-leaf me-2s"></i>Daftar Tanaman</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Nama Tanaman</th>
                                <th>Jenis</th>
                                <th>Stok Barang Jadi</th>
                                <th>Stok Bibit</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tanaman as $t)
                                <tr>
                                    <td>{{ $t->nama }}</td>
                                    <td>{{ ucfirst($t->jenis) }}</td>
                                    <td>{{ format_stok($t->stok_barang_jadi) }}</td>
                                    <td>{{ format_jumlah_tanam($t->stok_bibit) }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-success me-1" data-crud="edit"
                                            data-title="Edit Tanaman" data-method="PATCH"
                                            data-url="{{ route('tanaman.update', $t->id) }}"
                                            data-fields='{
                        "nama": {"label": "Nama Tanaman", "value": "{{ $t->nama }}"},
                        "jenis": {"label": "Jenis", "value": "{{ $t->jenis }}", "type": "select", "options": ["sayur", "buah", "rempah", "herbal", "biji", "kacang", "umbi", "hias"]}
                    }'>
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-crud="delete"
                                            data-title="Hapus Tanaman" data-method="DELETE"
                                            data-url="{{ route('tanaman.destroy', $t->id) }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Belum ada data tanaman.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
