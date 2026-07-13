@extends('layouts.app')

@section('title', 'Tambah Monitoring Penumpang')


@section('content')

     <div class="container-fluid px-4 py-4">


          <div class="page-header mb-4">

               <div>

                    <h2>
                         <i class="bi bi-person-plus-fill me-2"></i>
                         Tambah Passenger Monitoring
                    </h2>

                    <p>
                         Input data jumlah penumpang kendaraan
                    </p>

               </div>


               <a href="{{ route('admin.passenger-counts.index') }}" class="btn btn-light rounded-pill px-4">

                    <i class="bi bi-arrow-left"></i>
                    Kembali

               </a>


          </div>




          <div class="card-modern">


               <form action="{{ route('admin.passenger-counts.store') }}" method="POST">

                    @csrf



                    <div class="row g-4">


                         <div class="col-md-6">

                              <label>Trip</label>

                              <select name="trip_id" class="form-control-modern">


                                   <option>
                                        -- Pilih Trip --
                                   </option>


                                   @foreach ($trips as $trip)
                                        <option value="{{ $trip->id }}">

                                             {{ $trip->trip_code }}

                                        </option>
                                   @endforeach


                              </select>


                         </div>






                         <div class="col-md-6">

                              <label>Kendaraan</label>

                              <select name="vehicle_id" class="form-control-modern">


                                   <option>
                                        -- Pilih Kendaraan --
                                   </option>


                                   @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}">

                                             {{ $vehicle->plate_number }}
                                             -
                                             {{ $vehicle->vehicle_code }}

                                        </option>
                                   @endforeach


                              </select>

                         </div>







                         <div class="col-md-6">


                              <label>Halte</label>


                              <select name="stop_id" class="form-control-modern">


                                   <option>
                                        -- Pilih Halte --
                                   </option>


                                   @foreach ($stops as $stop)
                                        <option value="{{ $stop->id }}">

                                             {{ $stop->stop_name }}

                                        </option>
                                   @endforeach


                              </select>


                         </div>







                         <div class="col-md-6">


                              <label>
                                   Waktu Monitoring
                              </label>


                              <input type="datetime-local" name="recorded_at" value="{{ now()->format('Y-m-d\TH:i') }}"
                                   class="form-control-modern">


                         </div>







                         <div class="col-md-4">


                              <label>
                                   Penumpang Naik
                              </label>


                              <input type="number" name="boarding_count" value="0" class="form-control-modern">


                         </div>







                         <div class="col-md-4">


                              <label>
                                   Penumpang Turun
                              </label>


                              <input type="number" name="alighting_count" value="0" class="form-control-modern">


                         </div>






                         <div class="col-md-4">


                              <label>
                                   Jumlah Saat Ini
                              </label>


                              <input type="number" name="current_load" value="0" class="form-control-modern">


                         </div>


                    </div>





                    <div class="mt-5">


                         <button class="btn-save">

                              <i class="bi bi-save me-2"></i>

                              Simpan Data

                         </button>


                    </div>


               </form>


          </div>


     </div>



     <style>
          .page-header {

               background: linear-gradient(135deg, #2563eb, #4f46e5);

               padding: 35px;

               border-radius: 25px;

               color: white;

               display: flex;

               justify-content: space-between;

               align-items: center;

          }


          .page-header h2 {

               font-weight: 800;

          }


          .page-header p {

               opacity: .8;

          }



          .card-modern {

               background: white;

               padding: 35px;

               border-radius: 28px;

               box-shadow: 0 15px 40px rgba(0, 0, 0, .08);

          }



          label {

               font-weight: 600;

               margin-bottom: 8px;

          }



          .form-control-modern {

               width: 100%;

               padding: 14px 18px;

               border-radius: 15px;

               border: 1px solid #e2e8f0;

               background: #f8fafc;

          }



          .form-control-modern:focus {

               border-color: #2563eb;

               outline: none;

          }



          .btn-save {

               background: #2563eb;

               color: white;

               border: 0;

               padding: 14px 35px;

               border-radius: 50px;

               font-weight: 600;

          }
     </style>


@endsection
