<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    /**
     * Menampilkan daftar kendaraan.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->validate([
            'search' => [
                'nullable',
                'string',
                'max:100',
            ],

            'operator_id' => [
                'nullable',
                'integer',
                Rule::exists('operators', 'id'),
            ],

            'transport_mode_id' => [
                'nullable',
                'integer',
                Rule::exists('transport_modes', 'id'),
            ],

            'status' => [
                'nullable',
                Rule::in(Vehicle::STATUSES),
            ],

            'manufacture_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:' . (now()->year + 1),
            ],

            'last_service_from' => [
                'nullable',
                'date_format:Y-m-d',
            ],

            'last_service_to' => [
                'nullable',
                'date_format:Y-m-d',
            ],

            'trashed' => [
                'nullable',
                Rule::in([
                    'without',
                    'with',
                    'only',
                ]),
            ],

            'sort_by' => [
                'nullable',
                Rule::in([
                    'id',
                    'vehicle_code',
                    'plate_number',
                    'capacity',
                    'manufacture_year',
                    'status',
                    'last_service_date',
                    'created_at',
                    'updated_at',
                ]),
            ],

            'sort_direction' => [
                'nullable',
                Rule::in([
                    'asc',
                    'desc',
                ]),
            ],

            'per_page' => [
                'nullable',
                'integer',
                'min:1',
                'max:100',
            ],
        ]);

        $query = Vehicle::query();

        /*
         * Mengatur data soft delete.
         */
        match ($filters['trashed'] ?? 'without') {
            'with' => $query->withTrashed(),
            'only' => $query->onlyTrashed(),
            default => null,
        };

        /*
         * Pencarian kode kendaraan atau nomor polisi.
         */
        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function ($subQuery) use ($search) {
                $subQuery
                    ->where('vehicle_code', 'like', "%{$search}%")
                    ->orWhere('plate_number', 'like', "%{$search}%");
            });
        }

        /*
         * Filter operator.
         */
        if (!empty($filters['operator_id'])) {
            $query->where(
                'operator_id',
                $filters['operator_id']
            );
        }

        /*
         * Filter jenis transportasi.
         */
        if (!empty($filters['transport_mode_id'])) {
            $query->where(
                'transport_mode_id',
                $filters['transport_mode_id']
            );
        }

        /*
         * Filter status.
         */
        if (!empty($filters['status'])) {
            $query->where(
                'status',
                $filters['status']
            );
        }

        /*
         * Filter tahun produksi.
         */
        if (!empty($filters['manufacture_year'])) {
            $query->where(
                'manufacture_year',
                $filters['manufacture_year']
            );
        }

        /*
         * Filter tanggal servis.
         */
        if (!empty($filters['last_service_from'])) {
            $query->whereDate(
                'last_service_date',
                '>=',
                $filters['last_service_from']
            );
        }

        if (!empty($filters['last_service_to'])) {
            $query->whereDate(
                'last_service_date',
                '<=',
                $filters['last_service_to']
            );
        }

        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        $perPage = $filters['per_page'] ?? 15;

        $vehicles = $query
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage)
            ->withQueryString();

        return VehicleResource::collection($vehicles);
    }

    /**
     * Menyimpan kendaraan baru.
     */
    public function store(
        StoreVehicleRequest $request
    ): JsonResponse {
        $vehicle = Vehicle::create($request->validated());

        return (new VehicleResource($vehicle))
            ->additional([
                'message' => 'Data kendaraan berhasil ditambahkan.',
            ])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Menampilkan detail kendaraan.
     */
    public function show(Vehicle $vehicle): VehicleResource
    {
        return (new VehicleResource($vehicle))
            ->additional([
                'message' => 'Detail kendaraan berhasil ditampilkan.',
            ]);
    }

    /**
     * Memperbarui kendaraan.
     */
    public function update(
        UpdateVehicleRequest $request,
        Vehicle $vehicle
    ): VehicleResource {
        $vehicle->update($request->validated());

        return (new VehicleResource($vehicle->refresh()))
            ->additional([
                'message' => 'Data kendaraan berhasil diperbarui.',
            ]);
    }

    /**
     * Soft delete kendaraan.
     */
    public function destroy(Vehicle $vehicle): JsonResponse
    {
        $vehicle->delete();

        return response()->json([
            'message' => 'Data kendaraan berhasil dihapus.',
            'data' => [
                'id' => $vehicle->id,
                'vehicle_code' => $vehicle->vehicle_code,
            ],
        ]);
    }

    /**
     * Mengembalikan data yang telah dihapus.
     */
    public function restore(string $vehicle): JsonResponse
    {
        $vehicleModel = Vehicle::onlyTrashed()
            ->findOrFail($vehicle);

        $vehicleModel->restore();

        return (new VehicleResource($vehicleModel->refresh()))
            ->additional([
                'message' => 'Data kendaraan berhasil dipulihkan.',
            ])
            ->response();
    }

    /**
     * Menghapus kendaraan secara permanen.
     */
    public function forceDestroy(string $vehicle): JsonResponse
    {
        $vehicleModel = Vehicle::withTrashed()
            ->findOrFail($vehicle);

        $vehicleData = [
            'id' => $vehicleModel->id,
            'vehicle_code' => $vehicleModel->vehicle_code,
        ];

        $vehicleModel->forceDelete();

        return response()->json([
            'message' => 'Data kendaraan berhasil dihapus permanen.',
            'data' => $vehicleData,
        ]);
    }
}
