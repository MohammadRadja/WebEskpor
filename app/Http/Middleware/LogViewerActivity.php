<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Activitylog\Facades\Activity;

class LogViewerActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->is('admin/*') && !$request->is('api/*') && auth()->guest()) {
            activity()
                ->tap(function ($activity) use ($request) {
                    $activity->properties = [
                        'ip' => $request->ip(),
                        'url' => $request->fullUrl(),
                        'user_agent' => $request->userAgent(),
                    ];
                })
                ->log('Pengunjung melihat halaman');
        }

        return $next($request);
    }
}
