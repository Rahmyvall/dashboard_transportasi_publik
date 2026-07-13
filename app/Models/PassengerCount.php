<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassengerCount extends Model
{
  use HasFactory;


  protected $table = 'passenger_counts';



  protected $fillable = [

    'trip_id',

    'vehicle_id',

    'stop_id',

    'boarding_count',

    'alighting_count',

    'current_load',

    'recorded_at',

  ];




  /*
    |--------------------------------------------------------------------------
    | CAST DATA
    |--------------------------------------------------------------------------
    */

  protected $casts = [

    'trip_id' => 'integer',

    'vehicle_id' => 'integer',

    'stop_id' => 'integer',

    'boarding_count' => 'integer',

    'alighting_count' => 'integer',

    'current_load' => 'integer',

    'recorded_at' => 'datetime',

  ];






    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */


  /**
   * Relasi ke Trip
   *
   * passenger_counts.trip_id
   *        |
   *        |
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






  /**
   * Relasi ke Vehicle
   *
   * passenger_counts.vehicle_id
   *        |
   *        |
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
        'plate_number' => 'Tidak Ada Kendaraan'
      ]);
  }






  /**
   * Relasi ke Stop/Halte
   *
   * passenger_counts.stop_id
   *        |
   *        |
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
    | ACCESSOR
    |--------------------------------------------------------------------------
    */



  /**
   * Ambil kapasitas kendaraan
   */
  public function getVehicleCapacityAttribute()
  {


    if ($this->vehicle) {

      return $this->vehicle->capacity;
    }


    return 0;
  }






  /**
   * Persentase okupansi
   */
  public function getOccupancyPercentageAttribute()
  {


    $capacity = $this->vehicle_capacity;



    if (
      !$capacity ||
      $capacity <= 0
    ) {

      return 0;
    }




    return round(

      ($this->current_load / $capacity) * 100,

      2

    );
  }







  /**
   * Status kapasitas
   */
  public function getOccupancyStatusAttribute()
  {


    $percentage = $this->occupancy_percentage;



    return match (true) {


      $percentage >= 100
      => 'Penuh',



      $percentage >= 80
      => 'Hampir Penuh',



      default
      => 'Tersedia'
    };
  }







  /*
    |--------------------------------------------------------------------------
    | SCOPE
    |--------------------------------------------------------------------------
    */



  public function scopeLatestRecord($query)
  {

    return $query->orderBy(
      'recorded_at',
      'desc'
    );
  }






  /**
   * Search data
   */
  public function scopeSearch(
    $query,
    $keyword
  ) {


    return $query->whereHas(
      'trip',
      function ($q) use ($keyword) {

        $q->where(
          'trip_code',
          'like',
          "%{$keyword}%"
        );
      }

    );
  }
}
