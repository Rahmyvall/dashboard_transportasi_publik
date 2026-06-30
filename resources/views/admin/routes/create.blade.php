@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h2 class="fw-bold mb-1">Tambah Rute</h2>
                <small class="text-muted">Kode rute & durasi dibuat otomatis oleh sistem</small>
            </div>

            <a href="{{ route('admin.routes.index') }}" class="btn btn-outline-secondary">
                ← Kembali
            </a>

        </div>

        <!-- CARD -->
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-4">

                <form action="{{ route('admin.routes.store') }}" method="POST">
                    @csrf

                    <div class="row g-4">

                        <!-- OPERATOR -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Operator</label>
                            <select name="operator_id" class="form-select modern-input" required>
                                <option value="">-- Pilih Operator --</option>
                                @foreach ($operators as $o)
                                    <option value="{{ $o->id }}">
                                        {{ $o->operator_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- TRANSPORT -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Transport Mode</label>
                            <select name="transport_mode_id" class="form-select modern-input" required>
                                <option value="">-- Pilih Transport --</option>
                                @foreach ($transportModes as $t)
                                    <option value="{{ $t->id }}">
                                        {{ $t->mode_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- NAMA ROUTE -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Rute</label>
                            <input type="text" name="route_name" class="form-control modern-input"
                                placeholder="Contoh: Jakarta - Bandung" required>
                        </div>

                        <!-- ASAL -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Asal</label>
                            <input type="text" name="origin" class="form-control modern-input" placeholder="Kota asal"
                                required>
                        </div>

                        <!-- TUJUAN -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tujuan</label>
                            <input type="text" name="destination" class="form-control modern-input"
                                placeholder="Kota tujuan" required>
                        </div>

                        <!-- DISTANCE -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jarak (KM)</label>
                            <input type="number" step="0.01" name="distance_km" id="distance_km"
                                class="form-control modern-input" placeholder="Opsional (akan mempengaruhi durasi)">
                        </div>

                        <!-- STATUS -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select modern-input" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                        </div>

                    </div>

                    <!-- INFO AUTO SYSTEM -->
                    <div class="alert alert-info mt-4 border-0 shadow-sm rounded-3">
                        <strong>Info Sistem:</strong><br>
                        ✔ Kode rute otomatis dibuat berdasarkan operator<br>
                        ✔ Durasi otomatis dihitung dari jarak (40 km/jam)
                    </div>

                    <!-- BUTTON -->
                    <div class="d-flex justify-content-end gap-2 mt-3">

                        <a href="{{ route('admin.routes.index') }}" class="btn btn-light px-4">
                            Cancel
                        </a>

                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <!-- STYLE -->
    <style>
        .modern-input {
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            padding: 10px 12px;
            transition: .2s;
        }

        .modern-input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 .2rem rgba(99, 102, 241, .15);
        }

        .card {
            border-radius: 18px;
        }

        label {
            font-size: 13px;
            color: #334155;
        }
    </style>
@endsection
