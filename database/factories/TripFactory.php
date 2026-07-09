<?php

namespace Database\Factories;

use App\Models\Route;
use App\Models\Trip;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripFactory extends Factory
{
    protected $model = Trip::class;


    public function definition(): array
    {
        return [

            'schedule_id' => Schedule::inRandomOrder()->first()?->id,

            'route_id' => Route::inRandomOrder()->first()->id,

            'vehicle_id' => Vehicle::inRandomOrder()->first()->id,

            'driver_id' => Driver::inRandomOrder()->first()?->id,

            'trip_code' => 'TRIP-' . fake()->unique()->numberBetween(1000,9999),

            'planned_start_time' => fake()->dateTimeBetween(
                'now',
                '+7 days'
            ),

            'planned_end_time' => fake()->dateTimeBetween(
                '+7 days',
                '+10 days'
            ),

            'actual_start_time' => null,

            'actual_end_time' => null,

            'status' => fake()->randomElement([
                'scheduled',
                'running',
                'completed',
                'cancelled',
                'delayed'
            ]),

            'delay_minutes' => fake()->numberBetween(
                0,
                120
            ),

            'notes' => fake()->sentence(),

        ];
    }
}