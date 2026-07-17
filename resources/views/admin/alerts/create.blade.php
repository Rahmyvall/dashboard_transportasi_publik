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

                                   <i class="ri-notification-add-line"></i>

                                   Tambah Alert Transportasi

                              </h3>


                              <p class="mb-0 opacity-75">

                                   Membuat informasi gangguan dan notifikasi layanan transportasi

                              </p>


                         </div>



                         <a href="{{ route('admin.alerts.index') }}" class="btn btn-light rounded-pill px-4">


                              <i class="ri-arrow-left-line"></i>

                              Kembali


                         </a>


                    </div>


               </div>


          </div>







          {{-- VALIDATION ERROR --}}

          @if ($errors->any())
               <div class="alert alert-danger rounded-4">


                    <strong>

                         Terjadi kesalahan:

                    </strong>


                    <ul class="mb-0 mt-2">


                         @foreach ($errors->all() as $error)
                              <li>

                                   {{ $error }}

                              </li>
                         @endforeach


                    </ul>


               </div>
          @endif







          <form action="{{ route('admin.alerts.store') }}" method="POST">


               @csrf





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

                                             <span class="text-danger">*</span>

                                        </label>


                                        <input type="text" name="title" class="form-control rounded-3"
                                             value="{{ old('title') }}" placeholder="Contoh: Bus mengalami keterlambatan">


                                   </div>







                                   <div class="mb-3">


                                        <label class="form-label fw-semibold">

                                             Pesan Alert

                                             <span class="text-danger">*</span>

                                        </label>



                                        <textarea name="message" rows="5" class="form-control rounded-3" placeholder="Masukkan informasi detail alert">{{ old('message') }}</textarea>



                                   </div>







                                   <div class="row">


                                        <div class="col-md-6">


                                             <label class="form-label fw-semibold">

                                                  Jenis Alert

                                             </label>


                                             <select name="alert_type" class="form-select rounded-3">


                                                  <option value="">
                                                       -- Pilih Type --
                                                  </option>


                                                  <option value="delay">
                                                       Delay
                                                  </option>


                                                  <option value="diversion">
                                                       Diversion
                                                  </option>


                                                  <option value="service_stop">
                                                       Service Stop
                                                  </option>


                                                  <option value="crowded">
                                                       Crowded
                                                  </option>


                                                  <option value="emergency">
                                                       Emergency
                                                  </option>


                                                  <option value="info">
                                                       Information
                                                  </option>


                                             </select>


                                        </div>





                                        <div class="col-md-6">


                                             <label class="form-label fw-semibold">

                                                  Priority

                                             </label>


                                             <select name="priority" class="form-select rounded-3">


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


                                        <select name="incident_id" class="form-select rounded-3">


                                             <option value="">

                                                  -- Tidak Ada Incident --

                                             </option>



                                             @foreach ($incidents as $incident)
                                                  <option value="{{ $incident->id }}">


                                                       {{ $incident->title ?? 'Incident #' . $incident->id }}


                                                  </option>
                                             @endforeach



                                        </select>


                                   </div>








                                   <div class="mb-3">


                                        <label class="form-label">

                                             Route

                                        </label>


                                        <select name="route_id" class="form-select rounded-3">


                                             <option value="">

                                                  -- Pilih Route --

                                             </option>



                                             @foreach ($routes as $route)
                                                  <option value="{{ $route->id }}">


                                                       {{ $route->name }}


                                                  </option>
                                             @endforeach


                                        </select>


                                   </div>








                                   <div class="mb-3">


                                        <label class="form-label">

                                             Vehicle

                                        </label>



                                        <select name="vehicle_id" class="form-select rounded-3">


                                             <option value="">

                                                  -- Pilih Vehicle --

                                             </option>



                                             @foreach ($vehicles as $vehicle)
                                                  <option value="{{ $vehicle->id }}">


                                                       {{ $vehicle->vehicle_number ?? $vehicle->id }}


                                                  </option>
                                             @endforeach



                                        </select>



                                   </div>



                              </div>


                         </div>








                         <div class="card border-0 shadow-sm rounded-4">


                              <div class="card-body p-4">


                                   <h5 class="fw-bold mb-3">

                                        <i class="ri-send-plane-line text-primary"></i>

                                        Publikasi

                                   </h5>




                                   <div class="form-check form-switch mb-3">


                                        <input class="form-check-input" type="checkbox" name="is_published" value="1"
                                             id="publishCheck">


                                        <label class="form-check-label" for="publishCheck">


                                             Publish sekarang


                                        </label>


                                   </div>





                                   <label class="form-label">

                                        Expired Date


                                   </label>


                                   <input type="datetime-local" name="expired_at" class="form-control rounded-3">



                              </div>


                         </div>



                    </div>



               </div>






               <div class="card border-0 shadow-sm rounded-4 mt-4">


                    <div class="card-body p-3 text-end">


                         <a href="{{ route('admin.alerts.index') }}" class="btn btn-light rounded-pill px-4 me-2">


                              Batal


                         </a>




                         <button type="submit" class="btn btn-primary rounded-pill px-5">


                              <i class="ri-save-line"></i>


                              Simpan Alert


                         </button>


                    </div>


               </div>





          </form>


     </div>


@endsection
