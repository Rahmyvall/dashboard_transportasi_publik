<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehiclePosition extends Model
{
    use HasFactory;


    protected $fillable = [

        'vehicle_id',

        'trip_id',

        'latitude',

        'longitude',

        'speed_kmh',

        'heading_degree',

        'recorded_at',

    ];



    protected $casts = [

        'latitude' => 'decimal:7',

        'longitude' => 'decimal:7',

        'speed_kmh' => 'decimal:2',

        'heading_degree' => 'integer',

        'recorded_at' => 'datetime',

    ];



    /*
    |--------------------------------------------------------------------------
    | Relationship
    |--------------------------------------------------------------------------
    */


    // Relasi ke kendaraan
    public function vehicle()
    {
        return $this->belongsTo(
            Vehicle::class,
            'vehicle_id'
        );
    }



    // Relasi ke perjalanan
    public function trip()
    {
        return $this->belongsTo(
            Trip::class,
            'trip_id'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | Scope
    |--------------------------------------------------------------------------
    */


    // Urut posisi terbaru
    public function scopeLatestPosition($query)
    {
        return $query->orderBy(
            'recorded_at',
            'desc'
        );
    }



    // Kendaraan sedang berjalan
    public function scopeMoving($query)
    {
        return $query->where(
            'speed_kmh',
            '>',
            0
        );
    }



    // Kendaraan berhenti
    public function scopeStopped($query)
    {
        return $query->where(
            'speed_kmh',
            '<=',
            0
        );
    }
}
