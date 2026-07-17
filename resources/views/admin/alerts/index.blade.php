@extends('layouts.app')

@section('content')
     <div class="container-fluid py-4">


          {{-- HEADER --}}

          <div class="card border-0 shadow-sm mb-4"
               style="
     background:linear-gradient(135deg,#6a85c5,#717a8d);
     border-radius:25px;
     color:white;
     ">


               <div class="card-body p-4">


                    <div class="d-flex justify-content-between align-items-center flex-wrap">


                         <div>


                              <h2 class="fw-bold mb-2">


                                   <i class="ri-notification-3-line"></i>

                                   Alert Monitoring Center


                                   <span class="badge bg-success ms-2">

                                        LIVE

                                   </span>


                              </h2>


                              <p class="mb-0 opacity-75">

                                   Monitoring alert transportasi secara realtime

                              </p>


                         </div>



                         <a href="{{ route('admin.alerts.create') }}" class="btn btn-light rounded-pill px-4">


                              <i class="ri-add-circle-line"></i>

                              Tambah Alert


                         </a>


                    </div>


               </div>


          </div>





          {{-- STATISTIC --}}

          <div class="row g-3 mb-4">


               @php

                    $totalAlert = $alerts->total();

                    $statistic = [
                        [
                            'title' => 'Total Alert',
                            'value' => $totalAlert,
                            'icon' => 'ri-notification-line',
                            'color' => 'primary',
                        ],

                        [
                            'title' => 'Critical',
                            'value' => $alerts->where('priority', 'critical')->count(),
                            'icon' => 'ri-alarm-warning-line',
                            'color' => 'danger',
                        ],

                        [
                            'title' => 'Emergency',
                            'value' => $alerts->where('alert_type', 'emergency')->count(),
                            'icon' => 'ri-error-warning-line',
                            'color' => 'warning',
                        ],

                        [
                            'title' => 'Published',
                            'value' => $alerts->where('is_published', 1)->count(),
                            'icon' => 'ri-checkbox-circle-line',
                            'color' => 'success',
                        ],
                    ];

               @endphp




               @foreach ($statistic as $item)
                    <div class="col-xl-3 col-md-6">


                         <div class="card border-0 shadow-sm rounded-4">


                              <div class="card-body">


                                   <div class="d-flex justify-content-between align-items-center">


                                        <div>


                                             <p class="text-muted mb-1">

                                                  {{ $item['title'] }}

                                             </p>


                                             <h2 class="fw-bold mb-0">

                                                  {{ $item['value'] }}

                                             </h2>


                                        </div>



                                        <div class="
bg-{{ $item['color'] }}
text-white
rounded-circle
d-flex
align-items-center
justify-content-center
"
                                             style="
width:60px;
height:60px;
font-size:25px;
">


                                             <i class="{{ $item['icon'] }}"></i>


                                        </div>



                                   </div>


                              </div>


                         </div>


                    </div>
               @endforeach



          </div>







          {{-- TABLE --}}


          <div class="card border-0 shadow-sm rounded-4">


               <div class="card-header bg-white border-0 p-4">


                    <div class="d-flex justify-content-between align-items-center">


                         <div>


                              <h5 class="fw-bold mb-1">


                                   <i class="ri-list-check text-primary"></i>

                                   Daftar Alert


                              </h5>


                              <small class="text-muted">

                                   Data notifikasi transportasi

                              </small>


                         </div>



                         <a href="{{ route('admin.alerts.create') }}" class="btn btn-primary rounded-pill">


                              <i class="ri-add-line"></i>

                              Create Alert


                         </a>


                    </div>


               </div>






               <div class="card-body">


                    <div class="table-responsive">


                         <table class="table table-hover align-middle">


                              <thead class="table-light">


                                   <tr>


                                        <th>No</th>

                                        <th>Alert</th>

                                        <th>Incident</th>

                                        <th>Route</th>

                                        <th>Vehicle</th>

                                        <th>Type</th>

                                        <th>Priority</th>

                                        <th>Status</th>

                                        <th width="150">

                                             Action

                                        </th>


                                   </tr>


                              </thead>





                              <tbody>


                                   @forelse($alerts as $alert)
                                        <tr>


                                             <td>

                                                  {{ $loop->iteration }}

                                             </td>




                                             <td>


                                                  <div class="d-flex align-items-center">


                                                       <div class="rounded-circle bg-light p-3 me-3">


                                                            <i class="{{ $alert->alert_icon }} text-primary"></i>


                                                       </div>



                                                       <div>


                                                            <h6 class="fw-bold mb-1">

                                                                 {{ $alert->title }}

                                                            </h6>


                                                            <small class="text-muted">

                                                                 {{ Str::limit($alert->message, 50) }}

                                                            </small>


                                                       </div>


                                                  </div>


                                             </td>





                                             <td>


                                                  @if ($alert->incident)
                                                       <span class="badge bg-danger">

                                                            {{ $alert->incident->title ?? 'Incident' }}

                                                       </span>
                                                  @else
                                                       -
                                                  @endif


                                             </td>






                                             <td>


                                                  @if ($alert->route)
                                                       <i class="ri-route-line text-primary"></i>


                                                       {{ $alert->route->name }}
                                                  @else
                                                       -
                                                  @endif


                                             </td>






                                             <td>


                                                  @if ($alert->vehicle)
                                                       <i class="ri-bus-line text-success"></i>


                                                       {{ $alert->vehicle->vehicle_number }}
                                                  @else
                                                       -
                                                  @endif


                                             </td>






                                             <td>


                                                  <span class="badge bg-info">


                                                       {{ strtoupper($alert->alert_type) }}


                                                  </span>


                                             </td>






                                             <td>


                                                  <span class="badge bg-{{ $alert->priority_color }}">


                                                       {{ strtoupper($alert->priority) }}


                                                  </span>


                                             </td>






                                             <td>


                                                  @if ($alert->status == 'Published')
                                                       <span class="badge bg-success">

                                                            Published

                                                       </span>
                                                  @elseif($alert->status == 'Expired')
                                                       <span class="badge bg-danger">

                                                            Expired

                                                       </span>
                                                  @else
                                                       <span class="badge bg-secondary">

                                                            Draft

                                                       </span>
                                                  @endif


                                             </td>






                                             <td>


                                                  <div class="d-flex gap-2">


                                                       <a href="{{ route('admin.alerts.show', $alert->id) }}"
                                                            class="btn btn-sm btn-info text-white rounded-circle">


                                                            <i class="ri-eye-line"></i>


                                                       </a>





                                                       <a href="{{ route('admin.alerts.edit', $alert->id) }}"
                                                            class="btn btn-sm btn-warning text-white rounded-circle">


                                                            <i class="ri-edit-line"></i>


                                                       </a>





                                                       <form action="{{ route('admin.alerts.destroy', $alert->id) }}"
                                                            method="POST">


                                                            @csrf

                                                            @method('DELETE')


                                                            <button onclick="return confirm('Hapus alert?')"
                                                                 class="btn btn-sm btn-danger rounded-circle">


                                                                 <i class="ri-delete-bin-line"></i>


                                                            </button>


                                                       </form>


                                                  </div>


                                             </td>


                                        </tr>



                                   @empty


                                        <tr>


                                             <td colspan="9" class="text-center py-5">


                                                  <i class="ri-notification-off-line fs-1 text-muted"></i>


                                                  <h6 class="text-muted mt-3">

                                                       Belum ada alert


                                                  </h6>


                                             </td>


                                        </tr>
                                   @endforelse



                              </tbody>


                         </table>


                    </div>





                    <div class="mt-3">

                         {{ $alerts->links() }}

                    </div>


               </div>


          </div>


     </div>
@endsection
