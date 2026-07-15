@extends('layouts.app')


@section('content')


     <div class="container-fluid py-4">


          <style>
               .form-card {

                    border: 0;

                    border-radius: 25px;

                    overflow: hidden;

                    box-shadow:
                         0 15px 40px rgba(0, 0, 0, .08);

               }


               .form-header {

                    background:
                         linear-gradient(135deg,
                              #7f1d1d,
                              #ef4444);

                    color: white;

                    padding: 30px;

               }



               .form-label {

                    font-weight: 700;

                    color: #334155;

               }



               .form-control,
               .form-select {

                    border-radius: 14px;

                    padding: 12px;

               }



               #map {

                    height: 350px;

                    border-radius: 20px;

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

                    color: rgb(110, 86, 86);

               }


               .section-title {

                    font-size: 17px;

                    font-weight: 800;

                    margin-top: 25px;

                    margin-bottom: 15px;

               }
          </style>






          <div class="card form-card">



               <div class="form-header">


                    <h3 class="fw-bold">

                         <i class="ri-edit-line"></i>

                         Edit Incident

                    </h3>


                    <p class="mb-0">

                         Perbarui data kejadian operasional armada

                    </p>


               </div>







               <div class="card-body p-4">



                    @if ($errors->any())
                         <div class="alert alert-danger">


                              <ul class="mb-0">


                                   @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                   @endforeach


                              </ul>


                         </div>
                    @endif








                    <form action="{{ route('admin.incidents.update', $incident->id) }}" method="POST">


                         @csrf

                         @method('PUT')









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
                                             <option value="{{ $trip->id }}"
                                                  {{ old('trip_id', $incident->trip_id) == $trip->id ? 'selected' : '' }}>


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
                                             <option value="{{ $vehicle->id }}"
                                                  {{ old('vehicle_id', $incident->vehicle_id) == $vehicle->id ? 'selected' : '' }}>


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
                                             <option value="{{ $route->id }}"
                                                  {{ old('route_id', $incident->route_id) == $route->id ? 'selected' : '' }}>


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


                                        @foreach (['accident', 'breakdown', 'traffic', 'weather', 'security', 'other'] as $type)
                                             <option value="{{ $type }}"
                                                  {{ old('incident_type', $incident->incident_type) == $type ? 'selected' : '' }}>


                                                  {{ ucfirst($type) }}


                                             </option>
                                        @endforeach


                                   </select>


                              </div>







                              <div class="col-md-6">


                                   <label class="form-label">

                                        Severity

                                   </label>



                                   <select name="severity" class="form-select">


                                        @foreach (['low', 'medium', 'high', 'critical'] as $severity)
                                             <option value="{{ $severity }}"
                                                  {{ old('severity', $incident->severity) == $severity ? 'selected' : '' }}>


                                                  {{ ucfirst($severity) }}


                                             </option>
                                        @endforeach


                                   </select>


                              </div>






                              <div class="col-md-12">


                                   <label class="form-label">

                                        Judul

                                   </label>


                                   <input type="text" name="title" class="form-control"
                                        value="{{ old('title', $incident->title) }}">


                              </div>







                              <div class="col-md-12">


                                   <label class="form-label">

                                        Deskripsi

                                   </label>


                                   <textarea name="description" class="form-control" rows="4">{{ old('description', $incident->description) }}</textarea>


                              </div>


                         </div>









                         <div class="section-title">

                              <i class="ri-user-line"></i>

                              Reporter

                         </div>




                         <div class="row">


                              <div class="col-md-6">


                                   <select name="reported_by" class="form-select">


                                        <option value="">

                                             -- Pilih Reporter --

                                        </option>



                                        @foreach ($reporters as $reporter)
                                             <option value="{{ $reporter->id }}"
                                                  {{ old('reported_by', $incident->reported_by) == $reporter->id ? 'selected' : '' }}>


                                                  {{ $reporter->name }}


                                             </option>
                                        @endforeach



                                   </select>


                              </div>


                         </div>









                         <div class="section-title">

                              <i class="ri-map-pin-line"></i>

                              Lokasi Incident

                         </div>






                         <div class="row g-3">



                              <div class="col-md-6">


                                   <label class="form-label">

                                        Latitude

                                   </label>


                                   <input type="text" id="latitude" name="location_latitude" class="form-control"
                                        value="{{ old('location_latitude', $incident->location_latitude) }}">


                              </div>





                              <div class="col-md-6">


                                   <label class="form-label">

                                        Longitude

                                   </label>


                                   <input type="text" id="longitude" name="location_longitude" class="form-control"
                                        value="{{ old('location_longitude', $incident->location_longitude) }}">


                              </div>



                         </div>






                         <div id="map" class="mt-3"></div>








                         <div class="section-title">

                              <i class="ri-time-line"></i>

                              Waktu

                         </div>





                         <div class="row g-3">


                              <div class="col-md-6">


                                   <label class="form-label">

                                        Reported At

                                   </label>


                                   <input type="datetime-local" name="reported_at" class="form-control"
                                        value="{{ $incident->reported_at ? $incident->reported_at->format('Y-m-d\TH:i') : '' }}">


                              </div>



                         </div>









                         <div class="section-title">

                              <i class="ri-shield-check-line"></i>

                              Status

                         </div>




                         <select name="status" class="form-select">


                              @foreach (['open', 'in_progress', 'resolved', 'closed'] as $status)
                                   <option value="{{ $status }}"
                                        {{ old('status', $incident->status) == $status ? 'selected' : '' }}>


                                        {{ strtoupper($status) }}


                                   </option>
                              @endforeach


                         </select>









                         <div class="d-flex justify-content-between mt-4">


                              <a href="{{ route('admin.incidents.index') }}" class="btn btn-light">


                                   <i class="ri-arrow-left-line"></i>

                                   Kembali


                              </a>



                              <button type="submit" class="btn btn-save">


                                   <i class="ri-save-line"></i>

                                   Update Incident


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
               {{ $incident->location_latitude ?? -6.2 }};


          let lng =
               {{ $incident->location_longitude ?? 106.816 }};



          let map =
               L.map('map')
               .setView(
                    [
                         lat,
                         lng
                    ],
                    13
               );



          L.tileLayer(
                    'https://tile.openstreetmap.org/{z}/{x}/{y}.png'
               )
               .addTo(map);




          let marker =
               L.marker(
                    [
                         lat,
                         lng
                    ]
               )
               .addTo(map);





          map.on(
               'click',
               function(e) {


                    document.getElementById('latitude').value =
                         e.latlng.lat.toFixed(7);



                    document.getElementById('longitude').value =
                         e.latlng.lng.toFixed(7);



                    marker.setLatLng(e.latlng);


               }

          );
     </script>


@endsection
