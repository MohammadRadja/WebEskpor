<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Bibit;
use App\Observers\BibitObserver;
use App\Models\PetakKebun;
use App\Observers\PetakKebunObserver;
use App\Models\Transaksi;
use App\Observers\TransaksiObserver;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Bibit::observe(BibitObserver::class);
        PetakKebun::observe(PetakKebunObserver::class);
<<<<<<< HEAD
=======
        Transaksi::observe(TransaksiObserver::class);
>>>>>>> 6e3bd2e (feat(UI): Add Update)
    }
}
