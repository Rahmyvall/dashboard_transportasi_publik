<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stop;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StopController extends Controller
{
    private function stopTypes()
    {
        return [
            'halte' => 'Halte',
            'terminal' => 'Terminal',
            'shelter' => 'Shelter',
            'stasiun' => 'Stasiun',
        ];
    }

    /* =========================================================
     * INDEX
     * ========================================================= */
    public function index(Request $request)
    {
        $stops = Stop::query()

            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('stop_code', 'like', "%{$request->search}%")
                        ->orWhere('stop_name', 'like', "%{$request->search}%")
                        ->orWhere('address', 'like', "%{$request->search}%");
                });
            })

            ->when($request->stop_type, function ($q) use ($request) {
                $q->where('stop_type', $request->stop_type);
            })

            ->when($request->filled('is_active'), function ($q) use ($request) {
                $q->where('is_active', $request->is_active);
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.stops.index', [
            'stops' => $stops,
            'title' => 'Data Stops'
        ]);
    }

    /* =========================================================
     * CREATE
     * ========================================================= */
    public function create()
    {
        return view('admin.stops.create', [
            'stopTypes' => $this->stopTypes(),
            'title' => 'Tambah Stop'
        ]);
    }

    /* =========================================================
     * STORE
     * ========================================================= */
    public function store(Request $request)
    {
        $data = $request->validate([
            'stop_name' => 'required|string|max:150',
            'stop_type' => ['required', Rule::in(array_keys($this->stopTypes()))],
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'address' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        // AUTO CODE SAFE
        $last = Stop::orderBy('id', 'desc')->first();
        $number = 1;

        if ($last && str_contains($last->stop_code, 'STP-')) {
            $number = (int) str_replace('STP-', '', $last->stop_code) + 1;
        }

        $data['stop_code'] = 'STP-' . str_pad($number, 4, '0', STR_PAD_LEFT);

        // checkbox fix
        $data['is_active'] = $request->has('is_active');

        // MAP SAFE CONVERSION
        $data['latitude'] = isset($data['latitude']) ? (float) $data['latitude'] : null;
        $data['longitude'] = isset($data['longitude']) ? (float) $data['longitude'] : null;

        Stop::create($data);

        return redirect()
            ->route('admin.stops.index')
            ->with('success', 'Stop berhasil ditambahkan.');
    }

    /* =========================================================
     * EDIT
     * ========================================================= */
    public function edit($id)
    {
        $stop = Stop::findOrFail($id);

        return view('admin.stops.edit', [
            'stop' => $stop,
            'stopTypes' => $this->stopTypes(),
            'title' => 'Edit Stop'
        ]);
    }

    public function show($id)
    {
        $stop = Stop::findOrFail($id);

        $title = 'Detail Stop';

        return view('admin.stops.show', compact('stop', 'title'));
    }

    /* =========================================================
     * UPDATE
     * ========================================================= */
  public function update(Request $request, $id)
    {
        $request->validate([
            'stop_name' => 'required',
            'stop_type' => 'required',
            'is_active' => 'required',
            'address' => 'nullable',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $stop = Stop::findOrFail($id);

        $stop->update([
            'stop_name' => $request->stop_name,
            'stop_type' => $request->stop_type,
            'is_active' => $request->is_active,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()
            ->route('admin.stops.index')
            ->with('success', 'Stop berhasil diupdate');
    }

    /* =========================================================
     * DELETE
     * ========================================================= */
    public function destroy($id)
    {
        Stop::findOrFail($id)->delete();

        return back()->with('success', 'Stop berhasil dihapus.');
    }

    /* =========================================================
     * TOGGLE STATUS
     * ========================================================= */
    public function toggleStatus($id)
    {
        $stop = Stop::findOrFail($id);

        $stop->update([
            'is_active' => !$stop->is_active
        ]);

        return back()->with('success', 'Status berhasil diubah.');
    }

    /* =========================================================
     * MAP DATA
     * ========================================================= */
    public function mapData()
    {
        return response()->json(
            Stop::whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->where('is_active', 1)
                ->get([
                    'id',
                    'stop_code',
                    'stop_name',
                    'stop_type',
                    'latitude',
                    'longitude',
                    'address'
                ])
        );
    }
}