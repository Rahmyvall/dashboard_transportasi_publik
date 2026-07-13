<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use HasFactory, SoftDeletes;



    protected $table = 'trips';




    protected $fillable = [

        'schedule_id',

        'route_id',

        'vehicle_id',

        'driver_id',

        'trip_code',

        'planned_start_time',

        'planned_end_time',

        'actual_start_time',

        'actual_end_time',

        'status',

        'delay_minutes',

        'notes',

    ];






    protected $casts = [

        'schedule_id' => 'integer',

        'route_id' => 'integer',

        'vehicle_id' => 'integer',

        'driver_id' => 'integer',


        'planned_start_time' => 'datetime',

        'planned_end_time' => 'datetime',

        'actual_start_time' => 'datetime',

        'actual_end_time' => 'datetime',


        'delay_minutes' => 'integer',

        'deleted_at' => 'datetime',

    ];






    /*
    |--------------------------------------------------------------------------
    | STATUS CONSTANT
    |--------------------------------------------------------------------------
    */


    const STATUS_SCHEDULED = 'scheduled';

    const STATUS_RUNNING = 'running';

    const STATUS_COMPLETED = 'completed';

    const STATUS_CANCELLED = 'cancelled';

    const STATUS_DELAYED = 'delayed';







    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */



    /**
     * Trip berasal dari Schedule
     */
    public function schedule(): BelongsTo
    {

        return $this->belongsTo(
            Schedule::class,
            'schedule_id'
        );
    }






    /**
     * Trip memiliki Route
     */
    public function route(): BelongsTo
    {

        return $this->belongsTo(
            Route::class,
            'route_id'
        );
    }






    /**
     * Trip menggunakan Vehicle
     */
    public function vehicle(): BelongsTo
    {

        return $this->belongsTo(
            Vehicle::class,
            'vehicle_id'
        );
    }






    /**
     * Trip menggunakan Driver
     */
    public function driver(): BelongsTo
    {

        return $this->belongsTo(
            Driver::class,
            'driver_id'
        );
    }






    /**
     * Posisi kendaraan saat perjalanan
     */
    public function vehiclePositions(): HasMany
    {

        return $this->hasMany(
            VehiclePosition::class,
            'trip_id'
        );
    }






    /**
     * Monitoring jumlah penumpang
     */
    public function passengerCounts(): HasMany
    {

        return $this->hasMany(
            PassengerCount::class,
            'trip_id'
        );
    }






    /**
     * Tiket perjalanan
     */
    public function tickets(): HasMany
    {

        return $this->hasMany(
            Ticket::class,
            'trip_id'
        );
    }







    /*
    |--------------------------------------------------------------------------
    | QUERY SCOPE
    |--------------------------------------------------------------------------
    */



    public function scopeRunning(
        Builder $query
    ): Builder {

        return $query->where(
            'status',
            self::STATUS_RUNNING
        );
    }





    public function scopeCompleted(
        Builder $query
    ): Builder {

        return $query->where(
            'status',
            self::STATUS_COMPLETED
        );
    }





    public function scopeScheduled(
        Builder $query
    ): Builder {

        return $query->where(
            'status',
            self::STATUS_SCHEDULED
        );
    }





    public function scopeDelayed(
        Builder $query
    ): Builder {

        return $query->where(
            'status',
            self::STATUS_DELAYED
        );
    }





    public function scopeSearch(
        Builder $query,
        $keyword
    ) {

        return $query->where(function ($q) use ($keyword) {

            $q->where(
                'trip_code',
                'like',
                "%{$keyword}%"
            );
        });
    }







    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */



    /**
     * Lama perjalanan dalam menit
     */
    public function getDurationAttribute()
    {

        if (
            !$this->actual_start_time ||
            !$this->actual_end_time
        ) {

            return 0;
        }


        return $this->actual_start_time
            ->diffInMinutes(
                $this->actual_end_time
            );
    }







    /**
     * Nama status
     */
    public function getStatusLabelAttribute()
    {

        return match ($this->status) {


            self::STATUS_SCHEDULED
            => 'Terjadwal',


            self::STATUS_RUNNING
            => 'Berjalan',


            self::STATUS_COMPLETED
            => 'Selesai',


            self::STATUS_CANCELLED
            => 'Dibatalkan',


            self::STATUS_DELAYED
            => 'Terlambat',


            default
            => '-',
        };
    }







    /*
    |--------------------------------------------------------------------------
    | ACTION FUNCTION
    |--------------------------------------------------------------------------
    */



    public function startTrip(): bool
    {

        return $this->update([

            'status'
            => self::STATUS_RUNNING,


            'actual_start_time'
            => now(),

        ]);
    }







    public function completeTrip(): bool
    {

        return $this->update([

            'status'
            => self::STATUS_COMPLETED,


            'actual_end_time'
            => now(),

        ]);
    }







    public function markDelayed(
        int $minutes
    ): bool {

        return $this->update([

            'status'
            => self::STATUS_DELAYED,


            'delay_minutes'
            => $minutes,

        ]);
    }







    public function cancelTrip(): bool
    {

        return $this->update([

            'status'
            => self::STATUS_CANCELLED,

        ]);
    }
}
