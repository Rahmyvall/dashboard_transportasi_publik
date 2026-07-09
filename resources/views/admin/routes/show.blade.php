@extends('layouts.app')

@section('content')
     <div class="container-fluid px-4 route-detail-page">


          <!-- HERO -->
          <div class="detail-hero mb-4">

               <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">


                    <div>

                         <div class="hero-badge mb-2">
                              <i class="bi bi-map"></i>
                              Route Detail
                         </div>


                         <h2 class="hero-title">
                              Detail Rute
                         </h2>


                         <p class="hero-subtitle">
                              Informasi lengkap konfigurasi transportasi dan perjalanan rute.
                         </p>


                    </div>



                    <div class="d-flex gap-2">


                         <a href="{{ route('admin.routes.edit', $route->id) }}" class="btn btn-edit">

                              <i class="bi bi-pencil-square me-1"></i>
                              Edit

                         </a>



                         <a href="{{ route('admin.routes.index') }}" class="btn btn-back">

                              <i class="bi bi-arrow-left me-1"></i>
                              Kembali

                         </a>


                    </div>


               </div>


          </div>





          <!-- MAIN CARD -->

          <div class="card detail-card border-0">



               <!-- PROFILE HEADER -->

               <div class="detail-profile">


                    <div class="profile-left">


                         <div class="route-avatar">

                              <i class="bi bi-signpost-2"></i>

                         </div>



                         <div>


                              <h4>
                                   {{ $route->route_name }}
                              </h4>


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



                    <!-- ROUTE FLOW -->


                    <div class="route-container mb-4">


                         <div class="section-title mb-3">


                              <div class="section-icon">

                                   <i class="bi bi-signpost-split"></i>

                              </div>


                              <div>

                                   <h6>
                                        Jalur Perjalanan
                                   </h6>


                                   <small>
                                        Informasi titik awal dan tujuan perjalanan
                                   </small>

                              </div>


                         </div>




                         <div class="route-line">


                              <div class="location start">


                                   <div class="location-icon">

                                        <i class="bi bi-geo-alt-fill"></i>

                                   </div>


                                   <div>

                                        <small>
                                             Origin
                                        </small>

                                        <h5>
                                             {{ $route->origin }}
                                        </h5>


                                   </div>


                              </div>





                              <div class="direction">


                                   <i class="bi bi-arrow-right"></i>


                              </div>





                              <div class="location end">


                                   <div class="location-icon">

                                        <i class="bi bi-flag-fill"></i>

                                   </div>


                                   <div>

                                        <small>
                                             Destination
                                        </small>

                                        <h5>
                                             {{ $route->destination }}
                                        </h5>


                                   </div>


                              </div>



                         </div>



                    </div>






                    <!-- INFORMATION GRID -->

                    <div class="row g-4">


                         <div class="col-md-6">

                              <div class="info-card">

                                   <div class="info-icon">
                                        <i class="bi bi-building"></i>
                                   </div>


                                   <div>

                                        <small>
                                             Operator
                                        </small>


                                        <h6>
                                             {{ $route->operator->operator_name ?? '-' }}
                                        </h6>


                                   </div>

                              </div>

                         </div>





                         <div class="col-md-6">


                              <div class="info-card">


                                   <div class="info-icon">

                                        <i class="bi bi-bus-front"></i>

                                   </div>


                                   <div>

                                        <small>
                                             Transport Mode
                                        </small>


                                        <h6>
                                             {{ $route->transportMode->mode_name ?? '-' }}
                                        </h6>


                                   </div>


                              </div>


                         </div>







                         <div class="col-md-6">


                              <div class="info-card">


                                   <div class="info-icon">

                                        <i class="bi bi-rulers"></i>

                                   </div>


                                   <div>


                                        <small>
                                             Distance
                                        </small>


                                        <h6>
                                             {{ $route->distance_km ?? '-' }} KM
                                        </h6>


                                   </div>


                              </div>


                         </div>







                         <div class="col-md-6">


                              <div class="info-card">


                                   <div class="info-icon">

                                        <i class="bi bi-clock"></i>

                                   </div>


                                   <div>


                                        <small>
                                             Estimated Duration
                                        </small>


                                        <h6>
                                             {{ $route->estimated_duration_minutes ?? '-' }} Menit
                                        </h6>


                                   </div>


                              </div>


                         </div>



                    </div>




                    <!-- SYSTEM NOTE -->


                    <div class="system-note mt-4">


                         <div class="system-icon">

                              <i class="bi bi-cpu"></i>

                         </div>


                         <div>


                              <h6>
                                   System Information
                              </h6>


                              <p>
                                   Data rute tersimpan dalam sistem transport management.
                                   Durasi dihitung berdasarkan jarak dengan estimasi kecepatan 40 km/jam.
                              </p>


                         </div>


                    </div>



               </div>


          </div>



     </div>





     <style>
          .route-detail-page {

               font-family: Inter, system-ui, sans-serif;

          }




          /* HERO */

          .detail-hero {

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

               margin: 0;

               font-size: 26px;

               font-weight: 800;

          }


          .hero-subtitle {

               margin: 6px 0 0;

               color: #e2e8f0;

               font-size: 14px;

          }





          .btn-back,
          .btn-edit {

               padding: 11px 18px;

               border-radius: 14px;

               font-weight: 700;

          }



          .btn-back {

               background: white;

               color: #2563eb;

          }


          .btn-edit {

               background: #ffffff25;

               color: white;

               border: 1px solid rgba(255, 255, 255, .3);

          }






          /* CARD */

          .detail-card {

               border-radius: 24px;

               overflow: hidden;

               box-shadow:
                    0 20px 55px rgba(15, 23, 42, .08);

          }




          .detail-profile {

               padding: 22px;

               display: flex;

               justify-content: space-between;

               align-items: center;

               border-bottom: 1px solid #f1f5f9;

          }



          .profile-left {

               display: flex;

               align-items: center;

               gap: 15px;

          }



          .route-avatar {

               width: 55px;

               height: 55px;

               display: flex;

               justify-content: center;

               align-items: center;

               border-radius: 18px;

               background: #eff6ff;

               color: #2563eb;

               font-size: 24px;

          }



          .profile-left h4 {

               margin: 0;

               font-weight: 800;

          }


          .profile-left p {

               margin: 4px 0 0;

               color: #64748b;

               font-size: 13px;

          }





          /* STATUS */


          .status-pill {

               padding: 8px 14px;

               display: inline-flex;

               align-items: center;

               gap: 7px;

               border-radius: 999px;

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

               background: #d9770b;

          }






          /* ROUTE */

          .route-container {

               padding: 20px;

               background: #f8fafc;

               border-radius: 20px;

               border: 1px solid #e2e8f0;

          }



          .section-title {

               display: flex;

               gap: 12px;

               align-items: center;

          }



          .section-icon {

               width: 44px;

               height: 44px;

               display: flex;

               align-items: center;

               justify-content: center;

               border-radius: 14px;

               background: #dbeafe;

               color: #2563eb;

          }



          .section-title h6 {

               margin: 0;

               font-weight: 800;

          }


          .section-title small {

               color: #64748b;

          }





          .route-line {

               display: flex;

               align-items: center;

               justify-content: space-between;

               gap: 20px;

               padding-top: 15px;

          }



          .location {

               display: flex;

               align-items: center;

               gap: 12px;

               background: white;

               padding: 16px;

               border-radius: 18px;

               flex: 1;

               border: 1px solid #e2e8f0;

          }



          .location-icon {

               width: 42px;

               height: 42px;

               border-radius: 14px;

               display: flex;

               align-items: center;

               justify-content: center;

               background: #eff6ff;

               color: #2563eb;

          }



          .location small {

               color: #64748b;

          }


          .location h5 {

               margin: 3px 0 0;

               font-weight: 800;

               font-size: 15px;

          }



          .direction {

               font-size: 25px;

               color: #94a3b8;

          }





          /* INFO */

          .info-card {

               display: flex;

               align-items: center;

               gap: 14px;

               padding: 18px;

               border-radius: 18px;

               background: #fff;

               border: 1px solid #e2e8f0;

               transition: .2s;

          }



          .info-card:hover {

               transform: translateY(-3px);

               box-shadow: 0 12px 25px rgba(15, 23, 42, .08);

          }



          .info-icon {

               width: 45px;

               height: 45px;

               display: flex;

               align-items: center;

               justify-content: center;

               border-radius: 14px;

               background: #eef2ff;

               color: #4f46e5;

               font-size: 20px;

          }



          .info-card small {

               color: #64748b;

               font-size: 12px;

          }



          .info-card h6 {

               margin: 3px 0 0;

               font-weight: 800;

               color: #0f172a;

          }





          .system-note {

               display: flex;

               gap: 14px;

               padding: 18px;

               background: #f8fafc;

               border-radius: 18px;

               border: 1px solid #e2e8f0;

          }



          .system-icon {

               width: 45px;

               height: 45px;

               display: flex;

               justify-content: center;

               align-items: center;

               background: #dbeafe;

               border-radius: 14px;

               color: #2563eb;

          }



          .system-note h6 {

               font-weight: 800;

          }



          .system-note p {

               margin: 0;

               font-size: 13px;

               color: #64748b;

          }





          @media(max-width:768px) {

               .route-line {

                    flex-direction: column;

               }

               .direction {

                    transform: rotate(90deg);

               }

          }
     </style>
@endsection
