<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RouteStop;
use App\Models\Route;
use App\Models\Stop;
use Illuminate\Http\Request;

class RouteStopController extends Controller
{
    public function index()
    {
        $routeStops = RouteStop::with(['route', 'stop'])
            ->orderBy('route_id')
            ->orderBy('stop_order')
            ->paginate(10);

        return view('admin.route-stops.index', [
            'routeStops' => $routeStops,
            'title' => 'Data Route Stops'
        ]);
    }

    public function create()
    {
        $routes = Route::orderBy('id')->get();
        $stops = Stop::orderBy('stop_name')->get();

        return view('admin.route-stops.create', [
            'routes' => $routes,
            'stops' => $stops,
            'title' => 'Tambah Route Stop'
        ]);
    }

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
            return back()
                ->withInput()
                ->with('error', 'Stop atau urutan sudah digunakan pada rute ini.');
        }

        $distance = $request->distance_from_start_km ?? 0;

        RouteStop::create([
            'route_id' => $request->route_id,
            'stop_id' => $request->stop_id,
            'stop_order' => $request->stop_order,
            'distance_from_start_km' => $distance,
            'estimated_arrival_minutes' => $this->calculateEta($distance),
        ]);

        return redirect()->route('admin.route-stops.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $routeStop = RouteStop::findOrFail($id);

        $routes = Route::orderBy('id')->get();
        $stops  = Stop::orderBy('stop_name')->get();

        return view('admin.route-stops.edit', [
            'routeStop' => $routeStop,
            'routes' => $routes,
            'stops' => $stops,
            'title' => 'Edit Route Stop'
        ]);
    }

    public function update(Request $request, $id)
    {
        $routeStop = RouteStop::findOrFail($id);

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
            return back()
                ->withInput()
                ->with('error', 'Stop atau urutan sudah digunakan pada rute ini.');
        }

        $distance = $request->distance_from_start_km ?? 0;

        $routeStop->update([
            'route_id' => $request->route_id,
            'stop_id' => $request->stop_id,
            'stop_order' => $request->stop_order,
            'distance_from_start_km' => $distance,
            'estimated_arrival_minutes' => $this->calculateEta($distance),
        ]);

        return redirect()->route('admin.route-stops.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        RouteStop::findOrFail($id)->delete();

        return redirect()->route('admin.route-stops.index')
            ->with('success', 'Data berhasil dihapus');
    }

    /**
     * AUTO ETA CALCULATION
     * asumsi speed bus 40 km/jam
     */
    private function calculateEta($distanceKm)
    {
        if ($distanceKm <= 0) {
            return 0;
        }

        $speed = 40; // km/jam
        return (int) round(($distanceKm / $speed) * 60);
    }
}