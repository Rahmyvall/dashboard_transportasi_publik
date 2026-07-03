<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stop;

class StopApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => Stop::latest()->get()
        ]);
    }

    public function show($id)
    {
        $stop = Stop::find($id);

        if (!$stop) {
            return response()->json([
                'status' => false,
                'message' => 'Stop not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $stop
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'stop_name' => 'required',
            'stop_type' => 'required',
            'address' => 'nullable',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'is_active' => 'required'
        ]);

        $stop = Stop::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Stop created',
            'data' => $stop
        ]);
    }

    public function update(Request $request, $id)
    {
        $stop = Stop::find($id);

        if (!$stop) {
            return response()->json([
                'status' => false,
                'message' => 'Stop not found'
            ], 404);
        }

        $stop->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Stop updated',
            'data' => $stop
        ]);
    }

    public function destroy($id)
    {
        $stop = Stop::find($id);

        if (!$stop) {
            return response()->json([
                'status' => false,
                'message' => 'Stop not found'
            ], 404);
        }

        $stop->delete();

        return response()->json([
            'status' => true,
            'message' => 'Stop deleted'
        ]);
    }
}