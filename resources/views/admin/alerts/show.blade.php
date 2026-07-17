@extends('layouts.app')

@section('content')
     <div class="container-fluid py-4">


          {{-- HEADER --}}

          <div class="card border-0 shadow-sm rounded-4 mb-4"
               style="
background:linear-gradient(135deg,#6982be,#7d9bdb);
color:white;
">


               <div class="card-body p-4">


                    <div class="d-flex justify-content-between align-items-center flex-wrap">


                         <div class="d-flex align-items-center gap-3">


                              <div class="rounded-circle bg-white bg-opacity-25 p-3">


                                   <i class="{{ $alert->alert_icon ?? 'ri-notification-line' }} fs-2"></i>


                              </div>




                              <div>


                                   <h2 class="fw-bold mb-1">

                                        {{ $alert->title }}

                                   </h2>



                                   <p class="mb-0 opacity-75">

                                        <i class="ri-time-line"></i>

                                        {{ $alert->created_at->diffForHumans() }}

                                   </p>


                              </div>


                         </div>







                         <div class="d-flex gap-2">


                              <a href="{{ route('admin.alerts.edit', $alert->id) }}"
                                   class="btn btn-warning rounded-pill text-white px-4">


                                   <i class="ri-edit-line"></i>

                                   Edit


                              </a>




                              <a href="{{ route('admin.alerts.index') }}" class="btn btn-light rounded-pill px-4">


                                   <i class="ri-arrow-left-line"></i>

                                   Back


                              </a>


                         </div>



                    </div>


               </div>


          </div>







          {{-- STATUS CARD --}}


          <div class="row g-3 mb-4">



               <div class="col-md-4">


                    <div class="card border-0 shadow-sm rounded-4">


                         <div class="card-body">


                              <div class="d-flex align-items-center">


                                   <div class="bg-info-subtle rounded-circle p-3 me-3">


                                        <i class="ri-notification-3-line text-info fs-3"></i>


                                   </div>



                                   <div>


                                        <small class="text-muted">

                                             Alert Type

                                        </small>


                                        <h5 class="fw-bold mb-0">

                                             {{ strtoupper($alert->alert_type) }}

                                        </h5>


                                   </div>


                              </div>


                         </div>


                    </div>


               </div>







               <div class="col-md-4">


                    <div class="card border-0 shadow-sm rounded-4">


                         <div class="card-body">


                              <div class="d-flex align-items-center">


                                   <div class="bg-danger-subtle rounded-circle p-3 me-3">


                                        <i class="ri-alarm-warning-line text-danger fs-3"></i>


                                   </div>



                                   <div>


                                        <small class="text-muted">

                                             Priority

                                        </small>


                                        <h5 class="fw-bold mb-0">

                                             {{ strtoupper($alert->priority) }}

                                        </h5>


                                   </div>


                              </div>


                         </div>


                    </div>


               </div>







               <div class="col-md-4">


                    <div class="card border-0 shadow-sm rounded-4">


                         <div class="card-body">


                              <div class="d-flex align-items-center">


                                   <div class="bg-success-subtle rounded-circle p-3 me-3">


                                        <i class="ri-checkbox-circle-line text-success fs-3"></i>


                                   </div>



                                   <div>


                                        <small class="text-muted">

                                             Status

                                        </small>


                                        <h5 class="fw-bold mb-0">


                                             {{ $alert->status }}


                                        </h5>


                                   </div>


                              </div>


                         </div>


                    </div>


               </div>



          </div>







          {{-- MESSAGE --}}


          <div class="card border-0 shadow-sm rounded-4 mb-4">


               <div class="card-body p-4">


                    <h5 class="fw-bold mb-3">

                         <i class="ri-message-2-line text-primary"></i>

                         Pesan Alert

                    </h5>



                    <div class="alert alert-primary rounded-4 mb-0">


                         {{ $alert->message }}


                    </div>



               </div>


          </div>







          {{-- TRANSPORT DETAIL --}}


          <div class="row g-4">





               {{-- ROUTE --}}

               <div class="col-lg-4">


                    <div class="card border-0 shadow-sm rounded-4 h-100">


                         <div class="card-body p-4">


                              <h5 class="fw-bold">

                                   <i class="ri-route-line text-primary"></i>

                                   Route

                              </h5>


                              <hr>



                              @if ($alert->route)
                                   <h6 class="fw-bold">

                                        {{ $alert->route->route_name }}

                                   </h6>



                                   <p class="text-muted mb-0">


                                        <i class="ri-map-pin-line"></i>


                                        {{ $alert->route->origin }}

                                        →

                                        {{ $alert->route->destination }}


                                   </p>
                              @else
                                   <span class="text-muted">

                                        Tidak ada route

                                   </span>
                              @endif


                         </div>


                    </div>


               </div>







               {{-- VEHICLE --}}

               <div class="col-lg-4">


                    <div class="card border-0 shadow-sm rounded-4 h-100">


                         <div class="card-body p-4">


                              <h5 class="fw-bold">

                                   <i class="ri-bus-line text-success"></i>

                                   Vehicle

                              </h5>


                              <hr>



                              @if ($alert->vehicle)
                                   <h4 class="fw-bold">

                                        {{ $alert->vehicle->vehicle_number ?? '-' }}

                                   </h4>


                                   <small class="text-muted">

                                        Vehicle ID :

                                        {{ $alert->vehicle->id }}

                                   </small>
                              @else
                                   <span class="text-muted">

                                        Tidak ada vehicle

                                   </span>
                              @endif



                         </div>


                    </div>


               </div>








               {{-- INCIDENT --}}

               <div class="col-lg-4">


                    <div class="card border-0 shadow-sm rounded-4 h-100">


                         <div class="card-body p-4">


                              <h5 class="fw-bold">

                                   <i class="ri-error-warning-line text-danger"></i>

                                   Incident

                              </h5>


                              <hr>



                              @if ($alert->incident)
                                   <h6 class="fw-bold">

                                        {{ $alert->incident->title ?? 'Incident' }}

                                   </h6>
                              @else
                                   <span class="text-muted">

                                        Tidak ada incident

                                   </span>
                              @endif



                         </div>


                    </div>


               </div>



          </div>








          {{-- PUBLICATION --}}


          <div class="card border-0 shadow-sm rounded-4 mt-4">


               <div class="card-body p-4">


                    <h5 class="fw-bold mb-4">

                         <i class="ri-send-plane-line text-primary"></i>

                         Publication Information

                    </h5>




                    <div class="row">



                         <div class="col-md-4">


                              <small class="text-muted">

                                   Published At

                              </small>


                              <p class="fw-semibold">


                                   @if ($alert->published_at)
                                        {{ $alert->published_at->format('d M Y H:i') }}
                                   @else
                                        -
                                   @endif


                              </p>


                         </div>






                         <div class="col-md-4">


                              <small class="text-muted">

                                   Expired At

                              </small>


                              <p class="fw-semibold">


                                   @if ($alert->expired_at)
                                        {{ $alert->expired_at->format('d M Y H:i') }}
                                   @else
                                        Tidak ada expired
                                   @endif


                              </p>


                         </div>






                         <div class="col-md-4">


                              <small class="text-muted">

                                   Created At

                              </small>


                              <p class="fw-semibold">


                                   {{ $alert->created_at->format('d M Y H:i') }}


                              </p>


                         </div>



                    </div>


               </div>


          </div>



     </div>
@endsection
