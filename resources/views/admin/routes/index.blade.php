@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">

        <!-- TOP HERO -->
        <div class="hero-shell mb-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>
                    <h2 class="title">Manajemen Rute</h2>
                    <p class="subtitle">Kelola data rute transportasi secara real-time dan terstruktur</p>
                </div>

                <a href="{{ route('admin.routes.create') }}" class="btn btn-primary btn-modern">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Rute
                </a>

            </div>

        </div>

        <!-- TABLE CARD -->
        <div class="card card-modern border-0 shadow-lg">

            <!-- HEADER -->
            <div class="card-header bg-white border-0 py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <div class="fw-bold">Daftar Rute</div>
                        <small class="text-muted">Total {{ $routes->total() }} data aktif sistem</small>
                    </div>

                </div>

            </div>

            <!-- TABLE -->
            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-modern mb-0 align-middle">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Rute</th>
                                <th>Operator</th>
                                <th>Transport</th>
                                <th>Jarak</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($routes as $i => $r)
                                <tr class="row-hover">

                                    <td class="text-muted">
                                        {{ $routes->firstItem() + $i }}
                                    </td>

                                    <td>
                                        <span class="code-chip">{{ $r->route_code }}</span>
                                    </td>

                                    <td>
                                        <div class="fw-semibold">{{ $r->route_name }}</div>
                                        <div class="text-muted small">
                                            {{ $r->origin }} → {{ $r->destination }}
                                        </div>
                                    </td>

                                    <td>{{ $r->operator->operator_name ?? '-' }}</td>

                                    <td>{{ $r->transportMode->mode_name ?? '-' }}</td>

                                    <td class="text-muted">
                                        {{ $r->distance_km ?? 0 }} km
                                    </td>

                                    <td>
                                        @if ($r->status == 'active')
                                            <span class="badge-status success">Active</span>
                                        @elseif($r->status == 'inactive')
                                            <span class="badge-status danger">Inactive</span>
                                        @else
                                            <span class="badge-status warning">Maintenance</span>
                                        @endif
                                    </td>

                                    <!-- ACTION -->
                                    <td>
                                        <div class="action">

                                            <a href="{{ route('admin.routes.show', $r->id) }}" class="icon-btn info">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.routes.edit', $r->id) }}" class="icon-btn primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <form action="{{ route('admin.routes.destroy', $r->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button class="icon-btn danger" onclick="return confirm('Hapus data ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                            </form>

                                        </div>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        Tidak ada data rute
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            <!-- FOOTER -->
            <div class="card-footer bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">

                    <small class="text-muted">
                        Showing {{ $routes->firstItem() }} - {{ $routes->lastItem() }}
                    </small>

                    {{ $routes->links() }}

                </div>
            </div>

        </div>

    </div>

    <!-- STYLE ENTERPRISE UI -->
    <style>
        .hero-shell {
            padding: 18px;
            border-radius: 16px;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
        }

        .title {
            font-size: 22px;
            font-weight: 700;
        }

        .subtitle {
            font-size: 13px;
            color: #64748b;
            margin: 0;
        }

        .card-modern {
            border-radius: 16px;
            overflow: hidden;
        }

        .table-modern thead {
            background: #5775b4;
            color: #fff;
        }

        .table-modern th {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .6px;
            padding: 14px;
        }

        .table-modern td {
            padding: 14px;
        }

        .row-hover:hover {
            background: #f9fafb;
        }

        .code-chip {
            background: #eef2ff;
            color: #3730a3;
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-status {
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-status.success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-status.danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-status.warning {
            background: #fef3c7;
            color: #92400e;
        }

        .action {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .icon-btn {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e5e7eb;
            background: #fff;
            transition: .2s;
            color: #334155;
        }

        .icon-btn:hover {
            transform: translateY(-2px);
        }

        .icon-btn.primary:hover {
            background: #e0f2fe;
            color: #0284c7;
        }

        .icon-btn.info:hover {
            background: #ecfeff;
            color: #0891b2;
        }

        .icon-btn.danger:hover {
            background: #fee2e2;
            color: #b91c1c;
        }

        .btn-modern {
            box-shadow: 0 10px 25px rgba(59, 130, 246, .25);
            border-radius: 10px;
        }
    </style>
@endsection
