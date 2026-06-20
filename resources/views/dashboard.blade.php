<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Dashboard Monitoring Transportasi Publik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Dashboard Monitoring Transportasi Publik" name="description" />
    <meta content="Transportasi Publik" name="author" />

    <!-- ICONS -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet">

    <!-- BOOTSTRAP (WAJIB STABLE) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- LOCAL TEMPLATE (SAFE LOAD) -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet">
    <style>
    .stat-card {
        border-radius: 14px;
        border: 1px solid rgba(0, 0, 0, .06);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 24px;
    }

    .map-box {
        height: 360px;
        border-radius: 14px;
        background: linear-gradient(135deg, #eef5ff, #f8fbff);
        border: 1px dashed #9bb7d4;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .bw-toggle-active {
        background: #111111 !important;
        color: #ffffff !important;
        border-radius: 50%;
    }

    body.bw-dark {
        background: #000000 !important;
        color: #ffffff !important;
    }

    body.bw-dark #page-topbar,
    body.bw-dark .navbar-header,
    body.bw-dark .vertical-menu,
    body.bw-dark .page-content,
    body.bw-dark .main-content,
    body.bw-dark .footer,
    body.bw-dark .right-bar,
    body.bw-dark .dropdown-menu,
    body.bw-dark .card,
    body.bw-dark .stat-card {
        background: #000000 !important;
        color: #ffffff !important;
        border-color: #2b2b2b !important;
    }

    body.bw-dark a,
    body.bw-dark .header-item,
    body.bw-dark .metismenu li a,
    body.bw-dark .menu-title,
    body.bw-dark .page-title-box h4,
    body.bw-dark .breadcrumb-item,
    body.bw-dark .breadcrumb-item a,
    body.bw-dark .text-muted,
    body.bw-dark .dropdown-item,
    body.bw-dark h1,
    body.bw-dark h2,
    body.bw-dark h3,
    body.bw-dark h4,
    body.bw-dark h5,
    body.bw-dark h6,
    body.bw-dark p,
    body.bw-dark span,
    body.bw-dark td,
    body.bw-dark th {
        color: #ffffff !important;
    }

    body.bw-dark .sub-menu li a {
        color: #dcdcdc !important;
    }

    body.bw-dark .form-control {
        background: #111111 !important;
        color: #ffffff !important;
        border-color: #333333 !important;
    }

    body.bw-dark .form-control::placeholder {
        color: #bdbdbd !important;
    }

    body.bw-dark .dropdown-item:hover,
    body.bw-dark .dropdown-icon-item:hover,
    body.bw-dark .notification-item:hover {
        background: #151515 !important;
    }

    body.bw-dark .map-box {
        background: #080808 !important;
        border-color: #ffffff !important;
    }

    .dashboard-hero {
        background: linear-gradient(135deg, #0B63B6 0%, #052B58 100%);
        position: relative;
        overflow: hidden;
    }

    .dashboard-hero::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        right: -80px;
        top: -100px;
    }

    .kpi-card {
        transition: all 0.25s ease;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08) !important;
    }

    .icon-box {
        width: 54px;
        height: 54px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .danger-card {
        border-left: 5px solid #dc3545 !important;
    }

    .map-box {
        border: 1px dashed #b5cce3;
    }

    .alert-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 14px 16px;
        border-radius: 18px;
        margin-bottom: 12px;
    }

    .alert-item.danger {
        background: #fff1f1;
        color: #842029;
    }

    .alert-item.warning {
        background: #fff8e6;
        color: #7a5200;
    }

    .alert-item.info {
        background: #eef7ff;
        color: #055160;
    }

    .status-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 13px 0;
        border-bottom: 1px solid #edf0f3;
    }

    .status-row:last-child {
        border-bottom: none;
    }

    .status-dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 8px;
    }

    .chart-placeholder {
        height: 260px;
        background: linear-gradient(135deg, #f3f6f8, #eef5ff);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        border: 1px dashed #b5cce3;
    }

    .route-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8fafc;
        border-radius: 16px;
        padding: 14px 16px;
        margin-bottom: 12px;
    }

    .menu-link {
        display: flex;
        align-items: center;
        padding: 10px 12px;
        border-radius: 10px;
        color: #495057;
        transition: 0.2s;
    }

    .menu-link:hover {
        background: #f1f5f9;
        color: #0d6efd;
    }

    .sub-menu li a {
        padding: 8px 12px;
        display: block;
        border-radius: 8px;
        color: #6c757d;
        transition: 0.2s;
    }

    .sub-menu li a:hover {
        background: #eef2ff;
        color: #0d6efd;
        padding-left: 16px;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }

    .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }
    </style>
</head>

<body data-topbar="dark">

    <div id="layout-wrapper">

        <!-- Header -->
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <div class="navbar-brand-box">
                        <a href="{{ url('/dashboard') }}" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="logo-sm" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('backend/assets/images/logo-dark.png') }}" alt="logo-dark"
                                    height="20">
                            </span>
                        </a>

                        <a href="{{ url('/dashboard') }}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="logo-sm-light"
                                    height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('backend/assets/images/logo-light.png') }}" alt="logo-light"
                                    height="20">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>

                    <form class="app-search d-none d-lg-block">
                        <div class="position-relative">
                            <input type="text" class="form-control" placeholder="Cari data transportasi...">
                            <span class="ri-search-line"></span>
                        </div>
                    </form>
                </div>

                <div class="d-flex">
                    <div class="dropdown d-inline-block d-lg-none ms-2">
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="ri-search-line"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-search-dropdown">
                            <form class="p-3">
                                <div class="mb-3 m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Cari data transportasi...">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="ri-search-line"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="bw-theme-toggle"
                            title="Black / White Mode">
                            <i class="ri-moon-line" id="bw-theme-icon"></i>
                        </button>
                    </div>

                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line"></i>
                        </button>
                    </div>
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-notification-3-line"></i>
                            <span class="noti-dot"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0">Notifikasi</h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="{{ url('/monitoring/notifikasi-alert') }}" class="small">Lihat
                                            Semua</a>
                                    </div>
                                </div>
                            </div>

                            <div data-simplebar style="max-height: 230px;">
                                <a href="{{ url('/monitoring/keterlambatan') }}" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-warning rounded-circle font-size-16">
                                                <i class="ri-time-line"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mb-1">Keterlambatan armada</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">3 armada terlambat dari jadwal.</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 5 menit lalu</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="{{ url('/monitoring/insiden-perjalanan') }}"
                                    class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-danger rounded-circle font-size-16">
                                                <i class="ri-alert-line"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mb-1">Insiden perjalanan</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">Ada laporan insiden pada rute utama.</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 10 menit lalu</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block user-dropdown">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user"
                                src="{{ asset('backend/assets/images/users/avatar-1.jpg') }}" alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ms-1">Admin</span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ url('/profile') }}">
                                <i class="ri-user-line align-middle me-1"></i> Profile
                            </a>
                            <a class="dropdown-item" href="{{ url('/pengaturan/user') }}">
                                <i class="ri-settings-2-line align-middle me-1"></i> Pengaturan
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="{{ url('/logout') }}">
                                <i class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Left Sidebar Start -->
        <div class="vertical-menu">
            <div data-simplebar class="h-100">

                {{-- PROFILE --}}
                <div class="user-profile text-center py-4 px-3 border-bottom">

                    <img src="{{ asset('backend/assets/images/users/avatar-1.jpg') }}"
                        class="avatar-md rounded-circle shadow-sm border">

                    <div class="mt-3">
                        <h6 class="mb-0 fw-semibold">{{ __('Admin Transportasi') }}</h6>
                        <small class="text-muted d-flex justify-content-center align-items-center gap-1 mt-1">
                            <span class="status-dot bg-success"></span>
                            Online
                        </small>
                    </div>

                </div>

                {{-- MENU --}}
                <div id="sidebar-menu" class="px-2 py-3">

                    <ul class="metismenu list-unstyled" id="side-menu">

                        {{-- TITLE --}}
                        <li class="menu-title px-3 mt-2 mb-2 text-uppercase small text-muted">
                            {{ __('Menu Transportasi') }}
                        </li>

                        {{-- ================= DASHBOARD ================= --}}
                        <li>
                            <a class="has-arrow waves-effect menu-link">
                                <i class="ri-dashboard-line me-2"></i>
                                <span>{{ __('Dashboard') }}</span>
                                <span class="badge bg-primary ms-auto">6</span>
                            </a>

                            <ul class="sub-menu">
                                <li><a href="{{ url('/dashboard') }}">Ringkasan Dashboard</a></li>
                                <li><a href="{{ url('/dashboard/armada-aktif') }}">Armada Aktif</a></li>
                                <li><a href="{{ url('/dashboard/perjalanan-hari-ini') }}">Perjalanan Hari Ini</a></li>
                                <li><a href="{{ url('/dashboard/jumlah-penumpang') }}">Jumlah Penumpang</a></li>
                                <li><a href="{{ url('/dashboard/jumlah-insiden') }}">Insiden</a></li>
                                <li><a href="{{ url('/dashboard/peta-realtime-armada') }}">Peta Realtime</a></li>
                            </ul>
                        </li>

                        {{-- ================= MASTER ================= --}}
                        <li>
                            <a class="has-arrow waves-effect menu-link">
                                <i class="ri-database-2-line me-2"></i>
                                <span>Data Master</span>
                                <span class="dot bg-primary ms-auto"></span>
                            </a>

                            <ul class="sub-menu">
                                <li><a href="{{ url('/operator') }}">Operator</a></li>
                                <li><a href="{{ url('/armada') }}">Armada</a></li>
                                <li><a href="{{ url('/pengemudi') }}">Pengemudi</a></li>
                                <li><a href="{{ url('/jenis-transportasi') }}">Jenis Transportasi</a></li>
                                <li><a href="{{ url('/rute') }}">Rute</a></li>
                                <li><a href="{{ url('/halte') }}">Halte</a></li>
                            </ul>
                        </li>

                        {{-- ================= OPERASIONAL ================= --}}
                        <li>
                            <a class="has-arrow waves-effect menu-link">
                                <i class="ri-bus-line me-2"></i>
                                <span>Operasional</span>
                                <span class="dot bg-success ms-auto"></span>
                            </a>

                            <ul class="sub-menu">
                                <li><a href="{{ url('/jadwal-operasional') }}">Jadwal Operasional</a></li>
                                <li><a href="{{ url('/perjalanan-aktif') }}">Perjalanan Aktif</a></li>
                                <li><a href="{{ url('/riwayat-perjalanan') }}">Riwayat Perjalanan</a></li>
                                <li><a href="{{ url('/gps-tracking') }}">GPS Tracking</a></li>
                            </ul>
                        </li>

                        {{-- ================= MONITORING ================= --}}
                        <li>
                            <a class="has-arrow waves-effect menu-link">
                                <i class="ri-radar-line me-2"></i>
                                <span>Monitoring</span>
                                <span class="badge bg-danger ms-auto">5</span>
                            </a>

                            <ul class="sub-menu">
                                <li><a href="{{ url('/monitoring/posisi-armada') }}">Posisi Armada</a></li>
                                <li><a href="{{ url('/monitoring/keterlambatan') }}">Keterlambatan</a></li>
                                <li><a href="{{ url('/monitoring/kepadatan-penumpang') }}">Kepadatan</a></li>
                                <li><a href="{{ url('/monitoring/insiden-perjalanan') }}">Insiden</a></li>
                                <li><a href="{{ url('/monitoring/notifikasi-alert') }}">Alert</a></li>
                            </ul>
                        </li>

                        {{-- ================= LAPORAN ================= --}}
                        <li>
                            <a class="has-arrow waves-effect menu-link">
                                <i class="ri-file-chart-line me-2"></i>
                                <span>Laporan</span>
                                <span class="dot bg-warning ms-auto"></span>
                            </a>

                            <ul class="sub-menu">
                                <li><a href="{{ url('/laporan/perjalanan') }}">Perjalanan</a></li>
                                <li><a href="{{ url('/laporan/penumpang') }}">Penumpang</a></li>
                                <li><a href="{{ url('/laporan/insiden') }}">Insiden</a></li>
                                <li><a href="{{ url('/laporan/performa-rute') }}">Performa Rute</a></li>
                                <li><a href="{{ url('/laporan/perawatan-armada') }}">Perawatan Armada</a></li>
                            </ul>
                        </li>

                        {{-- ================= SETTINGS ================= --}}
                        <li>
                            <a class="has-arrow waves-effect menu-link">
                                <i class="ri-settings-3-line me-2"></i>
                                <span>Pengaturan</span>
                            </a>

                            <ul class="sub-menu">
                                <li><a href="{{ url('/user') }}">User</a></li>
                                <li><a href="{{ url('/role') }}">Role</a></li>
                                <li><a href="{{ url('/hak-akses') }}">Hak Akses</a></li>
                            </ul>
                        </li>

                    </ul>

                </div>
            </div>
        </div>
        <!-- Left Sidebar End -->

        <!-- Main Content -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <!-- HEADER HERO -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="dashboard-hero rounded-4 p-4 shadow-sm">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                    <div>
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                                <i class="ri-radio-button-line me-1"></i> Live Monitoring
                                            </span>
                                            <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                                Update terakhir: 10:24 WIB
                                            </span>
                                        </div>

                                        <h3 class="fw-bold mb-1 text-white">
                                            Dashboard Monitoring Transportasi Publik
                                        </h3>
                                        <p class="mb-0 text-white-50">
                                            Pantau armada, rute, penumpang, keterlambatan, dan insiden secara realtime.
                                        </p>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2">
                                        <select class="form-select form-select-sm rounded-pill border-0 px-3">
                                            <option>Semua Rute</option>
                                            <option>Koridor 1</option>
                                            <option>Koridor 2</option>
                                            <option>Koridor 3</option>
                                        </select>

                                        <select class="form-select form-select-sm rounded-pill border-0 px-3">
                                            <option>Hari Ini</option>
                                            <option>7 Hari Terakhir</option>
                                            <option>Bulan Ini</option>
                                        </select>

                                        <button class="btn btn-light btn-sm rounded-pill px-3">
                                            <i class="ri-refresh-line me-1"></i> Refresh
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KPI UTAMA -->
                    <div class="row g-3 mb-4">

                        <div class="col-xl-3 col-md-6">
                            <div class="card border-0 shadow-sm rounded-4 kpi-card hover-lift">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="icon-box bg-primary-subtle text-primary">
                                            <i class="ri-bus-2-line fs-3"></i>
                                        </div>
                                        <span class="badge bg-success-subtle text-success rounded-pill">
                                            +8 aktif
                                        </span>
                                    </div>
                                    <p class="text-muted mb-1">Armada Beroperasi</p>
                                    <h3 class="fw-bold mb-1">128</h3>
                                    <small class="text-muted">Dari total 145 armada tersedia</small>

                                    <div class="progress mt-3 rounded-pill" style="height: 7px;">
                                        <div class="progress-bar bg-primary" style="width: 88%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card border-0 shadow-sm rounded-4 kpi-card hover-lift">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="icon-box bg-success-subtle text-success">
                                            <i class="ri-timer-flash-line fs-3"></i>
                                        </div>
                                        <span class="badge bg-success-subtle text-success rounded-pill">
                                            Baik
                                        </span>
                                    </div>
                                    <p class="text-muted mb-1">Ketepatan Waktu</p>
                                    <h3 class="fw-bold mb-1">91%</h3>
                                    <small class="text-muted">On Time Performance hari ini</small>

                                    <div class="progress mt-3 rounded-pill" style="height: 7px;">
                                        <div class="progress-bar bg-success" style="width: 91%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card border-0 shadow-sm rounded-4 kpi-card hover-lift">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="icon-box bg-info-subtle text-info">
                                            <i class="ri-team-line fs-3"></i>
                                        </div>
                                        <span class="badge bg-info-subtle text-info rounded-pill">
                                            +12%
                                        </span>
                                    </div>
                                    <p class="text-muted mb-1">Penumpang Hari Ini</p>
                                    <h3 class="fw-bold mb-1">18.540</h3>
                                    <small class="text-muted">Naik dibanding kemarin</small>

                                    <div class="progress mt-3 rounded-pill" style="height: 7px;">
                                        <div class="progress-bar bg-info" style="width: 76%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card border-0 shadow-sm rounded-4 kpi-card hover-lift danger-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="icon-box bg-danger-subtle text-danger">
                                            <i class="ri-alert-line fs-3"></i>
                                        </div>
                                        <span class="badge bg-danger-subtle text-danger rounded-pill">
                                            Perlu respon
                                        </span>
                                    </div>
                                    <p class="text-muted mb-1">Insiden Aktif</p>
                                    <h3 class="fw-bold mb-1">7</h3>
                                    <small class="text-muted">1 insiden prioritas tinggi</small>

                                    <div class="progress mt-3 rounded-pill" style="height: 7px;">
                                        <div class="progress-bar bg-danger" style="width: 35%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- MAIN CONTENT -->
                    <div class="row g-3 mb-4">

                        <!-- MAP COMMAND CENTER -->
                        <div class="col-xl-8">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body">

                                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                                        <div>
                                            <h5 class="fw-bold mb-0">Peta Realtime Armada</h5>
                                            <small class="text-muted">
                                                Posisi kendaraan, status perjalanan, dan kepadatan rute
                                            </small>
                                        </div>

                                        <div class="d-flex gap-2">
                                            <span class="badge bg-success rounded-pill px-3 py-2">Normal</span>
                                            <span class="badge bg-warning rounded-pill px-3 py-2">Delay</span>
                                            <span class="badge bg-danger rounded-pill px-3 py-2">Insiden</span>
                                        </div>
                                    </div>

                                    <div class="map-box rounded-4 position-relative overflow-hidden"
                                        style="height: 440px; background: linear-gradient(135deg,#eef5ff,#f8fafc);">

                                        <div
                                            class="position-absolute top-0 start-0 m-3 bg-white rounded-4 shadow-sm p-3">
                                            <h6 class="fw-bold mb-2">Ringkasan Peta</h6>
                                            <div class="small text-muted">Armada bergerak: <b class="text-dark">112</b>
                                            </div>
                                            <div class="small text-muted">Armada berhenti: <b class="text-dark">16</b>
                                            </div>
                                            <div class="small text-muted">Rute padat: <b class="text-danger">5</b></div>
                                        </div>

                                        <div class="h-100 d-flex align-items-center justify-content-center text-center">
                                            <div>
                                                <i class="ri-map-pin-line display-3 text-primary"></i>
                                                <h5 class="mt-2 fw-bold">Area Peta Realtime Armada</h5>
                                                <p class="text-muted mb-3">
                                                    Integrasikan Google Maps, Leaflet, atau Mapbox di area ini.
                                                </p>
                                                <a href="{{ url('/dashboard/peta-realtime-armada') }}"
                                                    class="btn btn-primary rounded-pill px-4">
                                                    Lihat Detail Peta
                                                </a>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- RIGHT PANEL -->
                        <div class="col-xl-4">

                            <!-- ALERT PRIORITAS -->
                            <div class="card border-0 shadow-sm rounded-4 mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="fw-bold mb-0">Alert Prioritas</h5>
                                        <span class="badge bg-danger rounded-pill">3 Baru</span>
                                    </div>

                                    <div class="alert-item danger">
                                        <div>
                                            <h6 class="fw-bold mb-1">Insiden Koridor 2</h6>
                                            <small>Armada B-021 berhenti lebih dari 15 menit.</small>
                                        </div>
                                        <i class="ri-arrow-right-s-line fs-4"></i>
                                    </div>

                                    <div class="alert-item warning">
                                        <div>
                                            <h6 class="fw-bold mb-1">Keterlambatan Tinggi</h6>
                                            <small>3 armada terlambat pada jam sibuk.</small>
                                        </div>
                                        <i class="ri-arrow-right-s-line fs-4"></i>
                                    </div>

                                    <div class="alert-item info mb-0">
                                        <div>
                                            <h6 class="fw-bold mb-1">Rute Padat</h6>
                                            <small>5 rute mengalami peningkatan penumpang.</small>
                                        </div>
                                        <i class="ri-arrow-right-s-line fs-4"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- STATUS OPERASIONAL -->
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-body">
                                    <h5 class="fw-bold mb-3">Status Operasional</h5>

                                    <div class="status-row">
                                        <div>
                                            <span class="status-dot bg-success"></span>
                                            Armada Normal
                                        </div>
                                        <strong>112</strong>
                                    </div>

                                    <div class="status-row">
                                        <div>
                                            <span class="status-dot bg-warning"></span>
                                            Dalam Perawatan
                                        </div>
                                        <strong>9</strong>
                                    </div>

                                    <div class="status-row">
                                        <div>
                                            <span class="status-dot bg-danger"></span>
                                            Insiden
                                        </div>
                                        <strong>7</strong>
                                    </div>

                                    <div class="status-row mb-0">
                                        <div>
                                            <span class="status-dot bg-secondary"></span>
                                            Offline
                                        </div>
                                        <strong>17</strong>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- ANALYTIC SECTION -->
                    <div class="row g-3">

                        <div class="col-xl-6">
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1">Tren Penumpang</h5>
                                    <small class="text-muted">Grafik jumlah penumpang per jam</small>

                                    <div class="chart-placeholder mt-3 rounded-4">
                                        <i class="ri-line-chart-line display-5 text-primary"></i>
                                        <p class="mb-0 mt-2 text-muted">Area Chart Penumpang</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-body">
                                    <h5 class="fw-bold mb-1">Rute Paling Padat</h5>
                                    <small class="text-muted">Prioritas penambahan armada</small>

                                    <div class="mt-3">
                                        <div class="route-item">
                                            <div>
                                                <strong>Koridor 1</strong>
                                                <small class="d-block text-muted">Terminal A - Pusat Kota</small>
                                            </div>
                                            <span class="badge bg-danger rounded-pill">96%</span>
                                        </div>

                                        <div class="route-item">
                                            <div>
                                                <strong>Koridor 3</strong>
                                                <small class="d-block text-muted">Stasiun - Kampus</small>
                                            </div>
                                            <span class="badge bg-warning rounded-pill">82%</span>
                                        </div>

                                        <div class="route-item mb-0">
                                            <div>
                                                <strong>Koridor 5</strong>
                                                <small class="d-block text-muted">Bandara - Pusat Kota</small>
                                            </div>
                                            <span class="badge bg-info rounded-pill">74%</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!-- End Main Content -->
    </div>

    <!-- JAVASCRIPT -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {

        // MENU SAFE
        if (window.jQuery && $.fn.metisMenu) {
            $('#side-menu').metisMenu();
        }

        // SIMPLEBAR SAFE
        if (window.SimpleBar) {
            document.querySelectorAll('[data-simplebar]').forEach(el => {
                new SimpleBar(el);
            });
        }

        // WAVES SAFE
        if (window.Waves) {
            Waves.init();
        }

        // FULLSCREEN SAFE
        document.querySelectorAll('[data-toggle="fullscreen"]').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen();
                } else {
                    document.exitFullscreen();
                }
            });
        });

    });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const body = document.body;
        const toggleButton = document.getElementById('bw-theme-toggle');
        const toggleIcon = document.getElementById('bw-theme-icon');
        const blackWhiteSwitch = document.getElementById('black-white-mode-switch');

        function setBlackWhiteMode(isDark) {
            body.classList.remove('bw-dark');

            if (isDark) {
                body.classList.add('bw-dark');
                localStorage.setItem('blackWhiteMode', 'dark');
            } else {
                localStorage.setItem('blackWhiteMode', 'normal');
            }

            if (blackWhiteSwitch) {
                blackWhiteSwitch.checked = isDark;
            }

            if (toggleIcon) {
                toggleIcon.className = isDark ? 'ri-sun-line' : 'ri-moon-line';
            }

            if (toggleButton) {
                toggleButton.classList.toggle('bw-toggle-active', isDark);
            }
        }

        const savedMode = localStorage.getItem('blackWhiteMode');
        setBlackWhiteMode(savedMode === 'dark');

        if (toggleButton) {
            toggleButton.addEventListener('click', function() {
                setBlackWhiteMode(!body.classList.contains('bw-dark'));
            });
        }

        if (blackWhiteSwitch) {
            blackWhiteSwitch.addEventListener('change', function() {
                setBlackWhiteMode(this.checked);
            });
        }
    });
    </script>
</body>

</html>
