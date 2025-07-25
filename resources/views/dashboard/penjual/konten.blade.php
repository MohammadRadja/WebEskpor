@extends('layouts.panel.index')
@section('title', 'Kelola Konten')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <h2 class="fw-bold text-success"><i class="fas fa-file-alt me-2"></i>Kelola Konten</h2>
                <p class="text-muted">Manajemen halaman, artikel, spanduk, dan komponen situs</p>
            </div>
        </div>

        @php
            $jenisList = [
                'halaman' => $halaman,
                'artikel' => $artikel,
                'spanduk' => $spanduk,
                'komponen' => $komponen,
            ];
        @endphp

        @foreach ($jenisList as $jenis => $kontens)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-capitalize text-success">
                        <i class="fas fa-layer-group me-2"></i>{{ ucfirst($jenis) }}
                    </h5>
                    <button class="btn btn-success" data-crud="add" data-method="POST"
                        data-title="Tambah {{ ucfirst($jenis) }}"
                        data-url="{{ route('konten.store', ['jenis' => $jenis]) }}"
                        data-fields='{
                            "judul": {"label": "Judul"},
                            "konten": {"label": "Konten", "type": "textarea"},
                            "jenis": {"label": "Jenis", "type": "select", "options": ["halaman", "artikel", "spanduk", "komponen"]},
                            "gambar": {"label": "Gambar", "type": "file"},
                            "kutipan": {"label": "Kutipan"},
                            "tautan": {"label": "Tautan"},
                            "meta": {"label": "Meta", "type": "json"},
                            "media": {"label": "Media", "type": "json"},
                            "status": {"label": "Status", "type": "select", "options": ["terbit", "draf"]},
                            "diterbitkan_pada": {"label": "Diterbitkan Pada", "type": "date"},
                            "id_penulis": {
            "label": "Penulis",
            "type": "select",
            "options": {!! json_encode($penulisList) !!}
        }
                        }'>
                        <i class="fas fa-plus me-1"></i> Tambah
                    </button>
                </div>
                <div class="card-body p-0">
                    @if ($kontens->count())
                        <div class="accordion" id="accordion-{{ $jenis }}">
                            @foreach ($kontens as $k)
                                <div class="accordion-item border-bottom">
                                    <h2 class="accordion-header" id="heading-{{ $jenis }}-{{ $k->id }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-{{ $jenis }}-{{ $k->id }}"
                                            aria-expanded="false">
                                            <strong>{{ $k->judul }}</strong> &nbsp;|&nbsp;
                                            <small class="text-muted">{{ Str::limit($k->kutipan, 80) }}</small>
                                        </button>
                                    </h2>
                                    <div id="collapse-{{ $jenis }}-{{ $k->id }}"
                                        class="accordion-collapse collapse"
                                        aria-labelledby="heading-{{ $jenis }}-{{ $k->id }}"
                                        data-bs-parent="#accordion-{{ $jenis }}">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <p><strong>Konten:</strong>
                                                        {{ Str::limit(strip_tags($k->konten), 200) }}</p>
                                                    <p><strong>Slug:</strong> {{ $k->slug }}</p>
                                                    <p><strong>Status:</strong>
                                                        @if ($k->status === 'terbit')
                                                            <span class="badge bg-success">Terbit</span>
                                                        @else
                                                            <span class="badge bg-warning text-dark">Draf</span>
                                                        @endif
                                                    </p>
                                                    <p><strong>Diterbitkan:</strong>
                                                        {{ \Carbon\Carbon::parse($k->diterbitkan_pada)->translatedFormat('d F Y') }}
                                                    </p>
                                                    <p><strong>Penulis:</strong> {{ $k->penulis->username }}</p>
                                                    <p><strong>Tautan:</strong>
                                                        @if ($k->tautan)
                                                            <a href="{{ $k->tautan }}"
                                                                target="_blank">{{ $k->tautan }}</a>
                                                        @else
                                                            <span class="text-muted">—</span>
                                                        @endif
                                                    </p>

                                                    @if ($k->meta)
                                                        <div class="mt-3">
                                                            <strong>Meta:</strong>
                                                            @foreach (json_decode($k->meta, true) as $key => $value)
                                                                <div><strong>{{ ucfirst($key) }}:</strong>
                                                                    {{ is_array($value) ? implode(', ', $value) : $value }}
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif

                                                    @if ($k->media)
                                                        <div class="mt-3">
                                                            <strong>Media:</strong>
                                                            @php $media = json_decode($k->media, true); @endphp
                                                            @if (isset($media['images']))
                                                                @foreach ($media['images'] as $img)
                                                                    <img src="{{ asset('uploads/' . $img) }}"
                                                                        class="img-thumbnail me-2 mb-2"
                                                                        style="height: 60px;">
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="col-md-4 text-end">
                                                    <div class="d-grid gap-2">
                                                        <button type="button" class="btn btn-sm btn-outline-success me-1"
                                                            data-crud="edit" data-title="Edit Konten {{ ucfirst($jenis) }}"
                                                            data-method="PATCH"
                                                            data-url="{{ route('konten.update', $k->id) }}"
                                                            data-fields='{
        "judul": {"label": "Judul", "value": "{{ addslashes($k->judul) }}"},
        "konten": {"label": "Konten", "type": "textarea", "value": "{{ addslashes($k->konten) }}"},
        "jenis": {
            "label": "Jenis",
            "type": "select",
            "options": ["halaman", "artikel", "spanduk", "komponen"],
            "value": "{{ $k->jenis }}"
        },
        "meta": {
            "label": "Meta",
            "type": "json",
            "value": {!! json_encode(json_decode($k->meta, true) ?? []) !!}
        },
        "media": {
            "label": "Media",
            "type": "json",
            "value": {!! json_encode(json_decode($k->media, true) ?? []) !!}
        },
        "kutipan": {"label": "Kutipan", "value": "{{ addslashes($k->kutipan) }}"},
        "tautan": {"label": "Tautan", "value": "{{ addslashes($k->tautan) }}"},
        "gambar": {"label": "Gambar", "type": "file"},
        "status": {
            "label": "Status",
            "type": "select",
            "options": ["terbit", "draf"],
            "value": "{{ $k->status }}"
        },
        "id_penulis": {
            "label": "Penulis",
            "type": "select",
            "options": {!! json_encode($penulisList) !!},
            "value": "{{ $k->id_penulis }}"
        },
        "diterbitkan_pada": {
            "label": "Diterbitkan Pada",
            "type": "date",
            "value": "{{ $k->diterbitkan_pada ? format_tanggal($k->diterbitkan_pada, 'Y-m-d') : '' }}"
        }
    }'>
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                        <button class="btn btn-outline-danger btn-sm" data-crud="delete"
                                                            data-title="Hapus Konten {{ ucfirst($jenis) }}"
                                                            data-method="DELETE"
                                                            data-url="{{ route('konten.destroy', $k->id) }}">
                                                            <i class="fas fa-trash-alt"></i> Hapus
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-4 text-center text-muted">
                            Tidak ada konten {{ $jenis }}.
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

    </div>
@endsection
@section('scripts')
    <script>
        window.penulisList = @json($penulisList);
    </script>
@endsection
