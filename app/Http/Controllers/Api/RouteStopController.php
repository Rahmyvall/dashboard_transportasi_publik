<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReorderRouteStopsRequest;
use App\Http\Requests\StoreRouteStopRequest;
use App\Http\Requests\UpdateRouteStopRequest;
use App\Http\Resources\RouteStopResource;
use App\Models\Route as TransitRoute;
use App\Models\RouteStop;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RouteStopController extends Controller
{
    /**
     * Menampilkan semua route stop.
     *
     * Filter:
     * - route_id
     * - stop_id
     * - stop_order
     * - per_page
     */
    public function index(Request $request)
    {
        $filters = $request->validate([
            'route_id' => [
                'nullable',
                'integer',
                'exists:routes,id',
            ],

            'stop_id' => [
                'nullable',
                'integer',
                'exists:stops,id',
            ],

            'stop_order' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'per_page' => [
                'nullable',
                'integer',
                'min:1',
                'max:100',
            ],
        ]);

        $routeStops = RouteStop::query()
            ->with([
                'route',
                'stop',
            ])
            ->when(
                isset($filters['route_id']),
                fn($query) => $query->where(
                    'route_id',
                    $filters['route_id']
                )
            )
            ->when(
                isset($filters['stop_id']),
                fn($query) => $query->where(
                    'stop_id',
                    $filters['stop_id']
                )
            )
            ->when(
                isset($filters['stop_order']),
                fn($query) => $query->where(
                    'stop_order',
                    $filters['stop_order']
                )
            )
            ->ordered()
            ->paginate($filters['per_page'] ?? 15)
            ->withQueryString();

        return RouteStopResource::collection($routeStops);
    }

    /**
     * Menambahkan halte ke dalam rute.
     */
    public function store(StoreRouteStopRequest $request)
    {
        $routeStop = DB::transaction(function () use ($request) {
            return RouteStop::create($request->validated());
        });

        $routeStop->load([
            'route',
            'stop',
        ]);

        return (new RouteStopResource($routeStop))
            ->additional([
                'message' => 'Halte berhasil ditambahkan ke dalam rute.',
            ])
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Menampilkan satu route stop.
     */
    public function show(RouteStop $routeStop)
    {
        $routeStop->load([
            'route',
            'stop',
        ]);

        return (new RouteStopResource($routeStop))
            ->additional([
                'message' => 'Data halte rute berhasil ditemukan.',
            ]);
    }

    /**
     * Memperbarui route stop.
     */
    public function update(
        UpdateRouteStopRequest $request,
        RouteStop $routeStop
    ) {
        DB::transaction(function () use ($request, $routeStop) {
            $routeStop->update($request->validated());
        });

        $routeStop->refresh()->load([
            'route',
            'stop',
        ]);

        return (new RouteStopResource($routeStop))
            ->additional([
                'message' => 'Data halte rute berhasil diperbarui.',
            ]);
    }

    /**
     * Menghapus halte dari rute.
     */
    public function destroy(RouteStop $routeStop)
    {
        DB::transaction(function () use ($routeStop) {
            $routeStop->delete();
        });

        return response()->json([
            'message' => 'Halte berhasil dihapus dari rute.',
        ]);
    }

    /**
     * Mengurutkan ulang seluruh halte pada satu rute.
     *
     * Urutan array menentukan stop_order:
     * indeks pertama = stop_order 1.
     */
    public function reorder(
        ReorderRouteStopsRequest $request,
        TransitRoute $route
    ) {
        $routeStopIds = collect(
            $request->validated('route_stop_ids')
        )
            ->map(fn($id) => (int) $id)
            ->values();

        $orderedRouteStops = DB::transaction(
            function () use ($route, $routeStopIds) {
                $currentRouteStops = RouteStop::query()
                    ->where('route_id', $route->id)
                    ->lockForUpdate()
                    ->get();

                $currentIds = $currentRouteStops
                    ->pluck('id')
                    ->map(fn($id) => (int) $id)
                    ->sort()
                    ->values();

                $submittedIds = $routeStopIds
                    ->sort()
                    ->values();

                /*
                 * Seluruh halte pada rute wajib dikirim.
                 * Hal ini mencegah benturan urutan dengan data
                 * yang tidak dikirim.
                 */
                if ($currentIds->all() !== $submittedIds->all()) {
                    throw ValidationException::withMessages([
                        'route_stop_ids' => [
                            'Daftar harus berisi seluruh halte yang terdaftar pada rute ini.',
                        ],
                    ]);
                }

                /*
                 * Tahap pertama menggunakan nomor sementara.
                 * Diperlukan agar pertukaran urutan, misalnya
                 * 1 menjadi 2 dan 2 menjadi 1, tidak melanggar
                 * unique constraint.
                 */
                $maximumOrder = (int) $currentRouteStops
                    ->max('stop_order');

                $temporaryStart = $maximumOrder
                    + $currentRouteStops->count()
                    + 100;

                foreach ($routeStopIds as $index => $routeStopId) {
                    RouteStop::query()
                        ->whereKey($routeStopId)
                        ->where('route_id', $route->id)
                        ->update([
                            'stop_order' => $temporaryStart + $index,
                        ]);
                }

                /*
                 * Tahap kedua menyimpan urutan sebenarnya.
                 */
                foreach ($routeStopIds as $index => $routeStopId) {
                    RouteStop::query()
                        ->whereKey($routeStopId)
                        ->where('route_id', $route->id)
                        ->update([
                            'stop_order' => $index + 1,
                        ]);
                }

                return RouteStop::query()
                    ->with([
                        'route',
                        'stop',
                    ])
                    ->where('route_id', $route->id)
                    ->orderBy('stop_order')
                    ->get();
            }
        );

        return RouteStopResource::collection($orderedRouteStops)
            ->additional([
                'message' => 'Urutan halte berhasil diperbarui.',
            ]);
    }
}
