@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

            <div>
                <h2 class="fw-bold mb-1">Edit Rute</h2>
                <small class="text-muted">
                    Perbarui data rute transportasi. Kode rute dan durasi diproses otomatis oleh sistem.
                </small>
            </div>

            <a href="{{ route('admin.routes.index') }}" class="btn btn-outline-secondary rounded-3 px-4">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>

        </div>

        <!-- CARD -->
        <div class="card border-0 shadow-lg modern-card">

            <!-- CARD HEADER -->
            <div class="card-header bg-white border-0 p-4">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>
                        <h5 class="fw-bold mb-1">{{ $route->route_name }}</h5>
                        <small class="text-muted">
                            Kode Rute: {{ $route->route_code }}
                        </small>
                    </div>

                    <div>
                        @if ($route->status == 'active')
                            <span class="badge-soft success">
                                <i class="bi bi-check-circle me-1"></i> Active
                            </span>
                        @elseif ($route->status == 'inactive')
                            <span class="badge-soft danger">
                                <i class="bi bi-x-circle me-1"></i> Inactive
                            </span>
                        @else
                            <span class="badge-soft warning">
                                <i class="bi bi-tools me-1"></i> Maintenance
                            </span>
                        @endif
                    </div>

                </div>

            </div>

            <!-- FORM -->
            <div class="card-body p-4">

                <form action="{{ route('admin.routes.update', $route->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">

                        <!-- ROUTE CODE READONLY -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-upc-scan me-1"></i> Kode Rute
                            </label>

                            <input type="text" value="{{ $route->route_code }}"
                                class="form-control modern-input bg-light" readonly>

                            <small class="text-muted">
                                Kode rute tidak dapat diubah manual.
                            </small>
                        </div>

                        <!-- ROUTE NAME -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-signpost-split me-1"></i> Nama Rute
                            </label>

                            <input type="text" name="route_name" value="{{ old('route_name', $route->route_name) }}"
                                class="form-control modern-input @error('route_name') is-invalid @enderror" required>

                            @error('route_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- OPERATOR -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-building me-1"></i> Operator
                            </label>

                            <select name="operator_id"
                                class="form-select modern-input @error('operator_id') is-invalid @enderror" required>
                                <option value="">Pilih Operator</option>

                                @foreach ($operators as $o)
                                    <option value="{{ $o->id }}"
                                        {{ old('operator_id', $route->operator_id) == $o->id ? 'selected' : '' }}>
                                        {{ $o->operator_name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('operator_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- TRANSPORT MODE -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-truck me-1"></i> Transport Mode
                            </label>

                            <select name="transport_mode_id"
                                class="form-select modern-input @error('transport_mode_id') is-invalid @enderror" required>
                                <option value="">Pilih Transport</option>

                                @foreach ($transportModes as $t)
                                    <option value="{{ $t->id }}"
                                        {{ old('transport_mode_id', $route->transport_mode_id) == $t->id ? 'selected' : '' }}>
                                        {{ $t->mode_name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('transport_mode_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- ORIGIN -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-geo-alt me-1"></i> Asal
                            </label>

                            <input type="text" name="origin" value="{{ old('origin', $route->origin) }}"
                                class="form-control modern-input @error('origin') is-invalid @enderror" required>

                            @error('origin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- DESTINATION -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-flag me-1"></i> Tujuan
                            </label>

                            <input type="text" name="destination" value="{{ old('destination', $route->destination) }}"
                                class="form-control modern-input @error('destination') is-invalid @enderror" required>

                            @error('destination')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- DISTANCE -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-rulers me-1"></i> Jarak (KM)
                            </label>

                            <input type="number" step="0.01" min="0" name="distance_km" id="distance_km"
                                value="{{ old('distance_km', $route->distance_km) }}"
                                class="form-control modern-input @error('distance_km') is-invalid @enderror">

                            @error('distance_km')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- DURATION PREVIEW -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-clock me-1"></i> Estimasi Durasi
                            </label>

                            <input type="text" id="duration_preview"
                                value="{{ $route->estimated_duration_minutes ?? 0 }} menit"
                                class="form-control modern-input bg-light" readonly>

                            <small class="text-muted">
                                Durasi dihitung otomatis dari jarak dengan asumsi 40 km per jam.
                            </small>
                        </div>

                        <!-- STATUS -->
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-toggle-on me-1"></i> Status
                            </label>

                            <select name="status" class="form-select modern-input @error('status') is-invalid @enderror"
                                required>
                                <option value="active" {{ old('status', $route->status) == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="inactive"
                                    {{ old('status', $route->status) == 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>

                                <option value="maintenance"
                                    {{ old('status', $route->status) == 'maintenance' ? 'selected' : '' }}>
                                    Maintenance
                                </option>
                            </select>

                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <!-- INFO -->
                    <div class="alert alert-info border-0 shadow-sm rounded-4 mt-4">
                        <i class="bi bi-info-circle me-1"></i>
                        Kode rute tetap mengikuti data awal. Estimasi durasi akan dihitung ulang otomatis saat data
                        disimpan.
                    </div>

                    <!-- BUTTON -->
                    <div class="d-flex justify-content-end gap-2 mt-4">

                        <a href="{{ route('admin.routes.index') }}" class="btn btn-light px-4 rounded-3">
                            Cancel
                        </a>

                        <button type="submit" class="btn btn-success px-4 rounded-3">
                            <i class="bi bi-check-circle me-1"></i> Update Data
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <!-- STYLE -->
    <style>
        .modern-card {
            border-radius: 20px;
            overflow: hidden;
        }

        .modern-input {
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            padding: 10px 12px;
            transition: .2s ease;
        }

        .modern-input:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 .2rem rgba(16, 185, 129, .15);
        }

        label {
            font-size: 13px;
            color: #334155;
        }

        .badge-soft {
            padding: 7px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
        }

        .badge-soft.success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-soft.danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-soft.warning {
            background: #fef3c7;
            color: #92400e;
        }

        .btn {
            font-weight: 600;
        }
    </style>

    <!-- AUTO DURATION PREVIEW -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const distanceInput = document.getElementById('distance_km');
            const durationPreview = document.getElementById('duration_preview');

            function calculateDuration() {
                const distance = parseFloat(distanceInput.value) || 0;
                const speed = 40;

                if (distance <= 0) {
                    durationPreview.value = '0 menit';
                    return;
                }

                const duration = Math.round((distance / speed) * 60);
                durationPreview.value = duration + ' menit';
            }

            distanceInput.addEventListener('input', calculateDuration);
            calculateDuration();
        });
    </script>
@endsection
