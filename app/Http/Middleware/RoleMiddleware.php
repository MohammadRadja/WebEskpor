<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{

    public function handle(Request $request, Closure $next, ...$roles): Response
{
    if (!Auth::check()) {
        Log::info('Middleware Role: User not authenticated');
        return redirect('/login');
    }

    $user = Auth::user();
    Log::info('Middleware Role: User authenticated', [
        'user_id' => $user->id,
        'role' => $user->role,
        'allowed_roles' => $roles
    ]);

    if (!in_array($user->role, $roles)) {
        Log::warning('Middleware Role: Role not authorized', [
            'user_id' => $user->id,
            'role' => $user->role
        ]);
        abort(403, 'Unauthorized');
    }

    return $next($request);
}
}
