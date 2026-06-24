<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\RoleApiController;
use App\Http\Controllers\Api\AuthApiController;

/*
|--------------------------------------------------------------------------
| AUTH USER (SANCTUM)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json([
        'status' => true,
        'message' => 'User authenticated',
        'data' => $request->user()
    ]);
});

/*
|--------------------------------------------------------------------------
| API VERSION 1
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | AUTH (PUBLIC - WAJIB ADA INI)
    |--------------------------------------------------------------------------
    */
    Route::post('/login', [AuthApiController::class, 'login']);

    /*
    |--------------------------------------------------------------------------
    | PROTECTED ROUTES (BUTUH TOKEN)
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth:sanctum')->group(function () {

        // USERS
        Route::get('/users', [UserApiController::class, 'index']);
        Route::get('/users/{id}', [UserApiController::class, 'show']);
        Route::post('/users', [UserApiController::class, 'store']);
        Route::put('/users/{id}', [UserApiController::class, 'update']);
        Route::delete('/users/{id}', [UserApiController::class, 'destroy']);

        // ROLES
        Route::get('/roles', [RoleApiController::class, 'index']);
        Route::get('/roles/{id}', [RoleApiController::class, 'show']);
        Route::post('/roles', [RoleApiController::class, 'store']);
        Route::put('/roles/{id}', [RoleApiController::class, 'update']);
        Route::delete('/roles/{id}', [RoleApiController::class, 'destroy']);

    });

});