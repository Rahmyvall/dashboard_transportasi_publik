<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <title>Login | Dashboard Monitoring Transportasi Publik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta content="Dashboard Monitoring Transportasi Publik" name="description" />
    <meta content="Dashboard Transportasi" name="author" />

    <link rel="shortcut icon" href="{{ asset('backend/assets/images/logo.png') }}">

    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="bg-light">

    <div class="container-fluid p-0">
        <div class="row g-0 min-vh-100">

            {{-- LOGIN SECTION --}}
            <div class="col-lg-5 col-xl-4 bg-white">
                <div class="d-flex flex-column min-vh-100 px-4 px-sm-5 py-4">

                    {{-- LOGO --}}
                    <div class="mb-3">
                        <a href="{{ url('/') }}" class="d-inline-flex align-items-center text-decoration-none">
                            <div class="avatar-md shadow-sm">
                                <span class="avatar-title rounded-4 bg-white bg-gradient">
                                    <img src="{{ asset('backend/assets/images/logo.png') }}" height="34" alt="Logo">
                                </span>
                            </div>

                            <div class="ms-3">
                                <h5 class="mb-0 fw-bold text-dark">
                                    TransportCare
                                </h5>
                                <small class="text-muted">
                                    Public Transport Monitoring
                                </small>
                            </div>
                        </a>
                    </div>

                    {{-- FORM --}}
                    <div class="d-flex align-items-center flex-grow-1">
                        <div class="w-100">

                            <div class="text-center mb-4">
                                <div class="avatar-lg mx-auto mb-3 shadow">
                                    <span class="avatar-title rounded-circle bg-primary bg-gradient text-white">
                                        <i class="ri-bus-2-line font-size-28"></i>
                                    </span>
                                </div>

                                <h3 class="fw-bold text-dark mb-2">
                                    Masuk Dashboard
                                </h3>

                                <p class="text-muted mb-0">
                                    Silakan login untuk mengakses sistem monitoring transportasi publik.
                                </p>
                            </div>

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
                                    <i class="ri-error-warning-line me-1"></i>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
                                    <i class="ri-checkbox-circle-line me-1"></i>
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="card border-0 shadow-lg rounded-4">
                                <div class="card-body p-4">

                                    <form method="POST" action="{{ route('login.process') }}">
                                        @csrf

                                        <div class="mb-3">
                                            <label for="user" class="form-label fw-semibold">
                                                Username
                                            </label>

                                            <div class="input-group input-group-lg shadow-sm">
                                                <span class="input-group-text bg-light border-end-0 rounded-start-4">
                                                    <i class="ri-user-line text-primary"></i>
                                                </span>

                                                <input
                                                    type="text"
                                                    name="user"
                                                    id="user"
                                                    value="{{ old('user') }}"
                                                    class="form-control border-start-0 rounded-end-4 @error('user') is-invalid @enderror"
                                                    placeholder="Masukkan username"
                                                    autocomplete="username"
                                                    required
                                                    autofocus
                                                >
                                            </div>

                                            @error('user')
                                                <small class="text-danger d-block mt-1">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <label for="passwordInput" class="form-label fw-semibold">
                                                    Password
                                                </label>

                                                <a href="#" class="small text-primary text-decoration-none">
                                                    Lupa password?
                                                </a>
                                            </div>

                                            <div class="input-group input-group-lg shadow-sm">
                                                <span class="input-group-text bg-light border-end-0 rounded-start-4">
                                                    <i class="ri-lock-2-line text-primary"></i>
                                                </span>

                                                <input
                                                    type="password"
                                                    name="pass"
                                                    id="passwordInput"
                                                    class="form-control border-start-0 border-end-0 @error('pass') is-invalid @enderror"
                                                    placeholder="Masukkan password"
                                                    autocomplete="current-password"
                                                    required
                                                >

                                                <button
                                                    class="input-group-text bg-light border-start-0 rounded-end-4"
                                                    type="button"
                                                    id="togglePassword"
                                                >
                                                    <i class="ri-eye-line text-muted" id="togglePasswordIcon"></i>
                                                </button>
                                            </div>

                                            @error('pass')
                                                <small class="text-danger d-block mt-1">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="form-check">
                                                <input
                                                    type="checkbox"
                                                    class="form-check-input"
                                                    id="rememberCheck"
                                                    name="remember"
                                                >

                                                <label class="form-check-label text-muted" for="rememberCheck">
                                                    Ingat saya
                                                </label>
                                            </div>
                                        </div>

                                        <div class="d-grid">
                                            <button class="btn btn-primary btn-lg rounded-4 shadow" type="submit">
                                                <i class="ri-login-circle-line me-1"></i>
                                                Masuk Sekarang
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            {{-- MINI MENU --}}
                            <div class="row g-3 mt-3">
                                <div class="col-4">
                                    <div class="card border-0 shadow-sm rounded-4 bg-light mb-0">
                                        <div class="card-body p-3 text-center">
                                            <i class="ri-bus-line text-primary font-size-22"></i>
                                            <p class="small text-muted mb-0 mt-1">
                                                Armada
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="card border-0 shadow-sm rounded-4 bg-light mb-0">
                                        <div class="card-body p-3 text-center">
                                            <i class="ri-road-map-line text-success font-size-22"></i>
                                            <p class="small text-muted mb-0 mt-1">
                                                Rute
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="card border-0 shadow-sm rounded-4 bg-light mb-0">
                                        <div class="card-body p-3 text-center">
                                            <i class="ri-radar-line text-info font-size-22"></i>
                                            <p class="small text-muted mb-0 mt-1">
                                                Live
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- FOOTER --}}
                    <div class="text-center mt-3">
                        <p class="mb-0 text-muted small">
                            © {{ date('Y') }} Dashboard Monitoring Transportasi Publik
                        </p>
                    </div>

                </div>
            </div>

            {{-- RIGHT SECTION --}}
            <div class="col-lg-7 col-xl-8 d-none d-lg-block">
                <div class="min-vh-100 bg-primary bg-gradient position-relative overflow-hidden">

                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-25"></div>

                    <div class="position-relative min-vh-100 d-flex align-items-center">
                        <div class="container px-5">

                            <div class="row justify-content-center">
                                <div class="col-xl-10">

                                    {{-- HERO TEXT --}}
                                    <div class="mb-4">
                                        <span class="badge bg-white bg-opacity-25 text-white rounded-pill px-3 py-2 mb-3 shadow-sm">
                                            <i class="ri-radar-line me-1"></i>
                                            Smart Public Transport System
                                        </span>

                                        <h1 class="display-6 fw-bold text-white mb-3">
                                            Monitoring Transportasi Publik dalam Satu Dashboard
                                        </h1>

                                        <p class="fs-5 text-white-50 mb-0">
                                            Pantau armada, rute, kepadatan penumpang, dan performa operasional secara cepat dan terpusat.
                                        </p>
                                    </div>

                                    {{-- STAT CARDS --}}
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <div class="card border-0 rounded-4 bg-white bg-opacity-25 text-white shadow-lg mb-0">
                                                <div class="card-body p-4">
                                                    <div class="avatar-md shadow mb-3">
                                                        <span class="avatar-title rounded-circle bg-white text-primary">
                                                            <i class="ri-group-line font-size-24"></i>
                                                        </span>
                                                    </div>

                                                    <h3 class="fw-bold text-white mb-1">
                                                        1.245M
                                                    </h3>

                                                    <p class="mb-0 text-white-50">
                                                        Penumpang
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="card border-0 rounded-4 bg-white bg-opacity-25 text-white shadow-lg mb-0">
                                                <div class="card-body p-4">
                                                    <div class="avatar-md shadow mb-3">
                                                        <span class="avatar-title rounded-circle bg-white text-primary">
                                                            <i class="ri-bus-2-line font-size-24"></i>
                                                        </span>
                                                    </div>

                                                    <h3 class="fw-bold text-white mb-1">
                                                        1.248
                                                    </h3>

                                                    <p class="mb-0 text-white-50">
                                                        Armada Aktif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="card border-0 rounded-4 bg-white bg-opacity-25 text-white shadow-lg mb-0">
                                                <div class="card-body p-4">
                                                    <div class="avatar-md shadow mb-3">
                                                        <span class="avatar-title rounded-circle bg-white text-primary">
                                                            <i class="ri-time-line font-size-24"></i>
                                                        </span>
                                                    </div>

                                                    <h3 class="fw-bold text-white mb-1">
                                                        92,6%
                                                    </h3>

                                                    <p class="mb-0 text-white-50">
                                                        On-Time
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- DASHBOARD PREVIEW --}}
                                    <div class="card border-0 rounded-4 shadow-lg mb-0">
                                        <div class="card-body p-4">

                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <div>
                                                    <h4 class="fw-bold text-dark mb-1">
                                                        Live Monitoring Panel
                                                    </h4>

                                                    <p class="text-muted mb-0">
                                                        Ringkasan status operasional transportasi publik.
                                                    </p>
                                                </div>

                                                <span class="badge bg-success rounded-pill px-3 py-2">
                                                    Online
                                                </span>
                                            </div>

                                            <div class="row g-3">

                                                <div class="col-md-6">
                                                    <div class="card border-0 rounded-4 bg-primary bg-gradient shadow mb-0">
                                                        <div class="card-body p-4 text-white">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-md me-3 shadow">
                                                                    <span class="avatar-title rounded-circle bg-white text-primary">
                                                                        <i class="ri-bus-line font-size-22"></i>
                                                                    </span>
                                                                </div>

                                                                <div>
                                                                    <p class="mb-1 text-white-50">
                                                                        Status Armada
                                                                    </p>
                                                                    <h4 class="text-white mb-0">
                                                                        Normal
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="card border-0 rounded-4 bg-info bg-gradient shadow mb-0">
                                                        <div class="card-body p-4 text-white">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-md me-3 shadow">
                                                                    <span class="avatar-title rounded-circle bg-white text-info">
                                                                        <i class="ri-road-map-line font-size-22"></i>
                                                                    </span>
                                                                </div>

                                                                <div>
                                                                    <p class="mb-1 text-white-50">
                                                                        Status Rute
                                                                    </p>
                                                                    <h4 class="text-white mb-0">
                                                                        Padat
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="card border-0 rounded-4 bg-light shadow-sm mb-0">
                                                        <div class="card-body p-4">

                                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                                <div>
                                                                    <h5 class="fw-bold text-dark mb-1">
                                                                        Jalur Operasional
                                                                    </h5>

                                                                    <small class="text-muted">
                                                                        Persentase pemantauan koridor aktif
                                                                    </small>
                                                                </div>

                                                                <div class="avatar-sm">
                                                                    <span class="avatar-title rounded-circle bg-primary text-white">
                                                                        <i class="ri-map-pin-line"></i>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <div class="d-flex justify-content-between mb-1">
                                                                    <small class="fw-semibold text-dark">Koridor A</small>
                                                                    <small class="text-muted">75%</small>
                                                                </div>
                                                                <div class="progress rounded-pill">
                                                                    <div class="progress-bar bg-primary w-75"></div>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <div class="d-flex justify-content-between mb-1">
                                                                    <small class="fw-semibold text-dark">Koridor B</small>
                                                                    <small class="text-muted">50%</small>
                                                                </div>
                                                                <div class="progress rounded-pill">
                                                                    <div class="progress-bar bg-success w-50"></div>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <div class="d-flex justify-content-between mb-1">
                                                                    <small class="fw-semibold text-dark">Koridor C</small>
                                                                    <small class="text-muted">100%</small>
                                                                </div>
                                                                <div class="progress rounded-pill">
                                                                    <div class="progress-bar bg-info w-100"></div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- JAVASCRIPT --}}
    <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passwordInput');
        const togglePasswordIcon = document.getElementById('togglePasswordIcon');

        if (togglePassword) {
            togglePassword.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';

                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                togglePasswordIcon.className = isPassword ? 'ri-eye-off-line text-muted' : 'ri-eye-line text-muted';
            });
        }
    </script>

</body>

</html>