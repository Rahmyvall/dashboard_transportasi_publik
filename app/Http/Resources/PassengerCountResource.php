<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PassengerCountResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $occupancyPercentage = null;

        if ($this->vehicle_capacity) {
            $occupancyPercentage = round(
                ($this->current_load / $this->vehicle_capacity) * 100,
                2
            );
        }

        return [
            'id' => $this->id,

            'trip_id' => $this->trip_id,
            'vehicle_id' => $this->vehicle_id,
            'stop_id' => $this->stop_id,

            'boarding_count' => $this->boarding_count,
            'alighting_count' => $this->alighting_count,
            'current_load' => $this->current_load,
            'vehicle_capacity' => $this->vehicle_capacity,

            'occupancy_percentage' => $occupancyPercentage,
            'is_over_capacity' => $this->vehicle_capacity !== null
                && $this->current_load > $this->vehicle_capacity,

            'recorded_at' => $this->recorded_at?->toISOString(),

            'trip' => $this->whenLoaded('trip', function () {
                return [
                    'id' => $this->trip->id,
                ];
            }),

            'vehicle' => $this->whenLoaded('vehicle', function () {
                return [
                    'id' => $this->vehicle->id,
                ];
            }),

            'stop' => $this->whenLoaded('stop', function () {
                if (!$this->stop) {
                    return null;
                }

                return [
                    'id' => $this->stop->id,
                ];
            }),

            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
