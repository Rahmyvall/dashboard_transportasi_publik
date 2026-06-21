<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Halaman awal langsung ke login
Route::get('/', [AuthController::class, 'login'])->name('login');

// Proses login
Route::post('login', [AuthController::class, 'process'])->name('login.process');

// Dashboard
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
