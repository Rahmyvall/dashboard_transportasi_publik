@extends('layouts.app')

@section('content')
    <style>
        .page-wrap {
            --primary: #2563eb;
            --soft: #f8fafc;
            --border: #e2e8f0;
            --text: #0f172a;
        }

        .page-header {
            background: linear-gradient(135deg, #2563eb, #1e3a8a);
            color: #fff;
            padding: 22px;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(37, 99, 235, .25);
        }

        .page-header h3 {
            font-weight: 700;
            margin: 0;
        }

        .btn-add {
            background: #fff;
            color: #1d4ed8;
            border: none;
            font-weight: 600;
            border-radius: 12px;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .card-box {
            border: none;
            border-radius: 18px;
            box-shadow: 0 8px 24px rgba(97, 128, 202, 0.06);
            overflow: hidden;
        }

        .table thead {
            background: #6079b4;
            color: #fff;
        }

        .table tbody td {
            padding: 14px;
            vertical-align: middle;
        }

        .badge-status {
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
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

        .action-group {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .btn-action {
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }
    </style>

    <div class="page-wrap">

        {{-- HEADER --}}
        <div class="page-header mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h3>Vehicles Management</h3>
                <small>Monitoring armada transportasi publik</small>
            </div>

            <a href="{{ route('admin.vehicles.create') }}" class="btn-add">
                <i class="ri-add-line"></i>
                Tambah Vehicle
            </a>

        </div>

        {{-- FILTER --}}
        <div class="card-box mb-4 p-3">

            <form method="GET" class="row g-2">

                <div class="col-md-6">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Cari kode kendaraan / plat...">
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="available">Available</option>
                        <option value="on_trip">On Trip</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="col-md-3 d-grid">
                    <button class="btn btn-dark">
                        <i class="ri-search-line"></i> Filter
                    </button>
                </div>

            </form>

        </div>

        {{-- TABLE --}}
        <div class="card card-box">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Plat</th>
                            <th>Operator</th>
                            <th>Mode</th>
                            <th>Capacity</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($vehicles as $v)
                            <tr>

                                {{-- CODE --}}
                                <td class="fw-bold text-primary">
                                    {{ $v->vehicle_code }}
                                </td>

                                {{-- PLATE --}}
                                <td class="fw-semibold">
                                    {{ $v->plate_number ?? '-' }}
                                </td>

                                {{-- OPERATOR --}}
                                <td>
                                    {{ $v->operator->operator_name ?? '-' }}
                                </td>

                                {{-- MODE --}}
                                <td>
                                    {{ $v->transport_mode_id }}
                                </td>

                                {{-- CAPACITY --}}
                                <td>
                                    {{ $v->capacity ?? 0 }}
                                </td>

                                {{-- STATUS --}}
                                <td>
                                    <span class="badge-status {{ $v->status }}">
                                        {{ ucfirst(str_replace('_', ' ', $v->status)) }}
                                    </span>
                                </td>

                                {{-- ACTION --}}
                                <td>
                                    <div class="action-group">

                                        <a href="{{ route('admin.vehicles.show', $v->id) }}"
                                            class="btn btn-sm btn-outline-info btn-action" title="Detail">
                                            <i class="ri-eye-line"></i>
                                        </a>

                                        <a href="{{ route('admin.vehicles.edit', $v->id) }}"
                                            class="btn btn-sm btn-outline-warning btn-action" title="Edit">
                                            <i class="ri-edit-line"></i>
                                        </a>

                                        <form action="{{ route('admin.vehicles.destroy', $v->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus data ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-sm btn-outline-danger btn-action">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>

                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="ri-inbox-line fs-3"></i>
                                    <div>Data kendaraan tidak ditemukan</div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="p-3 border-top">
                {{ $vehicles->appends(request()->query())->links() }}
            </div>

        </div>

    </div>
@endsection
