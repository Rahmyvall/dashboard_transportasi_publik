<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RouteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'operator_id' => $this->operator_id,

            'transport_mode_id' =>
            $this->transport_mode_id,

            'route_code' => $this->route_code,
            'route_name' => $this->route_name,

            'origin' => $this->origin,
            'destination' => $this->destination,

            'distance_km' => $this->distance_km !== null
                ? (float) $this->distance_km
                : null,

            'estimated_duration_minutes' =>
            $this->estimated_duration_minutes,

            'estimated_duration_formatted' =>
            $this->formatDuration(
                $this->estimated_duration_minutes
            ),

            'status' => $this->status,

            'operator' => $this->whenLoaded(
                'operator',
                function () {
                    return [
                        'id' => $this->operator?->id,

                        /*
                         * Sesuaikan nama kolom berikut dengan
                         * struktur tabel operators.
                         */
                        'name' =>
                        $this->operator?->operator_name
                            ?? $this->operator?->name
                            ?? null,

                        'code' =>
                        $this->operator?->operator_code
                            ?? $this->operator?->code
                            ?? null,
                    ];
                }
            ),

            'transport_mode' => $this->whenLoaded(
                'transportMode',
                function () {
                    return [
                        'id' => $this->transportMode?->id,

                        /*
                         * Sesuaikan nama kolom berikut dengan
                         * struktur tabel transport_modes.
                         */
                        'name' =>
                        $this->transportMode?->mode_name
                            ?? $this->transportMode?->name
                            ?? null,

                        'code' =>
                        $this->transportMode?->mode_code
                            ?? $this->transportMode?->code
                            ?? null,
                    ];
                }
            ),

            'is_deleted' => $this->trashed(),

            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
            'deleted_at' => $this->deleted_at?->toISOString(),
        ];
    }

    private function formatDuration(?int $minutes): ?string
    {
        if ($minutes === null) {
            return null;
        }

        $hours = intdiv($minutes, 60);
        $remainingMinutes = $minutes % 60;

        if ($hours === 0) {
            return "{$remainingMinutes} menit";
        }

        if ($remainingMinutes === 0) {
            return "{$hours} jam";
        }

        return "{$hours} jam {$remainingMinutes} menit";
    }
}
