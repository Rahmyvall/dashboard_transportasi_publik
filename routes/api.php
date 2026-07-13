<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\OperatorController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;

Route::prefix('v1')
    ->name('api.v1.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | PUBLIC ROUTES
        |--------------------------------------------------------------------------
        */

        Route::post('login', [AuthApiController::class, 'login'])
            ->name('login');

        /*
        |--------------------------------------------------------------------------
        | PROTECTED ROUTES
        |--------------------------------------------------------------------------
        */

        Route::middleware('auth:sanctum')->group(function () {

            /*
            |--------------------------------------------------------------------------
            | AUTH
            |--------------------------------------------------------------------------
            */

            Route::get('me', function (Request $request) {
                return response()->json([
                    'status' => true,
                    'message' => 'User profile',
                    'data' => $request->user(),
                ]);
            })->name('me');

            Route::post('logout', [AuthApiController::class, 'logout'])
                ->name('logout');

            /*
            |--------------------------------------------------------------------------
            | MASTER DATA
            |--------------------------------------------------------------------------
            */

            Route::apiResource('roles', RoleController::class);
            Route::apiResource('users', UserController::class);
        });
    });
