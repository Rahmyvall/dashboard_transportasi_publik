<?php

namespace App\Models;

use App\Enums\DriverStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Nama tabel yang digunakan model.
     *
     * Sebenarnya properti ini boleh dihapus karena Laravel
     * otomatis menggunakan nama tabel "drivers".
     */
    protected $table = 'drivers';

    /**
     * Atribut yang dapat diisi melalui mass assignment.
     */
    protected $fillable = [
        'operator_id',
        'driver_name',
        'license_number',
        'phone',
        'address',
        'status',
    ];

    /**
     * Nilai default atribut.
     */
    protected $attributes = [
        'status' => DriverStatus::ACTIVE->value,
    ];

    /**
     * Atribut tambahan yang otomatis muncul ketika model
     * diubah menjadi array atau JSON.
     */
    protected $appends = [
        'display_name',
        'status_label',
    ];

    /**
     * Casting atribut model.
     */
    protected $casts = [
        'id' => 'integer',
        'operator_id' => 'integer',
        'status' => DriverStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Driver dimiliki oleh satu operator.
     *
     * Foreign key:
     * drivers.operator_id -> operators.id
     */
    public function operator(): BelongsTo
    {
        return $this->belongsTo(
            Operator::class,
            'operator_id',
            'id'
        );
    }

    /**
     * Driver memiliki banyak jadwal.
     *
     * Foreign key:
     * schedules.driver_id -> drivers.id
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(
            Schedule::class,
            'driver_id',
            'id'
        );
    }

    /**
     * Driver memiliki banyak perjalanan.
     *
     * Foreign key:
     * trips.driver_id -> drivers.id
     */
    public function trips(): HasMany
    {
        return $this->hasMany(
            Trip::class,
            'driver_id',
            'id'
        );
    }

    /**
     * Driver memiliki banyak kendaraan.
     *
     * Foreign key:
     * vehicles.driver_id -> drivers.id
     */
    public function vehicles(): HasMany
    {
        return $this->hasMany(
            Vehicle::class,
            'driver_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LOCAL SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Mengambil driver dengan status aktif.
     *
     * Contoh:
     * Driver::active()->get();
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where(
            'status',
            DriverStatus::ACTIVE->value
        );
    }

    /**
     * Mengambil driver dengan status tidak aktif.
     *
     * Contoh:
     * Driver::inactive()->get();
     */
    public function scopeInactive(Builder $query): Builder
    {
        return $query->where(
            'status',
            DriverStatus::INACTIVE->value
        );
    }

    /**
     * Mengambil driver yang sedang bertugas.
     *
     * Contoh:
     * Driver::onDuty()->get();
     */
    public function scopeOnDuty(Builder $query): Builder
    {
        return $query->where(
            'status',
            DriverStatus::ON_DUTY->value
        );
    }

    /**
     * Filter berdasarkan operator.
     *
     * Contoh:
     * Driver::byOperator(1)->get();
     */
    public function scopeByOperator(
        Builder $query,
        int $operatorId
    ): Builder {
        return $query->where(
            'operator_id',
            $operatorId
        );
    }

    /**
     * Pencarian driver berdasarkan nama, nomor SIM,
     * nomor telepon, atau alamat.
     *
     * Contoh:
     * Driver::search('Budi')->get();
     */
    public function scopeSearch(
        Builder $query,
        ?string $keyword
    ): Builder {
        if (blank($keyword)) {
            return $query;
        }

        return $query->where(function (Builder $subQuery) use ($keyword) {
            $subQuery
                ->where('driver_name', 'like', "%{$keyword}%")
                ->orWhere('license_number', 'like', "%{$keyword}%")
                ->orWhere('phone', 'like', "%{$keyword}%")
                ->orWhere('address', 'like', "%{$keyword}%");
        });
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Menghasilkan nama tampilan driver.
     *
     * Contoh hasil:
     * Budi Santoso (SIM-B2-123456)
     *
     * Pemanggilan:
     * $driver->display_name
     */
    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                return sprintf(
                    '%s (%s)',
                    $this->driver_name,
                    $this->license_number
                );
            }
        );
    }

    /**
     * Menghasilkan label status dalam Bahasa Indonesia.
     *
     * Pemanggilan:
     * $driver->status_label
     */
    protected function statusLabel(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                if ($this->status instanceof DriverStatus) {
                    return $this->status->label();
                }

                return DriverStatus::tryFrom(
                    (string) $this->status
                )?->label() ?? 'Tidak Diketahui';
            }
        );
    }
}
