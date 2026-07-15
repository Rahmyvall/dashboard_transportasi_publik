<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Route;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncidentController extends Controller
{

  /**
   * List Incident
   */
  public function index(Request $request)
  {

    $incidents = Incident::with([

      'trip',
      'vehicle',
      'route',
      'reporter'

    ])

      ->when(
        $request->status,
        function ($query) use ($request) {

          $query->where(
            'status',
            $request->status
          );
        }
      )


      ->when(
        $request->severity,
        function ($query) use ($request) {

          $query->where(
            'severity',
            $request->severity
          );
        }
      )


      ->when(
        $request->incident_type,
        function ($query) use ($request) {

          $query->where(
            'incident_type',
            $request->incident_type
          );
        }
      )


      ->latest('reported_at')

      ->paginate(10);





    /*
    |--------------------------------------------------------------------------
    | STATISTIC CARD
    |--------------------------------------------------------------------------
    */


    $totalIncident = Incident::count();


    $totalOpen = Incident::where(
      'status',
      'open'
    )->count();



    $totalProgress = Incident::where(
      'status',
      'in_progress'
    )->count();



    $totalCritical = Incident::where(
      'severity',
      'critical'
    )->count();







    $title = "Monitoring Incident";






    return view(
      'admin.incidents.index',
      compact(

        'incidents',

        'title',

        'totalIncident',

        'totalOpen',

        'totalProgress',

        'totalCritical'

      )
    );
  }
  /**
   * Form Create
   */
  public function create()
  {

    $title = "Tambah Incident";


    $trips = Trip::latest()
      ->get();


    $vehicles = Vehicle::whereNull('deleted_at')
      ->orderBy('plate_number')
      ->get();



    $routes = Route::orderBy('origin')
      ->get();



    $reporters = User::orderBy('name')
      ->get();



    return view(
      'admin.incidents.create',
      compact(
        'title',
        'trips',
        'vehicles',
        'routes',
        'reporters'
      )
    );
  }

  /**
   * Store
   */
  public function store(Request $request)
  {

    $validated = $request->validate([

      'trip_id'            =>
      'nullable|exists:trips,id',

      'vehicle_id'         =>
      'nullable|exists:vehicles,id',

      'route_id'           =>
      'nullable|exists:routes,id',

      'incident_type'      =>
      'required|in:accident,breakdown,traffic,weather,security,other',

      'title'              =>
      'required|string|max:150',

      'description'        =>
      'nullable|string',

      'severity'           =>
      'required|in:low,medium,high,critical',

      'status'             =>
      'nullable|in:open,in_progress,resolved,closed',

      'location_latitude'  =>
      'nullable|numeric',

      'location_longitude' =>
      'nullable|numeric',

      'reported_at'        =>
      'required|date',

      'resolved_at'        =>
      'nullable|date',

    ]);

    $validated['reported_by'] = Auth::id();

    if (empty($validated['status'])) {

      $validated['status'] = 'open';
    }

    if (
      in_array(
        $validated['status'],
        [
          'resolved',
          'closed',
        ]
      )
      &&
      empty($validated['resolved_at'])
    ) {

      $validated['resolved_at'] = now();
    }

    Incident::create(
      $validated
    );

    return redirect()
      ->route('admin.incidents.index')
      ->with(
        'success',
        'Incident berhasil ditambahkan'
      );
  }

  /**
   * Detail
   */
  public function show(
    Incident $incident
  ) {

    $title = "Detail Incident";

    $incident->load([

      'trip',
      'vehicle',
      'route',
      'reporter',

    ]);

    return view(
      'admin.incidents.show',
      compact(
        'title',
        'incident'
      )
    );
  }

  /**
   * Edit
   */
  public function edit(
    Incident $incident
  ) {

    $title = "Edit Incident";


    $trips = Trip::latest()
      ->get();



    $vehicles = Vehicle::whereNull(
      'deleted_at'
    )
      ->orderBy(
        'plate_number'
      )
      ->get();




    $routes = Route::orderBy(
      'origin'
    )
      ->get();




    $reporters = User::orderBy(
      'name'
    )
      ->get();





    return view(
      'admin.incidents.edit',
      compact(

        'title',

        'incident',

        'trips',

        'vehicles',

        'routes',

        'reporters'

      )
    );
  }

  /**
   * Update
   */
  public function update(
    Request $request,
    Incident $incident
  ) {


    $validated = $request->validate([


      'trip_id' => [
        'nullable',
        'exists:trips,id'
      ],


      'vehicle_id' => [
        'nullable',
        'exists:vehicles,id'
      ],


      'route_id' => [
        'nullable',
        'exists:routes,id'
      ],


      'reported_by' => [
        'nullable',
        'exists:users,id'
      ],


      'incident_type' => [
        'required',
        'in:accident,breakdown,traffic,weather,security,other'
      ],


      'title' => [
        'required',
        'string',
        'max:150'
      ],


      'description' => [
        'nullable',
        'string'
      ],


      'severity' => [
        'required',
        'in:low,medium,high,critical'
      ],


      'status' => [
        'required',
        'in:open,in_progress,resolved,closed'
      ],


      'location_latitude' => [
        'nullable',
        'numeric'
      ],


      'location_longitude' => [
        'nullable',
        'numeric'
      ],


      'reported_at' => [
        'nullable',
        'date'
      ],


    ]);





    if (
      in_array(
        $validated['status'],
        [
          'resolved',
          'closed'
        ]
      )
    ) {

      $validated['resolved_at'] = now();
    }





    $incident->update(
      $validated
    );





    return redirect()

      ->route(
        'admin.incidents.index'
      )

      ->with(
        'success',
        'Incident berhasil diperbarui'
      );
  }
  /**
   * Delete
   */
  public function destroy(
    Incident $incident
  ) {

    $incident->delete();

    return redirect()
      ->route('admin.incidents.index')
      ->with(
        'success',
        'Incident berhasil dihapus'
      );
  }

  /**
   * Statistik Dashboard
   */
  public function statistics()
  {

    return response()->json([

      'total'       => Incident::count(),

      'open'        => Incident::where(
        'status',
        'open'
      )->count(),

      'in_progress' => Incident::where(
        'status',
        'in_progress'
      )->count(),

      'resolved'    => Incident::where(
        'status',
        'resolved'
      )->count(),

      'closed'      => Incident::where(
        'status',
        'closed'
      )->count(),

      'critical'    => Incident::where(
        'severity',
        'critical'
      )->count(),

    ]);
  }

  /**
   * Update Status Cepat
   */
  public function updateStatus(
    Request $request,
    Incident $incident
  ) {

    $request->validate([

      'status' =>
      'required|in:open,in_progress,resolved,closed',

    ]);

    $incident->update([

      'status'      => $request->status,

      'resolved_at' => in_array(

        $request->status,

        [
          'resolved',
          'closed',
        ]

      )

        ? now()

        : null,

    ]);

    return back()
      ->with(
        'success',
        'Status incident berhasil diperbarui'
      );
  }
}
