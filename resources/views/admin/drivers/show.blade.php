@extends('layouts.app')

@section('content')
    <style>
        .page-wrap {
            background: #f6f8fc;
            min-height: 100vh;
            padding-bottom: 30px;
        }

        .page-header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8, #60a5fa);
            color: #fff;
            padding: 22px;
            border-radius: 18px;
            box-shadow: 0 12px 30px rgba(59, 130, 246, 0.25);
            margin-bottom: 20px;
        }

        .card-modern {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .section-title {
            font-size: 12px;
            letter-spacing: .08em;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 12px;
        }

        .info-box {
            padding: 14px;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px solid #eef2f7;
            margin-bottom: 12px;
        }

        .label {
            font-size: 12px;
            color: #64748b;
        }

        .value {
            font-weight: 600;
            color: #0f172a;
        }

        .badge-status {
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .active {
            background: #dcfce7;
            color: #15803d;
        }

        .on_duty {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .inactive {
            background: #fee2e2;
            color: #b91c1c;
        }

        .btn-back {
            background: #e5e7eb;
            padding: 10px 16px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            color: #0f172a;
        }

        .btn-edit {
            background: linear-gradient(135deg, #60a5fa, #3b82f6);
            color: #fff;
            padding: 10px 16px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
        }
    </style>

    <div class="page-wrap">

        <div class="container-pg">

            {{-- HEADER --}}
            <div class="page-header">
                <h4>🚛 Detail Driver</h4>
                <small>Informasi lengkap data driver transportasi publik</small>
            </div>

            <div class="card card-modern">

                <div class="card-body">

                    {{-- SECTION 1 --}}
                    <div class="section-title">Informasi Driver</div>

                    <div class="info-box">
                        <div class="label">Nama Driver</div>
                        <div class="value">{{ $driver->driver_name }}</div>
                    </div>

                    <div class="info-box">
                        <div class="label">Operator</div>
                        <div class="value">{{ $driver->operator->operator_name ?? '-' }}</div>
                    </div>

                    {{-- SECTION 2 --}}
                    <div class="section-title">Data Operasional</div>

                    <div class="info-box">
                        <div class="label">No SIM</div>
                        <div class="value">{{ $driver->license_number }}</div>
                    </div>

                    <div class="info-box">
                        <div class="label">No HP</div>
                        <div class="value">{{ $driver->phone ?? '-' }}</div>
                    </div>

                    <div class="info-box">
                        <div class="label">Status</div>
                        <div class="value">
                            <span class="badge-status {{ $driver->status }}">
                                {{ ucfirst(str_replace('_', ' ', $driver->status)) }}
                            </span>
                        </div>
                    </div>

                    {{-- SECTION 3 --}}
                    <div class="section-title">Alamat</div>

                    <div class="info-box">
                        <div class="label">Lokasi</div>
                        <div class="value">{{ $driver->address ?? '-' }}</div>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="card-footer bg-white border-0 d-flex justify-content-between">

                    <a href="{{ route('admin.drivers.index') }}" class="btn-back">
                        ← Kembali
                    </a>

                    <a href="{{ route('admin.drivers.edit', $driver->id) }}" class="btn-edit">
                        ✏ Edit Driver
                    </a>

                </div>

            </div>

        </div>

    </div>
@endsection
