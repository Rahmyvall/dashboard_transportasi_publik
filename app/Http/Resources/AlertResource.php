<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlertResource extends JsonResource
{

    public function toArray(Request $request): array
    {

        return [

            'id'           => $this->id,

            'title'        => $this->title,

            'message'      => $this->message,

            'alert_type'   => $this->alert_type,

            'priority'     => $this->priority,

            'status'       => $this->status,

            'published'    => $this->is_published,

            'published_at' => $this->published_at,

            'expired_at'   => $this->expired_at,

            'created_at'   => $this->created_at,

            'incident'     => [

                'id'    => $this->incident?->id,

                'title' => $this->incident?->title,

            ],

            'route'        => [

                'id'          => $this->route?->id,

                'name'        => $this->route?->route_name,

                'origin'      => $this->route?->origin,

                'destination' => $this->route?->destination,

            ],

            'vehicle'      => [

                'id'     => $this->vehicle?->id,

                'number' => $this->vehicle?->vehicle_number,

            ],

        ];

    }

}