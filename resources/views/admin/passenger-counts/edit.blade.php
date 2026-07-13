@extends('layouts.app')

@section('title', 'Edit Monitoring Penumpang')


@section('content')


     <div class="container-fluid px-4 py-4">


          {{-- HEADER --}}

          <div class="modern-header mb-4">


               <div>

                    <h2>

                         <i class="bi bi-pencil-square me-2"></i>

                         Edit Passenger Monitoring

                    </h2>


                    <p>

                         Perbarui data jumlah penumpang kendaraan

                    </p>


               </div>



               <a href="{{ route('admin.passenger-counts.index') }}" class="btn btn-light rounded-pill px-4">


                    <i class="bi bi-arrow-left me-2"></i>

                    Kembali


               </a>


          </div>








          <div class="form-card">



               <form action="{{ route('admin.passenger-counts.update', $passengerCount->id) }}" method="POST">


                    @csrf

                    @method('PUT')




                    <div class="row g-4">



                         {{-- TRIP --}}

                         <div class="col-lg-6">


                              <label>

                                   Trip Perjalanan

                              </label>


                              <select name="trip_id" class="modern-input">


                                   @foreach ($trips as $trip)
                                        <option value="{{ $trip->id }}"
                                             @if ($passengerCount->trip_id == $trip->id) selected @endif>


                                             {{ $trip->trip_code }}


                                        </option>
                                   @endforeach


                              </select>


                         </div>






                         {{-- VEHICLE --}}

                         <div class="col-lg-6">


                              <label>

                                   Kendaraan

                              </label>


                              <select name="vehicle_id" class="modern-input">


                                   @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}"
                                             @if ($passengerCount->vehicle_id == $vehicle->id) selected @endif>


                                             {{ $vehicle->plate_number }}

                                             -
                                             {{ $vehicle->vehicle_code }}


                                        </option>
                                   @endforeach


                              </select>


                         </div>







                         {{-- STOP --}}

                         <div class="col-lg-6">


                              <label>

                                   Halte

                              </label>


                              <select name="stop_id" class="modern-input">


                                   <option value="">

                                        -- Tidak Ada Halte --

                                   </option>


                                   @foreach ($stops as $stop)
                                        <option value="{{ $stop->id }}"
                                             @if ($passengerCount->stop_id == $stop->id) selected @endif>


                                             {{ $stop->stop_name }}


                                        </option>
                                   @endforeach


                              </select>


                         </div>








                         {{-- TIME --}}

                         <div class="col-lg-6">


                              <label>

                                   Waktu Monitoring

                              </label>


                              <input type="datetime-local" name="recorded_at" class="modern-input"
                                   value="{{ $passengerCount->recorded_at->format('Y-m-d\TH:i') }}">


                         </div>








                         <div class="col-md-4">


                              <label>

                                   Penumpang Naik

                              </label>


                              <div class="input-icon">

                                   <i class="bi bi-person-plus"></i>


                                   <input type="number" name="boarding_count" class="modern-input"
                                        value="{{ $passengerCount->boarding_count }}">


                              </div>


                         </div>







                         <div class="col-md-4">


                              <label>

                                   Penumpang Turun

                              </label>


                              <input type="number" name="alighting_count" class="modern-input"
                                   value="{{ $passengerCount->alighting_count }}">


                         </div>








                         <div class="col-md-4">


                              <label>

                                   Jumlah Penumpang

                              </label>


                              <input type="number" name="current_load" class="modern-input"
                                   value="{{ $passengerCount->current_load }}">


                         </div>




                    </div>







                    <div class="mt-5 d-flex gap-3">


                         <button class="btn-save">


                              <i class="bi bi-check-circle me-2"></i>

                              Update Data


                         </button>




                         <a href="{{ route('admin.passenger-counts.index') }}" class="btn-cancel">


                              Batal


                         </a>


                    </div>





               </form>


          </div>


     </div>









     <style>
          .modern-header {

               background: linear-gradient(135deg,
                         #2563eb,
                         #7c3aed);

               padding: 35px;

               border-radius: 30px;

               color: white;

               display: flex;

               justify-content: space-between;

               align-items: center;

          }



          .modern-header h2 {

               font-weight: 800;

          }



          .modern-header p {

               opacity: .8;

          }




          .form-card {

               background: white;

               padding: 40px;

               border-radius: 30px;

               box-shadow:
                    0 15px 40px rgba(0, 0, 0, .08);

          }



          label {

               font-weight: 700;

               margin-bottom: 8px;

               display: block;

               color: #334155;

          }



          .modern-input {

               width: 100%;

               padding: 15px 18px;

               border-radius: 16px;

               border: 1px solid #e2e8f0;

               background: #f8fafc;

          }



          .modern-input:focus {

               border-color: #2563eb;

               outline: none;

               background: white;

          }



          .btn-save {

               background: #2563eb;

               color: white;

               border: none;

               padding: 15px 35px;

               border-radius: 50px;

               font-weight: 700;

          }



          .btn-cancel {

               padding: 15px 35px;

               border-radius: 50px;

               background: #e2e8f0;

               color: #334155;

               text-decoration: none;

               font-weight: 600;

          }
     </style>



@endsection
