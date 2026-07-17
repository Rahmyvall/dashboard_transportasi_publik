<?php
namespace App\Models;

use App\Models\Route as TransportRoute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alert extends Model
{

    use HasFactory;

    /**
     * Table Name
     */
    protected $table = 'alerts';

    /**
     * Mass Assignment
     */
    protected $fillable = [

        // Relationship
        'incident_id',
        'route_id',
        'vehicle_id',

        // Alert Information
        'title',
        'message',
        'alert_type',
        'priority',

        // Publication
        'is_published',
        'published_at',
        'expired_at',

    ];

    /**
     * Data Casting
     */
    protected $casts = [

        'is_published' => 'boolean',

        'published_at' => 'datetime',

        'expired_at'   => 'datetime',

    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    /**
     * Alert belongs to Incident
     */
    public function incident(): BelongsTo
    {

        return $this->belongsTo(
            Incident::class,
            'incident_id'
        );
    }

    /**
     * Alert belongs to Route
     *
     * Alias TransportRoute untuk menghindari
     * konflik Illuminate Route
     */
    public function route(): BelongsTo
    {

        return $this->belongsTo(
            TransportRoute::class,
            'route_id'
        );
    }

    /**
     * Alert belongs to Vehicle
     */
    public function vehicle(): BelongsTo
    {

        return $this->belongsTo(
            Vehicle::class,
            'vehicle_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | QUERY SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Published Alert
     */
    public function scopePublished(
        Builder $query
    ): Builder {

        return $query

            ->where(
                'is_published',
                true
            )

            ->where(function ($query) {

                $query

                    ->whereNull(
                        'expired_at'
                    )

                    ->orWhere(
                        'expired_at',
                        '>',
                        now()
                    );
            });
    }

    /**
     * Active Alert
     */
    public function scopeActive(
        Builder $query
    ): Builder {

        return $query->where(function ($query) {

            $query

                ->whereNull(
                    'expired_at'
                )

                ->orWhere(
                    'expired_at',
                    '>',
                    now()
                );
        });
    }

    /**
     * Filter Priority
     */
    public function scopePriority(
        Builder $query,
        string $priority
    ): Builder {

        return $query->where(
            'priority',
            $priority
        );
    }

    /**
     * Filter Alert Type
     */
    public function scopeType(
        Builder $query,
        string $type
    ): Builder {

        return $query->where(
            'alert_type',
            $type
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */

    /**
     * Alert Status
     */
    public function getStatusAttribute(): string
    {

        if (! $this->is_published) {

            return 'Draft';
        }

        if (
            $this->expired_at &&
            $this->expired_at->isPast()
        ) {

            return 'Expired';
        }

        return 'Published';
    }

    /**
     * Priority Badge Color
     */
    public function getPriorityColorAttribute(): string
    {

        return match ($this->priority) {

            'critical' =>
            'danger',

            'high'     =>
            'warning',

            'medium'   =>
            'primary',

            'low'      =>
            'success',

            default    =>
            'secondary',
        };
    }

    /**
     * Alert Icon Untuk UI
     */
    public function getAlertIconAttribute(): string
    {

        return match ($this->alert_type) {

            'emergency'    =>
            'ri-alarm-warning-line',

            'delay'        =>
            'ri-time-line',

            'diversion'    =>
            'ri-road-map-line',

            'service_stop' =>
            'ri-stop-circle-line',

            'crowded'      =>
            'ri-group-line',

            default        =>
            'ri-information-line',
        };
    }

    /**
     * Publish Alert
     */
    public function publish(): bool
    {

        return $this->update([

            'is_published' => true,

            'published_at' => now(),

        ]);
    }

    /**
     * Expire Alert
     */
    public function expire(): bool
    {

        return $this->update([

            'expired_at' => now(),

        ]);
    }

    /**
     * Check Active Alert
     */
    public function isActive(): bool
    {
        if (! $this->is_published) {
            return false;
        }

        if (
            $this->expired_at &&
            $this->expired_at->isPast()
        ) {
            return false;
        }

        return true;
    }

    /**
     * Check Critical Alert
     */
    public function isCritical(): bool
    {

        return $this->priority === 'critical';
    }
}