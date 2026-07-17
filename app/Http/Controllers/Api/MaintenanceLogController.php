<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaintenanceLogRequest;
use App\Http\Resources\MaintenanceLogResource;
use App\Models\MaintenanceLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rule;

class MaintenanceLogController extends Controller
{
    /**
     * Menampilkan daftar maintenance.
     *
     * Endpoint:
     * GET /api/maintenance-logs
     */
    public function index(
        Request $request
    ): AnonymousResourceCollection {
        $filters = $request->validate([
            'search'           => [
                'nullable',
                'string',
                'max:150',
            ],

            'vehicle_id'       => [
                'nullable',
                'integer',
                'exists:vehicles,id',
            ],

            'maintenance_type' => [
                'nullable',
                Rule::in([
                    'routine',
                    'repair',
                    'inspection',
                    'emergency',
                ]),
            ],

            'status'           => [
                'nullable',
                Rule::in([
                    'scheduled',
                    'in_progress',
                    'completed',
                    'cancelled',
                ]),
            ],

            'date_from'        => [
                'nullable',
                'date',
            ],

            'date_to'          => [
                'nullable',
                'date',
                'after_or_equal:date_from',
            ],

            'sort_by'          => [
                'nullable',
                Rule::in([
                    'id',
                    'maintenance_date',
                    'next_maintenance_date',
                    'cost',
                    'created_at',
                    'updated_at',
                ]),
            ],

            'sort_direction'   => [
                'nullable',
                Rule::in([
                    'asc',
                    'desc',
                ]),
            ],

            'per_page'         => [
                'nullable',
                'integer',
                'min:1',
                'max:100',
            ],
        ]);

        $perPage = (int) ($filters['per_page'] ?? 15);

        $sortBy = $filters['sort_by'] ?? 'maintenance_date';

        $sortDirection = $filters['sort_direction'] ?? 'desc';

        $maintenanceLogs = MaintenanceLog::query()
            ->with('vehicle')

        // Filter kendaraan
            ->when(
                isset($filters['vehicle_id']),
                fn($query) => $query->where(
                    'vehicle_id',
                    $filters['vehicle_id']
                )
            )

        // Filter jenis maintenance
            ->when(
                ! empty($filters['maintenance_type']),
                fn($query) => $query->where(
                    'maintenance_type',
                    $filters['maintenance_type']
                )
            )

        // Filter status
            ->when(
                ! empty($filters['status']),
                fn($query) => $query->where(
                    'status',
                    $filters['status']
                )
            )

        // Filter tanggal mulai
            ->when(
                ! empty($filters['date_from']),
                fn($query) => $query->whereDate(
                    'maintenance_date',
                    '>=',
                    $filters['date_from']
                )
            )

        // Filter tanggal akhir
            ->when(
                ! empty($filters['date_to']),
                fn($query) => $query->whereDate(
                    'maintenance_date',
                    '<=',
                    $filters['date_to']
                )
            )

        // Pencarian
            ->when(
                ! empty($filters['search']),
                function ($query) use ($filters) {
                    $search = trim($filters['search']);

                    $query->where(
                        function ($subQuery) use ($search) {
                            $subQuery
                                ->where(
                                    'description',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'handled_by',
                                    'like',
                                    "%{$search}%"
                                );
                        }
                    );
                }
            )

        // Sorting
            ->orderBy($sortBy, $sortDirection)
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        return MaintenanceLogResource::collection(
            $maintenanceLogs
        )->additional([
            'success' => true,
            'message' => 'Data maintenance berhasil diambil.',
        ]);
    }

    /**
     * Menyimpan maintenance baru.
     *
     * Endpoint:
     * POST /api/maintenance-logs
     */
    public function store(
        MaintenanceLogRequest $request
    ): JsonResponse {
        $maintenanceLog = MaintenanceLog::create(
            $request->validated()
        );

        $maintenanceLog->load('vehicle');

        return (new MaintenanceLogResource(
            $maintenanceLog
        ))
            ->additional([
                'success' => true,
                'message' =>
                'Data maintenance berhasil ditambahkan.',
            ])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Menampilkan detail maintenance.
     *
     * Endpoint:
     * GET /api/maintenance-logs/{maintenance_log}
     */
    public function show(
        MaintenanceLog $maintenanceLog
    ): MaintenanceLogResource {
        $maintenanceLog->load('vehicle');

        return (new MaintenanceLogResource(
            $maintenanceLog
        ))->additional([
            'success' => true,
            'message' => 'Detail maintenance berhasil diambil.',
        ]);
    }

    /**
     * Memperbarui maintenance.
     *
     * Endpoint:
     * PUT/PATCH /api/maintenance-logs/{maintenance_log}
     */
    public function update(
        MaintenanceLogRequest $request,
        MaintenanceLog $maintenanceLog
    ): MaintenanceLogResource {
        $maintenanceLog->update(
            $request->validated()
        );

        $maintenanceLog
            ->refresh()
            ->load('vehicle');

        return (new MaintenanceLogResource(
            $maintenanceLog
        ))->additional([
            'success' => true,
            'message' =>
            'Data maintenance berhasil diperbarui.',
        ]);
    }

    /**
     * Menghapus maintenance.
     *
     * Endpoint:
     * DELETE /api/maintenance-logs/{maintenance_log}
     */
    public function destroy(
        MaintenanceLog $maintenanceLog
    ): JsonResponse {
        $maintenanceLog->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data maintenance berhasil dihapus.',
            'data'    => null,
        ]);
    }
}