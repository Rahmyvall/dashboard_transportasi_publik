<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Operator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        // ✅ PAGINATION (INI YANG BENAR)
        $users = User::with(['role', 'operator'])
            ->latest()
            ->paginate(10);

        return view('admin.users.index', [
            'title' => 'Data User',
            'users' => $users,
        ]);
    }

    public function create()
    {
        return view('admin.users.create', [
            'title' => 'Tambah User',
            'roles' => Role::orderBy('role_name', 'asc')->get(),
            'operators' => Operator::where('status', 'aktif')
                ->orderBy('operator_name', 'asc')
                ->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
            'operator_id' => ['nullable', 'exists:operators,id'],
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'email' => ['nullable', 'email', 'max:100'],
            'password' => ['required', 'string', 'min:6'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', [
            'title' => 'Edit User',
            'user' => $user,
            'roles' => Role::orderBy('role_name', 'asc')->get(),
            'operators' => Operator::where('status', 'aktif')
                ->orderBy('operator_name', 'asc')
                ->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
            'operator_id' => ['nullable', 'exists:operators,id'],
            'name' => ['required', 'string', 'max:100'],
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email' => ['nullable', 'email', 'max:100'],
            'password' => ['nullable', 'string', 'min:6'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}