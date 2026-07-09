@extends('layouts.app')

@section('content')
     <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

     @php
          $formatDateTime = function ($value) {
              return $value ? \Carbon\Carbon::parse($value)->format('d M Y, H:i') : '-';
          };

          $items = method_exists($trips, 'getCollection') ? $trips->getCollection() : collect($trips);

          $totalHistory = method_exists($trips, 'total') ? $trips->total() : $items->count();
          $totalCompleted = $items->where('status', 'completed')->count();
          $totalCancelled = $items->where('status', 'cancelled')->count();
          $totalDelayedHistory = $items->where('delay_minutes', '>', 0)->count();
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
               background: linear-gradient(135deg, #111827, #475569);
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
               color: #334155;
               border: 0;
               border-radius: 14px;
               padding: 11px 18px;
               font-weight: 700;
               text-decoration: none;
               box-shadow: 0 10px 24px rgba(15, 23, 42, .16);
          }

          .btn-hero:hover {
               background: #f8fafc;
               color: #0f172a;
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

          .icon-slate {
               background: #e2e8f0;
               color: #334155;
          }

          .icon-green {
               background: #dcfce7;
               color: #166534;
          }

          .icon-red {
               background: #fee2e2;
               color: #991b1b;
          }

          .icon-orange {
               background: #ffedd5;
               color: #c2410c;
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
               background: #f1f5f9;
               color: #334155;
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

          .status-pill {
               display: inline-flex;
               align-items: center;
               gap: 6px;
               border-radius: 999px;
               padding: 7px 12px;
               font-size: 12px;
               font-weight: 800;
          }

          .status-completed {
               background: #dcfce7;
               color: #166534;
          }

          .status-cancelled {
               background: #fee2e2;
               color: #991b1b;
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
               background: #ffedd5;
               color: #c2410c;
          }

          .delay-normal {
               background: #f1f5f9;
               color: #64748b;
          }

          .notes-preview {
               max-width: 220px;
               white-space: normal;
               color: #475569;
               font-size: 13px;
               line-height: 1.45;
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
                                   <i class="bi bi-clock-history me-2"></i>
                                   Trip History
                              </div>

                              <p class="hero-subtitle">
                                   Riwayat trip yang sudah completed atau cancelled.
                              </p>
                         </div>

                         <div class="d-flex flex-wrap gap-2">
                              <a href="{{ route('admin.trips.index') }}" class="btn-hero">
                                   <i class="bi bi-list-ul me-1"></i>
                                   Semua Trip
                              </a>

                              <a href="{{ route('admin.trips.active') }}" class="btn-hero">
                                   <i class="bi bi-activity me-1"></i>
                                   Active Trips
                              </a>
                         </div>

                    </div>

               </div>
          </div>

          <div class="row g-3 mb-4">

               <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                         <div class="stat-wrap">
                              <div class="stat-icon icon-slate">
                                   <i class="bi bi-archive"></i>
                              </div>
                              <div>
                                   <div class="stat-label">Total History</div>
                                   <div class="stat-value">{{ $totalHistory }}</div>
                              </div>
                         </div>
                    </div>
               </div>

               <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                         <div class="stat-wrap">
                              <div class="stat-icon icon-green">
                                   <i class="bi bi-check-circle"></i>
                              </div>
                              <div>
                                   <div class="stat-label">Completed</div>
                                   <div class="stat-value">{{ $totalCompleted }}</div>
                              </div>
                         </div>
                    </div>
               </div>

               <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                         <div class="stat-wrap">
                              <div class="stat-icon icon-red">
                                   <i class="bi bi-x-circle"></i>
                              </div>
                              <div>
                                   <div class="stat-label">Cancelled</div>
                                   <div class="stat-value">{{ $totalCancelled }}</div>
                              </div>
                         </div>
                    </div>
               </div>

               <div class="col-xl-3 col-md-6">
                    <div class="stat-card">
                         <div class="stat-wrap">
                              <div class="stat-icon icon-orange">
                                   <i class="bi bi-clock"></i>
                              </div>
                              <div>
                                   <div class="stat-label">With Delay</div>
                                   <div class="stat-value">{{ $totalDelayedHistory }}</div>
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
                              Daftar Trip History
                         </div>

                         <p class="table-subtitle">
                              Data perjalanan yang sudah selesai atau dibatalkan.
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
                                   <th>Planned Start</th>
                                   <th>Planned End</th>
                                   <th>Actual Start</th>
                                   <th>Actual End</th>
                                   <th>Status</th>
                                   <th>Delay</th>
                                   <th>Notes</th>
                                   <th width="90">Action</th>
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

                                        $statusClass =
                                            [
                                                'completed' => 'status-completed',
                                                'cancelled' => 'status-cancelled',
                                            ][$trip->status] ?? 'status-default';

                                        $statusIcon =
                                            [
                                                'completed' => 'bi-check-circle',
                                                'cancelled' => 'bi-x-circle',
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
                                                  ID: {{ $trip->route_id }}
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
                                             <div class="main-text">
                                                  {{ $driverName }}
                                             </div>

                                             <div class="sub-text">
                                                  ID: {{ $trip->driver_id ?? '-' }}
                                             </div>
                                        </td>

                                        <td>
                                             <div class="main-text">
                                                  {{ $formatDateTime($trip->planned_start_time) }}
                                             </div>
                                        </td>

                                        <td>
                                             <div class="main-text">
                                                  {{ $formatDateTime($trip->planned_end_time) }}
                                             </div>
                                        </td>

                                        <td>
                                             <div class="main-text">
                                                  {{ $formatDateTime($trip->actual_start_time) }}
                                             </div>
                                        </td>

                                        <td>
                                             <div class="main-text">
                                                  {{ $formatDateTime($trip->actual_end_time) }}
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
                                             <div class="notes-preview" title="{{ $trip->notes }}">
                                                  {{ $trip->notes ? \Illuminate\Support\Str::limit($trip->notes, 70) : '-' }}
                                             </div>
                                        </td>

                                        <td>
                                             <div class="action-group">
                                                  <a href="{{ route('admin.trips.show', $trip->id) }}"
                                                       class="action-btn action-view" title="Detail">
                                                       <i class="bi bi-eye"></i>
                                                  </a>
                                             </div>
                                        </td>

                                   </tr>

                              @empty

                                   <tr>
                                        <td colspan="13">
                                             <div class="empty-box">
                                                  <div class="fs-1 mb-2">
                                                       <i class="bi bi-archive"></i>
                                                  </div>

                                                  <div class="fw-bold text-dark">
                                                       Belum ada trip history
                                                  </div>

                                                  <div>
                                                       Data completed atau cancelled belum tersedia.
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
@endsection
