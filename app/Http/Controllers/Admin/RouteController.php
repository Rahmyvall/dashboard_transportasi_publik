<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransportRoute;
use App\Models\Operator;
use App\Models\TransportMode;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = TransportRoute::with(['operator', 'transportMode'])
            ->latest()
            ->paginate(6);

        return view('admin.routes.index', [
            'routes' => $routes,
            'title' => 'Data Rute'
        ]);
    }

    public function create()
    {
        $operators = Operator::orderBy('operator_name')->get();
        $transportModes = TransportMode::orderBy('mode_name')->get();

        return view('admin.routes.create', [
            'operators' => $operators,
            'transportModes' => $transportModes,
            'title' => 'Tambah Rute'
        ]);
    }

    public function show($id)
    {
        $route = TransportRoute::with(['operator', 'transportMode'])
            ->findOrFail($id);

        return view('admin.routes.show', [
            'route' => $route,
            'title' => 'Detail Rute'
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

        TransportRoute::create([
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

        return redirect()->route('admin.routes.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $route = TransportRoute::findOrFail($id);

        $operators = Operator::orderBy('operator_name')->get();
        $transportModes = TransportMode::orderBy('mode_name')->get();

        return view('admin.routes.edit', [
            'route' => $route,
            'operators' => $operators,
            'transportModes' => $transportModes,
            'title' => 'Edit Rute'
        ]);
    }

    public function update(Request $request, $id)
    {
        $route = TransportRoute::findOrFail($id);

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

        return redirect()->route('admin.routes.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        TransportRoute::findOrFail($id)->delete();

        return redirect()->route('admin.routes.index')
            ->with('success', 'Data berhasil dihapus');
    }

    /* =========================
       AUTO ROUTE CODE
    ========================= */
    private function generateRouteCode($operatorId)
    {
        $operator = Operator::findOrFail($operatorId);

        $prefix = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $operator->operator_name), 0, 2));

        $last = TransportRoute::where('route_code', 'like', $prefix . '-%')
            ->orderByDesc('id')
            ->first();

        if (!$last) {
            return $prefix . '-0001';
        }

        $number = (int) substr($last->route_code, -4);
        $number++;

        return $prefix . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    /* =========================
       AUTO DURATION
    ========================= */
    private function calculateDuration($distanceKm)
    {
        if ($distanceKm <= 0) {
            return 0;
        }

        $speed = 40; // km/jam
        return (int) round(($distanceKm / $speed) * 60);
    }
}