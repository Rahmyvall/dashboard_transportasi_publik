@extends('layouts.app')

@section('content')
    <style>
        .schedule-wrapper {
            --primary: #2563eb;
            --soft: #eff6ff;
            --dark: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
        }

        .schedule-header {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: #fff;
            border-radius: 18px;
            padding: 22px;
            box-shadow: 0 10px 25px rgba(37, 99, 235, .25);
        }

        .btn-add {
            background: #fff;
            color: #1e40af;
            border-radius: 12px;
            padding: 10px 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: none;
        }

        .table-card {
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(15, 23, 42, .06);
        }

        .table thead th {
            background: #0f172a;
            color: #fff;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .5px;
            border: none;
        }

        .table tbody td {
            vertical-align: middle;
            border-color: #f1f5f9;
            color: #334155;
        }

        .badge-soft {
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .soft-primary {
            background: #eff6ff;
            color: #2563eb;
        }

        .soft-warning {
            background: #fffbeb;
            color: #d97706;
        }

        .soft-danger {
            background: #fef2f2;
            color: #dc2626;
        }

        .soft-success {
            background: #ecfdf5;
            color: #16a34a;
        }

        .action-btn {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .route-code {
            font-weight: 700;
            color: #0f172a;
        }

        .route-name {
            font-size: 12px;
            color: #64748b;
        }
    </style>

    <div class="schedule-wrapper container-fluid">

        <!-- HEADER -->
        <div class="schedule-header d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="mb-1 fw-bold">Schedule Management</h4>
                <small class="opacity-75">Kelola jadwal operasional rute & driver</small>
            </div>

            <a href="{{ route('admin.schedules.create') }}" class="btn-add">
                <i class="ri-add-line"></i>
                Tambah
            </a>

        </div>

        <!-- TABLE -->
        <div class="table-card card">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover mb-0">

                        <thead>
                            <tr>
                                <th>Route</th>
                                <th>Vehicle</th>
                                <th>Driver</th>
                                <th>Day</th>
                                <th>Time</th>
                                <th>Headway</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($schedules as $s)
                                <tr>

                                    <!-- ROUTE (FIX: route_code + route_name) -->
                                    <td>
                                        <div class="route-code">
                                            {{ $s->route->route_code ?? '-' }}
                                        </div>
                                        <div class="route-name">
                                            {{ $s->route->route_name ?? '-' }}
                                        </div>
                                    </td>

                                    <!-- VEHICLE -->
                                    <td>
                                        <span class="badge-soft soft-primary">
                                            {{ $s->vehicle->plate_number ?? '-' }}
                                        </span>
                                    </td>

                                    <!-- DRIVER -->
                                    <td>
                                        {{ $s->driver->driver_name ?? ($s->driver->name ?? '-') }}
                                    </td>

                                    <!-- DAY TYPE -->
                                    <td>
                                        @php
                                            $type = match ($s->day_type) {
                                                'weekday' => 'soft-primary',
                                                'weekend' => 'soft-warning',
                                                'holiday' => 'soft-danger',
                                                default => 'soft-success',
                                            };
                                        @endphp

                                        <span class="badge-soft {{ $type }}">
                                            {{ strtoupper($s->day_type) }}
                                        </span>
                                    </td>

                                    <!-- TIME -->
                                    <td class="fw-semibold">
                                        {{ $s->start_time }} - {{ $s->end_time }}
                                    </td>

                                    <!-- HEADWAY -->
                                    <td>
                                        {{ $s->headway_minutes ?? '-' }} min
                                    </td>

                                    <!-- STATUS -->
                                    <td>
                                        @if ($s->is_active)
                                            <span class="badge-soft soft-success">ACTIVE</span>
                                        @else
                                            <span class="badge-soft soft-danger">INACTIVE</span>
                                        @endif
                                    </td>

                                    <!-- ACTION -->
                                    <td class="text-center">

                                        <a href="{{ route('admin.schedules.edit', $s->id) }}"
                                            class="btn btn-outline-warning action-btn" title="Edit">
                                            <i class="ri-edit-line"></i>
                                        </a>

                                        <form action="{{ route('admin.schedules.destroy', $s->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-outline-danger action-btn"
                                                onclick="return confirm('Hapus schedule ini?')" title="Delete">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="ri-inbox-line fs-3 d-block mb-2"></i>
                                        Tidak ada schedule
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
