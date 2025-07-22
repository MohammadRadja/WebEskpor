@extends('layouts.panel.index')
@section('title', 'Kelola User')

@section('content')
    <div class="container-fluid py-4">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="text-success fw-bold mb-1">
                    <i class="fas fa-users me-2"></i>Kelola User
                </h2>
                <p class="text-muted mb-0">Data pengguna sistem</p>
            </div>
            <button class="btn btn-success" data-crud="add" data-method="POST" data-title="Tambah User"
                data-url="{{ route('user.store') }}"
                data-fields='{
                    "username": {"label": "Username"},
                    "email": {"label": "Email"},
                    "password": {"label": "Password", "type": "password"},
                    "password_confirmation": {
    "label": "Konfirmasi Password",
    "type": "password"
},
                    "role": {"label": "Role", "type": "select", "options": ["pelanggan", "manajer_kebun", "penjual"]}
                }'>
                <i class="fas fa-plus me-1"></i> Tambah User
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0 text-success"><i class="fas fa-list me-2"></i>Daftar User</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Dibuat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span
                                            class="badge bg-primary">{{ ucwords(str_replace('_', ' ', $user->role)) }}</span>
                                    </td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-success me-1" data-crud="edit"
                                            data-title="Edit User" data-method="PATCH"
                                            data-url="{{ route('user.update', $user->id) }}"
                                            data-fields='{
                                                "username": {"label": "Username", "value": "{{ $user->username }}"},
                                                "email": {"label": "Email", "value": "{{ $user->email }}"},
                                                "role": {"label": "Role", "value": "{{ $user->role }}",
                                                    "type": "select", "options": ["pelanggan", "manajer_kebun", "penjual"]},
                                                "password": {"label": "Password", "type": "password"},
                                                "password_confirmation": {"label": "Konfirmasi Password", "type": "password"}
                                            }'>
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-crud="delete"
                                            data-title="Hapus User" data-method="DELETE"
                                            data-url="{{ route('user.destroy', $user->id) }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada data user.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
