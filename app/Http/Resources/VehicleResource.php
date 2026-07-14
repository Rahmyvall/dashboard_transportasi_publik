<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'operator_id' => $this->operator_id,
            'transport_mode_id' => $this->transport_mode_id,

            'vehicle_code' => $this->vehicle_code,
            'plate_number' => $this->plate_number,

            'capacity' => $this->capacity,
            'manufacture_year' => $this->manufacture_year,

            'status' => $this->status,
            'status_label' => $this->getStatusLabel(),

            'last_service_date' => $this->last_service_date?->format('Y-m-d'),
            'notes' => $this->notes,

            'relationships' => [
                'operator' => [
                    'id' => $this->operator_id,
                ],
                'transport_mode' => [
                    'id' => $this->transport_mode_id,
                ],
            ],

            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
            'deleted_at' => $this->deleted_at?->toISOString(),
            'is_deleted' => $this->trashed(),
        ];
    }

    private function getStatusLabel(): string
    {
        return match ($this->status) {
            'available' => 'Tersedia',
            'on_trip' => 'Dalam Perjalanan',
            'maintenance' => 'Dalam Perawatan',
            'inactive' => 'Tidak Aktif',
            default => $this->status,
        };
    }
}
