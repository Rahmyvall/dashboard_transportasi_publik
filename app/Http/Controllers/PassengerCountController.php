<?php

namespace App\Http\Controllers;

use App\Models\PassengerCount;
use App\Models\Trip;
use App\Models\Vehicle;
use App\Models\Stop;
use Illuminate\Http\Request;

class PassengerCountController extends Controller
{


    /**
     * Menampilkan data passenger count
     */
    public function index()
    {

        $passengerCounts = PassengerCount::with([

            'trip',

            'vehicle',

            'stop'

        ])

            ->latest('recorded_at')

            ->paginate(10);



        $title = "Monitoring Penumpang";



        return view(
            'admin.passenger-counts.index',
            compact(
                'passengerCounts',
                'title'
            )
        );
    }





    /**
     * Form tambah data
     */
    public function create()
    {


        $title = "Tambah Data Passenger Count";



        $trips = Trip::orderBy(
            'id',
            'desc'
        )->get();



        $vehicles = Vehicle::whereNull(
            'deleted_at'
        )

            ->orderBy(
                'plate_number'
            )

            ->get();




        $stops = Stop::where(
            'is_active',
            true
        )

            ->orderBy(
                'stop_name'
            )

            ->get();






        return view(

            'admin.passenger-counts.create',

            compact(

                'title',

                'trips',

                'vehicles',

                'stops'

            )

        );
    }








    /**
     * Simpan data
     */
    public function store(Request $request)
    {


        $validated = $request->validate([



            'trip_id' => [

                'required',

                'exists:trips,id'

            ],



            'vehicle_id' => [

                'required',

                'exists:vehicles,id'

            ],




            'stop_id' => [

                'nullable',

                'exists:stops,id'

            ],




            'boarding_count' => [

                'required',

                'integer',

                'min:0'

            ],




            'alighting_count' => [

                'required',

                'integer',

                'min:0'

            ],




            'current_load' => [

                'required',

                'integer',

                'min:0'

            ],




            'vehicle_capacity' => [

                'nullable',

                'integer',

                'min:0'

            ],




            'recorded_at' => [

                'required',

                'date'

            ],


        ]);





        PassengerCount::create($validated);





        return redirect()

            ->route(
                'admin.passenger-counts.index'
            )

            ->with(

                'success',

                'Data jumlah penumpang berhasil ditambahkan'

            );
    }









    /**
     * Detail data
     */
    public function show(
        PassengerCount $passengerCount
    ) {


        $title = "Detail Passenger Count";



        $passengerCount->load([

            'trip',

            'vehicle',

            'stop'

        ]);






        return view(

            'admin.passenger-counts.show',

            compact(

                'title',

                'passengerCount'

            )

        );
    }









    /**
     * Form edit
     */
    public function edit(
        PassengerCount $passengerCount
    ) {


        $title = "Edit Passenger Count";



        $trips = Trip::all();



        $vehicles = Vehicle::all();



        $stops = Stop::all();







        return view(

            'admin.passenger-counts.edit',

            compact(

                'title',

                'passengerCount',

                'trips',

                'vehicles',

                'stops'

            )

        );
    }









    /**
     * Update data
     */
    public function update(

        Request $request,

        PassengerCount $passengerCount

    ) {



        $validated = $request->validate([



            'trip_id' => 'required|exists:trips,id',



            'vehicle_id' => 'required|exists:vehicles,id',



            'stop_id' => 'nullable|exists:stops,id',



            'boarding_count' => 'required|integer|min:0',



            'alighting_count' => 'required|integer|min:0',



            'current_load' => 'required|integer|min:0',



            'vehicle_capacity' => 'nullable|integer|min:0',



            'recorded_at' => 'required|date',



        ]);





        $passengerCount->update(
            $validated
        );





        return redirect()

            ->route(
                'admin.passenger-counts.index'
            )

            ->with(

                'success',

                'Data berhasil diperbarui'

            );
    }









    /**
     * Hapus data
     */
    public function destroy(
        PassengerCount $passengerCount
    ) {



        $passengerCount->delete();






        return redirect()

            ->route(
                'admin.passenger-counts.index'
            )

            ->with(

                'success',

                'Data berhasil dihapus'

            );
    }
}
