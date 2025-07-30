<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Shared\KebunController;
use App\Http\Controllers\Shared\PetakKebunController;
use App\Http\Controllers\Shared\BibitController;
use App\Http\Controllers\Shared\TanamanController;
use App\Http\Controllers\Shared\ProdukController;
use App\Http\Controllers\Shared\ProdukEksternalController;
use App\Http\Controllers\Shared\TransaksiController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Penjual\KontenController;
use App\Http\Controllers\MessageController;


/*
|--------------------------------------------------------------------------
| Halaman Publik - Guest
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'index'])->name('Home');
Route::get('/about', [PageController::class, 'about'])->name('About');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/product', [PageController::class, 'product'])->name('product');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/cart', [PageController::class, 'cart'])->name('cart');
Route::get('/message', [PageController::class, 'message'])->name('message');

/*
|--------------------------------------------------------------------------
| AUTH - Login, Register, Logout
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('forgot.password');
    Route::post('/forgot-password', [AuthController::class, 'updatePassword'])->name('forgot.password.update');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
/*
|--------------------------------------------------------------------------
| Halaman Shared, Dashboard, Administrator, Penjual, Manajer Kebun, Pembeli
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Message
    Route::prefix('messages')
        ->name('message.')
        ->group(function () {
            Route::get('/', [MessageController::class, 'index'])->name('index');
            Route::get('/read/{id}', [MessageController::class, 'read'])->name('read');
            Route::get('/mark-all', [MessageController::class, 'markAllRead'])->name('markAllRead');
        });

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add-to-cart', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update-qty', [CartController::class, 'updateQuantity'])->name('cart.updateQty');
    Route::get('/checkout', [CartController::class, 'checkoutForm'])->name('checkout.form');
    Route::post('/buy-now', [CartController::class, 'buyNow'])->name('cart.buyNow');

    // Profile
    Route::get('/dashboard/profile', [AuthController::class, 'showProfile'])->name('profile.show');
    Route::post('/dashboard/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Produk
    Route::resource('produk', ProdukController::class);
    Route::get('/produk-export', [ProdukController::class, 'exportExcel'])->name('produk.export.excel');

    // Produk Eksternal
    Route::resource('produk-eksternal', ProdukEksternalController::class);

    // Bibit
    Route::resource('/bibit', BibitController::class);
    Route::get('/bibit-export', [BibitController::class, 'exportExcel'])->name('bibit.export.excel');

    // Kebun
    Route::resource('/kebun', KebunController::class);
    Route::get('/kebun-export', [KebunController::class, 'exportExcel'])->name('kebun.export.excel');

    // Tanaman
    Route::resource('/tanaman', TanamanController::class);
    Route::get('/tanaman-export', [TanamanController::class, 'exportExcel'])->name('tanaman.export.excel');

    // Petak Kebun
    Route::get('/petak-kebun', [PetakKebunController::class, 'index'])->name('petak.kebun');
    Route::get('/petak-kebun', [PetakKebunController::class, 'index'])->name('petak.kebun');
    Route::get('/petak-kebun/create/{kebunId}', [PetakKebunController::class, 'create'])->name('petakan.create');
    Route::post('/petak-kebun', [PetakKebunController::class, 'store'])->name('petakan.store');
    Route::get('/petak-kebun/{id}/edit', [PetakKebunController::class, 'edit'])->name('petakan.edit');
    Route::put('/petak-kebun/{id}', [PetakKebunController::class, 'update'])->name('petakan.update');
    Route::delete('/petak-kebun/{id}', [PetakKebunController::class, 'destroy'])->name('petakan.destroy');
    Route::get('/petak-kebun/export/excel', [PetakKebunController::class, 'exportExcel'])->name('petak.kebun.export.excel');

    // Transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::resource('/transaksi', TransaksiController::class);
    Route::post('/checkout/xendit', [TransaksiController::class, 'checkoutXendit'])->name('checkout.xendit');
    Route::post('/xendit/callback', [TransaksiController::class, 'handleCallback']);

    Route::get('/konten', [DashboardController::class, 'konten'])->name('konten');

    // User Management
    Route::middleware('role:administrator')->group(function () {
        Route::resource('/user', UserController::class);
        Route::get('/user/export', [UserController::class, 'exportExcel'])->name('user.export.excel');
    });

    // Konten
    Route::middleware('role:administrator,penjual')->group(function () {
        Route::resource('konten', KontenController::class);
    });
});

/*
|--------------------------------------------------------------------------
| Pembeli - role: pembeli
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pelanggan'])
    ->prefix('pelanggan')
    ->group(function () {
        // ✳️ Route baru: Lihat info kebun atau produk (read-only)
        Route::get('/home', [PageController::class, 'index'])->name('pelanggan.index');
    });
