@extends('layouts.panel.index')
@section('title', 'Kelola Kebun')

@section('content')
    <div class="container-fluid py-4">

        <!-- Header -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-start flex-wrap">
                <div class="mb-2">
                    <h2 class="text-success fw-bold mb-1">
                        <i class="fas fa-seedling me-2"></i>Kelola Kebun
                    </h2>
                    <p class="text-muted mb-0">Lihat, tambahkan, atau kelola kebun Anda.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('kebun.export.excel') }}" class="btn btn-outline-success">
                        <i class="fas fa-file-excel me-1"></i> Export Excel
                    </a>
                    <button class="btn btn-success" data-crud="add" data-method="POST" data-title="Tambah Kebun"
                        data-url="{{ route('kebun.store') }}"
                        data-fields='{
                            "nama": {"label": "Nama Kebun"},
                            "lokasi": {"label": "Lokasi"}
                        }'>
                        <i class="fas fa-plus me-1"></i> Tambah Kebun
                    </button>
                </div>
            </div>
        </div>

        <!-- List Kebun -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-success">
                    <i class="fas fa-list me-2"></i>Daftar Kebun
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-center">
                            <tr>
                                <th>Nama Kebun</th>
                                <th>Lokasi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse($kebunList as $k)
                                <tr>
                                    <td>{{ $k->nama }}</td>
                                    <td>{{ $k->lokasi }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-success me-1" data-crud="edit"
                                            data-title="Edit Kebun" data-method="PATCH"
                                            data-url="{{ route('kebun.update', $k->id) }}"
                                            data-fields='{
                                                "nama": {"label": "Nama Kebun", "value": "{{ $k->nama }}"},
                                                "lokasi": {"label": "Lokasi", "value": "{{ $k->lokasi }}"}
                                            }'>
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-crud="delete"
                                            data-title="Hapus Kebun" data-method="DELETE"
                                            data-url="{{ route('kebun.destroy', $k->id) }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        <i class="fas fa-exclamation-circle me-1"></i> Belum ada kebun terdaftar.
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
