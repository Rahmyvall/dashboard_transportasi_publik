<?php

use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\RouteController;
use App\Http\Controllers\Admin\RouteStopController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Admin\StopController;
use App\Http\Controllers\Admin\TransportModeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PassengerCountController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehiclePositionController;
use Illuminate\Support\Facades\Route;


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

Route::get(
    'login',
    [AuthController::class, 'login']
)
    ->name('login.form');


Route::post(
    'login',
    [AuthController::class, 'processLogin']
)
    ->name('login.process');




/*
|--------------------------------------------------------------------------
| PROTECTED AREA
|--------------------------------------------------------------------------
*/

Route::middleware('web')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get(
        'dashboard',
        [DashboardController::class, 'index']
    )
        ->name('dashboard');


    Route::get(
        'dashboard/armada',
        [DashboardController::class, 'armada']
    )
        ->name('dashboard.armada');


    Route::get(
        'dashboard/perjalanan',
        [DashboardController::class, 'perjalanan']
    )
        ->name('dashboard.perjalanan');


    Route::get(
        'dashboard/penumpang',
        [DashboardController::class, 'penumpang']
    )
        ->name('dashboard.penumpang');


    Route::get(
        'dashboard/peta',
        [DashboardController::class, 'peta']
    )
        ->name('dashboard.peta');



    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    Route::post(
        'logout',
        [AuthController::class, 'logout']
    )
        ->name('logout');




    /*
    |--------------------------------------------------------------------------
    | ADMIN AREA
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')
        ->name('admin.')
        ->group(function () {



            /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */

            Route::resource(
                'users',
                UserController::class
            );



            /*
        |--------------------------------------------------------------------------
        | ROLES
        |--------------------------------------------------------------------------
        */

            Route::resource(
                'roles',
                RoleController::class
            );



            /*
        |--------------------------------------------------------------------------
        | OPERATORS
        |--------------------------------------------------------------------------
        */

            Route::resource(
                'operators',
                OperatorController::class
            );


            Route::get(
                'operators/print',
                [OperatorController::class, 'print']
            )
                ->name('operators.print');


            Route::get(
                'operators/{id}/print',
                [OperatorController::class, 'printDetail']
            )
                ->name('operators.print.detail');




            /*
        |--------------------------------------------------------------------------
        | MASTER DATA
        |--------------------------------------------------------------------------
        */

            Route::resource(
                'transport-modes',
                TransportModeController::class
            );


            Route::resource(
                'routes',
                RouteController::class
            );


            Route::resource(
                'stops',
                StopController::class
            );


            Route::patch(
                'stops/{id}/toggle-status',
                [StopController::class, 'toggleStatus']
            )
                ->name('stops.toggle-status');


            Route::get(
                'stops/map-data',
                [StopController::class, 'mapData']
            )
                ->name('stops.mapData');


            Route::resource(
                'route-stops',
                RouteStopController::class
            );




            /*
        |--------------------------------------------------------------------------
        | VEHICLE MANAGEMENT
        |--------------------------------------------------------------------------
        */

            Route::resource(
                'vehicles',
                VehicleController::class
            );


            Route::resource(
                'drivers',
                DriverController::class
            );



            Route::prefix('drivers')
                ->name('drivers.')
                ->group(function () {


                    Route::get(
                        'status/active',
                        [DriverController::class, 'active']
                    )
                        ->name('active');


                    Route::get(
                        'status/on-duty',
                        [DriverController::class, 'onDuty']
                    )
                        ->name('onDuty');


                    Route::get(
                        'status/inactive',
                        [DriverController::class, 'inactive']
                    )
                        ->name('inactive');
                });

            Route::resource(
                'vehicle-positions',
                VehiclePositionController::class
            );



            Route::get(
                'vehicle-tracking/{vehicle_id}',
                [
                    VehiclePositionController::class,
                    'tracking'
                ]
            )
                ->name('vehicle-tracking');



            Route::get(
                'vehicle-positions/latest/{vehicle_id}',
                [
                    VehiclePositionController::class,
                    'latest'
                ]
            )
                ->name('vehicle-positions.latest');





            /*
        |--------------------------------------------------------------------------
        | OPERATION
        |--------------------------------------------------------------------------
        */

            Route::resource(
                'schedules',
                AdminScheduleController::class
            );



            Route::get(
                'trips/active',
                [TripController::class, 'active']
            )
                ->name('trips.active');



            Route::get(
                'trips/history',
                [TripController::class, 'history']
            )
                ->name('trips.history');



            Route::resource(
                'trips',
                TripController::class
            );



            Route::patch(
                'trips/{id}/start',
                [TripController::class, 'start']
            )
                ->name('trips.start');



            Route::patch(
                'trips/{id}/complete',
                [TripController::class, 'complete']
            )
                ->name('trips.complete');



            Route::patch(
                'trips/{id}/cancel',
                [TripController::class, 'cancel']
            )
                ->name('trips.cancel');

            Route::resource(
                'passenger-counts',
                PassengerCountController::class
            );


            Route::resource(
                'tickets',
                TicketController::class
            );
            Route::resource('tickets', TicketController::class);
        });
});
