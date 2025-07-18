<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangJadiController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\SeedController;
use App\Http\Controllers\FarmController;
use App\Http\Controllers\PenanamanController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProdukController;
use App\Models\BarangJadi;

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
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Halaman Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:administrator'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/kebun', [FarmController::class, 'show'])->name('admin.kebun.index');
});

/*
|--------------------------------------------------------------------------
| Kepala Kebun - role: kepala
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:farm_manager'])->prefix('kepala')->group(function () {
    // ✳️ Route baru: Halaman dashboard kepala kebun (opsional)
    Route::get('/dashboard', [AdminController::class, 'index'])->name('farm-manager.dashboard');

    // Kelola Kebun
    Route::get('/kebun', [FarmController::class, 'show'])->name('kebun.show');
    Route::post('/kebun', [FarmController::class, 'storeKebun'])->name('kebun.store');
    Route::put('/kebun/{id}', [FarmController::class, 'updateKebun'])->name('kebun.update');
    Route::delete('/kebun/{id}', [FarmController::class, 'destroyKebun'])->name('kebun.delete');

    // Kelola Petakan
    Route::get('/kebun/{id}/petakan', [FarmController::class, 'showPetakan'])->name('petakan.show');
    Route::post('/kebun/{id}/petakan', [FarmController::class, 'storePetakan'])->name('petakan.store');

    // Kelola bibit
    Route::get('/bibit', [SeedController::class, 'index'])->name('bibit.show');
    Route::post('/kebun/{id}/petakan', [FarmController::class, 'storePetakan'])->name('petakan.store');
    // Kelola Barang Jadi
    Route::get('/barang-jadi', [BarangJadiController::class, 'show'])->name('barang.show');
    // Kelola penanaman
    Route::get('/penanaman', [PenanamanController::class, 'index'])->name('penanaman.show');
});

/*
|--------------------------------------------------------------------------
| Sales - role: sales
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:sales'])->prefix('sales')->group(function () {
    // ✳️ Route baru: Lihat daftar kebun (read-only)
    Route::get('/dashboard', [AdminController::class, 'sales'])->name('sales.dashboard');
    // produk
    Route::get('/sales/produk', [ProdukController::class, 'show'])->name('sales.produk');
    // orderan
    Route::get('/sales/order', [PesananController::class, 'show'])->name('sales.order');

    // Berita
    Route::get('/sales/berita', [BeritaController::class, 'show'])->name('sales.berita');
    Route::get('/sales/berita/add-news', [BeritaController::class, 'addShow'])->name('sales.berita.add');
    Route::get('/sales/berita/edit-news', [BeritaController::class, 'editShow'])->name('sales.berita.edit');
});

/*
|--------------------------------------------------------------------------
| Pembeli - role: pembeli
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pembeli'])->prefix('pembeli')->group(function () {
    // ✳️ Route baru: Lihat info kebun atau produk (read-only)
    Route::get('/kebun', [FarmController::class, 'indexForCustomer'])->name('customer.kebun');
});
