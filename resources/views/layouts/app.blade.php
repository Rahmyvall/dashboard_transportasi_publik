@include('layouts.header')

<body data-topbar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- Topbar -->
        <header id="page-topbar" class="bg-primary">
            <div class="navbar-header bg-primary">

                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box bg-primary">
                        <a href="{{ route('dashboard') }}" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ asset('backend/assets/images/logo.png') }}" alt="logo-sm" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('backend/assets/images/logo.png') }}" alt="logo-dark" height="20">
                            </span>
                        </a>

                        <a href="{{ route('dashboard') }}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset('backend/assets/images/logo3.png') }}" alt="logo-sm-light"
                                    height="60">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('backend/assets/images/logo3.png') }}" alt="logo-light"
                                    height="40">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect text-white"
                        id="vertical-menu-btn">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>

                    <!-- Search -->
                    <form class="app-search d-none d-lg-block">
                        <div class="position-relative">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="ri-search-line"></span>
                        </div>
                    </form>
                </div>

                <div class="d-flex">

                    <!-- Mobile Search -->
                    <div class="dropdown d-inline-block d-lg-none ms-2">
                        <button type="button" class="btn header-item noti-icon waves-effect text-white"
                            id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="ri-search-line"></i>
                        </button>

                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-search-dropdown">
                            <form class="p-3">
                                <div class="mb-3 m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ...">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="ri-search-line"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Theme Toggle -->
                    <div class="d-none d-sm-inline-block">
                        <button type="button" id="themeToggle" class="btn header-item waves-effect text-white">
                            <i id="themeIcon" class="bx bx-moon font-size-18"></i>
                            <span id="themeText" class="ms-1">Black</span>
                        </button>
                    </div>

                    <!-- Apps Dropdown -->
                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect text-white"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-apps-2-line"></i>
                        </button>

                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <div class="px-lg-2">
                                <div class="row g-0">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="{{ asset('backend/assets/images/brands/github.png') }}"
                                                alt="Github">
                                            <span>GitHub</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="{{ asset('backend/assets/images/brands/bitbucket.png') }}"
                                                alt="Bitbucket">
                                            <span>Bitbucket</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="{{ asset('backend/assets/images/brands/dribbble.png') }}"
                                                alt="Dribbble">
                                            <span>Dribbble</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="row g-0">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="{{ asset('backend/assets/images/brands/dropbox.png') }}"
                                                alt="Dropbox">
                                            <span>Dropbox</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="{{ asset('backend/assets/images/brands/mail_chimp.png') }}"
                                                alt="Mail Chimp">
                                            <span>Mail Chimp</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="{{ asset('backend/assets/images/brands/slack.png') }}"
                                                alt="Slack">
                                            <span>Slack</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fullscreen -->
                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect text-white"
                            data-toggle="fullscreen">
                            <i class="ri-fullscreen-line"></i>
                        </button>
                    </div>

                    <!-- Notifications -->
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect text-white"
                            id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-notification-3-line"></i>
                            <span class="noti-dot"></span>
                        </button>

                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown">

                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0">Notifications</h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#!" class="small">View All</a>
                                    </div>
                                </div>
                            </div>

                            <div data-simplebar style="max-height: 230px;">
                                <a href="#" class="text-reset notification-item">
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

                                <a href="#" class="text-reset notification-item">
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

                    <!-- User Dropdown -->
                    <div class="dropdown d-inline-block user-dropdown">
                        <button type="button"
                            class="btn d-inline-flex align-items-center gap-2 rounded-3 px-2 py-1 border-0 bg-transparent mt-2 text-white"
                            id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">

                            <img class="rounded-circle border border-light flex-shrink-0"
                                src="{{ asset('backend/assets/images/users/avatar-1.jpg') }}" alt="Header Avatar"
                                width="34" height="34" style="object-fit: cover;">

                            <div
                                class="d-none d-xl-flex flex-column align-items-start justify-content-center text-start lh-sm me-1">
                                <span class="fw-semibold text-white" style="font-size: 13px;">
                                    {{ session('loginName', session('loginUsername', 'Guest')) }}
                                </span>

                                <span class="text-white-50" style="font-size: 11px;">
                                    {{ session('loginRoleId') == 1 ? 'Administrator' : 'Operator' }}
                                </span>
                            </div>

                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block text-white-50"
                                style="font-size: 15px;"></i>
                        </button>

                        <div class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-4"
                            style="min-width: 220px;">

                            <div class="px-3 py-2 border-bottom mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <img class="rounded-circle border"
                                        src="{{ asset('backend/assets/images/users/avatar-1.jpg') }}" alt="Avatar"
                                        width="36" height="36">

                                    <div>
                                        <div class="fw-semibold text-dark">
                                            {{ session('loginName', session('loginUsername', 'Guest')) }}
                                        </div>

                                        <small class="text-muted">
                                            {{ session('loginRoleId') == 1 ? 'Administrator' : 'Operator' }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <a class="dropdown-item rounded-2 py-2" href="#">
                                <i class="ri-user-line me-2 text-muted"></i>
                                Profile
                            </a>

                            <a class="dropdown-item rounded-2 py-2" href="{{ route('dashboard') }}">
                                <i class="ri-dashboard-line me-2 text-muted"></i>
                                Dashboard
                            </a>

                            <a class="dropdown-item rounded-2 py-2" href="#">
                                <i class="ri-settings-2-line me-2 text-muted"></i>
                                Settings
                            </a>

                            <a class="dropdown-item rounded-2 py-2" href="#">
                                <i class="ri-lock-unlock-line me-2 text-muted"></i>
                                Lock Screen
                            </a>

                            <div class="dropdown-divider"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger rounded-2 py-2">
                                    <i class="ri-shut-down-line me-2 text-danger"></i>
                                    Logout
                                </button>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </header>
        <!-- End Topbar -->


        <!-- Left Sidebar -->
        <div class="vertical-menu" style="background: linear-gradient(180deg, #1e2022 0%, #2e2e30 100%);">
            <div data-simplebar class="h-100">

                <div class="user-profile text-center pt-4 pb-4">
                    <div>
                        <img src="{{ asset('backend/assets/images/users/avatar-1.jpg') }}" alt="User Avatar"
                            class="avatar-md rounded-circle border border-3 border-light shadow">
                    </div>

                    <div class="mt-3">
                        <h4 class="font-size-16 mb-1 text-white">
                            {{ session('loginName', session('loginUsername', 'Guest')) }}
                        </h4>

                        <span class="text-white-50">
                            <i class="ri-record-circle-fill align-middle font-size-14 text-success"></i>
                            Online
                        </span>
                    </div>
                </div>

                @include('layouts.sidebar')

            </div>
        </div>
        <!-- End Left Sidebar -->


        <!-- Main Content -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    @hasSection('page-title')
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">
                                        @yield('page-title')
                                    </h4>
                                </div>
                            </div>
                        </div>
                    @endif

                    @yield('content')

                </div>
            </div>

            @include('layouts.footer')

        </div>
        <!-- End Main Content -->

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

            <hr class="mt-0">

            <h6 class="text-center mb-0">Choose Layouts</h6>

            <div class="p-4">
                <div class="mb-2">
                    <img src="{{ asset('backend/assets/images/layouts/layout-1.jpg') }}"
                        class="img-fluid img-thumbnail" alt="layout-1">
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                    <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                </div>

                <div class="mb-2">
                    <img src="{{ asset('backend/assets/images/layouts/layout-2.jpg') }}"
                        class="img-fluid img-thumbnail" alt="layout-2">
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch"
                        data-bsStyle="{{ asset('backend/assets/css/bootstrap-dark.min.css') }}"
                        data-appStyle="{{ asset('backend/assets/css/app-dark.min.css') }}">
                    <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                </div>

                <div class="mb-2">
                    <img src="{{ asset('backend/assets/images/layouts/layout-3.jpg') }}"
                        class="img-fluid img-thumbnail" alt="layout-3">
                </div>

                <div class="form-check form-switch mb-5">
                    <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch"
                        data-appStyle="{{ asset('backend/assets/css/app-rtl.min.css') }}">
                    <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                </div>
            </div>

        </div>
    </div>
    <!-- End Right Sidebar -->

    <div class="rightbar-overlay"></div>


    <!-- JAVASCRIPT -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- Apexcharts -->
    <script src="{{ asset('backend/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Datatable -->
    <script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Datatable Responsive -->
    <script src="{{ asset('backend/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}">
    </script>

    <!-- Datatable Buttons -->
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

    <script src="{{ asset('backend/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>

    <!-- Vector Map -->
    <script src="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}">
    </script>
    <script src="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}">
    </script>

    <!-- Pages -->
    <script src="{{ asset('backend/assets/js/pages/dashboard.init.js') }}"></script>

    <!-- App -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = document.getElementById('themeIcon');
            const themeText = document.getElementById('themeText');

            if (!themeToggle || !themeIcon || !themeText) {
                return;
            }

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

            setTheme(savedTheme === 'dark' ? 'dark' : 'light');

            themeToggle.addEventListener('click', function() {
                const isDark = document.body.classList.contains('dark-mode');
                setTheme(isDark ? 'light' : 'dark');
            });
        });
    </script>

    @stack('scripts')

</body>

</html>
