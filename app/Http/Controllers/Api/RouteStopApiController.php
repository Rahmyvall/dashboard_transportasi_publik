<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RouteStop;
use Illuminate\Http\Request;

class RouteStopApiController extends Controller
{
    /* =========================
        LIST ALL
    ========================= */
    public function index()
    {
        $data = RouteStop::with(['route', 'stop'])
            ->orderBy('route_id')
            ->orderBy('stop_order')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'List route stops',
            'data' => $data
        ]);
    }

    /* =========================
        DETAIL
    ========================= */
    public function show($id)
    {
        $data = RouteStop::with(['route', 'stop'])->find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    /* =========================
        STORE
    ========================= */
    public function store(Request $request)
    {
        $request->validate([
            'route_id' => 'required|exists:routes,id',
            'stop_id' => 'required|exists:stops,id',
            'stop_order' => 'required|integer|min:1',
            'distance_from_start_km' => 'nullable|numeric|min:0',
        ]);

        $exists = RouteStop::where('route_id', $request->route_id)
            ->where(function ($q) use ($request) {
                $q->where('stop_id', $request->stop_id)
                  ->orWhere('stop_order', $request->stop_order);
            })
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'Stop atau urutan sudah digunakan'
            ], 422);
        }

        $distance = $request->distance_from_start_km ?? 0;

        $data = RouteStop::create([
            'route_id' => $request->route_id,
            'stop_id' => $request->stop_id,
            'stop_order' => $request->stop_order,
            'distance_from_start_km' => $distance,
            'estimated_arrival_minutes' => $this->calculateEta($distance),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dibuat',
            'data' => $data
        ], 201);
    }

    /* =========================
        UPDATE
    ========================= */
    public function update(Request $request, $id)
    {
        $data = RouteStop::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'route_id' => 'required|exists:routes,id',
            'stop_id' => 'required|exists:stops,id',
            'stop_order' => 'required|integer|min:1',
            'distance_from_start_km' => 'nullable|numeric|min:0',
        ]);

        $exists = RouteStop::where('route_id', $request->route_id)
            ->where('id', '!=', $id)
            ->where(function ($q) use ($request) {
                $q->where('stop_id', $request->stop_id)
                  ->orWhere('stop_order', $request->stop_order);
            })
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => 'Duplikasi stop atau urutan'
            ], 422);
        }

        $distance = $request->distance_from_start_km ?? 0;

        $data->update([
            'route_id' => $request->route_id,
            'stop_id' => $request->stop_id,
            'stop_order' => $request->stop_order,
            'distance_from_start_km' => $distance,
            'estimated_arrival_minutes' => $this->calculateEta($distance),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diupdate',
            'data' => $data
        ]);
    }

    /* =========================
        DELETE
    ========================= */
    public function destroy($id)
    {
        $data = RouteStop::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    /* =========================
        ETA CALCULATION
    ========================= */
    private function calculateEta($distanceKm)
    {
        if ($distanceKm <= 0) {
            return 0;
        }

        $speed = 40; // km/jam
        return (int) round(($distanceKm / $speed) * 60);
    }
}