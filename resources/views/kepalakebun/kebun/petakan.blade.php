@extends('kepalakebun.layout.index')
@section('title', 'Kelola Kebun dan petakan')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="text-success fw-bold mb-1">
                    <i class="fas fa-seedling me-2"></i>Detail Kebun
                </h2>
                <p class="text-muted mb-0">Kelola petakan dalam kebun ini</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="#" class="text-decoration-none text-success">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#" class="text-decoration-none text-success">Kelola Kebun</a>
                    </li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">Detail Kebun</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Informasi Kebun -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #212529 0%, #343a40 100%);">
                <div class="card-body text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="text-success fw-bold mb-3">
                                <i class="fas fa-leaf me-2"></i>{{ $kebun->nama }}
                            </h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-tag text-white"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted">Nama Kebun</small>
                                            <div class="fw-semibold">{{ $kebun->nama }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-map-marker-alt text-white"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted">Lokasi</small>
                                            <div class="fw-semibold">{{ $kebun->lokasi }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="bg-success bg-opacity-25 rounded-3 p-3">
                                <i class="fas fa-seedling fa-3x text-success mb-2"></i>
                                <p class="mb-0 text-success fw-bold">Kebun Aktif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Daftar Petakan -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #212529 0%, #343a40 100%);">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-th-large me-2 text-success"></i>Daftar Petakan
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th class="fw-semibold text-dark border-0">
                                        <i class="fas fa-tag me-1 text-success"></i>Nama
                                    </th>
                                    <th class="fw-semibold text-dark border-0">
                                        <i class="fas fa-ruler me-1 text-success"></i>Ukuran
                                    </th>
                                    <th class="fw-semibold text-dark border-0">
                                        <i class="fas fa-user me-1 text-success"></i>Penanggung Jawab
                                    </th>
                                    <th class="fw-semibold text-dark border-0">
                                        <i class="fas fa-signal me-1 text-success"></i>Status
                                    </th>
                                    <th class="fw-semibold text-dark border-0 text-center">
                                        <i class="fas fa-cogs me-1 text-success"></i>Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kebun->petakan as $petakan)
                                <tr class="border-bottom">
                                    <td class="fw-semibold text-dark">{{ $petakan->nama }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            <i class="fas fa-ruler me-1"></i>{{ $petakan->ukuran }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                                <i class="fas fa-user text-white small"></i>
                                            </div>
                                            <span class="text-dark">{{ $petakan->penanggung_jawab }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($petakan->status == 'aktif')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>{{ ucfirst($petakan->status) }}
                                            </span>
                                        @else
                                            <span class="badge bg-dark">
                                                <i class="fas fa-times me-1"></i>{{ ucfirst($petakan->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="" class="btn btn-sm btn-outline-success" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Yakin ingin menghapus petakan ini?')" 
                                                        class="btn btn-sm btn-outline-dark" 
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-th-large fa-4x mb-3 text-success opacity-50"></i>
                                            <h5 class="text-dark">Belum ada petakan</h5>
                                            <p class="mb-0">Tambahkan petakan pertama untuk kebun ini</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Tambah Petakan -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #198754 0%, #20c997 100%);">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus me-2"></i>Tambah Petakan Baru
                    </h5>
                </div>
                <div class="card-body" style="background-color: #f8f9fa;">
                    <form action="{{ route('petakan.store', $kebun->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-tag me-1 text-success"></i>Nama Petakan
                            </label>
                            <input type="text" 
                                   name="nama" 
                                   class="form-control border-success" 
                                   placeholder="Contoh: Petakan A1" 
                                   required
                                   style="border-width: 2px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-ruler me-1 text-success"></i>Ukuran
                            </label>
                            <input type="text" 
                                   name="ukuran" 
                                   class="form-control border-success" 
                                   placeholder="Contoh: 100m² / 50x20m" 
                                   required
                                   style="border-width: 2px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-user me-1 text-success"></i>Penanggung Jawab
                            </label>
                            <input type="text" 
                                   name="penanggung_jawab" 
                                   class="form-control border-success" 
                                   placeholder="Nama lengkap penanggung jawab" 
                                   required
                                   style="border-width: 2px;">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="fas fa-signal me-1 text-success"></i>Status
                            </label>
                            <select name="status" 
                                    class="form-select border-success" 
                                    required
                                    style="border-width: 2px;">
                                <option value="">Pilih Status</option>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold py-2">
                            <i class="fas fa-plus me-2"></i>Tambah Petakan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Custom CSS untuk tema hitam dan hijau --}}

@endsection