<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TransportMode;
use Illuminate\Http\Request;

class TransportModeApiController extends Controller
{
    /**
     * GET ALL DATA
     */
    public function index()
    {
        $data = TransportMode::latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'List data transport modes',
            'data' => $data
        ], 200);
    }

    /**
     * GET DETAIL
     */
    public function show($id)
    {
        $data = TransportMode::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail transport mode',
            'data' => $data
        ], 200);
    }

    /**
     * CREATE
     */
    public function store(Request $request)
    {
        $request->validate([
            'mode_code' => 'required|string|max:50|unique:transport_modes,mode_code',
            'mode_name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $data = TransportMode::create([
            'mode_code' => strtoupper($request->mode_code),
            'mode_name' => $request->mode_name,
            'description' => $request->description,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditambahkan',
            'data' => $data
        ], 201);
    }

    /**
     * UPDATE
     */
    public function update(Request $request, $id)
    {
        $data = TransportMode::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $request->validate([
            'mode_code' => 'required|string|max:50|unique:transport_modes,mode_code,' . $id,
            'mode_name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $data->update([
            'mode_code' => strtoupper($request->mode_code),
            'mode_name' => $request->mode_name,
            'description' => $request->description,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diupdate',
            'data' => $data
        ], 200);
    }

    /**
     * DELETE
     */
    public function destroy($id)
    {
        $data = TransportMode::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ], 200);
    }
}