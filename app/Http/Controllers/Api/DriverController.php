<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DriverController extends Controller
{
    /**
     * GET: /api/drivers
     * Ambil semua data driver
     */
    public function index(): JsonResponse
    {
        $drivers = Driver::with('operator')
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data drivers berhasil diambil',
            'data' => $drivers
        ]);
    }

    /**
     * POST: /api/drivers
     * Simpan driver baru
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'operator_id' => 'required|exists:operators,id',
            'driver_name' => 'required|string|max:150',
            'license_number' => 'required|string|max:100|unique:drivers,license_number',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'status' => 'nullable|in:active,inactive,on_duty',
        ]);

        $driver = Driver::create([
            'operator_id' => $request->operator_id,
            'driver_name' => $request->driver_name,
            'license_number' => $request->license_number,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => $request->status ?? 'active',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Driver berhasil ditambahkan',
            'data' => $driver
        ]);
    }

    /**
     * GET: /api/drivers/{id}
     * Detail driver
     */
    public function show($id): JsonResponse
    {
        $driver = Driver::with('operator')->find($id);

        if (!$driver) {
            return response()->json([
                'status' => false,
                'message' => 'Driver tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail driver',
            'data' => $driver
        ]);
    }

    /**
     * PUT/PATCH: /api/drivers/{id}
     * Update driver
     */
    public function update(Request $request, $id): JsonResponse
    {
        $driver = Driver::find($id);

        if (!$driver) {
            return response()->json([
                'status' => false,
                'message' => 'Driver tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'operator_id' => 'sometimes|exists:operators,id',
            'driver_name' => 'sometimes|string|max:150',
            'license_number' => 'sometimes|string|max:100|unique:drivers,license_number,' . $id,
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'status' => 'nullable|in:active,inactive,on_duty',
        ]);

        $driver->update($request->only([
            'operator_id',
            'driver_name',
            'license_number',
            'phone',
            'address',
            'status',
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Driver berhasil diupdate',
            'data' => $driver
        ]);
    }

    /**
     * DELETE: /api/drivers/{id}
     * Hapus driver (soft delete)
     */
    public function destroy($id): JsonResponse
    {
        $driver = Driver::find($id);

        if (!$driver) {
            return response()->json([
                'status' => false,
                'message' => 'Driver tidak ditemukan'
            ], 404);
        }

        $driver->delete();

        return response()->json([
            'status' => true,
            'message' => 'Driver berhasil dihapus'
        ]);
    }
}