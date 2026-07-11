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

               background: linear-gradient(135deg,
                         #ccced3,
                         #2563eb);

               color: white;

               padding: 35px;

               border-radius: 25px;

               margin-bottom: 25px;

          }



          .header-card h2 {

               font-weight: 800;

          }



          .form-card {

               background: white;

               border-radius: 25px;

               padding: 35px;

               box-shadow:
                    0 10px 30px rgba(0, 0, 0, .08);

          }



          .section-title {

               font-size: 18px;

               font-weight: 800;

               color: #0f172a;

               margin-bottom: 20px;

          }



          .form-label {

               font-weight: 700;

               color: #334155;

          }



          .form-control,
          .form-select {

               height: 52px;

               border-radius: 15px;

               border: 1px solid #dbe3ef;

          }



          .form-control:focus,
          .form-select:focus {

               border-color: #2563eb;

               box-shadow:
                    0 0 0 .2rem rgba(37, 99, 235, .15);

          }



          #map {

               height: 400px;

               border-radius: 25px;

               margin-top: 20px;

          }




          .btn-primary-custom {

               background: #2563eb;

               color: white;

               border: none;

               padding: 14px 30px;

               border-radius: 15px;

               font-weight: 700;

          }



          .btn-back {

               background: #e2e8f0;

               color: #334155;

               padding: 14px 30px;

               border-radius: 15px;

               text-decoration: none;

               font-weight: 700;

          }
     </style>







     <div class="page-wrapper">



          <div class="header-card">


               <h2>

                    <i class="bi bi-geo-alt-fill"></i>

                    Tambah Vehicle Position

               </h2>


               <p class="mb-0">

                    Input data tracking kendaraan GPS

               </p>


          </div>








          <div class="form-card">


               <form action="{{ route('admin.vehicle-positions.store') }}" method="POST">


                    @csrf





                    <!-- VEHICLE -->

                    <div class="section-title">

                         <i class="bi bi-truck"></i>

                         Vehicle Information

                    </div>



                    <div class="row g-4">



                         <div class="col-md-6">


                              <label class="form-label">

                                   Vehicle

                              </label>


                              <select name="vehicle_id" class="form-select" required>


                                   <option value="">

                                        -- Pilih Vehicle --

                                   </option>


                                   @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}">


                                             {{ $vehicle->vehicle_code }}

                                             @if (isset($vehicle->plate_number))
                                                  - {{ $vehicle->plate_number }}
                                             @endif


                                        </option>
                                   @endforeach


                              </select>


                         </div>








                         <div class="col-md-6">


                              <label class="form-label">

                                   Trip

                              </label>


                              <select name="trip_id" class="form-select">


                                   <option value="">

                                        -- No Trip --

                                   </option>


                                   @foreach ($trips as $trip)
                                        <option value="{{ $trip->id }}">

                                             {{ $trip->trip_code }}

                                        </option>
                                   @endforeach


                              </select>


                         </div>



                    </div>









                    <hr class="my-5">








                    <!-- GPS -->


                    <div class="section-title">

                         <i class="bi bi-map"></i>

                         GPS Location

                    </div>







                    <div class="row g-3">



                         <div class="col-md-9">


                              <label class="form-label">

                                   Search Location

                              </label>


                              <input type="text" id="place_name" class="form-control"
                                   placeholder="Contoh Jakarta Indonesia">


                         </div>





                         <div class="col-md-3">


                              <label class="form-label">

                                   &nbsp;

                              </label>


                              <button type="button" onclick="searchLocation()" class="btn-primary-custom w-100">


                                   <i class="bi bi-search"></i>

                                   Find


                              </button>


                         </div>



                    </div>







                    <div id="map"></div>







                    <div class="row g-4 mt-3">



                         <div class="col-md-6">


                              <label class="form-label">

                                   Latitude

                              </label>


                              <input type="number" name="latitude" id="latitude" class="form-control" step="0.0000001"
                                   min="-90" max="90" required>


                         </div>






                         <div class="col-md-6">


                              <label class="form-label">

                                   Longitude

                              </label>


                              <input type="number" name="longitude" id="longitude" class="form-control" step="0.0000001"
                                   min="-180" max="180" required>


                         </div>



                    </div>










                    <hr class="my-5">







                    <!-- MOVEMENT -->


                    <div class="section-title">

                         <i class="bi bi-speedometer2"></i>

                         Vehicle Movement

                    </div>





                    <div class="row g-4">



                         <div class="col-md-4">


                              <label class="form-label">

                                   Speed KM/H

                              </label>


                              <input type="number" step="0.01" name="speed_kmh" class="form-control" value="0">


                         </div>







                         <div class="col-md-4">


                              <label class="form-label">

                                   Heading Degree

                              </label>


                              <input type="number" name="heading_degree" min="0" max="360" class="form-control"
                                   value="0">


                         </div>







                         <div class="col-md-4">


                              <label class="form-label">

                                   Recorded At

                              </label>


                              <input type="datetime-local" name="recorded_at" class="form-control"
                                   value="{{ now()->format('Y-m-d\TH:i') }}" required>


                         </div>



                    </div>







                    <div class="mt-5 d-flex gap-3">


                         <a href="{{ route('admin.vehicle-positions.index') }}" class="btn-back">


                              <i class="bi bi-arrow-left"></i>

                              Kembali


                         </a>





                         <button type="submit" class="btn-primary-custom">


                              <i class="bi bi-save"></i>

                              Simpan Position


                         </button>


                    </div>





               </form>


          </div>



     </div>









     <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>



     <script>
          let map = L.map('map')
               .setView(
                    [-6.2000000, 106.8166667],
                    5
               );



          L.tileLayer(

                    'https://tile.openstreetmap.org/{z}/{x}/{y}.png'

               )

               .addTo(map);




          let marker = L.marker(
                    [-6.2000000, 106.8166667]
               )

               .addTo(map);







          function setCoordinate(lat, lng) {


               lat = Number(lat).toFixed(7);

               lng = Number(lng).toFixed(7);



               document.getElementById('latitude').value = lat;


               document.getElementById('longitude').value = lng;



               marker.setLatLng(
                    [
                         lat,
                         lng
                    ]
               );



               map.setView(
                    [
                         lat,
                         lng
                    ],
                    15
               );


          }







          map.on(

               'click',

               function(e) {


                    setCoordinate(

                         e.latlng.lat,

                         e.latlng.lng

                    );


               }

          );








          function searchLocation() {


               let place =
                    document.getElementById('place_name').value;



               if (place == "") {

                    alert("Masukkan lokasi");

                    return;

               }



               fetch(

                         'https://nominatim.openstreetmap.org/search?format=json&q='

                         +
                         encodeURIComponent(place)

                    )


                    .then(response => response.json())


                    .then(data => {


                         if (data.length > 0) {


                              setCoordinate(

                                   data[0].lat,

                                   data[0].lon

                              );



                         } else {


                              alert("Lokasi tidak ditemukan");

                         }


                    });


          }
     </script>
@endsection
