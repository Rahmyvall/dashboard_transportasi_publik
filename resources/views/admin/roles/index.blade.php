@extends('layouts.app')

@section('content')
    <div class="container-fluid py-3">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="mb-0 fw-bold">
                    <i class="ri-shield-user-line text-primary"></i>
                    {{ $title ?? 'Roles Management' }}
                </h3>
                <small class="text-muted">Manage system roles & permissions</small>
            </div>

            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary shadow-sm px-3">
                <i class="ri-add-line"></i> Add Role
            </a>

        </div>

        <!-- CARD -->
        <div class="card border-0 shadow-lg rounded-3">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th width="60">#</th>
                                <th>Role Name</th>
                                <th>Description</th>
                                <th width="120" class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($roles as $i => $role)
                                <tr class="border-top">

                                    <td class="text-muted">
                                        {{ $i + 1 }}
                                    </td>

                                    <td>
                                        <span class="badge rounded-pill bg-dark px-3 py-2">
                                            <i class="ri-shield-star-line me-1"></i>
                                            {{ $role->role_name }}
                                        </span>
                                    </td>

                                    <td class="text-muted">
                                        {{ $role->description ?? '-' }}
                                    </td>

                                    <td class="text-center">

                                        <!-- EDIT -->
                                        <a href="{{ route('admin.roles.edit', $role->id) }}"
                                            class="btn btn-sm btn-warning shadow-sm">
                                            <i class="ri-edit-2-line"></i>
                                        </a>

                                        <!-- DELETE -->
                                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Are you sure delete this role?')">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-sm btn-danger shadow-sm">
                                                <i class="ri-delete-bin-6-line"></i>
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4" class="text-center py-5">

                                        <div class="text-muted">
                                            <i class="ri-inbox-line display-6"></i>
                                            <p class="mt-2 mb-0">No roles found</p>
                                            <small>Create your first role</small>
                                        </div>

                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
@endsection
