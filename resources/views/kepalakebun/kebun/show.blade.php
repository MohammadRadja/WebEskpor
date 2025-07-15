@extends('kepalakebun.layout.index')
@section('title', 'Kelola Kebun')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-success fw-bold mb-1">
                <i class="fas fa-seedling me-2"></i>Kelola Kebun
            </h2>
            <p class="text-muted mb-0">Kelola semua kebun dan petakan dengan mudah</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="#" class="text-decoration-none text-success">Dashboard</a>
                </li>
                <li class="breadcrumb-item active text-dark" aria-current="page">Kelola Kebun</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- Daftar Kebun Section -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #212529 0%, #343a40 100%);">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2 text-success"></i>Daftar Kebun
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="datatablesSimple" class="table table-hover mb-0">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th class="fw-semibold text-dark border-0">
                                        <i class="fas fa-tag me-1 text-success"></i>Nama Kebun
                                    </th>
                                    <th class="fw-semibold text-dark border-0">
                                        <i class="fas fa-map-marker-alt me-1 text-success"></i>Lokasi
                                    </th>
                                    <th class="fw-semibold text-dark border-0 text-center">
                                        <i class="fas fa-cogs me-1 text-success"></i>Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($kebun->count() > 0)
                                @foreach($kebun as $item)
                                <tr class="border-bottom">
                                    <td class="px-4 py-3 fw-semibold text-dark">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px;">
                                                <i class="fas fa-leaf text-white"></i>
                                            </div>
                                            {{ $item->nama }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-light text-dark border">
                                            <i class="fas fa-map-marker-alt me-1 text-success"></i>{{ $item->lokasi }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('petakan.show', $item->id) }}"
                                                class="btn btn-sm btn-success fw-semibold px-3"
                                                title="Kelola Petakan">
                                                <i class="fas fa-cogs me-1"></i>Kelola
                                            </a>
                                            <button type="button"
                                                class="btn btn-sm btn-outline-success btn-edit-kebun"
                                                data-id="{{ $item->id }}"
                                                data-nama="{{ $item->nama }}"
                                                data-lokasi="{{ $item->lokasi }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editKebunModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button"
                                                class="btn btn-sm btn-outline-dark"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $item->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="3" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-seedling fa-4x mb-3 text-success opacity-50"></i>
                                            <h5 class="text-dark">Belum ada kebun</h5>
                                            <p class="mb-0">Tambahkan kebun pertama untuk memulai</p>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                            <tfoot style="background-color: #f8f9fa;">
                                <tr>
                                    <th class="fw-semibold text-dark border-0">
                                        <i class="fas fa-tag me-1 text-success"></i>Nama Kebun
                                    </th>
                                    <th class="fw-semibold text-dark border-0">
                                        <i class="fas fa-map-marker-alt me-1 text-success"></i>Lokasi
                                    </th>
                                    <th class="fw-semibold text-dark border-0 text-center">
                                        <i class="fas fa-cogs me-1 text-success"></i>Aksi
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Tambah Kebun -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #198754 0%, #20c997 100%);">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus me-2"></i>Tambah Kebun Baru
                    </h5>
                </div>
                <div class="card-body" style="background-color: #f8f9fa;">
                    <form action="{{route('kebun.store')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-tag me-1 text-success"></i>Nama Kebun
                            </label>
                            <input type="text"
                                name="nama"
                                class="form-control border-success"
                                placeholder="Masukkan nama kebun"
                                required
                                style="border-width: 2px;">
                            <div class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>Contoh: Kebun Sayur Utara
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-map-marker-alt me-1 text-success"></i>Lokasi
                            </label>
                            <input type="text"
                                name="lokasi"
                                class="form-control border-success"
                                placeholder="Masukkan lokasi kebun"
                                required
                                style="border-width: 2px;">
                            <div class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>Contoh: Jl. Raya Pertanian No. 123
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold py-2">
                            <i class="fas fa-plus me-2"></i>Tambah Kebun
                        </button>
                    </form>
                </div>
            </div>

            <!-- Statistik Kebun -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #212529 0%, #343a40 100%);">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2 text-success"></i>Statistik Kebun
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-12 mb-3">
                            <div class="bg-success bg-opacity-10 rounded-3 p-3">
                                <i class="fas fa-seedling fa-2x text-success mb-2"></i>
                                <h4 class="text-success fw-bold mb-0">{{ $kebun->count() }}</h4>
                                <small class="text-muted">Total Kebun</small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="bg-dark bg-opacity-10 rounded-3 p-3">
                                <i class="fas fa-th-large fa-2x text-dark mb-2"></i>
                                <h4 class="text-dark fw-bold mb-0">
                                    {{ $kebun->sum(function($item) { return $item->petakan->count(); }) }}
                                </h4>
                                <small class="text-muted">Total Petakan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('kepalakebun.kebun.partial.editModal')
@include('kepalakebun.kebun.partial.hapusModal')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tableBody = document.querySelector('#datatablesSimple tbody');
        const editForm = document.getElementById('formEditKebun');
        const namaInput = document.getElementById('editNama');
        const lokasiInput = document.getElementById('editLokasi');
        const modalEdit = document.getElementById('editKebunModal');

        tableBody.addEventListener('click', function(e) {
            const target = e.target.closest('.btn-edit-kebun');
            if (!target) return;

            const id = target.dataset.id;
            const nama = target.dataset.nama;
            const lokasi = target.dataset.lokasi;

            editForm.action = `/kebun/${id}/update`;
            namaInput.value = nama;
            lokasiInput.value = lokasi;
        });

        modalEdit.addEventListener('hidden.bs.modal', function() {
            editForm.reset();
            editForm.action = '#';
        });
    });
</script>
@endsection