<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'status' => $this->status,

            'role' => $this->whenLoaded('role', function () {
                return [
                    'id' => $this->role->id,
                    'name' => $this->role->name,
                ];
            }),

            'operator' => $this->whenLoaded('operator', function () {
                return $this->operator
                    ? [
                        'id' => $this->operator->id,
                        'name' => $this->operator->name,
                    ]
                    : null;
            }),

            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
