@extends('layouts.panel.index')
@section('title', 'Laporan Data')

@section('content')
    <div class="container-fluid py-4">
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-file-alt me-2"></i> Laporan Data</h4>
            </div>
            <div class="card-body">
                <p class="mb-4 text-muted">
                    Berikut adalah daftar jenis laporan yang tersedia. Anda dapat mengunduhnya dalam format
                    <span class="fw-bold">Excel</span>, <span class="fw-bold">CSV</span>, atau <span
                        class="fw-bold">PDF</span>.
                </p>

                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th class="w-75 text-center">Jenis Laporan</th>
                            <th class="w-25 text-center">Export</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $laporan = [
                                'bibit' => ['icon' => 'fas fa-seedling', 'label' => 'Laporan Bibit'],
                                'tanaman' => ['icon' => 'fas fa-leaf', 'label' => 'Laporan Tanaman'],
                                'kebun' => ['icon' => 'fas fa-tree', 'label' => 'Laporan Kebun'],
                                'petak-kebun' => ['icon' => 'fas fa-map', 'label' => 'Laporan Petak Kebun'],
                                'produk' => ['icon' => 'fas fa-box', 'label' => 'Laporan Produk'],
                                'produk-eksternal' => ['icon' => 'fas fa-truck', 'label' => 'Laporan Produk Eksternal'],
                                'transaksi' => ['icon' => 'fas fa-money-bill-wave', 'label' => 'Laporan Transaksi'],
                                'user' => ['icon' => 'fas fa-users', 'label' => 'Laporan Pengguna'],
                            ];
                            $no = 1;
                        @endphp

                        @foreach ($laporan as $jenis => $info)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>
                                    <i class="{{ $info['icon'] }} text-success me-2"></i>
                                    {{ $info['label'] }}
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('laporan.export', ['jenis' => $jenis, 'format' => 'excel']) }}"
                                            class="btn btn-sm btn-outline-success me-3">
                                            <i class="fas fa-file-excel"></i> Excel
                                        </a>
                                        <a href="{{ route('laporan.export', ['jenis' => $jenis, 'format' => 'csv']) }}"
                                            class="btn btn-sm btn-outline-warning me-3">
                                            <i class="fas fa-file-csv"></i> CSV
                                        </a>
                                        <a href="{{ route('laporan.export', ['jenis' => $jenis, 'format' => 'pdf']) }}"
                                            class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-file-pdf"></i> PDF
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
