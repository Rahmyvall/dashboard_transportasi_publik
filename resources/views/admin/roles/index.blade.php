@extends('layouts.app')

@section('content')
    <style>
        .role-page {
            background: #f5f7fb;
            min-height: calc(100vh - 80px);
        }

        .page-header-card {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            border-radius: 18px;
            padding: 24px;
            color: #fff;
            box-shadow: 0 12px 30px rgba(37, 99, 235, 0.25);
        }

        .page-header-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .role-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 12px 35px rgba(15, 23, 42, 0.08);
        }

        .role-table thead th {
            background: #f8fafc;
            color: #475569;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .5px;
            padding: 16px;
            border-bottom: 1px solid #e2e8f0;
        }

        .role-table tbody td {
            padding: 18px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #eef2f7;
        }

        .role-table tbody tr:hover {
            background: #f8fbff;
        }

        .role-number {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #eef2ff;
            color: #2563eb;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            border-radius: 999px;
            padding: 8px 14px;
            font-weight: 600;
            font-size: 14px;
        }

        .btn-action {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .btn-edit-soft {
            background: #fff7ed;
            color: #f97316;
            border: 1px solid #fed7aa;
        }

        .btn-edit-soft:hover {
            background: #f97316;
            color: #fff;
        }

        .btn-delete-soft {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .btn-delete-soft:hover {
            background: #dc2626;
            color: #fff;
        }

        .empty-state {
            padding: 60px 20px;
            text-align: center;
            color: #64748b;
        }

        .empty-state-icon {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 38px;
            color: #94a3b8;
        }
    </style>

    @php
        $roleCount = method_exists($roles, 'total') ? $roles->total() : $roles->count();
        $startNumber = method_exists($roles, 'firstItem') ? $roles->firstItem() : 1;
    @endphp

    <div class="role-page py-4">
        <div class="container-fluid">

            {{-- HEADER --}}
            <div class="page-header-card mb-4">
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">

                    <div class="d-flex align-items-center gap-3">
                        <div class="page-header-icon">
                            <i class="ri-shield-user-line"></i>
                        </div>

                        <div>
                            <h3 class="mb-1 fw-bold">
                                {{ $title ?? 'Roles Management' }}
                            </h3>
                            <p class="mb-0 opacity-75">
                                Manage system roles and permissions easily
                            </p>
                        </div>
                    </div>

                    <a href="{{ route('admin.roles.create') }}" class="btn btn-light fw-semibold px-4 shadow-sm">
                        <i class="ri-add-line me-1"></i>
                        Add Role
                    </a>

                </div>
            </div>

            {{-- SUMMARY --}}
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="role-number">
                                <i class="ri-team-line"></i>
                            </div>
                            <div>
                                <small class="text-muted">Total Roles</small>
                                <h5 class="mb-0 fw-bold">{{ $roleCount }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABLE CARD --}}
            <div class="card role-card">

                <div class="card-header bg-white border-0 py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Role List</h5>
                            <small class="text-muted">List of all available system roles</small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">

                        <table class="table role-table table-hover align-middle mb-0">

                            <thead>
                                <tr>
                                    <th width="80">#</th>
                                    <th>Role Name</th>
                                    <th>Description</th>
                                    <th width="140" class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($roles as $i => $role)
                                    <tr>

                                        <td>
                                            <div class="role-number">
                                                {{ $startNumber + $i }}
                                            </div>
                                        </td>

                                        <td>
                                            <span class="role-badge">
                                                <i class="ri-shield-star-line"></i>
                                                {{ $role->role_name }}
                                            </span>
                                        </td>

                                        <td class="text-muted">
                                            {{ $role->description ?? 'No description available' }}
                                        </td>

                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">

                                                {{-- EDIT --}}
                                                <a href="{{ route('admin.roles.edit', $role->id) }}"
                                                    class="btn btn-action btn-edit-soft" title="Edit Role">
                                                    <i class="ri-edit-2-line"></i>
                                                </a>

                                                {{-- DELETE --}}
                                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this role?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-action btn-delete-soft"
                                                        title="Delete Role">
                                                        <i class="ri-delete-bin-6-line"></i>
                                                    </button>

                                                </form>

                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <div class="empty-state">
                                                <div class="empty-state-icon">
                                                    <i class="ri-inbox-line"></i>
                                                </div>

                                                <h5 class="fw-bold mb-1">No roles found</h5>
                                                <p class="mb-3">Create your first role to start managing permissions.</p>

                                                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary px-4">
                                                    <i class="ri-add-line me-1"></i>
                                                    Add Role
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>

                    </div>
                </div>

                @if (method_exists($roles, 'links'))
                    <div class="card-footer bg-white border-0 px-4 py-3">
                        {{ $roles->links() }}
                    </div>
                @endif

            </div>

        </div>
    </div>
@endsection
