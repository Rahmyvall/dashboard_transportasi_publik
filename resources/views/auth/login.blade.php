<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Login | Dashboard Monitoring Transportasi Publik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Dashboard Monitoring Transportasi Publik">
    <meta name="author" content="Dashboard Transportasi">

    <link rel="shortcut icon" href="{{ asset('backend/assets/images/logo.png') }}">

    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet">
</head>

<body class="bg-light overflow-hidden">

    <main class="container-fluid p-0">
        <div class="row g-0 vh-100 overflow-hidden">

            {{-- LEFT LOGIN --}}
            <section class="col-lg-5 col-xl-4 bg-white h-100 d-flex align-items-center">
                <div class="w-100 px-4 px-xl-5">

                    {{-- BRAND --}}
                    <div class="text-center mb-3">
                        <a href="{{ url('/') }}" class="text-decoration-none">
                            <div class="avatar-md mx-auto mb-2">
                                <span class="avatar-title rounded-circle bg-primary bg-gradient shadow">
                                    <img src="{{ asset('backend/assets/images/logo3.png') }}" alt="Logo"
                                        height="38">
                                </span>
                            </div>

                            <h4 class="fw-bold text-dark mb-1">
                                TransportCare
                            </h4>

                            <p class="text-muted small mb-0">
                                Dashboard Monitoring Transportasi Publik
                            </p>
                        </a>
                    </div>

                    {{-- ALERT ERROR --}}
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-4 shadow-sm py-2 mb-3"
                            role="alert">
                            <div class="d-flex align-items-center">
                                <i class="ri-error-warning-line fs-5 me-2"></i>
                                <span class="small">{{ session('error') }}</span>
                            </div>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- ALERT SUCCESS --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm py-2 mb-3"
                            role="alert">
                            <div class="d-flex align-items-center">
                                <i class="ri-checkbox-circle-line fs-5 me-2"></i>
                                <span class="small">{{ session('success') }}</span>
                            </div>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- CARD --}}
                    <div class="card border-0 shadow-lg rounded-4">
                        <div class="card-body p-4">

                            <div class="mb-3">
                                <span class="badge bg-primary bg-gradient rounded-pill px-3 py-2 mb-2">
                                    <i class="ri-shield-check-line me-1"></i>
                                    Secure Login
                                </span>

                                <h5 class="fw-bold text-dark mb-1">
                                    Selamat Datang
                                </h5>

                                <p class="text-muted small mb-0">
                                    Masuk untuk mengakses dashboard.
                                </p>
                            </div>

                            <form method="POST" action="{{ route('login.process') }}">
                                @csrf

                                {{-- USERNAME --}}
                                <div class="mb-3">
                                    <label for="username" class="form-label fw-semibold small">
                                        Username
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 rounded-start-4">
                                            <i class="ri-user-3-line text-primary"></i>
                                        </span>

                                        <input type="text" name="username" id="username"
                                            value="{{ old('username') }}"
                                            class="form-control border-start-0 rounded-end-4 @error('username') is-invalid @enderror"
                                            placeholder="Masukkan username" autocomplete="username" autofocus required>
                                    </div>

                                    @error('username')
                                        <small class="text-danger d-block mt-1">
                                            <i class="ri-error-warning-line me-1"></i>
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>

                                {{-- PASSWORD --}}
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold small">
                                        Password
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 rounded-start-4">
                                            <i class="ri-lock-password-line text-primary"></i>
                                        </span>

                                        <input type="password" name="password" id="password"
                                            class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror"
                                            placeholder="Masukkan password" autocomplete="current-password" required>

                                        <button type="button" class="btn btn-light border-start-0 rounded-end-4"
                                            id="togglePassword">
                                            <i class="ri-eye-line text-muted" id="togglePasswordIcon"></i>
                                        </button>
                                    </div>

                                    @error('password')
                                        <small class="text-danger d-block mt-1">
                                            <i class="ri-error-warning-line me-1"></i>
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>

                                {{-- OPTION --}}
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                        <label class="form-check-label small text-muted" for="remember">
                                            Ingat saya
                                        </label>
                                    </div>

                                    <a href="#" class="small fw-semibold text-decoration-none">
                                        Lupa password?
                                    </a>
                                </div>

                                {{-- BUTTON --}}
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary rounded-4 shadow fw-semibold">
                                        <i class="ri-login-circle-line me-1"></i>
                                        Masuk Dashboard
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>

                    <p class="text-center text-muted small mt-3 mb-0">
                        © {{ date('Y') }} TransportCare
                    </p>

                </div>
            </section>

            {{-- RIGHT HERO --}}
            <section class="col-lg-7 col-xl-8 d-none d-lg-flex h-100 align-items-center bg-primary bg-gradient">
                <div class="container px-5">
                    <div class="row justify-content-center">
                        <div class="col-xl-10">

                            {{-- BADGE --}}
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="badge bg-white text-primary rounded-pill px-3 py-2 shadow-sm">
                                    <i class="ri-radar-line me-1"></i>
                                    Smart Transport System
                                </span>

                                <span class="badge bg-success rounded-pill px-3 py-2 shadow-sm">
                                    <i class="ri-checkbox-blank-circle-fill me-1"></i>
                                    Online
                                </span>
                            </div>

                            {{-- HERO TEXT --}}
                            <div class="mb-4">
                                <h1 class="display-6 fw-bold text-white mb-3">
                                    Monitoring Transportasi Publik Lebih Cepat dan Terpusat
                                </h1>

                                <p class="text-white-50 mb-0">
                                    Pantau armada, rute, jadwal, kepadatan penumpang, dan performa layanan
                                    dalam satu dashboard yang mudah digunakan.
                                </p>
                            </div>

                            {{-- STATISTIC --}}
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <div class="card border-0 rounded-4 shadow h-100">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    <span class="avatar-title rounded-4 bg-primary text-white">
                                                        <i class="ri-group-line fs-4"></i>
                                                    </span>
                                                </div>

                                                <div>
                                                    <h5 class="fw-bold mb-0">
                                                        1.245M
                                                    </h5>
                                                    <p class="text-muted small mb-0">
                                                        Penumpang
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card border-0 rounded-4 shadow h-100">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    <span class="avatar-title rounded-4 bg-success text-white">
                                                        <i class="ri-bus-2-line fs-4"></i>
                                                    </span>
                                                </div>

                                                <div>
                                                    <h5 class="fw-bold mb-0">
                                                        1.248
                                                    </h5>
                                                    <p class="text-muted small mb-0">
                                                        Armada
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card border-0 rounded-4 shadow h-100">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    <span class="avatar-title rounded-4 bg-warning text-white">
                                                        <i class="ri-time-line fs-4"></i>
                                                    </span>
                                                </div>

                                                <div>
                                                    <h5 class="fw-bold mb-0">
                                                        92,6%
                                                    </h5>
                                                    <p class="text-muted small mb-0">
                                                        On-Time
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- MONITORING PANEL --}}
                            <div class="card border-0 rounded-4 shadow-lg">
                                <div class="card-body p-4">

                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h5 class="fw-bold text-dark mb-1">
                                                Live Monitoring Panel
                                            </h5>

                                            <p class="text-muted small mb-0">
                                                Ringkasan status operasional hari ini
                                            </p>
                                        </div>

                                        <span class="badge bg-success rounded-pill px-3 py-2">
                                            Live
                                        </span>
                                    </div>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <div class="bg-light rounded-4 p-3 h-100">
                                                <div class="d-flex align-items-center mb-1">
                                                    <i class="ri-bus-line text-primary fs-5 me-2"></i>
                                                    <span class="fw-semibold small">
                                                        Armada
                                                    </span>
                                                </div>

                                                <h6 class="fw-bold text-success mb-0">
                                                    Normal
                                                </h6>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="bg-light rounded-4 p-3 h-100">
                                                <div class="d-flex align-items-center mb-1">
                                                    <i class="ri-route-line text-primary fs-5 me-2"></i>
                                                    <span class="fw-semibold small">
                                                        Rute
                                                    </span>
                                                </div>

                                                <h6 class="fw-bold text-warning mb-0">
                                                    Padat
                                                </h6>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="bg-light rounded-4 p-3 h-100">
                                                <div class="d-flex align-items-center mb-1">
                                                    <i class="ri-user-location-line text-primary fs-5 me-2"></i>
                                                    <span class="fw-semibold small">
                                                        Kepadatan
                                                    </span>
                                                </div>

                                                <h6 class="fw-bold text-danger mb-0">
                                                    Tinggi
                                                </h6>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- PROGRESS --}}
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-semibold small">
                                                Koridor A - Pusat Kota
                                            </span>

                                            <span class="text-muted small">
                                                75%
                                            </span>
                                        </div>

                                        <div class="progress rounded-pill">
                                            <div class="progress-bar bg-primary w-75"></div>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-semibold small">
                                                Koridor B - Terminal Utama
                                            </span>

                                            <span class="text-muted small">
                                                50%
                                            </span>
                                        </div>

                                        <div class="progress rounded-pill">
                                            <div class="progress-bar bg-success w-50"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>

        </div>
    </main>

    <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('togglePasswordIcon');

        if (togglePassword && passwordInput && passwordIcon) {
            togglePassword.addEventListener('click', function() {
                const isHidden = passwordInput.type === 'password';

                passwordInput.type = isHidden ? 'text' : 'password';

                passwordIcon.classList.toggle('ri-eye-line');
                passwordIcon.classList.toggle('ri-eye-off-line');
            });
        }
    </script>

</body>

</html>
