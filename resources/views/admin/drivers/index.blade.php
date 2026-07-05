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
            background: #2563eb;
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
                <h3>Driver Management</h3>
                <small>Monitoring data driver transportasi publik</small>
            </div>

            <a href="{{ route('admin.drivers.create') }}" class="btn-add">
                <i class="ri-add-line"></i>
                Tambah Driver
            </a>

        </div>

        {{-- TABLE --}}
        <div class="card card-box">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

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

                                {{-- DRIVER NAME --}}
                                <td>
                                    <div class="fw-bold">{{ $d->driver_name }}</div>
                                    <small class="text-muted">{{ $d->address ?? '-' }}</small>
                                </td>

                                {{-- OPERATOR --}}
                                <td>
                                    {{ $d->operator->operator_name ?? '-' }}
                                </td>

                                {{-- LICENSE --}}
                                <td class="fw-semibold text-primary">
                                    {{ $d->license_number }}
                                </td>

                                {{-- PHONE --}}
                                <td>
                                    {{ $d->phone ?? '-' }}
                                </td>

                                {{-- STATUS --}}
                                <td>
                                    <span class="badge-status {{ $d->status }}">
                                        {{ ucfirst(str_replace('_', ' ', $d->status)) }}
                                    </span>
                                </td>

                                {{-- ACTION --}}
                                <td>
                                    <div class="action-group">

                                        <a href="{{ route('admin.drivers.show', $d->id) }}"
                                            class="btn btn-sm btn-outline-info btn-action" title="Detail">
                                            <i class="ri-eye-line"></i>
                                        </a>

                                        <a href="{{ route('admin.drivers.edit', $d->id) }}"
                                            class="btn btn-sm btn-outline-warning btn-action" title="Edit">
                                            <i class="ri-edit-line"></i>
                                        </a>

                                        <form action="{{ route('admin.drivers.destroy', $d->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus driver ini?')">

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
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="ri-inbox-line fs-3"></i>
                                    <div>Data driver tidak ditemukan</div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="p-3 border-top">
                {{ $drivers->links() }}
            </div>

        </div>

    </div>
@endsection
