<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login.form');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('login', [AuthController::class, 'login'])->name('login.form');
Route::post('login', [AuthController::class, 'processLogin'])->name('login.process');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD (manual session system)
|--------------------------------------------------------------------------
*/
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('user', [UserController::class, 'index'])->name('user');