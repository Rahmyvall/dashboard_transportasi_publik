<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncidentController extends Controller
{

    public function index(Request $request)
    {

        $incidents = Incident::with([

            'trip',

            'vehicle',

            'route',

            'reporter',

        ])

            ->when(
                $request->status,
                fn($q) => $q->where(
                    'status',
                    $request->status
                )
            )

            ->when(
                $request->severity,
                fn($q) => $q->where(
                    'severity',
                    $request->severity
                )
            )

            ->latest('reported_at')

            ->paginate(20);

        return response()->json([

            'success' => true,

            'data'    => $incidents,

        ]);
    }

    public function store(Request $request)
    {

        $data = $request->validate([

            'trip_id'            => 'nullable|exists:trips,id',

            'vehicle_id'         => 'nullable|exists:vehicles,id',

            'route_id'           => 'nullable|exists:routes,id',

            'reported_by'        => 'nullable|exists:users,id',

            'incident_type'      =>
            'required|in:accident,breakdown,traffic,weather,security,other',

            'title'              => 'required|max:150',

            'description'        => 'nullable',

            'severity'           =>
            'required|in:low,medium,high,critical',

            'location_latitude'  => 'nullable|numeric',

            'location_longitude' => 'nullable|numeric',

            'reported_at'        => 'required|date',

        ]);

        $data['status'] = 'open';

        $data['reported_by']
            =
            $data['reported_by'] ??
            Auth::id();

        $incident =
            Incident::create($data);

        return response()->json([

            'success' => true,

            'message' => 'Incident created',

            'data'    => $incident,

        ], 201);
    }

    public function show(
        Incident $incident
    ) {

        $incident->load([

            'trip',

            'vehicle',

            'route',

            'reporter',

        ]);

        return response()->json([

            'success' => true,

            'data'    => $incident,

        ]);
    }

    public function update(
        Request $request,
        Incident $incident
    ) {

        $data = $request->validate([

            'trip_id'            => 'nullable',

            'vehicle_id'         => 'nullable',

            'route_id'           => 'nullable',

            'incident_type'      => 'required',

            'title'              => 'required|max:150',

            'description'        => 'nullable',

            'severity'           => 'required',

            'status'             => 'required',

            'location_latitude'  => 'nullable',

            'location_longitude' => 'nullable',

            'reported_at'        => 'nullable|date',

        ]);

        if (
            in_array(
                $data['status'],
                [
                    'resolved',
                    'closed',
                ]
            )
        ) {

            $data['resolved_at'] = now();
        }

        $incident->update($data);

        return response()->json([

            'success' => true,

            'message' => 'Incident updated',

            'data'    => $incident,

        ]);
    }

    public function destroy(
        Incident $incident
    ) {

        $incident->delete();

        return response()->json([

            'success' => true,

            'message' => 'Incident deleted',

        ]);
    }

    public function statistics()
    {

        return response()->json([

            'success' => true,

            'data'    => [

                'total'       =>
                Incident::count(),

                'open'        =>
                Incident::where(
                    'status',
                    'open'
                )->count(),

                'in_progress' =>
                Incident::where(
                    'status',
                    'in_progress'
                )->count(),

                'resolved'    =>
                Incident::where(
                    'status',
                    'resolved'
                )->count(),

                'critical'    =>
                Incident::where(
                    'severity',
                    'critical'
                )->count(),

            ],

        ]);
    }

    public function open()
    {

        return response()->json([

            'data' =>
            Incident::where(
                'status',
                'open'
            )
                ->latest()
                ->get(),

        ]);
    }

    public function critical()
    {

        return response()->json([

            'data' =>
            Incident::where(
                'severity',
                'critical'
            )
                ->latest()
                ->get(),

        ]);
    }
}
