@extends('layouts.app')

@section('content')
    @php
        $statCards = [
            [
                'title' => 'Armada Terpantau',
                'value' => $armadaTerkoneksi ?? '128',
                'note' => 'Online GPS',
                'sub' => 'aktif realtime',
                'icon' => 'ri-signal-tower-line',
                'color' => 'success',
                'progress' => 85,
            ],
            [
                'title' => 'Armada Bergerak',
                'value' => $armadaBergerak ?? '96',
                'note' => 'Moving',
                'sub' => 'sedang perjalanan',
                'icon' => 'ri-bus-line',
                'color' => 'primary',
                'progress' => 72,
            ],
            [
                'title' => 'Idle / Berhenti',
                'value' => $armadaIdle ?? '32',
                'note' => 'Standby',
                'sub' => 'tidak bergerak',
                'icon' => 'ri-pause-circle-line',
                'color' => 'warning',
                'progress' => 40,
            ],
            [
                'title' => 'Alert Lokasi',
                'value' => $alertLokasi ?? '5',
                'note' => 'Warning',
                'sub' => 'anomali GPS',
                'icon' => 'ri-alert-line',
                'color' => 'danger',
                'progress' => 20,
            ],
        ];
    @endphp


    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold mb-0">Dashboard Peta Realtime</h3>
                <small class="text-muted">Monitoring posisi armada berbasis GPS live tracking</small>
            </div>

            <div>
                <span class="badge bg-dark p-2">
                    <i class="ri-time-line me-1"></i>
                    {{ date('d M Y H:i') }} WIB
                </span>
            </div>

        </div>


        {{-- HERO --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-body bg-dark text-white rounded">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h4 class="fw-bold mb-1">Real-Time Fleet Map System</h4>
                        <small class="text-white-50">
                            Tracking posisi armada secara langsung di peta digital
                        </small>
                    </div>

                    <div>
                        <span class="badge bg-success p-2">
                            ● LIVE GPS TRACKING
                        </span>
                    </div>

                </div>

            </div>

        </div>


        {{-- STAT CARDS --}}
        <div class="row g-3 mb-4">

            @foreach ($statCards as $card)
                <div class="col-md-6 col-xl-3">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>
                                    <small class="text-muted">{{ $card['title'] }}</small>
                                    <h4 class="fw-bold mb-0">{{ $card['value'] }}</h4>
                                </div>

                                <div class="text-{{ $card['color'] }} fs-3">
                                    <i class="{{ $card['icon'] }}"></i>
                                </div>

                            </div>

                            <div class="mt-3">

                                <span class="badge bg-{{ $card['color'] }}">
                                    {{ $card['note'] }}
                                </span>

                                <div class="text-muted small mt-1">
                                    {{ $card['sub'] }}
                                </div>

                            </div>

                            <div class="progress mt-3" style="height:6px;">
                                <div class="progress-bar bg-{{ $card['color'] }}" style="width: {{ $card['progress'] }}%">
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            @endforeach

        </div>


        {{-- CONTENT --}}
        <div class="row g-3">

            {{-- MAP SECTION --}}
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <div>
                                <h5 class="fw-bold mb-0">Peta Realtime Armada</h5>
                                <small class="text-muted">Posisi kendaraan live tracking</small>
                            </div>

                            <span class="badge bg-success">LIVE</span>

                        </div>

                        {{-- MAP PLACEHOLDER --}}
                        <div style="height: 420px; border-radius: 12px; overflow:hidden; background:#e9ecef;"
                            class="d-flex align-items-center justify-content-center">

                            <div class="text-center">
                                <i class="ri-map-pin-line fs-1 text-primary"></i>
                                <p class="mt-2 text-muted mb-0">Map Realtime akan ditampilkan di sini</p>
                                <small class="text-muted">
                                    (Integrasi: Leaflet.js / Google Maps API)
                                </small>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- RIGHT PANEL --}}
            <div class="col-lg-4">

                {{-- STATUS ARMADA --}}
                <div class="card border-0 shadow-sm mb-3">

                    <div class="card-body">

                        <h5 class="fw-bold mb-3">Status Armada</h5>

                        @php
                            $fleetStatus = [
                                ['name' => 'Online GPS', 'value' => '128', 'color' => 'success'],
                                ['name' => 'Moving', 'value' => '96', 'color' => 'primary'],
                                ['name' => 'Idle', 'value' => '32', 'color' => 'warning'],
                                ['name' => 'Offline', 'value' => '4', 'color' => 'danger'],
                            ];
                        @endphp

                        @foreach ($fleetStatus as $f)
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">

                                <span class="text-muted">{{ $f['name'] }}</span>

                                <span class="badge bg-{{ $f['color'] }}">
                                    {{ $f['value'] }}
                                </span>

                            </div>
                        @endforeach

                    </div>

                </div>


                {{-- ALERT REALTIME --}}
                <div class="card border-0 shadow-sm mb-3">

                    <div class="card-body">

                        <h5 class="fw-bold mb-3">Alert Realtime</h5>

                        @php
                            $alerts = [
                                ['text' => 'Armada keluar jalur', 'color' => 'danger'],
                                ['text' => 'GPS delay 12 detik', 'color' => 'warning'],
                                ['text' => 'Speed abnormal detected', 'color' => 'danger'],
                                ['text' => 'Koneksi stabil kembali', 'color' => 'success'],
                            ];
                        @endphp

                        @foreach ($alerts as $a)
                            <div class="d-flex align-items-center py-2 border-bottom">

                                <span class="badge bg-{{ $a['color'] }} me-2">●</span>
                                <span class="text-muted small">{{ $a['text'] }}</span>

                            </div>
                        @endforeach

                    </div>

                </div>


                {{-- AKTIVITAS TERAKHIR --}}
                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <h5 class="fw-bold mb-3">Aktivitas Terakhir</h5>

                        @php
                            $logs = [
                                ['time' => '10:01', 'text' => 'Armada BUS-12 update lokasi'],
                                ['time' => '10:03', 'text' => 'Armada BUS-09 berhenti sementara'],
                                ['time' => '10:05', 'text' => 'GPS reconnect BUS-21'],
                                ['time' => '10:07', 'text' => 'Armada BUS-33 mulai bergerak'],
                            ];
                        @endphp

                        @foreach ($logs as $log)
                            <div class="d-flex justify-content-between py-2 border-bottom">

                                <small class="text-primary">{{ $log['time'] }}</small>
                                <small class="text-muted text-end" style="max-width:70%;">
                                    {{ $log['text'] }}
                                </small>

                            </div>
                        @endforeach

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
