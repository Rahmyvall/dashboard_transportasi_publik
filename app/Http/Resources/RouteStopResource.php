<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RouteStopResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'route_id' => $this->route_id,
            'stop_id' => $this->stop_id,

            'stop_order' => $this->stop_order,

            'distance_from_start_km' =>
            $this->distance_from_start_km !== null
                ? (float) $this->distance_from_start_km
                : null,

            'estimated_arrival_minutes' =>
            $this->estimated_arrival_minutes,

            'route' => $this->whenLoaded('route', function () {
                return [
                    'id' => $this->route->id,

                    // Sesuaikan nama kolom pada tabel routes.
                    'name' => $this->route->name ?? null,
                    'code' => $this->route->code ?? null,
                ];
            }),

            'stop' => $this->whenLoaded('stop', function () {
                return [
                    'id' => $this->stop->id,

                    // Sesuaikan nama kolom pada tabel stops.
                    'name' => $this->stop->name ?? null,
                    'code' => $this->stop->code ?? null,
                    'latitude' => $this->stop->latitude ?? null,
                    'longitude' => $this->stop->longitude ?? null,
                ];
            }),

            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
