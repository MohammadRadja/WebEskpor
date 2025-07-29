@extends('layouts.guest.index')

@section('title', 'Message')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">📩 Daftar Pesan</h3>

        <!-- Filter -->
        <div class="mb-3 d-flex justify-content-between">
            <div>
                <a href="{{ route('message.index') }}" class="btn btn-outline-secondary btn-sm">Semua</a>
                <a href="{{ route('message.index', ['type' => 'success']) }}"
                    class="btn btn-outline-success btn-sm">Success</a>
                <a href="{{ route('message.index', ['type' => 'error']) }}" class="btn btn-outline-danger btn-sm">Error</a>
                <a href="{{ route('message.index', ['type' => 'warning']) }}"
                    class="btn btn-outline-warning btn-sm">Warning</a>
                <a href="{{ route('message.index', ['type' => 'info']) }}" class="btn btn-outline-info btn-sm">Info</a>
            </div>
            <a href="{{ route('message.markAllRead') }}" class="btn btn-primary btn-sm">✅ Tandai Semua Dibaca</a>
        </div>

        @if ($notifications->isEmpty())
            <div class="alert alert-info text-center">Tidak ada pesan saat ini.</div>
        @else
            <div class="row">
                @foreach ($notifications as $notify)
                    @php
                        $status = $notify->transaksi->status ?? '';
                        $badgeColor = match ($status) {
                            'menunggu' => 'secondary',
                            'proses' => 'warning',
                            'diterima' => 'success',
                            'ditolak' => 'danger',
                            default => 'info',
                        };
                    @endphp

                    <div class="col-md-6 mb-3">
                        <div class="card shadow-sm {{ $notify->is_read ? '' : 'border-warning' }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title mb-1">{{ $notify->title }}</h5>
                                    @if ($status)
                                        <span class="badge bg-{{ $badgeColor }}">{{ ucfirst($status) }}</span>
                                    @endif
                                </div>
                                <p class="card-text text-muted">{{ $notify->message }}</p>

                                <div class="d-flex justify-content-between mt-2">
                                    <small class="text-muted">{{ $notify->created_at->diffForHumans() }}</small>
                                    @if ($notify->id_transaksi)
                                        <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                            data-bs-target="#modalTransaksi{{ $notify->id }}">
                                            <i class="bi bi-info-circle"></i> Detail
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Detail Transaksi -->
                    @if ($notify->transaksi)
                        <div class="modal fade" id="modalTransaksi{{ $notify->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title">🧾 Detail Transaksi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-striped table-bordered">
                                            <tr>
                                                <th>ID Transaksi</th>
                                                <td>{{ $notify->transaksi->id }}</td>
                                            </tr>
                                            <tr>
                                                <th>Jumlah</th>
                                                <td>{{ $notify->transaksi->jumlah }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total Harga</th>
                                                <td>{{ rupiah($notify->transaksi->total_harga) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td><span
                                                        class="badge bg-{{ $badgeColor }}">{{ ucfirst($status) }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Alamat</th>
                                                <td>{{ $notify->transaksi->alamat }}</td>
                                            </tr>
                                            <tr>
                                                <th>Bukti Pembayaran</th>
                                                <td>
                                                    @if ($notify->transaksi->bukti_pembayaran)
                                                        @php $file = $notify->transaksi->bukti_pembayaran; @endphp
                                                        @if (Str::endsWith($file, ['jpg', 'jpeg', 'png']))
                                                            <img src="{{ asset_or_default($file) }}" alt="Bukti Pembayaran"
                                                                class="img-fluid rounded" style="max-height:150px">
                                                        @else
                                                            <a href="{{ asset_or_default($file) }}" target="_blank"
                                                                class="btn btn-sm btn-primary">Lihat Bukti</a>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">Tidak ada</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="mt-3">
                {{ $notifications->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection
