<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransportRoute extends Model
{
    use SoftDeletes;

    protected $table = 'routes';

    protected $fillable = [
        'operator_id',
        'transport_mode_id',
        'route_code',
        'route_name',
        'origin',
        'destination',
        'distance_km',
        'estimated_duration_minutes',
        'status',
    ];

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    public function transportMode()
    {
        return $this->belongsTo(TransportMode::class);
    }
}