@extends('layouts.panel.index')
@section('title', 'Kelola Petakan Kebun')

@section('content')
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-start flex-wrap">
                <div class="mb-2">
                    <h2 class="text-success fw-bold mb-1">
                        <i class="fas fa-th-large me-2"></i>Kelola Petakan Kebun
                    </h2>
                    <p class="text-muted mb-0">Lihat, tambahkan, atau kelola petakan kebun Anda.</p>
                </div>
                <div class="d-flex gap-2">
                    @can('create', App\Models\PetakKebun::class)
                        <button class="btn btn-success" data-crud="add" data-method="POST" data-title="Tambah Petakan"
                            data-url="{{ route('petakan.store') }}"
                            data-fields='{
                                "nama": {"label": "Nama Petakan"},
                                "ukuran": {"label": "Ukuran"},
                                "id_kebun": {"label": "Kebun", "type": "select", "options": "kebunOptions"},
                                "id_tanaman": {"label": "Tanaman", "type": "select", "options": "tanamanOptions"},
                                "penanggung_jawab": {"label": "Penanggung Jawab"},
                                "tanggal_tanam": {"label": "Tanggal Tanam", "type": "date"},
                                "tanggal_panen": {"label": "Tanggal Panen", "type": "date"},
                                "jumlah_tanaman": {"label": "Jumlah Tanaman"},
                                "jumlah_panen": {"label": "Jumlah Panen"},
                                "status": {"label": "Status", "type": "select", "options": ["aktif", "non-aktif"]}
                            }'>
                            <i class="fas fa-plus me-1"></i> Tambah Petakan
                        </button>
                    @endcan
                </div>
            </div>
        </div>

        <!-- List Petakan -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-success">
                    <i class="fas fa-list me-2"></i>Daftar Petak Kebun
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-center">
                            <tr>
                                <th>Nama Petakan</th>
                                <th>Ukuran</th>
                                <th>Kebun</th>
                                <th>Tanaman</th>
                                <th>Penanggung Jawab</th>
                                <th>Tanggal Tanam</th>
                                <th>Tanggal Panen</th>
                                <th>Jumlah Tanam</th>
                                <th>Jumlah Panen</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse($petakan as $p)
                                <tr>
                                    <td>{{ $p->nama }}</td>
                                    <td>{{ $p->ukuran }}</td>
                                    <td>{{ $p->kebun->nama ?? '-' }}</td>
                                    <td>{{ $p->tanaman->nama ?? '-' }}</td>
                                    <td>{{ $p->penanggung_jawab }}</td>
                                    <td>{{ format_tanggal($p->tanggal_tanam) }}</td>
                                    <td>{{ format_tanggal($p->tanggal_panen) }}</td>
                                    <td>{{ format_jumlah_tanam($p->jumlah_tanaman) }}</td>
                                    <td>{{ format_stok($p->jumlah_panen) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $p->status == 'aktif' ? 'success' : 'secondary' }}">
                                            {{ ucwords(str_replace('-', ' ', $p->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        @can('update', $p)
                                            <button type="button" class="btn btn-sm btn-outline-success me-1" data-crud="edit"
                                                data-title="Edit Petakan" data-method="PUT"
                                                data-url="{{ route('petakan.update', $p->id) }}"
                                                data-fields='{
                                                    "nama": {"label": "Nama Petakan", "value": "{{ $p->nama }}"},
                                                    "ukuran": {"label": "Ukuran", "value": "{{ $p->ukuran }}"},
                                                    "id_kebun": {"label": "Kebun", "value": "{{ $p->id_kebun }}", "type": "select", "options": "kebunOptions"},
                                                    "id_tanaman": {"label": "Tanaman", "value": "{{ $p->id_tanaman }}", "type": "select", "options": "tanamanOptions"},
                                                    "penanggung_jawab": {"label": "Penanggung Jawab", "value": "{{ $p->penanggung_jawab }}"},
                                                    "tanggal_tanam": {"label": "Tanggal Tanam", "value": "{{ $p->tanggal_tanam }}", "type": "date"},
                                                    "tanggal_panen": {"label": "Tanggal Panen", "value": "{{ $p->tanggal_panen }}", "type": "date"},
                                                    "jumlah_tanaman": {"label": "Jumlah Tanaman", "value": "{{ $p->jumlah_tanaman }}"},
                                                    "jumlah_panen": {"label": "Jumlah Panen", "value": "{{ $p->jumlah_panen }}"},
                                                    "status": {"label": "Status", "value": "{{ $p->status }}", "type": "select", "options": ["aktif", "non-aktif"]}
                                                }'>
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @endcan

                                        @can('delete', $p)
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-crud="delete"
                                                data-title="Hapus Petakan" data-method="DELETE"
                                                data-url="{{ route('petakan.destroy', $p->id) }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-4 text-muted">
                                        <i class="fas fa-exclamation-circle me-1"></i> Belum ada petakan terdaftar.
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

@push('scripts')
    <script>
        window.kebunOptions = @json($kebunList);
        window.tanamanOptions = @json($tanamanList);
    </script>
@endpush
