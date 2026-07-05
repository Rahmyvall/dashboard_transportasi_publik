<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DriverController extends Controller
{
    /**
     * GENERATE AUTO SIM
     */
    private function generateLicenseNumber()
    {
        $last = Driver::orderBy('id', 'desc')->first();

        $next = 1;

        if ($last && $last->license_number) {
            $num = (int) str_replace('SIM-', '', $last->license_number);
            $next = $num + 1;
        }

        return 'SIM-' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    /**
     * GET ALL DRIVERS
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
     * CREATE DRIVER (AUTO SIM)
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'operator_id' => 'required|exists:operators,id',
            'driver_name' => 'required|string|max:150',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'status' => 'nullable|in:active,inactive,on_duty',
        ]);

        // AUTO GENERATE SIM
        $validated['license_number'] = $this->generateLicenseNumber();
        $validated['status'] = $validated['status'] ?? 'active';

        $driver = Driver::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Driver berhasil ditambahkan',
            'data' => $driver
        ]);
    }

    /**
     * DETAIL DRIVER
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
     * UPDATE DRIVER (SIM TIDAK BOLEH DIUBAH)
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

        $validated = $request->validate([
            'operator_id' => 'sometimes|exists:operators,id',
            'driver_name' => 'sometimes|string|max:150',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'status' => 'nullable|in:active,inactive,on_duty',
        ]);

        // SIM TIDAK DIUBAH
        $driver->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Driver berhasil diupdate',
            'data' => $driver
        ]);
    }

    /**
     * DELETE DRIVER
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