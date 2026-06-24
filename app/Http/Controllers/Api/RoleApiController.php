<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleApiController extends Controller
{
    // GET ALL
    public function index()
    {
        $roles = DB::table('roles')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'List Roles',
            'data' => $roles
        ]);
    }

    // GET BY ID
    public function show($id)
    {
        $role = DB::table('roles')->where('id', $id)->first();

        if (!$role) {
            return response()->json([
                'status' => false,
                'message' => 'Role not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $role
        ]);
    }

    // CREATE
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        $id = DB::table('roles')->insertGetId([
            'role_name' => $request->role_name,
            'description' => $request->description,
            'created_at' => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Role created',
            'id' => $id
        ], 201);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $role = DB::table('roles')->where('id', $id)->first();

        if (!$role) {
            return response()->json([
                'status' => false,
                'message' => 'Role not found'
            ], 404);
        }

        DB::table('roles')
            ->where('id', $id)
            ->update([
                'role_name' => $request->role_name,
                'description' => $request->description,
            ]);

        return response()->json([
            'status' => true,
            'message' => 'Role updated'
        ]);
    }

    // DELETE
    public function destroy($id)
    {
        DB::table('roles')->where('id', $id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Role deleted'
        ]);
    }
}