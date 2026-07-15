<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Incident;


class IncidentSeeder extends Seeder
{

    public function run(): void
    {


        Incident::create([

            'trip_id' => 1,

            'vehicle_id' => 1,

            'route_id' => 1,

            'reported_by' => 1,


            'incident_type' => 'breakdown',

            'title' => 'Mesin Bus Mengalami Kerusakan',

            'description' => 'Bus berhenti karena gangguan mesin.',


            'severity' => 'high',

            'status' => 'in_progress',


            'location_latitude' => -6.2000000,

            'location_longitude' => 106.8166667,


            'reported_at' => now(),

            'resolved_at' => null,

        ]);



        Incident::create([

            'trip_id' => 2,

            'vehicle_id' => 2,

            'route_id' => 2,

            'reported_by' => 1,


            'incident_type' => 'traffic',

            'title' => 'Kemacetan Jalur Utama',


            'description' => 'Perjalanan terlambat akibat kemacetan.',


            'severity' => 'medium',

            'status' => 'resolved',


            'location_latitude' => -6.914744,

            'location_longitude' => 107.609810,


            'reported_at' => now()->subHours(2),

            'resolved_at' => now(),

        ]);
    }
}
