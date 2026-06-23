@extends('layouts.app')

@section('content')
    @php
        $statCards = [
            [
                'title' => 'Total Penumpang',
                'value' => $totalPenumpang ?? '1.245.890',
                'note' => 'Naik 8,7%',
                'sub' => 'dibanding kemarin',
                'icon' => 'ri-group-line',
                'color' => 'primary',
                'progress' => 75,
            ],
            [
                'title' => 'Total Armada Aktif',
                'value' => $totalArmadaAktif ?? '1.248',
                'note' => 'Siap Operasi',
                'sub' => 'hari ini',
                'icon' => 'ri-bus-2-line',
                'color' => 'success',
                'progress' => 78,
            ],
            [
                'title' => 'Rute Aktif',
                'value' => $totalRute ?? '132',
                'note' => 'Optimal',
                'sub' => 'seluruh jaringan',
                'icon' => 'ri-road-map-line',
                'color' => 'info',
                'progress' => 100,
            ],
            [
                'title' => 'On-Time',
                'value' => $onTimePerformance ?? '92,6%',
                'note' => 'Stabil',
                'sub' => 'minggu ini',
                'icon' => 'ri-time-line',
                'color' => 'warning',
                'progress' => 92,
            ],
            [
                'title' => 'Peringatan',
                'value' => $peringatanAktif ?? '8',
                'note' => 'Perhatian',
                'sub' => 'hari ini',
                'icon' => 'ri-alert-line',
                'color' => 'danger',
                'progress' => 25,
            ],
        ];
    @endphp


    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold mb-0">Dashboard Transportasi Publik</h3>
                <small class="text-muted">Real-time monitoring system</small>
            </div>

            <div>
                <span class="badge bg-dark p-2">
                    <i class="ri-time-line me-1"></i>
                    {{ date('d M Y H:i') }} WIB
                </span>
            </div>

        </div>


        {{-- HERO --}}
        <div class="card shadow-sm border-0 mb-4">

            <div class="card-body bg-primary text-white rounded">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h4 class="fw-bold mb-1">Fleet Monitoring System</h4>
                        <small class="text-white-50">
                            Monitoring armada, penumpang, dan rute secara real-time
                        </small>
                    </div>

                    <div>
                        <span class="badge bg-light text-primary p-2">
                            ● LIVE SYSTEM
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
                                <div class="progress-bar bg-{{ $card['color'] }}" role="progressbar"
                                    style="width: {{ $card['progress'] }}%">
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            @endforeach

        </div>


        {{-- CONTENT --}}
        <div class="row g-3">

            {{-- LEFT --}}
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <h5 class="fw-bold mb-1">Live Monitoring Armada</h5>
                        <small class="text-muted">Status operasional semua armada</small>

                        <div class="alert alert-success mt-3 mb-4">
                            <i class="ri-checkbox-circle-line me-1"></i>
                            Semua sistem berjalan normal tanpa gangguan
                        </div>

                        <div class="row g-3">

                            <div class="col-md-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h4 class="fw-bold">124</h4>
                                        <small class="text-muted">GPS Active</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h4 class="fw-bold">{{ $totalArmadaAktif ?? 1248 }}</h4>
                                        <small class="text-muted">Armada Aktif</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h4 class="fw-bold">18</h4>
                                        <small class="text-muted">Rute Padat</small>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- RIGHT --}}
            <div class="col-lg-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <h5 class="fw-bold mb-3">System Status</h5>

                        @php
                            $systems = [
                                ['name' => 'Server', 'status' => 'Online', 'color' => 'success'],
                                ['name' => 'Database', 'status' => 'Stable', 'color' => 'success'],
                                ['name' => 'API Gateway', 'status' => 'Active', 'color' => 'success'],
                            ];
                        @endphp

                        @foreach ($systems as $sys)
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">

                                <span class="text-muted">{{ $sys['name'] }}</span>

                                <span class="badge bg-{{ $sys['color'] }}">
                                    {{ $sys['status'] }}
                                </span>

                            </div>
                        @endforeach

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
