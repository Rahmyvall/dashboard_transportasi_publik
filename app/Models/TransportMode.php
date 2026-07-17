<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportMode extends Model
{
    use HasFactory;

    protected $table = 'transport_modes';

    protected $primaryKey = 'id';

    protected $fillable = [

        'mode_code',

        'mode_name',

        'description',

    ];

    protected $casts = [

        'id' => 'integer',

    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function vehicles()
    {
        return $this->hasMany(
            Vehicle::class,
            'transport_mode_id',
            'id'
        );
    }

    public function routes()
    {
        return $this->hasMany(
            Route::class,
            'transport_mode_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPE
    |--------------------------------------------------------------------------
    */

    public function scopeSearch($query, $keyword)
    {

        return $query->where(function ($q) use ($keyword) {

            $q->where(
                'mode_code',
                'like',
                "%{$keyword}%"
            )

                ->orWhere(
                    'mode_name',
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

    public function getDisplayNameAttribute()
    {

        return ucfirst(
            strtolower(
                $this->mode_name
            )
        );

    }

    public function getVehicleCountAttribute()
    {

        return $this->vehicles()->count();

    }

    public function hasVehicles(): bool
    {

        return $this->vehicles()->exists();

    }

}