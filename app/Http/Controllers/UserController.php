<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data User'
        ];

        return view('admin.user.index', $data);
    }
}