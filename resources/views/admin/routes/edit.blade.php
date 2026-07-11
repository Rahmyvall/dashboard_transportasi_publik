@extends('layouts.app')

@section('content')
     <div class="container-fluid px-4 route-edit-page">


          <!-- HERO -->
          <div class="edit-hero mb-4">

               <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>

                         <div class="hero-badge mb-2">
                              <i class="bi bi-pencil-square"></i>
                              Update Route
                         </div>

                         <h2 class="hero-title">
                              Edit Rute
                         </h2>

                         <p class="hero-subtitle">
                              Perbarui informasi rute transportasi. Sistem akan menghitung ulang estimasi durasi secara
                              otomatis.
                         </p>

                    </div>


                    <a href="{{ route('admin.routes.index') }}" class="btn btn-back">

                         <i class="bi bi-arrow-left me-1"></i>
                         Kembali

                    </a>


               </div>


          </div>



          <!-- MAIN CARD -->
          <div class="card edit-card border-0">


               <!-- HEADER CARD -->

               <div class="edit-profile-header">


                    <div class="route-profile">


                         <div class="route-icon">

                              <i class="bi bi-map"></i>

                         </div>


                         <div>

                              <h5>
                                   {{ $route->route_name }}
                              </h5>

                              <p>
                                   <i class="bi bi-upc-scan"></i>
                                   {{ $route->route_code }}
                              </p>

                         </div>


                    </div>



                    <div>

                         @if ($route->status == 'active')
                              <span class="status-pill active">
                                   <span></span>
                                   Active
                              </span>
                         @elseif($route->status == 'inactive')
                              <span class="status-pill inactive">
                                   <span></span>
                                   Inactive
                              </span>
                         @else
                              <span class="status-pill maintenance">
                                   <span></span>
                                   Maintenance
                              </span>
                         @endif


                    </div>


               </div>





               <div class="card-body p-4">



                    <form action="{{ route('admin.routes.update', $route->id) }}" method="POST">

                         @csrf
                         @method('PUT')



                         <div class="section-title mb-4">

                              <div class="section-icon">
                                   <i class="bi bi-info-circle"></i>
                              </div>


                              <div>

                                   <h6>
                                        Informasi Rute
                                   </h6>

                                   <small>
                                        Kelola detail perjalanan dan konfigurasi transportasi
                                   </small>

                              </div>

                         </div>




                         <div class="row g-4">



                              <!-- CODE -->

                              <div class="col-md-6">

                                   <label>
                                        <i class="bi bi-upc-scan"></i>
                                        Kode Rute
                                   </label>


                                   <div class="input-box">

                                        <i class="bi bi-lock"></i>

                                        <input type="text" value="{{ $route->route_code }}"
                                             class="form-control modern-input bg-light" readonly>

                                   </div>


                                   <small class="text-muted">
                                        Kode dibuat otomatis sistem.
                                   </small>


                              </div>





                              <!-- NAME -->

                              <div class="col-md-6">


                                   <label>
                                        <i class="bi bi-signpost"></i>
                                        Nama Rute
                                   </label>


                                   <div class="input-box">

                                        <i class="bi bi-pencil"></i>

                                        <input type="text" name="route_name"
                                             value="{{ old('route_name', $route->route_name) }}"
                                             class="form-control modern-input @error('route_name') is-invalid @enderror"
                                             required>

                                   </div>


                                   @error('route_name')
                                        <div class="invalid-feedback">
                                             {{ $message }}
                                        </div>
                                   @enderror


                              </div>





                              <!-- OPERATOR -->

                              <div class="col-md-6">

                                   <label>
                                        <i class="bi bi-building"></i>
                                        Operator
                                   </label>


                                   <div class="input-box">

                                        <i class="bi bi-building"></i>


                                        <select name="operator_id" class="form-select modern-input" required>


                                             <option value="">
                                                  Pilih Operator
                                             </option>


                                             @foreach ($operators as $o)
                                                  <option value="{{ $o->id }}"
                                                       {{ old('operator_id', $route->operator_id) == $o->id ? 'selected' : '' }}>

                                                       {{ $o->operator_name }}

                                                  </option>
                                             @endforeach


                                        </select>


                                   </div>

                              </div>





                              <!-- TRANSPORT -->

                              <div class="col-md-6">


                                   <label>
                                        <i class="bi bi-bus-front"></i>
                                        Transport Mode
                                   </label>


                                   <div class="input-box">

                                        <i class="bi bi-truck"></i>


                                        <select name="transport_mode_id" class="form-select modern-input" required>


                                             <option value="">
                                                  Pilih Transport
                                             </option>


                                             @foreach ($transportModes as $t)
                                                  <option value="{{ $t->id }}"
                                                       {{ old('transport_mode_id', $route->transport_mode_id) == $t->id ? 'selected' : '' }}>

                                                       {{ $t->mode_name }}

                                                  </option>
                                             @endforeach


                                        </select>


                                   </div>


                              </div>





                              <!-- ORIGIN -->

                              <div class="col-md-6">


                                   <label>
                                        <i class="bi bi-geo-alt"></i>
                                        Asal
                                   </label>


                                   <div class="input-box">

                                        <i class="bi bi-pin-map"></i>


                                        <input type="text" name="origin" value="{{ old('origin', $route->origin) }}"
                                             class="form-control modern-input" required>


                                   </div>


                              </div>





                              <!-- DESTINATION -->

                              <div class="col-md-6">


                                   <label>
                                        <i class="bi bi-flag"></i>
                                        Tujuan
                                   </label>


                                   <div class="input-box">

                                        <i class="bi bi-geo"></i>


                                        <input type="text" name="destination"
                                             value="{{ old('destination', $route->destination) }}"
                                             class="form-control modern-input" required>


                                   </div>


                              </div>





                              <!-- DISTANCE -->

                              <div class="col-md-6">


                                   <label>
                                        <i class="bi bi-rulers"></i>
                                        Jarak (KM)
                                   </label>


                                   <div class="input-box">

                                        <i class="bi bi-signpost-split"></i>


                                        <input type="number" step="0.01" min="0" id="distance_km"
                                             name="distance_km" value="{{ old('distance_km', $route->distance_km) }}"
                                             class="form-control modern-input">


                                   </div>


                              </div>





                              <!-- DURATION -->

                              <div class="col-md-6">


                                   <label>
                                        <i class="bi bi-clock"></i>
                                        Estimasi Durasi
                                   </label>


                                   <div class="input-box">

                                        <i class="bi bi-stopwatch"></i>


                                        <input type="text" id="duration_preview"
                                             value="{{ $route->estimated_duration_minutes ?? 0 }} menit"
                                             class="form-control modern-input bg-light" readonly>


                                   </div>


                                   <small class="text-muted">
                                        Perhitungan berdasarkan kecepatan 40 km/jam.
                                   </small>


                              </div>






                              <!-- STATUS -->

                              <div class="col-md-12">


                                   <label>
                                        <i class="bi bi-toggle-on"></i>
                                        Status
                                   </label>


                                   <select name="status" class="form-select modern-input">


                                        <option value="active" {{ $route->status == 'active' ? 'selected' : '' }}>
                                             Active
                                        </option>


                                        <option value="inactive" {{ $route->status == 'inactive' ? 'selected' : '' }}>
                                             Inactive
                                        </option>


                                        <option value="maintenance"
                                             {{ $route->status == 'maintenance' ? 'selected' : '' }}>
                                             Maintenance
                                        </option>


                                   </select>


                              </div>



                         </div>





                         <!-- SYSTEM INFO -->

                         <div class="system-box mt-4">

                              <div class="system-icon">
                                   <i class="bi bi-cpu"></i>
                              </div>


                              <div>

                                   <h6>
                                        System Information
                                   </h6>


                                   <p>
                                        Kode rute mengikuti data awal dan tidak dapat diubah.
                                        Estimasi durasi akan diperbarui otomatis ketika jarak berubah.
                                   </p>


                              </div>


                         </div>





                         <!-- BUTTON -->

                         <div class="form-action mt-4">


                              <a href="{{ route('admin.routes.index') }}" class="btn btn-cancel">

                                   Cancel

                              </a>


                              <button class="btn btn-update">

                                   <i class="bi bi-check-circle me-1"></i>
                                   Update Data

                              </button>


                         </div>



                    </form>


               </div>


          </div>


     </div>





     <style>
          .route-edit-page {
               font-family: Inter, system-ui, sans-serif;
          }



          /* HERO */

          .edit-hero {

               padding: 28px;
               border-radius: 24px;

               background:
                    linear-gradient(135deg,
                         #2563eb,
                         #4f46e5,
                         #7c3aed);

               color: white;

               box-shadow:
                    0 20px 45px rgba(37, 99, 235, .25);

          }


          .hero-badge {

               display: inline-flex;
               gap: 8px;
               align-items: center;

               padding: 7px 12px;

               background: rgba(255, 255, 255, .15);

               border-radius: 999px;

               font-size: 12px;

               font-weight: 700;

          }


          .hero-title {

               font-size: 26px;
               font-weight: 800;
               margin: 0;

          }


          .hero-subtitle {

               margin: 6px 0 0;

               font-size: 14px;

               color: #e2e8f0;

          }


          .btn-back {

               background: white;
               color: #2563eb;

               padding: 11px 18px;

               border-radius: 14px;

               font-weight: 700;

          }





          .edit-card {

               border-radius: 24px;

               overflow: hidden;

               box-shadow:
                    0 20px 55px rgba(15, 23, 42, .08);

          }




          .edit-profile-header {

               padding: 22px;

               display: flex;

               justify-content: space-between;

               align-items: center;

               border-bottom: 1px solid #f1f5f9;

          }



          .route-profile {

               display: flex;

               align-items: center;

               gap: 15px;

          }



          .route-icon {

               width: 52px;
               height: 52px;

               display: flex;
               align-items: center;
               justify-content: center;

               border-radius: 18px;

               background: #eff6ff;

               color: #2563eb;

               font-size: 22px;

          }



          .route-profile h5 {

               margin: 0;

               font-weight: 800;

          }



          .route-profile p {

               margin: 4px 0 0;

               color: #64748b;

               font-size: 13px;

          }





          .status-pill {

               padding: 8px 14px;

               border-radius: 999px;

               display: inline-flex;

               align-items: center;

               gap: 7px;

               font-size: 12px;

               font-weight: 800;

          }


          .status-pill span {

               width: 7px;
               height: 7px;
               border-radius: 50%;

          }


          .active {
               background: #dcfce7;
               color: #166534;
          }

          .active span {
               background: #16a34a;
          }


          .inactive {
               background: #fee2e2;
               color: #991b1b;
          }

          .inactive span {
               background: #dc2626;
          }


          .maintenance {
               background: #fef3c7;
               color: #92400e;
          }

          .maintenance span {
               background: #d97706;
          }





          .section-title {

               display: flex;
               gap: 14px;
               align-items: center;

          }



          .section-icon {

               width: 44px;
               height: 44px;

               border-radius: 14px;

               display: flex;
               justify-content: center;
               align-items: center;

               background: #eff6ff;

               color: #2563eb;

          }





          label {

               font-size: 13px;

               font-weight: 700;

               color: #334155;

          }



          .input-box {

               position: relative;

          }


          .input-box i {

               position: absolute;

               left: 14px;

               top: 50%;

               transform: translateY(-50%);

               color: #94a3b8;

               z-index: 2;

          }



          .modern-input {

               height: 46px;

               padding-left: 40px;

               border-radius: 14px;

               border: 1px solid #e2e8f0;

          }



          .modern-input:focus {

               border-color: #2563eb;

               box-shadow:
                    0 0 0 4px rgba(37, 99, 235, .12);

          }




          .system-box {

               display: flex;

               gap: 14px;

               padding: 18px;

               border-radius: 18px;

               background: #f8fafc;

               border: 1px solid #e2e8f0;

          }



          .system-icon {

               width: 45px;
               height: 45px;

               display: flex;

               justify-content: center;
               align-items: center;

               border-radius: 14px;

               background: #dbeafe;

               color: #2563eb;

          }



          .system-box h6 {

               font-weight: 800;

          }



          .system-box p {

               margin: 0;

               font-size: 13px;

               color: #64748b;

          }



          .form-action {

               display: flex;

               justify-content: flex-end;

               gap: 12px;

          }



          .btn-cancel {

               padding: 11px 24px;

               border-radius: 14px;

               background: #f8fafc;

               font-weight: 700;

          }



          .btn-update {

               padding: 11px 26px;

               border-radius: 14px;

               background: #2563eb;

               color: white;

               font-weight: 700;

               box-shadow:
                    0 12px 25px rgba(37, 99, 235, .25);

          }


          .btn-update:hover {

               background: #1d4ed8;

               color: white;

          }
     </style>



     <script>
          document.addEventListener('DOMContentLoaded', function() {

               const distance = document.getElementById('distance_km');
               const duration = document.getElementById('duration_preview');


               function calculate() {

                    let km = parseFloat(distance.value) || 0;

                    duration.value = Math.round((km / 40) * 60) + ' menit';

               }


               distance.addEventListener('input', calculate);

          });
     </script>
@endsection
