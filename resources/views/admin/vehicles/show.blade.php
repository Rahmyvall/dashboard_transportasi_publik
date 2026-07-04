@extends('layouts.app')

@section('content')
    <style>
        .page-wrap {
            background: #f6f8fc;
            min-height: 100vh;
            padding-bottom: 30px;
        }

        /* HEADER */
        .page-header {
            background: linear-gradient(135deg, #4f9cff, #2563eb, #1e40af);
            color: #fff;
            padding: 20px;
            border-radius: 18px;
            margin-bottom: 20px;
            box-shadow: 0 12px 30px rgba(37, 99, 235, 0.25);
        }

        .vehicle-title {
            font-size: 22px;
            font-weight: 700;
            margin: 0;
        }

        .vehicle-sub {
            font-size: 13px;
            opacity: .9;
        }

        /* CARD */
        .card-modern {
            border: none;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        /* INFO BOX */
        .info-box {
            background: #fff;
            border-radius: 14px;
            padding: 14px;
            border: 1px solid #eef2f7;
            margin-bottom: 10px;
        }

        .label {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 4px;
        }

        .value {
            font-weight: 600;
            color: #0f172a;
        }

        /* STATUS BADGE */
        .badge-status {
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .available {
            background: #dcfce7;
            color: #15803d;
        }

        .on_trip {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .maintenance {
            background: #fef3c7;
            color: #92400e;
        }

        .inactive {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* GRID */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        @media(max-width: 768px) {
            .grid-2 {
                grid-template-columns: 1fr;
            }
        }

        /* BUTTON */
        .btn-back {
            border-radius: 12px;
            padding: 10px 16px;
            font-weight: 600;
        }
    </style>

    <div class="page-wrap">

        <div class="container-pg">

            <!-- HEADER -->
            <div class="page-header">
                <div class="vehicle-title">{{ $vehicle->vehicle_code }}</div>
                <div class="vehicle-sub">Detail kendaraan operasional transportasi publik</div>
            </div>

            <div class="grid-2">

                <!-- LEFT CARD -->
                <div class="card card-modern">
                    <div class="card-body">

                        <h6 class="mb-3">🚛 Informasi Kendaraan</h6>

                        <div class="info-box">
                            <div class="label">Plate Number</div>
                            <div class="value">{{ $vehicle->plate_number ?? '-' }}</div>
                        </div>

                        <div class="info-box">
                            <div class="label">Capacity</div>
                            <div class="value">{{ $vehicle->capacity }}</div>
                        </div>

                        <div class="info-box">
                            <div class="label">Manufacture Year</div>
                            <div class="value">{{ $vehicle->manufacture_year ?? '-' }}</div>
                        </div>

                        <div class="info-box">
                            <div class="label">Last Service</div>
                            <div class="value">{{ $vehicle->last_service_date ?? '-' }}</div>
                        </div>

                    </div>
                </div>

                <!-- RIGHT CARD -->
                <div class="card card-modern">
                    <div class="card-body">

                        <h6 class="mb-3">📊 Operasional</h6>

                        <div class="info-box">
                            <div class="label">Operator</div>
                            <div class="value">{{ $vehicle->operator->operator_name ?? '-' }}</div>
                        </div>

                        <div class="info-box">
                            <div class="label">Transport Mode</div>
                            <div class="value">
                                {{ $vehicle->transportMode->name ?? ($vehicle->transportMode->mode_name ?? '-') }}
                            </div>
                        </div>

                        <div class="info-box">
                            <div class="label">Status</div>

                            @if ($vehicle->status == 'available')
                                <span class="badge-status available">Available</span>
                            @elseif($vehicle->status == 'on_trip')
                                <span class="badge-status on_trip">On Trip</span>
                            @elseif($vehicle->status == 'maintenance')
                                <span class="badge-status maintenance">Maintenance</span>
                            @else
                                <span class="badge-status inactive">Inactive</span>
                            @endif

                        </div>

                    </div>
                </div>

            </div>

            <!-- NOTES CARD -->
            <div class="card card-modern mt-3">
                <div class="card-body">

                    <h6>📝 Notes</h6>

                    <p class="text-muted">
                        {{ $vehicle->notes ?? 'Tidak ada catatan' }}
                    </p>

                </div>
            </div>

            <!-- BACK BUTTON -->
            <div class="mt-3">
                <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary btn-back">
                    ← Kembali
                </a>
            </div>

        </div>

    </div>
@endsection
