<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserApiController extends Controller
{
    // GET ALL USER
    public function index()
    {
        $users = User::with(['role', 'operator'])->latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'List user',
            'data' => $users
        ]);
    }

    // GET DETAIL USER
    public function show($id)
    {
        $user = User::with(['role', 'operator'])->find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $user
        ]);
    }

    // CREATE USER (SESUAI DATABASE KAMU)
    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'operator_id' => 'nullable|exists:operators,id',
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'nullable|email|max:100',
            'password' => 'required|min:6',
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ]);

        $user = User::create([
            'role_id' => $request->role_id,
            'operator_id' => $request->operator_id,
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User berhasil dibuat',
            'data' => $user
        ]);
    }

    // UPDATE USER
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'operator_id' => 'nullable|exists:operators,id',
            'name' => 'required|string|max:100',
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users')->ignore($id),
            ],
            'email' => 'nullable|email|max:100',
            'password' => 'nullable|min:6',
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ]);

        $data = [
            'role_id' => $request->role_id,
            'operator_id' => $request->operator_id,
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'status' => $request->status,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'status' => true,
            'message' => 'User berhasil diupdate',
            'data' => $user
        ]);
    }

    // DELETE USER
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User berhasil dihapus'
        ]);
    }
}