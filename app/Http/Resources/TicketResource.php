<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'ticket_code' => $this->ticket_code,

            'trip_id' => $this->trip_id,
            'route_id' => $this->route_id,
            'vehicle_id' => $this->vehicle_id,

            'payment_method' => $this->payment_method,

            'payment_label' => match ($this->payment_method) {
                'cash' => 'Tunai',
                'emoney' => 'E-Money',
                'qris' => 'QRIS',
                'card' => 'Kartu Debit/Kredit',
                default => 'Lainnya',
            },

            'fare' => (float) $this->fare,

            'fare_formatted' => 'Rp '
                . number_format(
                    (float) $this->fare,
                    0,
                    ',',
                    '.'
                ),

            'ticket_status' => $this->ticket_status,

            'status_label' => match ($this->ticket_status) {
                'paid' => 'Dibayar',
                'refunded' => 'Dikembalikan',
                'failed' => 'Gagal',
                default => ucfirst(
                    (string) $this->ticket_status
                ),
            },

            'issued_at' =>
            $this->issued_at?->toISOString(),

            'issued_at_formatted' =>
            $this->issued_at
                ? $this->issued_at->format(
                    'd-m-Y H:i'
                )
                : null,

            'trip' => $this->whenLoaded(
                'trip',
                function (): ?array {
                    if ($this->trip === null) {
                        return null;
                    }

                    return [
                        'id' => $this->trip->id,
                    ];
                }
            ),

            'route' => $this->whenLoaded(
                'route',
                function (): ?array {
                    if ($this->route === null) {
                        return null;
                    }

                    return [
                        'id' => $this->route->id,
                    ];
                }
            ),

            'vehicle' => $this->whenLoaded(
                'vehicle',
                function (): ?array {
                    if ($this->vehicle === null) {
                        return null;
                    }

                    return [
                        'id' => $this->vehicle->id,
                    ];
                }
            ),

            'created_at' =>
            $this->created_at?->toISOString(),

            'updated_at' =>
            $this->updated_at?->toISOString(),
        ];
    }
}
