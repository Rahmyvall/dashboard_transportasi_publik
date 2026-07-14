<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexTransportModeRequest;
use App\Http\Requests\StoreTransportModeRequest;
use App\Http\Requests\UpdateTransportModeRequest;
use App\Http\Resources\TransportModeResource;
use App\Models\TransportMode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TransportModeController extends Controller
{
    /**
     * Menampilkan daftar moda transportasi.
     */
    public function index(
        IndexTransportModeRequest $request
    ): AnonymousResourceCollection {
        $validated = $request->validated();

        $search = $validated['search'] ?? null;
        $modeCode = $validated['mode_code'] ?? null;
        $sortBy = $validated['sort_by'] ?? 'id';
        $sortDirection = $validated['sort_direction'] ?? 'desc';
        $perPage = $validated['per_page'] ?? 10;

        $transportModes = TransportMode::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('mode_code', 'like', "%{$search}%")
                        ->orWhere('mode_name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($modeCode, function ($query, $modeCode) {
                $query->where('mode_code', $modeCode);
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage)
            ->withQueryString();

        return TransportModeResource::collection($transportModes);
    }

    /**
     * Menyimpan moda transportasi baru.
     */
    public function store(
        StoreTransportModeRequest $request
    ): JsonResponse {
        $transportMode = TransportMode::create(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Moda transportasi berhasil ditambahkan.',
            'data' => new TransportModeResource($transportMode),
        ], 201);
    }

    /**
     * Menampilkan detail moda transportasi.
     */
    public function show(
        TransportMode $transportMode
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => 'Detail moda transportasi berhasil ditemukan.',
            'data' => new TransportModeResource($transportMode),
        ]);
    }

    /**
     * Memperbarui moda transportasi.
     */
    public function update(
        UpdateTransportModeRequest $request,
        TransportMode $transportMode
    ): JsonResponse {
        $transportMode->update(
            $request->validated()
        );

        $transportMode->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Moda transportasi berhasil diperbarui.',
            'data' => new TransportModeResource($transportMode),
        ]);
    }

    /**
     * Menghapus moda transportasi.
     */
    public function destroy(
        TransportMode $transportMode
    ): JsonResponse {
        $transportMode->delete();

        return response()->json([
            'success' => true,
            'message' => 'Moda transportasi berhasil dihapus.',
            'data' => null,
        ]);
    }
}
