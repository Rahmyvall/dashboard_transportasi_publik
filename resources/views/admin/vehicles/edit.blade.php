@extends('layouts.app')

@section('content')
    <style>
        .page-wrap {
            background: #f6f8fc;
            min-height: 100vh;
            padding-bottom: 30px;
        }

        .page-header {
            background: linear-gradient(135deg, #60a5fa, #3b82f6, #1d4ed8);
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
            padding: 10px 12px;
            border: 1px solid #e5e7eb;
            transition: .2s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.15);
        }

        .btn-modern {
            background: linear-gradient(135deg, #2563eb, #1e3a8a);
            border: none;
            color: #fff;
            padding: 10px 18px;
            border-radius: 12px;
            font-weight: 600;
            box-shadow: 0 8px 18px rgba(59, 130, 246, 0.25);
        }

        .readonly-code {
            background: #f1f5f9;
            border: 1px dashed #94a3b8;
            font-weight: 600;
            color: #0f172a;
        }

        hr {
            border-top: 1px solid #eef2f7;
            margin: 20px 0;
        }
    </style>

    <div class="page-wrap">

        <div class="container-pg">

            <!-- HEADER -->
            <div class="page-header">
                <h4>✏️ Edit Vehicle</h4>
                <small>Update data armada transportasi publik</small>
            </div>

            <form action="{{ route('admin.vehicles.update', $vehicle->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card card-modern">

                    <div class="card-body">

                        <!-- SECTION 1 -->
                        <div class="section-title">Informasi Operasional</div>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label>Operator</label>
                                <select name="operator_id" class="form-select">
                                    @foreach ($operators as $o)
                                        <option value="{{ $o->id }}"
                                            {{ $vehicle->operator_id == $o->id ? 'selected' : '' }}>
                                            {{ $o->operator_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Transport Mode</label>
                                <select name="transport_mode_id" class="form-select">
                                    @foreach ($modes as $m)
                                        <option value="{{ $m->id }}"
                                            {{ $vehicle->transport_mode_id == $m->id ? 'selected' : '' }}>
                                            {{ $m->name ?? $m->mode_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <hr>

                        <!-- SECTION 2 -->
                        <div class="section-title">Identitas Kendaraan</div>

                        <div class="row g-3">

                            <!-- AUTO SYSTEM CODE -->
                            <div class="col-md-6">
                                <label>Vehicle Code (System Locked)</label>
                                <input type="text" value="{{ $vehicle->vehicle_code }}"
                                    class="form-control readonly-code" readonly>
                                <small class="text-muted">
                                    Code tidak dapat diubah (auto system)
                                </small>
                            </div>

                            <div class="col-md-6">
                                <label>Plate Number</label>
                                <input type="text" name="plate_number" value="{{ $vehicle->plate_number }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label>Capacity</label>
                                <input type="number" name="capacity" value="{{ $vehicle->capacity }}" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label>Manufacture Year</label>
                                <input type="number" name="manufacture_year" value="{{ $vehicle->manufacture_year }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label>Status</label>
                                <select name="status" class="form-select">
                                    <option value="available" {{ $vehicle->status == 'available' ? 'selected' : '' }}>
                                        Available</option>
                                    <option value="on_trip" {{ $vehicle->status == 'on_trip' ? 'selected' : '' }}>On Trip
                                    </option>
                                    <option value="maintenance" {{ $vehicle->status == 'maintenance' ? 'selected' : '' }}>
                                        Maintenance</option>
                                    <option value="inactive" {{ $vehicle->status == 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>

                        </div>

                        <hr>

                        <!-- SECTION 3 -->
                        <div class="section-title">Maintenance & Notes</div>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label>Last Service Date</label>
                                <input type="date" name="last_service_date" value="{{ $vehicle->last_service_date }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label>Notes</label>
                                <textarea name="notes" class="form-control" rows="3">{{ $vehicle->notes }}</textarea>
                            </div>

                        </div>

                    </div>

                    <!-- FOOTER -->
                    <div class="card-footer bg-white border-0 text-end">
                        <button class="btn btn-modern">
                            💾 Update Vehicle
                        </button>
                    </div>

                </div>

            </form>

        </div>

    </div>
@endsection
