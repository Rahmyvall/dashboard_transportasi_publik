<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VehicleApiController extends Controller
{
    /*
    |-----------------------------------------
    | GET ALL VEHICLES
    |-----------------------------------------
    */
    public function index(Request $request)
    {
        $data = Vehicle::with(['operator', 'transportMode'])
            ->when($request->status, fn($q) =>
                $q->where('status', $request->status)
            )
            ->when($request->search, function ($q) use ($request) {
                $q->where('vehicle_code', 'like', "%{$request->search}%")
                  ->orWhere('plate_number', 'like', "%{$request->search}%");
            })
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'List Vehicles',
            'data' => $data
        ]);
    }

    /*
    |-----------------------------------------
    | GET DETAIL VEHICLE
    |-----------------------------------------
    */
    public function show($id)
    {
        $vehicle = Vehicle::with(['operator', 'transportMode'])
            ->find($id);

        if (!$vehicle) {
            return response()->json([
                'status' => false,
                'message' => 'Vehicle not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $vehicle
        ]);
    }

    /*
    |-----------------------------------------
    | CREATE VEHICLE (AUTO SYSTEM CODE)
    |-----------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'operator_id' => 'required|exists:operators,id',
            'transport_mode_id' => 'required|exists:transport_modes,id',
            'plate_number' => 'nullable|string|max:50|unique:vehicles',
            'capacity' => 'required|integer|min:0',
            'manufacture_year' => 'nullable|integer',
            'status' => 'required|in:available,on_trip,maintenance,inactive',
            'notes' => 'nullable|string',
        ]);

        $vehicle = Vehicle::create([
            'operator_id' => $request->operator_id,
            'transport_mode_id' => $request->transport_mode_id,
            'vehicle_code' => $this->generateCode(),
            'plate_number' => $request->plate_number,
            'capacity' => $request->capacity,
            'manufacture_year' => $request->manufacture_year,
            'status' => $request->status,
            'last_service_date' => Carbon::now(),
            'notes' => $request->notes,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Vehicle created',
            'data' => $vehicle
        ]);
    }

    /*
    |-----------------------------------------
    | UPDATE VEHICLE
    |-----------------------------------------
    */
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json([
                'status' => false,
                'message' => 'Vehicle not found'
            ], 404);
        }

        $request->validate([
            'operator_id' => 'required|exists:operators,id',
            'transport_mode_id' => 'required|exists:transport_modes,id',
            'plate_number' => 'nullable|string|max:50|unique:vehicles,plate_number,' . $id,
            'capacity' => 'required|integer|min:0',
            'manufacture_year' => 'nullable|integer',
            'status' => 'required|in:available,on_trip,maintenance,inactive',
            'notes' => 'nullable|string',
        ]);

        $vehicle->update([
            'operator_id' => $request->operator_id,
            'transport_mode_id' => $request->transport_mode_id,
            'plate_number' => $request->plate_number,
            'capacity' => $request->capacity,
            'manufacture_year' => $request->manufacture_year,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Vehicle updated',
            'data' => $vehicle
        ]);
    }

    /*
    |-----------------------------------------
    | DELETE VEHICLE
    |-----------------------------------------
    */
    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json([
                'status' => false,
                'message' => 'Vehicle not found'
            ], 404);
        }

        $vehicle->delete();

        return response()->json([
            'status' => true,
            'message' => 'Vehicle deleted'
        ]);
    }

    /*
    |-----------------------------------------
    | AUTO VEHICLE CODE GENERATOR
    |-----------------------------------------
    */
    private function generateCode()
    {
        $last = Vehicle::orderBy('id', 'desc')->first();

        $number = $last ? $last->id + 1 : 1;

        return 'VEH-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}