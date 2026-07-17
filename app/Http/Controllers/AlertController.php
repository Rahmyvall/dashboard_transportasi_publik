<?php
namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Incident;
use App\Models\Route as TransportRoute;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class AlertController extends Controller
{

    /**
     * Display alert list
     */
    public function index()
    {

        $title = 'Manajemen Alert Transportasi';

        $alerts = Alert::with([
            'incident',
            'route',
            'vehicle',
        ])
            ->latest()
            ->paginate(15);

        return view(
            'admin.alerts.index',
            compact(
                'title',
                'alerts'
            )
        );
    }

    /**
     * Create Form
     */
    public function create()
    {
        $title = 'Tambah Alert Baru';

        $incidents = Incident::orderBy('id', 'desc')
            ->get();

        $routes = TransportRoute::orderBy('route_name', 'asc')
            ->get();

        $vehicles = Vehicle::orderBy('id', 'desc')
            ->get();

        return view(
            'admin.alerts.create',
            compact(
                'title',
                'incidents',
                'routes',
                'vehicles'
            )
        );
    }
    /**
     * Store Alert
     */
    public function store(Request $request)
    {

        $validated = $request->validate([

            'incident_id'  => [
                'nullable',
                'exists:incidents,id',
            ],

            'route_id'     => [
                'nullable',
                'exists:routes,id',
            ],

            'vehicle_id'   => [
                'nullable',
                'exists:vehicles,id',
            ],

            'title'        => [
                'required',
                'max:150',
            ],

            'message'      => [
                'required',
            ],

            'alert_type'   => [
                'required',
                'in:delay,diversion,service_stop,crowded,emergency,info',
            ],

            'priority'     => [
                'required',
                'in:low,medium,high,critical',
            ],

            'is_published' => [
                'nullable',
                'boolean',
            ],

            'published_at' => [
                'nullable',
                'date',
            ],

            'expired_at'   => [
                'nullable',
                'date',
                'after:published_at',
            ],

        ]);

        if (
            isset($validated['is_published'])
            &&
            $validated['is_published']
        ) {

            $validated['published_at'] =
                now();
        }

        Alert::create($validated);

        return redirect()

            ->route('admin.alerts.index')

            ->with(
                'success',
                'Alert berhasil dibuat'
            );
    }

    /**
     * Detail Alert
     */
    public function show(string $id)
    {

        $title = 'Detail Alert';

        $alert = Alert::with([
            'incident',
            'route',
            'vehicle',
        ])
            ->findOrFail($id);

        return view(
            'admin.alerts.show',
            compact(
                'title',
                'alert'
            )
        );
    }

    /**
     * Edit Form
     */
    public function edit(string $id)
    {
        $title = 'Edit Alert';

        $alert = Alert::findOrFail($id);

        $incidents = Incident::orderBy('id', 'desc')
            ->get();

        $routes = TransportRoute::orderBy('route_name', 'asc')
            ->get();

        $vehicles = Vehicle::orderBy('id', 'desc')
            ->get();

        return view(
            'admin.alerts.edit',
            compact(
                'title',
                'alert',
                'incidents',
                'routes',
                'vehicles'
            )
        );
    }

    /**
     * Update Alert
     */
    public function update(
        Request $request,
        string $id
    ) {

        $alert = Alert::findOrFail($id);

        $validated = $request->validate([

            'incident_id'  =>
            'nullable|exists:incidents,id',

            'route_id'     =>
            'nullable|exists:routes,id',

            'vehicle_id'   =>
            'nullable|exists:vehicles,id',

            'title'        =>
            'required|max:150',

            'message'      =>
            'required',

            'alert_type'   =>
            'required|in:delay,diversion,service_stop,crowded,emergency,info',

            'priority'     =>
            'required|in:low,medium,high,critical',

            'is_published' =>
            'nullable|boolean',

            'published_at' =>
            'nullable|date',

            'expired_at'   =>
            'nullable|date|after:published_at',

        ]);

        if (
            isset($validated['is_published'])
            &&
            $validated['is_published']
            &&
            ! $alert->published_at
        ) {

            $validated['published_at'] =
                now();
        }

        $alert->update($validated);

        return redirect()

            ->route('admin.alerts.index')

            ->with(
                'success',
                'Alert berhasil diperbarui'
            );
    }

    /**
     * Delete Alert
     */
    public function destroy(string $id)
    {

        $alert = Alert::findOrFail($id);

        $alert->delete();

        return redirect()

            ->route('admin.alerts.index')

            ->with(
                'success',
                'Alert berhasil dihapus'
            );
    }

    /**
     * Publish Alert
     */
    public function publish(string $id)
    {

        $alert = Alert::findOrFail($id);

        $alert->update([

            'is_published' => true,

            'published_at' => now(),

        ]);

        return back()

            ->with(
                'success',
                'Alert berhasil dipublish'
            );
    }

    /**
     * Expire Alert
     */
    public function expire(string $id)
    {

        $alert = Alert::findOrFail($id);

        $alert->update([

            'expired_at' => now(),

        ]);

        return back()

            ->with(
                'success',
                'Alert berhasil expired'
            );
    }
}