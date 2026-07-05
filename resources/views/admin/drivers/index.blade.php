@extends('layouts.app')

@section('content')
    <style>
        .driver-page {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --primary-soft: #eff6ff;
            --success-soft: #dcfce7;
            --success: #15803d;
            --danger-soft: #fee2e2;
            --danger: #b91c1c;
            --warning-soft: #fef3c7;
            --warning: #b45309;
            --info-soft: #e0f2fe;
            --info: #0369a1;
            --border: #e5e7eb;
            --text: #111827;
            --muted: #6b7280;
            --bg: #f8fafc;
        }

        .driver-page {
            background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
            min-height: 100vh;
            padding-bottom: 30px;
        }

        .modern-header {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #2563eb, #1e3a8a);
            border-radius: 24px;
            padding: 26px;
            color: #fff;
            box-shadow: 0 18px 45px rgba(37, 99, 235, 0.22);
        }

        .modern-header::after {
            content: "";
            position: absolute;
            width: 240px;
            height: 240px;
            right: -70px;
            top: -90px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 50%;
        }

        .modern-header::before {
            content: "";
            position: absolute;
            width: 140px;
            height: 140px;
            right: 110px;
            bottom: -70px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .header-title {
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 6px;
            letter-spacing: -0.4px;
        }

        .header-subtitle {
            color: rgba(255, 255, 255, 0.82);
            font-size: 14px;
        }

        .btn-modern-add {
            background: #fff;
            color: var(--primary-dark);
            border: none;
            border-radius: 14px;
            padding: 11px 16px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.12);
            transition: all 0.2s ease;
        }

        .btn-modern-add:hover {
            color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.18);
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-top: 20px;
        }

        .summary-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 18px;
            box-shadow: 0 12px 35px rgba(15, 23, 42, 0.05);
        }

        .summary-card .icon {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--primary-soft);
            color: var(--primary);
            font-size: 22px;
            margin-bottom: 12px;
        }

        .summary-card .label {
            color: var(--muted);
            font-size: 13px;
        }

        .summary-card .value {
            color: var(--text);
            font-size: 24px;
            font-weight: 800;
            line-height: 1.2;
        }

        .modern-card {
            border: 1px solid var(--border);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.06);
            background: #fff;
        }

        .card-toolbar {
            padding: 18px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .toolbar-title {
            font-size: 17px;
            font-weight: 800;
            color: var(--text);
            margin: 0;
        }

        .toolbar-subtitle {
            color: var(--muted);
            font-size: 13px;
            margin-top: 3px;
        }

        .table-modern {
            margin-bottom: 0;
        }

        .table-modern thead th {
            background: #f9fafb;
            color: #475569;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 800;
            border-bottom: 1px solid var(--border);
            padding: 15px 18px;
            white-space: nowrap;
        }

        .table-modern tbody td {
            padding: 18px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            color: var(--text);
        }

        .table-modern tbody tr {
            transition: all 0.18s ease;
        }

        .table-modern tbody tr:hover {
            background: #f8fafc;
        }

        .driver-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .driver-avatar {
            width: 44px;
            height: 44px;
            border-radius: 16px;
            background: linear-gradient(135deg, #dbeafe, #eff6ff);
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 16px;
            flex-shrink: 0;
        }

        .driver-name {
            font-weight: 800;
            color: var(--text);
            line-height: 1.25;
        }

        .driver-address {
            color: var(--muted);
            font-size: 12px;
            margin-top: 3px;
            max-width: 260px;
        }

        .operator-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #f8fafc;
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: 7px 11px;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
        }

        .license-box {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--primary-soft);
            color: var(--primary-dark);
            padding: 7px 11px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 800;
        }

        .phone-text {
            color: #334155;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        .status-badge::before {
            content: "";
            width: 7px;
            height: 7px;
            border-radius: 999px;
            background: currentColor;
        }

        .status-active {
            background: var(--success-soft);
            color: var(--success);
        }

        .status-on-duty {
            background: var(--info-soft);
            color: var(--info);
        }

        .status-inactive {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .action-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-action {
            width: 38px;
            height: 38px;
            border-radius: 13px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border);
            background: #fff;
            transition: all 0.18s ease;
        }

        .btn-view {
            color: var(--info);
        }

        .btn-edit {
            color: var(--warning);
        }

        .btn-delete {
            color: var(--danger);
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.10);
        }

        .btn-view:hover {
            background: var(--info-soft);
            border-color: #bae6fd;
            color: var(--info);
        }

        .btn-edit:hover {
            background: var(--warning-soft);
            border-color: #fde68a;
            color: var(--warning);
        }

        .btn-delete:hover {
            background: var(--danger-soft);
            border-color: #fecaca;
            color: var(--danger);
        }

        .empty-state {
            padding: 60px 20px;
            text-align: center;
        }

        .empty-icon {
            width: 70px;
            height: 70px;
            border-radius: 24px;
            background: #f1f5f9;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            margin: 0 auto 16px;
        }

        .empty-title {
            color: var(--text);
            font-weight: 800;
            margin-bottom: 5px;
        }

        .empty-desc {
            color: var(--muted);
            font-size: 14px;
        }

        .pagination-wrap {
            padding: 16px 20px;
            border-top: 1px solid var(--border);
            background: #fff;
        }

        @media (max-width: 768px) {
            .modern-header {
                padding: 22px;
            }

            .header-title {
                font-size: 22px;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }

            .table-modern thead {
                display: none;
            }

            .table-modern tbody tr {
                display: block;
                padding: 14px;
                border-bottom: 1px solid var(--border);
            }

            .table-modern tbody td {
                display: flex;
                justify-content: space-between;
                gap: 14px;
                padding: 10px 0;
                border-bottom: none;
            }

            .table-modern tbody td::before {
                content: attr(data-label);
                font-size: 12px;
                font-weight: 800;
                color: var(--muted);
                text-transform: uppercase;
            }

            .table-modern tbody td:first-child {
                display: block;
            }

            .table-modern tbody td:first-child::before {
                display: none;
            }

            .action-group {
                justify-content: flex-end;
            }
        }
    </style>

    <div class="driver-page">

        {{-- HEADER --}}
        <div class="modern-header mb-4">
            <div class="header-content d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <div class="header-title">Driver Management</div>
                    <div class="header-subtitle">
                        Kelola data driver, operator, nomor SIM, dan status operasional.
                    </div>
                </div>

                <a href="{{ route('admin.drivers.create') }}" class="btn-modern-add">
                    <i class="ri-add-line"></i>
                    Tambah Driver
                </a>
            </div>
        </div>

        {{-- SUMMARY --}}
        <div class="summary-grid mb-4">
            <div class="summary-card">
                <div class="icon">
                    <i class="ri-user-3-line"></i>
                </div>
                <div class="label">Total Driver</div>
                <div class="value">{{ $drivers->total() }}</div>
            </div>

            <div class="summary-card">
                <div class="icon">
                    <i class="ri-steering-2-line"></i>
                </div>
                <div class="label">Data Ditampilkan</div>
                <div class="value">{{ $drivers->count() }}</div>
            </div>

            <div class="summary-card">
                <div class="icon">
                    <i class="ri-shield-check-line"></i>
                </div>
                <div class="label">Status Monitoring</div>
                <div class="value">Aktif</div>
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="modern-card">

            <div class="card-toolbar">
                <div>
                    <h5 class="toolbar-title">Daftar Driver</h5>
                    <div class="toolbar-subtitle">
                        Data driver transportasi publik yang terdaftar di sistem.
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-modern align-middle">

                    <thead>
                        <tr>
                            <th>Driver</th>
                            <th>Operator</th>
                            <th>SIM</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($drivers as $d)
                            <tr>
                                {{-- DRIVER --}}
                                <td data-label="Driver">
                                    <div class="driver-info">
                                        <div class="driver-avatar">
                                            {{ strtoupper(substr($d->driver_name, 0, 1)) }}
                                        </div>

                                        <div>
                                            <div class="driver-name">
                                                {{ $d->driver_name }}
                                            </div>

                                            <div class="driver-address">
                                                {{ $d->address ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- OPERATOR --}}
                                <td data-label="Operator">
                                    <span class="operator-pill">
                                        <i class="ri-building-4-line"></i>
                                        {{ $d->operator->operator_name ?? '-' }}
                                    </span>
                                </td>

                                {{-- LICENSE --}}
                                <td data-label="SIM">
                                    <span class="license-box">
                                        <i class="ri-id-card-line"></i>
                                        {{ $d->license_number }}
                                    </span>
                                </td>

                                {{-- PHONE --}}
                                <td data-label="Phone">
                                    <span class="phone-text">
                                        <i class="ri-phone-line me-1"></i>
                                        {{ $d->phone ?? '-' }}
                                    </span>
                                </td>

                                {{-- STATUS --}}
                                <td data-label="Status">
                                    <span class="status-badge status-{{ str_replace('_', '-', $d->status) }}">
                                        {{ ucfirst(str_replace('_', ' ', $d->status)) }}
                                    </span>
                                </td>

                                {{-- ACTION --}}
                                <td data-label="Aksi">
                                    <div class="action-group">

                                        <a href="{{ route('admin.drivers.show', $d->id) }}" class="btn-action btn-view"
                                            title="Detail">
                                            <i class="ri-eye-line"></i>
                                        </a>

                                        <a href="{{ route('admin.drivers.edit', $d->id) }}" class="btn-action btn-edit"
                                            title="Edit">
                                            <i class="ri-edit-line"></i>
                                        </a>

                                        <form action="{{ route('admin.drivers.destroy', $d->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus driver ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn-action btn-delete" title="Hapus">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="ri-inbox-line"></i>
                                        </div>

                                        <div class="empty-title">
                                            Data driver belum tersedia
                                        </div>

                                        <div class="empty-desc">
                                            Tambahkan driver baru untuk mulai mengelola data transportasi.
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <div class="pagination-wrap">
                {{ $drivers->links() }}
            </div>

        </div>

    </div>
@endsection
