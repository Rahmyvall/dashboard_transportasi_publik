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








    /*
    |--------------------------------------------------------------------------
    | CAST DATA
    |--------------------------------------------------------------------------
    */


    protected $casts = [

        'id' => 'integer',

    ];









    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */





    /**
     * Satu mode transport memiliki banyak kendaraan
     *
     * transport_modes.id
     *
     * vehicles.transport_mode_id
     */
    public function vehicles()
    {

        return $this->hasMany(

            Vehicle::class,

            'transport_mode_id',

            'id'

        );
    }








    /**
     * Jika route memiliki transport mode
     * (optional jika tabel routes ada kolom transport_mode_id)
     */
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
    | QUERY SCOPE
    |--------------------------------------------------------------------------
    */





    /**
     * Filter kode transport
     */
    public function scopeCode(
        $query,
        $code
    ) {

        return $query->where(

            'mode_code',

            $code

        );
    }








    /**
     * Search nama mode
     */
    public function scopeSearch(
        $query,
        $keyword
    ) {


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








    /**
     * Filter nama
     */
    public function scopeName(
        $query,
        $name
    ) {

        return $query->where(

            'mode_name',

            'like',

            "%{$name}%"

        );
    }









    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */





    /**
     * Nama mode tampilan
     */
    public function getDisplayNameAttribute()
    {

        return ucfirst(

            strtolower(

                $this->mode_name

            )

        );
    }








    /**
     * Label lengkap
     */
    public function getModeLabelAttribute()
    {

        return

            $this->mode_code

            .

            ' - '

            .

            $this->display_name;
    }








    /*
    |--------------------------------------------------------------------------
    | MUTATOR
    |--------------------------------------------------------------------------
    */





    /**
     * Mode code selalu uppercase
     */
    public function setModeCodeAttribute($value)
    {

        $this->attributes['mode_code']

            =

            strtoupper(

                trim($value ?? '')

            );
    }








    /**
     * Mode name format
     */
    public function setModeNameAttribute($value)
    {

        $this->attributes['mode_name']

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





    /**
     * Jumlah kendaraan
     */
    public function getVehicleCountAttribute()
    {

        return $this->vehicles()->count();
    }







    /**
     * Cek memiliki kendaraan
     */
    public function hasVehicles(): bool
    {

        return $this->vehicles()->exists();
    }
}
