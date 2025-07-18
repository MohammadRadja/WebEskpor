@extends('layouts.panel.index')

@section('content')
<div class="min-vh-100 p-4">
    <h1 class="mt-4 text-success fw-bold mb-1">
        <i class="fas fa-box-open me-2"></i>
        Manajemen Penanaman
    </h1>

    <ol class="breadcrumb mb-4 breadcrumb-dark">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none" style="color: #00ff88;">
                <i class="fas fa-home me-1"></i>
                Dashboard
            </a>
        </li>
        <li class="breadcrumb-item active">
            <i class="fas fa-box-open me-1"></i>
            Manajemen Penanaman
        </li>
    </ol>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4" >
            <div class="card  stats-card" style="background: linear-gradient(135deg, #28a745, #20c997);">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="fs-2 fw-bold">245</div>
                        <div class="fw-bold">Total Bibit</div>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-seedling fa-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card text-white stats-card" style="background: linear-gradient(135deg, #28a745, #20c997);">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="fs-2 fw-bold">12</div>
                        <div class="fw-bold">Penjual Aktif</div>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-store fa-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card text-white stats-card" style="background: linear-gradient(135deg, #155724, #1e7e34);">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="fs-2 fw-bold">Rp 2.5M</div>
                        <div class="fw-bold">Total Investasi</div>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-money-bill-wave fa-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card text-white stats-card" style="background: linear-gradient(135deg, #40e0d0, #00ff88);">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <div class="fs-2 fw-bold">18</div>
                        <div class="fw-bold">Pembelian Bulan Ini</div>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-calendar-alt fa-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Form -->
    <div class="card card-dark mb-4">
        <div class="card-header ">
            <i class="fas fa-plus-circle me-2"></i>
            <strong>Tambah Penanaman Baru</strong>
        </div>
        <div class="card-body">
            <form id="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal_beli" class="form-label form-label-green">
                                <i class="fas fa-calendar me-1"></i>
                                Tanggal Beli
                            </label>
                            <input type="date" class="form-control" id="tanggal_beli" name="tanggal_beli" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_penjual" class="form-label form-label-green">
                                <i class="fas fa-store me-1"></i>
                                Nama Penjual
                            </label>
                            <input type="text" class="form-control" id="nama_penjual" name="nama_penjual" placeholder="Masukkan nama penjual" maxlength="255" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="harga_satuan" class="form-label form-label-green">
                                <i class="fas fa-money-bill me-1"></i>
                                Harga Satuan
                            </label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-dark">Rp</span>
                                <input type="number" class="form-control" id="harga_satuan" name="harga_satuan" placeholder="0" min="0" step="0.01" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="qty" class="form-label form-label-green">
                                <i class="fas fa-seedling me-1"></i>
                                Quantity
                            </label>
                            <input type="number" class="form-control" id="qty" name="qty" placeholder="0" min="1" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="total_harga" class="form-label form-label-green">
                        <i class="fas fa-calculator me-1"></i>
                        Total Harga
                    </label>
                    <div class="input-group">
                        <span class="input-group-text input-group-text-dark">Rp</span>
                        <input type="number" class="form-control" id="total_harga" name="total_harga" readonly>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-green">
                        <i class="fas fa-save me-1"></i>
                        Simpan Penanaman
                    </button>
                    <button type="reset" class="btn btn-outline-green">
                        <i class="fas fa-undo me-1"></i>
                        Reset Form
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card card-dark">
        <div class="card-header card-header-dark d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-2"></i>
                <strong>Daftar Penanaman</strong>
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
                <table class="table table-dark-custom  table-hover" id="seedlingTable">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag me-1"></i>No</th>
                            <th><i class="fas fa-calendar me-1"></i>Tanggal Beli</th>
                            <th><i class="fas fa-store me-1"></i>Nama Penjual</th>
                            <th><i class="fas fa-money-bill me-1"></i>Harga Satuan</th>
                            <th><i class="fas fa-seedling me-1"></i>Quantity</th>
                            <th><i class="fas fa-calculator me-1"></i>Total Harga</th>
                            <th><i class="fas fa-cogs me-1"></i>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="seedlingTableBody">
                        <!-- Sample data -->
                        <tr>
                            <td>1</td>
                            <td>2024-01-15</td>
                            <td>Toko Bibit Sejahtera</td>
                            <td>Rp 15,000</td>
                            <td><span class="badge badge-green">50</span></td>
                            <td>Rp 750,000</td>
                            <td>
                                <button class="btn btn-sm btn-outline-green me-1" onclick="editSeedling(1)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteSeedling(1)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>2024-01-20</td>
                            <td>Bibit Unggul Nusantara</td>
                            <td>Rp 25,000</td>
                            <td><span class="badge badge-green">30</span></td>
                            <td>Rp 750,000</td>
                            <td>
                                <button class="btn btn-sm btn-outline-green me-1" onclick="editSeedling(2)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteSeedling(2)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection