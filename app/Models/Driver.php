<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Driver extends Model
{
    use HasFactory, SoftDeletes;


    protected $table = 'drivers';



    protected $fillable = [

        'operator_id',

        'driver_name',

        'license_number',

        'phone',

        'address',

        'status',

    ];



    protected $casts = [

        'operator_id' => 'integer',

        'driver_name' => 'string',

        'license_number' => 'string',

        'phone' => 'string',

        'address' => 'string',

        'status' => 'string',

        'deleted_at' => 'datetime',

    ];





    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */


    /**
     * Driver memiliki satu Operator
     */
    public function operator(): BelongsTo
    {
        return $this->belongsTo(
            Operator::class,
            'operator_id'
        );
    }





    /**
     * Driver memiliki banyak Schedule
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(
            Schedule::class,
            'driver_id'
        );
    }





    /**
     * Driver memiliki banyak Trip
     */
    public function trips(): HasMany
    {
        return $this->hasMany(
            Trip::class,
            'driver_id'
        );
    }






    /*
    |--------------------------------------------------------------------------
    | SCOPE
    |--------------------------------------------------------------------------
    */


    public function scopeActive($query)
    {
        return $query->where(
            'status',
            'active'
        );
    }



    public function scopeInactive($query)
    {
        return $query->where(
            'status',
            'inactive'
        );
    }



    public function scopeOnDuty($query)
    {
        return $query->where(
            'status',
            'on_duty'
        );
    }

    public function vehicles()
    {
        return $this->hasMany(
            Vehicle::class
        );
    }




    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */


    public function getDisplayNameAttribute()
    {
        return $this->driver_name
            . ' ('
            . $this->license_number
            . ')';
    }
}
