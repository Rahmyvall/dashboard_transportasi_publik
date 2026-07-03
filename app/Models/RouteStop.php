<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouteStop extends Model
{
    protected $table = 'route_stops';

    protected $fillable = [
        'route_id',
        'stop_id',
        'stop_order',
        'distance_from_start_km',
        'estimated_arrival_minutes',
    ];

    protected $casts = [
        'route_id' => 'integer',
        'stop_id' => 'integer',
        'stop_order' => 'integer',
        'distance_from_start_km' => 'decimal:2',
        'estimated_arrival_minutes' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }

    public function stop()
    {
        return $this->belongsTo(Stop::class, 'stop_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeByRoute($query, $routeId)
    {
        return $query->where('route_id', $routeId);
    }

    public function scopeByStop($query, $stopId)
    {
        return $query->where('stop_id', $stopId);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('stop_order', 'asc');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function isFirstStop()
    {
        return $this->stop_order === 1;
    }

    public function isLastStop()
    {
        return self::where('route_id', $this->route_id)
            ->max('stop_order') === $this->stop_order;
    }

    public function getFormattedDistance()
    {
        return $this->distance_from_start_km !== null
            ? number_format($this->distance_from_start_km, 2) . ' km'
            : '-';
    }

    public function getFormattedArrivalTime()
    {
        return $this->estimated_arrival_minutes !== null
            ? $this->estimated_arrival_minutes . ' menit'
            : '-';
    }
}