<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehiclePositionRequest;
use App\Http\Requests\UpdateVehiclePositionRequest;
use App\Http\Resources\VehiclePositionResource;
use App\Models\Vehicle;
use App\Models\VehiclePosition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class VehiclePositionController extends Controller
{
    /**
     * Menampilkan seluruh data posisi kendaraan.
     *
     * Filter tersedia:
     * - vehicle_id
     * - trip_id
     * - status
     * - from
     * - to
     * - per_page
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $validated = $request->validate([
            'vehicle_id' => [
                'nullable',
                'integer',
                'exists:vehicles,id',
            ],

            'trip_id' => [
                'nullable',
                'integer',
                'exists:trips,id',
            ],

            'status' => [
                'nullable',
                Rule::in([
                    'moving',
                    'idle',
                    'stopped',
                ]),
            ],

            'from' => [
                'nullable',
                'date',
            ],

            'to' => [
                'nullable',
                'date',
                'after_or_equal:from',
            ],

            'per_page' => [
                'nullable',
                'integer',
                'min:1',
                'max:100',
            ],
        ]);

        $query = VehiclePosition::query();

        if (isset($validated['vehicle_id'])) {
            $query->where(
                'vehicle_id',
                $validated['vehicle_id']
            );
        }

        if (isset($validated['trip_id'])) {
            $query->where(
                'trip_id',
                $validated['trip_id']
            );
        }

        if (isset($validated['status'])) {
            $query->where(
                'status',
                $validated['status']
            );
        }

        if (isset($validated['from'])) {
            $query->where(
                'recorded_at',
                '>=',
                $validated['from']
            );
        }

        if (isset($validated['to'])) {
            $query->where(
                'recorded_at',
                '<=',
                $validated['to']
            );
        }

        $perPage = $validated['per_page'] ?? 20;

        $positions = $query
            ->orderByDesc('recorded_at')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        return VehiclePositionResource::collection($positions);
    }

    /**
     * Menyimpan posisi GPS baru.
     */
    public function store(
        StoreVehiclePositionRequest $request
    ): JsonResponse {
        $data = $request->validated();

        $data['speed_kmh'] ??= 0;
        $data['status'] ??= 'stopped';

        $vehiclePosition = VehiclePosition::create($data);

        return (new VehiclePositionResource($vehiclePosition))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Menampilkan satu posisi.
     */
    public function show(
        VehiclePosition $vehiclePosition
    ): VehiclePositionResource {
        return new VehiclePositionResource($vehiclePosition);
    }

    /**
     * Memperbarui posisi.
     */
    public function update(
        UpdateVehiclePositionRequest $request,
        VehiclePosition $vehiclePosition
    ): VehiclePositionResource {
        $vehiclePosition->update(
            $request->validated()
        );

        return new VehiclePositionResource(
            $vehiclePosition->refresh()
        );
    }

    /**
     * Menghapus posisi.
     */
    public function destroy(
        VehiclePosition $vehiclePosition
    ): Response {
        $vehiclePosition->delete();

        return response()->noContent();
    }

    /**
     * Riwayat posisi untuk satu kendaraan.
     */
    public function history(
        Request $request,
        Vehicle $vehicle
    ): AnonymousResourceCollection {
        $validated = $request->validate([
            'status' => [
                'nullable',
                Rule::in([
                    'moving',
                    'idle',
                    'stopped',
                ]),
            ],

            'from' => [
                'nullable',
                'date',
            ],

            'to' => [
                'nullable',
                'date',
                'after_or_equal:from',
            ],

            'per_page' => [
                'nullable',
                'integer',
                'min:1',
                'max:100',
            ],
        ]);

        $query = $vehicle->positions();

        if (isset($validated['status'])) {
            $query->where(
                'status',
                $validated['status']
            );
        }

        if (isset($validated['from'])) {
            $query->where(
                'recorded_at',
                '>=',
                $validated['from']
            );
        }

        if (isset($validated['to'])) {
            $query->where(
                'recorded_at',
                '<=',
                $validated['to']
            );
        }

        $perPage = $validated['per_page'] ?? 20;

        $positions = $query
            ->orderByDesc('recorded_at')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        return VehiclePositionResource::collection($positions);
    }

    /**
     * Posisi terbaru dari satu kendaraan.
     */
    public function latest(
        Vehicle $vehicle
    ): VehiclePositionResource {
        $position = $vehicle
            ->positions()
            ->orderByDesc('recorded_at')
            ->orderByDesc('id')
            ->firstOrFail();

        return new VehiclePositionResource($position);
    }

    /**
     * Posisi terbaru dari setiap kendaraan.
     */
    public function latestAll(): AnonymousResourceCollection
    {
        $positions = VehiclePosition::query()
            ->whereRaw(
                'vehicle_positions.id = (
                    SELECT vp.id
                    FROM vehicle_positions AS vp
                    WHERE vp.vehicle_id = vehicle_positions.vehicle_id
                    ORDER BY vp.recorded_at DESC, vp.id DESC
                    LIMIT 1
                )'
            )
            ->orderBy('vehicle_id')
            ->get();

        return VehiclePositionResource::collection($positions);
    }
}
