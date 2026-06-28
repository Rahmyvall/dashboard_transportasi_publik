<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Login | TransportCare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="{{ asset('backend/assets/images/logo.png') }}">

    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet">
</head>

<body class="bg-light overflow-hidden">

    <main class="container-fluid p-0">
        <div class="row g-0 vh-100 overflow-hidden">

            {{-- LEFT: LOGIN (FOCUSED UX) --}}
            <section class="col-12 col-lg-4 bg-white d-flex align-items-center justify-content-center">

                <div class="w-100 px-4" style="max-width: 390px;">

                    {{-- BRAND --}}
                    <div class="text-center mb-4">
                        <img src="{{ asset('backend/assets/images/logo3.png') }}" height="46" class="mb-2">
                        <h4 class="fw-bold mb-0">TransportCare</h4>
                        <small class="text-muted">Smart Monitoring Platform</small>
                    </div>

                    {{-- ALERT --}}
                    @if (session('error'))
                        <div class="alert alert-danger rounded-4 py-2 small mb-3 border-0 shadow-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- LOGIN CARD (FLOAT STYLE) --}}
                    <div class="card border-0 shadow-lg rounded-5">
                        <div class="card-body p-4">

                            {{-- HEADER UX --}}
                            <div class="mb-3">
                                <h5 class="fw-bold mb-1">Welcome Back</h5>
                                <p class="text-muted small mb-0">
                                    Login untuk mengakses dashboard monitoring
                                </p>
                            </div>

                            <form method="POST" action="{{ route('login.process') }}">
                                @csrf

                                {{-- USERNAME --}}
                                <div class="mb-3">
                                    <label class="form-label small text-muted">Username</label>
                                    <input type="text" name="username"
                                        class="form-control bg-light border-0 rounded-4 py-2"
                                        placeholder="Enter username" autofocus required>
                                </div>

                                {{-- PASSWORD --}}
                                <div class="mb-3">
                                    <label class="form-label small text-muted">Password</label>

                                    <div class="input-group">
                                        <input type="password" name="password" id="password"
                                            class="form-control bg-light border-0 rounded-start-4 py-2"
                                            placeholder="Enter password" required>

                                        <button type="button" class="btn btn-light border-0 rounded-end-4"
                                            id="togglePassword">
                                            <i class="ri-eye-line" id="togglePasswordIcon"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- OPTIONS --}}
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember">
                                        <label class="form-check-label small text-muted">Remember me</label>
                                    </div>

                                    <a href="#" class="small text-primary text-decoration-none">
                                        Forgot password?
                                    </a>
                                </div>

                                {{-- BUTTON --}}
                                <button class="btn btn-primary w-100 rounded-4 py-2 fw-semibold shadow-sm">
                                    Sign In
                                </button>

                            </form>

                        </div>
                    </div>

                    {{-- FOOTER --}}
                    <p class="text-center text-muted small mt-3 mb-0">
                        © {{ date('Y') }} TransportCare
                    </p>

                </div>

            </section>

            {{-- RIGHT: BRAND EXPERIENCE (CLEAN + MODERN) --}}
            <section
                class="d-none d-lg-flex col-lg-8 bg-primary bg-gradient align-items-center position-relative overflow-hidden">

                {{-- soft background shapes (NO CSS FILE) --}}
                <div
                    style="position:absolute;width:280px;height:280px;border-radius:50%;background:#fff;opacity:.08;top:-60px;right:-60px;">
                </div>
                <div
                    style="position:absolute;width:220px;height:220px;border-radius:50%;background:#fff;opacity:.06;bottom:-50px;left:-50px;">
                </div>

                <div class="container text-white px-5">

                    {{-- MAIN VALUE PROP --}}
                    <h1 class="fw-bold mb-2">
                        Smart Transport Monitoring System
                    </h1>

                    <p class="text-white-50 mb-4">
                        Platform modern untuk memantau armada, rute, penumpang, dan performa transportasi secara
                        real-time.
                    </p>

                    {{-- KPI CARDS --}}
                    <div class="row g-3 mb-4">

                        <div class="col-md-4">
                            <div class="bg-white bg-opacity-10 rounded-4 p-3 text-center">
                                <i class="ri-bus-2-line fs-3"></i>
                                <h4 class="mb-0 mt-2">1.248</h4>
                                <small class="text-white-50">Armada Aktif</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="bg-white bg-opacity-10 rounded-4 p-3 text-center">
                                <i class="ri-group-line fs-3"></i>
                                <h4 class="mb-0 mt-2">1.2M</h4>
                                <small class="text-white-50">Penumpang</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="bg-white bg-opacity-10 rounded-4 p-3 text-center">
                                <i class="ri-time-line fs-3"></i>
                                <h4 class="mb-0 mt-2">92%</h4>
                                <small class="text-white-50">On-Time Rate</small>
                            </div>
                        </div>

                    </div>

                    {{-- TRUST / STATUS --}}
                    <div class="bg-white bg-opacity-10 rounded-4 p-4">

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">System Status</span>
                            <span class="badge bg-success">Online</span>
                        </div>

                        <p class="text-white-50 small mb-0">
                            Semua sistem berjalan normal dan tersinkronisasi real-time tanpa delay data.
                        </p>

                    </div>

                </div>

            </section>

        </div>
    </main>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('togglePasswordIcon');

        togglePassword.addEventListener('click', function() {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';

            icon.classList.toggle('ri-eye-line');
            icon.classList.toggle('ri-eye-off-line');
        });
    </script>

</body>

</html>
