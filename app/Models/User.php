<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use App\Models\Operator;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
     * Hidden fields
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast attributes (Laravel 11 style)
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi ke Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Relasi ke Operator
     */
    public function operator()
    {
        return $this->belongsTo(Operator::class, 'operator_id');
    }

    /**
     * Scope user aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}