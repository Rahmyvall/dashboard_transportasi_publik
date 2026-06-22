<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Login | Dashboard Monitoring Transportasi Publik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta content="Dashboard Monitoring Transportasi Publik" name="description">
    <meta content="Dashboard Transportasi" name="author">

    <link rel="shortcut icon" href="{{ asset('backend/assets/images/logo.png') }}">

    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet">
</head>

<body class="bg-light overflow-hidden">

    <div class="container-fluid p-0">
        <div class="row g-0 vh-100">

            {{-- LEFT LOGIN --}}
            <div class="col-lg-5 col-xl-4 bg-white d-flex align-items-center justify-content-center">
                <div class="w-100 px-4 px-sm-5">

                    {{-- LOGO --}}
                    <div class="text-center mb-3">
                        <a href="{{ url('/') }}" class="text-decoration-none">
                            <img src="{{ asset('backend/assets/images/logo3.png') }}" alt="Logo" height="42"
                                class="mb-2">

                            <h4 class="fw-bold text-dark mb-1">
                                TransportCare
                            </h4>

                            <p class="text-muted small mb-0">
                                Dashboard Monitoring Transportasi Publik
                            </p>
                        </a>
                    </div>

                    {{-- ALERT --}}
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-4 shadow-sm py-2"
                            role="alert">
                            <i class="ri-error-warning-line me-1"></i>
                            {{ session('error') }}

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm py-2"
                            role="alert">
                            <i class="ri-checkbox-circle-line me-1"></i>
                            {{ session('success') }}

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- LOGIN CARD --}}
                    <div class="card border-0 shadow-lg rounded-4">
                        <div class="card-body p-4">

                            <div class="text-center mb-3">
                                <div class="avatar-md mx-auto mb-2">
                                    <span class="avatar-title rounded-circle bg-primary bg-gradient text-white">
                                        <i class="ri-bus-2-line fs-3"></i>
                                    </span>
                                </div>

                                <h5 class="fw-bold text-dark mb-1">
                                    Masuk Dashboard
                                </h5>

                                <p class="text-muted small mb-0">
                                    Login untuk mengakses sistem monitoring.
                                </p>
                            </div>

                            <form method="POST" action="{{ route('login.process') }}">
                                @csrf

                                {{-- USERNAME --}}
                                <div class="mb-3">
                                    <label for="username" class="form-label fw-semibold">
                                        Username
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 rounded-start-4">
                                            <i class="ri-user-line text-primary"></i>
                                        </span>

                                        <input type="text" name="username" id="username"
                                            value="{{ old('username') }}"
                                            class="form-control border-start-0 rounded-end-4 @error('username') is-invalid @enderror"
                                            placeholder="Masukkan username" autocomplete="username" autofocus required>
                                    </div>

                                    @error('username')
                                        <small class="text-danger d-block mt-1">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>

                                {{-- PASSWORD --}}
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">
                                        Password
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 rounded-start-4">
                                            <i class="ri-lock-2-line text-primary"></i>
                                        </span>

                                        <input type="password" name="password" id="password"
                                            class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror"
                                            placeholder="Masukkan password" autocomplete="current-password" required>

                                        <button class="btn btn-light border-start-0 rounded-end-4" type="button"
                                            id="togglePassword">
                                            <i class="ri-eye-line text-muted" id="togglePasswordIcon"></i>
                                        </button>
                                    </div>

                                    @error('password')
                                        <small class="text-danger d-block mt-1">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>

                                {{-- REMEMBER --}}
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                        <label class="form-check-label text-muted small" for="remember">
                                            Ingat saya
                                        </label>
                                    </div>

                                    <a href="#" class="text-decoration-none small">
                                        Lupa password?
                                    </a>
                                </div>

                                {{-- BUTTON --}}
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary rounded-4 shadow fw-semibold py-2">
                                        <i class="ri-login-circle-line me-1"></i>
                                        Masuk Sekarang
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>

                    <p class="text-center text-muted small mt-3 mb-0">
                        © {{ date('Y') }} Dashboard Monitoring Transportasi Publik
                    </p>

                </div>
            </div>

            {{-- RIGHT HERO --}}
            <div
                class="col-lg-7 col-xl-8 d-none d-lg-flex align-items-center justify-content-center bg-primary bg-gradient">
                <div class="container px-5">

                    <div class="row align-items-center">
                        <div class="col-xl-10 mx-auto">

                            <span class="badge bg-white text-primary rounded-pill px-3 py-2 mb-3 shadow-sm">
                                <i class="ri-radar-line me-1"></i>
                                Smart Public Transport System
                            </span>

                            <h1 class="display-6 fw-bold text-white mb-3">
                                Monitoring Transportasi Publik dalam Satu Dashboard
                            </h1>

                            <p class="text-white-50 mb-4">
                                Pantau armada, rute, kepadatan penumpang, dan ketepatan waktu operasional secara cepat,
                                ringkas, dan terpusat.
                            </p>

                            {{-- STATISTIC CARD --}}
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <div class="card border-0 rounded-4 shadow-lg">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    <span
                                                        class="avatar-title rounded-4 bg-primary-subtle text-primary">
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
                                    <div class="card border-0 rounded-4 shadow-lg">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    <span
                                                        class="avatar-title rounded-4 bg-success-subtle text-success">
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
                                    <div class="card border-0 rounded-4 shadow-lg">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    <span
                                                        class="avatar-title rounded-4 bg-warning-subtle text-warning">
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
                                                Status operasional hari ini
                                            </p>
                                        </div>

                                        <span class="badge bg-success rounded-pill px-3 py-2">
                                            <i class="ri-checkbox-blank-circle-fill me-1"></i>
                                            Online
                                        </span>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="bg-light rounded-4 p-3">
                                                <p class="text-muted small mb-1">
                                                    Armada
                                                </p>

                                                <h6 class="fw-bold text-dark mb-0">
                                                    Normal
                                                </h6>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="bg-light rounded-4 p-3">
                                                <p class="text-muted small mb-1">
                                                    Rute
                                                </p>

                                                <h6 class="fw-bold text-dark mb-0">
                                                    Padat
                                                </h6>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="bg-light rounded-4 p-3">
                                                <p class="text-muted small mb-1">
                                                    Kepadatan
                                                </p>

                                                <h6 class="fw-bold text-dark mb-0">
                                                    Tinggi
                                                </h6>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-4">

                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fw-semibold">
                                            Koridor A
                                        </span>

                                        <span class="text-muted small">
                                            75%
                                        </span>
                                    </div>

                                    <div class="progress rounded-pill mb-3">
                                        <div class="progress-bar bg-primary w-75"></div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fw-semibold">
                                            Koridor B
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

        </div>
    </div>

    <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const icon = document.getElementById('togglePasswordIcon');

        if (togglePassword && password && icon) {
            togglePassword.addEventListener('click', function() {
                const isPassword = password.type === 'password';

                password.type = isPassword ? 'text' : 'password';

                icon.classList.toggle('ri-eye-line');
                icon.classList.toggle('ri-eye-off-line');
            });
        }
    </script>

</body>

</html>
