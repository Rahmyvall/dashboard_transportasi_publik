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

class TripController extends Controller
{

    public function index(Request $request): View
    {

        $trips = Trip::with([
            'schedule',
            'route',
            'vehicle',
            'driver'
        ])

            ->when($request->filled('search'), function ($query) use ($request) {

                $query->where(
                    'trip_code',
                    'like',
                    '%' . $request->search . '%'
                );
            })

            ->when($request->filled('status'), function ($query) use ($request) {

                $query->where(
                    'status',
                    $request->status
                );
            })

            ->when($request->filled('route_id'), function ($query) use ($request) {

                $query->where(
                    'route_id',
                    $request->route_id
                );
            })

            ->when($request->filled('vehicle_id'), function ($query) use ($request) {

                $query->where(
                    'vehicle_id',
                    $request->vehicle_id
                );
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();



        $stats = [

            'total' => Trip::count(),

            'scheduled' => Trip::where(
                'status',
                'scheduled'
            )->count(),

            'running' => Trip::where(
                'status',
                'running'
            )->count(),

            'completed' => Trip::where(
                'status',
                'completed'
            )->count(),

            'delayed' => Trip::where(
                'status',
                'delayed'
            )->count(),

            'cancelled' => Trip::where(
                'status',
                'cancelled'
            )->count(),

        ];



        return view('admin.trips.index', [

            'trips' => $trips,

            'routes' => RouteModel::all(),

            'vehicles' => Vehicle::all(),

            'stats' => $stats,

            'title' => 'Trip Monitoring System'

        ]);
    }



    public function create(): View
    {

        return view('admin.trips.create', [

            'schedules' => Schedule::all(),

            'routes' => RouteModel::all(),

            'vehicles' => Vehicle::where(
                'status',
                'available'
            )->get(),

            'drivers' => Driver::where(
                'status',
                'active'
            )->get(),

            'tripCode' => $this->generateTripCode(),

            'title' => 'Tambah Trip'

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

            'planned_end_time' => 'nullable|date',

            'notes' => 'nullable|string'

        ]);



        $data['trip_code'] = $this->generateTripCode();

        $data['status'] = 'scheduled';

        $data['delay_minutes'] = 0;



        Trip::create($data);



        return redirect()
            ->route('admin.trips.index')
            ->with(
                'success',
                'Trip berhasil dibuat'
            );
    }



    public function show(int $id): View
    {

        $trip = Trip::with([

            'schedule',
            'route',
            'vehicle',
            'driver'

        ])
            ->findOrFail($id);



        return view(
            'admin.trips.show',
            compact('trip')
        );
    }



    public function edit(int $id): View
    {

        $trip = Trip::findOrFail($id);



        return view('admin.trips.edit', [

            'trip' => $trip,

            'schedules' => Schedule::all(),

            'routes' => RouteModel::all(),

            'vehicles' => Vehicle::all(),

            'drivers' => Driver::all()

        ]);
    }



    public function update(
        Request $request,
        int $id
    ): RedirectResponse {

        $trip = Trip::findOrFail($id);



        $data = $request->validate([

            'schedule_id' => 'nullable|exists:schedules,id',

            'route_id' => 'required|exists:routes,id',

            'vehicle_id' => 'required|exists:vehicles,id',

            'driver_id' => 'nullable|exists:drivers,id',

            'planned_start_time' => 'required|date',

            'planned_end_time' => 'nullable|date',

            'notes' => 'nullable|string'

        ]);



        $trip->update($data);



        return redirect()
            ->route('admin.trips.index')
            ->with(
                'success',
                'Trip berhasil diperbarui'
            );
    }



    public function start(int $id): RedirectResponse
    {

        $trip = Trip::with('vehicle')
            ->findOrFail($id);

        $trip->update([

            'status' => 'running',

            'actual_start_time' => now()

        ]);

        if ($trip->vehicle) {

            $trip->vehicle->update([

                'status' => 'on_trip'

            ]);
        }
        return back()
            ->with(
                'success',
                'Trip sedang berjalan'
            );
    }



    public function complete(int $id): RedirectResponse
    {

        $trip = Trip::with('vehicle')
            ->findOrFail($id);



        $trip->update([

            'status' => 'completed',

            'actual_end_time' => now()

        ]);



        if ($trip->vehicle) {

            $trip->vehicle->update([

                'status' => 'available'

            ]);
        }



        return back()
            ->with(
                'success',
                'Trip selesai'
            );
    }



    public function delayed(
        Request $request,
        int $id
    ): RedirectResponse {

        $request->validate([

            'delay_minutes' => 'required|integer|min:1'

        ]);



        $trip = Trip::findOrFail($id);



        $trip->update([

            'status' => 'delayed',

            'delay_minutes' => $request->delay_minutes

        ]);



        return back()
            ->with(
                'success',
                'Trip terlambat'
            );
    }



    public function destroy(int $id): RedirectResponse
    {

        $trip = Trip::findOrFail($id);



        if (in_array($trip->status, [

            'running',
            'completed'

        ])) {


            return back()
                ->with(
                    'error',
                    'Trip sudah berjalan tidak dapat dihapus'
                );
        }



        $trip->delete();



        return back()
            ->with(
                'success',
                'Trip berhasil dihapus'
            );
    }



    private function generateTripCode(): string
    {

        $last = Trip::latest('id')->first();



        $number = $last
            ? $last->id + 1
            : 1;



        return 'TRIP-' . str_pad(
            $number,
            5,
            '0',
            STR_PAD_LEFT
        );
    }
}
