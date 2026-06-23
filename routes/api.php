<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;

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
| USER REST API (SESUAI DATABASE USERS)
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function () {

    Route::get('/users', [UserApiController::class, 'index']);
    Route::get('/users/{id}', [UserApiController::class, 'show']);

    Route::post('/users', [UserApiController::class, 'store']);

    Route::put('/users/{id}', [UserApiController::class, 'update']);

    Route::delete('/users/{id}', [UserApiController::class, 'destroy']);
});