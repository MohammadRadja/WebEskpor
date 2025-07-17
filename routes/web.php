<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangJadiController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\BibitController;
use App\Http\Controllers\KebunController;
use App\Http\Controllers\PenanamanController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProdukController;
use App\Models\BarangJadi;

/*
|--------------------------------------------------------------------------
| Halaman Publik
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])->name('Home');
Route::get('/tentang', [LandingController::class, 'tentang'])->name('About');
Route::get('/contact', [LandingController::class, 'contact'])->name('contact');
Route::get('/service', [LandingController::class, 'service'])->name('service');
Route::get('/blog', [LandingController::class, 'blog'])->name('blog');
Route::get('/cart', [LandingController::class, 'cart'])->name('cart');
Route::get('/messages', [LandingController::class, 'messages'])->name('messages');

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
| Halaman Admin - role: admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // ✳️ Route baru: Admin dapat melihat semua kebun & user
    Route::get('/kebun', [KebunController::class, 'show'])->name('admin.kebun.index');
});

/*
|--------------------------------------------------------------------------
| Kepala Kebun - role: kepala
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:kepala_kebun'])->prefix('kepala')->group(function () {
    // ✳️ Route baru: Halaman dashboard kepala kebun (opsional)
    Route::get('/dashboard', [AdminController::class, 'index'])->name('kepala.dashboard');

    // Kelola Kebun
    Route::get('/kebun', [KebunController::class, 'show'])->name('kebun.show');
    Route::post('/kebun', [KebunController::class, 'storeKebun'])->name('kebun.store');
    Route::put('/kebun/{id}', [KebunController::class, 'updateKebun'])->name('kebun.update');
    Route::delete('/kebun/{id}', [KebunController::class, 'destroyKebun'])->name('kebun.delete');

    // Kelola Petakan
    Route::get('/kebun/{id}/petakan', [KebunController::class, 'showPetakan'])->name('petakan.show');
    Route::post('/kebun/{id}/petakan', [KebunController::class, 'storePetakan'])->name('petakan.store');
    
    // Kelola bibit
    Route::get('/bibit', [BibitController::class, 'index'])->name('bibit.show');
    Route::post('/kebun/{id}/petakan', [KebunController::class, 'storePetakan'])->name('petakan.store');
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
    Route::get('/kebun', [KebunController::class, 'indexForCustomer'])->name('customer.kebun');
});
