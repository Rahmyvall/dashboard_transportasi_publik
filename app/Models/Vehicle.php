<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vehicles';

    protected $fillable = [
        'operator_id',
        'transport_mode_id',
        'vehicle_code',
        'plate_number',
        'capacity',
        'manufacture_year',
        'status',
        'last_service_date',
        'notes',
    ];

    /*
    |-----------------------------------------
    | CASTING
    |-----------------------------------------
    */
    protected $casts = [
        'capacity' => 'integer',
        'manufacture_year' => 'integer',
        'last_service_date' => 'date',
    ];

    /*
    |-----------------------------------------
    | RELATIONSHIP
    |-----------------------------------------
    */

    // Vehicle milik Operator
    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    // Vehicle punya Transport Mode
    public function transportMode()
    {
        return $this->belongsTo(TransportMode::class);
    }

    /*
    |-----------------------------------------
    | SCOPES (FILTER STATUS)
    |-----------------------------------------
    */

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeOnTrip($query)
    {
        return $query->where('status', 'on_trip');
    }

    public function scopeMaintenance($query)
    {
        return $query->where('status', 'maintenance');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /*
    |-----------------------------------------
    | ACCESSOR (LABEL STATUS)
    |-----------------------------------------
    */

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'available'   => 'Tersedia',
            'on_trip'     => 'Dalam Perjalanan',
            'maintenance' => 'Perawatan',
            'inactive'    => 'Tidak Aktif',
            default       => 'Tidak Diketahui',
        };
    }

    /*
    |-----------------------------------------
    | ACCESSOR (BADGE COLOR UI)
    |-----------------------------------------
    */

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'available'   => 'green',
            'on_trip'     => 'blue',
            'maintenance' => 'yellow',
            'inactive'    => 'red',
            default       => 'gray',
        };
    }

    /*
    |-----------------------------------------
    | HELPER FUNCTION
    |-----------------------------------------
    */

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isOnTrip(): bool
    {
        return $this->status === 'on_trip';
    }

    public function isMaintenance(): bool
    {
        return $this->status === 'maintenance';
    }

    public function isInactive(): bool
    {
        return $this->status === 'inactive';
    }

    /*
    |-----------------------------------------
    | SEARCH SCOPE (OPTIONAL)
    |-----------------------------------------
    */

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('vehicle_code', 'like', "%$keyword%")
              ->orWhere('plate_number', 'like', "%$keyword%");
        });
    }
}