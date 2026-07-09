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

     <style>
          body {
               min-height: 100vh;
               background: #f4f7fb;
               font-family: "Inter", "Segoe UI", Arial, sans-serif;
          }

          .login-wrapper {
               min-height: 100vh;
          }

          .login-left {
               background: #ffffff;
          }

          .login-box {
               width: 100%;
               max-width: 420px;
               padding: 24px;
          }

          .brand-logo {
               width: 58px;
               height: 58px;
               object-fit: contain;
               border-radius: 16px;
               background: #f5f7fb;
               padding: 8px;
               box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
          }

          .login-card {
               border: 0;
               border-radius: 28px;
               box-shadow: 0 18px 45px rgba(15, 23, 42, 0.10);
          }

          .form-label {
               font-size: 13px;
               font-weight: 600;
               color: #475569;
          }

          .form-control {
               height: 48px;
               border-radius: 16px;
               border: 1px solid #e2e8f0;
               background: #f8fafc;
               font-size: 14px;
          }

          .form-control:focus {
               background: #ffffff;
               border-color: #0d6efd;
               box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.10);
          }

          .password-btn {
               height: 48px;
               border-radius: 0 16px 16px 0;
               border: 1px solid #e2e8f0;
               border-left: 0;
               background: #f8fafc;
          }

          .password-input {
               border-radius: 16px 0 0 16px;
          }

          .btn-login {
               height: 48px;
               border-radius: 16px;
               font-weight: 700;
               letter-spacing: 0.2px;
               box-shadow: 0 12px 24px rgba(13, 110, 253, 0.25);
          }

          .right-panel {
               position: relative;
               overflow: hidden;
               background:
                    radial-gradient(circle at top right, rgba(255, 255, 255, 0.22), transparent 28%),
                    linear-gradient(135deg, #0d6efd 0%, #2563eb 45%, #1e40af 100%);
          }

          .right-panel::before {
               content: "";
               position: absolute;
               width: 360px;
               height: 360px;
               border-radius: 50%;
               background: rgba(255, 255, 255, 0.10);
               top: -110px;
               right: -110px;
          }

          .right-panel::after {
               content: "";
               position: absolute;
               width: 280px;
               height: 280px;
               border-radius: 50%;
               background: rgba(255, 255, 255, 0.08);
               bottom: -100px;
               left: -80px;
          }

          .right-content {
               position: relative;
               z-index: 2;
               max-width: 760px;
          }

          .feature-card {
               border-radius: 24px;
               background: rgba(255, 255, 255, 0.13);
               border: 1px solid rgba(255, 255, 255, 0.18);
               backdrop-filter: blur(14px);
          }

          .kpi-card {
               border-radius: 22px;
               background: rgba(255, 255, 255, 0.14);
               border: 1px solid rgba(255, 255, 255, 0.18);
               backdrop-filter: blur(12px);
               transition: 0.2s ease;
          }

          .kpi-card:hover {
               transform: translateY(-4px);
               background: rgba(255, 255, 255, 0.18);
          }

          .icon-box {
               width: 46px;
               height: 46px;
               border-radius: 15px;
               display: inline-flex;
               align-items: center;
               justify-content: center;
               background: rgba(255, 255, 255, 0.16);
               font-size: 24px;
          }

          .mini-status {
               width: 10px;
               height: 10px;
               display: inline-block;
               border-radius: 50%;
               background: #22c55e;
               box-shadow: 0 0 0 5px rgba(34, 197, 94, 0.18);
          }

          .text-soft {
               color: rgba(255, 255, 255, 0.72);
          }

          @media (max-width: 991.98px) {
               .login-left {
                    min-height: 100vh;
               }

               .login-box {
                    max-width: 460px;
               }
          }
     </style>
</head>

<body>

     <main class="container-fluid p-0">
          <div class="row g-0 login-wrapper">

               {{-- LEFT LOGIN --}}
               <section class="col-12 col-lg-5 col-xl-4 login-left d-flex align-items-center justify-content-center">

                    <div class="login-box">

                         {{-- BRAND --}}
                         <div class="text-center mb-4">
                              <img src="{{ asset('backend/assets/images/logo3.png') }}" alt="TransportCare Logo"
                                   class="brand-logo mb-3">

                              <h3 class="fw-bold mb-1 text-dark">
                                   TransportCare
                              </h3>

                              <p class="text-muted mb-0 small">
                                   Smart Monitoring Platform
                              </p>
                         </div>

                         {{-- ALERT ERROR SESSION --}}
                         @if (session('error'))
                              <div class="alert alert-danger border-0 rounded-4 small shadow-sm mb-3">
                                   <div class="d-flex align-items-start gap-2">
                                        <i class="ri-error-warning-line fs-5"></i>
                                        <div>{{ session('error') }}</div>
                                   </div>
                              </div>
                         @endif

                         {{-- VALIDATION ERRORS --}}
                         @if ($errors->any())
                              <div class="alert alert-danger border-0 rounded-4 small shadow-sm mb-3">
                                   <div class="fw-semibold mb-1">Login gagal</div>
                                   @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                   @endforeach
                              </div>
                         @endif

                         {{-- LOGIN CARD --}}
                         <div class="card login-card">
                              <div class="card-body p-4 p-md-5">

                                   <div class="mb-4">
                                        <h4 class="fw-bold mb-1 text-dark">
                                             Welcome Back
                                        </h4>

                                        <p class="text-muted small mb-0">
                                             Masuk untuk mengakses dashboard monitoring transportasi.
                                        </p>
                                   </div>

                                   <form method="POST" action="{{ route('login.process') }}" autocomplete="off">
                                        @csrf

                                        {{-- USERNAME --}}
                                        <div class="mb-3">
                                             <label for="username" class="form-label">
                                                  Username
                                             </label>

                                             <div class="position-relative">
                                                  <input type="text" name="username" id="username"
                                                       value="{{ old('username') }}"
                                                       class="form-control ps-5 @error('username') is-invalid @enderror"
                                                       placeholder="Masukkan username" autofocus required>

                                                  <i class="ri-user-line position-absolute top-50 translate-middle-y text-muted"
                                                       style="left: 18px;"></i>
                                             </div>

                                             @error('username')
                                                  <small class="text-danger">{{ $message }}</small>
                                             @enderror
                                        </div>

                                        {{-- PASSWORD --}}
                                        <div class="mb-3">
                                             <label for="password" class="form-label">
                                                  Password
                                             </label>

                                             <div class="input-group">
                                                  <span class="position-relative flex-grow-1">
                                                       <input type="password" name="password" id="password"
                                                            class="form-control password-input ps-3 @error('password') is-invalid @enderror"
                                                            placeholder="Masukkan password" required>

                                                       <i class="ri-lock-2-line position-absolute top-50 translate-middle-y text-muted"
                                                            style="left: 14px; z-index: 5;"></i>
                                                  </span>

                                                  <button type="button" class="btn password-btn" id="togglePassword"
                                                       aria-label="Tampilkan password">

                                                  </button>
                                             </div>

                                             @error('password')
                                                  <small class="text-danger">{{ $message }}</small>
                                             @enderror
                                        </div>

                                        {{-- OPTIONS --}}
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                             <div class="form-check">
                                                  <input class="form-check-input" type="checkbox" name="remember"
                                                       id="remember">

                                                  <label class="form-check-label small text-muted" for="remember">
                                                       Remember me
                                                  </label>
                                             </div>

                                             <a href="#"
                                                  class="small text-primary text-decoration-none fw-semibold">
                                                  Forgot password?
                                             </a>
                                        </div>

                                        {{-- BUTTON --}}
                                        <button type="submit" class="btn btn-primary btn-login w-100">
                                             <i class="ri-login-circle-line me-1"></i>
                                             Sign In
                                        </button>
                                   </form>

                              </div>
                         </div>

                         {{-- FOOTER --}}
                         <p class="text-center text-muted small mt-4 mb-0">
                              © {{ date('Y') }} TransportCare. All rights reserved.
                         </p>
                    </div>
               </section>

               {{-- RIGHT BRAND PANEL --}}
               <section class="d-none d-lg-flex col-lg-7 col-xl-8 right-panel align-items-center">

                    <div class="right-content text-white px-5 mx-auto">

                         <div class="mb-4">
                              <span class="badge rounded-pill bg-white bg-opacity-25 text-white px-3 py-2 mb-3">
                                   Real-Time Transport Dashboard
                              </span>

                              <h1 class="display-5 fw-bold mb-3">
                                   Smart Transport Monitoring System
                              </h1>

                              <p class="text-soft fs-6 mb-0" style="max-width: 660px;">
                                   Platform modern untuk memantau armada, rute, penumpang, performa layanan, dan status
                                   operasional secara real-time dalam satu dashboard.
                              </p>
                         </div>

                         {{-- KPI CARDS --}}
                         <div class="row g-3 mb-4">

                              <div class="col-md-4">
                                   <div class="kpi-card p-4 h-100">
                                        <div class="icon-box mb-3">
                                             <i class="ri-bus-2-line"></i>
                                        </div>

                                        <h3 class="fw-bold mb-1">
                                             1.248
                                        </h3>

                                        <p class="text-soft small mb-0">
                                             Armada Aktif
                                        </p>
                                   </div>
                              </div>

                              <div class="col-md-4">
                                   <div class="kpi-card p-4 h-100">
                                        <div class="icon-box mb-3">
                                             <i class="ri-group-line"></i>
                                        </div>

                                        <h3 class="fw-bold mb-1">
                                             1.2M
                                        </h3>

                                        <p class="text-soft small mb-0">
                                             Total Penumpang
                                        </p>
                                   </div>
                              </div>

                              <div class="col-md-4">
                                   <div class="kpi-card p-4 h-100">
                                        <div class="icon-box mb-3">
                                             <i class="ri-time-line"></i>
                                        </div>

                                        <h3 class="fw-bold mb-1">
                                             92%
                                        </h3>

                                        <p class="text-soft small mb-0">
                                             On-Time Rate
                                        </p>
                                   </div>
                              </div>

                         </div>

                         {{-- STATUS CARD --}}
                         <div class="feature-card p-4">
                              <div class="d-flex justify-content-between align-items-center mb-3">
                                   <div>
                                        <h5 class="fw-bold mb-1">
                                             System Status
                                        </h5>

                                        <p class="text-soft small mb-0">
                                             Semua layanan utama berjalan normal.
                                        </p>
                                   </div>

                                   <span class="badge bg-success rounded-pill px-3 py-2">
                                        Online
                                   </span>
                              </div>

                              <div class="d-flex align-items-center gap-3">
                                   <span class="mini-status"></span>

                                   <p class="text-soft small mb-0">
                                        Data armada, brute, dan performa tersinkronisasi dengan dashboard operasional.
                                   </p>
                              </div>
                         </div>

                    </div>

               </section>

          </div>
     </main>

     <script>
          document.addEventListener('DOMContentLoaded', function() {
               const togglePassword = document.getElementById('togglePassword');
               const passwordInput = document.getElementById('password');
               const icon = document.getElementById('togglePasswordIcon');

               if (togglePassword && passwordInput && icon) {
                    togglePassword.addEventListener('click', function() {
                         const isHidden = passwordInput.type === 'password';

                         passwordInput.type = isHidden ? 'text' : 'password';

                         icon.classList.toggle('ri-eye-line', !isHidden);
                         icon.classList.toggle('ri-eye-off-line', isHidden);

                         togglePassword.setAttribute(
                              'aria-label',
                              isHidden ? 'Sembunyikan password' : 'Tampilkan password'
                         );
                    });
               }
          });
     </script>

</body>

</html>
