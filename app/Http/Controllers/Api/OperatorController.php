<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOperatorRequest;
use App\Http\Requests\UpdateOperatorRequest;
use App\Http\Resources\OperatorResource;
use App\Models\Operator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    /**
     * Menampilkan daftar operator.
     *
     * GET /api/operators
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min(
            max((int) $request->input('per_page', 10), 1),
            100
        );

        $operators = Operator::query()
            ->when(
                $request->filled('search'),
                function ($query) use ($request) {
                    $search = $request->input('search');

                    $query->where(function ($query) use ($search) {
                        $query->where('operator_name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('address', 'like', "%{$search}%");
                    });
                }
            )
            ->when(
                $request->filled('status'),
                function ($query) use ($request) {
                    $query->where('status', $request->input('status'));
                }
            )
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Data operator berhasil diambil.',
            'data' => OperatorResource::collection(
                $operators->items()
            ),
            'meta' => [
                'current_page' => $operators->currentPage(),
                'last_page' => $operators->lastPage(),
                'per_page' => $operators->perPage(),
                'total' => $operators->total(),
            ],
            'links' => [
                'first' => $operators->url(1),
                'last' => $operators->url($operators->lastPage()),
                'previous' => $operators->previousPageUrl(),
                'next' => $operators->nextPageUrl(),
            ],
        ]);
    }

    /**
     * Menambahkan operator.
     *
     * POST /api/operators
     */
    public function store(
        StoreOperatorRequest $request
    ): JsonResponse {
        $operator = Operator::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Operator berhasil ditambahkan.',
            'data' => new OperatorResource($operator),
        ], 201);
    }

    /**
     * Menampilkan detail operator.
     *
     * GET /api/operators/{operator}
     */
    public function show(Operator $operator): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail operator berhasil diambil.',
            'data' => new OperatorResource($operator),
        ]);
    }

    /**
     * Memperbarui operator.
     *
     * PUT/PATCH /api/operators/{operator}
     */
    public function update(
        UpdateOperatorRequest $request,
        Operator $operator
    ): JsonResponse {
        $operator->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Operator berhasil diperbarui.',
            'data' => new OperatorResource(
                $operator->fresh()
            ),
        ]);
    }

    /**
     * Menghapus operator sementara.
     *
     * DELETE /api/operators/{operator}
     */
    public function destroy(Operator $operator): JsonResponse
    {
        $operator->delete();

        return response()->json([
            'success' => true,
            'message' => 'Operator berhasil dihapus.',
            'data' => null,
        ]);
    }
}
