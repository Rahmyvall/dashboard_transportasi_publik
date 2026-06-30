<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\RoleApiController;
use App\Http\Controllers\Api\OperatorController;
use App\Http\Controllers\Api\RouteApiController;
use App\Http\Controllers\Api\TransportModeApiController;

/*
|--------------------------------------------------------------------------
| API VERSION 1
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    /*
    |--------------------------
    | PUBLIC ROUTES (NO TOKEN)
    |--------------------------
    */
    Route::post('/login', [AuthApiController::class, 'login']);

    /*
    |--------------------------
    | PROTECTED ROUTES (SANCTUM)
    |--------------------------
    */
    Route::middleware('auth:sanctum')->group(function () {

        /*
        | PROFILE
        */
        Route::get('/me', function (Request $request) {
            return response()->json([
                'status' => true,
                'message' => 'User profile',
                'data' => $request->user()
            ]);
        });

        Route::post('/logout', [AuthApiController::class, 'logout']);

        /*
        | USERS MODULE
        */
        Route::prefix('users')->group(function () {
            Route::get('/', [UserApiController::class, 'index']);
            Route::post('/', [UserApiController::class, 'store']);
        });

        /*
        | ROLES MODULE
        */
        Route::prefix('roles')->group(function () {
            Route::get('/', [RoleApiController::class, 'index']);
            Route::post('/', [RoleApiController::class, 'store']);
        });

        /*
        | OPERATORS MODULE
        */
        Route::prefix('operators')->group(function () {
            Route::get('/', [OperatorController::class, 'index']);
            Route::post('/', [OperatorController::class, 'store']);
            Route::get('/{id}', [OperatorController::class, 'show']);
            Route::put('/{id}', [OperatorController::class, 'update']);
            Route::delete('/{id}', [OperatorController::class, 'destroy']);
        });

        /*
        | TRANSPORT MODES MODULE
        */
        Route::prefix('transport-modes')->group(function () {
            Route::get('/', [TransportModeApiController::class, 'index']);
            Route::post('/', [TransportModeApiController::class, 'store']);
            Route::get('/{id}', [TransportModeApiController::class, 'show']);
            Route::put('/{id}', [TransportModeApiController::class, 'update']);
            Route::delete('/{id}', [TransportModeApiController::class, 'destroy']);
        });

        Route::prefix('routes')->group(function () {
        Route::get('/', [RouteApiController::class, 'index']);
        Route::get('/{id}', [RouteApiController::class, 'show']);
        Route::post('/', [RouteApiController::class, 'store']);
        Route::put('/{id}', [RouteApiController::class, 'update']);
        Route::delete('/{id}', [RouteApiController::class, 'destroy']);
    });

    });

});