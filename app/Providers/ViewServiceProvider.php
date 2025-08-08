<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Konten;
use Illuminate\Support\Facades\Log;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Layout Guest - footer
        View::composer('layouts.guest.*', function ($view) {
            $footer = Konten::where('slug', 'footer')->first();
            $view->with([
                'footer' => $footer,
            ]);
        });

        // Layout App - jika punya layout untuk user login
        View::composer('layouts.panel.*', function ($view) {
            $footer = Konten::where('slug', 'footer')->first();
            $view->with([
                'footer' => $footer,
            ]);
        });

    }
}
