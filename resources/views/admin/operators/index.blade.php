@extends('layouts.app')

@section('content')
    <style>
        .operator-page {
            --primary: #2563eb;
            --primary-soft: #eff6ff;
            --dark: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --bg-soft: #f8fafc;
        }

        .operator-header {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            border-radius: 20px;
            padding: 24px;
            color: #fff;
            box-shadow: 0 12px 30px rgba(37, 99, 235, 0.25);
        }

        .operator-header h3 {
            letter-spacing: -0.3px;
        }

        .operator-header small {
            color: rgba(255, 255, 255, 0.8);
        }

        .btn-add-operator {
            background: #fff;
            color: #1d4ed8;
            border: none;
            font-weight: 600;
            border-radius: 12px;
            padding: 10px 16px;
            transition: 0.2s ease;
        }

        .btn-add-operator:hover {
            background: #f8fafc;
            color: #1e40af;
            transform: translateY(-1px);
        }

        .filter-card,
        .table-card {
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        }

        .filter-card .form-control,
        .filter-card .form-select,
        .filter-card .input-group-text {
            border-color: var(--border);
            min-height: 44px;
        }

        .filter-card .form-control:focus,
        .filter-card .form-select:focus {
            border-color: #93c5fd;
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.12);
        }

        .table thead th {
            background: #0f172a;
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            border: none;
            padding: 15px 16px;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 16px;
            color: #334155;
            border-color: #f1f5f9;
            vertical-align: middle;
        }

        .table-hover tbody tr {
            transition: 0.18s ease;
        }

        .table-hover tbody tr:hover {
            background: #f8fafc;
        }

        .operator-avatar {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: var(--primary-soft);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            flex-shrink: 0;
        }

        .operator-name {
            color: #0f172a;
            font-weight: 700;
        }

        .operator-address {
            color: var(--muted);
            font-size: 13px;
        }

        .contact-info {
            display: flex;
            align-items: center;
            gap: 7px;
            color: #475569;
            white-space: nowrap;
        }

        .contact-info i {
            color: #94a3b8;
        }

        .status-badge {
            border-radius: 999px;
            padding: 7px 12px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .status-active {
            background: #dcfce7;
            color: #15803d;
        }

        .status-inactive {
            background: #fee2e2;
            color: #b91c1c;
        }

        .action-group {
            display: flex;
            justify-content: center;
            gap: 7px;
        }

        .btn-action {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: 0.18s ease;
        }

        .btn-action:hover {
            transform: translateY(-1px);
        }

        .empty-state {
            padding: 56px 20px;
            text-align: center;
            color: var(--muted);
        }

        .empty-state .empty-icon {
            width: 66px;
            height: 66px;
            border-radius: 20px;
            background: #f1f5f9;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
            font-size: 30px;
        }

        .pagination-wrapper {
            background: #fff;
            border-top: 1px solid var(--border);
        }

        .page-link {
            border-radius: 10px;
            margin: 0 3px;
            color: #2563eb;
            border-color: #e2e8f0;
        }

        .page-item.active .page-link {
            background: #2563eb;
            border-color: #2563eb;
        }

        @media (max-width: 768px) {
            .operator-header {
                padding: 20px;
            }

            .operator-header .d-flex {
                align-items: flex-start !important;
            }

            .btn-add-operator {
                width: 100%;
                justify-content: center;
            }

            .table tbody td {
                white-space: nowrap;
            }
        }
    </style>

    <div class="operator-page">

        <!-- HEADER -->
        <div class="operator-header mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white bg-opacity-25 rounded-4 d-flex align-items-center justify-content-center"
                            style="width: 52px; height: 52px;">
                            <i class="bi bi-people fs-3"></i>
                        </div>

                        <div>
                            <h3 class="mb-1 fw-bold">Data Operator</h3>
                            <small>Kelola data operator sistem secara mudah dan terstruktur</small>
                        </div>
                    </div>
                </div>

                <a href="{{ route('admin.operators.create') }}"
                    class="btn btn-add-operator shadow-sm d-flex align-items-center gap-2">
                    <i class="bi bi-plus-circle"></i>
                    Tambah Operator
                </a>

            </div>
        </div>

        <!-- ALERT -->
        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center gap-2 mb-4">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        <!-- FILTER -->
        <div class="card filter-card mb-4">
            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <div>
                        <h6 class="fw-bold mb-1">Filter Data</h6>
                        <small class="text-muted">Cari berdasarkan nama, email, nomor telepon, atau status operator</small>
                    </div>

                    @if (request('search') || request('status'))
                        <a href="{{ route('admin.operators.index') }}"
                            class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="bi bi-arrow-clockwise me-1"></i>
                            Reset
                        </a>
                    @endif
                </div>

                <form method="GET" action="{{ route('admin.operators.index') }}">
                    <div class="row g-3">

                        <div class="col-lg-8 col-md-7">
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari nama, email, atau nomor telepon..." value="{{ request('search') }}">
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>
                                    Aktif
                                </option>
                                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>
                                    Nonaktif
                                </option>
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-2 d-grid">
                            <button class="btn btn-dark rounded-3 d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-funnel"></i>
                                Filter
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>

        <!-- TABLE -->
        <div class="card table-card">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead>
                            <tr>
                                <th style="width: 70px;">No</th>
                                <th>Operator</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                                <th class="text-center" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($operators as $i => $op)
                                <tr>

                                    <!-- NO -->
                                    <td>
                                        <span class="badge bg-light text-secondary border px-3 py-2">
                                            {{ ($operators->firstItem() ?? 0) + $i }}
                                        </span>
                                    </td>

                                    <!-- OPERATOR -->
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="operator-avatar">
                                                {{ strtoupper(substr($op->operator_name, 0, 1)) }}
                                            </div>

                                            <div>
                                                <div class="operator-name">
                                                    {{ $op->operator_name }}
                                                </div>

                                                <div class="operator-address">
                                                    <i class="bi bi-geo-alt me-1"></i>
                                                    {{ $op->address ? \Illuminate\Support\Str::limit($op->address, 42) : 'Alamat belum diisi' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- PHONE -->
                                    <td>
                                        <div class="contact-info">
                                            <i class="bi bi-telephone"></i>
                                            <span>{{ $op->phone ?? '-' }}</span>
                                        </div>
                                    </td>

                                    <!-- EMAIL -->
                                    <td>
                                        <div class="contact-info">
                                            <i class="bi bi-envelope"></i>
                                            <span>{{ $op->email ?? '-' }}</span>
                                        </div>
                                    </td>

                                    <!-- STATUS -->
                                    <td>
                                        @if ($op->status == 'aktif')
                                            <span class="status-badge status-active">
                                                <i class="bi bi-check-circle-fill"></i>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="status-badge status-inactive">
                                                <i class="bi bi-x-circle-fill"></i>
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    <!-- DATE -->
                                    <td>
                                        <div class="contact-info">
                                            <i class="bi bi-calendar-event"></i>
                                            <span>
                                                {{ $op->created_at ? $op->created_at->format('d M Y') : '-' }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- ACTION -->
                                    <td>
                                        <div class="action-group">

                                            <a href="{{ route('admin.operators.show', $op->id) }}"
                                                class="btn btn-sm btn-outline-info btn-action" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.operators.edit', $op->id) }}"
                                                class="btn btn-sm btn-outline-warning btn-action" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form action="{{ route('admin.operators.destroy', $op->id) }}" method="POST"
                                                class="d-inline">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    onclick="return confirm('Yakin ingin menghapus data operator ini?')"
                                                    class="btn btn-sm btn-outline-danger btn-action" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                            </form>

                                        </div>
                                    </td>

                                </tr>
                            @empty

                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="bi bi-inbox"></i>
                                            </div>

                                            <h6 class="fw-bold mb-1">Data operator tidak ditemukan</h6>
                                            <p class="mb-0 small">
                                                Coba ubah kata kunci pencarian atau reset filter yang aktif.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <!-- PAGINATION -->
                <div class="pagination-wrapper d-flex justify-content-between align-items-center px-4 py-3 flex-wrap gap-3">

                    <div class="text-muted small">
                        Menampilkan
                        <strong>{{ $operators->firstItem() ?? 0 }}</strong>
                        -
                        <strong>{{ $operators->lastItem() ?? 0 }}</strong>
                        dari
                        <strong>{{ $operators->total() ?? 0 }}</strong>
                        data operator
                    </div>

                    <div>
                        {{ $operators->withQueryString()->links() }}
                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
