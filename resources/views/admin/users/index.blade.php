@extends('layouts.app')

@section('content')
    <style>
        .page-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #1f2937;
        }

        .page-subtitle {
            color: #6b7280;
            font-size: .9rem;
        }

        .user-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .08);
        }

        .user-card-header {
            background: linear-gradient(135deg, #2563eb, #0ea5e9);
            color: white;
            padding: 22px 24px;
        }

        .table-custom {
            margin-bottom: 0;
        }

        .table-custom thead th {
            background: #f8fafc;
            color: #475569;
            font-size: .78rem;
            text-transform: uppercase;
            letter-spacing: .04em;
            padding: 14px 16px;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }

        .table-custom tbody td {
            padding: 16px;
            vertical-align: middle;
            border-color: #f1f5f9;
        }

        .table-custom tbody tr {
            transition: .2s ease;
        }

        .table-custom tbody tr:hover {
            background: #f8fbff;
            transform: scale(1.002);
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1d4ed8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            flex-shrink: 0;
        }

        .badge-soft-secondary {
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #e2e8f0;
        }

        .badge-soft-info {
            background: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
        }

        .badge-soft-success {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .badge-soft-danger {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .action-btn {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }

        .empty-state {
            padding: 45px 20px;
            text-align: center;
            color: #64748b;
        }

        .empty-state i {
            font-size: 42px;
            color: #cbd5e1;
            margin-bottom: 12px;
        }

        .pagination {
            margin-bottom: 0;
        }

        .pagination .page-link {
            border-radius: 10px;
            margin: 0 3px;
            border: 1px solid #e5e7eb;
            color: #2563eb;
        }

        .pagination .active .page-link {
            background: #2563eb;
            border-color: #2563eb;
        }

        @media (max-width: 768px) {
            .user-card-header {
                padding: 18px;
            }

            .table-custom thead th,
            .table-custom tbody td {
                padding: 12px;
            }
        }
    </style>

    <div class="container-fluid">

        <!-- HEADER PAGE -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <div class="page-title">Data User</div>
                <div class="page-subtitle">
                    Manajemen akun pengguna sistem
                </div>
            </div>

            <a href="{{ route('admin.users.create') }}" class="btn btn-primary shadow-sm rounded-3 px-4">
                <i class="fa fa-plus me-1"></i> Tambah User
            </a>
        </div>

        <!-- CARD -->
        <div class="card user-card">

            <!-- CARD HEADER -->
            <div class="user-card-header">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <h5 class="mb-1 fw-bold">
                            <i class="fa fa-users me-2"></i>
                            Daftar Pengguna
                        </h5>
                        <small class="opacity-75">
                            Kelola role, operator, status, dan informasi akun pengguna.
                        </small>
                    </div>

                    <div class="bg-white bg-opacity-25 rounded-3 px-3 py-2">
                        <small class="d-block opacity-75">Total Data</small>
                        <strong>{{ $users->total() }} User</strong>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-hover align-middle table-custom">

                        <thead>
                            <tr>
                                <th width="70">No</th>
                                <th>Pengguna</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Operator</th>
                                <th>Status</th>
                                <th class="text-center" width="120">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($users as $i => $user)
                                <tr>
                                    <td class="fw-bold text-muted">
                                        {{ $users->firstItem() + $i }}
                                    </td>

                                    <!-- USER INFO -->
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="user-avatar">
                                                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                            </div>

                                            <div>
                                                <div class="fw-bold text-dark">
                                                    {{ $user->name }}
                                                </div>

                                                <small class="text-muted">
                                                    <i class="fa fa-envelope me-1"></i>
                                                    {{ $user->email ?? '-' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge badge-soft-secondary px-3 py-2 rounded-pill">
                                            <i class="fa fa-user me-1"></i>
                                            {{ $user->username }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge badge-soft-info px-3 py-2 rounded-pill">
                                            <i class="fa fa-user-shield me-1"></i>
                                            {{ $user->role->role_name ?? '-' }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="text-dark">
                                            <i class="fa fa-building text-muted me-1"></i>
                                            {{ $user->operator->operator_name ?? '-' }}
                                        </span>
                                    </td>

                                    <!-- STATUS -->
                                    <td>
                                        @if ($user->status == 'aktif')
                                            <span class="badge badge-soft-success px-3 py-2 rounded-pill">
                                                <i class="fa fa-check-circle me-1"></i> Aktif
                                            </span>
                                        @else
                                            <span class="badge badge-soft-danger px-3 py-2 rounded-pill">
                                                <i class="fa fa-times-circle me-1"></i> Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    <!-- ACTION -->
                                    <td class="text-center">
                                        <div class="d-inline-flex gap-1">
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                                class="btn btn-sm btn-warning text-white action-btn" title="Edit User">
                                                <i class="fa fa-pen"></i>
                                            </a>

                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Yakin hapus user ini?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-danger action-btn"
                                                    title="Hapus User">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <i class="fa fa-users"></i>
                                            <h6 class="fw-bold mb-1">Belum ada data user</h6>
                                            <small>Silakan tambah user baru untuk mulai mengelola akun pengguna.</small>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                <!-- PAGINATION -->
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 p-3 border-top bg-light">

                    <small class="text-muted">
                        @if ($users->total() > 0)
                            Menampilkan
                            <strong>{{ $users->firstItem() }}</strong>
                            -
                            <strong>{{ $users->lastItem() }}</strong>
                            dari
                            <strong>{{ $users->total() }}</strong>
                            data
                        @else
                            Tidak ada data yang ditampilkan
                        @endif
                    </small>

                    <div>
                        {{ $users->links('pagination::bootstrap-5') }}
                    </div>

                </div>

            </div>
        </div>

    </div>
@endsection
