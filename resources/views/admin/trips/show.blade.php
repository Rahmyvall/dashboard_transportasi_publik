@extends('layouts.app')

@section('content')
     <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

     @php
          $formatDateTime = function ($value) {
              return $value ? \Carbon\Carbon::parse($value)->format('d M Y, H:i') : '-';
          };

          $scheduleName =
              data_get($trip, 'schedule.name') ??
              (data_get($trip, 'schedule.schedule_name') ??
                  (data_get($trip, 'schedule.schedule_code') ??
                      (data_get($trip, 'schedule.code') ??
                          ($trip->schedule_id ? 'Schedule ID: ' . $trip->schedule_id : '-'))));

          $routeName =
              data_get($trip, 'route.name') ??
              (data_get($trip, 'route.route_name') ??
                  (data_get($trip, 'route.route_code') ?? ($trip->route_id ? 'Route ID: ' . $trip->route_id : '-')));

          $routeStart =
              data_get($trip, 'route.start_location') ??
              (data_get($trip, 'route.origin') ?? (data_get($trip, 'route.from_location') ?? null));

          $routeEnd =
              data_get($trip, 'route.end_location') ??
              (data_get($trip, 'route.destination') ?? (data_get($trip, 'route.to_location') ?? null));

          $vehicleName =
              data_get($trip, 'vehicle.vehicle_number') ??
              (data_get($trip, 'vehicle.plate_number') ??
                  (data_get($trip, 'vehicle.license_plate') ??
                      (data_get($trip, 'vehicle.police_number') ??
                          (data_get($trip, 'vehicle.name') ??
                              ($trip->vehicle_id ? 'Vehicle ID: ' . $trip->vehicle_id : '-')))));

          $vehicleType =
              data_get($trip, 'vehicle.type') ??
              (data_get($trip, 'vehicle.vehicle_type') ?? (data_get($trip, 'vehicle.brand') ?? '-'));

          $driverName =
              data_get($trip, 'driver.name') ??
              (data_get($trip, 'driver.driver_name') ??
                  (data_get($trip, 'driver.full_name') ??
                      ($trip->driver_id ? 'Driver ID: ' . $trip->driver_id : 'Belum ada driver')));

          $driverPhone =
              data_get($trip, 'driver.phone') ??
              (data_get($trip, 'driver.phone_number') ?? (data_get($trip, 'driver.no_hp') ?? '-'));

          $statusClass =
              [
                  'scheduled' => 'status-scheduled',
                  'running' => 'status-running',
                  'completed' => 'status-completed',
                  'cancelled' => 'status-cancelled',
                  'delayed' => 'status-delayed',
              ][$trip->status] ?? 'status-default';

          $statusIcon =
              [
                  'scheduled' => 'bi-calendar-check',
                  'running' => 'bi-play-circle',
                  'completed' => 'bi-check-circle',
                  'cancelled' => 'bi-x-circle',
                  'delayed' => 'bi-exclamation-circle',
              ][$trip->status] ?? 'bi-circle';
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
               color: #ffffff;
               overflow: hidden;
               position: relative;
               box-shadow: 0 18px 45px rgba(15, 23, 42, .18);
          }

          .hero-card::after {
               content: "";
               position: absolute;
               width: 260px;
               height: 260px;
               right: -80px;
               top: -90px;
               background: rgba(255, 255, 255, .14);
               border-radius: 50%;
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

          .hero-code {
               display: inline-flex;
               align-items: center;
               gap: 8px;
               background: rgba(255, 255, 255, .14);
               color: #ffffff;
               padding: 9px 13px;
               border-radius: 14px;
               font-weight: 800;
               margin-top: 14px;
          }

          .btn-back {
               background: #ffffff;
               color: #1d4ed8;
               border: 0;
               border-radius: 14px;
               padding: 11px 18px;
               font-weight: 700;
               text-decoration: none;
               box-shadow: 0 10px 24px rgba(15, 23, 42, .16);
          }

          .btn-back:hover {
               background: #eff6ff;
               color: #1e40af;
          }

          .detail-card {
               border: 0;
               border-radius: 24px;
               background: #ffffff;
               box-shadow: 0 12px 34px rgba(15, 23, 42, .08);
               overflow: hidden;
               height: 100%;
          }

          .detail-card-header {
               padding: 20px 24px;
               border-bottom: 1px solid #e5e7eb;
               background: #ffffff;
          }

          .detail-card-title {
               font-size: 18px;
               font-weight: 800;
               color: #0f172a;
               margin-bottom: 2px;
               display: flex;
               align-items: center;
               gap: 8px;
          }

          .detail-card-title i {
               color: #2563eb;
          }

          .detail-card-subtitle {
               font-size: 13px;
               color: #64748b;
               margin-bottom: 0;
          }

          .detail-body {
               padding: 22px 24px;
          }

          .info-list {
               display: grid;
               gap: 16px;
          }

          .info-item {
               padding-bottom: 14px;
               border-bottom: 1px solid #f1f5f9;
          }

          .info-item:last-child {
               border-bottom: 0;
               padding-bottom: 0;
          }

          .info-label {
               font-size: 12px;
               color: #64748b;
               font-weight: 700;
               text-transform: uppercase;
               letter-spacing: .04em;
               margin-bottom: 5px;
          }

          .info-value {
               color: #0f172a;
               font-size: 15px;
               font-weight: 800;
          }

          .info-sub {
               color: #64748b;
               font-size: 13px;
               margin-top: 3px;
          }

          .status-pill {
               display: inline-flex;
               align-items: center;
               gap: 7px;
               border-radius: 999px;
               padding: 8px 13px;
               font-size: 13px;
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

          .status-completed {
               background: #dcfce7;
               color: #166534;
          }

          .status-cancelled {
               background: #fee2e2;
               color: #991b1b;
          }

          .status-delayed {
               background: #ffedd5;
               color: #c2410c;
          }

          .status-default {
               background: #e2e8f0;
               color: #334155;
          }

          .timeline-box {
               display: grid;
               gap: 14px;
          }

          .timeline-item {
               display: flex;
               align-items: flex-start;
               gap: 12px;
               padding: 14px;
               border-radius: 18px;
               background: #f8fafc;
               border: 1px solid #eef2f7;
          }

          .timeline-icon {
               width: 42px;
               height: 42px;
               border-radius: 14px;
               background: #dbeafe;
               color: #1d4ed8;
               display: flex;
               align-items: center;
               justify-content: center;
               font-size: 20px;
               flex-shrink: 0;
          }

          .notes-box {
               background: #f8fafc;
               border: 1px solid #eef2f7;
               border-radius: 18px;
               padding: 16px;
               color: #334155;
               line-height: 1.6;
               min-height: 100px;
          }

          .action-card {
               border: 0;
               border-radius: 24px;
               background: #ffffff;
               box-shadow: 0 12px 34px rgba(15, 23, 42, .08);
               padding: 20px;
          }

          .btn-modern {
               border-radius: 14px;
               padding: 11px 16px;
               font-weight: 700;
               border: 0;
               text-decoration: none;
               display: inline-flex;
               align-items: center;
               gap: 7px;
          }

          .btn-edit {
               background: #fef3c7;
               color: #92400e;
          }

          .btn-edit:hover {
               background: #fde68a;
               color: #78350f;
          }

          .btn-delete {
               background: #fee2e2;
               color: #991b1b;
          }

          .btn-delete:hover {
               background: #fecaca;
               color: #7f1d1d;
          }

          .btn-list {
               background: #e2e8f0;
               color: #334155;
          }

          .btn-list:hover {
               background: #cbd5e1;
               color: #0f172a;
          }
     </style>

     <div class="trip-page">

          <div class="hero-card mb-4">
               <div class="hero-content">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                         <div>
                              <div class="hero-title">
                                   <i class="bi bi-info-circle me-2"></i>
                                   Detail Trip
                              </div>

                              <p class="hero-subtitle">
                                   Informasi lengkap data perjalanan, rute, kendaraan, driver, waktu, status, dan catatan.
                              </p>

                              <div class="hero-code">
                                   <i class="bi bi-ticket-perforated"></i>
                                   {{ $trip->trip_code }}
                              </div>
                         </div>

                         <a href="{{ route('admin.trips.index') }}" class="btn-back">
                              <i class="bi bi-arrow-left-circle me-1"></i>
                              Kembali
                         </a>

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

          <div class="row g-4">

               <div class="col-xl-4 col-lg-6">
                    <div class="detail-card">

                         <div class="detail-card-header">
                              <div class="detail-card-title">
                                   <i class="bi bi-ticket-perforated"></i>
                                   Informasi Trip
                              </div>

                              <p class="detail-card-subtitle">
                                   Data utama dari tabel trips.
                              </p>
                         </div>

                         <div class="detail-body">

                              <div class="info-list">

                                   <div class="info-item">
                                        <div class="info-label">Trip Code</div>
                                        <div class="info-value">{{ $trip->trip_code }}</div>
                                   </div>

                                   <div class="info-item">
                                        <div class="info-label">Status</div>
                                        <div class="info-value">
                                             <span class="status-pill {{ $statusClass }}">
                                                  <i class="bi {{ $statusIcon }}"></i>
                                                  {{ ucfirst($trip->status) }}
                                             </span>
                                        </div>
                                   </div>

                                   <div class="info-item">
                                        <div class="info-label">Delay Minutes</div>
                                        <div class="info-value">
                                             {{ $trip->delay_minutes ?? 0 }} menit
                                        </div>
                                   </div>

                                   <div class="info-item">
                                        <div class="info-label">Created At</div>
                                        <div class="info-value">
                                             {{ $formatDateTime($trip->created_at) }}
                                        </div>
                                   </div>

                                   <div class="info-item">
                                        <div class="info-label">Updated At</div>
                                        <div class="info-value">
                                             {{ $formatDateTime($trip->updated_at) }}
                                        </div>
                                   </div>

                              </div>

                         </div>

                    </div>
               </div>

               <div class="col-xl-4 col-lg-6">
                    <div class="detail-card">

                         <div class="detail-card-header">
                              <div class="detail-card-title">
                                   <i class="bi bi-signpost-2"></i>
                                   Rute dan Jadwal
                              </div>

                              <p class="detail-card-subtitle">
                                   Relasi schedule dan route.
                              </p>
                         </div>

                         <div class="detail-body">

                              <div class="info-list">

                                   <div class="info-item">
                                        <div class="info-label">Schedule</div>
                                        <div class="info-value">{{ $scheduleName }}</div>
                                        <div class="info-sub">
                                             ID: {{ $trip->schedule_id ?? '-' }}
                                        </div>
                                   </div>

                                   <div class="info-item">
                                        <div class="info-label">Route</div>
                                        <div class="info-value">{{ $routeName }}</div>

                                        <div class="info-sub">
                                             @if ($routeStart || $routeEnd)
                                                  {{ $routeStart ?? '-' }} ke {{ $routeEnd ?? '-' }}
                                             @else
                                                  ID: {{ $trip->route_id }}
                                             @endif
                                        </div>
                                   </div>

                              </div>

                         </div>

                    </div>
               </div>

               <div class="col-xl-4 col-lg-12">
                    <div class="detail-card">

                         <div class="detail-card-header">
                              <div class="detail-card-title">
                                   <i class="bi bi-truck-front"></i>
                                   Kendaraan dan Driver
                              </div>

                              <p class="detail-card-subtitle">
                                   Relasi vehicle dan driver.
                              </p>
                         </div>

                         <div class="detail-body">

                              <div class="info-list">

                                   <div class="info-item">
                                        <div class="info-label">Vehicle</div>
                                        <div class="info-value">{{ $vehicleName }}</div>
                                        <div class="info-sub">
                                             {{ $vehicleType }}
                                        </div>
                                        <div class="info-sub">
                                             ID: {{ $trip->vehicle_id }}
                                        </div>
                                   </div>

                                   <div class="info-item">
                                        <div class="info-label">Driver</div>
                                        <div class="info-value">{{ $driverName }}</div>
                                        <div class="info-sub">
                                             {{ $driverPhone }}
                                        </div>
                                        <div class="info-sub">
                                             ID: {{ $trip->driver_id ?? '-' }}
                                        </div>
                                   </div>

                              </div>

                         </div>

                    </div>
               </div>

               <div class="col-xl-8">
                    <div class="detail-card">

                         <div class="detail-card-header">
                              <div class="detail-card-title">
                                   <i class="bi bi-clock-history"></i>
                                   Waktu Perjalanan
                              </div>

                              <p class="detail-card-subtitle">
                                   Perbandingan waktu rencana dan waktu aktual.
                              </p>
                         </div>

                         <div class="detail-body">

                              <div class="timeline-box">

                                   <div class="timeline-item">
                                        <div class="timeline-icon">
                                             <i class="bi bi-calendar-event"></i>
                                        </div>

                                        <div>
                                             <div class="info-label">Planned Start Time</div>
                                             <div class="info-value">{{ $formatDateTime($trip->planned_start_time) }}</div>
                                        </div>
                                   </div>

                                   <div class="timeline-item">
                                        <div class="timeline-icon">
                                             <i class="bi bi-calendar2-check"></i>
                                        </div>

                                        <div>
                                             <div class="info-label">Planned End Time</div>
                                             <div class="info-value">{{ $formatDateTime($trip->planned_end_time) }}</div>
                                        </div>
                                   </div>

                                   <div class="timeline-item">
                                        <div class="timeline-icon">
                                             <i class="bi bi-play-circle"></i>
                                        </div>

                                        <div>
                                             <div class="info-label">Actual Start Time</div>
                                             <div class="info-value">{{ $formatDateTime($trip->actual_start_time) }}</div>
                                        </div>
                                   </div>

                                   <div class="timeline-item">
                                        <div class="timeline-icon">
                                             <i class="bi bi-stop-circle"></i>
                                        </div>

                                        <div>
                                             <div class="info-label">Actual End Time</div>
                                             <div class="info-value">{{ $formatDateTime($trip->actual_end_time) }}</div>
                                        </div>
                                   </div>

                              </div>

                         </div>

                    </div>
               </div>

               <div class="col-xl-4">
                    <div class="detail-card">

                         <div class="detail-card-header">
                              <div class="detail-card-title">
                                   <i class="bi bi-journal-text"></i>
                                   Notes
                              </div>

                              <p class="detail-card-subtitle">
                                   Catatan tambahan perjalanan.
                              </p>
                         </div>

                         <div class="detail-body">

                              <div class="notes-box">
                                   {{ $trip->notes ?? 'Tidak ada catatan.' }}
                              </div>

                         </div>

                    </div>
               </div>

               <div class="col-12">
                    <div class="action-card">

                         <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                              <div>
                                   <div class="fw-bold text-dark">
                                        Action
                                   </div>

                                   <div class="text-muted small">
                                        Kelola data trip ini.
                                   </div>
                              </div>

                              <div class="d-flex flex-wrap gap-2">

                                   <a href="{{ route('admin.trips.index') }}" class="btn-modern btn-list">
                                        <i class="bi bi-list-ul"></i>
                                        Daftar Trip
                                   </a>

                                   <a href="{{ route('admin.trips.edit', $trip->id) }}" class="btn-modern btn-edit">
                                        <i class="bi bi-pencil-square"></i>
                                        Edit Trip
                                   </a>

                                   <form action="{{ route('admin.trips.destroy', $trip->id) }}" method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="btn-modern btn-delete"
                                             onclick="confirmDelete(this)">
                                             <i class="bi bi-trash3"></i>
                                             Hapus Trip
                                        </button>

                                   </form>

                              </div>

                         </div>

                    </div>
               </div>

          </div>

     </div>

     <script>
          function confirmDelete(button) {
               if (confirm('Yakin ingin menghapus data trip ini?')) {
                    button.closest('form').submit();
               }
          }
     </script>
@endsection
