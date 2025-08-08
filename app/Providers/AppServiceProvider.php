<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Bibit;
use App\Observers\BibitObserver;
use App\Models\PetakKebun;
use App\Observers\PetakKebunObserver;
use App\Models\Transaksi;
use App\Observers\TransaksiObserver;
use App\Models\Produk;
use App\Observers\ProdukObserver;
use App\Models\ProdukEksternal;
use App\Observers\ProdukEksternalObserver;
use App\Services\DatabaseNotify;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifications;
use App\Models\Cart;
use App\Models\CartItem;

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
        // Register Observers
        Bibit::observe(BibitObserver::class);
        PetakKebun::observe(PetakKebunObserver::class);
        Produk::observe(ProdukObserver::class);
        ProdukEksternal::observe(ProdukEksternalObserver::class);

        // Bind DatabaseNotify
        App::bind(DatabaseNotify::class, fn() => new DatabaseNotify());

        // Global variable for unread notifications count
        view()->composer('*', function ($view) {
            $unreadCount = 0;
            $cartCount = 0;

            if (Auth::check()) {
                // Hitung notifikasi yang belum dibaca
                $unreadCount = Notifications::where('user_id', Auth::id())->where('is_read', false)->count();

                // Hitung total item di keranjang
                $cart = Cart::where('user_id', Auth::id())->with('items')->first();
                if ($cart) {
                    $cartCount = $cart->items->sum('quantity');
                }
            }

            $view->with([
                'unreadCount' => $unreadCount,
                'cartCount' => $cartCount,
            ]);
        });
    }
}
