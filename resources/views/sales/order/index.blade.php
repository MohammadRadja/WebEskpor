@extends('layout.index')

@section('content')
<div class="card">
    <div class="card-header card-header-dark d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-table me-2"></i>
            <strong>Daftar Pesanan</strong>
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
                        <th><i class="fas fa-calendar me-1"></i>Nama Pembeli</th>
                        <th><i class="fas fa-store me-1"></i>Tlpn</th>
                        <th><i class="fas fa-money-bill me-1"></i>Alamat</th>
                        <th><i class="fas fa-seedling me-1"></i>Negara</th>
                        <th><i class="fas fa-calculator me-1"></i>Ongkir</th>
                        <th><i class="fas fa-calculator me-1"></i>Status</th>
                        <th><i class="fas fa-calculator me-1"></i>Sub total</th>
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
                        <td>Rp 750,000</td>
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
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection