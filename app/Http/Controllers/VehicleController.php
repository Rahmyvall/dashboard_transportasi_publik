<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Operator;
use App\Models\TransportMode;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VehicleController extends Controller
{
    /*
    |-----------------------------------------
    | INDEX (MONITORING SYSTEM)
    |-----------------------------------------
    */
    public function index(Request $request)
    {
        $vehicles = Vehicle::with(['operator', 'transportMode'])
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where('vehicle_code', 'like', "%{$request->search}%")
                          ->orWhere('plate_number', 'like', "%{$request->search}%");
                });
            })
            ->when($request->status, function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->operator_id, function ($q) use ($request) {
                $q->where('operator_id', $request->operator_id);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total' => Vehicle::count(),
            'available' => Vehicle::where('status', 'available')->count(),
            'on_trip' => Vehicle::where('status', 'on_trip')->count(),
            'maintenance' => Vehicle::where('status', 'maintenance')->count(),
        ];

        return view('admin.vehicles.index', [
            'vehicles' => $vehicles,
            'operators' => Operator::select('id','operator_name')->get(),
            'stats' => $stats,
            'title' => 'Vehicle Monitoring System'
        ]);
    }

    /*
    |-----------------------------------------
    | CREATE
    |-----------------------------------------
    */
    public function create()
    {
        return view('admin.vehicles.create', [
            'operators' => Operator::all(),
            'modes' => TransportMode::all(),
            'title' => 'Tambah Vehicle',
            'autoCode' => $this->generateVehicleCode()
        ]);
    }

    /*
    |-----------------------------------------
    | STORE (AUTO VEHICLE CODE SYSTEM)
    |-----------------------------------------
    */
    public function store(Request $request)
    {
        $data = $request->validate([
            'operator_id' => 'required|exists:operators,id',
            'transport_mode_id' => 'required|exists:transport_modes,id',
            'plate_number' => 'nullable|string|max:50|unique:vehicles,plate_number',
            'capacity' => 'required|integer|min:0',
            'manufacture_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'status' => 'required|in:available,on_trip,maintenance,inactive',
            'last_service_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        // AUTO VEHICLE CODE
        $data['vehicle_code'] = $this->generateVehicleCode();

        // AUTO SERVICE DATE DEFAULT
        if (empty($data['last_service_date'])) {
            $data['last_service_date'] = Carbon::now();
        }

        Vehicle::create($data);

        return redirect()
            ->route('admin.vehicles.index')
            ->with('success', 'Vehicle berhasil ditambahkan');
    }

    /*
    |-----------------------------------------
    | SHOW
    |-----------------------------------------
    */
    public function show($id)
    {
        $vehicle = Vehicle::with(['operator', 'transportMode'])
            ->findOrFail($id);

        return view('admin.vehicles.show', [
            'vehicle' => $vehicle,
            'title' => 'Detail Vehicle'
        ]);
    }

    /*
    |-----------------------------------------
    | EDIT
    |-----------------------------------------
    */
    public function edit($id)
    {
        return view('admin.vehicles.edit', [
            'vehicle' => Vehicle::findOrFail($id),
            'operators' => Operator::all(),
            'modes' => TransportMode::all(),
            'title' => 'Edit Vehicle'
        ]);
    }

    /*
    |-----------------------------------------
    | UPDATE (AUTO MAINTENANCE LOGIC)
    |-----------------------------------------
    */
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $data = $request->validate([
            'operator_id' => 'required|exists:operators,id',
            'transport_mode_id' => 'required|exists:transport_modes,id',
            'plate_number' => 'nullable|string|max:50|unique:vehicles,plate_number,' . $id,
            'capacity' => 'required|integer|min:0',
            'manufacture_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'status' => 'required|in:available,on_trip,maintenance,inactive',
            'last_service_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        // AUTO UPDATE SERVICE WHEN MAINTENANCE
        if ($data['status'] === 'maintenance') {
            $data['last_service_date'] = Carbon::now();
        }

        $vehicle->update($data);

        return redirect()
            ->route('admin.vehicles.index')
            ->with('success', 'Vehicle berhasil diupdate');
    }

    /*
    |-----------------------------------------
    | DELETE
    |-----------------------------------------
    */
    public function destroy($id)
    {
        Vehicle::findOrFail($id)->delete();

        return redirect()
            ->route('admin.vehicles.index')
            ->with('success', 'Vehicle berhasil dihapus');
    }

    /*
    |-----------------------------------------
    | AUTO GENERATE VEHICLE CODE
    |-----------------------------------------
    */
    private function generateVehicleCode()
    {
        $last = Vehicle::orderBy('id', 'desc')->first();

        $number = $last ? $last->id + 1 : 1;

        return 'VEH-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}