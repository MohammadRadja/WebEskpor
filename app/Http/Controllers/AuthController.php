<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

                Log::info('Auth attempt success', ['user' => Auth::user()]);
            $user = Auth::user();

            // Log aktivitas login berhasil
            Log::info('Login berhasil', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'ip' => $request->ip(),
                'agent' => $request->header('User-Agent'),
            ]);

            // Redirect berdasarkan role
            switch ($user->role) {
                case 'administrator':
                    return redirect()->route('admin.dashboard');
                case 'farm_manager':
                    return redirect()->route('farm-manager.dashboard');
                case 'sales':
                    return redirect()->route('sales.dashboard');
                case 'customer':
                    return redirect()->route('customer.kebun');
                default:
                    Auth::logout();

                    // Log error role tidak dikenali
                    Log::warning('Login gagal - role tidak dikenali', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'role' => $user->role,
                    ]);

                    return redirect('/login')->withErrors(['email' => 'Role tidak dikenali.']);
            }
        }

        // Log login gagal
        Log::warning('Login gagal - kredensial salah', [
            'email' => $request->input('email'),
            'ip' => $request->ip(),
            'agent' => $request->header('User-Agent'),
        ]);

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->withInput();
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
