<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Route extends Model
{
    use HasFactory, SoftDeletes;


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


    protected $casts = [

        'operator_id' => 'integer',

        'transport_mode_id' => 'integer',

        'distance_km' => 'decimal:2',

        'estimated_duration_minutes' => 'integer',

        'status' => 'string',

        'deleted_at' => 'datetime',

    ];



    public const STATUS_ACTIVE = 'active';

    public const STATUS_INACTIVE = 'inactive';

    public const STATUS_MAINTENANCE = 'maintenance';



    public static function getStatuses(): array
    {

        return [

            self::STATUS_ACTIVE,

            self::STATUS_INACTIVE,

            self::STATUS_MAINTENANCE,

        ];

    }



    /**
     * Operator pemilik route
     */
    public function operator(): BelongsTo
    {

        return $this->belongsTo(
            Operator::class,
            'operator_id'
        );

    }



    /**
     * Jenis transportasi
     */
    public function transportMode(): BelongsTo
    {

        return $this->belongsTo(
            TransportMode::class,
            'transport_mode_id'
        );

    }

public function route()
{
    return $this->belongsTo(RouteModel::class);
}

    /**
     * Jadwal route
     */
    public function schedules(): HasMany
    {

        return $this->hasMany(
            Schedule::class,
            'route_id'
        );

    }



    /**
     * Trip route
     */
    public function trips(): HasMany
    {

        return $this->hasMany(
            Trip::class,
            'route_id'
        );

    }



    /**
     * Detail pemberhentian route
     */
    public function routeStops(): HasMany
    {

        return $this->hasMany(
            RouteStop::class,
            'route_id'
        )
        ->orderBy(
            'stop_order',
            'asc'
        );

    }



    /**
     * Relasi many to many stop
     */
    public function stops(): BelongsToMany
    {

        return $this->belongsToMany(
            Stop::class,
            'route_stops',
            'route_id',
            'stop_id'
        )

        ->withPivot([

            'stop_order',

            'distance_from_start_km',

            'estimated_arrival_minutes',

        ])

        ->withTimestamps()

        ->orderByPivot(
            'stop_order',
            'asc'
        );

    }



    /**
     * Scope route aktif
     */
    public function scopeActive(Builder $query): Builder
    {

        return $query->where(
            'status',
            self::STATUS_ACTIVE
        );

    }



    /**
     * Scope route tidak aktif
     */
    public function scopeInactive(Builder $query): Builder
    {

        return $query->where(
            'status',
            self::STATUS_INACTIVE
        );

    }



    /**
     * Scope maintenance
     */
    public function scopeMaintenance(Builder $query): Builder
    {

        return $query->where(
            'status',
            self::STATUS_MAINTENANCE
        );

    }



    /**
     * Filter operator
     */
    public function scopeByOperator(
        Builder $query,
        int $operatorId
    ): Builder
    {

        return $query->where(
            'operator_id',
            $operatorId
        );

    }



    /**
     * Filter transport mode
     */
    public function scopeByTransportMode(
        Builder $query,
        int $transportModeId
    ): Builder
    {

        return $query->where(
            'transport_mode_id',
            $transportModeId
        );

    }

}
