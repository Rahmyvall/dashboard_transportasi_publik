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
            'progress' => 'w-75',
            'trendIcon' => 'ri-arrow-up-line',
        ],
        [
            'title' => 'Kendaraan Aktif',
            'value' => $totalArmada ?? '1.248',
            'note' => 'Naik 5,4%',
            'sub' => 'dibanding kemarin',
            'icon' => 'ri-bus-2-line',
            'color' => 'success',
            'progress' => 'w-75',
            'trendIcon' => 'ri-arrow-up-line',
        ],
        [
            'title' => 'Rute Aktif',
            'value' => $totalRute ?? '132',
            'note' => '100%',
            'sub' => 'dari total rute',
            'icon' => 'ri-road-map-line',
            'color' => 'info',
            'progress' => 'w-100',
            'trendIcon' => 'ri-check-line',
        ],
        [
            'title' => 'On-Time',
            'value' => $onTimePerformance ?? '92,6%',
            'note' => 'Naik 6,3%',
            'sub' => 'minggu ini',
            'icon' => 'ri-time-line',
            'color' => 'warning',
            'progress' => 'w-100',
            'trendIcon' => 'ri-arrow-up-line',
        ],
        [
            'title' => 'Peringatan',
            'value' => $peringatanAktif ?? '8',
            'note' => 'Perlu dipantau',
            'sub' => 'hari ini',
            'icon' => 'ri-alert-line',
            'color' => 'danger',
            'progress' => 'w-25',
            'trendIcon' => 'ri-error-warning-line',
        ],
    ];

    $statusRute = [
        [
            'nama' => 'BRT Koridor 1',
            'rute' => 'Blok M - Kota',
            'status' => 'Normal',
            'persen' => '94%',
            'warna' => 'success',
            'icon' => 'ri-bus-line',
            'progress' => 'w-100',
        ],
        [
            'nama' => 'KRL Bogor Line',
            'rute' => 'Bogor - Jakarta Kota',
            'status' => 'Normal',
            'persen' => '91%',
            'warna' => 'success',
            'icon' => 'ri-train-line',
            'progress' => 'w-100',
        ],
        [
            'nama' => 'MRT North-South',
            'rute' => 'Lebak Bulus - Bundaran HI',
            'status' => 'Normal',
            'persen' => '96%',
            'warna' => 'success',
            'icon' => 'ri-subway-line',
            'progress' => 'w-100',
        ],
        [
            'nama' => 'Angkot D05',
            'rute' => 'Kalideres - Grogol',
            'status' => 'Padat',
            'persen' => '78%',
            'warna' => 'warning',
            'icon' => 'ri-taxi-line',
            'progress' => 'w-75',
        ],
    ];

    $peringatan = [
        [
            'judul' => 'Kepadatan Lalu Lintas',
            'lokasi' => 'Jl. Sudirman arah Bundaran HI',
            'waktu' => '10:21 WIB',
            'warna' => 'warning',
            'icon' => 'ri-alert-line',
        ],
        [
            'judul' => 'Perbaikan Jalur KRL',
            'lokasi' => 'Stasiun Manggarai - Jatinegara',
            'waktu' => '10:15 WIB',
            'warna' => 'primary',
            'icon' => 'ri-information-line',
        ],
        [
            'judul' => 'Keterlambatan Armada',
            'lokasi' => 'Rute Angkot D05',
            'waktu' => '10:12 WIB',
            'warna' => 'danger',
            'icon' => 'ri-error-warning-line',
        ],
    ];

    $modaTransportasi = [
        [
            'nama' => 'BRT Transjakarta',
            'jumlah' => '598.027',
            'persen' => '48%',
            'warna' => 'primary',
            'progress' => 'w-50',
            'icon' => 'ri-bus-line',
        ],
        [
            'nama' => 'KRL',
            'jumlah' => '348.849',
            'persen' => '28%',
            'warna' => 'success',
            'progress' => 'w-25',
            'icon' => 'ri-train-line',
        ],
        [
            'nama' => 'MRT',
            'jumlah' => '186.883',
            'persen' => '15%',
            'warna' => 'info',
            'progress' => 'w-25',
            'icon' => 'ri-subway-line',
        ],
        [
            'nama' => 'Angkot / Minibus',
            'jumlah' => '112.131',
            'persen' => '9%',
            'warna' => 'warning',
            'progress' => 'w-25',
            'icon' => 'ri-taxi-line',
        ],
    ];

    $trenPenumpang = [
        ['tanggal' => '16 Mei', 'nilai' => '890K', 'warna' => 'primary', 'progress' => 'w-75'],
        ['tanggal' => '17 Mei', 'nilai' => '1.02M', 'warna' => 'primary', 'progress' => 'w-75'],
        ['tanggal' => '18 Mei', 'nilai' => '780K', 'warna' => 'warning', 'progress' => 'w-50'],
        ['tanggal' => '19 Mei', 'nilai' => '1.14M', 'warna' => 'primary', 'progress' => 'w-100'],
        ['tanggal' => '22 Mei', 'nilai' => '1.245M', 'warna' => 'success', 'progress' => 'w-100'],
    ];

    $onTimeData = [
        ['tanggal' => '16 Mei', 'nilai' => '88%', 'warna' => 'info', 'progress' => 'w-75'],
        ['tanggal' => '17 Mei', 'nilai' => '90%', 'warna' => 'info', 'progress' => 'w-75'],
        ['tanggal' => '18 Mei', 'nilai' => '89%', 'warna' => 'info', 'progress' => 'w-75'],
        ['tanggal' => '19 Mei', 'nilai' => '91%', 'warna' => 'success', 'progress' => 'w-100'],
        ['tanggal' => '22 Mei', 'nilai' => '93%', 'warna' => 'success', 'progress' => 'w-100'],
    ];

    $aktivitasSistem = [
        [
            'judul' => 'Data GPS berhasil diperbarui',
            'waktu' => 'Baru saja',
            'icon' => 'ri-map-pin-time-line',
            'warna' => 'success',
        ],
        [
            'judul' => 'Data tiket masuk tersinkron',
            'waktu' => '5 menit lalu',
            'icon' => 'ri-ticket-2-line',
            'warna' => 'primary',
        ],
        [
            'judul' => 'CCTV halte pusat aktif',
            'waktu' => '12 menit lalu',
            'icon' => 'ri-camera-line',
            'warna' => 'info',
        ],
    ];
@endphp

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <p class="text-muted mb-1">Dashboard / Monitoring</p>
                    <h3 class="fw-bold text-dark mb-0">
                        Monitoring Transportasi Publik
                    </h3>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-light border rounded-pill px-3">
                        <i class="ri-download-2-line me-1"></i>
                        Export
                    </button>
                    <button type="button" class="btn btn-primary rounded-pill px-3">
                        <i class="ri-refresh-line me-1"></i>
                        Refresh Data
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- HERO --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow bg-primary bg-gradient rounded-4 overflow-hidden">
                <div class="card-body p-4 p-lg-5 text-white">
                    <div class="row align-items-center g-4">
                        <div class="col-xl-8 col-lg-7">
                            <span class="badge bg-white bg-opacity-25 text-white rounded-pill px-3 py-2 mb-3">
                                <i class="ri-radar-line me-1"></i>
                                Smart Public Transport
                            </span>

                            <h1 class="fw-bold text-white mb-3">
                                {{ $title ?? 'Dashboard Monitoring Transportasi Publik' }}
                            </h1>

                            <p class="text-white-50 mb-4">
                                Pantau jumlah penumpang, kendaraan aktif, rute, kepadatan, dan ketepatan waktu operasional dalam satu halaman monitoring terpadu.
                            </p>

                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-light text-primary rounded-pill px-3 py-2">
                                    <i class="ri-database-2-line me-1"></i>
                                    Satu Data
                                </span>
                                <span class="badge bg-light text-primary rounded-pill px-3 py-2">
                                    <i class="ri-links-line me-1"></i>
                                    Terintegrasi
                                </span>
                                <span class="badge bg-light text-primary rounded-pill px-3 py-2">
                                    <i class="ri-pulse-line me-1"></i>
                                    Real-time
                                </span>
                                <span class="badge bg-light text-primary rounded-pill px-3 py-2">
                                    <i class="ri-shield-check-line me-1"></i>
                                    Monitoring Aktif
                                </span>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-5">
                            <div class="card border-0 rounded-4 shadow-sm mb-0">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-4">
                                        <div>
                                            <p class="text-muted mb-1">Status Sistem</p>
                                            <h4 class="fw-bold text-dark mb-0">Normal</h4>
                                        </div>

                                        <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center p-3">
                                            <i class="ri-checkbox-circle-line fs-3"></i>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between border-top pt-3 mb-2">
                                        <span class="text-muted">Tanggal</span>
                                        <strong class="text-dark">{{ date('d M Y') }}</strong>
                                    </div>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Waktu</span>
                                        <strong class="text-dark">{{ date('H:i') }} WIB</strong>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">Update</span>
                                        <span class="badge bg-success rounded-pill px-3 py-2">
                                            Online
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mt-4">
                        <div class="col-md-3 col-6">
                            <div class="bg-white bg-opacity-25 rounded-4 p-3 h-100">
                                <h4 class="fw-bold text-white mb-1">{{ $totalPenumpang ?? '1.245.890' }}</h4>
                                <small class="text-white-50">Penumpang Hari Ini</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="bg-white bg-opacity-25 rounded-4 p-3 h-100">
                                <h4 class="fw-bold text-white mb-1">{{ $totalArmada ?? '1.248' }}</h4>
                                <small class="text-white-50">Kendaraan Aktif</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="bg-white bg-opacity-25 rounded-4 p-3 h-100">
                                <h4 class="fw-bold text-white mb-1">{{ $totalRute ?? '132' }}</h4>
                                <small class="text-white-50">Rute Aktif</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="bg-white bg-opacity-25 rounded-4 p-3 h-100">
                                <h4 class="fw-bold text-white mb-1">{{ $onTimePerformance ?? '92,6%' }}</h4>
                                <small class="text-white-50">On-Time</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Filter Monitoring</h5>
                            <p class="text-muted small mb-0">
                                Pilih periode, wilayah, dan moda transportasi.
                            </p>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                            <i class="ri-filter-3-line me-1"></i>
                            Filter Data
                        </span>
                    </div>

                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold text-muted">Periode</label>
                            <select class="form-select rounded-4">
                                <option>Hari Ini</option>
                                <option>7 Hari Terakhir</option>
                                <option>Bulan Ini</option>
                                <option>Tahun Ini</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-semibold text-muted">Wilayah</label>
                            <select class="form-select rounded-4">
                                <option>Semua Wilayah</option>
                                <option>Jakarta Pusat</option>
                                <option>Jakarta Selatan</option>
                                <option>Jakarta Timur</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-semibold text-muted">Moda</label>
                            <select class="form-select rounded-4">
                                <option>Semua Moda</option>
                                <option>BRT</option>
                                <option>KRL</option>
                                <option>MRT</option>
                                <option>Angkot</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <button type="button" class="btn btn-primary w-100 rounded-4">
                                <i class="ri-search-eye-line me-1"></i>
                                Tampilkan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Sinkronisasi Data</h5>
                            <p class="text-muted small mb-0">Integrasi data operasional.</p>
                        </div>
                        <span class="badge bg-success rounded-pill px-3 py-2">Aktif</span>
                    </div>

                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-4 bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center p-3">
                            <i class="ri-cloud-line fs-4"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-semibold">Data Sync</span>
                                <span class="fw-bold text-success">100%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-success w-100"></div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">GPS Tracking</span>
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">CCTV</span>
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">Tiket</span>
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">Cuaca</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- STATISTIC CARDS --}}
    <div class="row g-3 mb-4">
        @foreach ($statCards as $card)
            <div class="col-xxl col-xl-4 col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <p class="text-muted small fw-semibold mb-2">{{ $card['title'] }}</p>
                                <h3 class="fw-bold text-dark mb-0">{{ $card['value'] }}</h3>
                            </div>

                            <div class="rounded-4 bg-{{ $card['color'] }} bg-opacity-10 text-{{ $card['color'] }} d-flex align-items-center justify-content-center p-3">
                                <i class="{{ $card['icon'] }} fs-4"></i>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <span class="badge bg-{{ $card['color'] }} bg-opacity-10 text-{{ $card['color'] }} rounded-pill">
                                    <i class="{{ $card['trendIcon'] }} me-1"></i>
                                    {{ $card['note'] }}
                                </span>
                                <small class="text-muted ms-1">{{ $card['sub'] }}</small>
                            </div>
                        </div>

                        <div class="progress">
                            <div class="progress-bar bg-{{ $card['color'] }} {{ $card['progress'] }}"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- MAIN CONTENT --}}
    <div class="row g-3 mb-4">
        {{-- LIVE MONITORING --}}
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Peta Live Monitoring</h5>
                            <p class="text-muted small mb-0">
                                Visualisasi rute, armada, halte, stasiun, dan titik kepadatan.
                            </p>
                        </div>

                        <span class="badge bg-success rounded-pill px-3 py-2">
                            <i class="ri-pulse-line me-1"></i>
                            Live
                        </span>
                    </div>

                    <div class="bg-dark text-white rounded-4 p-4">
                        <div class="row g-3">
                            <div class="col-lg-3">
                                <div class="bg-black bg-opacity-25 rounded-4 p-3 h-100">
                                    <h6 class="text-white mb-3">Legenda</h6>

                                    <p class="small mb-2">
                                        <span class="badge bg-primary me-2">&nbsp;</span>
                                        Bus / BRT
                                    </p>
                                    <p class="small mb-2">
                                        <span class="badge bg-success me-2">&nbsp;</span>
                                        KRL / MRT
                                    </p>
                                    <p class="small mb-2">
                                        <span class="badge bg-warning me-2">&nbsp;</span>
                                        Angkot
                                    </p>
                                    <p class="small mb-2">
                                        <i class="ri-map-pin-line text-info me-2"></i>
                                        Halte / Stasiun
                                    </p>
                                    <p class="small mb-0">
                                        <i class="ri-error-warning-line text-danger me-2"></i>
                                        Titik Padat
                                    </p>
                                </div>
                            </div>

                            <div class="col-lg-9">
                                <div class="row g-3 mb-3 text-center">
                                    <div class="col-md-4">
                                        <div class="border border-primary rounded-4 p-3 h-100">
                                            <i class="ri-bus-line fs-1 text-primary"></i>
                                            <h6 class="text-white mt-2 mb-1">BRT Koridor 1</h6>
                                            <small class="text-white-50">Blok M - Kota</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="border border-success rounded-4 p-3 h-100">
                                            <i class="ri-train-line fs-1 text-success"></i>
                                            <h6 class="text-white mt-2 mb-1">KRL Bogor Line</h6>
                                            <small class="text-white-50">Bogor - Jakarta Kota</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="border border-warning rounded-4 p-3 h-100">
                                            <i class="ri-taxi-line fs-1 text-warning"></i>
                                            <h6 class="text-white mt-2 mb-1">Angkot D05</h6>
                                            <small class="text-white-50">Kalideres - Grogol</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <div class="bg-primary bg-opacity-25 rounded-4 p-3 text-center h-100">
                                            <h4 class="fw-bold text-white mb-1">124</h4>
                                            <small class="text-white-50">Unit GPS</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="bg-success bg-opacity-25 rounded-4 p-3 text-center h-100">
                                            <h4 class="fw-bold text-white mb-1">18</h4>
                                            <small class="text-white-50">Halte Ramai</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="bg-danger bg-opacity-25 rounded-4 p-3 text-center h-100">
                                            <h4 class="fw-bold text-white mb-1">3</h4>
                                            <small class="text-white-50">Titik Padat</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-primary border-0 rounded-4 mb-2">
                                    <i class="ri-checkbox-circle-line me-1"></i>
                                    <strong>Stasiun Kota</strong> terpantau normal.
                                </div>

                                <div class="alert alert-success border-0 rounded-4 mb-2">
                                    <i class="ri-road-map-line me-1"></i>
                                    <strong>Koridor utama</strong> berjalan lancar.
                                </div>

                                <div class="alert alert-warning border-0 rounded-4 mb-0">
                                    <i class="ri-alert-line me-1"></i>
                                    <strong>Terminal Kampung Rambutan</strong> mengalami peningkatan kepadatan.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PANEL KANAN --}}
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Status Rute</h5>
                            <p class="text-muted small mb-0">Performa rute aktif.</p>
                        </div>
                        <a href="#" class="btn btn-sm btn-light border rounded-pill px-3">Detail</a>
                    </div>

                    @foreach ($statusRute as $item)
                        <div class="bg-light border rounded-4 p-3 mb-3">
                            <div class="d-flex gap-3">
                                <div class="rounded-4 bg-{{ $item['warna'] }} bg-opacity-10 text-{{ $item['warna'] }} d-flex align-items-center justify-content-center p-3">
                                    <i class="{{ $item['icon'] }} fs-4"></i>
                                </div>

                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center gap-2 mb-1">
                                        <h6 class="fw-bold mb-0">{{ $item['nama'] }}</h6>
                                        <span class="badge bg-{{ $item['warna'] }} rounded-pill">{{ $item['status'] }}</span>
                                    </div>

                                    <p class="text-muted small mb-2">{{ $item['rute'] }}</p>

                                    <div class="d-flex justify-content-between mb-1">
                                        <small class="text-muted">On-Time</small>
                                        <strong>{{ $item['persen'] }}</strong>
                                    </div>

                                    <div class="progress">
                                        <div class="progress-bar bg-{{ $item['warna'] }} {{ $item['progress'] }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Peringatan & Informasi</h5>
                            <p class="text-muted small mb-0">Notifikasi operasional terbaru.</p>
                        </div>
                        <span class="badge bg-danger rounded-pill px-3 py-2">{{ $peringatanAktif ?? '8' }}</span>
                    </div>

                    @foreach ($peringatan as $item)
                        <div class="bg-light border rounded-4 p-3 mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-{{ $item['warna'] }} text-white d-flex align-items-center justify-content-center p-2">
                                    <i class="{{ $item['icon'] }} fs-5"></i>
                                </div>

                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1">{{ $item['judul'] }}</h6>
                                    <p class="text-muted small mb-0">{{ $item['lokasi'] }}</p>
                                </div>

                                <small class="text-muted text-nowrap">{{ $item['waktu'] }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- BOTTOM CONTENT --}}
    <div class="row g-3 mb-4">
        {{-- TREN PENUMPANG --}}
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Tren Penumpang</h5>
                            <p class="text-muted small mb-0">Pergerakan jumlah penumpang.</p>
                        </div>
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">7 Hari</span>
                    </div>

                    @foreach ($trenPenumpang as $item)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">{{ $item['tanggal'] }}</span>
                                <strong>{{ $item['nilai'] }}</strong>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-{{ $item['warna'] }} {{ $item['progress'] }}"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- MODA TRANSPORTASI --}}
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Moda Transportasi</h5>
                            <p class="text-muted small mb-0">Distribusi penumpang berdasarkan moda.</p>
                        </div>
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">Hari Ini</span>
                    </div>

                    @foreach ($modaTransportasi as $moda)
                        <div class="bg-light border rounded-4 p-3 mb-3">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="rounded-4 bg-{{ $moda['warna'] }} bg-opacity-10 text-{{ $moda['warna'] }} d-flex align-items-center justify-content-center p-3">
                                    <i class="{{ $moda['icon'] }} fs-4"></i>
                                </div>

                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $moda['nama'] }}</strong>
                                        <strong class="text-{{ $moda['warna'] }}">{{ $moda['persen'] }}</strong>
                                    </div>
                                    <small class="text-muted">{{ $moda['jumlah'] }} penumpang</small>
                                </div>
                            </div>

                            <div class="progress">
                                <div class="progress-bar bg-{{ $moda['warna'] }} {{ $moda['progress'] }}"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ON TIME --}}
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">On-Time Performance</h5>
                            <p class="text-muted small mb-0">Ketepatan waktu operasional.</p>
                        </div>
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">7 Hari</span>
                    </div>

                    @foreach ($onTimeData as $data)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">{{ $data['tanggal'] }}</span>
                                <strong>{{ $data['nilai'] }}</strong>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-{{ $data['warna'] }} {{ $data['progress'] }}"></div>
                            </div>
                        </div>
                    @endforeach

                    <div class="alert alert-success border-0 rounded-4 mb-0 mt-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center p-2">
                                <i class="ri-check-double-line fs-5"></i>
                            </div>
                            <div>
                                <strong>Performa stabil</strong>
                                <p class="small mb-0 text-muted">
                                    Ketepatan waktu berada pada kategori baik.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- AKTIVITAS SISTEM --}}
    <div class="row g-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Aktivitas Sistem Terbaru</h5>
                            <p class="text-muted small mb-0">
                                Riwayat sinkronisasi dan aktivitas monitoring.
                            </p>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                            <i class="ri-history-line me-1"></i>
                            Log Sistem
                        </span>
                    </div>

                    <div class="row g-3">
                        @foreach ($aktivitasSistem as $aktivitas)
                            <div class="col-md-4">
                                <div class="bg-light border rounded-4 p-3 h-100">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-4 bg-{{ $aktivitas['warna'] }} bg-opacity-10 text-{{ $aktivitas['warna'] }} d-flex align-items-center justify-content-center p-3">
                                            <i class="{{ $aktivitas['icon'] }} fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">{{ $aktivitas['judul'] }}</h6>
                                            <small class="text-muted">{{ $aktivitas['waktu'] }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
