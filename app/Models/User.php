<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'role_id',
        'operator_id',
        'name',
        'username',
        'email',
        'password',
        'status',
    ];

    /**
     * Hidden fields saat response API / JSON
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast attributes
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relasi ke Operator
     */
    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    /**
     * Scope user aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}