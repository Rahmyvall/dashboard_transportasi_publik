<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehiclePositionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'vehicle_id' => $this->vehicle_id,
            'trip_id' => $this->trip_id,

            'latitude' => (float) $this->latitude,
            'longitude' => (float) $this->longitude,

            'speed_kmh' => (float) $this->speed_kmh,
            'heading_degree' => $this->heading_degree,

            'accuracy_meter' => $this->accuracy_meter !== null
                ? (float) $this->accuracy_meter
                : null,

            'status' => $this->status,

            'recorded_at' => $this->recorded_at?->toIso8601String(),

            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
