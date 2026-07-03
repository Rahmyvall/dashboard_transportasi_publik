<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stop extends Model
{
    use HasFactory;

    protected $table = 'stops';

    /**
     * Field yang boleh diisi (mass assignment)
     */
    protected $fillable = [
        'stop_code',
        'stop_name',
        'stop_type',
        'latitude',
        'longitude',
        'address',
        'is_active',
    ];

    /**
     * Cast data otomatis
     */
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'is_active' => 'boolean',
    ];

    /* =========================
        SCOPES (FILTER DATA)
    ========================= */

    // hanya data aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // filter berdasarkan tipe stop
    public function scopeType($query, $type)
    {
        return $query->where('stop_type', $type);
    }

    // cari berdasarkan keyword nama
    public function scopeSearch($query, $keyword)
    {
        return $query->where('stop_name', 'like', '%' . $keyword . '%');
    }

    /* =========================
        ACCESSOR (FORMAT DATA)
    ========================= */

    // format nama stop (uppercase)
    public function getStopNameAttribute($value)
    {
        return strtoupper($value);
    }

    // format koordinat gabungan
    public function getCoordinateAttribute()
    {
        if ($this->latitude && $this->longitude) {
            return $this->latitude . ', ' . $this->longitude;
        }

        return null;
    }

    /* =========================
        MUTATOR (INPUT DATA)
    ========================= */

    public function setStopCodeAttribute($value)
    {
        $this->attributes['stop_code'] = strtoupper($value);
    }

    public function setStopNameAttribute($value)
    {
        $this->attributes['stop_name'] = ucwords(strtolower($value));
    }
}