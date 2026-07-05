@extends('layouts.app')

@section('content')
    <style>
        .page-wrap {
            background: #f6f8fc;
            min-height: 100vh;
            padding-bottom: 30px;
        }

        .page-header {
            background: linear-gradient(135deg, #1d4ed8, #2563eb, #60a5fa);
            color: #fff;
            padding: 20px;
            border-radius: 18px;
            box-shadow: 0 12px 30px rgba(59, 130, 246, 0.25);
            margin-bottom: 20px;
        }

        .card-modern {
            border: none;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .section-title {
            font-size: 12px;
            letter-spacing: .08em;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 10px;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            padding: 11px 12px;
            border: 1px solid #e5e7eb;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.15);
        }

        .btn-modern {
            background: linear-gradient(135deg, #60a5fa, #3b82f6);
            border: none;
            padding: 10px 18px;
            border-radius: 12px;
            font-weight: 600;
            color: #fff;
            box-shadow: 0 8px 18px rgba(59, 130, 246, 0.25);
        }

        hr {
            border-top: 1px solid #eef2f7;
            margin: 20px 0;
        }
    </style>

    <div class="page-wrap">

        <div class="container-pg">

            {{-- HEADER --}}
            <div class="page-header">
                <h4>✏ Edit Schedule</h4>
                <small>Update data jadwal operasional transportasi</small>
            </div>

            <form action="{{ route('admin.schedules.update', $schedule->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card card-modern">

                    <div class="card-body">

                        {{-- SECTION 1 --}}
                        <div class="section-title">Rute & Kendaraan</div>

                        <div class="row g-3">

                            {{-- ROUTE --}}
                            <div class="col-md-12">
                                <label>Route</label>
                                <select name="route_id" class="form-select" required>
                                    <option value="">Pilih Route</option>
                                    @foreach ($routes as $route)
                                        <option value="{{ $route->id }}"
                                            {{ $schedule->route_id == $route->id ? 'selected' : '' }}>
                                            {{ $route->route_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- VEHICLE --}}
                            <div class="col-md-6">
                                <label>Vehicle</label>
                                <select name="vehicle_id" class="form-select">
                                    <option value="">Tidak ada</option>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}"
                                            {{ $schedule->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                                            {{ $vehicle->plate_number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- DRIVER --}}
                            <div class="col-md-6">
                                <label>Driver</label>
                                <select name="driver_id" class="form-select">
                                    <option value="">Tidak ada</option>
                                    @foreach ($drivers as $driver)
                                        <option value="{{ $driver->id }}"
                                            {{ $schedule->driver_id == $driver->id ? 'selected' : '' }}>
                                            {{ $driver->driver_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <hr>

                        {{-- SECTION 2 --}}
                        <div class="section-title">Waktu Operasional</div>

                        <div class="row g-3">

                            {{-- DAY TYPE --}}
                            <div class="col-md-6">
                                <label>Day Type</label>
                                <select name="day_type" class="form-select" required>
                                    @foreach (['all', 'weekday', 'weekend', 'holiday'] as $type)
                                        <option value="{{ $type }}"
                                            {{ $schedule->day_type == $type ? 'selected' : '' }}>
                                            {{ ucfirst($type) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- HEADWAY --}}
                            <div class="col-md-6">
                                <label>Headway (Menit)</label>
                                <input type="number" name="headway_minutes" class="form-control"
                                    value="{{ old('headway_minutes', $schedule->headway_minutes) }}">
                            </div>

                            {{-- START TIME --}}
                            <div class="col-md-6">
                                <label>Start Time</label>
                                <input type="time" name="start_time" class="form-control"
                                    value="{{ $schedule->start_time }}" required>
                            </div>

                            {{-- END TIME --}}
                            <div class="col-md-6">
                                <label>End Time</label>
                                <input type="time" name="end_time" class="form-control"
                                    value="{{ $schedule->end_time }}" required>
                            </div>

                            {{-- STATUS --}}
                            <div class="col-md-12">
                                <label>Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                        {{ $schedule->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label">
                                        Active Schedule
                                    </label>
                                </div>
                            </div>

                        </div>

                    </div>

                    {{-- FOOTER --}}
                    <div class="card-footer bg-white border-0 text-end">

                        <a href="{{ route('admin.schedules.index') }}" class="btn btn-light">
                            Kembali
                        </a>

                        <button type="submit" class="btn btn-modern">
                            💾 Update Schedule
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>
@endsection
