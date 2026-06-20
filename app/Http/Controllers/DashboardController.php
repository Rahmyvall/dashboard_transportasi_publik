<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // You can pass data to the view here if needed
        $data = [
            'title' => 'Dashboard'
        ];

        return view('dashboard', $data);
    }
}