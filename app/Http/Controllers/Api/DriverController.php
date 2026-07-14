<?php

namespace App\Http\Controllers\Api;

use App\Enums\DriverStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Http\Resources\DriverResource;
use App\Models\Driver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rule;

class DriverController extends Controller
{
    /**
     * Menampilkan daftar driver.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $validated = $request->validate([
            'search' => [
                'nullable',
                'string',
                'max:150',
            ],

            'operator_id' => [
                'nullable',
                'integer',
                Rule::exists('operators', 'id'),
            ],

            'status' => [
                'nullable',
                Rule::enum(DriverStatus::class),
            ],

            'sort_by' => [
                'nullable',
                Rule::in([
                    'id',
                    'driver_name',
                    'license_number',
                    'status',
                    'created_at',
                    'updated_at',
                ]),
            ],

            'sort_direction' => [
                'nullable',
                Rule::in(['asc', 'desc']),
            ],

            'per_page' => [
                'nullable',
                'integer',
                'min:1',
                'max:100',
            ],
        ]);

        $search = $validated['search'] ?? null;
        $operatorId = $validated['operator_id'] ?? null;
        $status = $validated['status'] ?? null;
        $sortBy = $validated['sort_by'] ?? 'created_at';
        $sortDirection = $validated['sort_direction'] ?? 'desc';
        $perPage = $validated['per_page'] ?? 10;

        $drivers = Driver::query()
            ->with('operator')
            ->when($search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('driver_name', 'like', "%{$search}%")
                        ->orWhere('license_number', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%");
                });
            })
            ->when($operatorId, function ($query, $operatorId) {
                $query->where('operator_id', $operatorId);
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage)
            ->withQueryString();

        return DriverResource::collection($drivers)
            ->additional([
                'success' => true,
                'message' => 'Data driver berhasil diambil.',
            ]);
    }

    /**
     * Menyimpan driver baru.
     */
    public function store(StoreDriverRequest $request)
    {
        $driver = Driver::create($request->validated());

        $driver->load('operator');

        return (new DriverResource($driver))
            ->additional([
                'success' => true,
                'message' => 'Driver berhasil ditambahkan.',
            ])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Menampilkan detail driver.
     */
    public function show(Driver $driver): DriverResource
    {
        $driver->load('operator');

        return (new DriverResource($driver))
            ->additional([
                'success' => true,
                'message' => 'Detail driver berhasil diambil.',
            ]);
    }

    /**
     * Memperbarui driver.
     */
    public function update(
        UpdateDriverRequest $request,
        Driver $driver
    ): DriverResource {
        $driver->update($request->validated());

        $driver->refresh();
        $driver->load('operator');

        return (new DriverResource($driver))
            ->additional([
                'success' => true,
                'message' => 'Driver berhasil diperbarui.',
            ]);
    }

    /**
     * Soft delete driver.
     */
    public function destroy(Driver $driver): JsonResponse
    {
        $driver->delete();

        return response()->json([
            'success' => true,
            'message' => 'Driver berhasil dipindahkan ke tempat sampah.',
        ]);
    }

    /**
     * Menampilkan driver yang telah dihapus.
     */
    public function trashed(Request $request): AnonymousResourceCollection
    {
        $validated = $request->validate([
            'search' => [
                'nullable',
                'string',
                'max:150',
            ],

            'operator_id' => [
                'nullable',
                'integer',
                Rule::exists('operators', 'id'),
            ],

            'status' => [
                'nullable',
                Rule::enum(DriverStatus::class),
            ],

            'per_page' => [
                'nullable',
                'integer',
                'min:1',
                'max:100',
            ],
        ]);

        $search = $validated['search'] ?? null;
        $operatorId = $validated['operator_id'] ?? null;
        $status = $validated['status'] ?? null;
        $perPage = $validated['per_page'] ?? 10;

        $drivers = Driver::onlyTrashed()
            ->with('operator')
            ->when($search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('driver_name', 'like', "%{$search}%")
                        ->orWhere('license_number', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($operatorId, function ($query, $operatorId) {
                $query->where('operator_id', $operatorId);
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest('deleted_at')
            ->paginate($perPage)
            ->withQueryString();

        return DriverResource::collection($drivers)
            ->additional([
                'success' => true,
                'message' => 'Data driver terhapus berhasil diambil.',
            ]);
    }

    /**
     * Mengembalikan driver yang telah dihapus.
     */
    public function restore(int $id): DriverResource
    {
        $driver = Driver::onlyTrashed()->findOrFail($id);

        $driver->restore();
        $driver->load('operator');

        return (new DriverResource($driver))
            ->additional([
                'success' => true,
                'message' => 'Driver berhasil dikembalikan.',
            ]);
    }

    /**
     * Menghapus driver secara permanen.
     */
    public function forceDelete(int $id): JsonResponse
    {
        $driver = Driver::onlyTrashed()->findOrFail($id);

        $driver->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Driver berhasil dihapus secara permanen.',
        ]);
    }
}
