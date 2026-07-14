<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\OperatorController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\RouteController;
use App\Http\Controllers\Api\RouteStopController;
use App\Http\Controllers\Api\StopController;
use App\Http\Controllers\Api\TransportModeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VehicleController;

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
            Route::apiResource('operators', OperatorController::class);
            Route::apiResource(
                'transport-modes',
                TransportModeController::class
            );
            Route::patch(
                'routes/{id}/restore',
                [RouteController::class, 'restore']
            )->whereNumber('id');

            Route::delete(
                'routes/{id}/force',
                [RouteController::class, 'forceDelete']
            )->whereNumber('id');

            Route::apiResource(
                'routes',
                RouteController::class
            );
            Route::patch(
                '/stops/{stop}/status',
                [StopController::class, 'updateStatus']
            );

            Route::apiResource('/stops', StopController::class);
            Route::patch(
                '/routes/{route}/route-stops/reorder',
                [RouteStopController::class, 'reorder']
            );

            Route::apiResource(
                'route-stops',
                RouteStopController::class
            )->parameters([
                'route-stops' => 'routeStop',
            ]);
            Route::prefix('vehicles')
                ->name('vehicles.')
                ->group(function () {
                    Route::post(
                        '{vehicle}/restore',
                        [VehicleController::class, 'restore']
                    )->name('restore');

                    Route::delete(
                        '{vehicle}/force',
                        [VehicleController::class, 'forceDestroy']
                    )->name('force-destroy');
                });

            /*
|--------------------------------------------------------------------------
| Detail Vehicle
|--------------------------------------------------------------------------
| withTrashed memungkinkan detail kendaraan yang sudah di-soft-delete
| tetap dapat ditampilkan.
*/
            Route::get(
                'vehicles/{vehicle}',
                [VehicleController::class, 'show']
            )
                ->withTrashed()
                ->name('vehicles.show');

            Route::apiResource(
                'vehicles',
                VehicleController::class
            )->except([
                'show',
            ]);
            Route::get('/drivers/trashed', [
                DriverController::class,
                'trashed',
            ]);

            Route::patch('/drivers/{id}/restore', [
                DriverController::class,
                'restore',
            ])->whereNumber('id');

            Route::delete('/drivers/{id}/force', [
                DriverController::class,
                'forceDelete',
            ])->whereNumber('id');

            Route::apiResource('drivers', DriverController::class);
        });
    });
