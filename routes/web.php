<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KebunController;

// Halaman publik
Route::get('/', [LandingController::class, 'index'])->name('Home');
Route::get('/tentang', [LandingController::class, 'tentang'])->name('About');
Route::get('/contact', [LandingController::class, 'contact'])->name('contact');
Route::get('/service', [LandingController::class, 'service'])->name('service');

// Halaman admin
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

// AUTH - Login, Register, Logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman kebun
Route::get('/kebun/{id}', [KebunController::class, 'show'])->name('kebun.show');
Route::post('/kebun/{id}/update', [KebunController::class, 'updateKebun'])->name('kebun.update');
Route::post('/kebun/{id}/petakan', [KebunController::class, 'storePetakan'])->name('petakan.store');
Route::delete('/petakan/{id}', [KebunController::class, 'destroyPetakan'])->name('petakan.destroy');

