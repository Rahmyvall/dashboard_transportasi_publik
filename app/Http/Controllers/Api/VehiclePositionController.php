<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VehiclePosition;
use Illuminate\Http\Request;
use Carbon\Carbon;


class VehiclePositionController extends Controller
{


    /**
     * Store GPS Position
     */
    public function store(Request $request)
    {


        $data = $request->validate([


            'vehicle_id'
            =>
            'required|exists:vehicles,id',


            'trip_id'
            =>
            'nullable|exists:trips,id',



            'latitude'
            =>
            'required|numeric|between:-90,90',



            'longitude'
            =>
            'required|numeric|between:-180,180',



            'speed_kmh'
            =>
            'nullable|numeric|min:0',



            'heading_degree'
            =>
            'nullable|integer|between:0,360',



            'recorded_at'
            =>
            'nullable|date'


        ]);





        /*
        |--------------------------------------------------------------------------
        | Decimal sesuai database decimal(10,7)
        |--------------------------------------------------------------------------
        */


        $data['latitude']
            =
            round(
                $data['latitude'],
                7
            );


        $data['longitude']
            =
            round(
                $data['longitude'],
                7
            );




        $data['speed_kmh']
            =
            $data['speed_kmh']
            ??
            0;



        $data['heading_degree']
            =
            $data['heading_degree']
            ??
            0;




        $data['recorded_at']
            =
            $data['recorded_at']
            ??
            Carbon::now();





        $position =
            VehiclePosition::create($data);





        return response()->json([


            'success' => true,


            'message' => 'GPS position berhasil disimpan',


            'data' => $position



        ], 201);
    }








    /**
     * Tracking History
     */
    public function index(Request $request)
    {


        $positions =
            VehiclePosition::with([

                'vehicle',

                'trip'

            ])

            ->when(
                $request->vehicle_id,
                function ($q) use ($request) {

                    $q->where(
                        'vehicle_id',
                        $request->vehicle_id
                    );
                }
            )


            ->latest('recorded_at')


            ->paginate(50);





        return response()->json([


            'success' => true,


            'data' => $positions



        ]);
    }









    /**
     * Last Position Vehicle
     */
    public function latest($vehicle_id)
    {


        $position =
            VehiclePosition::with([

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





        if (!$position) {


            return response()->json([

                'success' => false,

                'message' => 'Position tidak ditemukan'


            ], 404);
        }





        return response()->json([


            'success' => true,


            'data' => $position



        ]);
    }










    /**
     * Detail Position
     */
    public function show($id)
    {


        $position =
            VehiclePosition::with([

                'vehicle',

                'trip'

            ])

            ->find($id);




        if (!$position) {


            return response()->json([

                'success' => false,

                'message' => 'Data tidak ditemukan'


            ], 404);
        }




        return response()->json([


            'success' => true,


            'data' => $position



        ]);
    }
}
