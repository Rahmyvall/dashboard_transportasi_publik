<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Route as RouteModel;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class TripController extends Controller
{
    public function index(Request $request): View
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
            ->paginate(10)
            ->withQueryString();

        $stats = $this->getTripStats();

        return view('admin.trips.index', [
            'trips' => $trips,
            'routes' => RouteModel::latest()->get(),
            'vehicles' => Vehicle::latest()->get(),
            'drivers' => Driver::latest()->get(),
            'stats' => $stats,
            'title' => 'Trip Monitoring System',
        ]);
    }

    public function active(): View
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

        return view('admin.trips.active', [
            'trips' => $trips,
            'title' => 'Active Trips',
        ]);
    }

    public function history(): View
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

        return view('admin.trips.history', [
            'trips' => $trips,
            'title' => 'Trip History',
        ]);
    }

    public function create(): View
    {
        return view('admin.trips.create', [
            'schedules' => Schedule::latest()->get(),
            'routes' => RouteModel::latest()->get(),
            'vehicles' => Vehicle::latest()->get(),
            'drivers' => Driver::latest()->get(),
            'tripCode' => $this->generateTripCode(false),
            'title' => 'Tambah Trip',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
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

        DB::transaction(function () use (&$data) {
            $data['trip_code'] = $this->generateTripCode(true);
            $data['status'] = $data['status'] ?? 'scheduled';
            $data['delay_minutes'] = $data['delay_minutes'] ?? 0;

            Trip::create($data);
        });

        return redirect()
            ->route('admin.trips.index')
            ->with('success', 'Trip berhasil dibuat.');
    }

    public function show(int $id): View
    {
        $trip = Trip::with([
                'schedule',
                'route',
                'vehicle',
                'driver',
            ])
            ->findOrFail($id);

        return view('admin.trips.show', [
            'trip' => $trip,
            'title' => 'Detail Trip',
        ]);
    }

    public function edit(int $id): View
    {
        $trip = Trip::with([
                'schedule',
                'route',
                'vehicle',
                'driver',
            ])
            ->findOrFail($id);

        return view('admin.trips.edit', [
            'trip' => $trip,
            'schedules' => Schedule::latest()->get(),
            'routes' => RouteModel::latest()->get(),
            'vehicles' => Vehicle::latest()->get(),
            'drivers' => Driver::latest()->get(),
            'title' => 'Edit Trip',
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $trip = Trip::findOrFail($id);

        $data = $request->validate([
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

        $data['status'] = $data['status'] ?? $trip->status;
        $data['delay_minutes'] = $data['delay_minutes'] ?? 0;

        $trip->update($data);

        return redirect()
            ->route('admin.trips.index')
            ->with('success', 'Trip berhasil diperbarui.');
    }

    public function start(int $id): RedirectResponse
    {
        $trip = Trip::with('vehicle')->findOrFail($id);

        if (in_array($trip->status, ['running', 'completed', 'cancelled'])) {
            return back()->with('error', 'Trip tidak dapat dijalankan.');
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

        return back()->with('success', 'Trip sedang berjalan.');
    }

    public function complete(int $id): RedirectResponse
    {
        $trip = Trip::with('vehicle')->findOrFail($id);

        if ($trip->status === 'cancelled') {
            return back()->with('error', 'Trip yang dibatalkan tidak dapat diselesaikan.');
        }

        if ($trip->status === 'completed') {
            return back()->with('error', 'Trip sudah selesai.');
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

        return back()->with('success', 'Trip berhasil diselesaikan.');
    }

    public function delayed(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'delay_minutes' => 'required|integer|min:1',
        ]);

        $trip = Trip::findOrFail($id);

        if (in_array($trip->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'Trip ini tidak dapat ditandai terlambat.');
        }

        $trip->update([
            'status' => 'delayed',
            'delay_minutes' => $request->delay_minutes,
        ]);

        return back()->with('success', 'Trip berhasil ditandai terlambat.');
    }

    public function cancel(int $id): RedirectResponse
    {
        $trip = Trip::with('vehicle')->findOrFail($id);

        if ($trip->status === 'completed') {
            return back()->with('error', 'Trip yang sudah selesai tidak dapat dibatalkan.');
        }

        if ($trip->status === 'cancelled') {
            return back()->with('error', 'Trip sudah dibatalkan.');
        }

        $trip->update([
            'status' => 'cancelled',
        ]);

        if ($trip->vehicle) {
            $trip->vehicle->update([
                'status' => 'available',
            ]);
        }

        return back()->with('success', 'Trip berhasil dibatalkan.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $trip = Trip::findOrFail($id);

        if (in_array($trip->status, ['running', 'completed'])) {
            return back()->with('error', 'Trip yang sudah berjalan atau selesai tidak dapat dihapus.');
        }

        $trip->delete();

        return redirect()
            ->route('admin.trips.index')
            ->with('success', 'Trip berhasil dihapus.');
    }

    private function generateTripCode(bool $useLock = true): string
    {
        $date = now()->format('Ymd');

        $query = Trip::whereDate('created_at', now()->toDateString())
            ->where('trip_code', 'like', 'TRP-' . $date . '-%')
            ->orderByDesc('id');

        if ($useLock) {
            $query->lockForUpdate();
        }

        $lastTrip = $query->first();

        $newNumber = 1;

        if ($lastTrip) {
            $lastNumber = (int) substr($lastTrip->trip_code, -4);
            $newNumber = $lastNumber + 1;
        }

        return 'TRP-' . $date . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    private function getTripStats(): array
    {
        return [
            'total' => Trip::count(),
            'scheduled' => Trip::where('status', 'scheduled')->count(),
            'running' => Trip::where('status', 'running')->count(),
            'completed' => Trip::where('status', 'completed')->count(),
            'delayed' => Trip::where('status', 'delayed')->count(),
            'cancelled' => Trip::where('status', 'cancelled')->count(),
        ];
    }
}
