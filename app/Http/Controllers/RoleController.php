<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    // INDEX
    public function index()
    {
        $roles = DB::table('roles')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.roles.index', [
            'roles' => $roles,
            'title' => 'Data Roles'
        ]);
    }

    // CREATE
    public function create()
    {
        return view('admin.roles.create', [
            'title' => 'Create Role'
        ]);
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        DB::table('roles')->insert([
            'role_name' => $request->role_name,
            'description' => $request->description,
            'created_at' => now(),
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role berhasil ditambahkan');
    }

    // EDIT
    public function edit($id)
    {
        $role = DB::table('roles')->where('id', $id)->first();

        return view('admin.roles.edit', [
            'role' => $role,
            'title' => 'Edit Role'
        ]);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'role_name' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        DB::table('roles')
            ->where('id', $id)
            ->update([
                'role_name' => $request->role_name,
                'description' => $request->description,
            ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role berhasil diupdate');
    }

    // DELETE
    public function destroy($id)
    {
        DB::table('roles')->where('id', $id)->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role berhasil dihapus');
    }
}