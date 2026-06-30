<?php

use App\Http\Controllers\Admin\RouteController;
use App\Http\Controllers\Admin\TransportModeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OperatorController;
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

/*
|--------------------------------------------------------------------------
| PROTECTED AREA (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('web')->group(function () {

    // dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('dashboard/armada', [DashboardController::class, 'armada'])
        ->name('dashboard.armada');

    Route::get('dashboard/perjalanan', [DashboardController::class, 'perjalanan'])
        ->name('dashboard.perjalanan');

    Route::get('dashboard/penumpang', [DashboardController::class, 'penumpang'])
        ->name('dashboard.penumpang');
    
     Route::get('dashboard/peta', [DashboardController::class, 'peta'])
        ->name('dashboard.peta');

    // logout harus login
    Route::post('logout', [AuthController::class, 'logout'])
        ->name('logout');

    /*
    |--------------------------------------------------------------------------
    | ADMIN AREA
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {

        // USERS
        Route::resource('users', UserController::class);

        // ROLES
        Route::resource('roles', RoleController::class);

        // OPERATORS
        Route::resource('operators', OperatorController::class);

        // PRINT OPERATOR LIST
        Route::get('operators/print', [OperatorController::class, 'print'])
            ->name('operators.print');

        // PRINT DETAIL OPERATOR
        Route::get('operators/{id}/print', [OperatorController::class, 'printDetail'])
            ->name('operators.print.detail');
        
        Route::resource('transport-modes', TransportModeController::class);

        Route::resource('routes', RouteController::class);

    });

});