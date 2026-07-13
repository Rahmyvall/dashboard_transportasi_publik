@extends('layouts.app')


@section('title', 'Detail Monitoring')


@section('content')


     <div class="container-fluid px-4 py-4">


          <div class="detail-header mb-4">


               <div>

                    <h2>

                         <i class="bi bi-bar-chart-fill me-2"></i>

                         Detail Passenger Monitoring

                    </h2>


                    <p>

                         Informasi perjalanan kendaraan dan jumlah penumpang

                    </p>

               </div>



               <a href="{{ route('admin.passenger-counts.index') }}" class="btn btn-light rounded-pill px-4">

                    Kembali

               </a>



          </div>









          <div class="row g-4">





               <div class="col-lg-4">


                    <div class="profile-card">


                         <div class="bus-icon">

                              <i class="bi bi-bus-front-fill"></i>

                         </div>


                         <h3>

                              {{ $passengerCount->vehicle->plate_number ?? '-' }}

                         </h3>


                         <p>

                              {{ $passengerCount->vehicle->vehicle_code ?? '-' }}

                         </p>


                         <span class="badge bg-success">

                              {{ $passengerCount->vehicle->status_label ?? 'Aktif' }}

                         </span>


                    </div>


               </div>







               <div class="col-lg-8">


                    <div class="info-card">


                         <h5>

                              Informasi Perjalanan

                         </h5>




                         <div class="row mt-3">



                              <div class="col-md-6">

                                   <label>

                                        Trip

                                   </label>

                                   <h5>

                                        {{ $passengerCount->trip->trip_code ?? '-' }}

                                   </h5>


                              </div>





                              <div class="col-md-6">

                                   <label>

                                        Halte

                                   </label>

                                   <h5>

                                        {{ $passengerCount->stop->stop_name ?? '-' }}

                                   </h5>


                              </div>






                              <div class="col-md-6">


                                   <label>

                                        Waktu

                                   </label>


                                   <h5>

                                        {{ $passengerCount->recorded_at->format('d M Y H:i') }}

                                   </h5>


                              </div>





                              <div class="col-md-6">


                                   <label>

                                        Kapasitas

                                   </label>


                                   <h5>

                                        {{ $passengerCount->vehicle->capacity ?? 0 }}

                                        Orang

                                   </h5>


                              </div>


                         </div>



                    </div>


               </div>



          </div>









          {{-- STAT --}}


          <div class="row g-4 mt-2">



               <div class="col-md-4">


                    <div class="counter green">


                         <i class="bi bi-person-plus-fill"></i>


                         <h6>Penumpang Naik</h6>


                         <h1>

                              +{{ $passengerCount->boarding_count }}

                         </h1>


                    </div>


               </div>






               <div class="col-md-4">


                    <div class="counter red">


                         <i class="bi bi-person-dash-fill"></i>


                         <h6>Penumpang Turun</h6>


                         <h1>

                              -{{ $passengerCount->alighting_count }}

                         </h1>


                    </div>


               </div>







               <div class="col-md-4">


                    <div class="counter blue">


                         <i class="bi bi-people-fill"></i>


                         <h6>Total Saat Ini</h6>


                         <h1>

                              {{ $passengerCount->current_load }}

                         </h1>


                    </div>


               </div>



          </div>









          @php

               $capacity = $passengerCount->vehicle->capacity ?? 0;

               $percent = $capacity > 0 ? ($passengerCount->current_load / $capacity) * 100 : 0;
          @endphp






          <div class="capacity-card mt-4">


               <div class="d-flex justify-content-between">


                    <h5>

                         Kapasitas Kendaraan

                    </h5>


                    <strong>

                         {{ round($percent) }}%

                    </strong>


               </div>




               <div class="progress mt-3">


                    <div class="progress-bar bg-primary" style="width:{{ $percent }}%">

                    </div>


               </div>


          </div>




     </div>








     <style>
          .detail-header {

               background: linear-gradient(135deg,
                         #b1cf98,
                         #8195c2);

               padding: 35px;

               border-radius: 30px;

               color: white;

               display: flex;

               justify-content: space-between;

               align-items: center;

          }



          .profile-card,
          .info-card,
          .capacity-card {

               background: white;

               border-radius: 30px;

               padding: 30px;

               box-shadow:
                    0 10px 30px rgba(202, 218, 202, 0.849);

          }



          .profile-card {

               text-align: center;

          }



          .bus-icon {

               width: 80px;

               height: 80px;

               margin: auto;

               border-radius: 25px;

               background: #dbeafe;

               display: flex;

               align-items: center;

               justify-content: center;

               font-size: 35px;

               color: #99aeda;

          }



          .counter {

               padding: 30px;

               border-radius: 25px;

               color: white;

               text-align: center;

          }



          .green {

               background: #16a34a;

          }


          .red {

               background: #dc2626;

          }


          .blue {

               background: #879dca;

          }


          .counter i {

               font-size: 30px;

          }


          .progress {

               height: 12px;

               border-radius: 20px;

          }
     </style>


@endsection
