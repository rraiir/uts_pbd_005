<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MarginPenjualanController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\GudangController;

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
    Route::get('/barang', [BarangController::class, 'index'])->name('admin.barang');
    Route::get('/vendor', [VendorController::class, 'index'])->name('admin.vendor');
    Route::get('/user', [UserController::class, 'index'])->name('admin.user');
    Route::get('/role', [RoleController::class, 'index'])->name('admin.role');
    Route::get('/margin', [MarginPenjualanController::class, 'index'])->name('admin.margin');
});

// ===== Route Manager =====
Route::middleware(['cekrole:Manager'])->prefix('manager')->group(function () {
    Route::get('/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
    Route::get('/pengadaan', [ManagerController::class, 'pengadaan'])->name('manager.pengadaan');
    Route::get('/pengadaan/buat', [ManagerController::class, 'buatPengadaan'])->name('manager.pengadaan.buat');
});

// ===== Route Gudang =====
Route::middleware(['cekrole:Gudang'])->prefix('gudang')->group(function () {
    Route::get('/dashboard', [GudangController::class, 'dashboard'])->name('gudang.dashboard');
    Route::get('/penerimaan', [GudangController::class, 'penerimaan'])->name('gudang.penerimaan');
    Route::get('/penerimaan/terima', [GudangController::class, 'terima'])->name('gudang.terima');
    Route::get('/retur', [GudangController::class, 'retur'])->name('gudang.retur');
    Route::get('/kartu-stok', [GudangController::class, 'kartuStok'])->name('gudang.kartu-stok');
});