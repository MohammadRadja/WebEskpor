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
                {{-- Tombol Tambah hanya untuk role yang boleh mengelola --}}
                @php
                    $canManage = in_array(Auth::user()->role, ['manajer_kebun']);
                @endphp

                @if ($canManage)
                    <button class="btn btn-success" data-crud="add" data-url="{{ route('bibit.store') }}" data-method="POST"
                        data-title="Tambah Bibit"
                        data-fields='{
                            "id_tanaman": {"label": "Tanaman", "type": "select", "options": "tanamanList"},
                            "nama": {"label": "Nama Bibit"},
                            "tanggal_pembelian": {"label": "Tanggal Pembelian", "type": "date"},
                            "nama_penjual": {"label": "Nama Penjual"},
                            "harga_satuan": {"label": "Harga Satuan"},
                            "jumlah": {"label": "Jumlah Bibit", "type": "number"}
                        }'>
                        <i class="fas fa-plus"></i> Tambah Bibit
                    </button>
                @endif
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
                                <th>No</th>
                                <th>Nama Tanaman</th>
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
                                    <td>
                                        {{ $loop->iteration + ($bibit->currentPage() - 1) * $bibit->perPage() }}
                                    </td>
                                    <td>{{ $b->tanaman->nama }}</td>
                                    <td>{{ $b->nama }}</td>
                                    <td>{{ format_tanggal($b->tanggal_pembelian) }}</td>
                                    <td>{{ $b->nama_penjual }}</td>
                                    <td>{{ rupiah($b->harga_satuan) }}</td>
                                    <td>{{ format_jumlah_tanam($b->jumlah) }}</td>
                                    <td>{{ rupiah($b->harga_satuan * $b->jumlah) }}</td>
                                    <td class="text-center">
                                        @php
                                            $editFields = [
                                                'id_tanaman' => [
                                                    'label' => 'Tanaman',
                                                    'type' => 'select',
                                                    'options' => 'tanamanList',
                                                    'value' => $b->tanaman->id,
                                                ],
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
                                                    'type' => 'text',
                                                    'value' => $b->harga_satuan,
                                                ],
                                                'jumlah' => [
                                                    'label' => 'Jumlah',
                                                    'type' => 'number',
                                                    'value' => $b->jumlah,
                                                ],
                                            ];
                                        @endphp

                                        {{-- Tampilkan tombol edit/hapus jika bisa mengelola --}}
                                        @if ($canManage)
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
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        Belum ada data bibit.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="card-footer bg-light py-2">
                <div class="d-flex justify-content-center">
                    {{ $bibit->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.tanamanList = @json($tanamanList);
    </script>
@endpush
