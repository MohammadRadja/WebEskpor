@extends('auth.layout.auth')

@section('title', 'Login')

@section('content')
<div class="card shadow p-4 w-100">
  <h4 class="text-center mb-4">Login</h4>
  <form method="POST" action="{{ url('/login') }}">
    @csrf

    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success w-100">Login</button>

    <p class="text-center mt-3">
      Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
    </p>
  </form>
</div>
@endsection
