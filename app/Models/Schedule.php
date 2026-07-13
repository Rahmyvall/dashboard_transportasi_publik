<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;



    protected $table = 'schedules';



    protected $primaryKey = 'id';





    protected $fillable = [

        'route_id',

        'vehicle_id',

        'driver_id',

        'day_type',

        'start_time',

        'end_time',

        'headway_minutes',

        'is_active',

    ];








    /*
    |--------------------------------------------------------------------------
    | CAST DATA
    |--------------------------------------------------------------------------
    */


    protected $casts = [

        'route_id' => 'integer',

        'vehicle_id' => 'integer',

        'driver_id' => 'integer',

        'headway_minutes' => 'integer',

        'is_active' => 'boolean',

        'start_time' => 'datetime:H:i',

        'end_time' => 'datetime:H:i',

    ];









    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */



    /**
     * Schedule menuju Route
     */
    public function route()
    {

        return $this->belongsTo(

            Route::class,

            'route_id',

            'id'

        )
            ->withDefault([

                'route_name' => 'Tidak Ada Route'

            ]);
    }








    /**
     * Schedule menggunakan Vehicle
     */
    public function vehicle()
    {

        return $this->belongsTo(

            Vehicle::class,

            'vehicle_id',

            'id'

        )
            ->withDefault([

                'plate_number' => 'Tidak Ada Kendaraan'

            ]);
    }








    /**
     * Schedule memiliki Driver
     */
    public function driver()
    {

        return $this->belongsTo(

            Driver::class,

            'driver_id',

            'id'

        )
            ->withDefault([

                'name' => 'Tidak Ada Driver'

            ]);
    }








    /**
     * Schedule menghasilkan banyak Trip
     */
    public function trips()
    {

        return $this->hasMany(

            Trip::class,

            'schedule_id',

            'id'

        );
    }









    /*
    |--------------------------------------------------------------------------
    | QUERY SCOPE
    |--------------------------------------------------------------------------
    */





    /**
     * Schedule aktif
     */
    public function scopeActive($query)
    {

        return $query->where(

            'is_active',

            true

        );
    }








    /**
     * Filter route
     */
    public function scopeByRoute(

        $query,

        $routeId

    ) {

        return $query->where(

            'route_id',

            $routeId

        );
    }








    /**
     * Filter kendaraan
     */
    public function scopeByVehicle(

        $query,

        $vehicleId

    ) {

        return $query->where(

            'vehicle_id',

            $vehicleId

        );
    }








    /**
     * Filter hari
     */
    public function scopeDayType(

        $query,

        $type

    ) {

        return $query->where(

            'day_type',

            $type

        );
    }









    /**
     * Search schedule
     */
    public function scopeSearch(

        $query,

        $keyword

    ) {


        return $query->whereHas(

            'route',

            function ($q) use ($keyword) {


                $q->where(

                    'route_name',

                    'like',

                    "%{$keyword}%"

                );
            }

        );
    }









    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */



    /**
     * Format waktu perjalanan
     */
    public function getTimeRangeAttribute()
    {

        return

            optional($this->start_time)

            ->format('H:i')

            .

            ' - '

            .

            optional($this->end_time)

            ->format('H:i');
    }








    /**
     * Status label
     */
    public function getStatusLabelAttribute()
    {

        return $this->is_active

            ? 'Aktif'

            : 'Tidak Aktif';
    }








    /**
     * Warna badge UI
     */
    public function getStatusColorAttribute()
    {

        return $this->is_active

            ? 'success'

            : 'danger';
    }








    /**
     * Nama lengkap jadwal
     */
    public function getScheduleNameAttribute()
    {

        return ($this->route->route_name ?? '-')

            .

            ' | '

            .

            $this->time_range;
    }









    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */





    /**
     * Cek jadwal aktif
     */
    public function isActive(): bool
    {

        return $this->is_active === true;
    }








    /**
     * Cek bentrok jadwal
     */
    public function isOverlapping(

        $start,

        $end,

        $routeId,

        $dayType,

        $ignoreId = null

    ) {


        $query = self::where(

            'route_id',

            $routeId

        )

            ->where(

                'day_type',

                $dayType

            )

            ->where(

                'start_time',

                '<',

                $end

            )

            ->where(

                'end_time',

                '>',

                $start

            );





        if ($ignoreId) {

            $query->where(

                'id',

                '!=',

                $ignoreId

            );
        }



        return $query->exists();
    }
}
