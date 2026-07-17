<?php
namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\PassengerCount;
use App\Models\TransportMode;
use App\Models\Vehicle;

class DashboardController extends Controller
{

    /**
     * Dashboard Utama
     */
    public function index()
    {

        $title = 'Pengembangan Dashboard Monitoring Transportasi Publik';

        // =========================
        // DATA NOTIFIKASI
        // =========================

        $notifications = Alert::latest()
            ->limit(5)
            ->get();

        $notificationCount = Alert::count();

        // =========================
        // STATISTIK ALERT
        // =========================

        $alertStats = [

            'total'     => Alert::count(),

            'critical'  => Alert::where(
                'priority',
                'critical'
            )
                ->count(),

            'emergency' => Alert::where(
                'alert_type',
                'emergency'
            )
                ->count(),

            'active'    => Alert::whereNotNull(
                'published_at'
            )
                ->count(),

        ];

        // =========================
        // KPI TRANSPORTASI
        // =========================

        // Total Armada
        $activeVehicles = Vehicle::count();

        // Total Penumpang
        $totalPassengers = PassengerCount::count();

        // Total Mode Transportasi
        $totalTransportModes = TransportMode::count();

        // =========================
        // ON TIME PERFORMANCE
        // =========================

        // Belum tersedia pada tabel transport_modes
        // Default sementara

        $onTimeRate = 0;

        // =========================
        // LOAD DASHBOARD
        // =========================

        return view(
            'dashboard',
            compact(

                'title',

                // Notifikasi
                'notifications',
                'notificationCount',

                // Alert
                'alertStats',

                // KPI
                'activeVehicles',
                'totalPassengers',
                'totalTransportModes',
                'onTimeRate'

            )
        );

    }

    // =========================
    // DASHBOARD ARMADA
    // =========================

    public function armada()
    {

        $title = 'Dashboard Armada Transportasi';

        return view(
            'dashboard.armada',
            compact('title')
        );

    }

    // =========================
    // DASHBOARD PERJALANAN
    // =========================

    public function perjalanan()
    {

        $title = 'Dashboard Perjalanan Transportasi';

        return view(
            'dashboard.perjalanan',
            compact('title')
        );

    }

    // =========================
    // DASHBOARD PENUMPANG
    // =========================

    public function penumpang()
    {

        $title = 'Dashboard Penumpang Transportasi';

        return view(
            'dashboard.penumpang',
            compact('title')
        );

    }

    // =========================
    // DASHBOARD PETA
    // =========================

    public function peta()
    {

        $title = 'Dashboard Peta';

        return view(
            'dashboard.peta',
            compact('title')
        );

    }

}