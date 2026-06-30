@extends('layouts.app')

@section('content')
    @php
        $statCards = [
            [
                'title' => 'Total Penumpang Hari Ini',
                'value' => $totalPenumpang ?? '24.580',
                'note' => 'Naik 8.7%',
                'sub' => 'dibanding kemarin',
                'icon' => 'ri-group-line',
                'color' => 'primary',
                'progress' => 78,
            ],
            [
                'title' => 'Penumpang Aktif',
                'value' => $penumpangAktif ?? '18.240',
                'note' => 'Sedang perjalanan',
                'sub' => 'real-time',
                'icon' => 'ri-user-location-line',
                'color' => 'success',
                'progress' => 65,
            ],
            [
                'title' => 'Jam Sibuk',
                'value' => $jamSibuk ?? '07:00 - 09:00',
                'note' => 'Peak Time',
                'sub' => 'terpadat hari ini',
                'icon' => 'ri-time-line',
                'color' => 'warning',
                'progress' => 90,
            ],
            [
                'title' => 'Rata-rata Trip',
                'value' => $rataTrip ?? '2.4x',
                'note' => 'per penumpang',
                'sub' => 'hari ini',
                'icon' => 'ri-route-line',
                'color' => 'info',
                'progress' => 60,
            ],
        ];
    @endphp

    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold mb-0">Dashboard Penumpang</h3>
                <small class="text-muted">Analisis pergerakan dan aktivitas penumpang real-time</small>
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

            <div class="card-body bg-success text-white rounded">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h4 class="fw-bold mb-1">Passenger Analytics System</h4>
                        <small class="text-white-50">
                            Monitoring jumlah penumpang, jam sibuk, dan pola perjalanan
                        </small>
                    </div>

                    <div>
                        <span class="badge bg-light text-success p-2">
                            ● LIVE PASSENGER DATA
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

            {{-- LEFT --}}
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <h5 class="fw-bold mb-1">Pergerakan Penumpang Hari Ini</h5>
                        <small class="text-muted">Data boarding & turun penumpang real-time</small>

                        <div class="alert alert-primary mt-3 mb-4">
                            <i class="ri-information-line me-1"></i>
                            Sistem mencatat pergerakan penumpang dari seluruh armada aktif
                        </div>

                        {{-- mini stats --}}
                        <div class="row g-3">

                            <div class="col-md-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h4 class="fw-bold">{{ $boarding ?? 12480 }}</h4>
                                        <small class="text-muted">Boarding</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h4 class="fw-bold">{{ $alighting ?? 11230 }}</h4>
                                        <small class="text-muted">Turun</small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <h4 class="fw-bold">{{ $peakLoad ?? 92 }}%</h4>
                                        <small class="text-muted">Peak Load</small>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- RIGHT --}}
            <div class="col-lg-4">

                {{-- JAM TERPADAT --}}
                <div class="card border-0 shadow-sm mb-3">

                    <div class="card-body">

                        <h5 class="fw-bold mb-3">Jam Terpadat</h5>

                        @php
                            $jam = [
                                ['time' => '06:00 - 08:00', 'value' => '85%', 'color' => 'danger'],
                                ['time' => '08:00 - 10:00', 'value' => '92%', 'color' => 'danger'],
                                ['time' => '12:00 - 14:00', 'value' => '60%', 'color' => 'warning'],
                                ['time' => '17:00 - 19:00', 'value' => '88%', 'color' => 'danger'],
                            ];
                        @endphp

                        @foreach ($jam as $j)
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">

                                <span class="text-muted">{{ $j['time'] }}</span>

                                <span class="badge bg-{{ $j['color'] }}">
                                    {{ $j['value'] }}
                                </span>

                            </div>
                        @endforeach

                    </div>

                </div>


                {{-- STATUS SISTEM PENUMPANG --}}
                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <h5 class="fw-bold mb-3">Status Data</h5>

                        @php
                            $status = [
                                ['name' => 'Data Real-Time', 'status' => 'Active', 'color' => 'success'],
                                ['name' => 'Tracking GPS', 'status' => 'Connected', 'color' => 'success'],
                                ['name' => 'Sensor Penumpang', 'status' => 'Stable', 'color' => 'success'],
                                ['name' => 'Update Data', 'status' => '5 sec', 'color' => 'primary'],
                            ];
                        @endphp

                        @foreach ($status as $s)
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">

                                <span class="text-muted">{{ $s['name'] }}</span>

                                <span class="badge bg-{{ $s['color'] }}">
                                    {{ $s['status'] }}
                                </span>

                            </div>
                        @endforeach

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
