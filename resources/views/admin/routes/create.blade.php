@extends('layouts.app')

@section('content')
     <div class="container-fluid px-4 route-create-page">

          <!-- HERO HEADER -->
          <div class="create-hero mb-4">

               <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>

                         <div class="hero-badge mb-2">
                              <i class="bi bi-plus-circle"></i>
                              Create New Route
                         </div>

                         <h2 class="hero-title">
                              Tambah Rute Baru
                         </h2>

                         <p class="hero-subtitle">
                              Buat data rute transportasi baru. Kode dan durasi akan diproses otomatis oleh sistem.
                         </p>

                    </div>


                    <a href="{{ route('admin.routes.index') }}" class="btn btn-back">

                         <i class="bi bi-arrow-left me-1"></i>
                         Kembali

                    </a>


               </div>

          </div>


          <!-- FORM CARD -->
          <div class="card create-card border-0">


               <div class="card-body p-4">


                    <form action="{{ route('admin.routes.store') }}" method="POST">

                         @csrf


                         <div class="section-title">

                              <div class="section-icon">
                                   <i class="bi bi-map"></i>
                              </div>

                              <div>
                                   <h6>Informasi Rute</h6>
                                   <small>
                                        Lengkapi data utama perjalanan transportasi
                                   </small>
                              </div>

                         </div>



                         <div class="row g-4 mt-2">


                              <!-- OPERATOR -->
                              <div class="col-md-6">

                                   <label class="form-label">
                                        Operator
                                   </label>

                                   <div class="input-group-modern">

                                        <i class="bi bi-building"></i>

                                        <select name="operator_id" class="form-select modern-input" required>

                                             <option value="">
                                                  Pilih Operator
                                             </option>

                                             @foreach ($operators as $o)
                                                  <option value="{{ $o->id }}">
                                                       {{ $o->operator_name }}
                                                  </option>
                                             @endforeach

                                        </select>

                                   </div>

                              </div>



                              <!-- TRANSPORT -->
                              <div class="col-md-6">

                                   <label class="form-label">
                                        Transport Mode
                                   </label>

                                   <div class="input-group-modern">

                                        <i class="bi bi-bus-front"></i>

                                        <select name="transport_mode_id" class="form-select modern-input" required>


                                             <option value="">
                                                  Pilih Transport
                                             </option>


                                             @foreach ($transportModes as $t)
                                                  <option value="{{ $t->id }}">
                                                       {{ $t->mode_name }}
                                                  </option>
                                             @endforeach


                                        </select>


                                   </div>


                              </div>




                              <!-- ROUTE NAME -->
                              <div class="col-md-6">

                                   <label class="form-label">
                                        Nama Rute
                                   </label>


                                   <div class="input-group-modern">

                                        <i class="bi bi-signpost"></i>

                                        <input type="text" name="route_name" class="form-control modern-input"
                                             placeholder="Contoh: Jakarta - Bandung" required>

                                   </div>

                              </div>




                              <!-- ORIGIN -->
                              <div class="col-md-6">

                                   <label class="form-label">
                                        Asal
                                   </label>


                                   <div class="input-group-modern">

                                        <i class="bi bi-geo-alt"></i>

                                        <input type="text" name="origin" class="form-control modern-input"
                                             placeholder="Kota asal" required>

                                   </div>

                              </div>





                              <!-- DESTINATION -->
                              <div class="col-md-6">

                                   <label class="form-label">
                                        Tujuan
                                   </label>


                                   <div class="input-group-modern">

                                        <i class="bi bi-geo"></i>

                                        <input type="text" name="destination" class="form-control modern-input"
                                             placeholder="Kota tujuan" required>


                                   </div>

                              </div>





                              <!-- DISTANCE -->
                              <div class="col-md-6">


                                   <label class="form-label">
                                        Jarak Perjalanan (KM)
                                   </label>


                                   <div class="input-group-modern">


                                        <i class="bi bi-signpost-split"></i>


                                        <input type="number" step="0.01" name="distance_km" id="distance_km"
                                             class="form-control modern-input" placeholder="Masukkan jarak">


                                   </div>


                              </div>




                              <!-- STATUS -->
                              <div class="col-md-6">


                                   <label class="form-label">
                                        Status Rute
                                   </label>


                                   <div class="input-group-modern">

                                        <i class="bi bi-toggle-on"></i>


                                        <select name="status" class="form-select modern-input" required>


                                             <option value="active">
                                                  Active
                                             </option>


                                             <option value="inactive">
                                                  Inactive
                                             </option>


                                             <option value="maintenance">
                                                  Maintenance
                                             </option>


                                        </select>


                                   </div>


                              </div>


                         </div>





                         <!-- SYSTEM INFO -->

                         <div class="system-info mt-4">


                              <div class="system-icon">

                                   <i class="bi bi-cpu"></i>

                              </div>


                              <div>


                                   <h6>
                                        Informasi Sistem
                                   </h6>


                                   <ul>

                                        <li>
                                             Kode rute dibuat otomatis berdasarkan operator.
                                        </li>


                                        <li>
                                             Durasi perjalanan dihitung otomatis menggunakan estimasi 40 km/jam.
                                        </li>


                                        <li>
                                             Data dapat diperbarui kembali melalui menu edit rute.
                                        </li>


                                   </ul>


                              </div>


                         </div>





                         <!-- ACTION BUTTON -->

                         <div class="form-footer mt-4">


                              <a href="{{ route('admin.routes.index') }}" class="btn btn-cancel">

                                   Cancel

                              </a>



                              <button type="submit" class="btn btn-save">

                                   <i class="bi bi-check-lg me-1"></i>
                                   Simpan Rute

                              </button>


                         </div>



                    </form>


               </div>


          </div>


     </div>





     <style>
          .route-create-page {
               font-family: Inter, system-ui, sans-serif;
          }



          /* HERO */

          .create-hero {

               padding: 28px;
               border-radius: 24px;

               background:
                    radial-gradient(circle at top right,
                         rgba(255, 255, 255, .35),
                         transparent 35%),

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
               align-items: center;
               gap: 7px;

               padding: 7px 12px;

               border-radius: 999px;

               background: rgba(255, 255, 255, .15);

               font-size: 12px;

               font-weight: 700;

          }



          .hero-title {

               font-size: 26px;
               font-weight: 800;
               margin: 0;

          }



          .hero-subtitle {

               margin: 7px 0 0;

               font-size: 14px;

               color: rgba(255, 255, 255, .85);

          }




          .btn-back {

               background: white;

               color: #2563eb;

               border-radius: 14px;

               padding: 11px 18px;

               font-weight: 700;

          }




          /* CARD */


          .create-card {

               border-radius: 24px;

               background: white;

               box-shadow:
                    0 20px 55px rgba(15, 23, 42, .08);

          }




          .section-title {

               display: flex;

               align-items: center;

               gap: 14px;

          }



          .section-icon {

               width: 45px;

               height: 45px;

               display: flex;

               justify-content: center;

               align-items: center;

               border-radius: 15px;

               background: #eff6ff;

               color: #2563eb;

               font-size: 20px;

          }



          .section-title h6 {

               margin: 0;

               font-size: 16px;

               font-weight: 800;

          }


          .section-title small {

               color: #64748b;

          }





          /* INPUT */


          .form-label {

               font-size: 13px;

               font-weight: 700;

               color: #334155;

          }



          .input-group-modern {

               position: relative;

          }



          .input-group-modern>i {

               position: absolute;

               left: 14px;

               top: 50%;

               transform: translateY(-50%);

               color: #94a3b8;

               z-index: 2;

          }



          .modern-input {

               height: 46px;

               padding-left: 42px;

               border-radius: 14px;

               border: 1px solid #e2e8f0;

               font-size: 14px;

               transition: .2s;

          }



          .modern-input:focus {

               border-color: #2563eb;

               box-shadow:
                    0 0 0 4px rgba(37, 99, 235, .12);

          }





          /* INFO */


          .system-info {

               display: flex;

               gap: 15px;

               padding: 18px;

               border-radius: 18px;

               background: #f8fafc;

               border: 1px solid #e2e8f0;

          }



          .system-icon {

               width: 45px;

               height: 45px;

               display: flex;

               align-items: center;

               justify-content: center;

               border-radius: 14px;

               background: #dbeafe;

               color: #2563eb;

          }



          .system-info h6 {

               font-weight: 800;

               margin-bottom: 8px;

          }



          .system-info ul {

               margin: 0;

               padding-left: 18px;

               color: #64748b;

               font-size: 13px;

          }





          /* BUTTON */

          .form-footer {

               display: flex;

               justify-content: flex-end;

               gap: 12px;

          }



          .btn-cancel {

               padding: 11px 24px;

               border-radius: 14px;

               background: #f8fafc;

               color: #475569;

               font-weight: 700;

          }



          .btn-save {

               padding: 11px 26px;

               border-radius: 14px;

               background: #2563eb;

               color: white;

               font-weight: 700;

               box-shadow:
                    0 12px 25px rgba(37, 99, 235, .25);

          }



          .btn-save:hover {

               background: #1d4ed8;

               color: white;

          }
     </style>
@endsection
