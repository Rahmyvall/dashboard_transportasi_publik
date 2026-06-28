@extends('layouts.app')

@section('content')
    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="mb-0 fw-bold">Detail Operator</h3>
            <small class="text-muted">Informasi lengkap data operator sistem</small>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('admin.operators.print.detail', $operator->id) }}" target="_blank"
                class="btn btn-outline-dark d-flex align-items-center gap-2 shadow-sm">
                <i class="bi bi-printer"></i>
                Print
            </a>

            <a href="{{ route('admin.operators.edit', $operator->id) }}"
                class="btn btn-warning d-flex align-items-center gap-2 shadow-sm">
                <i class="bi bi-pencil-square"></i>
                Edit
            </a>

            <a href="{{ route('admin.operators.index') }}"
                class="btn btn-secondary d-flex align-items-center gap-2 shadow-sm">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>

        </div>

    </div>

    <!-- MAIN CARD -->
    <div class="card border-0 shadow-lg rounded-4">

        <div class="card-body p-4">

            <div class="row g-4">

                <!-- LEFT COLUMN -->
                <div class="col-md-6">

                    <div class="p-3 border rounded-3 bg-light h-100">

                        <div class="text-muted small mb-1">
                            <i class="bi bi-person me-1"></i> Nama Operator
                        </div>

                        <h5 class="fw-bold mb-0">
                            {{ $operator->operator_name }}
                        </h5>

                    </div>

                </div>

                <!-- STATUS -->
                <div class="col-md-6">

                    <div class="p-3 border rounded-3 bg-light h-100">

                        <div class="text-muted small mb-1">
                            <i class="bi bi-shield-check me-1"></i> Status
                        </div>

                        @if ($operator->status == 'aktif')
                            <span class="badge bg-success px-3 py-2">
                                <i class="bi bi-check-circle me-1"></i> Aktif
                            </span>
                        @else
                            <span class="badge bg-danger px-3 py-2">
                                <i class="bi bi-x-circle me-1"></i> Nonaktif
                            </span>
                        @endif

                    </div>

                </div>

                <!-- PHONE -->
                <div class="col-md-6">

                    <div class="p-3 border rounded-3 h-100">

                        <div class="text-muted small mb-1">
                            <i class="bi bi-telephone me-1"></i> No Telepon
                        </div>

                        <div class="fw-semibold">
                            {{ $operator->phone ?? '-' }}
                        </div>

                    </div>

                </div>

                <!-- EMAIL -->
                <div class="col-md-6">

                    <div class="p-3 border rounded-3 h-100">

                        <div class="text-muted small mb-1">
                            <i class="bi bi-envelope me-1"></i> Email
                        </div>

                        <div class="fw-semibold">
                            {{ $operator->email ?? '-' }}
                        </div>

                    </div>

                </div>

                <!-- ADDRESS -->
                <div class="col-12">

                    <div class="p-3 border rounded-3">

                        <div class="text-muted small mb-1">
                            <i class="bi bi-geo-alt me-1"></i> Alamat
                        </div>

                        <div>
                            {{ $operator->address ?? '-' }}
                        </div>

                    </div>

                </div>

                <!-- DATE -->
                <div class="col-12">

                    <div class="p-3 border rounded-3 bg-light">

                        <div class="text-muted small mb-1">
                            <i class="bi bi-calendar me-1"></i> Tanggal Dibuat
                        </div>

                        <div class="fw-semibold">
                            {{ $operator->created_at?->format('d M Y H:i') }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
