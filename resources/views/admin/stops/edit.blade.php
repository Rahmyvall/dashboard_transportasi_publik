@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-0">Edit Stop</h3>
            <small class="text-muted">Update data titik pemberhentian</small>
        </div>

        <a href="{{ route('admin.stops.index') }}" class="btn btn-light border shadow-sm">
            Kembali
        </a>

    </div>

    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body p-4">

            <form action="{{ route('admin.stops.update', $stop->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Stop</label>
                        <input type="text" name="stop_name" class="form-control" value="{{ $stop->stop_name }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jenis Stop</label>
                        <select name="stop_type" class="form-select">
                            <option value="halte" {{ $stop->stop_type == 'halte' ? 'selected' : '' }}>Halte</option>
                            <option value="terminal" {{ $stop->stop_type == 'terminal' ? 'selected' : '' }}>Terminal
                            </option>
                            <option value="shelter" {{ $stop->stop_type == 'shelter' ? 'selected' : '' }}>Shelter</option>
                            <option value="stasiun" {{ $stop->stop_type == 'stasiun' ? 'selected' : '' }}>Stasiun</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="is_active" class="form-select">
                            <option value="1" {{ $stop->is_active ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !$stop->is_active ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Alamat (Auto Maps)</label>
                        <input type="text" name="address" id="address" class="form-control"
                            value="{{ $stop->address }}" readonly>
                    </div>

                    {{-- MAP --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            Pilih Lokasi (klik / drag marker untuk ubah)
                        </label>

                        <div id="map" style="height: 420px; border-radius: 12px; border:1px solid #e5e7eb;">
                        </div>
                    </div>

                    {{-- LAT LONG --}}
                    <input type="hidden" name="latitude" id="latitude" value="{{ $stop->latitude }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ $stop->longitude }}">

                </div>

                <div class="mt-4 text-end">
                    <button class="btn btn-warning px-4">
                        Update
                    </button>
                </div>

            </form>

        </div>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // DEFAULT COORDINATE
            let lat = {{ $stop->latitude ?? -6.2 }};
            let lng = {{ $stop->longitude ?? 106.8 }};

            let map = L.map('map').setView([lat, lng], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19
            }).addTo(map);

            let marker = null;

            function reverseGeocode(lat, lng) {
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.display_name) {
                            document.getElementById('address').value = data.display_name;
                        }
                    });
            }

            function setMarker(lat, lng) {

                if (marker) {
                    map.removeLayer(marker);
                }

                marker = L.marker([lat, lng], {
                    draggable: true
                }).addTo(map);

                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

                reverseGeocode(lat, lng);

                marker.on('dragend', function() {
                    let pos = marker.getLatLng();

                    document.getElementById('latitude').value = pos.lat;
                    document.getElementById('longitude').value = pos.lng;

                    reverseGeocode(pos.lat, pos.lng);
                });
            }

            // INIT MARKER (DATA LAMA)
            if (lat && lng) {
                setMarker(lat, lng);
            }

            // CLICK MAP UPDATE LOCATION
            map.on('click', function(e) {
                setMarker(e.latlng.lat, e.latlng.lng);
            });

            // FIX MAP BLANK ISSUE
            setTimeout(() => {
                map.invalidateSize();
            }, 300);

        });
    </script>
@endsection
