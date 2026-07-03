@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">

        <!-- HERO -->
        <div class="hero-shell mb-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>
                    <h2 class="title">Manajemen Route Stops</h2>
                    <p class="subtitle">Kelola urutan halte dalam setiap rute transportasi</p>
                </div>

                <a href="{{ route('admin.route-stops.create') }}" class="btn btn-primary btn-modern">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Route Stop
                </a>

            </div>

        </div>

        <!-- CARD -->
        <div class="card card-modern border-0 shadow-lg">

            <!-- HEADER -->
            <div class="card-header bg-white border-0 py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <div class="fw-bold">Daftar Route Stops</div>
                        <small class="text-muted">
                            Total {{ $routeStops->total() }} data dalam sistem
                        </small>
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
                                <th>Route</th>
                                <th>Stop</th>
                                <th>Order</th>
                                <th>Distance</th>
                                <th>ETA</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($routeStops as $i => $item)
                                <tr class="row-hover">

                                    <!-- NO -->
                                    <td class="text-muted">
                                        {{ $routeStops->firstItem() + $i }}
                                    </td>

                                    <!-- ROUTE (FIX RELASI DB) -->
                                    <td class="fw-semibold">
                                        {{ $item->route->route_name ?? '-' }}
                                    </td>

                                    <!-- STOP (FIX RELASI DB) -->
                                    <td>
                                        <span class="text-muted">
                                            {{ $item->stop_id }}
                                        </span>
                                    </td>

                                    <!-- ORDER -->
                                    <td>
                                        <span class="code-chip">
                                            #{{ $item->stop_order }}
                                        </span>
                                    </td>

                                    <!-- DISTANCE -->
                                    <td class="text-muted">
                                        {{ $item->distance_from_start_km ?? 0 }} km
                                    </td>

                                    <!-- ETA -->
                                    <td class="text-muted">
                                        {{ $item->estimated_arrival_minutes ?? 0 }} min
                                    </td>

                                    <!-- ACTION -->
                                    <td>
                                        <div class="action">

                                            <a href="{{ route('admin.route-stops.edit', $item->id) }}"
                                                class="icon-btn primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <form action="{{ route('admin.route-stops.destroy', $item->id) }}"
                                                method="POST">

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
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        Tidak ada data route stop
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
                        Showing {{ $routeStops->firstItem() }} - {{ $routeStops->lastItem() }}
                    </small>

                    {{ $routeStops->links() }}

                </div>
            </div>

        </div>

    </div>

    <!-- STYLE -->
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
            background: #6e97f0;
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
