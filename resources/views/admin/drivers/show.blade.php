@extends('layouts.app')

@section('content')
    <style>
        :root {
            --bg: #f5f7fb;
            --card: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --primary: #2563eb;
            --border: #e5e7eb;
            --radius: 18px;
            --shadow: 0 12px 30px rgba(15, 23, 42, .08);
        }

        .wrap {
            background: var(--bg);
            min-height: 100vh;
            padding: 24px;
        }

        /* HEADER */
        .header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8, #60a5fa);
            color: #fff;
            padding: 24px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            margin-bottom: 18px;
            position: relative;
            overflow: hidden;
        }

        .header::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            right: -80px;
            top: -80px;
            background: rgba(255, 255, 255, .12);
            border-radius: 50%;
        }

        .header h4 {
            margin: 0;
            font-weight: 900;
            letter-spacing: -.3px;
        }

        .header small {
            opacity: .85;
        }

        /* GRID */
        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        @media(max-width:768px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }

        /* CARD */
        .card-modern {
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .card-body {
            padding: 22px;
        }

        .section-title {
            font-size: 11px;
            letter-spacing: .14em;
            font-weight: 800;
            color: var(--muted);
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        /* INFO CARD */
        .info {
            background: #f8fafc;
            border: 1px solid #eef2f7;
            border-radius: 14px;
            padding: 14px;
            transition: .2s;
        }

        .info:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, .05);
        }

        .label {
            font-size: 12px;
            color: var(--muted);
            margin-bottom: 4px;
            display: block;
        }

        .value {
            font-size: 15px;
            font-weight: 800;
            color: var(--text);
        }

        /* BADGE */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
        }

        .active {
            background: #dcfce7;
            color: #166534;
        }

        .on_duty {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        /* FOOTER */
        .footer {
            padding: 16px 22px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            background: #fff;
        }

        .btn {
            padding: 10px 14px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: .2s;
        }

        .btn-back {
            background: #f1f5f9;
            color: #0f172a;
        }

        .btn-edit {
            background: linear-gradient(135deg, #60a5fa, #3b82f6);
            color: #fff;
            box-shadow: 0 10px 25px rgba(59, 130, 246, .25);
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        /* ID CARD STYLE */
        .profile-box {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .avatar {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, #dbeafe, #eff6ff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 900;
            color: #1d4ed8;
        }

        .name {
            font-size: 18px;
            font-weight: 900;
            color: var(--text);
        }

        .sub {
            font-size: 12px;
            color: var(--muted);
        }
    </style>

    <div class="wrap">

        {{-- HEADER --}}
        <div class="header">
            <h4>Detail Driver</h4>
            <small>Informasi lengkap data driver transportasi publik</small>
        </div>

        <div class="card-modern">

            <div class="card-body">

                {{-- PROFILE --}}
                <div class="section-title">Profil Driver</div>

                <div class="profile-box info" style="margin-bottom:18px;">
                    <div class="avatar">
                        {{ strtoupper(substr($driver->driver_name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="name">{{ $driver->driver_name }}</div>
                        <div class="sub">{{ $driver->operator->operator_name ?? '-' }}</div>
                    </div>
                </div>

                {{-- GRID INFO --}}
                <div class="section-title">Data Driver</div>

                <div class="grid">

                    <div class="info">
                        <span class="label">Nama Driver</span>
                        <div class="value">{{ $driver->driver_name }}</div>
                    </div>

                    <div class="info">
                        <span class="label">Operator</span>
                        <div class="value">{{ $driver->operator->operator_name ?? '-' }}</div>
                    </div>

                    <div class="info">
                        <span class="label">No SIM</span>
                        <div class="value">{{ $driver->license_number }}</div>
                    </div>

                    <div class="info">
                        <span class="label">No HP</span>
                        <div class="value">{{ $driver->phone ?? '-' }}</div>
                    </div>

                    <div class="info">
                        <span class="label">Status</span>
                        <div class="value">
                            <span class="badge {{ $driver->status }}">
                                {{ ucfirst(str_replace('_', ' ', $driver->status)) }}
                            </span>
                        </div>
                    </div>

                    <div class="info">
                        <span class="label">Alamat</span>
                        <div class="value">{{ $driver->address ?? '-' }}</div>
                    </div>

                </div>

            </div>

            {{-- FOOTER --}}
            <div class="footer">

                <a href="{{ route('admin.drivers.index') }}" class="btn btn-back">
                    ← Kembali
                </a>

                <a href="{{ route('admin.drivers.edit', $driver->id) }}" class="btn btn-edit">
                    ✏ Edit Driver
                </a>

            </div>

        </div>

    </div>
@endsection
