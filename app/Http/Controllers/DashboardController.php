<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Pengembangan Dashboard Monitoring Transportasi Publik';

        return view('dashboard', compact('title'));
    }
}
