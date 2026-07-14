<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStopRequest;
use App\Http\Requests\UpdateStopRequest;
use App\Http\Resources\StopResource;
use App\Models\Stop;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StopController extends Controller
{
    public function index(Request $request)
    {
        $query = Stop::query();

        if ($request->filled('search')) {
            $search = $request->string('search')->trim();

            $query->where(function ($query) use ($search) {
                $query
                    ->where('stop_code', 'like', "%{$search}%")
                    ->orWhere('stop_name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('stop_type')) {
            $query->where(
                'stop_type',
                $request->stop_type
            );
        }

        if ($request->has('is_active')) {
            $query->where(
                'is_active',
                $request->boolean('is_active')
            );
        }

        $allowedSorts = [
            'id',
            'stop_code',
            'stop_name',
            'stop_type',
            'is_active',
            'created_at',
            'updated_at',
        ];

        $sortBy = in_array(
            $request->sort_by,
            $allowedSorts,
            true
        ) ? $request->sort_by : 'id';

        $sortDirection = $request->sort_direction === 'asc'
            ? 'asc'
            : 'desc';

        $perPage = min(
            max((int) $request->input('per_page', 10), 1),
            100
        );

        $stops = $query
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage)
            ->withQueryString();

        return StopResource::collection($stops)
            ->additional([
                'success' => true,
                'message' => 'Data stops berhasil diambil.',
            ]);
    }

    public function store(StoreStopRequest $request)
    {
        $data = $request->validated();

        $data['stop_type'] = $data['stop_type'] ?? 'halte';
        $data['is_active'] = $data['is_active'] ?? true;

        $stop = Stop::create($data);

        return (new StopResource($stop))
            ->additional([
                'success' => true,
                'message' => 'Stop berhasil ditambahkan.',
            ])
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Stop $stop)
    {
        return (new StopResource($stop))
            ->additional([
                'success' => true,
                'message' => 'Detail stop berhasil diambil.',
            ]);
    }

    public function update(
        UpdateStopRequest $request,
        Stop $stop
    ) {
        $stop->update($request->validated());

        return (new StopResource($stop->fresh()))
            ->additional([
                'success' => true,
                'message' => 'Stop berhasil diperbarui.',
            ]);
    }

    public function destroy(Stop $stop): JsonResponse
    {
        $stop->delete();

        return response()->json([
            'success' => true,
            'message' => 'Stop berhasil dihapus.',
            'data' => null,
        ]);
    }

    public function updateStatus(
        Request $request,
        Stop $stop
    ) {
        $validated = $request->validate([
            'is_active' => [
                'required',
                'boolean',
            ],
        ]);

        $stop->update($validated);

        return (new StopResource($stop->fresh()))
            ->additional([
                'success' => true,
                'message' => $stop->is_active
                    ? 'Stop berhasil diaktifkan.'
                    : 'Stop berhasil dinonaktifkan.',
            ]);
    }
}
