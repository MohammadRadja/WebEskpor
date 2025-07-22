@extends('layouts.panel.index')

@section('content')
    <div class="container-fluid py-4 min-vh-100">
        <!-- Judul Dashboard -->
        <h1 class="h3 mb-4 text-success">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </h1>

        <!-- Statistik Utama -->
        <div class="row mb-4">
            @php
                $statCards = [
                    [
                        'label' => 'Total Pengguna',
                        'value' => $totalUsers,
                        'icon' => 'fas fa-users',
                        'bg' => 'bg-primary text-white',
                    ],
                    [
                        'label' => 'Total Produk Internal',
                        'value' => $totalProduk,
                        'icon' => 'fas fa-box',
                        'bg' => 'bg-info text-white',
                    ],
                    [
                        'label' => 'Total Produk Eksternal',
                        'value' => $totalProdukEksternal,
                        'icon' => 'fas fa-cubes',
                        'bg' => 'bg-warning text-white',
                    ],
                    [
                        'label' => 'Total Transaksi',
                        'value' => $totalTransaksi,
                        'icon' => 'fas fa-shopping-cart',
                        'bg' => 'bg-danger text-white',
                    ],
                    [
                        'label' => 'Total Pendapatan',
                        'value' => 'Rp' . number_format($totalPendapatan ?? 0, 0, ',', '.'),
                        'icon' => 'fas fa-dollar-sign',
                        'bg' => 'bg-success text-white',
                    ],
                    [
                        'label' => 'Jumlah Kebun',
                        'value' => $totalKebun,
                        'icon' => 'fas fa-tree',
                        'bg' => 'bg-success-subtle text-success',
                    ],
                    [
                        'label' => 'Jumlah Petak Kebun',
                        'value' => $totalPetak,
                        'icon' => 'fas fa-border-style',
                        'bg' => 'bg-info-subtle text-info',
                    ],
                    [
                        'label' => 'Jumlah Tanaman',
                        'value' => $totalTanaman,
                        'icon' => 'fas fa-seedling',
                        'bg' => 'bg-warning-subtle text-warning',
                    ],
                    [
                        'label' => 'Jumlah Bibit',
                        'value' => $totalBibit,
                        'icon' => 'fas fa-leaf',
                        'bg' => 'bg-primary-subtle text-primary',
                    ],
                    [
                        'label' => 'Jumlah Konten',
                        'value' => $totalKonten,
                        'icon' => 'fas fa-newspaper',
                        'bg' => 'bg-danger-subtle text-danger',
                    ],
                ];
            @endphp
            @foreach ($statCards as $card)
                <div class="col-md-4 col-lg-3 mb-3">
                    <div class="card {{ $card['bg'] }} h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">{{ $card['value'] }}</h4>
                                <p class="mb-0">{{ $card['label'] }}</p>
                            </div>
                            <i class="{{ $card['icon'] }} fa-2x"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Log Aktivitas -->
        <div class="card bg-white shadow-sm">
            <div class="card-header bg-success text-white fw-bold">
                <i class="fas fa-history me-2"></i> Log Aktivitas Terbaru
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-success text-dark">
                        <tr>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Waktu</th>
                            <th scope="col">Pengguna</th>
                            <th scope="col">Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('d F Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }}</td>
                                <td>{{ $log->causer ?? 'System' }}</td>
                                <td>{{ $log->description }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada log aktivitas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
