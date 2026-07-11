@extends('layouts.app')


@section('content')
     <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">


     <style>
          body {
               background: #f1f5f9;
          }


          .page-wrapper {

               padding: 30px;

          }


          .header-card {

               background: linear-gradient(135deg, #868fa3, #495a80);

               color: white;

               padding: 35px;

               border-radius: 25px;

               margin-bottom: 25px;

          }



          .detail-card {

               background: white;

               padding: 30px;

               border-radius: 25px;

               box-shadow: 0 10px 30px rgba(0, 0, 0, .08);

          }



          .info-box {

               background: #f8fafc;

               padding: 20px;

               border-radius: 18px;

          }



          .label {

               font-size: 13px;

               color: #64748b;

          }



          .value {

               font-weight: 800;

               color: #0f172a;

          }



          #map {

               height: 400px;

               border-radius: 25px;

          }



          .btn-back {

               background: #e2e8f0;

               padding: 12px 25px;

               border-radius: 15px;

               text-decoration: none;

               font-weight: 700;

               color: #334155;

          }


          .btn-edit {

               background: #2563eb;

               padding: 12px 25px;

               border-radius: 15px;

               text-decoration: none;

               font-weight: 700;

               color: white;

          }
     </style>







     <div class="page-wrapper">



          <div class="header-card">


               <h2>

                    <i class="bi bi-geo-alt-fill"></i>

                    Detail Vehicle Position

               </h2>


               <p class="mb-0">

                    Informasi lokasi kendaraan

               </p>


          </div>








          <div class="detail-card">



               <div class="row g-4">



                    <div class="col-md-4">


                         <div class="info-box">


                              <div class="label">

                                   Vehicle

                              </div>


                              <div class="value">

                                   {{ $position->vehicle->vehicle_code ?? '-' }}

                              </div>


                         </div>


                    </div>







                    <div class="col-md-4">


                         <div class="info-box">


                              <div class="label">

                                   Trip

                              </div>


                              <div class="value">

                                   {{ $position->trip->trip_code ?? 'No Trip' }}

                              </div>


                         </div>


                    </div>








                    <div class="col-md-4">


                         <div class="info-box">


                              <div class="label">

                                   Recorded At

                              </div>


                              <div class="value">

                                   {{ $position->recorded_at->format('d M Y H:i') }}

                              </div>


                         </div>


                    </div>



               </div>







               <hr class="my-5">






               <div class="row g-4">



                    <div class="col-md-3">


                         <div class="info-box">


                              <div class="label">

                                   Latitude

                              </div>


                              <div class="value">

                                   {{ $position->latitude }}

                              </div>


                         </div>


                    </div>






                    <div class="col-md-3">


                         <div class="info-box">


                              <div class="label">

                                   Longitude

                              </div>


                              <div class="value">

                                   {{ $position->longitude }}

                              </div>


                         </div>


                    </div>








                    <div class="col-md-3">


                         <div class="info-box">


                              <div class="label">

                                   Speed

                              </div>


                              <div class="value">

                                   {{ $position->speed_kmh ?? 0 }} KM/H

                              </div>


                         </div>


                    </div>






                    <div class="col-md-3">


                         <div class="info-box">


                              <div class="label">

                                   Heading

                              </div>


                              <div class="value">

                                   {{ $position->heading_degree ?? 0 }}°

                              </div>


                         </div>


                    </div>



               </div>







               <div id="map" class="mt-5"></div>








               <div class="mt-4 d-flex gap-3">


                    <a href="{{ route('admin.vehicle-positions.index') }}" class="btn-back">

                         <i class="bi bi-arrow-left"></i>

                         Kembali

                    </a>




                    <a href="{{ route('admin.vehicle-positions.edit', $position->id) }}" class="btn-edit">

                         <i class="bi bi-pencil"></i>

                         Edit

                    </a>



               </div>





          </div>


     </div>







     <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>


     <script>
          let lat =
               {{ $position->latitude }};


          let lng =
               {{ $position->longitude }};



          let map = L.map('map')

               .setView(

                    [lat, lng],

                    15

               );



          L.tileLayer(

                    'https://tile.openstreetmap.org/{z}/{x}/{y}.png'

               )

               .addTo(map);



          L.marker([lat, lng])

               .addTo(map)

               .bindPopup(

                    `

<b>

{{ $position->vehicle->vehicle_code ?? '' }}

</b>

<br>

Speed :

{{ $position->speed_kmh }}

KM/H

`

               )

               .openPopup();
     </script>
@endsection
