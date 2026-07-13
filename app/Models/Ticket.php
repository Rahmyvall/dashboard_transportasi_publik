<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
  use HasFactory;



  protected $table = 'tickets';



  protected $fillable = [
    'trip_id',
    'route_id',
    'vehicle_id',
    'ticket_code',
    'payment_method',
    'fare',
    'ticket_status',
    'issued_at',
  ];



  protected $casts = [
    'fare' => 'decimal:2',
    'issued_at' => 'datetime',
  ];



  /**
   * Relasi ke Trip
   */
  public function trip()
  {
    return $this->belongsTo(
      Trip::class,
      'trip_id'
    );
  }



  /**
   * Relasi ke Route
   */
  public function route()
  {
    return $this->belongsTo(
      Route::class,
      'route_id'
    );
  }



  /**
   * Relasi ke Vehicle
   */
  public function vehicle()
  {
    return $this->belongsTo(
      Vehicle::class,
      'vehicle_id'
    );
  }



  /**
   * Scope tiket berhasil dibayar
   */
  public function scopePaid($query)
  {
    return $query->where(
      'ticket_status',
      'paid'
    );
  }



  /**
   * Scope berdasarkan metode pembayaran
   */
  public function scopePaymentMethod(
    $query,
    $method
  ) {
    return $query->where(
      'payment_method',
      $method
    );
  }
}
