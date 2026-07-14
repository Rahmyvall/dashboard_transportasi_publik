<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRouteRequest;
use App\Http\Requests\UpdateRouteRequest;
use App\Http\Resources\RouteResource;
use App\Models\TransportRoute;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rule;

class RouteController extends Controller
{
    /**
     * Menampilkan daftar rute.
     */
    public function index(
        Request $request
    ): AnonymousResourceCollection {
        $filters = $request->validate([
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

            'transport_mode_id' => [
                'nullable',
                'integer',
                Rule::exists('transport_modes', 'id'),
            ],

            'status' => [
                'nullable',
                Rule::in([
                    'active',
                    'inactive',
                    'maintenance',
                ]),
            ],

            'origin' => [
                'nullable',
                'string',
                'max:150',
            ],

            'destination' => [
                'nullable',
                'string',
                'max:150',
            ],

            'min_distance' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'max_distance' => [
                'nullable',
                'numeric',
                'gte:min_distance',
            ],

            'min_duration' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'max_duration' => [
                'nullable',
                'integer',
                'gte:min_duration',
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
                    'route_code',
                    'route_name',
                    'origin',
                    'destination',
                    'distance_km',
                    'estimated_duration_minutes',
                    'status',
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

        $query = TransportRoute::query()
            ->with([
                'operator',
                'transportMode',
            ]);

        $trashed = $filters['trashed'] ?? 'without';

        if ($trashed === 'with') {
            $query->withTrashed();
        }

        if ($trashed === 'only') {
            $query->onlyTrashed();
        }

        $query
            ->search($filters['search'] ?? null)
            ->byOperator($filters['operator_id'] ?? null)
            ->byTransportMode(
                $filters['transport_mode_id'] ?? null
            )
            ->byStatus($filters['status'] ?? null);

        if (!empty($filters['origin'])) {
            $query->where(
                'origin',
                'like',
                '%' . trim($filters['origin']) . '%'
            );
        }

        if (!empty($filters['destination'])) {
            $query->where(
                'destination',
                'like',
                '%' . trim($filters['destination']) . '%'
            );
        }

        if (isset($filters['min_distance'])) {
            $query->where(
                'distance_km',
                '>=',
                $filters['min_distance']
            );
        }

        if (isset($filters['max_distance'])) {
            $query->where(
                'distance_km',
                '<=',
                $filters['max_distance']
            );
        }

        if (isset($filters['min_duration'])) {
            $query->where(
                'estimated_duration_minutes',
                '>=',
                $filters['min_duration']
            );
        }

        if (isset($filters['max_duration'])) {
            $query->where(
                'estimated_duration_minutes',
                '<=',
                $filters['max_duration']
            );
        }

        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortDirection =
            $filters['sort_direction'] ?? 'desc';

        $query->orderBy($sortBy, $sortDirection);

        $perPage = $filters['per_page'] ?? 15;

        $routes = $query
            ->paginate($perPage)
            ->withQueryString();

        return RouteResource::collection($routes)
            ->additional([
                'success' => true,
                'message' =>
                'Daftar rute berhasil ditampilkan.',
            ]);
    }

    /**
     * Menyimpan rute baru.
     */
    public function store(
        StoreRouteRequest $request
    ) {
        $route = TransportRoute::create(
            $request->validated()
        );

        $route->load([
            'operator',
            'transportMode',
        ]);

        return (new RouteResource($route))
            ->additional([
                'success' => true,
                'message' =>
                'Rute berhasil ditambahkan.',
            ])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Menampilkan detail rute.
     */
    public function show(
        TransportRoute $route
    ): RouteResource {
        $route->load([
            'operator',
            'transportMode',
        ]);

        return (new RouteResource($route))
            ->additional([
                'success' => true,
                'message' =>
                'Detail rute berhasil ditampilkan.',
            ]);
    }

    /**
     * Memperbarui rute.
     */
    public function update(
        UpdateRouteRequest $request,
        TransportRoute $route
    ): RouteResource {
        $route->update(
            $request->validated()
        );

        $route->refresh();

        $route->load([
            'operator',
            'transportMode',
        ]);

        return (new RouteResource($route))
            ->additional([
                'success' => true,
                'message' =>
                'Rute berhasil diperbarui.',
            ]);
    }

    /**
     * Soft delete rute.
     */
    public function destroy(
        TransportRoute $route
    ): JsonResponse {
        $route->delete();

        return response()->json([
            'success' => true,
            'message' =>
            'Rute berhasil dihapus sementara.',
            'data' => null,
        ]);
    }

    /**
     * Mengembalikan rute yang sudah dihapus.
     */
    public function restore(
        int $id
    ): RouteResource {
        $route = TransportRoute::onlyTrashed()
            ->findOrFail($id);

        $route->restore();

        $route->load([
            'operator',
            'transportMode',
        ]);

        return (new RouteResource($route))
            ->additional([
                'success' => true,
                'message' =>
                'Rute berhasil dikembalikan.',
            ]);
    }

    /**
     * Menghapus rute secara permanen.
     */
    public function forceDelete(
        int $id
    ): JsonResponse {
        $route = TransportRoute::onlyTrashed()
            ->findOrFail($id);

        $route->forceDelete();

        return response()->json([
            'success' => true,
            'message' =>
            'Rute berhasil dihapus permanen.',
            'data' => null,
        ]);
    }
}
