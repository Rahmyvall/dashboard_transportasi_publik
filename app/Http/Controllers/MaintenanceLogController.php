<?php
namespace App\Http\Controllers;

use App\Http\Requests\MaintenanceLogRequest;
use App\Models\MaintenanceLog;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaintenanceLogController extends Controller
{
    /**
     * Menampilkan daftar maintenance kendaraan.
     */
    public function index(Request $request): View
    {
        $title = 'Data Maintenance Kendaraan';

        $maintenanceLogs = MaintenanceLog::query()
            ->with('vehicle')

        // Filter status
            ->when(
                $request->filled('status'),
                fn($query) => $query->where(
                    'status',
                    $request->string('status')->toString()
                )
            )

        // Filter jenis maintenance
            ->when(
                $request->filled('maintenance_type'),
                fn($query) => $query->where(
                    'maintenance_type',
                    $request->string('maintenance_type')->toString()
                )
            )

        // Pencarian
            ->when(
                $request->filled('search'),
                function ($query) use ($request) {
                    $search = trim(
                        $request->string('search')->toString()
                    );

                    $query->where(function ($subQuery) use ($search) {
                        $subQuery
                            ->where('handled_by', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%")
                            ->orWhereHas('vehicle', function ($vehicleQuery) use ($search) {
                                /*
                                 * Sesuaikan plate_number dan name
                                 * dengan kolom tabel vehicles Anda.
                                 */
                                $vehicleQuery
                                    ->where('plate_number', 'like', "%{$search}%")
                                    ->orWhere('name', 'like', "%{$search}%");
                            });
                    });
                }
            )

        // Urutan data terbaru
            ->orderByDesc('maintenance_date')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.maintenance_logs.index', compact(
            'title',
            'maintenanceLogs'
        ));
    }

    /**
     * Menampilkan form tambah maintenance.
     */
    public function create(): View
    {
        $title = 'Tambah Maintenance Kendaraan';

        $maintenanceLog = new MaintenanceLog();

        $vehicles = Vehicle::query()
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.maintenance_logs.create', compact(
            'title',
            'maintenanceLog',
            'vehicles'
        ));
    }

    /**
     * Menyimpan data maintenance baru.
     */
    public function store(
        MaintenanceLogRequest $request
    ): RedirectResponse {
        MaintenanceLog::create(
            $request->validated()
        );

        return redirect()
            ->route('admin.maintenance-logs.index')
            ->with(
                'success',
                'Data maintenance berhasil ditambahkan.'
            );
    }

    /**
     * Menampilkan detail maintenance.
     */
    public function show(
        MaintenanceLog $maintenanceLog
    ): View {
        $title = 'Detail Maintenance Kendaraan';

        $maintenanceLog->load('vehicle');

        return view('admin.maintenance_logs.show', compact(
            'title',
            'maintenanceLog'
        ));
    }

    /**
     * Menampilkan form edit maintenance.
     */
    public function edit(
        MaintenanceLog $maintenanceLog
    ): View {
        $title = 'Edit Maintenance Kendaraan';

        $maintenanceLog->load('vehicle');

        $vehicles = Vehicle::query()
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.maintenance_logs.edit', compact(
            'title',
            'maintenanceLog',
            'vehicles'
        ));
    }

    /**
     * Memperbarui data maintenance.
     */
    public function update(
        MaintenanceLogRequest $request,
        MaintenanceLog $maintenanceLog
    ): RedirectResponse {
        $maintenanceLog->update(
            $request->validated()
        );

        return redirect()
            ->route('admin.maintenance-logs.index')
            ->with(
                'success',
                'Data maintenance berhasil diperbarui.'
            );
    }

    /**
     * Menghapus data maintenance.
     */
    public function destroy(
        MaintenanceLog $maintenanceLog
    ): RedirectResponse {
        $maintenanceLog->delete();

        return redirect()
            ->route('admin.maintenance-logs.index')
            ->with(
                'success',
                'Data maintenance berhasil dihapus.'
            );
    }
}