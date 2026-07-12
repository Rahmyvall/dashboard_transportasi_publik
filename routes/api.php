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
use App\Http\Controllers\Api\VehiclePositionController;





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


        Route::post(
            'login',
            [
                AuthApiController::class,
                'login'
            ]
        )
            ->name('login');








        /*
    |--------------------------------------------------------------------------
    | PROTECTED ROUTES
    |--------------------------------------------------------------------------
    */


        Route::middleware('auth:sanctum')

            ->group(function () {



                /*
        |--------------------------------------------------------------------------
        | AUTH
        |--------------------------------------------------------------------------
        */


                Route::get(
                    'me',
                    function (Request $request) {


                        return response()->json([

                            'status' => true,

                            'message' => 'User profile',

                            'data' => $request->user()

                        ]);
                    }

                )
                    ->name('me');





                Route::post(
                    'logout',
                    [
                        AuthApiController::class,
                        'logout'
                    ]
                )
                    ->name('logout');









                /*
        |--------------------------------------------------------------------------
        | USERS AND ROLES
        |--------------------------------------------------------------------------
        */


                Route::apiResource(
                    'users',
                    UserApiController::class
                )
                    ->only([

                        'index',
                        'store'

                    ]);




                Route::apiResource(
                    'roles',
                    RoleApiController::class
                )
                    ->only([

                        'index',
                        'store'

                    ]);









                /*
        |--------------------------------------------------------------------------
        | MASTER DATA
        |--------------------------------------------------------------------------
        */


                Route::apiResource(
                    'operators',
                    OperatorController::class
                );



                Route::apiResource(
                    'transport-modes',
                    TransportModeApiController::class
                );



                Route::apiResource(
                    'routes',
                    RouteApiController::class
                );



                Route::apiResource(
                    'stops',
                    StopApiController::class
                );



                Route::apiResource(
                    'route-stops',
                    RouteStopApiController::class
                );



                Route::apiResource(
                    'vehicles',
                    VehicleApiController::class
                );



                Route::apiResource(
                    'drivers',
                    DriverController::class
                );



                Route::apiResource(
                    'schedules',
                    ScheduleController::class
                );









                /*
        |--------------------------------------------------------------------------
        | VEHICLE POSITION TRACKING API
        |--------------------------------------------------------------------------
        */


                Route::prefix('vehicle-positions')

                    ->name('vehicle-positions.')

                    ->group(function () {





                        /*
            | Simpan data GPS kendaraan
            |
            | POST
            | /api/v1/vehicle-positions/store
            |
            */


                        Route::post(
                            'store',
                            [
                                VehiclePositionController::class,
                                'store'
                            ]
                        )
                            ->name('store');







                        /*
            | Semua history posisi
            |
            | GET
            | /api/v1/vehicle-positions
            |
            */


                        Route::get(
                            '/',
                            [
                                VehiclePositionController::class,
                                'index'
                            ]
                        )
                            ->name('index');







                        /*
            | Posisi terakhir kendaraan
            |
            | GET
            | /api/v1/vehicle-positions/latest/{vehicle_id}
            |
            */


                        Route::get(
                            'latest/{vehicle_id}',
                            [
                                VehiclePositionController::class,
                                'latest'
                            ]
                        )
                            ->name('latest');








                        /*
            | Detail posisi
            |
            | GET
            | /api/v1/vehicle-positions/{id}
            |
            */


                        Route::get(
                            '{id}',
                            [
                                VehiclePositionController::class,
                                'show'
                            ]
                        )
                            ->name('show');
                    });









                /*
        |--------------------------------------------------------------------------
        | TRIPS CUSTOM ROUTES
        |--------------------------------------------------------------------------
        */


                Route::prefix('trips')

                    ->name('trips.')

                    ->group(function () {



                        Route::get(
                            'active',
                            [
                                TripApiController::class,
                                'active'
                            ]
                        )
                            ->name('active');





                        Route::get(
                            'history',
                            [
                                TripApiController::class,
                                'history'
                            ]
                        )
                            ->name('history');





                        Route::get(
                            'stats',
                            [
                                TripApiController::class,
                                'stats'
                            ]
                        )
                            ->name('stats');






                        Route::patch(
                            '{id}/start',
                            [
                                TripApiController::class,
                                'start'
                            ]
                        )
                            ->name('start');






                        Route::patch(
                            '{id}/complete',
                            [
                                TripApiController::class,
                                'complete'
                            ]
                        )
                            ->name('complete');






                        Route::patch(
                            '{id}/delayed',
                            [
                                TripApiController::class,
                                'delayed'
                            ]
                        )
                            ->name('delayed');






                        Route::patch(
                            '{id}/cancel',
                            [
                                TripApiController::class,
                                'cancel'
                            ]
                        )
                            ->name('cancel');
                    });
                /*
        |--------------------------------------------------------------------------
        | TRIPS RESOURCE
        |--------------------------------------------------------------------------
        */


                Route::apiResource(
                    'trips',
                    TripApiController::class
                );
            });
    });
