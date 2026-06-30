@extends('layouts.app')

@section('content')
    @php
        $statCards = [
            [
                'title' => 'Total Perjalanan',
                'value' => $totalPerjalanan ?? '48',
                'note' => 'Jadwal Hari Ini',
                'sub' => 'seluruh perjalanan',
                'icon' => 'ri-route-line',
                'color' => 'primary',
                'progress' => 100,
            ],
            [
                'title' => 'Sudah Berangkat',
                'value' => $sudahBerangkat ?? '18',
                'note' => 'Berjalan',
                'sub' => 'armada telah berangkat',
                'icon' => 'ri-bus-line',
                'color' => 'success',
                'progress' => 65,
            ],
            [
                'title' => 'Dalam Perjalanan',
                'value' => $dalamPerjalanan ?? '12',
                'note' => 'Aktif',
                'sub' => 'sedang menuju tujuan',
                'icon' => 'ri-road-map-line',
                'color' => 'info',
                'progress' => 55,
            ],
            [
                'title' => 'Selesai',
                'value' => $selesaiPerjalanan ?? '15',
                'note' => 'Selesai',
                'sub' => 'telah tiba tujuan',
                'icon' => 'ri-checkbox-circle-line',
                'color' => 'warning',
                'progress' => 75,
            ],
            [
                'title' => 'Terlambat',
                'value' => $terlambatPerjalanan ?? '3',
                'note' => 'Perhatian',
                'sub' => 'melebihi jadwal',
                'icon' => 'ri-alert-line',
                'color' => 'danger',
                'progress' => 25,
            ],
        ];

        $perjalananList = $perjalananHariIni ?? [
            [
                'kode' => 'PJ-001',
                'rute' => 'Terminal Utama - Stasiun Kota',
                'armada' => 'BUS-021',
                'pengemudi' => 'Budi Santoso',
                'jam_berangkat' => '07:00',
                'jam_tiba' => '08:15',
                'status' => 'Dalam Perjalanan',
            ],
            [
                'kode' => 'PJ-002',
                'rute' => 'Bandara - Pusat Kota',
                'armada' => 'BUS-014',
                'pengemudi' => 'Andi Pratama',
                'jam_berangkat' => '07:30',
                'jam_tiba' => '08:45',
                'status' => 'Sudah Berangkat',
            ],
            [
                'kode' => 'PJ-003',
                'rute' => 'Terminal Barat - Terminal Timur',
                'armada' => 'BUS-033',
                'pengemudi' => 'Rahmat Hidayat',
                'jam_berangkat' => '08:00',
                'jam_tiba' => '09:20',
                'status' => 'Terlambat',
            ],
            [
                'kode' => 'PJ-004',
                'rute' => 'Stasiun Kota - Kampus Utama',
                'armada' => 'BUS-045',
                'pengemudi' => 'Deni Saputra',
                'jam_berangkat' => '09:00',
                'jam_tiba' => '10:10',
                'status' => 'Menunggu',
            ],
        ];

        function statusColorPerjalanan($status)
        {
            return match ($status) {
                'Sudah Berangkat' => 'success',
                'Dalam Perjalanan' => 'info',
                'Selesai' => 'primary',
                'Terlambat' => 'danger',
                'Dibatalkan' => 'dark',
                default => 'warning',
            };
        }
    @endphp

    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold mb-0">Dashboard Perjalanan Hari Ini</h3>
                <small class="text-muted">
                    Monitoring jadwal, armada, pengemudi, dan status perjalanan harian
                </small>
            </div>

            <div>
                <span class="badge bg-dark p-2">
                    <i class="ri-calendar-line me-1"></i>
                    {{ date('d M Y H:i') }} WIB
                </span>
            </div>

        </div>


        {{-- HERO --}}
        <div class="card shadow-sm border-0 mb-4">

            <div class="card-body bg-primary text-white rounded">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h4 class="fw-bold mb-1">Perjalanan Operasional Hari Ini</h4>
                        <small class="text-white-50">
                            Pantau seluruh perjalanan berdasarkan jadwal keberangkatan, armada, dan status perjalanan
                        </small>
                    </div>

                    <div>
                        <span class="badge bg-light text-primary p-2">
                            ● LIVE MONITORING
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

            {{-- LEFT CONTENT --}}
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm mb-3">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <div>
                                <h5 class="fw-bold mb-1">Daftar Perjalanan Hari Ini</h5>
                                <small class="text-muted">
                                    Data perjalanan berdasarkan jadwal keberangkatan hari ini
                                </small>
                            </div>

                            <span class="badge bg-primary p-2">
                                {{ count($perjalananList) }} Data
                            </span>

                        </div>

                        <div class="alert alert-info mb-4">
                            <i class="ri-information-line me-1"></i>
                            Perjalanan ditampilkan berdasarkan jadwal operasional hari ini.
                        </div>

                        <div class="table-responsive">

                            <table class="table table-hover align-middle mb-0">

                                <thead class="table-light">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Rute</th>
                                        <th>Armada</th>
                                        <th>Pengemudi</th>
                                        <th>Berangkat</th>
                                        <th>Tiba</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($perjalananList as $item)
                                        @php
                                            $kode = data_get($item, 'kode', data_get($item, 'kode_perjalanan', '-'));
                                            $rute = data_get($item, 'rute', '-');
                                            $armada = data_get($item, 'armada', '-');
                                            $pengemudi = data_get($item, 'pengemudi', '-');
                                            $jamBerangkat = data_get($item, 'jam_berangkat', '-');
                                            $jamTiba = data_get($item, 'jam_tiba', '-');
                                            $status = data_get($item, 'status', 'Menunggu');
                                            $statusColor = statusColorPerjalanan($status);
                                        @endphp

                                        <tr>
                                            <td>
                                                <span class="fw-bold">{{ $kode }}</span>
                                            </td>

                                            <td>
                                                <div class="fw-semibold">{{ $rute }}</div>
                                                <small class="text-muted">Rute perjalanan</small>
                                            </td>

                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    {{ $armada }}
                                                </span>
                                            </td>

                                            <td>{{ $pengemudi }}</td>

                                            <td>
                                                <i class="ri-time-line me-1 text-success"></i>
                                                {{ $jamBerangkat }}
                                            </td>

                                            <td>
                                                <i class="ri-map-pin-time-line me-1 text-primary"></i>
                                                {{ $jamTiba }}
                                            </td>

                                            <td>
                                                <span class="badge bg-{{ $statusColor }}">
                                                    {{ $status }}
                                                </span>
                                            </td>
                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                Belum ada data perjalanan hari ini
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>


            {{-- RIGHT CONTENT --}}
            <div class="col-lg-4">

                {{-- RINGKASAN STATUS --}}
                <div class="card border-0 shadow-sm mb-3">

                    <div class="card-body">

                        <h5 class="fw-bold mb-3">Ringkasan Status</h5>

                        @php
                            $statusPerjalanan = [
                                [
                                    'name' => 'Menunggu Berangkat',
                                    'value' => $menungguBerangkat ?? '8',
                                    'color' => 'warning',
                                ],
                                [
                                    'name' => 'Sudah Berangkat',
                                    'value' => $sudahBerangkat ?? '18',
                                    'color' => 'success',
                                ],
                                [
                                    'name' => 'Dalam Perjalanan',
                                    'value' => $dalamPerjalanan ?? '12',
                                    'color' => 'info',
                                ],
                                [
                                    'name' => 'Selesai',
                                    'value' => $selesaiPerjalanan ?? '15',
                                    'color' => 'primary',
                                ],
                                [
                                    'name' => 'Terlambat',
                                    'value' => $terlambatPerjalanan ?? '3',
                                    'color' => 'danger',
                                ],
                            ];
                        @endphp

                        @foreach ($statusPerjalanan as $status)
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">

                                <span class="text-muted">{{ $status['name'] }}</span>

                                <span class="badge bg-{{ $status['color'] }}">
                                    {{ $status['value'] }}
                                </span>

                            </div>
                        @endforeach

                    </div>

                </div>


                {{-- KESIAPAN OPERASIONAL --}}
                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <h5 class="fw-bold mb-3">Kesiapan Operasional</h5>

                        @php
                            $operasional = [
                                ['name' => 'Armada Siap Jalan', 'status' => 'Siap', 'color' => 'success'],
                                ['name' => 'Pengemudi Bertugas', 'status' => 'Aktif', 'color' => 'success'],
                                ['name' => 'Jadwal Perjalanan', 'status' => 'Terjadwal', 'color' => 'primary'],
                                ['name' => 'Keterlambatan', 'status' => 'Dipantau', 'color' => 'warning'],
                            ];
                        @endphp

                        @foreach ($operasional as $item)
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">

                                <span class="text-muted">{{ $item['name'] }}</span>

                                <span class="badge bg-{{ $item['color'] }}">
                                    {{ $item['status'] }}
                                </span>

                            </div>
                        @endforeach

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
