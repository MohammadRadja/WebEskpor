@extends('layouts.panel.index')
@section('title', 'Kelola Bibit')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <h2 class="fw-bold text-success"><i class="fas fa-seedling me-2"></i>Kelola Bibit</h2>
                <p class="text-muted">Kelola data pembelian bibit tanaman</p>
            </div>
            <div>
                <a href="{{ route('bibit.export.excel') }}" class="btn btn-outline-success me-2">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
                <button class="btn btn-success" data-crud="add" data-url="{{ route('bibit.store') }}" data-method="POST"
                    data-title="Tambah Bibit"
                    data-fields='{
        "nama": {"label": "Nama Bibit"},
        "tanggal_pembelian": {"label": "Tanggal Pembelian", "type": "date"},
        "nama_penjual": {"label": "Nama Penjual"},
        "harga_satuan": {"label": "Harga Satuan", "type": "number"},
        "jumlah": {"label": "Jumlah", "type": "number"}
    }'>
                    <i class="fas fa-plus"></i> Tambah Bibit
                </button>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0 text-success"><i class="fas fa-leaf me-2"></i>Daftar Bibit</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Nama Bibit</th>
                                <th>Tanggal Pembelian</th>
                                <th>Nama Penjual</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah Bibit</th>
                                <th>Total</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bibit as $b)
                                <tr>
                                    <td>{{ $b->nama }}</td>
                                    <td>{{ format_tanggal($b->tanggal_pembelian) }}</td>
                                    <td>{{ $b->nama_penjual }}</td>
                                    <td>{{ rupiah($b->harga_satuan) }}</td>
                                    <td>{{ format_jumlah_tanam($b->jumlah) }}</td>
                                    <td>{{ rupiah($b->harga_satuan * $b->jumlah) }}</td>
                                    <td class="text-center">
                                        @php
                                            $editFields = [
                                                'nama' => [
                                                    'label' => 'Nama Bibit',
                                                    'value' => $b->nama,
                                                ],
                                                'tanggal_pembelian' => [
                                                    'label' => 'Tanggal Pembelian',
                                                    'type' => 'date',
                                                    'value' => $b->tanggal_pembelian,
                                                ],
                                                'nama_penjual' => [
                                                    'label' => 'Nama Penjual',
                                                    'value' => $b->nama_penjual,
                                                ],
                                                'harga_satuan' => [
                                                    'label' => 'Harga Satuan',
                                                    'type' => 'number',
                                                    'value' => $b->harga_satuan,
                                                ],
                                                'jumlah' => [
                                                    'label' => 'Jumlah',
                                                    'type' => 'number',
                                                    'value' => $b->jumlah,
                                                ],
                                            ];
                                        @endphp

                                        <button class="btn btn-sm btn-outline-success" data-crud="edit"
                                            data-url="{{ route('bibit.update', $b->id) }}" data-method="PATCH"
                                            data-title="Edit Bibit" data-fields='@json($editFields)'>
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-crud="delete"
                                            data-method="DELETE" data-title="Hapus Bibit"
                                            data-url="{{ route('bibit.destroy', $b->id) }}">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        Belum ada data bibit.
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
