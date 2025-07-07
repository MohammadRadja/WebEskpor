@extends('auth.layout.auth')

@section('title', 'Register')

@section('content')
<div class="card shadow p-4 w-100">
  <h4 class="text-center mb-4">Register</h4>

  {{-- Menampilkan error validasi jika ada --}}
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ url('/register') }}">
    @csrf

    <div class="mb-3">
      <label>Username</label>
      <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
    </div>

    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
    </div>

    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Konfirmasi Password</label>
      <input type="password" name="password_confirmation" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success w-100">Register</button>

    <p class="text-center mt-3">
      Sudah punya akun? <a href="{{ route('login') }}">Login</a>
    </p>
  </form>
</div>
@endsection
