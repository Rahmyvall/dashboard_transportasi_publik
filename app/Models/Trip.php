<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

        'schedule_id'        => 'integer',

        'route_id'           => 'integer',

        'vehicle_id'         => 'integer',

        'driver_id'          => 'integer',

        'planned_start_time' => 'datetime',

        'planned_end_time'   => 'datetime',

        'actual_start_time'  => 'datetime',

        'actual_end_time'    => 'datetime',

        'delay_minutes'      => 'integer',

        'status'             => 'string',

        'deleted_at'         => 'datetime',

    ];

    const STATUS_SCHEDULED = 'scheduled';

    const STATUS_RUNNING = 'running';

    const STATUS_COMPLETED = 'completed';

    const STATUS_CANCELLED = 'cancelled';

    const STATUS_DELAYED = 'delayed';

    /**
     * Relasi Schedule
     */
    public function schedule(): BelongsTo
    {

        return $this->belongsTo(
            Schedule::class,
            'schedule_id'
        );

    }

    /**
     * Relasi Route
     */
    public function route(): BelongsTo
    {

        return $this->belongsTo(
            Route::class,
            'route_id'
        );

    }

    /**
     * Relasi Vehicle
     */
    public function vehicle(): BelongsTo
    {

        return $this->belongsTo(
            Vehicle::class,
            'vehicle_id'
        );

    }

    /**
     * Relasi Driver
     */
    public function driver(): BelongsTo
    {

        return $this->belongsTo(
            Driver::class,
            'driver_id'
        );

    }

    /**
     * Scope running
     */
    public function scopeRunning(
        Builder $query
    ): Builder {

        return $query->where(
            'status',
            self::STATUS_RUNNING
        );

    }

    /**
     * Scope completed
     */
    public function scopeCompleted(
        Builder $query
    ): Builder {

        return $query->where(
            'status',
            self::STATUS_COMPLETED
        );

    }

    /**
     * Scope scheduled
     */
    public function scopeScheduled(
        Builder $query
    ): Builder {

        return $query->where(
            'status',
            self::STATUS_SCHEDULED
        );

    }

    /**
     * Scope cancelled
     */
    public function scopeCancelled(
        Builder $query
    ): Builder {

        return $query->where(
            'status',
            self::STATUS_CANCELLED
        );

    }

    /**
     * Scope delayed
     */
    public function scopeDelayed(
        Builder $query
    ): Builder {

        return $query->where(
            'status',
            self::STATUS_DELAYED
        );

    }

    /**
     * Cek trip berjalan
     */
    public function isRunning(): bool
    {

        return $this->status === self::STATUS_RUNNING;

    }

    /**
     * Cek trip selesai
     */
    public function isCompleted(): bool
    {

        return $this->status === self::STATUS_COMPLETED;

    }

    /**
     * Cek trip terlambat
     */
    public function isDelayed(): bool
    {

        return $this->status === self::STATUS_DELAYED;

    }

    /**
     * Durasi perjalanan
     */
    public function getDurationAttribute(): ?int
    {

        if (
            ! $this->actual_start_time ||
            ! $this->actual_end_time
        ) {

            return null;

        }

        return $this->actual_start_time
            ->diffInMinutes(
                $this->actual_end_time
            );

    }

    /**
     * Label status
     */
    public function getStatusLabelAttribute(): string
    {

        return match ($this->status) {

            self::STATUS_SCHEDULED =>
            'Terjadwal',

            self::STATUS_RUNNING   =>
            'Berjalan',

            self::STATUS_COMPLETED =>
            'Selesai',

            self::STATUS_CANCELLED =>
            'Dibatalkan',

            self::STATUS_DELAYED   =>
            'Terlambat',

            default                =>
            '-',

        };

    }

    /**
     * Mulai trip
     */
    public function startTrip(): bool
    {

        return $this->update([

            'status'            => self::STATUS_RUNNING,

            'actual_start_time' => now(),

        ]);

    }

    /**
     * Selesaikan trip
     */
    public function completeTrip(): bool
    {

        return $this->update([

            'status'          => self::STATUS_COMPLETED,

            'actual_end_time' => now(),

        ]);

    }

    /**
     * Tandai terlambat
     */
    public function markDelayed(int $minutes): bool
    {

        return $this->update([

            'status'        => self::STATUS_DELAYED,

            'delay_minutes' => $minutes,

        ]);

    }

    /**
     * Batalkan trip
     */
    public function cancelTrip(): bool
    {

        return $this->update([

            'status' => self::STATUS_CANCELLED,

        ]);

    }

}
