@extends('layouts.panel.index')
@section('title', 'Kelola Transaksi')

@section('content')
    <div class="container-fluid py-4">

        <!-- Header -->
        <div class="mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                <div>
                    <h2 class="text-success fw-bold mb-1">
                        <i class="fas fa-shopping-cart me-2"></i>Kelola Transaksi
                    </h2>
                    <p class="text-muted mb-0">Data transaksi pelanggan</p>
                </div>
            </div>
        </div>

        <!-- Tabel Transaksi -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-success">
                    <i class="fas fa-list me-2"></i>Daftar Transaksi
                </h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-sm align-middle mb-0">
                        <thead class="bg-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Pembeli</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th>Negara</th>
                                <th>Jumlah</th>
                                <th>Berat</th>
                                <th>Total Harga</th>
                                <th>Jenis Pengiriman</th>
                                <th>Nama Ekspedisi</th>
                                <th>Biaya Pengiriman</th>
                                <th>No Resi</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksi as $t)
                                <tr class="text-center">
                                    <td>
                                        {{ $loop->iteration + ($transaksi->currentPage() - 1) * $transaksi->perPage() }}
                                    </td>
                                    <td>{{ $t->pelanggan->username }}</td>
                                    <td>{{ $t->telepon }}</td>
                                    <td>
                                        {{ limit_teks($t->alamat, 50) }}
                                        @if (strlen(strip_tags($t->alamat)) > 50)
                                            <a href="#" class="text-primary ms-1" data-crud="detail"
                                                data-title="Alamat Lengkap"
                                                data-fields='{
                                                    "alamat": { "value": @json(nl2br(e($t->alamat))) }
                                                }'>
                                                <i class="fas fa-map-marker-alt"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{ $t->negara }}</td>
                                    <td>{{ $t->jumlah }}</td>
                                    <td>{{ format_stok($t->jumlah * 500) }}</td>
                                    <td>{{ rupiah($t->total_harga) }}</td>
                                    <td>{{ ucwords(str_replace('_', ' ', $t->jenis_pengiriman)) }}</td>
                                    <td>{{ $t->ekspedisi }}</td>
                                    <td>{{ rupiah($t->biaya_pengiriman) }}</td>
                                    <td>{{ $t->no_resi }}</td>
                                    @php
                                        $badgeColors = [
                                            'menunggu' => 'bg-warning',
                                            'proses' => 'bg-info',
                                            'dibayar' => 'bg-success',
                                            'expired' => 'bg-secondary',
                                            'gagal' => 'bg-danger',
                                        ];
                                        $color = $badgeColors[$t->status] ?? 'bg-dark';
                                    @endphp
                                    <td>
                                        <span class="badge {{ $color }}">{{ ucfirst($t->status) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            {{-- Detail Transaksi --}}
                                            <button type="button" class="btn btn-sm btn-info" data-crud="detail"
                                                data-title="Detail Transaksi"
                                                data-fields='{
                                                    "id_produk": { "label": "Nama Produk", "value": "{{ $t->detailTransaksi->first()->produk->nama ?? '-' }}" },
                                                    "deskripsi": { "label": "Deskripsi", "value": "{{ $t->detailTransaksi->first()->produk->deskripsi ?? '-' }}" },
                                                    "jumlah": { "label": "Jumlah", "value": "{{ $t->detailTransaksi->first()->jumlah ?? '-' }}" },
                                                    "berat": { "label": "Berat", "value": "{{ format_stok($t->detailTransaksi->first()->jumlah * 500) ?? '-' }}" },
                                                    "harga_satuan": { "label": "Harga Barang Satuan", "value": "{{ $t->detailTransaksi->first()?->harga_satuan !== null ? rupiah($t->detailTransaksi->first()->harga_satuan) : '-' }}" },
                                                    "sub_total": { "label": "Sub Total", "value": "{{ $t->detailTransaksi->first()?->sub_total !== null ? rupiah($t->detailTransaksi->first()->sub_total) : '-' }}" }
                                                }'>
                                                <i class="fas fa-info-circle"></i>
                                            </button>

                                            {{-- Biaya Pengiriman --}}
                                            @if ($t->status === 'menunggu' && in_array($t->jenis_pengiriman, ['ditanggung_penjual', 'ditanggung_bersama']))
                                                <button type="button" class="btn btn-sm btn-warning" data-crud="edit"
                                                    data-title="Isi Biaya Pengiriman" data-method="PATCH"
                                                    data-url="{{ route('transaksi.update', $t->id) }}"
                                                    data-fields='{ "ekspedisi"
                                                : { "label" : "Nama Ekspedisi" , "type" : "select" , "options" : [ "JNE"
                                                , "POS Indonesia" , "TIKI" , "SiCepat" , "J&T Express" , "Ninja Xpress"
                                                , "Lion Parcel" , "Wahana" , "AnterAja" , "DHL" , "FedEx" , "UPS"
                                                , "TNT Express" , "Aramex" ], "value" : "{{ $t->ekspedisi }}"
                                                }, "biaya_pengiriman" : { "label" : "Biaya Pengiriman" , "value"
                                                : "{{ $t->biaya_pengiriman }}" } }'
                                                    title="Isi Biaya Pengiriman">
                                                    <i class="fas fa-shipping-fast"></i>
                                                </button>
                                            @endif

                                            {{-- Nomor Resi --}}
                                            @if ($t->status === 'dibayar' && in_array($t->jenis_pengiriman, ['ditanggung_penjual', 'ditanggung_bersama']))
                                                <button type="button" class="btn btn-sm btn-primary" data-crud="edit"
                                                    data-title="Isi Nomor Resi" data-method="PATCH"
                                                    data-url="{{ route('transaksi.update', $t->id) }}"
                                                    data-fields='{
                                                        "no_resi": {
                                                            "label": "Nomor Resi",
                                                            "type": "text",
                                                            "value": "{{ $t->no_resi }}"
                                                        }
                                                    }'
                                                    title="Isi Nomor Resi">
                                                    <i class="fas fa-barcode"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="14" class="text-center py-4 text-muted">Belum ada data transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="card-footer bg-light py-2">
                <div class="d-flex justify-content-center">
                    {{ $transaksi->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
