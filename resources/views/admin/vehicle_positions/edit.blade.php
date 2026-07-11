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
                         #9d9e9e,
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

               margin-bottom: 20px;

               color: #0f172a;

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




          #map {

               height: 400px;

               border-radius: 25px;

               margin-top: 20px;

          }




          .btn-update {

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

                    <i class="bi bi-pencil-square"></i>

                    Edit Vehicle Position

               </h2>


               <p class="mb-0">

                    Perbarui data tracking kendaraan

               </p>


          </div>









          <div class="form-card">


               <form action="{{ route('admin.vehicle-positions.update', $position->id) }}" method="POST">


                    @csrf

                    @method('PUT')








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
                                        <option value="{{ $vehicle->id }}"
                                             {{ $position->vehicle_id == $vehicle->id ? 'selected' : '' }}>


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
                                        <option value="{{ $trip->id }}"
                                             {{ $position->trip_id == $trip->id ? 'selected' : '' }}>


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


                              <input type="text" id="place_name" class="form-control" placeholder="Cari lokasi">


                         </div>





                         <div class="col-md-3">


                              <label class="form-label">

                                   &nbsp;

                              </label>


                              <button type="button" onclick="searchLocation()" class="btn-update w-100">


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


                              <input type="number" step="0.0000001" name="latitude" id="latitude" class="form-control"
                                   value="{{ number_format($position->latitude, 7, '.', '') }}" required>


                         </div>








                         <div class="col-md-6">


                              <label class="form-label">

                                   Longitude

                              </label>


                              <input type="number" step="0.0000001" name="longitude" id="longitude" class="form-control"
                                   value="{{ number_format($position->longitude, 7, '.', '') }}" required>


                         </div>



                    </div>










                    <hr class="my-5">








                    <div class="section-title">


                         <i class="bi bi-speedometer2"></i>

                         Vehicle Movement


                    </div>







                    <div class="row g-4">





                         <div class="col-md-4">


                              <label class="form-label">

                                   Speed KM/H

                              </label>


                              <input type="number" step="0.01" name="speed_kmh" class="form-control"
                                   value="{{ $position->speed_kmh }}">


                         </div>







                         <div class="col-md-4">


                              <label class="form-label">

                                   Heading Degree

                              </label>


                              <input type="number" name="heading_degree" min="0" max="360" class="form-control"
                                   value="{{ $position->heading_degree }}">


                         </div>








                         <div class="col-md-4">


                              <label class="form-label">

                                   Recorded At

                              </label>


                              <input type="datetime-local" name="recorded_at" class="form-control"
                                   value="{{ $position->recorded_at?->format('Y-m-d\TH:i') }}" required>


                         </div>





                    </div>








                    <div class="mt-5 d-flex gap-3">



                         <a href="{{ route('admin.vehicle-positions.index') }}" class="btn-back">


                              <i class="bi bi-arrow-left"></i>

                              Kembali


                         </a>





                         <button type="submit" class="btn-update">


                              <i class="bi bi-save"></i>

                              Update Position


                         </button>




                    </div>






               </form>


          </div>


     </div>









     <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>



     <script>
          let latOld = {{ $position->latitude }};

          let lngOld = {{ $position->longitude }};





          let map = L.map('map')

               .setView(

                    [latOld, lngOld],

                    15

               );





          L.tileLayer(

                    'https://tile.openstreetmap.org/{z}/{x}/{y}.png'

               )

               .addTo(map);






          let marker = L.marker(

                    [latOld, lngOld]

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

                    alert('Masukkan lokasi');

                    return;

               }



               fetch(

                         'https://nominatim.openstreetmap.org/search?format=json&q='

                         +

                         encodeURIComponent(place)

                    )


                    .then(res => res.json())


                    .then(data => {


                         if (data.length) {


                              setCoordinate(

                                   data[0].lat,

                                   data[0].lon

                              );



                         } else {


                              alert('Lokasi tidak ditemukan');

                         }


                    });



          }
     </script>
@endsection
