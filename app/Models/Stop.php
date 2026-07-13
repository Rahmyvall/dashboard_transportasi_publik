<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stop extends Model
{
    use HasFactory;


    protected $table = 'stops';



    protected $primaryKey = 'id';



    protected $fillable = [

        'stop_code',

        'stop_name',

        'stop_type',

        'latitude',

        'longitude',

        'address',

        'is_active',

    ];





    /*
    |--------------------------------------------------------------------------
    | CAST DATA
    |--------------------------------------------------------------------------
    */


    protected $casts = [

        'latitude' => 'decimal:8',

        'longitude' => 'decimal:8',

        'is_active' => 'boolean',

    ];






    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */



    /**
     * Satu halte memiliki banyak data penumpang
     *
     * stops.id
     *      |
     *      |
     * passenger_counts.stop_id
     */
    public function passengerCounts()
    {

        return $this->hasMany(

            PassengerCount::class,

            'stop_id',

            'id'

        );
    }








    /*
    |--------------------------------------------------------------------------
    | QUERY SCOPE
    |--------------------------------------------------------------------------
    */



    /**
     * Halte aktif
     */
    public function scopeActive($query)
    {

        return $query->where(
            'is_active',
            true
        );
    }







    /**
     * Filter tipe halte
     */
    public function scopeType(
        $query,
        $type
    ) {

        return $query->where(
            'stop_type',
            $type
        );
    }







    /**
     * Search halte
     */
    public function scopeSearch(
        $query,
        $keyword
    ) {

        return $query->where(function ($q) use ($keyword) {


            $q->where(
                'stop_code',
                'like',
                "%{$keyword}%"
            )


                ->orWhere(
                    'stop_name',
                    'like',
                    "%{$keyword}%"
                )


                ->orWhere(
                    'address',
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
     * Nama halte untuk tampilan
     */
    public function getDisplayNameAttribute()
    {

        return $this->stop_name
            ?: 'Tidak Ada Halte';
    }







    /**
     * Format koordinat
     */
    public function getCoordinateAttribute()
    {

        if (
            $this->latitude !== null &&
            $this->longitude !== null
        ) {

            return

                $this->latitude .
                ', ' .
                $this->longitude;
        }


        return '-';
    }







    /**
     * Label status
     */
    public function getStatusLabelAttribute()
    {

        return $this->is_active

            ? 'Aktif'

            : 'Tidak Aktif';
    }







    /**
     * Warna badge status
     */
    public function getStatusColorAttribute()
    {

        return $this->is_active

            ? 'success'

            : 'danger';
    }







    /*
    |--------------------------------------------------------------------------
    | MUTATOR
    |--------------------------------------------------------------------------
    */



    /**
     * Format kode halte
     */
    public function setStopCodeAttribute($value)
    {

        $this->attributes['stop_code']

            =

            strtoupper(
                trim($value ?? '')
            );
    }







    /**
     * Format nama halte
     */
    public function setStopNameAttribute($value)
    {

        $this->attributes['stop_name']

            =

            ucwords(
                strtolower(
                    trim($value ?? '')
                )
            );
    }







    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */



    public function isActive(): bool
    {

        return $this->is_active === true;
    }




    public function isInactive(): bool
    {

        return $this->is_active === false;
    }
}
