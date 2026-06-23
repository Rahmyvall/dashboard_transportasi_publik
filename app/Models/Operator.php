<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    /**
     * Nama tabel
     */
    protected $table = 'operators';

    /**
     * Karena tidak ada updated_at di migration
     */
    public $timestamps = false;

    /**
     * Field yang boleh diisi
     */
    protected $fillable = [
        'operator_name',
        'phone',
        'email',
        'address',
        'status',
    ];

    /**
     * Cast created_at ke datetime
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Relasi: 1 operator punya banyak user
     */
    public function users()
    {
        return $this->hasMany(User::class, 'operator_id');
    }

    /**
     * Scope: operator aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Accessor biar lebih enak dipakai di view
     */
    public function getNameAttribute()
    {
        return $this->operator_name;
    }
}