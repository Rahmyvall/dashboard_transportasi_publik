<?php

namespace Database\Seeders;

use App\Models\Alert;
use App\Models\Incident;
use App\Models\Route;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class AlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan data relasi tersedia
        $incidents = Incident::pluck('id')->toArray();
        $routes    = Route::pluck('id')->toArray();
        $vehicles  = Vehicle::pluck('id')->toArray();


        Alert::factory()
            ->count(100)
            ->create()
            ->each(function ($alert) use (
                $incidents,
                $routes,
                $vehicles
            ) {

                $alert->update([

                    'incident_id' => !empty($incidents)
                        ? fake()->randomElement($incidents)
                        : null,

                    'route_id' => !empty($routes)
                        ? fake()->randomElement($routes)
                        : null,

                    'vehicle_id' => !empty($vehicles)
                        ? fake()->randomElement($vehicles)
                        : null,

                ]);
            });
    }
}
