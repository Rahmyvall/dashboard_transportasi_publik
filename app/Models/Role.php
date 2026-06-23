<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * Nama tabel (opsional kalau tidak pakai plural default)
     */
    protected $table = 'roles';

    /**
     * Karena tidak ada updated_at di migration
     */
    public $timestamps = true;

    /**
     * Fillable field sesuai database
     */
    protected $fillable = [
        'role_name',
        'description',
    ];

    /**
     * Cast created_at jadi datetime
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Relasi: 1 role punya banyak user
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}