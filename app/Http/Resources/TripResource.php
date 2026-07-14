<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'schedule_id' => $this->schedule_id,
            'route_id' => $this->route_id,
            'vehicle_id' => $this->vehicle_id,
            'driver_id' => $this->driver_id,

            'trip_code' => $this->trip_code,

            'planned_start_time' =>
            $this->planned_start_time?->toISOString(),

            'planned_end_time' =>
            $this->planned_end_time?->toISOString(),

            'actual_start_time' =>
            $this->actual_start_time?->toISOString(),

            'actual_end_time' =>
            $this->actual_end_time?->toISOString(),

            'status' => $this->status->value,

            'delay_minutes' => $this->delay_minutes,
            'notes' => $this->notes,

            'schedule' => $this->whenLoaded(
                'schedule',
                fn() => $this->schedule
                    ? [
                        'id' => $this->schedule->id,
                    ]
                    : null
            ),

            'route' => $this->whenLoaded(
                'route',
                fn() => [
                    'id' => $this->route->id,
                ]
            ),

            'vehicle' => $this->whenLoaded(
                'vehicle',
                fn() => [
                    'id' => $this->vehicle->id,
                ]
            ),

            'driver' => $this->whenLoaded(
                'driver',
                fn() => $this->driver
                    ? [
                        'id' => $this->driver->id,
                    ]
                    : null
            ),

            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
