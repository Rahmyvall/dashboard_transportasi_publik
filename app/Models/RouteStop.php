<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RouteStop extends Model
{
    use HasFactory;



    protected $table = 'route_stops';



    protected $primaryKey = 'id';





    protected $fillable = [

        'route_id',

        'stop_id',

        'stop_order',

        'distance_from_start_km',

        'estimated_arrival_minutes',

    ];







    /*
    |--------------------------------------------------------------------------
    | CAST DATA
    |--------------------------------------------------------------------------
    */


    protected $casts = [

        'route_id' => 'integer',

        'stop_id' => 'integer',

        'stop_order' => 'integer',

        'distance_from_start_km' => 'decimal:2',

        'estimated_arrival_minutes' => 'integer',

    ];








    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */





    /**
     * Route memiliki banyak halte
     *
     * route_stops.route_id
     *
     * routes.id
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
     * RouteStop menuju halte
     *
     * route_stops.stop_id
     *
     * stops.id
     */
    public function stop()
    {

        return $this->belongsTo(

            Stop::class,

            'stop_id',

            'id'

        )
            ->withDefault([

                'stop_name' => 'Tidak Ada Halte'

            ]);
    }









    /*
    |--------------------------------------------------------------------------
    | SCOPE QUERY
    |--------------------------------------------------------------------------
    */



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
     * Filter halte
     */
    public function scopeByStop(
        $query,
        $stopId
    ) {

        return $query->where(

            'stop_id',

            $stopId

        );
    }







    /**
     * Urutkan halte sesuai jalur
     */
    public function scopeOrdered($query)
    {

        return $query->orderBy(

            'stop_order',

            'asc'

        );
    }







    /**
     * Search route stop
     */
    public function scopeSearch(
        $query,
        $keyword
    ) {

        return $query->whereHas(

            'stop',

            function ($q) use ($keyword) {

                $q->where(

                    'stop_name',

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
     * Nama halte
     */
    public function getStopNameAttribute()
    {

        return $this->stop->stop_name
            ?? '-';
    }







    /**
     * Jarak format
     */
    public function getDistanceLabelAttribute()
    {

        if (
            $this->distance_from_start_km === null
        ) {

            return '-';
        }



        return number_format(

            $this->distance_from_start_km,

            2

        ) . ' km';
    }







    /**
     * Estimasi waktu tiba
     */
    public function getArrivalTimeLabelAttribute()
    {

        if (
            $this->estimated_arrival_minutes === null
        ) {

            return '-';
        }



        return $this->estimated_arrival_minutes
            . ' menit';
    }







    /**
     * Nomor urutan halte
     */
    public function getOrderLabelAttribute()
    {

        return 'Halte ke-'
            . $this->stop_order;
    }








    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */





    /**
     * Cek halte pertama
     */
    public function isFirstStop(): bool
    {

        return $this->stop_order === 1;
    }







    /**
     * Cek halte terakhir
     */
    public function isLastStop(): bool
    {


        $lastOrder = self::where(

            'route_id',

            $this->route_id

        )
            ->max('stop_order');



        return $lastOrder === $this->stop_order;
    }







    /**
     * Ambil urutan halte berikutnya
     */
    public function nextStop()
    {

        return self::where(

            'route_id',

            $this->route_id

        )
            ->where(

                'stop_order',

                '>',

                $this->stop_order

            )
            ->orderBy(

                'stop_order',

                'asc'

            )
            ->first();
    }







    /**
     * Ambil halte sebelumnya
     */
    public function previousStop()
    {

        return self::where(

            'route_id',

            $this->route_id

        )
            ->where(

                'stop_order',

                '<',

                $this->stop_order

            )
            ->orderBy(

                'stop_order',

                'desc'

            )
            ->first();
    }
}
