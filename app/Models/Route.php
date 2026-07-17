<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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

        'operator_id'                => 'integer',

        'transport_mode_id'          => 'integer',

        'distance_km'                => 'decimal:2',

        'estimated_duration_minutes' => 'integer',

        'deleted_at'                 => 'datetime',

    ];

    /*
    |--------------------------------------------------------------------------
    | CONSTANT STATUS
    |--------------------------------------------------------------------------
    */

    public const STATUS_ACTIVE =
        'active';

    public const STATUS_INACTIVE =
        'inactive';

    public const STATUS_MAINTENANCE =
        'maintenance';

    public static function getStatuses(): array
    {

        return [

            self::STATUS_ACTIVE,

            self::STATUS_INACTIVE,

            self::STATUS_MAINTENANCE,

        ];

    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    /**
     * Operator
     */
    public function operator(): BelongsTo
    {

        return $this->belongsTo(
            Operator::class,
            'operator_id'
        );

    }

    /**
     * Transport Mode
     */
    public function transportMode(): BelongsTo
    {

        return $this->belongsTo(
            TransportMode::class,
            'transport_mode_id'
        );

    }

    /**
     * Alert Notification
     *
     * Relasi penting untuk tabel alerts
     */
    public function alerts(): HasMany
    {

        return $this->hasMany(
            Alert::class,
            'route_id'
        );

    }

    /**
     * Schedule
     */
    public function schedules(): HasMany
    {

        return $this->hasMany(
            Schedule::class,
            'route_id'
        );

    }

    /**
     * Trip
     */
    public function trips(): HasMany
    {

        return $this->hasMany(
            Trip::class,
            'route_id'
        );

    }

    /**
     * Route Stops Detail
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
     * Many to Many Stops
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
     * Ticket
     */
    public function tickets(): HasMany
    {

        return $this->hasMany(
            Ticket::class,
            'route_id'
        );

    }

    /**
     * Incident
     */
    public function incidents(): HasMany
    {

        return $this->hasMany(
            Incident::class,
            'route_id'
        );

    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeActive(
        Builder $query
    ): Builder {

        return $query->where(
            'status',
            self::STATUS_ACTIVE
        );

    }

    public function scopeInactive(
        Builder $query
    ): Builder {

        return $query->where(
            'status',
            self::STATUS_INACTIVE
        );

    }

    public function scopeMaintenance(
        Builder $query
    ): Builder {

        return $query->where(
            'status',
            self::STATUS_MAINTENANCE
        );

    }

    public function scopeByOperator(
        Builder $query,
        int $operatorId
    ): Builder {

        return $query->where(
            'operator_id',
            $operatorId
        );

    }

    public function scopeByTransportMode(
        Builder $query,
        int $transportModeId
    ): Builder {

        return $query->where(
            'transport_mode_id',
            $transportModeId
        );

    }

    /**
     * Search Route
     */
    public function scopeSearch(
        Builder $query,
        string $keyword
    ): Builder {

        return $query->where(function ($q) use ($keyword) {

            $q->where(
                'route_code',
                'like',
                "%{$keyword}%"
            )

                ->orWhere(
                    'route_name',
                    'like',
                    "%{$keyword}%"
                )

                ->orWhere(
                    'origin',
                    'like',
                    "%{$keyword}%"
                )

                ->orWhere(
                    'destination',
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
     * Compatibility dengan Alert Blade
     *
     * {{ $alert->route->name }}
     */
    public function getNameAttribute()
    {

        return $this->route_name;

    }

    /**
     * Status Label
     */
    public function getStatusLabelAttribute()
    {

        return match ($this->status) {

            self::STATUS_ACTIVE      =>
            'Active',

            self::STATUS_INACTIVE    =>
            'Inactive',

            self::STATUS_MAINTENANCE =>
            'Maintenance',

            default                  =>
            '-',

        };

    }

    /**
     * Full Route Name
     */
    public function getFullRouteAttribute()
    {

        return $this->origin
        . ' → ' .
        $this->destination;

    }

}
