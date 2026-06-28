<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\RoleApiController;
use App\Http\Controllers\Api\OperatorController;

Route::prefix('v1')->group(function () {

    /*
    |--------------------------
    | PUBLIC ROUTES
    |--------------------------
    */
    Route::post('/login', [AuthApiController::class, 'login']);

    /*
    |--------------------------
    | PROTECTED ROUTES
    |--------------------------
    */
    Route::middleware('auth:sanctum')->group(function () {

        // PROFILE
        Route::get('/me', function (Request $request) {
            return response()->json([
                'status' => true,
                'data' => $request->user()
            ]);
        });

        Route::post('/logout', [AuthApiController::class, 'logout']);

        /*
        |--------------------------
        | USERS MODULE
        |--------------------------
        */
        Route::prefix('users')->group(function () {
            Route::get('/', [UserApiController::class, 'index']);
            Route::post('/', [UserApiController::class, 'store']);
        });

        /*
        |--------------------------
        | ROLES MODULE
        |--------------------------
        */
        Route::prefix('roles')->group(function () {
            Route::get('/', [RoleApiController::class, 'index']);
            Route::post('/', [RoleApiController::class, 'store']);
        });

        /*
        |--------------------------
        | OPERATORS MODULE (NEW)
        |--------------------------
        */
        Route::prefix('operators')->group(function () {
            Route::get('/', [OperatorController::class, 'index']);
            Route::post('/', [OperatorController::class, 'store']);
            Route::get('/{id}', [OperatorController::class, 'show']);
            Route::put('/{id}', [OperatorController::class, 'update']);
            Route::delete('/{id}', [OperatorController::class, 'destroy']);
        });

    });
});