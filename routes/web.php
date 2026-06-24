<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
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
| DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::get('dashboard/armada', [DashboardController::class, 'armada'])
    ->name('dashboard.armada');

/*
|--------------------------------------------------------------------------
| ADMIN AREA (RECOMMENDED STRUCTURE)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // USER MANAGEMENT
    Route::resource('users', UserController::class);

    // ROLE MANAGEMENT
    Route::resource('roles', RoleController::class);

});