<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Pengembangan Dashboard Monitoring Transportasi Publik';

        return view('dashboard', compact('title'));
    }

    // =========================
    // DASHBOARD ARMADA (TAMBAHAN)
    // =========================
    public function armada()
    {
        $title = 'Dashboard Armada Transportasi';


        return view('dashboard.armada', compact(
            'title',
        ));
    }

    public function perjalanan()
    {
        $title = 'Dashboard Perjalanan Transportasi';


        return view('dashboard.perjalanan', compact(
            'title',
        ));
    }

    public function penumpang()
    {
        $title = 'Dashboard Penumpang Transportasi';


        return view('dashboard.penumpang', compact(
            'title',
        ));
    }

    public function peta()
    {
        $title = 'Dashboard Peta';


        return view('dashboard.peta', compact(
            'title',
        ));
    }
}