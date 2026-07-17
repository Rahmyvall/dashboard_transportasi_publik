@extends('layouts.app')

@section('content')


     <div class="container-fluid py-4">


          {{-- HEADER --}}

          <div class="card border-0 shadow-sm mb-4"
               style="
background:linear-gradient(135deg,#0f172a,#2563eb);
border-radius:25px;
color:white;
">


               <div class="card-body p-4">


                    <div class="d-flex justify-content-between align-items-center">


                         <div>


                              <h3 class="fw-bold mb-2">

                                   <i class="ri-edit-line"></i>

                                   Edit Alert Transportasi

                              </h3>


                              <p class="mb-0 opacity-75">

                                   Perbarui informasi notifikasi transportasi

                              </p>


                         </div>



                         <a href="{{ route('admin.alerts.index') }}" class="btn btn-light rounded-pill px-4">


                              <i class="ri-arrow-left-line"></i>

                              Kembali


                         </a>


                    </div>


               </div>


          </div>





          @if ($errors->any())
               <div class="alert alert-danger rounded-4">

                    <ul class="mb-0">

                         @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                         @endforeach

                    </ul>

               </div>
          @endif





          <form method="POST" action="{{ route('admin.alerts.update', $alert->id) }}">


               @csrf

               @method('PUT')



               <div class="row g-4">



                    {{-- LEFT --}}

                    <div class="col-lg-8">


                         <div class="card border-0 shadow-sm rounded-4">


                              <div class="card-body p-4">


                                   <h5 class="fw-bold mb-4">

                                        <i class="ri-information-line text-primary"></i>

                                        Informasi Alert

                                   </h5>




                                   <div class="mb-3">

                                        <label class="form-label fw-semibold">

                                             Judul Alert

                                        </label>


                                        <input type="text" name="title" class="form-control rounded-3"
                                             value="{{ old('title', $alert->title) }}">


                                   </div>





                                   <div class="mb-3">

                                        <label class="form-label fw-semibold">

                                             Pesan

                                        </label>


                                        <textarea name="message" rows="5" class="form-control rounded-3">{{ old('message', $alert->message) }}</textarea>


                                   </div>





                                   <div class="row">


                                        <div class="col-md-6">


                                             <label class="form-label">

                                                  Alert Type

                                             </label>


                                             <select name="alert_type" class="form-select rounded-3">


                                                  @foreach (['delay', 'diversion', 'service_stop', 'crowded', 'emergency', 'info'] as $type)
                                                       <option value="{{ $type }}"
                                                            {{ old('alert_type', $alert->alert_type) == $type ? 'selected' : '' }}>


                                                            {{ strtoupper($type) }}


                                                       </option>
                                                  @endforeach


                                             </select>


                                        </div>





                                        <div class="col-md-6">


                                             <label class="form-label">

                                                  Priority

                                             </label>


                                             <select name="priority" class="form-select rounded-3">


                                                  @foreach (['low', 'medium', 'high', 'critical'] as $priority)
                                                       <option value="{{ $priority }}"
                                                            {{ old('priority', $alert->priority) == $priority ? 'selected' : '' }}>


                                                            {{ strtoupper($priority) }}


                                                       </option>
                                                  @endforeach


                                             </select>


                                        </div>


                                   </div>


                              </div>


                         </div>


                    </div>








                    {{-- RIGHT --}}

                    <div class="col-lg-4">


                         <div class="card border-0 shadow-sm rounded-4 mb-4">


                              <div class="card-body p-4">


                                   <h5 class="fw-bold mb-4">

                                        <i class="ri-route-line text-primary"></i>

                                        Relasi Transportasi

                                   </h5>





                                   <div class="mb-3">


                                        <label class="form-label">

                                             Incident

                                        </label>


                                        <select name="incident_id" class="form-select">


                                             <option value="">

                                                  Tidak ada incident

                                             </option>


                                             @foreach ($incidents as $incident)
                                                  <option value="{{ $incident->id }}"
                                                       {{ $alert->incident_id == $incident->id ? 'selected' : '' }}>


                                                       {{ $incident->title ?? 'Incident #' . $incident->id }}


                                                  </option>
                                             @endforeach


                                        </select>


                                   </div>







                                   <div class="mb-3">


                                        <label class="form-label">

                                             Route

                                        </label>


                                        <select name="route_id" class="form-select">


                                             <option value="">

                                                  Pilih Route

                                             </option>



                                             @foreach ($routes as $route)
                                                  <option value="{{ $route->id }}"
                                                       {{ $alert->route_id == $route->id ? 'selected' : '' }}>


                                                       {{ $route->route_name }}

                                                       -

                                                       {{ $route->origin }}

                                                       →

                                                       {{ $route->destination }}


                                                  </option>
                                             @endforeach



                                        </select>


                                   </div>







                                   <div class="mb-3">


                                        <label class="form-label">

                                             Vehicle

                                        </label>


                                        <select name="vehicle_id" class="form-select">


                                             <option value="">

                                                  Pilih Vehicle

                                             </option>



                                             @foreach ($vehicles as $vehicle)
                                                  <option value="{{ $vehicle->id }}"
                                                       {{ $alert->vehicle_id == $vehicle->id ? 'selected' : '' }}>


                                                       {{ $vehicle->vehicle_number ?? $vehicle->id }}


                                                  </option>
                                             @endforeach



                                        </select>


                                   </div>



                              </div>


                         </div>







                         <div class="card border-0 shadow-sm rounded-4">


                              <div class="card-body p-4">


                                   <h5 class="fw-bold">

                                        <i class="ri-send-plane-line text-primary"></i>

                                        Publikasi

                                   </h5>




                                   <div class="form-check form-switch mt-3">


                                        <input class="form-check-input" type="checkbox" name="is_published" value="1"
                                             {{ $alert->is_published ? 'checked' : '' }}>


                                        <label>

                                             Publish Alert

                                        </label>


                                   </div>





                                   <label class="mt-3">

                                        Expired Date

                                   </label>


                                   <input type="datetime-local" name="expired_at" class="form-control"
                                        value="{{ optional($alert->expired_at)->format('Y-m-d\TH:i') }}">



                              </div>


                         </div>



                    </div>



               </div>






               <div class="card border-0 shadow-sm rounded-4 mt-4">


                    <div class="card-body text-end">


                         <a href="{{ route('admin.alerts.index') }}" class="btn btn-light rounded-pill px-4">


                              Batal

                         </a>




                         <button class="btn btn-primary rounded-pill px-5">


                              <i class="ri-save-line"></i>

                              Update Alert


                         </button>



                    </div>


               </div>



          </form>


     </div>


@endsection
