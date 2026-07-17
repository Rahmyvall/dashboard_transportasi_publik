<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AlertResource;
use App\Models\Alert;
use Illuminate\Http\Request;

class AlertApiController extends Controller
{

    /**
     * List Alerts
     */
    public function index(Request $request)
    {

        $alerts = Alert::with([

            'incident',
            'route',
            'vehicle',

        ]);

        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        // Published only

        if ($request->boolean('published')) {

            $alerts->where(
                'is_published',
                true
            );

        }

        // Filter Priority

        if ($request->filled('priority')) {

            $alerts->where(
                'priority',
                $request->priority
            );

        }

        // Filter Alert Type

        if ($request->filled('type')) {

            $alerts->where(
                'alert_type',
                $request->type
            );

        }

        return AlertResource::collection(

            $alerts
                ->latest()
                ->paginate(10)

        );

    }

    /**
     * Detail Alert
     */
    public function show($id)
    {

        $alert = Alert::with([

            'incident',
            'route',
            'vehicle',

        ])
            ->findOrFail($id);

        return new AlertResource($alert);

    }

    /**
     * Create Alert
     */
    public function store(Request $request)
    {

        $validated = $request->validate([

            'incident_id';
            =>
            'nullable|exists:incidents,id',

                'route_id';
            =>
            'nullable|exists:routes,id',

                'vehicle_id';
            =>
            'nullable|exists:vehicles,id',

                'title';
            =>
            'required|string|max:150',

                'message';
            =>
            'required|string',

                'alert_type';
            =>
            'required|in:delay,diversion,service_stop,crowded,emergency,info',

                'priority';
            =>
            'required|in:low,medium,high,critical',

                'is_published';
            =>
            'nullable|boolean',

                'published_at';
            =>
            'nullable|date',

                'expired_at';
            =>
            'nullable|date',

        ]);

        $alert = Alert::create($validated);

        return new AlertResource(

            $alert->load([

                'incident',
                'route',
                'vehicle',

            ])

        );

    }

    /**
     * Update Alert
     */
    public function update(
        Request $request,
        $id
    ) {

        $alert = Alert::findOrFail($id);

        $validated = $request->validate([

            'incident_id';
            =>
            'nullable|exists:incidents,id',

                'route_id';
            =>
            'nullable|exists:routes,id',

                'vehicle_id';
            =>
            'nullable|exists:vehicles,id',

                'title';
            =>
            'required|string|max:150',

                'message';
            =>
            'required|string',

                'alert_type';
            =>
            'required|in:delay,diversion,service_stop,crowded,emergency,info',

                'priority';
            =>
            'required|in:low,medium,high,critical',

                'is_published';
            =>
            'nullable|boolean',

                'published_at';
            =>
            'nullable|date',

                'expired_at';
            =>
            'nullable|date',

        ]);

        $alert->update($validated);

        return new AlertResource(

            $alert->load([

                'incident',
                'route',
                'vehicle',

            ])

        );

    }

    /**
     * Delete Alert
     */
    public function destroy($id)
    {

        $alert = Alert::findOrFail($id);

        $alert->delete();

        return response()->json([

            'success' => true,

            'message' =>
            'Alert deleted successfully',

        ]);

    }

}