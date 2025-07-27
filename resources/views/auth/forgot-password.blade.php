@extends('layouts.guest.index')

@section('title', 'Reset Password')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm p-4" style="max-width: 420px; width: 100%;">
        <h4 class="text-center mb-4">Reset Password</h4>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('forgot.password.update') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email Anda</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password Baru</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Update Password</button>
            <p class="text-center mt-3 mb-0"><a href="{{ route('login') }}">Kembali ke Login</a></p>
        </form>
    </div>
</div>
@endsection
