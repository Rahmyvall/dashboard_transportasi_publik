<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StopResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'stop_code' => $this->stop_code,
            'stop_name' => $this->stop_name,
            'stop_type' => $this->stop_type,

            'location' => [
                'latitude' => $this->latitude !== null
                    ? (float) $this->latitude
                    : null,

                'longitude' => $this->longitude !== null
                    ? (float) $this->longitude
                    : null,
            ],

            'address' => $this->address,
            'is_active' => (bool) $this->is_active,
            'created_at' => $this->created_at?->format(
                'Y-m-d H:i:s'
            ),
            'updated_at' => $this->updated_at?->format(
                'Y-m-d H:i:s'
            ),
        ];
    }
}
