<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransportMode;
use Illuminate\Http\Request;

class TransportModeController extends Controller
{
    /**
     * LIST DATA
     */
    public function index(Request $request)
    {
        $transportModes = TransportMode::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('mode_code', 'like', '%' . $request->search . '%')
                      ->orWhere('mode_name', 'like', '%' . $request->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.transport-modes.index', [
            'transportModes' => $transportModes,
            'search' => $request->search,
            'title' => 'Data Mode Transportasi'
        ]);
    }

    /**
     * FORM CREATE
     */
    public function create()
    {
        return view('admin.transport-modes.create', [
            'title' => 'Tambah Mode Transportasi'
        ]);
    }

    /**
     * STORE DATA
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mode_code' => 'required|string|max:50|unique:transport_modes,mode_code',
            'mode_name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        TransportMode::create([
            'mode_code' => strtoupper($validated['mode_code']),
            'mode_name' => $validated['mode_name'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()
            ->route('admin.transport-modes.index')
            ->with('success', 'Data mode transportasi berhasil ditambahkan');
    }

    /**
     * FORM EDIT
     */
    public function edit($id)
    {
        $transportMode = TransportMode::findOrFail($id);

        return view('admin.transport-modes.edit', [
            'transportMode' => $transportMode,
            'title' => 'Edit Mode Transportasi'
        ]);
    }

    /**
     * UPDATE DATA
     */
    public function update(Request $request, $id)
    {
        $transportMode = TransportMode::findOrFail($id);

        $validated = $request->validate([
            'mode_code' => 'required|string|max:50|unique:transport_modes,mode_code,' . $id,
            'mode_name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $transportMode->update([
            'mode_code' => strtoupper($validated['mode_code']),
            'mode_name' => $validated['mode_name'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()
            ->route('admin.transport-modes.index')
            ->with('success', 'Data mode transportasi berhasil diupdate');
    }

    /**
     * DELETE DATA
     */
    public function destroy($id)
    {
        $transportMode = TransportMode::findOrFail($id);
        $transportMode->delete();

        return redirect()
            ->route('admin.transport-modes.index')
            ->with('success', 'Data mode transportasi berhasil dihapus');
    }
}