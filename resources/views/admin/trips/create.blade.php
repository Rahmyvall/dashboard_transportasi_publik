@extends('layouts.app')

@section('content')
     <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

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

          .form-card {
               border: 0;
               border-radius: 24px;
               overflow: hidden;
               background: #ffffff;
               box-shadow: 0 12px 34px rgba(15, 23, 42, .08);
          }

          .form-card-header {
               padding: 22px 24px;
               border-bottom: 1px solid #e5e7eb;
               background: #ffffff;
          }

          .form-card-title {
               font-size: 18px;
               font-weight: 800;
               color: #0f172a;
               margin-bottom: 3px;
          }

          .form-card-subtitle {
               font-size: 13px;
               color: #64748b;
               margin-bottom: 0;
          }

          .section-title {
               font-size: 15px;
               font-weight: 800;
               color: #0f172a;
               margin-bottom: 16px;
               display: flex;
               align-items: center;
               gap: 8px;
          }

          .section-title i {
               color: #2563eb;
          }

          .form-label {
               font-size: 13px;
               font-weight: 700;
               color: #334155;
               margin-bottom: 7px;
          }

          .form-control,
          .form-select {
               border-radius: 14px;
               border: 1px solid #dbe3ef;
               padding: 11px 13px;
               color: #0f172a;
               font-size: 14px;
          }

          .form-control:focus,
          .form-select:focus {
               border-color: #2563eb;
               box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .12);
          }

          .input-icon {
               position: relative;
          }

          .input-icon i {
               position: absolute;
               left: 14px;
               top: 50%;
               transform: translateY(-50%);
               color: #64748b;
               z-index: 2;
          }

          .input-icon .form-control,
          .input-icon .form-select {
               padding-left: 42px;
          }

          .form-section {
               padding: 24px;
               border-bottom: 1px solid #f1f5f9;
          }

          .form-footer {
               padding: 22px 24px;
               background: #f8fafc;
               display: flex;
               justify-content: flex-end;
               gap: 10px;
               flex-wrap: wrap;
          }

          .btn-save {
               background: #2563eb;
               border: 0;
               color: #ffffff;
               border-radius: 14px;
               padding: 11px 18px;
               font-weight: 700;
          }

          .btn-save:hover {
               background: #1d4ed8;
               color: #ffffff;
          }

          .btn-cancel {
               background: #e2e8f0;
               border: 0;
               color: #334155;
               border-radius: 14px;
               padding: 11px 18px;
               font-weight: 700;
               text-decoration: none;
          }

          .btn-cancel:hover {
               background: #cbd5e1;
               color: #0f172a;
          }

          .required {
               color: #dc2626;
          }

          .invalid-feedback {
               font-size: 12px;
               font-weight: 600;
          }

          .help-text {
               color: #64748b;
               font-size: 12px;
               margin-top: 6px;
          }
     </style>

     <div class="trip-page">

          <div class="hero-card mb-4">
               <div class="hero-content">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                         <div>
                              <div class="hero-title">
                                   <i class="bi bi-plus-circle me-2"></i>
                                   Tambah Trip
                              </div>

                              <p class="hero-subtitle">
                                   Buat data perjalanan baru berdasarkan jadwal, rute, kendaraan, driver, dan waktu
                                   operasional.
                              </p>
                         </div>

                         <a href="{{ route('admin.trips.index') }}" class="btn-back">
                              <i class="bi bi-arrow-left-circle me-1"></i>
                              Kembali
                         </a>

                    </div>

               </div>
          </div>

          @if ($errors->any())
               <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
                    <div class="fw-bold mb-1">
                         <i class="bi bi-exclamation-triangle-fill me-1"></i>
                         Data belum lengkap
                    </div>

                    <div>
                         Periksa kembali field yang wajib diisi.
                    </div>
               </div>
          @endif

          <form action="{{ route('admin.trips.store') }}" method="POST">

               @csrf

               <div class="form-card">

                    <div class="form-card-header">
                         <div class="form-card-title">
                              Form Data Trip
                         </div>

                         <p class="form-card-subtitle">
                              Field bertanda merah wajib diisi.
                         </p>
                    </div>

                    <div class="form-section">

                         <div class="section-title">
                              <i class="bi bi-ticket-perforated"></i>
                              Informasi Utama
                         </div>

                         <div class="row g-3">

                              <div class="col-lg-4 col-md-6">
                                   <label class="form-label">
                                        Trip Code
                                   </label>

                                   <div class="input-icon">
                                        <i class="bi bi-upc-scan"></i>

                                        <input type="text" class="form-control" value="Auto Generate" readonly>
                                   </div>

                                   <div class="help-text">
                                        Trip code akan dibuat otomatis oleh sistem saat data disimpan.
                                   </div>
                              </div>

                              <div class="col-lg-4 col-md-6">
                                   <label class="form-label">
                                        Schedule
                                   </label>

                                   <div class="input-icon">
                                        <i class="bi bi-calendar-check"></i>
                                        <select name="schedule_id"
                                             class="form-select @error('schedule_id') is-invalid @enderror">

                                             <option value="">Pilih Schedule</option>

                                             @foreach ($schedules as $schedule)
                                                  @php
                                                       $scheduleName =
                                                           $schedule->name ??
                                                           ($schedule->schedule_name ??
                                                               ($schedule->schedule_code ??
                                                                   ($schedule->code ??
                                                                       'Schedule ID: ' . $schedule->id)));
                                                  @endphp

                                                  <option value="{{ $schedule->id }}"
                                                       {{ old('schedule_id') == $schedule->id ? 'selected' : '' }}>
                                                       {{ $scheduleName }}
                                                  </option>
                                             @endforeach

                                        </select>

                                        @error('schedule_id')
                                             <div class="invalid-feedback">
                                                  {{ $message }}
                                             </div>
                                        @enderror
                                   </div>

                                   <div class="help-text">
                                        Boleh dikosongkan jika trip tidak memakai jadwal tetap.
                                   </div>
                              </div>

                              <div class="col-lg-4 col-md-6">
                                   <label class="form-label">
                                        Status <span class="required">*</span>
                                   </label>

                                   <div class="input-icon">
                                        <i class="bi bi-activity"></i>
                                        <select name="status" class="form-select @error('status') is-invalid @enderror">

                                             <option value="scheduled"
                                                  {{ old('status', 'scheduled') == 'scheduled' ? 'selected' : '' }}>
                                                  Scheduled
                                             </option>

                                             <option value="running" {{ old('status') == 'running' ? 'selected' : '' }}>
                                                  Running
                                             </option>

                                             <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                                                  Completed
                                             </option>

                                             <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>
                                                  Cancelled
                                             </option>

                                             <option value="delayed" {{ old('status') == 'delayed' ? 'selected' : '' }}>
                                                  Delayed
                                             </option>

                                        </select>

                                        @error('status')
                                             <div class="invalid-feedback">
                                                  {{ $message }}
                                             </div>
                                        @enderror
                                   </div>
                              </div>

                         </div>

                    </div>

                    <div class="form-section">

                         <div class="section-title">
                              <i class="bi bi-signpost-2"></i>
                              Rute, Kendaraan, dan Driver
                         </div>

                         <div class="row g-3">

                              <div class="col-lg-4 col-md-6">
                                   <label class="form-label">
                                        Route <span class="required">*</span>
                                   </label>

                                   <div class="input-icon">
                                        <i class="bi bi-map"></i>
                                        <select name="route_id" class="form-select @error('route_id') is-invalid @enderror">

                                             <option value="">Pilih Route</option>

                                             @foreach ($routes as $route)
                                                  @php
                                                       $routeName =
                                                           $route->name ??
                                                           ($route->route_name ??
                                                               ($route->route_code ?? 'Route ID: ' . $route->id));

                                                       $routeStart =
                                                           $route->start_location ??
                                                           ($route->origin ?? ($route->from_location ?? null));

                                                       $routeEnd =
                                                           $route->end_location ??
                                                           ($route->destination ?? ($route->to_location ?? null));
                                                  @endphp

                                                  <option value="{{ $route->id }}"
                                                       {{ old('route_id') == $route->id ? 'selected' : '' }}>
                                                       {{ $routeName }}
                                                       @if ($routeStart || $routeEnd)
                                                            | {{ $routeStart ?? '-' }} ke {{ $routeEnd ?? '-' }}
                                                       @endif
                                                  </option>
                                             @endforeach

                                        </select>

                                        @error('route_id')
                                             <div class="invalid-feedback">
                                                  {{ $message }}
                                             </div>
                                        @enderror
                                   </div>
                              </div>

                              <div class="col-lg-4 col-md-6">
                                   <label class="form-label">
                                        Vehicle <span class="required">*</span>
                                   </label>

                                   <div class="input-icon">
                                        <i class="bi bi-truck-front"></i>
                                        <select name="vehicle_id"
                                             class="form-select @error('vehicle_id') is-invalid @enderror">

                                             <option value="">Pilih Vehicle</option>

                                             @foreach ($vehicles as $vehicle)
                                                  @php
                                                       $vehicleName =
                                                           $vehicle->vehicle_number ??
                                                           ($vehicle->plate_number ??
                                                               ($vehicle->license_plate ??
                                                                   ($vehicle->police_number ??
                                                                       ($vehicle->name ??
                                                                           'Vehicle ID: ' . $vehicle->id))));

                                                       $vehicleType =
                                                           $vehicle->type ??
                                                           ($vehicle->vehicle_type ?? ($vehicle->brand ?? null));
                                                  @endphp

                                                  <option value="{{ $vehicle->id }}"
                                                       {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                                       {{ $vehicleName }}
                                                       @if ($vehicleType)
                                                            | {{ $vehicleType }}
                                                       @endif
                                                  </option>
                                             @endforeach

                                        </select>

                                        @error('vehicle_id')
                                             <div class="invalid-feedback">
                                                  {{ $message }}
                                             </div>
                                        @enderror
                                   </div>
                              </div>

                              <div class="col-lg-4 col-md-6">
                                   <label class="form-label">
                                        Driver
                                   </label>

                                   <div class="input-icon">
                                        <i class="bi bi-person-badge"></i>
                                        <select name="driver_id"
                                             class="form-select @error('driver_id') is-invalid @enderror">

                                             <option value="">Pilih Driver</option>

                                             @foreach ($drivers as $driver)
                                                  @php
                                                       $driverName =
                                                           $driver->name ??
                                                           ($driver->driver_name ??
                                                               ($driver->full_name ?? 'Driver ID: ' . $driver->id));

                                                       $driverPhone =
                                                           $driver->phone ??
                                                           ($driver->phone_number ?? ($driver->no_hp ?? null));
                                                  @endphp

                                                  <option value="{{ $driver->id }}"
                                                       {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                                       {{ $driverName }}
                                                       @if ($driverPhone)
                                                            | {{ $driverPhone }}
                                                       @endif
                                                  </option>
                                             @endforeach

                                        </select>

                                        @error('driver_id')
                                             <div class="invalid-feedback">
                                                  {{ $message }}
                                             </div>
                                        @enderror
                                   </div>

                                   <div class="help-text">
                                        Boleh dikosongkan jika driver belum ditentukan.
                                   </div>
                              </div>

                         </div>

                    </div>

                    <div class="form-section">

                         <div class="section-title">
                              <i class="bi bi-clock-history"></i>
                              Waktu Perjalanan
                         </div>

                         <div class="row g-3">

                              <div class="col-lg-3 col-md-6">
                                   <label class="form-label">
                                        Planned Start Time <span class="required">*</span>
                                   </label>

                                   <div class="input-icon">
                                        <i class="bi bi-calendar-event"></i>
                                        <input type="datetime-local" name="planned_start_time"
                                             value="{{ old('planned_start_time') }}"
                                             class="form-control @error('planned_start_time') is-invalid @enderror">

                                        @error('planned_start_time')
                                             <div class="invalid-feedback">
                                                  {{ $message }}
                                             </div>
                                        @enderror
                                   </div>
                              </div>

                              <div class="col-lg-3 col-md-6">
                                   <label class="form-label">
                                        Planned End Time
                                   </label>

                                   <div class="input-icon">
                                        <i class="bi bi-calendar2-check"></i>
                                        <input type="datetime-local" name="planned_end_time"
                                             value="{{ old('planned_end_time') }}"
                                             class="form-control @error('planned_end_time') is-invalid @enderror">

                                        @error('planned_end_time')
                                             <div class="invalid-feedback">
                                                  {{ $message }}
                                             </div>
                                        @enderror
                                   </div>
                              </div>

                              <div class="col-lg-3 col-md-6">
                                   <label class="form-label">
                                        Actual Start Time
                                   </label>

                                   <div class="input-icon">
                                        <i class="bi bi-play-circle"></i>
                                        <input type="datetime-local" name="actual_start_time"
                                             value="{{ old('actual_start_time') }}"
                                             class="form-control @error('actual_start_time') is-invalid @enderror">

                                        @error('actual_start_time')
                                             <div class="invalid-feedback">
                                                  {{ $message }}
                                             </div>
                                        @enderror
                                   </div>
                              </div>

                              <div class="col-lg-3 col-md-6">
                                   <label class="form-label">
                                        Actual End Time
                                   </label>

                                   <div class="input-icon">
                                        <i class="bi bi-stop-circle"></i>
                                        <input type="datetime-local" name="actual_end_time"
                                             value="{{ old('actual_end_time') }}"
                                             class="form-control @error('actual_end_time') is-invalid @enderror">

                                        @error('actual_end_time')
                                             <div class="invalid-feedback">
                                                  {{ $message }}
                                             </div>
                                        @enderror
                                   </div>
                              </div>

                         </div>

                    </div>

                    <div class="form-section">

                         <div class="section-title">
                              <i class="bi bi-info-circle"></i>
                              Informasi Tambahan
                         </div>

                         <div class="row g-3">

                              <div class="col-lg-4 col-md-6">
                                   <label class="form-label">
                                        Delay Minutes
                                   </label>

                                   <div class="input-icon">
                                        <i class="bi bi-alarm"></i>
                                        <input type="number" name="delay_minutes" value="{{ old('delay_minutes', 0) }}"
                                             min="0"
                                             class="form-control @error('delay_minutes') is-invalid @enderror"
                                             placeholder="0">

                                        @error('delay_minutes')
                                             <div class="invalid-feedback">
                                                  {{ $message }}
                                             </div>
                                        @enderror
                                   </div>
                              </div>

                              <div class="col-lg-8 col-md-6">
                                   <label class="form-label">
                                        Notes
                                   </label>

                                   <textarea name="notes" rows="4" class="form-control @error('notes') is-invalid @enderror"
                                        placeholder="Masukkan catatan perjalanan jika ada">{{ old('notes') }}</textarea>

                                   @error('notes')
                                        <div class="invalid-feedback">
                                             {{ $message }}
                                        </div>
                                   @enderror
                              </div>

                         </div>

                    </div>

                    <div class="form-footer">

                         <a href="{{ route('admin.trips.index') }}" class="btn-cancel">
                              <i class="bi bi-x-circle me-1"></i>
                              Batal
                         </a>

                         <button type="submit" class="btn-save">
                              <i class="bi bi-save me-1"></i>
                              Simpan Trip
                         </button>

                    </div>

               </div>

          </form>

     </div>
@endsection
