<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
  use HasFactory;

  /**
   * Nama tabel database.
   */
  protected $table = 'tickets';

  /**
   * Primary key tabel.
   */
  protected $primaryKey = 'id';

  /**
   * Primary key menggunakan auto increment.
   */
  public $incrementing = true;

  /**
   * Tipe primary key.
   */
  protected $keyType = 'int';

  /**
   * Tabel memiliki created_at dan updated_at.
   */
  public $timestamps = true;

  /**
   * Daftar metode pembayaran sesuai enum migration.
   */
  public const PAYMENT_CASH = 'cash';
  public const PAYMENT_EMONEY = 'emoney';
  public const PAYMENT_QRIS = 'qris';
  public const PAYMENT_CARD = 'card';
  public const PAYMENT_OTHER = 'other';

  public const PAYMENT_METHODS = [
    self::PAYMENT_CASH,
    self::PAYMENT_EMONEY,
    self::PAYMENT_QRIS,
    self::PAYMENT_CARD,
    self::PAYMENT_OTHER,
  ];

  /**
   * Daftar status tiket sesuai enum migration.
   */
  public const STATUS_PAID = 'paid';
  public const STATUS_REFUNDED = 'refunded';
  public const STATUS_FAILED = 'failed';

  public const TICKET_STATUSES = [
    self::STATUS_PAID,
    self::STATUS_REFUNDED,
    self::STATUS_FAILED,
  ];

  /**
   * Kolom yang dapat diisi melalui mass assignment.
   */
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

  /**
   * Nilai default model.
   *
   * Nilai ini disesuaikan dengan default pada migration.
   */
  protected $attributes = [
    'payment_method' => self::PAYMENT_EMONEY,
    'fare' => 0,
    'ticket_status' => self::STATUS_PAID,
  ];

  /**
   * Casting tipe data.
   */
  protected $casts = [
    'id' => 'integer',
    'trip_id' => 'integer',
    'route_id' => 'integer',
    'vehicle_id' => 'integer',
    'fare' => 'decimal:2',
    'issued_at' => 'datetime',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
  ];

  /**
   * Relasi tiket ke perjalanan.
   */
  public function trip(): BelongsTo
  {
    return $this->belongsTo(
      Trip::class,
      'trip_id',
      'id'
    );
  }

  /**
   * Relasi tiket ke rute.
   */
  public function route(): BelongsTo
  {
    return $this->belongsTo(
      Route::class,
      'route_id',
      'id'
    );
  }

  /**
   * Relasi tiket ke kendaraan.
   */
  public function vehicle(): BelongsTo
  {
    return $this->belongsTo(
      Vehicle::class,
      'vehicle_id',
      'id'
    );
  }

  /**
   * Scope pencarian berdasarkan kode tiket.
   *
   * Contoh:
   * Ticket::search('TKT-001')->get();
   */
  public function scopeSearch(
    Builder $query,
    ?string $keyword
  ): Builder {
    return $query->when(
      filled($keyword),
      function (Builder $query) use ($keyword) {
        $query->where(
          'ticket_code',
          'like',
          '%' . $keyword . '%'
        );
      }
    );
  }

  /**
   * Scope tiket yang sudah dibayar.
   *
   * Contoh:
   * Ticket::paid()->get();
   */
  public function scopePaid(Builder $query): Builder
  {
    return $query->where(
      'ticket_status',
      self::STATUS_PAID
    );
  }

  /**
   * Scope tiket yang dikembalikan dananya.
   */
  public function scopeRefunded(Builder $query): Builder
  {
    return $query->where(
      'ticket_status',
      self::STATUS_REFUNDED
    );
  }

  /**
   * Scope tiket yang gagal.
   */
  public function scopeFailed(Builder $query): Builder
  {
    return $query->where(
      'ticket_status',
      self::STATUS_FAILED
    );
  }

  /**
   * Scope berdasarkan status tiket.
   *
   * Contoh:
   * Ticket::status('paid')->get();
   */
  public function scopeStatus(
    Builder $query,
    ?string $status
  ): Builder {
    return $query->when(
      filled($status),
      fn(Builder $query) => $query->where(
        'ticket_status',
        $status
      )
    );
  }

  /**
   * Scope berdasarkan metode pembayaran.
   *
   * Contoh:
   * Ticket::paymentMethod('qris')->get();
   */
  public function scopePaymentMethod(
    Builder $query,
    ?string $method
  ): Builder {
    return $query->when(
      filled($method),
      fn(Builder $query) => $query->where(
        'payment_method',
        $method
      )
    );
  }

  /**
   * Scope berdasarkan perjalanan.
   */
  public function scopeTrip(
    Builder $query,
    ?int $tripId
  ): Builder {
    return $query->when(
      $tripId !== null,
      fn(Builder $query) => $query->where(
        'trip_id',
        $tripId
      )
    );
  }

  /**
   * Scope berdasarkan rute.
   */
  public function scopeRoute(
    Builder $query,
    ?int $routeId
  ): Builder {
    return $query->when(
      $routeId !== null,
      fn(Builder $query) => $query->where(
        'route_id',
        $routeId
      )
    );
  }

  /**
   * Scope berdasarkan kendaraan.
   */
  public function scopeVehicle(
    Builder $query,
    ?int $vehicleId
  ): Builder {
    return $query->when(
      $vehicleId !== null,
      fn(Builder $query) => $query->where(
        'vehicle_id',
        $vehicleId
      )
    );
  }

  /**
   * Scope tiket berdasarkan rentang tanggal penerbitan.
   */
  public function scopeIssuedBetween(
    Builder $query,
    ?string $startDate,
    ?string $endDate
  ): Builder {
    return $query
      ->when(
        filled($startDate),
        fn(Builder $query) => $query->whereDate(
          'issued_at',
          '>=',
          $startDate
        )
      )
      ->when(
        filled($endDate),
        fn(Builder $query) => $query->whereDate(
          'issued_at',
          '<=',
          $endDate
        )
      );
  }
}
