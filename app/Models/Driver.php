<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Driver extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'drivers';

    protected $fillable = [
        'operator_id',
        'driver_name',
        'license_number',
        'phone',
        'address',
        'status',
    ];

    protected $casts = [
        'operator_id' => 'integer',
        'driver_name' => 'string',
        'license_number' => 'string',
        'phone' => 'string',
        'address' => 'string',
        'status' => 'string',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi: Driver milik satu Operator
     */
    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class);
    }

    /**
     * Scope: driver aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope: driver tidak aktif
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope: driver sedang bertugas
     */
    public function scopeOnDuty($query)
    {
        return $query->where('status', 'on_duty');
    }
}