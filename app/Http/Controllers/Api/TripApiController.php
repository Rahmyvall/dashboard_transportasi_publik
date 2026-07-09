<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TripApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $trips = Trip::with([
                'schedule',
                'route',
                'vehicle',
                'driver',
            ])
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('trip_code', 'like', '%' . $request->search . '%');
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->filled('route_id'), function ($query) use ($request) {
                $query->where('route_id', $request->route_id);
            })
            ->when($request->filled('vehicle_id'), function ($query) use ($request) {
                $query->where('vehicle_id', $request->vehicle_id);
            })
            ->latest()
            ->paginate($request->per_page ?? 10);

        return response()->json([
            'success' => true,
            'message' => 'Data trips berhasil diambil.',
            'data' => $trips,
        ]);
    }

    public function active(): JsonResponse
    {
        $trips = Trip::with([
                'schedule',
                'route',
                'vehicle',
                'driver',
            ])
            ->whereIn('status', [
                'scheduled',
                'running',
                'delayed',
            ])
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Data active trips berhasil diambil.',
            'data' => $trips,
        ]);
    }

    public function history(): JsonResponse
    {
        $trips = Trip::with([
                'schedule',
                'route',
                'vehicle',
                'driver',
            ])
            ->whereIn('status', [
                'completed',
                'cancelled',
            ])
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Data trip history berhasil diambil.',
            'data' => $trips,
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $trip = Trip::with([
                'schedule',
                'route',
                'vehicle',
                'driver',
            ])
            ->find($id);

        if (!$trip) {
            return response()->json([
                'success' => false,
                'message' => 'Trip tidak ditemukan.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail trip berhasil diambil.',
            'data' => $trip,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'schedule_id' => 'nullable|exists:schedules,id',
            'route_id' => 'required|exists:routes,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'nullable|exists:drivers,id',

            'planned_start_time' => 'required|date',
            'planned_end_time' => 'nullable|date|after_or_equal:planned_start_time',

            'actual_start_time' => 'nullable|date',
            'actual_end_time' => 'nullable|date|after_or_equal:actual_start_time',

            'status' => 'nullable|in:scheduled,running,completed,cancelled,delayed',
            'delay_minutes' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $trip = null;

        DB::transaction(function () use (&$validated, &$trip) {
            $validated['trip_code'] = $this->generateTripCode();
            $validated['status'] = $validated['status'] ?? 'scheduled';
            $validated['delay_minutes'] = $validated['delay_minutes'] ?? 0;

            $trip = Trip::create($validated);
        });

        $trip->load([
            'schedule',
            'route',
            'vehicle',
            'driver',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Trip berhasil dibuat.',
            'data' => $trip,
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $trip = Trip::find($id);

        if (!$trip) {
            return response()->json([
                'success' => false,
                'message' => 'Trip tidak ditemukan.',
                'data' => null,
            ], 404);
        }

        $validated = $request->validate([
            'schedule_id' => 'nullable|exists:schedules,id',
            'route_id' => 'required|exists:routes,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'nullable|exists:drivers,id',

            'planned_start_time' => 'required|date',
            'planned_end_time' => 'nullable|date|after_or_equal:planned_start_time',

            'actual_start_time' => 'nullable|date',
            'actual_end_time' => 'nullable|date|after_or_equal:actual_start_time',

            'status' => 'nullable|in:scheduled,running,completed,cancelled,delayed',
            'delay_minutes' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = $validated['status'] ?? $trip->status;
        $validated['delay_minutes'] = $validated['delay_minutes'] ?? 0;

        $trip->update($validated);

        $trip->load([
            'schedule',
            'route',
            'vehicle',
            'driver',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Trip berhasil diperbarui.',
            'data' => $trip,
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $trip = Trip::find($id);

        if (!$trip) {
            return response()->json([
                'success' => false,
                'message' => 'Trip tidak ditemukan.',
                'data' => null,
            ], 404);
        }

        if (in_array($trip->status, ['running', 'completed'])) {
            return response()->json([
                'success' => false,
                'message' => 'Trip yang sudah berjalan atau selesai tidak dapat dihapus.',
                'data' => null,
            ], 422);
        }

        $trip->delete();

        return response()->json([
            'success' => true,
            'message' => 'Trip berhasil dihapus.',
            'data' => null,
        ]);
    }

    public function start(int $id): JsonResponse
    {
        $trip = Trip::with('vehicle')->find($id);

        if (!$trip) {
            return response()->json([
                'success' => false,
                'message' => 'Trip tidak ditemukan.',
                'data' => null,
            ], 404);
        }

        if (in_array($trip->status, ['running', 'completed', 'cancelled'])) {
            return response()->json([
                'success' => false,
                'message' => 'Trip tidak dapat dijalankan.',
                'data' => $trip,
            ], 422);
        }

        $delayMinutes = 0;
        $status = 'running';

        if ($trip->planned_start_time && now()->gt($trip->planned_start_time)) {
            $delayMinutes = now()->diffInMinutes($trip->planned_start_time);
            $status = 'delayed';
        }

        $trip->update([
            'status' => $status,
            'actual_start_time' => now(),
            'delay_minutes' => $delayMinutes,
        ]);

        if ($trip->vehicle) {
            $trip->vehicle->update([
                'status' => 'on_trip',
            ]);
        }

        $trip->load([
            'schedule',
            'route',
            'vehicle',
            'driver',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Trip sedang berjalan.',
            'data' => $trip,
        ]);
    }

    public function complete(int $id): JsonResponse
    {
        $trip = Trip::with('vehicle')->find($id);

        if (!$trip) {
            return response()->json([
                'success' => false,
                'message' => 'Trip tidak ditemukan.',
                'data' => null,
            ], 404);
        }

        if ($trip->status === 'cancelled') {
            return response()->json([
                'success' => false,
                'message' => 'Trip yang dibatalkan tidak dapat diselesaikan.',
                'data' => $trip,
            ], 422);
        }

        if ($trip->status === 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Trip sudah selesai.',
                'data' => $trip,
            ], 422);
        }

        $delayMinutes = $trip->delay_minutes ?? 0;

        if ($trip->planned_end_time && now()->gt($trip->planned_end_time)) {
            $delayMinutes = now()->diffInMinutes($trip->planned_end_time);
        }

        $trip->update([
            'status' => 'completed',
            'actual_end_time' => now(),
            'delay_minutes' => $delayMinutes,
        ]);

        if ($trip->vehicle) {
            $trip->vehicle->update([
                'status' => 'available',
            ]);
        }

        $trip->load([
            'schedule',
            'route',
            'vehicle',
            'driver',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Trip berhasil diselesaikan.',
            'data' => $trip,
        ]);
    }

    public function delayed(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'delay_minutes' => 'required|integer|min:1',
        ]);

        $trip = Trip::find($id);

        if (!$trip) {
            return response()->json([
                'success' => false,
                'message' => 'Trip tidak ditemukan.',
                'data' => null,
            ], 404);
        }

        if (in_array($trip->status, ['completed', 'cancelled'])) {
            return response()->json([
                'success' => false,
                'message' => 'Trip ini tidak dapat ditandai terlambat.',
                'data' => $trip,
            ], 422);
        }

        $trip->update([
            'status' => 'delayed',
            'delay_minutes' => $request->delay_minutes,
        ]);

        $trip->load([
            'schedule',
            'route',
            'vehicle',
            'driver',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Trip berhasil ditandai terlambat.',
            'data' => $trip,
        ]);
    }

    public function cancel(int $id): JsonResponse
    {
        $trip = Trip::with('vehicle')->find($id);

        if (!$trip) {
            return response()->json([
                'success' => false,
                'message' => 'Trip tidak ditemukan.',
                'data' => null,
            ], 404);
        }

        if ($trip->status === 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Trip yang sudah selesai tidak dapat dibatalkan.',
                'data' => $trip,
            ], 422);
        }

        if ($trip->status === 'cancelled') {
            return response()->json([
                'success' => false,
                'message' => 'Trip sudah dibatalkan.',
                'data' => $trip,
            ], 422);
        }

        $trip->update([
            'status' => 'cancelled',
        ]);

        if ($trip->vehicle) {
            $trip->vehicle->update([
                'status' => 'available',
            ]);
        }

        $trip->load([
            'schedule',
            'route',
            'vehicle',
            'driver',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Trip berhasil dibatalkan.',
            'data' => $trip,
        ]);
    }

    public function stats(): JsonResponse
    {
        $stats = [
            'total' => Trip::count(),
            'scheduled' => Trip::where('status', 'scheduled')->count(),
            'running' => Trip::where('status', 'running')->count(),
            'completed' => Trip::where('status', 'completed')->count(),
            'delayed' => Trip::where('status', 'delayed')->count(),
            'cancelled' => Trip::where('status', 'cancelled')->count(),
        ];

        return response()->json([
            'success' => true,
            'message' => 'Statistik trips berhasil diambil.',
            'data' => $stats,
        ]);
    }

    private function generateTripCode(): string
    {
        $date = now()->format('Ymd');

        $lastTrip = Trip::whereDate('created_at', now()->toDateString())
            ->where('trip_code', 'like', 'TRP-' . $date . '-%')
            ->lockForUpdate()
            ->orderByDesc('id')
            ->first();

        $newNumber = 1;

        if ($lastTrip) {
            $lastNumber = (int) substr($lastTrip->trip_code, -4);
            $newNumber = $lastNumber + 1;
        }

        return 'TRP-' . $date . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
