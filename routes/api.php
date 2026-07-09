<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\RoleApiController;
use App\Http\Controllers\Api\OperatorController;
use App\Http\Controllers\Api\RouteApiController;
use App\Http\Controllers\Api\RouteStopApiController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\TransportModeApiController;
use App\Http\Controllers\Api\TripApiController;
use App\Http\Controllers\Api\StopApiController;
use App\Http\Controllers\Api\VehicleApiController;
use App\Http\Controllers\Api\DriverController;

/*
|--------------------------------------------------------------------------
| API VERSION 1
|--------------------------------------------------------------------------
*/

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
            | USERS AND ROLES
            |--------------------------------------------------------------------------
            */

            Route::apiResource('users', UserApiController::class)
                ->only(['index', 'store']);

            Route::apiResource('roles', RoleApiController::class)
                ->only(['index', 'store']);

            /*
            |--------------------------------------------------------------------------
            | MASTER DATA
            |--------------------------------------------------------------------------
            */

            Route::apiResource('operators', OperatorController::class);
            Route::apiResource('transport-modes', TransportModeApiController::class);
            Route::apiResource('routes', RouteApiController::class);
            Route::apiResource('stops', StopApiController::class);
            Route::apiResource('route-stops', RouteStopApiController::class);
            Route::apiResource('vehicles', VehicleApiController::class);
            Route::apiResource('drivers', DriverController::class);
            Route::apiResource('schedules', ScheduleController::class);

            /*
            |--------------------------------------------------------------------------
            | TRIPS CUSTOM ROUTES
            |--------------------------------------------------------------------------
            | active, history, dan stats harus ditaruh sebelum apiResource trips.
            |--------------------------------------------------------------------------
            */

            Route::prefix('trips')
                ->name('trips.')
                ->group(function () {

                    Route::get('active', [TripApiController::class, 'active'])
                        ->name('active');

                    Route::get('history', [TripApiController::class, 'history'])
                        ->name('history');

                    Route::get('stats', [TripApiController::class, 'stats'])
                        ->name('stats');

                    Route::patch('{id}/start', [TripApiController::class, 'start'])
                        ->name('start');

                    Route::patch('{id}/complete', [TripApiController::class, 'complete'])
                        ->name('complete');

                    Route::patch('{id}/delayed', [TripApiController::class, 'delayed'])
                        ->name('delayed');

                    Route::patch('{id}/cancel', [TripApiController::class, 'cancel'])
                        ->name('cancel');
                });

            /*
            |--------------------------------------------------------------------------
            | TRIPS RESOURCE
            |--------------------------------------------------------------------------
            */

            Route::apiResource('trips', TripApiController::class);
        });
    });
