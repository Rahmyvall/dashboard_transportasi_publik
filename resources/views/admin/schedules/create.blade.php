@extends('layouts.app')

@section('content')
    <style>
        .schedule-create {
            --primary: #2563eb;
            --soft: #eff6ff;
            --dark: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
        }

        .header-box {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: white;
            border-radius: 18px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(37, 99, 235, .25);
        }

        .card-form {
            border: none;
            border-radius: 18px;
            box-shadow: 0 8px 20px rgba(15, 23, 42, .06);
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            min-height: 44px;
            border: 1px solid #e2e8f0;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #93c5fd;
            box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .15);
        }

        .btn-primary {
            border-radius: 12px;
            padding: 10px 16px;
            font-weight: 600;
        }

        .btn-light {
            border-radius: 12px;
        }
    </style>

    <div class="schedule-create container-fluid">

        <!-- HEADER -->
        <div class="header-box d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="mb-1 fw-bold">Tambah Schedule</h4>
                <small class="opacity-75">Buat jadwal operasional rute</small>
            </div>

            <a href="{{ route('admin.schedules.index') }}" class="btn btn-light btn-sm">
                <i class="ri-arrow-left-line"></i> Kembali
            </a>

        </div>

        <!-- FORM -->
        <div class="card card-form">

            <div class="card-body p-4">

                <form action="{{ route('admin.schedules.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">

                        <!-- ROUTE -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Route</label>
                            <select name="route_id" class="form-select" required>
                                <option value="">Pilih Route</option>
                                @foreach ($routes as $r)
                                    <option value="{{ $r->id }}">
                                        {{ $r->route_code }} - {{ $r->route_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- VEHICLE -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Vehicle</label>
                            <select name="vehicle_id" class="form-select">
                                <option value="">-</option>
                                @foreach ($vehicles as $v)
                                    <option value="{{ $v->id }}">
                                        {{ $v->plate_number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- DRIVER -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Driver</label>
                            <select name="driver_id" class="form-select">
                                <option value="">-</option>
                                @foreach ($drivers as $d)
                                    <option value="{{ $d->id }}">
                                        {{ $d->driver_name ?? $d->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- DAY TYPE -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Day Type</label>
                            <select name="day_type" class="form-select">
                                <option value="weekday">Weekday</option>
                                <option value="weekend">Weekend</option>
                                <option value="holiday">Holiday</option>
                                <option value="all">All</option>
                            </select>
                        </div>

                        <!-- START -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Start Time</label>
                            <input type="time" name="start_time" class="form-control" required>
                        </div>

                        <!-- END -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">End Time</label>
                            <input type="time" name="end_time" class="form-control" required>
                        </div>

                        <!-- HEADWAY -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Headway (menit)</label>
                            <input type="number" name="headway_minutes" class="form-control" min="1"
                                placeholder="Contoh: 10">
                        </div>

                        <!-- STATUS -->
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="form-check mt-4">
                                <input type="checkbox" name="is_active" class="form-check-input" checked>
                                <label class="form-check-label">Active</label>
                            </div>
                        </div>

                    </div>

                    <!-- BUTTON -->
                    <div class="mt-4 d-flex justify-content-end gap-2">

                        <a href="{{ route('admin.schedules.index') }}" class="btn btn-light">
                            Cancel
                        </a>

                        <button class="btn btn-primary">
                            <i class="ri-save-line"></i> Simpan Schedule
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
