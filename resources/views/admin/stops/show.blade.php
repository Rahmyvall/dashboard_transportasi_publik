@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-0">Detail Stop</h3>
            <small class="text-muted">Informasi titik pemberhentian transportasi</small>
        </div>

        <a href="{{ route('admin.stops.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>

    </div>

    {{-- HEADER CARD --}}
    <div class="card border-0 shadow-lg rounded-4 mb-4">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h4 class="fw-bold mb-1">
                        <i class="ri-map-pin-2-fill text-primary"></i>
                        {{ $stop->stop_name }}
                    </h4>

                    <div class="text-muted">
                        {{ $stop->address ?? 'Alamat tidak tersedia' }}
                    </div>
                </div>

                <div class="text-end">

                    <div class="mb-2">
                        @if ($stop->is_active)
                            <span class="badge bg-success px-3 py-2">
                                <i class="ri-checkbox-circle-line"></i> Aktif
                            </span>
                        @else
                            <span class="badge bg-danger px-3 py-2">
                                <i class="ri-close-circle-line"></i> Nonaktif
                            </span>
                        @endif
                    </div>

                    <span class="badge bg-light text-dark text-capitalize">
                        {{ $stop->stop_type }}
                    </span>

                </div>

            </div>

        </div>
    </div>

    {{-- DETAIL INFO --}}
    <div class="row g-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">

                    <div class="text-muted">Latitude</div>
                    <h5 class="fw-bold">{{ $stop->latitude ?? '-' }}</h5>

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">

                    <div class="text-muted">Longitude</div>
                    <h5 class="fw-bold">{{ $stop->longitude ?? '-' }}</h5>

                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">

                    <div class="text-muted">Status Sistem</div>

                    @if ($stop->is_active)
                        <h5 class="fw-bold text-success">Operational</h5>
                    @else
                        <h5 class="fw-bold text-danger">Inactive</h5>
                    @endif

                </div>
            </div>
        </div>

    </div>

    {{-- MAP --}}
    <div class="card border-0 shadow-lg rounded-4 mt-4">
        <div class="card-body">

            <div class="d-flex align-items-center mb-3">
                <i class="ri-map-2-line text-primary me-2"></i>
                <h5 class="fw-bold mb-0">Lokasi di Peta</h5>
            </div>

            <div id="map" style="height: 420px; border-radius: 14px;"></div>

        </div>
    </div>
@endsection


@section('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let lat = @json($stop->latitude ?? -6.2);
            let lng = @json($stop->longitude ?? 106.8);

            let map = L.map('map').setView([lat, lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19
            }).addTo(map);

            L.marker([lat, lng])
                .addTo(map)
                .bindPopup(`<b>{{ $stop->stop_name }}</b>`)
                .openPopup();

            setTimeout(() => {
                map.invalidateSize();
            }, 300);

        });
    </script>
@endsection
