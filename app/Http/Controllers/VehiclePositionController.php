<?php

namespace App\Http\Controllers;

use App\Models\VehiclePosition;
use App\Models\Vehicle;
use App\Models\Trip;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VehiclePositionController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {

        $positions = VehiclePosition::with([
            'vehicle',
            'trip'
        ])

            ->when($request->vehicle_id, function ($query) use ($request) {

                $query->where(
                    'vehicle_id',
                    $request->vehicle_id
                );
            })


            ->when($request->trip_id, function ($query) use ($request) {

                $query->where(
                    'trip_id',
                    $request->trip_id
                );
            })


            ->when($request->date, function ($query) use ($request) {

                $query->whereDate(
                    'recorded_at',
                    $request->date
                );
            })


            ->orderBy(
                'recorded_at',
                'desc'
            )


            ->paginate(20)


            ->withQueryString();



        return view(
            'admin.vehicle_positions.index',
            [

                'positions' => $positions,

                'vehicles' => Vehicle::orderBy(
                    'vehicle_code'
                )->get(),


                'trips' => Trip::orderBy(
                    'trip_code'
                )->get(),


                'title' => 'Vehicle Tracking History'

            ]
        );
    }





    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {

        return view(
            'admin.vehicle_positions.create',
            [

                'vehicles' => Vehicle::all(),

                'trips' => Trip::all(),

                'title' => 'Tambah Vehicle Position'

            ]
        );
    }





    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {

        $data = $request->validate([


            'vehicle_id' => [
                'required',
                'exists:vehicles,id'
            ],


            'trip_id' => [
                'nullable',
                'exists:trips,id'
            ],


            'latitude' => [
                'required',
                'numeric',
                'between:-90,90'
            ],


            'longitude' => [
                'required',
                'numeric',
                'between:-180,180'
            ],


            'speed_kmh' => [
                'nullable',
                'numeric',
                'min:0'
            ],


            'heading_degree' => [
                'nullable',
                'integer',
                'between:0,360'
            ],


            'recorded_at' => [
                'nullable',
                'date'
            ]

        ]);



        $data['speed_kmh'] =
            $data['speed_kmh'] ?? 0;



        $data['recorded_at'] =
            $data['recorded_at'] ?? Carbon::now();



        VehiclePosition::create($data);



        return redirect()
            ->route(
                'admin.vehicle-positions.index'
            )
            ->with(
                'success',
                'Vehicle position berhasil ditambahkan'
            );
    }





    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {

        $position = VehiclePosition::with([
            'vehicle',
            'trip'
        ])

            ->findOrFail($id);



        return view(
            'admin.vehicle_positions.show',
            [

                'position' => $position,

                'title' => 'Detail Vehicle Position'

            ]
        );
    }





    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {

        return view(
            'admin.vehicle_positions.edit',
            [

                'position' => VehiclePosition::findOrFail($id),

                'vehicles' => Vehicle::all(),

                'trips' => Trip::all(),

                'title' => 'Edit Vehicle Position'

            ]
        );
    }





    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {

        $position = VehiclePosition::findOrFail($id);



        $data = $request->validate([


            'vehicle_id' => [
                'required',
                'exists:vehicles,id'
            ],


            'trip_id' => [
                'nullable',
                'exists:trips,id'
            ],


            'latitude' => [
                'required',
                'numeric',
                'between:-90,90'
            ],


            'longitude' => [
                'required',
                'numeric',
                'between:-180,180'
            ],


            'speed_kmh' => [
                'nullable',
                'numeric',
                'min:0'
            ],


            'heading_degree' => [
                'nullable',
                'integer',
                'between:0,360'
            ],


            'recorded_at' => [
                'required',
                'date'
            ]


        ]);



        $position->update($data);



        return redirect()
            ->route(
                'admin.vehicle-positions.index'
            )
            ->with(
                'success',
                'Vehicle position berhasil diperbarui'
            );
    }





    /*
    |--------------------------------------------------------------------------
    | TRACKING
    |--------------------------------------------------------------------------
    */
    public function tracking($vehicle_id)
    {

        $vehicle = Vehicle::findOrFail(
            $vehicle_id
        );



        $positions = VehiclePosition::with([
            'trip'
        ])

            ->where(
                'vehicle_id',
                $vehicle_id
            )

            ->orderBy(
                'recorded_at',
                'asc'
            )

            ->get();



        return view(
            'admin.vehicle_positions.tracking',
            [

                'vehicle' => $vehicle,

                'positions' => $positions,

                'title' => 'Tracking ' . $vehicle->vehicle_code

            ]
        );
    }





    /*
    |--------------------------------------------------------------------------
    | LAST POSITION
    |--------------------------------------------------------------------------
    */
    public function latest($vehicle_id)
    {

        $position = VehiclePosition::with([
            'vehicle',
            'trip'
        ])

            ->where(
                'vehicle_id',
                $vehicle_id
            )

            ->latest(
                'recorded_at'
            )

            ->first();



        return view(
            'admin.vehicle_positions.show',
            [

                'position' => $position,

                'title' => 'Last Vehicle Position'

            ]
        );
    }





    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {

        VehiclePosition::findOrFail($id)
            ->delete();



        return redirect()
            ->route(
                'admin.vehicle-positions.index'
            )
            ->with(
                'success',
                'Vehicle position berhasil dihapus'
            );
    }
}
