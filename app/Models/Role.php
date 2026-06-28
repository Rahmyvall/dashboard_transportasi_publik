<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Role extends Model
{
    use HasFactory;

    /**
     * Table (optional, boleh dihapus kalau nama tabel "roles")
     */
    protected $table = 'roles';

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'role_name',
        'description',
    ];

    /**
     * Cast attributes
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi: 1 role punya banyak user
     */
    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class, 'role_id');
    }
}