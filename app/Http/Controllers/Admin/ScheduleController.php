<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Route;
use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['route', 'vehicle', 'driver'])
            ->latest()
            ->paginate(10);

        return view('admin.schedules.index', [
            'schedules' => $schedules,
            'title' => 'Data Schedule'
        ]);
    }

    public function create()
    {
        return view('admin.schedules.create', [
            // FIX ROUTE (route_name)
            'routes' => Route::select('id', 'route_name')
                ->orderBy('route_name')
                ->get(),

            // FIX VEHICLE (plate_number)
            'vehicles' => Vehicle::select('id', 'plate_number')
                ->orderBy('plate_number')
                ->get(),

            // FIX DRIVER (driver_name, bukan name)
            'drivers' => Driver::select('id', 'driver_name')
                ->orderBy('driver_name')
                ->get(),

            'title' => 'Tambah Schedule'
        ]);
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'route_id' => 'required|exists:routes,id',
        'vehicle_id' => 'nullable|exists:vehicles,id',
        'driver_id' => 'nullable|exists:drivers,id',
        'day_type' => 'required|in:weekday,weekend,holiday,all',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'headway_minutes' => 'nullable|integer|min:1',
    ]);

    // FIX CHECKBOX (WAJIB INI)
    $validated['is_active'] = $request->has('is_active') ? 1 : 0;

    // FIX OVERLAP LOGIC (AMAN)
    $exists = Schedule::where('route_id', $validated['route_id'])
        ->where('day_type', $validated['day_type'])
        ->where(function ($q) use ($validated) {
            $q->where('start_time', '<', $validated['end_time'])
              ->where('end_time', '>', $validated['start_time']);
        })
        ->exists();

    if ($exists) {
        return back()
            ->withInput()
            ->with('error', 'Jadwal bentrok dengan schedule lain.');
    }

    // FIX INSERT (PASTI MASUK DB)
    Schedule::create([
        'route_id' => $validated['route_id'],
        'vehicle_id' => $validated['vehicle_id'],
        'driver_id' => $validated['driver_id'],
        'day_type' => $validated['day_type'],
        'start_time' => $validated['start_time'],
        'end_time' => $validated['end_time'],
        'headway_minutes' => $validated['headway_minutes'] ?? 0,
        'is_active' => $validated['is_active'],
    ]);

    return redirect()->route('admin.schedules.index')
        ->with('success', 'Schedule berhasil dibuat');
}

   public function edit($id)
{
    $schedule = Schedule::with(['route', 'vehicle', 'driver'])
        ->findOrFail($id);

    return view('admin.schedules.edit', [
        'schedule' => $schedule,

        // ROUTE FIX
        'routes' => Route::select('id', 'route_name')
            ->orderBy('route_name')
            ->get(),

        // VEHICLE FIX
        'vehicles' => Vehicle::select('id', 'plate_number')
            ->orderBy('plate_number')
            ->get(),

        // DRIVER FIX
        'drivers' => Driver::select('id', 'driver_name')
            ->orderBy('driver_name')
            ->get(),

        'title' => 'Edit Schedule'
    ]);
}

   public function update(Request $request, $id)
{
    $request->validate([
        'route_id' => 'required',
        'vehicle_id' => 'nullable',
        'driver_id' => 'nullable',
        'day_type' => 'required',
        'start_time' => 'required',
        'end_time' => 'required',
        'headway_minutes' => 'nullable|integer',
        'is_active' => 'nullable',
    ]);

    $schedule = Schedule::findOrFail($id);

    $schedule->update([
        'route_id' => $request->route_id,
        'vehicle_id' => $request->vehicle_id,
        'driver_id' => $request->driver_id,
        'day_type' => $request->day_type,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'headway_minutes' => $request->headway_minutes,
        'is_active' => $request->has('is_active') ? 1 : 0,
    ]);

    return redirect()->route('admin.schedules.index')
        ->with('success', 'Schedule berhasil diupdate');
}

    public function destroy($id)
    {
        Schedule::findOrFail($id)->delete();

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule berhasil dihapus');
    }
}