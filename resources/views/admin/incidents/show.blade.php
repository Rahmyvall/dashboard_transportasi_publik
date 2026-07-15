@extends('layouts.app')


@section('content')
     <div class="container-fluid py-4">


          <style>
               body {

                    background: #f8fafc;

               }



               .detail-card {

                    border: 0;

                    border-radius: 28px;

                    box-shadow:
                         0 20px 45px rgba(15, 23, 42, .08);

                    overflow: hidden;

               }



               .header-card {

                    background:
                         linear-gradient(135deg,
                              #450a0a,
                              #991b1b,
                              #ef4444);

                    padding: 35px;

                    color: white;

               }



               .header-title {

                    font-size: 30px;

                    font-weight: 900;

               }



               .badge-modern {

                    padding: 10px 18px;

                    border-radius: 50px;

                    font-weight: 800;

                    font-size: 12px;

               }





               .info-card {

                    border: 0;

                    border-radius: 22px;

                    background: white;

                    box-shadow:
                         0 10px 30px rgba(0, 0, 0, .06);

                    padding: 25px;

                    height: 100%;

               }



               .info-title {

                    font-size: 16px;

                    font-weight: 800;

                    color: #0f172a;

                    margin-bottom: 20px;

               }



               .info-item {

                    display: flex;

                    justify-content: space-between;

                    padding: 12px 0;

                    border-bottom: 1px solid #e2e8f0;

               }



               .info-item:last-child {

                    border-bottom: 0;

               }



               .info-label {

                    color: #64748b;

                    font-weight: 600;

               }



               .info-value {

                    font-weight: 700;

                    color: #111827;

                    text-align: right;

               }




               .description-box {

                    background: #f8fafc;

                    border-radius: 18px;

                    padding: 20px;

                    line-height: 1.7;

               }




               #map {

                    height: 450px;

                    border-radius: 25px;

                    overflow: hidden;

               }





               .btn-action {

                    border-radius: 15px;

                    padding: 12px 22px;

                    font-weight: 700;

               }
          </style>









          {{-- HEADER --}}


          <div class="detail-card mb-4">


               <div class="header-card">


                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">


                         <div>


                              <div class="header-title">


                                   <i class="ri-error-warning-line"></i>

                                   {{ $incident->title }}


                              </div>


                              <p class="mb-0 mt-2 opacity-75">

                                   Detail laporan kejadian operasional armada

                              </p>


                         </div>






                         <div>


                              <span class="badge-modern bg-warning text-dark">

                                   {{ strtoupper($incident->severity) }}

                              </span>



                              <span class="badge-modern bg-light text-danger">


                                   {{ strtoupper($incident->status) }}


                              </span>


                         </div>


                    </div>


               </div>


          </div>









          <div class="row g-4">





               {{-- LEFT --}}


               <div class="col-xl-7">





                    <div class="info-card mb-4">


                         <div class="info-title">


                              <i class="ri-information-line text-danger"></i>

                              Informasi Incident


                         </div>





                         <div class="info-item">


                              <span class="info-label">

                                   Jenis Incident

                              </span>


                              <span class="info-value">

                                   {{ ucfirst($incident->incident_type) }}

                              </span>


                         </div>






                         <div class="info-item">


                              <span class="info-label">

                                   Tanggal Laporan

                              </span>


                              <span class="info-value">


                                   {{ $incident->reported_at ? $incident->reported_at->format('d M Y H:i') : '-' }}


                              </span>


                         </div>






                         <div class="info-item">


                              <span class="info-label">

                                   Reporter

                              </span>


                              <span class="info-value">

                                   {{ $incident->reporter->name ?? '-' }}

                              </span>


                         </div>





                    </div>









                    <div class="info-card mb-4">


                         <div class="info-title">


                              <i class="ri-bus-line text-danger"></i>

                              Informasi Armada


                         </div>






                         <div class="info-item">


                              <span class="info-label">

                                   Vehicle

                              </span>


                              <span class="info-value">

                                   {{ $incident->vehicle->plate_number ?? '-' }}

                              </span>


                         </div>







                         <div class="info-item">


                              <span class="info-label">

                                   Trip

                              </span>


                              <span class="info-value">

                                   {{ $incident->trip->trip_code ?? '-' }}

                              </span>


                         </div>








                         <div class="info-item">


                              <span class="info-label">

                                   Route

                              </span>


                              <span class="info-value">


                                   @if ($incident->route)
                                        {{ $incident->route->route_code }}

                                        <br>

                                        <small class="text-muted">

                                             {{ $incident->route->origin }}

                                             -

                                             {{ $incident->route->destination }}

                                        </small>
                                   @else
                                        -
                                   @endif



                              </span>


                         </div>





                    </div>









                    <div class="info-card">


                         <div class="info-title">


                              <i class="ri-file-text-line text-danger"></i>

                              Deskripsi Kejadian


                         </div>



                         <div class="description-box">


                              {{ $incident->description ?? 'Tidak ada deskripsi' }}


                         </div>



                    </div>







               </div>









               {{-- RIGHT MAP --}}


               <div class="col-xl-5">


                    <div class="info-card">



                         <div class="info-title">


                              <i class="ri-map-pin-line text-danger"></i>

                              Lokasi Incident


                         </div>




                         <div id="map"></div>






                         @if ($incident->location_latitude)
                              <div class="mt-3 text-center">


                                   <a target="_blank"
                                        href="https://maps.google.com/?q={{ $incident->location_latitude }},{{ $incident->location_longitude }}"
                                        class="btn btn-success btn-action">


                                        <i class="ri-navigation-line"></i>

                                        Buka Google Maps


                                   </a>


                              </div>
                         @endif




                    </div>



               </div>



          </div>









          <div class="mt-4">


               <a href="{{ route('admin.incidents.index') }}" class="btn btn-secondary btn-action">


                    <i class="ri-arrow-left-line"></i>

                    Kembali


               </a>





               <a href="{{ route('admin.incidents.edit', $incident->id) }}" class="btn btn-danger btn-action">


                    <i class="ri-edit-line"></i>

                    Edit Incident


               </a>


          </div>









          <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">


          <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>





          <script>
               let lat =
                    {{ $incident->location_latitude ?? -6.2 }};



               let lng =
                    {{ $incident->location_longitude ?? 106.8 }};





               let map =
                    L.map('map')
                    .setView(
                         [
                              lat,
                              lng
                         ],
                         14
                    );





               L.tileLayer(
                         'https://tile.openstreetmap.org/{z}/{x}/{y}.png', {

                              maxZoom: 19

                         }
                    )
                    .addTo(map);





               L.marker(
                         [
                              lat,
                              lng
                         ]
                    )
                    .addTo(map)
                    .bindPopup(

                         `
<strong>
{{ $incident->title }}
</strong>
<br>

{{ $incident->vehicle->plate_number ?? '-' }}

`

                    )
                    .openPopup();
          </script>
     @endsection
