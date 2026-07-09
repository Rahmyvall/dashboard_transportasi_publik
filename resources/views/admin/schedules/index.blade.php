@extends('layouts.app')

@section('content')
    <style>
        .schedule-page {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-soft: #eff6ff;
            --success: #16a34a;
            --warning: #d97706;
            --danger: #dc2626;
            --dark: #0f172a;
            --muted: #64748b;
            --soft: #f8fafc;
            --border: #e2e8f0;

            background: #f6f8fb;
            min-height: 100vh;
            padding: 22px;
        }

        .page-shell {
            max-width: 100%;
            margin: 0 auto;
        }

        .schedule-hero {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            padding: 30px;
            color: #ffffff;
            background:
                radial-gradient(circle at top right, rgba(255, 255, 255, .28), transparent 28%),
                linear-gradient(135deg, #2563eb 0%, #1e40af 60%, #0f172a 100%);
            box-shadow: 0 22px 50px rgba(37, 99, 235, .25);
        }

        .schedule-hero::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            right: -70px;
            bottom: -90px;
            background: rgba(255, 255, 255, .14);
            border-radius: 50%;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .16);
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .hero-title {
            font-size: 28px;
            font-weight: 900;
            letter-spacing: -.7px;
            margin-bottom: 6px;
        }

        .hero-subtitle {
            font-size: 14px;
            color: rgba(255, 255, 255, .78);
            margin: 0;
        }

        .btn-create-modern {
            border: none;
            text-decoration: none;
            background: #ffffff;
            color: var(--primary);
            padding: 13px 18px;
            border-radius: 16px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 9px;
            box-shadow: 0 12px 28px rgba(15, 23, 42, .18);
            transition: .25s ease;
        }

        .btn-create-modern:hover {
            color: var(--primary-dark);
            background: #f8fafc;
            transform: translateY(-2px);
        }

        .stats-grid {
            margin-top: -34px;
            position: relative;
            z-index: 5;
        }

        .stat-card {
            height: 100%;
            background: rgba(255, 255, 255, .92);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, .85);
            border-radius: 22px;
            padding: 20px;
            box-shadow: 0 16px 34px rgba(15, 23, 42, .08);
            transition: .25s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 22px 42px rgba(15, 23, 42, .11);
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
        }

        .stat-title {
            color: var(--muted);
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .icon-blue {
            background: #eff6ff;
            color: #2563eb;
        }

        .icon-green {
            background: #ecfdf5;
            color: #16a34a;
        }

        .icon-yellow {
            background: #fffbeb;
            color: #d97706;
        }

        .icon-red {
            background: #fef2f2;
            color: #dc2626;
        }

        .stat-value {
            color: var(--dark);
            font-size: 32px;
            font-weight: 900;
            line-height: 1;
        }

        .content-card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 26px;
            overflow: hidden;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .07);
        }

        .table-toolbar {
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            border-bottom: 1px solid #eef2f7;
        }

        .toolbar-title {
            font-size: 18px;
            font-weight: 900;
            color: var(--dark);
            margin: 0;
        }

        .toolbar-desc {
            font-size: 13px;
            color: var(--muted);
            margin: 4px 0 0;
        }

        .search-box {
            position: relative;
            min-width: 280px;
        }

        .search-box i {
            position: absolute;
            top: 50%;
            left: 14px;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .search-box input {
            width: 100%;
            height: 44px;
            border: 1px solid var(--border);
            border-radius: 15px;
            padding: 0 14px 0 42px;
            outline: none;
            font-size: 14px;
            transition: .2s ease;
            background: #f8fafc;
        }

        .search-box input:focus {
            background: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .10);
        }

        .modern-table {
            margin: 0;
            min-width: 920px;
        }

        .modern-table thead th {
            background: #f8fafc;
            color: #64748b;
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .4px;
            padding: 16px 18px;
            border-bottom: 1px solid #eef2f7;
            white-space: nowrap;
        }

        .modern-table tbody td {
            padding: 18px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .modern-table tbody tr {
            transition: .22s ease;
        }

        .modern-table tbody tr:hover {
            background: #f8fbff;
        }

        .route-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .route-icon {
            width: 44px;
            height: 44px;
            border-radius: 16px;
            background: var(--primary-soft);
            color: var(--primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .route-code {
            color: var(--dark);
            font-size: 15px;
            font-weight: 900;
            margin-bottom: 2px;
        }

        .route-name {
            color: var(--muted);
            font-size: 13px;
            font-weight: 600;
        }

        .driver-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .driver-avatar {
            width: 38px;
            height: 38px;
            border-radius: 14px;
            background: #f1f5f9;
            color: #334155;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
        }

        .driver-name {
            color: var(--dark);
            font-weight: 800;
            font-size: 14px;
        }

        .soft-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 999px;
            padding: 8px 12px;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .2px;
            white-space: nowrap;
        }

        .badge-blue {
            background: #eff6ff;
            color: #2563eb;
        }

        .badge-green {
            background: #ecfdf5;
            color: #16a34a;
        }

        .badge-yellow {
            background: #fffbeb;
            color: #d97706;
        }

        .badge-red {
            background: #fef2f2;
            color: #dc2626;
        }

        .time-box {
            color: var(--dark);
            font-weight: 900;
            white-space: nowrap;
        }

        .time-box small {
            display: block;
            color: var(--muted);
            font-size: 11px;
            font-weight: 700;
            margin-top: 2px;
        }

        .headway-pill {
            padding: 8px 11px;
            border-radius: 12px;
            background: #f8fafc;
            color: #334155;
            font-size: 13px;
            font-weight: 800;
            border: 1px solid #eef2f7;
            white-space: nowrap;
        }

        .action-group {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .action-btn-modern {
            width: 39px;
            height: 39px;
            border-radius: 13px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid transparent;
            transition: .22s ease;
            text-decoration: none;
            background: #f8fafc;
        }

        .action-btn-modern:hover {
            transform: translateY(-2px);
        }

        .btn-edit {
            color: #d97706;
            background: #fffbeb;
            border-color: #fde68a;
        }

        .btn-delete {
            color: #dc2626;
            background: #fef2f2;
            border-color: #fecaca;
        }

        .empty-state {
            padding: 64px 20px;
            text-align: center;
        }

        .empty-icon {
            width: 76px;
            height: 76px;
            border-radius: 24px;
            background: #f8fafc;
            color: #94a3b8;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            margin-bottom: 16px;
        }

        .empty-title {
            font-size: 18px;
            font-weight: 900;
            color: var(--dark);
            margin-bottom: 4px;
        }

        .empty-text {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 18px;
        }

        .pagination-wrap {
            padding: 18px 20px;
            border-top: 1px solid #eef2f7;
        }

        @media (max-width: 768px) {
            .schedule-page {
                padding: 14px;
            }

            .schedule-hero {
                padding: 24px;
            }

            .hero-title {
                font-size: 23px;
            }

            .hero-actions {
                margin-top: 18px;
            }

            .btn-create-modern {
                width: 100%;
                justify-content: center;
            }

            .table-toolbar {
                flex-direction: column;
                align-items: stretch;
            }

            .search-box {
                min-width: 100%;
            }

            .stats-grid {
                margin-top: 18px;
            }
        }
    </style>

    @php
        $scheduleItems =
            $schedules instanceof \Illuminate\Pagination\AbstractPaginator
                ? $schedules->getCollection()
                : collect($schedules);

        $totalSchedule = $scheduleItems->count();
        $activeSchedule = $scheduleItems->where('is_active', 1)->count();
        $weekdaySchedule = $scheduleItems->where('day_type', 'weekday')->count();
        $holidaySchedule = $scheduleItems->where('day_type', 'holiday')->count();
    @endphp

    <div class="schedule-page">
        <div class="page-shell">

            <div class="schedule-hero mb-4">
                <div class="hero-content">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="hero-label">
                                <i class="ri-calendar-schedule-line"></i>
                                Operational Schedule
                            </div>

                            <h3 class="hero-title">
                                Schedule Management
                            </h3>

                            <p class="hero-subtitle">
                                Manage route, vehicle, driver, day type, time, and operational status in one dashboard.
                            </p>
                        </div>

                        <div class="col-lg-4 text-lg-end hero-actions">
                            <a href="{{ route('admin.schedules.create') }}" class="btn-create-modern">
                                <i class="ri-add-line"></i>
                                New Schedule
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-4 stats-grid">
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-top">
                            <div class="stat-title">Total Schedule</div>
                            <div class="stat-icon icon-blue">
                                <i class="ri-calendar-2-line"></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ $totalSchedule }}</div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-top">
                            <div class="stat-title">Active</div>
                            <div class="stat-icon icon-green">
                                <i class="ri-checkbox-circle-line"></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ $activeSchedule }}</div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-top">
                            <div class="stat-title">Weekday</div>
                            <div class="stat-icon icon-yellow">
                                <i class="ri-sun-line"></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ $weekdaySchedule }}</div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                        <div class="stat-top">
                            <div class="stat-title">Holiday</div>
                            <div class="stat-icon icon-red">
                                <i class="ri-calendar-event-line"></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ $holidaySchedule }}</div>
                    </div>
                </div>
            </div>

            <div class="content-card">
                <div class="table-toolbar">
                    <div>
                        <h5 class="toolbar-title">Schedule List</h5>
                        <p class="toolbar-desc">
                            View and manage all operational schedules.
                        </p>
                    </div>

                    <div class="search-box">
                        <i class="ri-search-line"></i>
                        <input type="text" id="scheduleSearch" placeholder="Search route, vehicle, driver...">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table modern-table">
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
                            @forelse($scheduleItems as $s)
                                @php
                                    $driverName = $s->driver->driver_name ?? ($s->driver->name ?? '-');

                                    $dayClass = match ($s->day_type) {
                                        'weekday' => 'badge-blue',
                                        'weekend' => 'badge-yellow',
                                        'holiday' => 'badge-red',
                                        default => 'badge-green',
                                    };
                                @endphp

                                <tr data-schedule-row>
                                    <td>
                                        <div class="route-wrap">
                                            <div class="route-icon">
                                                <i class="ri-route-line"></i>
                                            </div>

                                            <div>
                                                <div class="route-code">
                                                    {{ $s->route->route_code ?? '-' }}
                                                </div>
                                                <div class="route-name">
                                                    {{ $s->route->route_name ?? '-' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="soft-badge badge-blue">
                                            <i class="ri-bus-line"></i>
                                            {{ $s->vehicle->plate_number ?? '-' }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="driver-wrap">
                                            <div class="driver-avatar">
                                                {{ strtoupper(substr($driverName, 0, 1)) }}
                                            </div>

                                            <div class="driver-name">
                                                {{ $driverName }}
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="soft-badge {{ $dayClass }}">
                                            <i class="ri-calendar-check-line"></i>
                                            {{ strtoupper($s->day_type ?? '-') }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="time-box">
                                            {{ $s->start_time ?? '-' }} - {{ $s->end_time ?? '-' }}
                                            <small>Start to end</small>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="headway-pill">
                                            {{ $s->headway_minutes ?? 0 }} min
                                        </span>
                                    </td>

                                    <td>
                                        @if ($s->is_active)
                                            <span class="soft-badge badge-green">
                                                <i class="ri-checkbox-circle-line"></i>
                                                ACTIVE
                                            </span>
                                        @else
                                            <span class="soft-badge badge-red">
                                                <i class="ri-close-circle-line"></i>
                                                INACTIVE
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="action-group">
                                            <a href="{{ route('admin.schedules.edit', $s->id) }}"
                                                class="action-btn-modern btn-edit" title="Edit">
                                                <i class="ri-edit-line"></i>
                                            </a>

                                            <form action="{{ route('admin.schedules.destroy', $s->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" onclick="return confirm('Delete this schedule?')"
                                                    class="action-btn-modern btn-delete" title="Delete">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="ri-calendar-close-line"></i>
                                            </div>

                                            <div class="empty-title">
                                                No schedule available
                                            </div>

                                            <div class="empty-text">
                                                Create your first operational schedule to start managing routes.
                                            </div>

                                            <a href="{{ route('admin.schedules.create') }}" class="btn-create-modern">
                                                <i class="ri-add-line"></i>
                                                New Schedule
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if (method_exists($schedules, 'links'))
                    <div class="pagination-wrap">
                        {{ $schedules->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('scheduleSearch');
            const rows = document.querySelectorAll('[data-schedule-row]');

            if (!searchInput) {
                return;
            }

            searchInput.addEventListener('keyup', function() {
                const keyword = this.value.toLowerCase();

                rows.forEach(function(row) {
                    const text = row.innerText.toLowerCase();
                    row.style.display = text.includes(keyword) ? '' : 'none';
                });
            });
        });
    </script>
@endsection
