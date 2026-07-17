<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaintenanceLogResource extends JsonResource
{
    /**
     * Transform resource menjadi array JSON.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $maintenanceType = (string) (
            $this->resource->getRawOriginal('maintenance_type') ?? $this->maintenance_type
        );

        $status = (string) (
            $this->resource->getRawOriginal('status') ?? $this->status
        );

        $maintenanceTypeLabels = [
            'routine'    => 'Perawatan Rutin',
            'repair'     => 'Perbaikan',
            'inspection' => 'Inspeksi',
            'emergency'  => 'Darurat',
        ];

        $statusLabels = [
            'scheduled'   => 'Dijadwalkan',
            'in_progress' => 'Sedang Dikerjakan',
            'completed'   => 'Selesai',
            'cancelled'   => 'Dibatalkan',
        ];

        return [
            'id'                    => $this->id,

            'vehicle_id'            => $this->vehicle_id,

            'vehicle'               => $this->whenLoaded(
                'vehicle',
                function (): array {
                    return [
                        'id'           => $this->vehicle?->id,

                        'plate_number' =>
                        $this->vehicle?->plate_number,

                        'name'         =>
                        $this->vehicle?->name,

                        'display_name' =>
                        $this->vehicle?->plate_number ?? $this->vehicle?->name ?? 'Kendaraan #' . $this->vehicle_id,
                    ];
                }
            ),

            'maintenance_type'      => [
                'value' => $maintenanceType,
                'label' => $maintenanceTypeLabels[
                    $maintenanceType
                ] ?? ucfirst(
                    str_replace('_', ' ', $maintenanceType)
                ),
            ],

            'description'           => $this->description,

            'cost'                  => (float) $this->cost,

            'cost_formatted'        => 'Rp ' . number_format(
                (float) $this->cost,
                0,
                ',',
                '.'
            ),

            'maintenance_date'      =>
            $this->maintenance_date?->format('Y-m-d'),

            'next_maintenance_date' =>
            $this->next_maintenance_date?->format('Y-m-d'),

            'status'                => [
                'value' => $status,
                'label' => $statusLabels[$status] ?? ucfirst(str_replace('_', ' ', $status)),
            ],

            'handled_by'            => $this->handled_by,

            'created_at'            =>
            $this->created_at?->toIso8601String(),

            'updated_at'            =>
            $this->updated_at?->toIso8601String(),
        ];
    }
}