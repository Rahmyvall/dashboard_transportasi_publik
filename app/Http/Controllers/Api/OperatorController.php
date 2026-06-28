<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Operator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OperatorController extends Controller
{
    // 🔵 GET ALL
    public function index()
    {
        $data = Operator::orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'message' => 'List data operator',
            'data' => $data
        ], 200);
    }

    // 🔵 GET BY ID
    public function show($id)
    {
        $data = Operator::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    // 🔵 CREATE
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'operator_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string',
            'status' => 'in:aktif,nonaktif'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = Operator::create([
            'operator_name' => $request->operator_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'status' => $request->status ?? 'aktif',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Operator berhasil ditambahkan',
            'data' => $data
        ], 201);
    }

    // 🔵 UPDATE
    public function update(Request $request, $id)
    {
        $data = Operator::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'operator_name' => 'sometimes|required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string',
            'status' => 'in:aktif,nonaktif'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data->update($request->only([
            'operator_name',
            'phone',
            'email',
            'address',
            'status'
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Operator berhasil diupdate',
            'data' => $data
        ], 200);
    }

    // 🔵 DELETE
    public function destroy($id)
    {
        $data = Operator::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Operator berhasil dihapus'
        ], 200);
    }
}