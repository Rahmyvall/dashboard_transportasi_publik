<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;


    protected $table = 'incidents';


    protected $fillable = [
        'trip_id',
        'vehicle_id',
        'route_id',
        'reported_by',

        'incident_type',
        'title',
        'description',

        'severity',
        'status',

        'location_latitude',
        'location_longitude',

        'reported_at',
        'resolved_at',
    ];


    protected $casts = [

        'trip_id' => 'integer',
        'vehicle_id' => 'integer',
        'route_id' => 'integer',
        'reported_by' => 'integer',

        'location_latitude' => 'decimal:7',
        'location_longitude' => 'decimal:7',

        'reported_at' => 'datetime',
        'resolved_at' => 'datetime',

    ];



    /*
    |--------------------------------------------------------------------------
    | Relasi ke Trip
    |--------------------------------------------------------------------------
    */

    public function trip()
    {
        return $this->belongsTo(
            Trip::class,
            'trip_id'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | Relasi ke Vehicle
    |--------------------------------------------------------------------------
    */

    public function vehicle()
    {
        return $this->belongsTo(
            Vehicle::class,
            'vehicle_id'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | Relasi ke Route
    |--------------------------------------------------------------------------
    */

    public function route()
    {
        return $this->belongsTo(
            Route::class,
            'route_id'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | User yang melaporkan incident
    |--------------------------------------------------------------------------
    */

    public function reporter()
    {
        return $this->belongsTo(
            User::class,
            'reported_by'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | Scope Filter
    |--------------------------------------------------------------------------
    */


    public function scopeOpen($query)
    {
        return $query->where(
            'status',
            'open'
        );
    }


    public function scopeCritical($query)
    {
        return $query->where(
            'severity',
            'critical'
        );
    }
}
