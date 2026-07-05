<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Operator;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * GENERATE AUTO SIM NUMBER
     */
    private function generateLicenseNumber()
    {
        $lastDriver = Driver::orderBy('id', 'desc')->first();

        $nextNumber = 1;

        if ($lastDriver && $lastDriver->license_number) {
            $number = (int) str_replace('SIM-', '', $lastDriver->license_number);
            $nextNumber = $number + 1;
        }

        return 'SIM-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * INDEX
     */
    public function index()
    {
        $drivers = Driver::with('operator')
            ->orderBy('driver_name')
            ->paginate(10);

        return view('admin.drivers.index', [
            'drivers' => $drivers,
            'title' => 'Data Driver'
        ]);
    }

    /**
     * CREATE
     */
    public function create()
    {
        $operators = Operator::orderBy('operator_name')->get();

        // preview SIM berikutnya (opsional di UI)
        $nextSim = $this->generateLicenseNumber();

        return view('admin.drivers.create', [
            'operators' => $operators,
            'title' => 'Tambah Driver',
            'nextSim' => $nextSim
        ]);
    }

    /**
     * STORE (AUTO SIM)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'operator_id' => 'required|exists:operators,id',
            'driver_name' => 'required|string|max:150',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive,on_duty',
        ]);

        // AUTO GENERATE SIM
        $validated['license_number'] = $this->generateLicenseNumber();

        Driver::create($validated);

        return redirect()
            ->route('admin.drivers.index')
            ->with('success', 'Driver berhasil ditambahkan dengan SIM ' . $validated['license_number']);
    }

    /**
     * SHOW
     */
    public function show($id)
    {
        $driver = Driver::with('operator')->findOrFail($id);

        return view('admin.drivers.show', [
            'driver' => $driver,
            'title' => 'Detail Driver'
        ]);
    }

    /**
     * EDIT
     */
    public function edit($id)
    {
        $driver = Driver::findOrFail($id);
        $operators = Operator::orderBy('operator_name')->get();

        return view('admin.drivers.edit', [
            'driver' => $driver,
            'operators' => $operators,
            'title' => 'Edit Driver'
        ]);
    }

    /**
     * UPDATE (SIM TIDAK DIUBAH)
     */
    public function update(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);

        $validated = $request->validate([
            'operator_id' => 'required|exists:operators,id',
            'driver_name' => 'required|string|max:150',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive,on_duty',
        ]);

        // SIM TIDAK DIUBAH (tetap konsisten)
        $driver->update($validated);

        return redirect()
            ->route('admin.drivers.index')
            ->with('success', 'Driver berhasil diupdate');
    }

    /**
     * DELETE
     */
    public function destroy($id)
    {
        Driver::findOrFail($id)->delete();

        return redirect()
            ->route('admin.drivers.index')
            ->with('success', 'Driver berhasil dihapus');
    }

    /**
     * FILTER ACTIVE
     */
    public function active()
    {
        $drivers = Driver::with('operator')
            ->where('status', 'active')
            ->orderBy('driver_name')
            ->paginate(10);

        return view('admin.drivers.index', [
            'drivers' => $drivers,
            'title' => 'Driver Active'
        ]);
    }

    /**
     * FILTER ON DUTY
     */
    public function onDuty()
    {
        $drivers = Driver::with('operator')
            ->where('status', 'on_duty')
            ->orderBy('driver_name')
            ->paginate(10);

        return view('admin.drivers.index', [
            'drivers' => $drivers,
            'title' => 'Driver On Duty'
        ]);
    }

    /**
     * FILTER INACTIVE
     */
    public function inactive()
    {
        $drivers = Driver::with('operator')
            ->where('status', 'inactive')
            ->orderBy('driver_name')
            ->paginate(10);

        return view('admin.drivers.index', [
            'drivers' => $drivers,
            'title' => 'Driver Inactive'
        ]);
    }
}