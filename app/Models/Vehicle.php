<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;



    protected $table = 'vehicles';



    protected $primaryKey = 'id';




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
    |--------------------------------------------------------------------------
    | CAST
    |--------------------------------------------------------------------------
    */


    protected $casts = [

        'capacity' => 'integer',

        'manufacture_year' => 'integer',

        'last_service_date' => 'date',

    ];








    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */



    /**
     * Kendaraan milik operator
     */
    public function operator()
    {

        return $this->belongsTo(

            Operator::class,

            'operator_id',

            'id'

        )
            ->withDefault([

                'name' => 'Tidak Ada Operator'

            ]);
    }








    /**
     * Jenis transportasi
     */
    public function transportMode()
    {

        return $this->belongsTo(

            TransportMode::class,

            'transport_mode_id',

            'id'

        )
            ->withDefault([

                'name' => 'Tidak Ada Mode'

            ]);
    }








    /**
     * Satu kendaraan memiliki banyak trip
     */
    public function trips()
    {

        return $this->hasMany(

            Trip::class,

            'vehicle_id',

            'id'

        );
    }








    /**
     * Satu kendaraan memiliki banyak jadwal
     */
    public function schedules()
    {

        return $this->hasMany(

            Schedule::class,

            'vehicle_id',

            'id'

        );
    }








    /**
     * Monitoring jumlah penumpang
     */
    public function passengerCounts()
    {

        return $this->hasMany(

            PassengerCount::class,

            'vehicle_id',

            'id'

        );
    }








    /**
     * Tiket kendaraan
     */
    public function tickets()
    {

        return $this->hasMany(

            Ticket::class,

            'vehicle_id',

            'id'

        );
    }








    /*
    |--------------------------------------------------------------------------
    | QUERY SCOPE
    |--------------------------------------------------------------------------
    */



    public function scopeAvailable($query)
    {

        return $query->where(
            'status',
            'available'
        );
    }





    public function scopeOnTrip($query)
    {

        return $query->where(
            'status',
            'on_trip'
        );
    }





    public function scopeMaintenance($query)
    {

        return $query->where(
            'status',
            'maintenance'
        );
    }





    public function scopeInactive($query)
    {

        return $query->where(
            'status',
            'inactive'
        );
    }








    /**
     * Search kendaraan
     */
    public function scopeSearch(
        $query,
        $keyword
    ) {


        return $query->where(function ($q) use ($keyword) {


            $q->where(

                'vehicle_code',

                'like',

                "%{$keyword}%"

            )


                ->orWhere(

                    'plate_number',

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
     * Nomor kendaraan tampil
     */
    public function getVehicleNumberAttribute()
    {

        return $this->plate_number

            ??

            $this->vehicle_code;
    }








    /**
     * Status Indonesia
     */
    public function getStatusLabelAttribute()
    {


        return match ($this->status) {


            'available'
            => 'Tersedia',


            'on_trip'
            => 'Dalam Perjalanan',


            'maintenance'
            => 'Perawatan',


            'inactive'
            => 'Tidak Aktif',


            default
            => 'Tidak Diketahui'
        };
    }








    /**
     * Warna badge
     */
    public function getStatusColorAttribute()
    {


        return match ($this->status) {


            'available'
            => 'success',


            'on_trip'
            => 'primary',


            'maintenance'
            => 'warning',


            'inactive'
            => 'danger',


            default
            => 'secondary'
        };
    }








    /**
     * Kapasitas kendaraan
     */
    public function getCapacityLabelAttribute()
    {

        return $this->capacity
            ? $this->capacity . ' Orang'
            : '-';
    }








    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
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
}
