<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Monitoring Transportasi Publik | {{ $title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/logo.png') }}">

    <!-- ICONS -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet">
    <!-- jquery.vectormap css -->
    <link href="{{asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css')}}" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{asset('backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />  

    <!-- BOOTSTRAP (WAJIB STABLE) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('backend/assets/libs/boxicons/css/boxicons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <!-- LOCAL TEMPLATE (SAFE LOAD) -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet">
    <style>
    body.dark-mode {
    background-color: #121212 !important;
    color: #ffffff !important;
}

body.dark-mode .navbar-header,
body.dark-mode .vertical-menu,
body.dark-mode .main-content,
body.dark-mode .page-content,
body.dark-mode .card,
body.dark-mode .table,
body.dark-mode .footer {
    background-color: #181818 !important;
    color: #ffffff !important;
}

body.dark-mode .card {
    border-color: #6e6161 !important;
}

body.dark-mode .table th,
body.dark-mode .table td,
body.dark-mode label,
body.dark-mode h1,
body.dark-mode h2,
body.dark-mode h3,
body.dark-mode h4,
body.dark-mode h5,
body.dark-mode h6,
body.dark-mode p,
body.dark-mode span {
    color: #ffffff !important;
}

body.dark-mode .form-control,
body.dark-mode .form-select {
    background-color: #5e4545 !important;
    color: #ffffff !important;
    border-color: #444444 !important;
}

body.dark-mode .form-control::placeholder {
    color: #bbbbbb !important;
}

#themeToggle {
    font-weight: 600;
}

body.dark-mode #themeToggle {
    color: #ffffff !important;
}
    </style>

</head>

<body data-topbar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
   <div id="layout-wrapper">

    <header id="page-topbar" class="bg-primary">
        <div class="navbar-header bg-primary">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box bg-primary">
                    <a href="index.html" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('backend/assets/images/logo.png') }}" alt="logo-sm" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('backend/assets/images/logo.png') }}" alt="logo-dark" height="20">
                        </span>
                    </a>

                    <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('backend/assets/images/logo3.png') }}" alt="logo-sm-light" height="60">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('backend/assets/images/logo3.png') }}" alt="logo-light" height="40">
                        </span>
                    </a>
                </div>

                <button type="button"
                    class="btn btn-sm px-3 font-size-24 header-item waves-effect text-white"
                    id="vertical-menu-btn">
                    <i class="ri-menu-2-line align-middle"></i>
                </button>

                <!-- App Search-->
                <form class="app-search d-none d-lg-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="ri-search-line"></span>
                    </div>
                </form>
            </div>

            <div class="d-flex">

                <div class="dropdown d-inline-block d-lg-none ms-2">
                    <button type="button"
                        class="btn header-item noti-icon waves-effect text-white"
                        id="page-header-search-dropdown"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                        <i class="ri-search-line"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-search-dropdown">

                        <form class="p-3">
                            <div class="mb-3 m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ...">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="ri-search-line"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

                <div class="d-none d-sm-inline-block">
                    <button type="button"
                        id="themeToggle"
                        class="btn header-item waves-effect text-white">
                        <i id="themeIcon" class="bx bx-moon font-size-18"></i>
                        <span id="themeText" class="ms-1">Black</span>
                    </button>
                </div>

                <div class="dropdown d-none d-lg-inline-block ms-1">
                    <button type="button"
                        class="btn header-item noti-icon waves-effect text-white"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                        <i class="ri-apps-2-line"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                        <div class="px-lg-2">
                            <div class="row g-0">
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <img src="{{asset('backend/assets/images/brands/github.png')}}" alt="Github">
                                        <span>GitHub</span>
                                    </a>
                                </div>

                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <img src="{{asset('backend/assets/images/brands/bitbucket.png')}}" alt="bitbucket">
                                        <span>Bitbucket</span>
                                    </a>
                                </div>

                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <img src="{{asset('backend/assets/images/brands/dribbble.png')}}" alt="dribbble">
                                        <span>Dribbble</span>
                                    </a>
                                </div>
                            </div>

                            <div class="row g-0">
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <img src="{{asset('backend/assets/images/brands/dropbox.png')}}" alt="dropbox">
                                        <span>Dropbox</span>
                                    </a>
                                </div>

                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <img src="{{asset('backend/assets/images/brands/mail_chimp.png')}}" alt="mail_chimp">
                                        <span>Mail Chimp</span>
                                    </a>
                                </div>

                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <img src="{{asset('backend/assets/images/brands/slack.png')}}" alt="slack">
                                        <span>Slack</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dropdown d-none d-lg-inline-block ms-1">
                    <button type="button"
                        class="btn header-item noti-icon waves-effect text-white"
                        data-toggle="fullscreen">
                        <i class="ri-fullscreen-line"></i>
                    </button>
                </div>

                <div class="dropdown d-inline-block">
                    <button type="button"
                        class="btn header-item noti-icon waves-effect text-white"
                        id="page-header-notifications-dropdown"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="ri-notification-3-line"></i>
                        <span class="noti-dot"></span>
                    </button>

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-notifications-dropdown">

                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0"> Notifications </h6>
                                </div>
                                <div class="col-auto">
                                    <a href="#!" class="small"> View All</a>
                                </div>
                            </div>
                        </div>

                        <div data-simplebar style="max-height: 230px;">
                            <a href="" class="text-reset notification-item">
                                <div class="d-flex">
                                    <div class="avatar-xs me-3">
                                        <span class="avatar-title bg-primary rounded-circle font-size-16">
                                            <i class="ri-shopping-cart-line"></i>
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <h6 class="mb-1">Your order is placed</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">If several languages coalesce the grammar</p>
                                            <p class="mb-0">
                                                <i class="mdi mdi-clock-outline"></i> 3 min ago
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="" class="text-reset notification-item">
                                <div class="d-flex">
                                    <img src="{{asset('backend/assets/images/users/avatar-3.jpg')}}"
                                        class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                    <div class="flex-1">
                                        <h6 class="mb-1">James Lemire</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">It will seem like simplified English.</p>
                                            <p class="mb-0">
                                                <i class="mdi mdi-clock-outline"></i> 1 hours ago
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="" class="text-reset notification-item">
                                <div class="d-flex">
                                    <div class="avatar-xs me-3">
                                        <span class="avatar-title bg-success rounded-circle font-size-16">
                                            <i class="ri-checkbox-circle-line"></i>
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <h6 class="mb-1">Your item is shipped</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">If several languages coalesce the grammar</p>
                                            <p class="mb-0">
                                                <i class="mdi mdi-clock-outline"></i> 3 min ago
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="" class="text-reset notification-item">
                                <div class="d-flex">
                                    <img src="{{asset('backend/assets/images/users/avatar-4.jpg')}}"
                                        class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                    <div class="flex-1">
                                        <h6 class="mb-1">Salena Layfield</h6>
                                        <div class="font-size-12 text-muted">
                                            <p class="mb-1">As a skeptical Cambridge friend of mine occidental.</p>
                                            <p class="mb-0">
                                                <i class="mdi mdi-clock-outline"></i> 1 hours ago
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="p-2 border-top">
                            <div class="d-grid">
                                <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                    <i class="mdi mdi-arrow-right-circle me-1"></i> View More..
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="dropdown d-inline-block user-dropdown">
                    <button type="button"
                        class="btn d-inline-flex align-items-center gap-2 rounded-3 px-2 py-1 border-0 bg-transparent mt-2 text-white"
                        id="page-header-user-dropdown"
                        data-bs-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">

                        <img class="rounded-circle border border-light flex-shrink-0"
                            src="{{ asset('backend/assets/images/users/avatar-1.jpg') }}"
                            alt="Header Avatar"
                            width="34"
                            height="34"
                            style="object-fit: cover;">

                        <div class="d-none d-xl-flex flex-column align-items-start justify-content-center text-start lh-sm me-1">
                            <span class="fw-semibold text-white" style="font-size: 13px;">
                                {{ session()->get('loginUsername', 'Julia') }}
                            </span>

                            <span class="text-white-50" style="font-size: 11px;">
                                Administrator
                            </span>
                        </div>

                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block text-white-50"
                            style="font-size: 15px;"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-4"
                        style="min-width: 40px;">

                        <div class="px-3 py-2 border-bottom mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <img class="rounded-circle border"
                                    src="{{ asset('backend/assets/images/users/avatar-1.jpg') }}"
                                    alt="Avatar"
                                    width="36"
                                    height="36">

                                <div>
                                    <div class="fw-semibold text-dark">
                                        {{ session()->get('loginUsername', 'Julia') }}
                                    </div>
                                    <small class="text-muted">
                                        Administrator
                                    </small>
                                </div>
                            </div>
                        </div>

                        <a class="dropdown-item rounded-2 py-2" href="#">
                            <i class="ri-user-line align-middle me-2 text-muted"></i>
                            Profile
                        </a>

                        <a class="dropdown-item rounded-2 py-2" href="#">
                            <i class="ri-dashboard-line align-middle me-2 text-muted"></i>
                            Dashboard
                        </a>

                        <a class="dropdown-item rounded-2 py-2 d-flex align-items-center justify-content-between" href="#">
                            <span>
                                <i class="ri-settings-2-line align-middle me-2 text-muted"></i>
                                Settings
                            </span>
                            <span class="badge bg-success rounded-pill">11</span>
                        </a>

                        <a class="dropdown-item rounded-2 py-2" href="#">
                            <i class="ri-lock-unlock-line align-middle me-2 text-muted"></i>
                            Lock Screen
                        </a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item rounded-2 py-2 text-danger" href="#">
                            <i class="ri-shut-down-line align-middle me-2 text-danger"></i>
                            Logout
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!-- User details -->
                <div class="user-profile text-center mt-3">
                    <div class="">
                        <img src="{{asset('backend/assets/images/users/avatar-1.jpg')}}" alt=""
                            class="avatar-md rounded-circle">
                    </div>
                    <div class="mt-3">
                        <h4 class="font-size-16 mb-1">Julia Hudda</h4>
                        <span class="text-muted"><i
                                class="ri-record-circle-line align-middle font-size-14 text-success"></i> Online</span>
                    </div>
                </div>

                <!--- Sidemenu -->
                <div id="sidebar-menu">
    <!-- Left Menu Start -->
    <ul class="metismenu list-unstyled" id="side-menu">
        <li class="menu-title">Menu Transportasi</li>

        <!-- Dashboard Utama -->
        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="ri-dashboard-line text-success"></i>
                <span>Dashboard Utama</span>
                <span class="badge badge-pill badge-primary float-right">Main</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="dashboard.html">Ringkasan Dashboard</a></li>
                <li><a href="dashboard-armada-aktif.html">Total Armada Aktif</a></li>
                <li><a href="dashboard-perjalanan-hari-ini.html">Total Perjalanan Hari Ini</a></li>
                <li><a href="dashboard-penumpang.html">Jumlah Penumpang</a></li>
                <li><a href="dashboard-insiden.html">Jumlah Insiden</a></li>
                <li><a href="dashboard-peta-realtime.html">Peta Realtime Armada</a></li>
            </ul>
        </li>

        <!-- Data Master -->
        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="ri-database-2-line text-info"></i>
                <span>Data Master</span>
                <span class="badge badge-pill badge-info float-right">Data</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="master-operator.html">Data Operator</a></li>
                <li><a href="master-armada.html">Data Armada</a></li>
                <li><a href="master-pengemudi.html">Data Pengemudi</a></li>
                <li><a href="master-jenis-transportasi.html">Data Jenis Transportasi</a></li>
                <li><a href="master-rute.html">Data Rute</a></li>
                <li><a href="master-halte.html">Data Halte</a></li>
            </ul>
        </li>

        <!-- Operasional -->
        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="ri-road-map-line text-success"></i>
                <span>Operasional</span>
                <span class="badge badge-pill badge-success float-right">Ops</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="operasional-jadwal.html">Jadwal Operasional</a></li>
                <li><a href="operasional-perjalanan-aktif.html">Perjalanan Aktif</a></li>
                <li><a href="operasional-riwayat-perjalanan.html">Riwayat Perjalanan</a></li>
                <li><a href="operasional-gps-tracking.html">GPS Tracking</a></li>
            </ul>
        </li>

        <!-- Monitoring -->
        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="ri-radar-line text-warning"></i>
                <span>Monitoring</span>
                <span class="badge badge-pill badge-warning float-right">Live</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="monitoring-posisi-armada.html">Posisi Armada Realtime</a></li>
                <li><a href="monitoring-keterlambatan.html">Keterlambatan</a></li>
                <li><a href="monitoring-kepadatan-penumpang.html">Kepadatan Penumpang</a></li>
                <li><a href="monitoring-insiden-perjalanan.html">Insiden Perjalanan</a></li>
                <li><a href="monitoring-notifikasi-alert.html">Notifikasi Alert</a></li>
            </ul>
        </li>

        <!-- Laporan -->
        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="ri-file-chart-line text-danger"></i>
                <span>Laporan</span>
                <span class="badge badge-pill badge-danger float-right">Report</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="laporan-perjalanan.html">Laporan Perjalanan</a></li>
                <li><a href="laporan-penumpang.html">Laporan Penumpang</a></li>
                <li><a href="laporan-insiden.html">Laporan Insiden</a></li>
                <li><a href="laporan-performa-rute.html">Laporan Performa Rute</a></li>
                <li><a href="laporan-perawatan-armada.html">Laporan Perawatan Armada</a></li>
            </ul>
        </li>

        <!-- Pengaturan -->
        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="ri-settings-3-line text-secondary"></i>
                <span>Pengaturan</span>
                <span class="badge badge-pill badge-secondary float-right">Admin</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="pengaturan-user.html">User</a></li>
                <li><a href="pengaturan-role.html">Role</a></li>
                <li><a href="pengaturan-hak-akses.html">Hak Akses</a></li>
            </ul>
        </li>
    </ul>
</div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                               @yield('content')
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

           <footer class="footer bg-dark text-white py-3">
    <div class="container-fluid">
        <div class="row align-items-center">

            <div class="col-sm-6">
                <div class="footer-left">
                    <span class="fw-bold text-warning">
                        <script>
                        document.write(new Date().getFullYear())
                        </script>
                    </span>
                    <span>© Dashboard Monitoring Transportasi Publik.</span>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="footer-right text-sm-end">
                    <span>
                        Developed with
                        <i class="mdi mdi-heart text-danger heart-icon"></i>
                        by <strong class="text-white">Rahma</strong>
                    </span>
                </div>
            </div>

        </div>
    </div>
</footer>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title d-flex align-items-center px-3 py-4">

                <h5 class="m-0 me-2">Settings</h5>

                <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
            </div>

            <!-- Settings -->
            <hr class="mt-0" />
            <h6 class="text-center mb-0">Choose Layouts</h6>

            <div class="p-4">
                <div class="mb-2">
                    <img src="{{ asset('backend/assets/images/layouts/layout-1.jpg') }}" class="img-fluid img-thumbnail"
                        alt="layout-1">
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                    <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                </div>

                <div class="mb-2">
                    <img src="{{ asset('backend/assets/images/layouts/layout-2.jpg') }}" class="img-fluid img-thumbnail"
                        alt="layout-2">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch"
                        data-bsStyle="{{ asset('backend/assets/css/bootstrap-dark.min.css') }}"
                        data-appStyle="{{ asset('backend/assets/css/app-dark.min.css') }}">
                    <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                </div>

                <div class="mb-2">
                    <img src="{{ asset('backend/assets/images/layouts/layout-3.jpg') }}" class="img-fluid img-thumbnail"
                        alt="layout-3">
                </div>
                <div class="form-check form-switch mb-5">
                    <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch"
                        data-appStyle="{{ asset('backend/assets/css/app-rtl.min.css') }}">
                    <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                </div>


            </div>

        </div> <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/black-white-theme.js') }}"></script>

    <!-- apexcharts -->
    <script src="{{asset('backend/assets/libs/apexcharts/apexcharts.min.js')}}"></script>

    <!-- jquery.vectormap map -->
    <script src="{{asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <script src="{{asset('backend/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js')}}"></script>

    <!-- Required datatable js -->
    <script src="{{asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        
    <!-- Responsive examples -->
    <script src="{{asset('backend/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('backend/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

    <script src="{{asset('backend/assets/js/pages/dashboard.init.js')}}"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const themeText = document.getElementById('themeText');

        function setTheme(mode) {
            if (mode === 'dark') {
                document.body.classList.add('dark-mode');

                themeIcon.className = 'bx bx-sun font-size-18';
                themeText.innerText = 'White';

                localStorage.setItem('dashboardTheme', 'dark');
            } else {
                document.body.classList.remove('dark-mode');

                themeIcon.className = 'bx bx-moon font-size-18';
                themeText.innerText = 'Black';

                localStorage.setItem('dashboardTheme', 'light');
            }
        }

        const savedTheme = localStorage.getItem('dashboardTheme');

        if (savedTheme === 'dark') {
            setTheme('dark');
        } else {
            setTheme('light');
        }

        themeToggle.addEventListener('click', function () {
            if (document.body.classList.contains('dark-mode')) {
                setTheme('light');
            } else {
                setTheme('dark');
            }
        });
    });
</script>
</body>

</html>