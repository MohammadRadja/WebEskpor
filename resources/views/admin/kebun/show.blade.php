@extends('admin.layout.show')

@section('title', 'Kelola Kebun')

@section('content')
<div class="container mt-4">
    <h3>Kelola Kebun: {{ $kebun->nama }}</h3>

    {{-- Form Edit Kebun --}}
    <form action="{{ route('kebun.update', $kebun->id) }}" method="POST" class="mb-4">
        @csrf
        <div class="mb-3">
            <label>Nama Kebun</label>
            <input type="text" name="nama" value="{{ $kebun->nama }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Lokasi</label>
            <input type="text" name="lokasi" value="{{ $kebun->lokasi }}" class="form-control" required>
        </div>
        <button class="btn btn-primary">Update Kebun</button>
    </form>

    <hr>

    {{-- Daftar Petakan --}}
    <h5>Daftar Petakan</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Ukuran</th>
                <th>Penanggung Jawab</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kebun->petakan as $p)
            <tr>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->ukuran }}</td>
                <td>{{ $p->penanggung_jawab }}</td>
                <td><span class="badge bg-{{ $p->status === 'aktif' ? 'success' : 'secondary' }}">{{ ucfirst($p->status) }}</span></td>
                <td>
                    <form action="{{ route('petakan.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Tambah Petakan --}}
    <h5 class="mt-4">Tambah Petakan</h5>
    <form action="{{ route('petakan.store', $kebun->id) }}" method="POST">
        @csrf
        <div class="mb-2">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-2">
            <label>Ukuran</label>
            <input type="text" name="ukuran" class="form-control" required>
        </div>
        <div class="mb-2">
            <label>Penanggung Jawab</label>
            <input type="text" name="penanggung_jawab" class="form-control" required>
        </div>
        <div class="mb-2">
            <label>Status</label>
            <select name="status" class="form-select" required>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>
        </div>
        <button class="btn btn-success">Tambah Petakan</button>
    </form>
</div>
@endsection
