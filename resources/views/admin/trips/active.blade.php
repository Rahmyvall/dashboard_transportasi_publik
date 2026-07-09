@extends('layouts.app')

@section('content')
     <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

     @php
          $formatDateTime = function ($value) {
              return $value ? \Carbon\Carbon::parse($value)->format('d M Y, H:i') : '-';
          };

          $items = method_exists($trips, 'getCollection') ? $trips->getCollection() : collect($trips);

          $totalActive = method_exists($trips, 'total') ? $trips->total() : $items->count();
          $totalScheduled = $items->where('status', 'scheduled')->count();
          $totalRunning = $items->where('status', 'running')->count();
          $totalDelayed = $items->where('status', 'delayed')->count();
     @endphp

     <style>
          body {
               background: #f4f7fb;
          }

          .trip-page {
               padding: 24px;
          }

          .hero-card {
               border: 0;
               border-radius: 24px;
               background: linear-gradient(135deg, #0f172a, #2563eb);
               color: #fff;
               overflow: hidden;
               position: relative;
               box-shadow: 0 18px 45px rgba(15, 23, 42, .18);
          }

          .hero-card::after {
               content: "";
               width: 260px;
               height: 260px;
               position: absolute;
               right: -90px;
               top: -90px;
               border-radius: 50%;
               background: rgba(255, 255, 255, .14);
          }

          .hero-content {
               position: relative;
               z-index: 2;
               padding: 28px;
          }

          .hero-title {
               font-size: 26px;
               font-weight: 800;
               margin-bottom: 6px;
          }

          .hero-subtitle {
               font-size: 14px;
               color: rgba(255, 255, 255, .82);
               margin-bottom: 0;
          }

          .btn-hero {
               background: #fff;
               color: #1d4ed8;
               border: 0;
               border-radius: 14px;
               padding: 11px 18px;
               font-weight: 700;
               text-decoration: none;
               box-shadow: 0 10px 24px rgba(15, 23, 42, .16);
          }

          .btn-hero:hover {
               background: #eff6ff;
               color: #1e40af;
          }

          .stat-card {
               border: 0;
               border-radius: 20px;
               background: #fff;
               box-shadow: 0 10px 30px rgba(15, 23, 42, .07);
               padding: 20px;
               height: 100%;
          }

          .stat-wrap {
               display: flex;
               align-items: center;
               gap: 14px;
          }

          .stat-icon {
               width: 46px;
               height: 46px;
               border-radius: 16px;
               display: flex;
               align-items: center;
               justify-content: center;
               font-size: 22px;
          }

          .icon-blue {
               background: #dbeafe;
               color: #1d4ed8;
          }

          .icon-yellow {
               background: #fef3c7;
               color: #92400e;
          }

          .icon-green {
               background: #dcfce7;
               color: #166534;
          }

          .icon-red {
               background: #fee2e2;
               color: #991b1b;
          }

          .stat-label {
               font-size: 13px;
               color: #64748b;
          }

          .stat-value {
               font-size: 24px;
               font-weight: 800;
               color: #0f172a;
               line-height: 1.1;
          }

          .table-card {
               border: 0;
               border-radius: 24px;
               overflow: hidden;
               background: #fff;
               box-shadow: 0 12px 34px rgba(15, 23, 42, .08);
          }

          .table-header {
               padding: 20px 24px;
               border-bottom: 1px solid #e5e7eb;
               display: flex;
               justify-content: space-between;
               align-items: center;
               gap: 16px;
               flex-wrap: wrap;
          }

          .table-title {
               font-size: 18px;
               font-weight: 800;
               color: #0f172a;
               margin-bottom: 2px;
          }

          .table-subtitle {
               font-size: 13px;
               color: #64748b;
               margin-bottom: 0;
          }

          .modern-table {
               margin-bottom: 0;
          }

          .modern-table thead th {
               background: #f8fafc;
               color: #475569;
               font-size: 12px;
               font-weight: 800;
               text-transform: uppercase;
               letter-spacing: .04em;
               border-bottom: 1px solid #e5e7eb;
               padding: 15px 16px;
               white-space: nowrap;
          }

          .modern-table tbody td {
               padding: 16px;
               color: #334155;
               font-size: 14px;
               vertical-align: middle;
               border-bottom: 1px solid #f1f5f9;
               white-space: nowrap;
          }

          .modern-table tbody tr:hover {
               background: #f8fafc;
          }

          .trip-code {
               display: inline-flex;
               align-items: center;
               gap: 7px;
               background: #eff6ff;
               color: #1d4ed8;
               padding: 8px 11px;
               border-radius: 12px;
               font-weight: 800;
          }

          .main-text {
               color: #0f172a;
               font-weight: 700;
               margin-bottom: 2px;
          }

          .sub-text {
               color: #64748b;
               font-size: 12px;
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
               background: #dbeafe;
               color: #1d4ed8;
               display: flex;
               align-items: center;
               justify-content: center;
               font-weight: 800;
          }

          .status-pill {
               display: inline-flex;
               align-items: center;
               gap: 6px;
               border-radius: 999px;
               padding: 7px 12px;
               font-size: 12px;
               font-weight: 800;
          }

          .status-scheduled {
               background: #dbeafe;
               color: #1d4ed8;
          }

          .status-running {
               background: #fef3c7;
               color: #92400e;
          }

          .status-delayed {
               background: #ffedd5;
               color: #c2410c;
          }

          .status-default {
               background: #e2e8f0;
               color: #334155;
          }

          .delay-badge {
               display: inline-flex;
               align-items: center;
               gap: 6px;
               padding: 7px 11px;
               border-radius: 999px;
               font-size: 12px;
               font-weight: 800;
               background: #fee2e2;
               color: #991b1b;
          }

          .delay-normal {
               background: #f1f5f9;
               color: #64748b;
          }

          .action-group {
               display: flex;
               align-items: center;
               gap: 7px;
          }

          .action-btn {
               width: 36px;
               height: 36px;
               border-radius: 12px;
               display: inline-flex;
               align-items: center;
               justify-content: center;
               border: 0;
               text-decoration: none;
               transition: .2s;
          }

          .action-btn:hover {
               transform: translateY(-2px);
          }

          .action-view {
               background: #e0f2fe;
               color: #0369a1;
          }

          .action-edit {
               background: #fef3c7;
               color: #92400e;
          }

          .action-start {
               background: #dcfce7;
               color: #166534;
          }

          .action-finish {
               background: #ede9fe;
               color: #5b21b6;
          }

          .action-cancel {
               background: #fee2e2;
               color: #991b1b;
          }

          .empty-box {
               padding: 64px 20px;
               text-align: center;
               color: #64748b;
          }

          .pagination-area {
               padding: 18px 24px;
               border-top: 1px solid #e5e7eb;
          }
     </style>

     <div class="trip-page">

          <div class="hero-card mb-4">
               <div class="hero-content">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                         <div>
                              <div class="hero-title">
                                   <i class="bi bi-activity me-2"></i>
                                   Active Trips
                              </div>

                              <p class="hero-subtitle">
                                   Monitoring trip yang masih scheduled, running, atau delayed.
                              </p>
                         </div>

                         <div class="d-flex flex-wrap gap-2">
                              <a href="{{ route('admin.trips.index') }}" class="btn-hero">
                                   <i class="bi bi-list-ul me-1"></i>
                                   Semua Trip
                              </a>

                              <a href="{{ route('admin.trips.create') }}" class="btn-hero">
                                   <i class="bi bi-plus-circle me-1"></i>
                                   Tambah Trip
                              </a>
                         </div>

                    </div>

               </div>
          </div>

          <div class="row g-3 mb-4">

               <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                         <div class="stat-wrap">
                              <div class="stat-icon icon-blue">
                                   <i class="bi bi-map"></i>
                              </div>
                              <div>
                                   <div class="stat-label">Active Trips</div>
                                   <div class="stat-value">{{ $totalActive }}</div>
                              </div>
                         </div>
                    </div>
               </div>

               <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                         <div class="stat-wrap">
                              <div class="stat-icon icon-blue">
                                   <i class="bi bi-calendar-check"></i>
                              </div>
                              <div>
                                   <div class="stat-label">Scheduled</div>
                                   <div class="stat-value">{{ $totalScheduled }}</div>
                              </div>
                         </div>
                    </div>
               </div>

               <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                         <div class="stat-wrap">
                              <div class="stat-icon icon-yellow">
                                   <i class="bi bi-play-circle"></i>
                              </div>
                              <div>
                                   <div class="stat-label">Running</div>
                                   <div class="stat-value">{{ $totalRunning }}</div>
                              </div>
                         </div>
                    </div>
               </div>

               <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                         <div class="stat-wrap">
                              <div class="stat-icon icon-red">
                                   <i class="bi bi-exclamation-triangle"></i>
                              </div>
                              <div>
                                   <div class="stat-label">Delayed</div>
                                   <div class="stat-value">{{ $totalDelayed }}</div>
                              </div>
                         </div>
                    </div>
               </div>

          </div>

          @if (session('success'))
               <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    {{ session('success') }}
               </div>
          @endif

          @if (session('error'))
               <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                    {{ session('error') }}
               </div>
          @endif

          <div class="table-card">

               <div class="table-header">
                    <div>
                         <div class="table-title">
                              Daftar Active Trips
                         </div>

                         <p class="table-subtitle">
                              Data trip yang masih berjalan, terjadwal, atau terlambat.
                         </p>
                    </div>
               </div>

               <div class="table-responsive">

                    <table class="table modern-table align-middle">

                         <thead>
                              <tr>
                                   <th>No</th>
                                   <th>Trip Code</th>
                                   <th>Route</th>
                                   <th>Vehicle</th>
                                   <th>Driver</th>
                                   <th>Planned Time</th>
                                   <th>Actual Start</th>
                                   <th>Status</th>
                                   <th>Delay</th>
                                   <th width="210">Action</th>
                              </tr>
                         </thead>

                         <tbody>

                              @forelse($trips as $trip)
                                   @php
                                        $routeName =
                                            data_get($trip, 'route.name') ??
                                            (data_get($trip, 'route.route_name') ??
                                                (data_get($trip, 'route.route_code') ??
                                                    'Route ID: ' . $trip->route_id));

                                        $routeStart =
                                            data_get($trip, 'route.start_location') ??
                                            (data_get($trip, 'route.origin') ??
                                                (data_get($trip, 'route.from_location') ?? null));

                                        $routeEnd =
                                            data_get($trip, 'route.end_location') ??
                                            (data_get($trip, 'route.destination') ??
                                                (data_get($trip, 'route.to_location') ?? null));

                                        $vehicleName =
                                            data_get($trip, 'vehicle.vehicle_number') ??
                                            (data_get($trip, 'vehicle.plate_number') ??
                                                (data_get($trip, 'vehicle.license_plate') ??
                                                    (data_get($trip, 'vehicle.police_number') ??
                                                        (data_get($trip, 'vehicle.name') ??
                                                            'Vehicle ID: ' . $trip->vehicle_id))));

                                        $driverName =
                                            data_get($trip, 'driver.name') ??
                                            (data_get($trip, 'driver.driver_name') ??
                                                (data_get($trip, 'driver.full_name') ??
                                                    ($trip->driver_id
                                                        ? 'Driver ID: ' . $trip->driver_id
                                                        : 'Belum ada driver')));

                                        $driverPhone =
                                            data_get($trip, 'driver.phone') ??
                                            (data_get($trip, 'driver.phone_number') ??
                                                (data_get($trip, 'driver.no_hp') ?? null));

                                        $statusClass =
                                            [
                                                'scheduled' => 'status-scheduled',
                                                'running' => 'status-running',
                                                'delayed' => 'status-delayed',
                                            ][$trip->status] ?? 'status-default';

                                        $statusIcon =
                                            [
                                                'scheduled' => 'bi-calendar-check',
                                                'running' => 'bi-play-circle',
                                                'delayed' => 'bi-exclamation-circle',
                                            ][$trip->status] ?? 'bi-circle';
                                   @endphp

                                   <tr>

                                        <td>
                                             {{ method_exists($trips, 'firstItem') ? $trips->firstItem() + $loop->index : $loop->iteration }}
                                        </td>

                                        <td>
                                             <span class="trip-code">
                                                  <i class="bi bi-ticket-perforated"></i>
                                                  {{ $trip->trip_code }}
                                             </span>
                                        </td>

                                        <td>
                                             <div class="main-text">
                                                  <i class="bi bi-signpost-2 text-primary me-1"></i>
                                                  {{ $routeName }}
                                             </div>

                                             <div class="sub-text">
                                                  @if ($routeStart || $routeEnd)
                                                       {{ $routeStart ?? '-' }} ke {{ $routeEnd ?? '-' }}
                                                  @else
                                                       ID: {{ $trip->route_id }}
                                                  @endif
                                             </div>
                                        </td>

                                        <td>
                                             <div class="main-text">
                                                  <i class="bi bi-truck-front text-primary me-1"></i>
                                                  {{ $vehicleName }}
                                             </div>

                                             <div class="sub-text">
                                                  ID: {{ $trip->vehicle_id }}
                                             </div>
                                        </td>

                                        <td>
                                             <div class="driver-wrap">
                                                  <div class="driver-avatar">
                                                       {{ strtoupper(substr($driverName, 0, 1)) }}
                                                  </div>

                                                  <div>
                                                       <div class="main-text">
                                                            {{ $driverName }}
                                                       </div>

                                                       <div class="sub-text">
                                                            {{ $driverPhone ?? 'ID: ' . ($trip->driver_id ?? '-') }}
                                                       </div>
                                                  </div>
                                             </div>
                                        </td>

                                        <td>
                                             <div class="main-text">
                                                  {{ $formatDateTime($trip->planned_start_time) }}
                                             </div>

                                             <div class="sub-text">
                                                  End: {{ $formatDateTime($trip->planned_end_time) }}
                                             </div>
                                        </td>

                                        <td>
                                             <div class="main-text">
                                                  {{ $formatDateTime($trip->actual_start_time) }}
                                             </div>
                                        </td>

                                        <td>
                                             <span class="status-pill {{ $statusClass }}">
                                                  <i class="bi {{ $statusIcon }}"></i>
                                                  {{ ucfirst($trip->status) }}
                                             </span>
                                        </td>

                                        <td>
                                             @if ($trip->delay_minutes > 0)
                                                  <span class="delay-badge">
                                                       <i class="bi bi-clock"></i>
                                                       {{ $trip->delay_minutes }} menit
                                                  </span>
                                             @else
                                                  <span class="delay-badge delay-normal">
                                                       <i class="bi bi-check2"></i>
                                                       0 menit
                                                  </span>
                                             @endif
                                        </td>

                                        <td>
                                             <div class="action-group">

                                                  <a href="{{ route('admin.trips.show', $trip->id) }}"
                                                       class="action-btn action-view" title="Detail">
                                                       <i class="bi bi-eye"></i>
                                                  </a>

                                                  <a href="{{ route('admin.trips.edit', $trip->id) }}"
                                                       class="action-btn action-edit" title="Edit">
                                                       <i class="bi bi-pencil-square"></i>
                                                  </a>

                                                  @if ($trip->status === 'scheduled')
                                                       <form action="{{ route('admin.trips.start', $trip->id) }}"
                                                            method="POST" class="d-inline">

                                                            @csrf
                                                            @method('PATCH')

                                                            <button type="button"
                                                                 onclick="confirmAction(this, 'Mulai trip ini?')"
                                                                 class="action-btn action-start" title="Start">
                                                                 <i class="bi bi-play-fill"></i>
                                                            </button>

                                                       </form>
                                                  @endif

                                                  @if (in_array($trip->status, ['running', 'delayed']))
                                                       <form action="{{ route('admin.trips.complete', $trip->id) }}"
                                                            method="POST" class="d-inline">

                                                            @csrf
                                                            @method('PATCH')

                                                            <button type="button"
                                                                 onclick="confirmAction(this, 'Selesaikan trip ini?')"
                                                                 class="action-btn action-finish" title="Complete">
                                                                 <i class="bi bi-check2-circle"></i>
                                                            </button>

                                                       </form>
                                                  @endif

                                                  @if (in_array($trip->status, ['scheduled', 'running', 'delayed']))
                                                       <form action="{{ route('admin.trips.cancel', $trip->id) }}"
                                                            method="POST" class="d-inline">

                                                            @csrf
                                                            @method('PATCH')

                                                            <button type="button"
                                                                 onclick="confirmAction(this, 'Batalkan trip ini?')"
                                                                 class="action-btn action-cancel" title="Cancel">
                                                                 <i class="bi bi-x-circle"></i>
                                                            </button>

                                                       </form>
                                                  @endif

                                             </div>
                                        </td>

                                   </tr>

                              @empty

                                   <tr>
                                        <td colspan="10">
                                             <div class="empty-box">
                                                  <div class="fs-1 mb-2">
                                                       <i class="bi bi-folder2-open"></i>
                                                  </div>

                                                  <div class="fw-bold text-dark">
                                                       Tidak ada active trip
                                                  </div>

                                                  <div>
                                                       Data scheduled, running, atau delayed belum tersedia.
                                                  </div>
                                             </div>
                                        </td>
                                   </tr>
                              @endforelse

                         </tbody>

                    </table>

               </div>

               <div class="pagination-area">
                    {{ $trips->links() }}
               </div>

          </div>

     </div>

     <script>
          function confirmAction(button, message) {
               if (confirm(message)) {
                    button.closest('form').submit();
               }
          }
     </script>
@endsection
