<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportMode extends Model
{
    use HasFactory;

    protected $table = 'transport_modes';

    protected $fillable = [
        'mode_code',
        'mode_name',
        'description',
    ];

    /*
    |---------------------------------------------
    | ACCESSOR
    |---------------------------------------------
    | Membuat format nama mode lebih rapi
    */
    public function getModeNameAttribute($value)
    {
        return ucfirst($value);
    }

    /*
    |---------------------------------------------
    | MUTATOR
    |---------------------------------------------
    | Mode code selalu uppercase
    */
    public function setModeCodeAttribute($value)
    {
        $this->attributes['mode_code'] = strtoupper($value);
    }

    /*
    |---------------------------------------------
    | SCOPES
    |---------------------------------------------
    */

    // Cari berdasarkan kode
    public function scopeCode($query, $code)
    {
        return $query->where('mode_code', $code);
    }

    // Cari berdasarkan nama
    public function scopeName($query, $name)
    {
        return $query->where('mode_name', 'LIKE', '%' . $name . '%');
    }

    // Hanya data aktif (jika nanti kamu tambah kolom status)
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /*
    |---------------------------------------------
    | RELATIONS (SIAP EXPANSI SISTEM TRANSPORT)
    |---------------------------------------------
    */

    // Jika nanti mode dipakai oleh banyak rute
    public function routes()
    {
        return $this->hasMany(TransportRoute::class);
    }

    // Jika mode dipakai oleh armada
    public function fleets()
    {
        return $this->hasMany(Fleet::class, 'transport_mode_id');
    }

    // Jika mode dipakai oleh operator (opsional)
    public function operators()
    {
        return $this->hasMany(Operator::class, 'transport_mode_id');
    }
}