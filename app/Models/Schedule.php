<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    /**
     * Mass assignment
     */
    protected $fillable = [
        'route_id',
        'vehicle_id',
        'driver_id',
        'day_type',
        'start_time',
        'end_time',
        'headway_minutes',
        'is_active',
    ];

    /**
     * Cast type biar aman
     */
    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'headway_minutes' => 'integer',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    // Route
    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }

    // Vehicle
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    // Driver
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES (biar lebih gampang query)
    |--------------------------------------------------------------------------
    */

    // hanya schedule aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    // filter berdasarkan route
    public function scopeRoute($query, $routeId)
    {
        return $query->where('route_id', $routeId);
    }

    // filter berdasarkan hari
    public function scopeDayType($query, $type)
    {
        return $query->where('day_type', $type);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR (optional tapi berguna)
    |--------------------------------------------------------------------------
    */

    // format jam biar rapi di UI
    public function getTimeRangeAttribute()
    {
        return $this->start_time . ' - ' . $this->end_time;
    }

    // status label
    public function getStatusLabelAttribute()
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER (optional logic kecil)
    |--------------------------------------------------------------------------
    */

    // cek apakah schedule overlap
    public function isOverlapping($start, $end, $routeId, $dayType, $ignoreId = null)
    {
        $query = self::where('route_id', $routeId)
            ->where('day_type', $dayType)
            ->where('start_time', '<', $end)
            ->where('end_time', '>', $start);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->exists();
    }
}