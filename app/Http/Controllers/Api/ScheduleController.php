<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    // GET ALL
    public function index()
    {
        $data = Schedule::with(['route', 'vehicle', 'driver'])->get();

        return response()->json([
            'success' => true,
            'message' => 'List schedules',
            'data' => $data
        ]);
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'route_id' => 'required|exists:routes,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'driver_id' => 'nullable|exists:drivers,id',
            'day_type' => 'required|in:weekday,weekend,holiday,all',
            'start_time' => 'required',
            'end_time' => 'required',
            'headway_minutes' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $schedule = Schedule::create([
            'route_id' => $request->route_id,
            'vehicle_id' => $request->vehicle_id,
            'driver_id' => $request->driver_id,
            'day_type' => $request->day_type,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'headway_minutes' => $request->headway_minutes,
            'is_active' => $request->is_active ?? 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Schedule created',
            'data' => $schedule
        ]);
    }

    // SHOW DETAIL
    public function show($id)
    {
        $schedule = Schedule::with(['route', 'vehicle', 'driver'])->find($id);

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Schedule not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $schedule
        ]);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Schedule not found'
            ], 404);
        }

        $request->validate([
            'route_id' => 'required|exists:routes,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'driver_id' => 'nullable|exists:drivers,id',
            'day_type' => 'required|in:weekday,weekend,holiday,all',
            'start_time' => 'required',
            'end_time' => 'required',
            'headway_minutes' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $schedule->update([
            'route_id' => $request->route_id,
            'vehicle_id' => $request->vehicle_id,
            'driver_id' => $request->driver_id,
            'day_type' => $request->day_type,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'headway_minutes' => $request->headway_minutes,
            'is_active' => $request->is_active ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Schedule updated',
            'data' => $schedule
        ]);
    }

    // DELETE
    public function destroy($id)
    {
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Schedule not found'
            ], 404);
        }

        $schedule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Schedule deleted'
        ]);
    }
}