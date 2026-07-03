@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">

        <!-- HERO -->
        <div class="hero-shell mb-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>
                    <h2 class="title">Edit Route Stop</h2>
                    <p class="subtitle">Mengubah urutan halte pada rute transportasi</p>
                </div>

                <a href="{{ route('admin.route-stops.index') }}" class="btn btn-light btn-modern">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>

            </div>

        </div>

        <!-- ERROR -->
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- CARD -->
        <div class="card card-modern border-0 shadow-lg">

            <div class="card-body p-4">

                <form action="{{ route('admin.route-stops.update', $routeStop->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <!-- ROUTE -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Route</label>
                            <select name="route_id" class="form-select" required>
                                <option value="">-- Pilih Route --</option>

                                @foreach ($routes as $route)
                                    <option value="{{ $route->id }}"
                                        {{ old('route_id', $routeStop->route_id) == $route->id ? 'selected' : '' }}>
                                        {{ $route->route_name ?? $route->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <!-- STOP -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Stop / Halte</label>
                            <select name="stop_id" class="form-select" required>
                                <option value="">-- Pilih Stop --</option>

                                @foreach ($stops as $stop)
                                    <option value="{{ $stop->id }}"
                                        {{ old('stop_id', $routeStop->stop_id) == $stop->id ? 'selected' : '' }}>
                                        {{ $stop->stop_name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <!-- ORDER -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Urutan Stop</label>
                            <input type="number" name="stop_order" class="form-control"
                                value="{{ old('stop_order', $routeStop->stop_order) }}" required>
                        </div>

                        <!-- DISTANCE -->
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Jarak dari Awal (KM)</label>
                            <input type="number" step="0.01" name="distance_from_start_km" class="form-control"
                                value="{{ old('distance_from_start_km', $routeStop->distance_from_start_km) }}">
                        </div>

                        <!-- INFO -->
                        <div class="col-12">
                            <div class="alert alert-info mt-2">
                                <i class="bi bi-info-circle me-1"></i>
                                ETA akan dihitung ulang otomatis berdasarkan jarak.
                            </div>
                        </div>

                    </div>

                    <!-- BUTTON -->
                    <div class="mt-4 d-flex gap-2">

                        <button class="btn btn-primary btn-modern">
                            <i class="bi bi-save me-1"></i> Update
                        </button>

                        <a href="{{ route('admin.route-stops.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <style>
        .hero-shell {
            padding: 18px;
            border-radius: 16px;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
        }

        .title {
            font-size: 22px;
            font-weight: 700;
        }

        .subtitle {
            font-size: 13px;
            color: #64748b;
            margin: 0;
        }

        .card-modern {
            border-radius: 16px;
        }

        .btn-modern {
            box-shadow: 0 10px 25px rgba(59, 130, 246, .25);
            border-radius: 10px;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 10px;
        }
    </style>
@endsection
