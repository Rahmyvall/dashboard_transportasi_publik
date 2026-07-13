<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehiclePosition extends Model
{
    use HasFactory;



    protected $table = 'vehicle_positions';



    protected $primaryKey = 'id';





    protected $fillable = [

        'vehicle_id',

        'trip_id',

        'latitude',

        'longitude',

        'speed_kmh',

        'heading_degree',

        'recorded_at',

    ];







    /*
    |--------------------------------------------------------------------------
    | CAST DATA
    |--------------------------------------------------------------------------
    */


    protected $casts = [


        'vehicle_id' => 'integer',


        'trip_id' => 'integer',



        'latitude' => 'decimal:7',



        'longitude' => 'decimal:7',



        'speed_kmh' => 'decimal:2',



        'heading_degree' => 'integer',



        'recorded_at' => 'datetime',


    ];









    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */





    /**
     * Posisi milik kendaraan
     *
     * vehicle_positions.vehicle_id
     *
     * vehicles.id
     */
    public function vehicle()
    {

        return $this->belongsTo(

            Vehicle::class,

            'vehicle_id',

            'id'

        )
            ->withDefault([

                'vehicle_code' => 'Tidak Ada Kendaraan',

                'plate_number' => '-'

            ]);
    }








    /**
     * Posisi berdasarkan perjalanan
     *
     * vehicle_positions.trip_id
     *
     * trips.id
     */
    public function trip()
    {

        return $this->belongsTo(

            Trip::class,

            'trip_id',

            'id'

        )
            ->withDefault([

                'trip_code' => 'Tidak Ada Trip'

            ]);
    }









    /*
    |--------------------------------------------------------------------------
    | QUERY SCOPE
    |--------------------------------------------------------------------------
    */





    /**
     * Posisi terbaru
     */
    public function scopeLatestPosition($query)
    {

        return $query->orderBy(

            'recorded_at',

            'desc'

        );
    }








    /**
     * Kendaraan sedang bergerak
     */
    public function scopeMoving($query)
    {

        return $query->where(

            'speed_kmh',

            '>',

            0

        );
    }








    /**
     * Kendaraan berhenti
     */
    public function scopeStopped($query)
    {

        return $query->where(

            'speed_kmh',

            '<=',

            0

        );
    }









    /**
     * Filter berdasarkan kendaraan
     */
    public function scopeVehicle(

        $query,

        $vehicleId

    ) {

        return $query->where(

            'vehicle_id',

            $vehicleId

        );
    }









    /**
     * Filter berdasarkan trip
     */
    public function scopeTrip(

        $query,

        $tripId

    ) {

        return $query->where(

            'trip_id',

            $tripId

        );
    }










    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */





    /**
     * Format koordinat GPS
     */
    public function getCoordinateAttribute()
    {


        if (

            $this->latitude !== null &&

            $this->longitude !== null

        ) {

            return

                $this->latitude

                . ', '

                .

                $this->longitude;
        }



        return '-';
    }










    /**
     * Status kendaraan
     */
    public function getMovementStatusAttribute()
    {


        if (

            $this->speed_kmh > 0

        ) {

            return 'Berjalan';
        }


        return 'Berhenti';
    }










    /**
     * Warna status UI
     */
    public function getMovementColorAttribute()
    {


        return $this->speed_kmh > 0

            ? 'success'

            : 'secondary';
    }









    /**
     * Arah kendaraan
     */
    public function getDirectionAttribute()
    {


        $degree = $this->heading_degree;



        if ($degree === null) {

            return '-';
        }



        return match (true) {


            $degree >= 337 || $degree < 23
            => 'Utara',



            $degree >= 23 && $degree < 68
            => 'Timur Laut',



            $degree >= 68 && $degree < 113
            => 'Timur',



            $degree >= 113 && $degree < 158
            => 'Tenggara',



            $degree >= 158 && $degree < 203
            => 'Selatan',



            $degree >= 203 && $degree < 248
            => 'Barat Daya',



            $degree >= 248 && $degree < 293
            => 'Barat',



            default
            => 'Barat Laut'
        };
    }









    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */





    public function isMoving(): bool
    {

        return $this->speed_kmh > 0;
    }





    public function isStopped(): bool
    {

        return $this->speed_kmh <= 0;
    }
}
