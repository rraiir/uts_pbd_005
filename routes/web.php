<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\SatuanController;

Route::get('/satuan', [SatuanController::class, 'index']);