<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoleController extends Controller
{
  /**
   * Menampilkan daftar role.
   */
  public function index(Request $request): AnonymousResourceCollection
  {
    $roles = Role::query()
      ->when(
        $request->filled('search'),
        function ($query) use ($request) {
          $search = $request->string('search')->toString();

          $query->where(function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
          });
        }
      )
      ->latest()
      ->paginate(
        perPage: min(
          max((int) $request->input('per_page', 10), 1),
          100
        )
      )
      ->withQueryString();

    return RoleResource::collection($roles);
  }

  /**
   * Menyimpan role baru.
   */
  public function store(StoreRoleRequest $request): JsonResponse
  {
    $role = Role::create($request->validated());

    return response()->json([
      'success' => true,
      'message' => 'Role berhasil ditambahkan.',
      'data' => new RoleResource($role),
    ], 201);
  }

  /**
   * Menampilkan satu role.
   */
  public function show(Role $role): JsonResponse
  {
    return response()->json([
      'success' => true,
      'message' => 'Detail role berhasil ditemukan.',
      'data' => new RoleResource($role),
    ]);
  }

  /**
   * Memperbarui role.
   */
  public function update(
    UpdateRoleRequest $request,
    Role $role
  ): JsonResponse {
    $role->update($request->validated());

    return response()->json([
      'success' => true,
      'message' => 'Role berhasil diperbarui.',
      'data' => new RoleResource($role->fresh()),
    ]);
  }

  /**
   * Menghapus role.
   */
  public function destroy(Role $role): JsonResponse
  {
    $role->delete();

    return response()->json([
      'success' => true,
      'message' => 'Role berhasil dihapus.',
      'data' => null,
    ]);
  }
}
