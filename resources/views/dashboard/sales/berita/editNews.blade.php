@extends('layout.index')

@section('content')
<h1 class="mt-4 text-success fw-bold mb-1">
    <i class="fas fa-newspaper me-2"></i>
    Edit Berita
</h1>

<ol class="breadcrumb mb-4 breadcrumb-dark">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none" style="color: #00ff88;">
            <i class="fas fa-home me-1"></i>
            Dashboard
        </a>
    </li>
    <li class="breadcrumb-item active">
        <i class="fas fa-newspaper me-1"></i>
        Kelola Berita
    </li>

    <li class="breadcrumb-item active">
        <i class="fas fa-plus me-1"></i>
        Edit Berita
    </li>
</ol>

<div class="card card-dark mb-4">
    <div class="card-header card-header-dark">
        <i class="fas fa-plus-circle me-2"></i>
        <strong>Tambah Berita Baru</strong>
    </div>
    <div class="card-body">
        <form id="seedlingForm">

            <div class="mb-3">
                <label for="total_harga" class="form-label form-label-green">
                    <i class="fas fa-newspaper me-1"></i>
                    Judul Berita
                </label>
                <div class="input-group">
                    <input type="Text" class="form-control" id="judul" name="judul" placeholder="Masukkan Judul">
                </div>
            </div>
            <div class="mb-3">
                <label for="total_harga" class="form-label form-label-green">
                    <i class="fas fa-image me-1"></i>
                    Gambar Berita
                </label>
                <div class="input-group">
                    <input type="file" class="form-control" id="gambar_berita" name="gambar_berita" placeholder="Masukkan Gambar">
                </div>
            </div>

            <div class="mb-3">
                <label for="total_harga" class="form-label form-label-green">
                    <i class="fas fa-newspaper me-1"></i>
                    Artikel Berita
                </label>
                <textarea id="konten" name="konten"></textarea>
            </div>



            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-green">
                    <i class="fas fa-save me-1"></i>
                    Simpan Perubahan Berita Baru
                </button>
                <button type="reset" class="btn btn-outline-green">
                    <i class="fas fa-undo me-1"></i>
                    Reset Form
                </button>
            </div>
        </form>
    </div>
</div>
@endsection