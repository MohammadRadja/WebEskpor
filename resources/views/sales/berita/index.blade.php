@extends('layout.index')

@section('content')
<h1 class="mt-4 text-success fw-bold mb-1">
    <i class="fas fa-newspaper me-2"></i>
    Kelola Berita
</h1>

<ol class="breadcrumb mb-4 breadcrumb-dark">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none" style="color: #00ff88;">
            <i class="fas fa-home me-1"></i>
            Dashboard
        </a>
    </li>
    <li class="breadcrumb-item active">
        <i class="fas fa-newspaper me-1"></i>
        Kelola Berita
    </li>
</ol>

<div class="d-flex gap-2 m-2">
    <a class="btn btn-green" href="{{route('sales.berita.add')}}">
        <i class="fas fa-plus me-1"></i>
        Tambah Berita
    </a>
</div>
<div class="card">
    <div class="card-header card-header-dark d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-newspaper me-2"></i>
            <strong>Daftar Berita</strong>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-outline-green" onclick="exportData()">
                <i class="fas fa-download me-1"></i>
                Export
            </button>
            <button class="btn btn-sm btn-outline-green" onclick="refreshTable()">
                <i class="fas fa-sync me-1"></i>
                Refresh
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table able-hover" id="seedlingTable">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag me-1"></i>No</th>
                        <th><i class="fas fa-calendar me-1"></i>Judul Berita</th>
                        <th><i class="fas fa-store me-1"></i>Gambar</th>
                        <th><i class="fas fa-calendar me-1"></i>Tanggal Dibuat</th>
                        <th><i class="fas fa-cogs me-1"></i>Aksi</th>
                    </tr>
                </thead>
                <tbody id="seedlingTableBody">
                    <!-- Sample data -->
                    <tr>
                        <td>1</td>
                        <td>Orang gila Kecebur</td>
                        <td>
                            <img src="{{asset('assets/img/log1.svg')}}" alt="contoh" style="width: 100;">
                        </td>
                        <td>17 - 07 2025</td>
                        <td>
                            <a class="btn btn-sm btn-outline-green me-1" href="{{route('sales.berita.edit')}}">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteSeedling(1)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection