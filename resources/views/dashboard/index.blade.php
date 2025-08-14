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
                        'label' => 'Total Produk',
                        'value' => $totalProduk + $totalProdukEksternal,
                        'sub' => "Internal: $totalProduk | Eksternal: $totalProdukEksternal",
                        'icon' => 'fas fa-boxes',
                        'bg' => 'bg-info text-white',
                    ],
                    [
                        'label' => 'Total Transaksi',
                        'value' => $totalTransaksi,
                        'icon' => 'fas fa-shopping-cart',
                        'bg' => 'bg-danger text-white',
                    ],
                    [
                        'label' => 'Kebun & Petak',
                        'value' => $totalKebun,
                        'sub' => "Kebun: $totalKebun | Petak Kebun: $totalPetak",
                        'icon' => 'fas fa-tree',
                        'bg' => 'bg-success-subtle text-success',
                    ],
                    [
                        'label' => 'Jumlah Konten',
                        'value' => $totalKonten,
                        'icon' => 'fas fa-newspaper',
                        'bg' => 'bg-danger-subtle text-danger',
                    ],
                    [
                        'label' => 'Jumlah Panen (Bulan Ini)',
                        'value' => format_stok($totalPanen),
                        'icon' => 'fas fa-tractor',
                        'bg' => 'bg-success text-white',
                    ],
                    [
                        'label' => 'Jumlah Bibit (Bulan Ini)',
                        'value' => format_jumlah_tanam($totalBibit),
                        'icon' => 'fas fa-leaf',
                        'bg' => 'bg-primary-subtle text-primary',
                    ],
                    [
                        'label' => 'Laba (Bulan Ini)',
                        'value' => rupiah($totalPendapatan - $totalPengeluaran),
                        'sub' =>
                            'Pendapatan: ' . rupiah($totalPendapatan) . ' | Pengeluaran: ' . rupiah($totalPengeluaran),
                        'icon' => 'fas fa-dollar-sign',
                        'bg' => 'bg-success text-white',
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
                                @if (isset($card['sub']))
                                    <small>{{ $card['sub'] }}</small>
                                @endif
                            </div>
                            <i class="{{ $card['icon'] }} fa-2x"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Chart Statistik Keuangan -->
        <div class="card bg-white shadow-sm mb-4">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="fas fa-chart-line me-2"></i> Statistik Keuangan (6 Bulan Terakhir)
            </div>
            <div class="card-body">
                <canvas id="chartKeuanganBulanan" height="120" data-chart='@json($chartKeuanganBulanan)'">
                </canvas>
            </div>
        </div>

          <!-- Chart Statistik Keuangan tahunan -->
        <div class="card bg-white shadow-sm mb-4">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="fas fa-chart-line me-2"></i> Statistik Keuangan Tahunan
            </div>
            <div class="card-body">
                <canvas id="chartKeuanganTahunan" height="120" data-chart='@json($ChartKeuanganTahunan)'> </canvas>
            </div>
        </div>

        <!-- Chart Panen & Tanaman -->
        <div class="card bg-white shadow-sm mb-4">
            <div class="card-header bg-warning text-dark fw-bold">
                <i class="fas fa-seedling me-2"></i> Statistik Panen & Tanaman
            </div>
            <div class="card-body">
                <canvas id="chartPanenTanaman" height="120" data-chart="{{ json_encode($chartPanenTanaman) }}">
                </canvas>
            </div>
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
                                <td>{{ format_tanggal($log->created_at, 'd F Y') }}</td>
                                <td>{{ format_tanggal($log->created_at, 'H:i') }}</td>
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
