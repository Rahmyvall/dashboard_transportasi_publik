@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-0">Tambah Stop</h3>
            <small class="text-muted">Input halte, terminal, shelter, stasiun</small>
        </div>

        <a href="{{ route('admin.stops.index') }}" class="btn btn-light border shadow-sm">
            Kembali
        </a>

    </div>

    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body p-4">

            <form id="stopForm" action="{{ route('admin.stops.store') }}" method="POST">
                @csrf

                <div class="row g-4">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Stop</label>
                        <input type="text" name="stop_name" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Jenis Stop</label>
                        <select name="stop_type" class="form-select" required>
                            <option value="halte">Halte</option>
                            <option value="terminal">Terminal</option>
                            <option value="shelter">Shelter</option>
                            <option value="stasiun">Stasiun</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="is_active" class="form-select">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Alamat (Auto Maps)</label>
                        <input type="text" name="address" id="address" class="form-control" readonly>
                    </div>

                    {{-- MAP --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">Pilih Lokasi (klik / drag marker)</label>
                        <div id="map" style="height: 420px; border-radius: 12px;"></div>

                        <small id="mapWarning" class="text-danger d-none">
                            Lokasi wajib dipilih di peta
                        </small>
                    </div>

                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">

                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        Simpan
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

            let map = L.map('map').setView([-6.2, 106.8], 13);

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

                marker.on('dragend', function(e) {
                    let pos = marker.getLatLng();

                    document.getElementById('latitude').value = pos.lat;
                    document.getElementById('longitude').value = pos.lng;

                    reverseGeocode(pos.lat, pos.lng);
                });
            }

            map.on('click', function(e) {
                setMarker(e.latlng.lat, e.latlng.lng);
                document.getElementById('mapWarning').classList.add('d-none');
            });

            setTimeout(() => {
                map.invalidateSize();
            }, 300);

        });

        document.getElementById('stopForm').addEventListener('submit', function(e) {

            let lat = document.getElementById('latitude').value;
            let lng = document.getElementById('longitude').value;

            if (!lat || !lng) {
                e.preventDefault();
                document.getElementById('mapWarning').classList.remove('d-none');
            }
        });
    </script>
@endsection
