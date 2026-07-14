<?php

namespace App\Http\Resources;

use App\Enums\DriverStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $status = $this->status instanceof DriverStatus
            ? $this->status
            : DriverStatus::tryFrom((string) $this->status);

        return [
            'id' => $this->id,

            'operator_id' => $this->operator_id,

            'operator' => $this->whenLoaded('operator', function () {
                return [
                    'id' => $this->operator->id,

                    // Sesuaikan nama kolom ini dengan tabel operators.
                    'operator_name' => $this->operator->operator_name
                        ?? $this->operator->name
                        ?? null,
                ];
            }),

            'driver_name' => $this->driver_name,
            'license_number' => $this->license_number,
            'phone' => $this->phone,
            'address' => $this->address,

            'status' => $status?->value,
            'status_label' => $status?->label(),

            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
            'deleted_at' => $this->deleted_at?->toISOString(),
        ];
    }
}
