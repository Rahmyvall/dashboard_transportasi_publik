@extends('layouts.app')

@section('content')
    <style>
        .tm-page {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --soft: #eff6ff;
            --dark: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --danger-soft: #fef2f2;
            --warning-soft: #fffbeb;
            background: #f8fafc;
            min-height: 100vh;
            padding-bottom: 32px;
        }

        .tm-header {
            background:
                linear-gradient(135deg, rgba(37, 99, 235, .96), rgba(30, 64, 175, .96)),
                radial-gradient(circle at top right, rgba(255, 255, 255, .28), transparent 35%);
            border-radius: 24px;
            padding: 28px;
            color: #fff;
            box-shadow: 0 16px 40px rgba(37, 99, 235, .28);
            position: relative;
            overflow: hidden;
        }

        .tm-header::after {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            right: -60px;
            bottom: -80px;
            background: rgba(255, 255, 255, .16);
            border-radius: 50%;
        }

        .tm-header-content {
            position: relative;
            z-index: 2;
        }

        .tm-title-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .tm-btn {
            border-radius: 12px;
            font-weight: 600;
            padding: 9px 14px;
        }

        .tm-btn-add {
            background: #fff;
            color: var(--primary);
            border: none;
            box-shadow: 0 8px 20px rgba(15, 23, 42, .16);
        }

        .tm-btn-add:hover {
            background: #f8fafc;
            color: var(--primary-dark);
        }

        .tm-card {
            border: 1px solid var(--border);
            border-radius: 22px;
            box-shadow: 0 10px 28px rgba(15, 23, 42, .06);
            overflow: hidden;
            background: #fff;
        }

        .tm-search-wrapper {
            position: relative;
        }

        .tm-search-wrapper i {
            position: absolute;
            top: 50%;
            left: 16px;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 18px;
        }

        .tm-search-input {
            padding-left: 44px;
            height: 48px;
            border-radius: 14px;
            border-color: var(--border);
        }

        .tm-search-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 .2rem rgba(37, 99, 235, .12);
        }

        .tm-info-box {
            background: var(--soft);
            border: 1px solid #bfdbfe;
            color: var(--primary-dark);
            border-radius: 16px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .tm-info-box i {
            font-size: 22px;
        }

        .tm-table {
            margin-bottom: 0;
        }

        .tm-table thead th {
            background: #0f172a;
            color: #fff;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .04em;
            padding: 16px;
            border: none;
            white-space: nowrap;
        }

        .tm-table tbody td {
            padding: 16px;
            color: #334155;
            border-bottom: 1px solid #eef2f7;
            vertical-align: middle;
        }

        .tm-table tbody tr:hover {
            background: #f8fafc;
        }

        .tm-table tbody tr:last-child td {
            border-bottom: none;
        }

        .tm-number {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            background: #f1f5f9;
            color: #475569;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
        }

        .tm-badge {
            background: #dbeafe;
            color: #1d4ed8;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .tm-name {
            font-weight: 700;
            color: var(--dark);
        }

        .tm-desc {
            color: var(--muted);
            max-width: 520px;
        }

        .tm-action-group {
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .tm-action-btn {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: .2s;
        }

        .tm-edit {
            color: #d97706;
            background: var(--warning-soft);
            border: 1px solid #fde68a;
        }

        .tm-edit:hover {
            color: #fff;
            background: #d97706;
            border-color: #d97706;
        }

        .tm-delete {
            color: #dc2626;
            background: var(--danger-soft);
            border: 1px solid #fecaca;
        }

        .tm-delete:hover {
            color: #fff;
            background: #dc2626;
            border-color: #dc2626;
        }

        .tm-empty {
            padding: 56px 24px;
            text-align: center;
        }

        .tm-empty-icon {
            width: 72px;
            height: 72px;
            border-radius: 22px;
            background: #f1f5f9;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            margin: 0 auto 16px;
        }

        .tm-footer {
            background: #fff;
            padding: 16px;
            border-top: 1px solid var(--border);
        }

        @media (max-width: 768px) {
            .tm-header {
                padding: 22px;
            }

            .tm-table thead {
                display: none;
            }

            .tm-table tbody tr {
                display: block;
                padding: 14px;
                border-bottom: 1px solid var(--border);
            }

            .tm-table tbody td {
                display: flex;
                justify-content: space-between;
                gap: 16px;
                padding: 10px 0;
                border-bottom: none;
            }

            .tm-table tbody td::before {
                content: attr(data-label);
                font-weight: 700;
                color: var(--dark);
            }

            .tm-action-group {
                justify-content: flex-end;
            }

            .tm-desc {
                text-align: right;
            }
        }
    </style>

    <div class="tm-page container-fluid py-4">

        {{-- HEADER --}}
        <div class="tm-header mb-4">
            <div class="tm-header-content d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div class="d-flex align-items-center gap-3">
                    <div class="tm-title-icon">
                        <i class="bi bi-bus-front"></i>
                    </div>

                    <div>
                        <h3 class="mb-1 fw-bold">Data Moda Transportasi</h3>
                        <small class="opacity-75">
                            Kelola kode, nama, dan deskripsi moda transportasi.
                        </small>
                    </div>
                </div>

                <a href="{{ route('admin.transport-modes.create') }}" class="btn tm-btn tm-btn-add">
                    <i class="bi bi-plus-lg me-1"></i>
                    Tambah Moda
                </a>

            </div>
        </div>

        {{-- SEARCH --}}
        <div class="card tm-card mb-4">
            <div class="card-body">
                <div class="row align-items-center g-3">

                    <div class="col-lg-8">
                        <form method="GET">
                            <div class="d-flex gap-2 flex-wrap flex-md-nowrap">

                                <div class="tm-search-wrapper flex-grow-1">
                                    <i class="bi bi-search"></i>
                                    <input type="text" name="search" class="form-control tm-search-input"
                                        placeholder="Cari kode atau nama moda transportasi..."
                                        value="{{ request('search') }}">
                                </div>

                                <button class="btn btn-primary tm-btn px-4">
                                    Cari
                                </button>

                                @if (request('search'))
                                    <a href="{{ route('admin.transport-modes.index') }}"
                                        class="btn btn-outline-secondary tm-btn px-4">
                                        Reset
                                    </a>
                                @endif

                            </div>
                        </form>
                    </div>

                    <div class="col-lg-4">
                        <div class="tm-info-box">
                            <i class="bi bi-database-check"></i>
                            <div>
                                <div class="fw-bold">
                                    {{ $transportModes->total() ?? 0 }} Data
                                </div>
                                <small>Total moda transportasi tersedia</small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="card tm-card">

            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-hover align-middle tm-table">

                        <thead>
                            <tr>
                                <th width="80">No</th>
                                <th width="160">Kode</th>
                                <th>Nama Moda</th>
                                <th>Deskripsi</th>
                                <th width="140" class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($transportModes as $i => $item)
                                <tr>
                                    <td data-label="No">
                                        <span class="tm-number">
                                            {{ ($transportModes->firstItem() ?? 0) + $i }}
                                        </span>
                                    </td>

                                    <td data-label="Kode">
                                        <span class="tm-badge">
                                            <i class="bi bi-hash"></i>
                                            {{ $item->mode_code }}
                                        </span>
                                    </td>

                                    <td data-label="Nama Moda">
                                        <span class="tm-name">
                                            {{ $item->mode_name }}
                                        </span>
                                    </td>

                                    <td data-label="Deskripsi">
                                        <div class="tm-desc">
                                            {{ $item->description ?? 'Belum ada deskripsi' }}
                                        </div>
                                    </td>

                                    <td data-label="Aksi">
                                        <div class="tm-action-group">

                                            <a href="{{ route('admin.transport-modes.edit', $item->id) }}"
                                                class="tm-action-btn tm-edit" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form action="{{ route('admin.transport-modes.destroy', $item->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="tm-action-btn tm-delete" title="Hapus"
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="tm-empty">
                                            <div class="tm-empty-icon">
                                                <i class="bi bi-inbox"></i>
                                            </div>

                                            <h5 class="fw-bold mb-1">Data belum tersedia</h5>
                                            <p class="text-muted mb-3">
                                                Belum ada data moda transportasi yang tersimpan.
                                            </p>

                                            <a href="{{ route('admin.transport-modes.create') }}"
                                                class="btn btn-primary tm-btn">
                                                <i class="bi bi-plus-lg me-1"></i>
                                                Tambah Data Pertama
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>
            </div>

            @if ($transportModes->hasPages())
                <div class="tm-footer">
                    {{ $transportModes->links() }}
                </div>
            @endif

        </div>

    </div>
@endsection
