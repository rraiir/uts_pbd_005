<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SatuanController;

// ===== Halaman Login (tanpa middleware) =====
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'proses'])->name('login.proses');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Redirect root ke login
Route::get('/', fn () => redirect('/login'));

// ===== Route Admin =====
Route::middleware(['cekrole:Admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/satuan', [SatuanController::class, 'index'])->name('admin.satuan');
});

// ===== Route Manager =====
Route::middleware(['cekrole:Manager'])->prefix('manager')->group(function () {
    Route::get('/dashboard', fn () => view('manager.dashboard'))->name('manager.dashboard');
});

// ===== Route Gudang =====
Route::middleware(['cekrole:Gudang'])->prefix('gudang')->group(function () {
    Route::get('/dashboard', fn () => view('gudang.dashboard'))->name('gudang.dashboard');
});