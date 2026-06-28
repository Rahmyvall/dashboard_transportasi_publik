<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Operator extends Model
{
    use HasFactory;

    protected $table = 'operators';

    /**
     * Timestamp handling
     * hanya created_at (tanpa updated_at)
     */
    public $timestamps = true;

    const UPDATED_AT = null;

    /**
     * Mass Assignment
     */
    protected $fillable = [
        'operator_name',
        'phone',
        'email',
        'address',
        'status',
    ];

    /**
     * Casts (API friendly)
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Default value
     */
    protected $attributes = [
        'status' => 'aktif',
    ];

    /**
     * Scope aktif
     */
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope nonaktif
     */
    public function scopeNonaktif(Builder $query): Builder
    {
        return $query->where('status', 'nonaktif');
    }

    /**
     * Accessor status label (API friendly)
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'aktif' => 'Aktif',
            default => 'Nonaktif',
        };
    }
}