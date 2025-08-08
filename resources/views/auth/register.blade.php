@extends('layouts.guest.index')

@section('title', 'Register')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 85vh;">
        <div class="card shadow-sm p-4" style="max-width: 460px; width: 100%;">
            <h4 class="text-center mb-4">Buat Akun Baru</h4>

            {{-- Menampilkan error validasi jika ada --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li class="small">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('/register') }}">
                @csrf

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username"
                        class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required
                        autofocus placeholder="Masukkan username">
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required
                        placeholder="you@example.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror" required placeholder="********">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        required placeholder="********">
                </div>

                <button type="submit" class="btn btn-success w-100">Register</button>

                <p class="text-center mt-4 mb-0 text-muted">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-success">Login di sini</a>
                </p>
            </form>
        </div>
    </div>
@endsection
