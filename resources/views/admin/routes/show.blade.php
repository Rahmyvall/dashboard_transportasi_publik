@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">

        <!-- HERO HEADER -->
        <div class="hero-header mb-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>
                    <h2 class="fw-bold mb-1">Detail Rute</h2>
                    <p class="text-muted mb-0">Informasi lengkap data transport route system</p>
                </div>

                <a href="{{ route('admin.routes.index') }}" class="btn btn-outline-secondary">
                    ← Kembali
                </a>

            </div>

        </div>

        <!-- MAIN CARD -->
        <div class="card border-0 shadow-lg modern-card">

            <!-- HEADER -->
            <div class="card-header bg-white border-0 py-4">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>
                        <h4 class="fw-bold mb-1">{{ $route->route_name }}</h4>
                        <div class="text-muted small">
                            <i class="bi bi-hash"></i> {{ $route->route_code }}
                        </div>
                    </div>

                    <!-- STATUS BADGE -->
                    <div>
                        @if ($route->status == 'active')
                            <span class="badge-soft success">
                                <i class="bi bi-check-circle me-1"></i> Active
                            </span>
                        @elseif($route->status == 'inactive')
                            <span class="badge-soft danger">
                                <i class="bi bi-x-circle me-1"></i> Inactive
                            </span>
                        @else
                            <span class="badge-soft warning">
                                <i class="bi bi-tools me-1"></i> Maintenance
                            </span>
                        @endif
                    </div>

                </div>

            </div>

            <!-- BODY -->
            <div class="card-body p-4">

                <!-- GRID INFO -->
                <div class="row g-4">

                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="icon"><i class="bi bi-upc-scan"></i></div>
                            <div>
                                <div class="label">Kode Rute</div>
                                <div class="value">{{ $route->route_code }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="icon"><i class="bi bi-signpost-2"></i></div>
                            <div>
                                <div class="label">Nama Rute</div>
                                <div class="value">{{ $route->route_name }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="icon"><i class="bi bi-building"></i></div>
                            <div>
                                <div class="label">Operator</div>
                                <div class="value">{{ $route->operator->operator_name ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="icon"><i class="bi bi-truck"></i></div>
                            <div>
                                <div class="label">Transport Mode</div>
                                <div class="value">{{ $route->transportMode->mode_name ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- ROUTE FLOW -->
                    <div class="col-md-12">
                        <div class="route-flow">

                            <div class="label mb-2">Rute Perjalanan</div>

                            <div class="flow-content">
                                <div class="point start">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <span>{{ $route->origin }}</span>
                                </div>

                                <div class="arrow">→</div>

                                <div class="point end">
                                    <i class="bi bi-flag-fill"></i>
                                    <span>{{ $route->destination }}</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- DISTANCE -->
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="icon"><i class="bi bi-rulers"></i></div>
                            <div>
                                <div class="label">Jarak</div>
                                <div class="value">{{ $route->distance_km ?? '-' }} km</div>
                            </div>
                        </div>
                    </div>

                    <!-- DURATION -->
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="icon"><i class="bi bi-clock"></i></div>
                            <div>
                                <div class="label">Estimasi Durasi</div>
                                <div class="value">{{ $route->estimated_duration_minutes ?? '-' }} menit</div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- STYLE PREMIUM -->
    <style>
        .hero-header {
            padding: 18px;
            border-radius: 18px;
            background: linear-gradient(135deg, #f1f5f9, #eef2ff);
            border: 1px solid #e5e7eb;
        }

        .modern-card {
            border-radius: 20px;
            overflow: hidden;
        }

        /* INFO CARD */
        .info-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            background: #f8fafc;
            border: 1px solid #eef2f7;
            border-radius: 14px;
            transition: .2s;
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        .icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #eef2ff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4f46e5;
            font-size: 18px;
        }

        /* TEXT */
        .label {
            font-size: 12px;
            color: #64748b;
        }

        .value {
            font-size: 15px;
            font-weight: 600;
            color: #0f172a;
        }

        /* ROUTE FLOW */
        .route-flow {
            padding: 18px;
            border-radius: 14px;
            background: linear-gradient(135deg, #eef2ff, #f8fafc);
            border: 1px solid #e5e7eb;
        }

        .flow-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .point {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
        }

        .point.start {
            color: #2563eb;
        }

        .point.end {
            color: #dc2626;
        }

        .arrow {
            font-size: 18px;
            color: #64748b;
        }

        /* BADGE */
        .badge-soft {
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-soft.success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-soft.danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-soft.warning {
            background: #fef3c7;
            color: #92400e;
        }
    </style>
@endsection
