<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckKebunAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Cek apakah sudah login dan memiliki role yang diizinkan
        if (!$user || !in_array($user->role, ['owner', 'kepala_kebun', 'sales'])) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
