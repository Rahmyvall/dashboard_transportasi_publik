@extends('layouts.app')


@section('content')


     <div class="container-fluid py-4">


          <style>
               .form-card {

                    border: 0;

                    border-radius: 25px;

                    overflow: hidden;

                    box-shadow:
                         0 15px 40px rgba(15, 23, 42, .08);

               }



               .form-header {

                    background:
                         linear-gradient(135deg,
                              #991b1b,
                              #ef4444);

                    color: white;

                    padding: 30px;

               }



               .section-title {

                    font-size: 17px;

                    font-weight: 800;

                    color: #0f172a;

                    margin-top: 25px;

                    margin-bottom: 15px;

               }



               .form-label {

                    font-weight: 700;

                    color: #334155;

               }



               .form-control,
               .form-select {

                    border-radius: 14px;

                    padding: 12px 15px;

               }



               .form-control:focus,
               .form-select:focus {

                    border-color: #ef4444;

                    box-shadow:
                         0 0 0 .2rem rgba(239, 68, 68, .15);

               }



               .btn-save {

                    background: #dc2626;

                    color: white;

                    border-radius: 14px;

                    padding: 12px 25px;

                    font-weight: 700;

               }



               .btn-save:hover {

                    background: #991b1b;

                    color: white;

               }



               #map {

                    height: 350px;

                    width: 100%;

                    border-radius: 20px;

                    border: 2px solid #e2e8f0;

               }
          </style>







          <div class="card form-card">



               <div class="form-header">


                    <h3 class="fw-bold mb-2">

                         <i class="ri-error-warning-line"></i>

                         Tambah Incident

                    </h3>


                    <p class="mb-0 opacity-75">

                         Input laporan kejadian operasional armada

                    </p>


               </div>








               <div class="card-body p-4">



                    @if ($errors->any())
                         <div class="alert alert-danger">


                              <ul class="mb-0">


                                   @foreach ($errors->all() as $error)
                                        <li>
                                             {{ $error }}
                                        </li>
                                   @endforeach


                              </ul>


                         </div>
                    @endif








                    <form action="{{ route('admin.incidents.store') }}" method="POST">


                         @csrf







                         {{-- ARMADA --}}



                         <div class="section-title">

                              <i class="ri-bus-line"></i>

                              Informasi Armada

                         </div>




                         <div class="row g-3">





                              <div class="col-md-4">


                                   <label class="form-label">

                                        Trip

                                   </label>


                                   <select name="trip_id" class="form-select">


                                        <option value="">

                                             -- Pilih Trip --

                                        </option>



                                        @foreach ($trips as $trip)
                                             <option value="{{ $trip->id }}">

                                                  {{ $trip->trip_code }}


                                             </option>
                                        @endforeach


                                   </select>


                              </div>








                              <div class="col-md-4">


                                   <label class="form-label">

                                        Vehicle

                                   </label>


                                   <select name="vehicle_id" class="form-select">


                                        <option value="">

                                             -- Pilih Armada --

                                        </option>



                                        @foreach ($vehicles as $vehicle)
                                             <option value="{{ $vehicle->id }}">

                                                  {{ $vehicle->plate_number }}


                                             </option>
                                        @endforeach


                                   </select>


                              </div>








                              <div class="col-md-4">


                                   <label class="form-label">

                                        Route

                                   </label>



                                   <select name="route_id" class="form-select">


                                        <option value="">

                                             -- Pilih Route --

                                        </option>



                                        @foreach ($routes as $route)
                                             <option value="{{ $route->id }}">


                                                  {{ $route->route_code }}

                                                  |

                                                  {{ $route->origin }}

                                                  -

                                                  {{ $route->destination }}


                                             </option>
                                        @endforeach



                                   </select>


                              </div>




                         </div>









                         {{-- INCIDENT --}}



                         <div class="section-title">

                              <i class="ri-file-warning-line"></i>

                              Detail Incident

                         </div>




                         <div class="row g-3">





                              <div class="col-md-6">


                                   <label class="form-label">

                                        Jenis Incident

                                   </label>



                                   <select name="incident_type" class="form-select">


                                        <option value="accident">
                                             Accident
                                        </option>


                                        <option value="breakdown">
                                             Breakdown
                                        </option>


                                        <option value="traffic">
                                             Traffic
                                        </option>


                                        <option value="weather">
                                             Weather
                                        </option>


                                        <option value="security">
                                             Security
                                        </option>


                                        <option value="other">
                                             Other
                                        </option>


                                   </select>


                              </div>








                              <div class="col-md-6">


                                   <label class="form-label">

                                        Severity

                                   </label>



                                   <select name="severity" class="form-select">


                                        <option value="low">
                                             Low
                                        </option>


                                        <option value="medium">
                                             Medium
                                        </option>


                                        <option value="high">
                                             High
                                        </option>


                                        <option value="critical">
                                             Critical
                                        </option>


                                   </select>


                              </div>







                              <div class="col-md-12">


                                   <label class="form-label">

                                        Judul Incident

                                   </label>


                                   <input type="text" name="title" class="form-control"
                                        placeholder="Contoh: Mesin kendaraan rusak">


                              </div>







                              <div class="col-md-12">


                                   <label class="form-label">

                                        Deskripsi

                                   </label>


                                   <textarea name="description" class="form-control" rows="4"></textarea>


                              </div>



                         </div>









                         {{-- REPORTER --}}



                         <div class="section-title">

                              <i class="ri-user-line"></i>

                              Informasi Reporter

                         </div>




                         <div class="row g-3">



                              <div class="col-md-6">


                                   <label class="form-label">

                                        Reporter

                                   </label>


                                   <select name="reported_by" class="form-select">


                                        <option value="">

                                             -- Pilih Reporter --

                                        </option>



                                        @foreach ($reporters as $reporter)
                                             <option value="{{ $reporter->id }}">


                                                  {{ $reporter->name }}


                                             </option>
                                        @endforeach


                                   </select>


                              </div>



                         </div>









                         {{-- LOCATION --}}



                         <div class="section-title">

                              <i class="ri-map-pin-line"></i>

                              Lokasi Kejadian

                         </div>






                         <div class="row g-3">



                              <div class="col-md-6">


                                   <label class="form-label">

                                        Latitude

                                   </label>


                                   <input type="text" id="latitude" name="location_latitude" class="form-control">


                              </div>







                              <div class="col-md-6">


                                   <label class="form-label">

                                        Longitude

                                   </label>


                                   <input type="text" id="longitude" name="location_longitude" class="form-control">


                              </div>



                         </div>






                         <div class="mt-3">


                              <label class="form-label">

                                   Pilih Lokasi Map

                              </label>


                              <div id="map"></div>


                         </div>









                         {{-- TIME --}}



                         <div class="section-title">

                              <i class="ri-time-line"></i>

                              Waktu Incident

                         </div>



                         <div class="col-md-6">


                              <label class="form-label">

                                   Reported At

                              </label>


                              <input type="datetime-local" name="reported_at" class="form-control">


                         </div>








                         <div class="d-flex justify-content-between mt-4">


                              <a href="{{ route('admin.incidents.index') }}" class="btn btn-light">


                                   Kembali

                              </a>





                              <button class="btn btn-save">


                                   <i class="ri-save-line"></i>

                                   Simpan Incident


                              </button>



                         </div>






                    </form>


               </div>


          </div>


     </div>








     <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">



     <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>





     <script>
          let lat =
               document.getElementById('latitude');


          let lng =
               document.getElementById('longitude');




          let map =
               L.map('map')
               .setView(
                    [-6.200000, 106.816666],
                    12
               );




          L.tileLayer(
                    'https://tile.openstreetmap.org/{z}/{x}/{y}.png'
               )
               .addTo(map);




          let marker;



          map.on(
               'click',
               function(e) {


                    lat.value =
                         e.latlng.lat.toFixed(7);



                    lng.value =
                         e.latlng.lng.toFixed(7);




                    if (marker) {

                         map.removeLayer(marker);

                    }



                    marker =
                         L.marker(
                              [
                                   e.latlng.lat,
                                   e.latlng.lng
                              ]
                         )
                         .addTo(map);



               }

          );
     </script>



@endsection
