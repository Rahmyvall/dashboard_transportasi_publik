@extends('layouts.app')


@section('title', 'Monitoring Penumpang')


@section('content')


     <div class="container-fluid px-4 py-4">


          {{-- HEADER --}}
          <div class="dashboard-header mb-4">

               <div>

                    <h2 class="fw-bold text-white mb-2">

                         <i class="bi bi-bus-front-fill me-2"></i>

                         Monitoring Penumpang

                    </h2>


                    <p class="text-white-50 mb-0">

                         Monitoring jumlah penumpang kendaraan berdasarkan perjalanan dan halte

                    </p>


               </div>



               <a href="{{ route('admin.passenger-counts.create') }}" class="btn btn-light rounded-pill px-4 fw-semibold">


                    <i class="bi bi-plus-circle me-2"></i>

                    Tambah Data


               </a>


          </div>






          {{-- SUCCESS ALERT --}}

          @if (session('success'))
               <div class="alert alert-success rounded-4 shadow-sm">

                    <i class="bi bi-check-circle-fill me-2"></i>

                    {{ session('success') }}

               </div>
          @endif







          {{-- STATISTIC --}}

          <div class="row g-4 mb-4">



               <div class="col-lg-4">


                    <div class="stat-card">


                         <div class="icon blue">

                              <i class="bi bi-bar-chart-fill"></i>

                         </div>



                         <div>

                              <small>
                                   Total Monitoring
                              </small>


                              <h2>
                                   {{ $passengerCounts->total() }}
                              </h2>


                              <span>
                                   Data perjalanan
                              </span>


                         </div>


                    </div>


               </div>






               <div class="col-lg-4">


                    <div class="stat-card">


                         <div class="icon green">

                              <i class="bi bi-person-plus-fill"></i>

                         </div>



                         <div>

                              <small>
                                   Penumpang Naik
                              </small>


                              <h2>

                                   {{ $passengerCounts->sum('boarding_count') }}

                              </h2>


                              <span>
                                   Boarding
                              </span>


                         </div>


                    </div>


               </div>








               <div class="col-lg-4">


                    <div class="stat-card">


                         <div class="icon red">

                              <i class="bi bi-person-dash-fill"></i>

                         </div>



                         <div>

                              <small>
                                   Penumpang Turun
                              </small>


                              <h2>

                                   {{ $passengerCounts->sum('alighting_count') }}

                              </h2>


                              <span>
                                   Alighting
                              </span>


                         </div>


                    </div>


               </div>


          </div>









          {{-- TABLE --}}


          <div class="card border-0 shadow-sm rounded-4">


               <div class="card-body p-4">



                    <div class="d-flex justify-content-between align-items-center mb-4">


                         <h5 class="fw-bold mb-0">

                              Data Passenger Count

                         </h5>



                         <span class="badge bg-primary rounded-pill">

                              Live Monitoring

                         </span>


                    </div>






                    <div class="table-responsive">


                         <table class="table modern-table align-middle">


                              <thead>


                                   <tr>


                                        <th>No</th>

                                        <th>Kendaraan</th>

                                        <th>Trip</th>

                                        <th>Halte</th>

                                        <th>Naik</th>

                                        <th>Turun</th>

                                        <th>Load</th>

                                        <th>Waktu</th>

                                        <th>Aksi</th>


                                   </tr>


                              </thead>






                              <tbody>



                                   @forelse($passengerCounts as $item)
                                        @php

                                             $capacity = $item->vehicle->capacity ?? 0;

                                             $percent = $capacity > 0 ? ($item->current_load / $capacity) * 100 : 0;

                                        @endphp




                                        <tr>



                                             <td>

                                                  {{ $loop->iteration }}

                                             </td>





                                             {{-- VEHICLE --}}

                                             <td>


                                                  <div class="vehicle-box">


                                                       <div class="vehicle-icon">

                                                            <i class="bi bi-bus-front"></i>

                                                       </div>



                                                       <div>


                                                            <strong>

                                                                 {{ $item->vehicle->plate_number ?? '-' }}

                                                            </strong>


                                                            <small>

                                                                 {{ $item->vehicle->vehicle_code ?? '-' }}

                                                            </small>


                                                       </div>


                                                  </div>


                                             </td>







                                             {{-- TRIP --}}

                                             <td>


                                                  <span class="badge bg-primary-subtle text-primary">


                                                       {{ $item->trip->trip_code ?? 'Tidak Ada' }}


                                                  </span>


                                             </td>






                                             {{-- STOP --}}

                                             <td>


                                                  {{ $item->stop->stop_name ?? '-' }}


                                             </td>







                                             <td>


                                                  <span class="badge bg-success">

                                                       +{{ $item->boarding_count }}

                                                  </span>


                                             </td>






                                             <td>


                                                  <span class="badge bg-danger">

                                                       -{{ $item->alighting_count }}

                                                  </span>


                                             </td>









                                             {{-- LOAD --}}

                                             <td width="180">


                                                  <div class="d-flex justify-content-between">


                                                       <small>

                                                            {{ $item->current_load }}

                                                            /

                                                            {{ $capacity }}


                                                       </small>


                                                       <small>

                                                            {{ round($percent) }}%

                                                       </small>


                                                  </div>




                                                  <div class="progress mt-2">


                                                       <div class="progress-bar

                                @if ($percent >= 90) bg-danger

                                @elseif($percent >= 70)

                                bg-warning

                                @else

                                bg-success @endif"
                                                            style="width: {{ $percent }}%">


                                                       </div>


                                                  </div>



                                             </td>








                                             <td>


                                                  <small>

                                                       {{ $item->recorded_at?->format('d M Y H:i') }}

                                                  </small>


                                             </td>








                                             <td>


                                                  <div class="d-flex gap-2">



                                                       <a href="{{ route('admin.passenger-counts.show', $item->id) }}"
                                                            class="btn-action view">


                                                            <i class="bi bi-eye"></i>


                                                       </a>





                                                       <a href="{{ route('admin.passenger-counts.edit', $item->id) }}"
                                                            class="btn-action edit">


                                                            <i class="bi bi-pencil"></i>


                                                       </a>






                                                       <form action="{{ route('admin.passenger-counts.destroy', $item->id) }}"
                                                            method="POST">


                                                            @csrf

                                                            @method('DELETE')



                                                            <button onclick="return confirm('Hapus data?')"
                                                                 class="btn-action delete">


                                                                 <i class="bi bi-trash"></i>


                                                            </button>


                                                       </form>



                                                  </div>


                                             </td>



                                        </tr>




                                   @empty


                                        <tr>


                                             <td colspan="9" class="text-center py-5">


                                                  <i class="bi bi-database-x fs-1 text-muted"></i>


                                                  <p class="mt-3">

                                                       Data passenger belum tersedia

                                                  </p>


                                             </td>


                                        </tr>
                                   @endforelse




                              </tbody>


                         </table>


                    </div>






                    {{ $passengerCounts->links() }}



               </div>


          </div>



     </div>









     <style>
          .dashboard-header {

               background: linear-gradient(135deg, #2563eb, #4f46e5);

               padding: 35px;

               border-radius: 25px;

               display: flex;

               justify-content: space-between;

               align-items: center;

          }





          .stat-card {

               background: white;

               padding: 25px;

               border-radius: 22px;

               display: flex;

               gap: 20px;

               align-items: center;

               box-shadow: 0 10px 30px rgba(0, 0, 0, .08);

          }



          .stat-card small {

               color: #64748b;

          }


          .stat-card h2 {

               font-weight: 800;

               margin: 5px 0;

          }



          .stat-card span {

               font-size: 13px;

               color: #94a3b8;

          }





          .icon {

               width: 60px;

               height: 60px;

               border-radius: 18px;

               display: flex;

               align-items: center;

               justify-content: center;

               color: white;

               font-size: 25px;

          }



          .blue {

               background: #2563eb;

          }



          .green {

               background: #16a34a;

          }



          .red {

               background: #dc2626;

          }





          .modern-table {

               border-collapse: separate;

               border-spacing: 0 12px;

          }



          .modern-table tbody tr {

               background: white;

               box-shadow: 0 5px 20px rgba(0, 0, 0, .05);

          }



          .modern-table td {

               padding: 18px;

               border: none;

          }



          .vehicle-box {

               display: flex;

               gap: 12px;

               align-items: center;

          }



          .vehicle-icon {

               width: 45px;

               height: 45px;

               background: #eff6ff;

               color: #2563eb;

               border-radius: 15px;

               display: flex;

               align-items: center;

               justify-content: center;

          }



          .vehicle-box small {

               display: block;

               color: #94a3b8;

          }




          .btn-action {

               width: 38px;

               height: 38px;

               border-radius: 12px;

               display: flex;

               align-items: center;

               justify-content: center;

               text-decoration: none;

               border: 0;

          }



          .view {

               background: #dbeafe;

               color: #2563eb;

          }



          .edit {

               background: #fef3c7;

               color: #d97706;

          }



          .delete {

               background: #fee2e2;

               color: #dc2626;

          }



          .progress {

               height: 8px;

               border-radius: 20px;

          }
     </style>



@endsection
