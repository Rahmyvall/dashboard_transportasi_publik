<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceLog extends Model
{
    use HasFactory;

    public const TYPES = [
        'routine'    => 'Perawatan Rutin',
        'repair'     => 'Perbaikan',
        'inspection' => 'Inspeksi',
        'emergency'  => 'Darurat',
    ];

    public const STATUSES = [
        'scheduled'   => 'Dijadwalkan',
        'in_progress' => 'Sedang Dikerjakan',
        'completed'   => 'Selesai',
        'cancelled'   => 'Dibatalkan',
    ];

    protected $fillable = [
        'vehicle_id',
        'maintenance_type',
        'description',
        'cost',
        'maintenance_date',
        'next_maintenance_date',
        'status',
        'handled_by',
    ];

    protected $casts = [
        'cost'                  => 'decimal:2',
        'maintenance_date'      => 'date',
        'next_maintenance_date' => 'date',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}