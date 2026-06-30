<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TransportRoute;
use App\Models\Operator;
use Illuminate\Http\Request;

class RouteApiController extends Controller
{
    public function index()
    {
        $data = TransportRoute::with(['operator', 'transportMode'])
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'List routes',
            'data' => $data
        ]);
    }

    public function show($id)
    {
        $route = TransportRoute::with(['operator', 'transportMode'])
            ->find($id);

        if (!$route) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $route
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'operator_id' => 'required|exists:operators,id',
            'transport_mode_id' => 'required|exists:transport_modes,id',
            'route_name' => 'required',
            'origin' => 'required',
            'destination' => 'required',
            'distance_km' => 'nullable|numeric',
            'status' => 'required|in:active,inactive,maintenance',
        ]);

        $distance = $request->distance_km ?? 0;

        $route = TransportRoute::create([
            'operator_id' => $request->operator_id,
            'transport_mode_id' => $request->transport_mode_id,
            'route_code' => $this->generateRouteCode($request->operator_id),
            'route_name' => $request->route_name,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'distance_km' => $distance,
            'estimated_duration_minutes' => $this->calculateDuration($distance),
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Route created',
            'data' => $route
        ]);
    }

    public function update(Request $request, $id)
    {
        $route = TransportRoute::find($id);

        if (!$route) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $request->validate([
            'operator_id' => 'required|exists:operators,id',
            'transport_mode_id' => 'required|exists:transport_modes,id',
            'route_name' => 'required',
            'origin' => 'required',
            'destination' => 'required',
            'distance_km' => 'nullable|numeric',
            'status' => 'required|in:active,inactive,maintenance',
        ]);

        $distance = $request->distance_km ?? 0;

        $route->update([
            'operator_id' => $request->operator_id,
            'transport_mode_id' => $request->transport_mode_id,
            'route_name' => $request->route_name,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'distance_km' => $distance,
            'estimated_duration_minutes' => $this->calculateDuration($distance),
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Route updated',
            'data' => $route
        ]);
    }

    public function destroy($id)
    {
        $route = TransportRoute::find($id);

        if (!$route) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $route->delete();

        return response()->json([
            'status' => true,
            'message' => 'Route deleted'
        ]);
    }

    /* =========================
        AUTO ROUTE CODE
    ========================= */
    private function generateRouteCode($operatorId)
    {
        $operator = Operator::find($operatorId);

        $prefix = strtoupper(substr($operator->operator_name, 0, 2));

        $last = TransportRoute::where('route_code', 'like', $prefix.'-%')
            ->orderByDesc('id')
            ->first();

        if (!$last) {
            return $prefix.'-0001';
        }

        $number = (int) substr($last->route_code, -4);
        $number++;

        return $prefix.'-'.str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    /* =========================
        AUTO DURATION
    ========================= */
    private function calculateDuration($distance)
    {
        if ($distance <= 0) {
            return 0;
        }

        $speed = 40;
        return (int) round(($distance / $speed) * 60);
    }
}