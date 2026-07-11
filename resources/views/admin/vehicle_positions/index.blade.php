@extends('layouts.app')

@section('content')
     <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


     <style>
          body {
               background: #f1f5f9;
          }


          .tracking-page {
               padding: 25px;
          }


          /* HEADER */

          .dashboard-header {

               background:
                    linear-gradient(135deg, #637bb4, #6486cac2);

               border-radius: 28px;

               padding: 35px;

               color: white;

               box-shadow:
                    0 15px 40px rgba(37, 99, 235, .25);

          }


          .dashboard-header h2 {

               font-weight: 800;

          }



          /* BUTTON */

          .btn-modern {

               background: white;

               color: #4d67a0;

               padding: 12px 20px;

               border-radius: 14px;

               font-weight: 700;

               text-decoration: none;

          }





          /* STAT CARD */


          .stat-box {

               background: white;

               border-radius: 22px;

               padding: 25px;

               box-shadow:
                    0 8px 25px rgba(0, 0, 0, .05);

          }


          .stat-icon {

               width: 55px;

               height: 55px;

               border-radius: 18px;

               display: flex;

               justify-content: center;

               align-items: center;

               font-size: 25px;

          }



          .bg-blue {

               background: #dbeafe;

               color: #2563eb;

          }


          .bg-green {

               background: #dcfce7;

               color: #16a34a;

          }


          .bg-red {

               background: #fee2e2;

               color: #dc2626;

          }





          /* TABLE */


          .table-container {

               background: white;

               border-radius: 25px;

               overflow: hidden;

               box-shadow:
                    0 10px 30px rgba(0, 0, 0, .06);

          }



          .table-modern thead th {

               background: #f8fafc;

               color: #64748b;

               font-size: 12px;

               text-transform: uppercase;

               padding: 18px;

          }



          .table-modern tbody td {

               padding: 18px;

               vertical-align: middle;

          }





          .vehicle-title {

               font-weight: 800;

               color: #0f172a;

          }





          .coordinate {

               font-size: 13px;

               color: #64748b;

          }




          .speed-active {

               background: #dcfce7;

               color: #166534;

               padding: 7px 14px;

               border-radius: 20px;

               font-weight: 700;

          }



          .speed-stop {

               background: #fee2e2;

               color: #991b1b;

               padding: 7px 14px;

               border-radius: 20px;

               font-weight: 700;

          }





          .action {

               width: 38px;

               height: 38px;

               border-radius: 12px;

               display: inline-flex;

               justify-content: center;

               align-items: center;

               border: 0;

          }



          .view {

               background: #dbeafe;

               color: #2563eb;

          }


          .edit {

               background: #fef3c7;

               color: #92400e;

          }


          .map {

               background: #dcfce7;

               color: #166534;

          }


          .delete {

               background: #fee2e2;

               color: #dc2626;

          }
     </style>





     <div class="tracking-page">





          <!-- HEADER -->


          <div class="dashboard-header mb-4">


               <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">


                    <div>


                         <h2>

                              <i class="bi bi-geo-alt-fill"></i>

                              Vehicle Tracking

                         </h2>


                         <p class="mb-0 opacity-75">

                              Monitoring posisi kendaraan berdasarkan GPS

                         </p>


                    </div>



                    <a href="{{ route('admin.vehicle-positions.create') }}" class="btn-modern">


                         <i class="bi bi-plus-circle"></i>

                         Tambah Position


                    </a>



               </div>


          </div>







          <!-- STAT -->


          <div class="row g-4 mb-4">


               <div class="col-md-4">


                    <div class="stat-box">


                         <div class="d-flex gap-3 align-items-center">


                              <div class="stat-icon bg-blue">

                                   <i class="bi bi-geo"></i>

                              </div>


                              <div>


                                   small > Total Position</small>


                                   <h3 class="fw-bold">

                                        {{ $positions->total() }}

                                   </h3>


                              </div>


                         </div>


                    </div>


               </div>






               <div class="col-md-4">


                    <div class="stat-box">


                         <div class="d-flex gap-3 align-items-center">


                              <div class="stat-icon bg-green">

                                   <i class="bi bi-truck"></i>

                              </div>


                              <div>


                                   <small>Kendaraan Bergerak</small>


                                   <h3 class="fw-bold">

                                        {{ $positions->where('speed_kmh', '>', 0)->count() }}

                                   </h3>


                              </div>


                         </div>


                    </div>


               </div>







               <div class="col-md-4">


                    <div class="stat-box">


                         <div class="d-flex gap-3 align-items-center">


                              <div class="stat-icon bg-red">

                                   <i class="bi bi-stop-circle"></i>

                              </div>


                              <div>


                                   <small>Kendaraan Berhenti</small>


                                   <h3 class="fw-bold">

                                        {{ $positions->where('speed_kmh', 0)->count() }}

                                   </h3>


                              </div>


                         </div>


                    </div>


               </div>



          </div>








          <!-- TABLE -->


          <div class="table-container">


               <div class="p-4 border-bottom">


                    <h5 class="fw-bold mb-1">

                         Vehicle Position History

                    </h5>


                    <p class="text-muted mb-0">

                         Data koordinat kendaraan terakhir

                    </p>


               </div>





               <div class="table-responsive">


                    <table class="table table-modern mb-0">


                         <thead>

                              <tr>

                                   <th>No</th>

                                   <th>Vehicle</th>

                                   <th>Trip</th>

                                   <th>Location</th>

                                   <th>Speed</th>

                                   <th>Heading</th>

                                   <th>Recorded</th>

                                   <th>Action</th>

                              </tr>


                         </thead>




                         <tbody>


                              @forelse($positions as $position)
                                   <tr>


                                        <td>

                                             {{ $loop->iteration }}

                                        </td>




                                        <td>


                                             <div class="vehicle-title">

                                                  {{ $position->vehicle?->vehicle_code ?? '-' }}

                                             </div>


                                             <small>

                                                  {{ $position->vehicle?->plate_number ?? '-' }}

                                             </small>


                                        </td>






                                        <td>

                                             {{ $position->trip_id }}

                                        </td>




                                        <td>


                                             <div class="coordinate">

                                                  Lat:
                                                  {{ $position->latitude }}

                                             </div>


                                             <div class="coordinate">

                                                  Lng:
                                                  {{ $position->longitude }}

                                             </div>


                                        </td>






                                        <td>


                                             @if ($position->speed_kmh > 0)
                                                  <span class="speed-active">

                                                       <i class="bi bi-speedometer"></i>

                                                       {{ number_format($position->speed_kmh, 2) }}

                                                       km/h

                                                  </span>
                                             @else
                                                  <span class="speed-stop">

                                                       STOP

                                                  </span>
                                             @endif


                                        </td>






                                        <td>

                                             {{ $position->heading_degree ?? 0 }}°

                                        </td>






                                        <td>

                                             {{ $position->recorded_at?->format('d M Y H:i') }}

                                        </td>






                                        <td>


                                             <a href="{{ route('admin.vehicle-positions.show', $position->id) }}"
                                                  class="action view">

                                                  <i class="bi bi-eye"></i>

                                             </a>



                                             <a href="{{ route('admin.vehicle-positions.edit', $position->id) }}"
                                                  class="action edit">

                                                  <i class="bi bi-pencil"></i>

                                             </a>



                                             <a href="{{ route('admin.vehicle-tracking', $position->vehicle_id) }}"
                                                  class="action map">

                                                  <i class="bi bi-map"></i>

                                             </a>



                                             <form method="POST"
                                                  action="{{ route('admin.vehicle-positions.destroy', $position->id) }}"
                                                  class="d-inline">


                                                  @csrf

                                                  @method('DELETE')


                                                  <button onclick="return confirm('Hapus data?')" class="action delete">


                                                       <i class="bi bi-trash"></i>


                                                  </button>


                                             </form>



                                        </td>



                                   </tr>


                              @empty


                                   <tr>

                                        <td colspan="8" class="text-center py-5">


                                             <h5>

                                                  Belum ada data tracking

                                             </h5>


                                        </td>


                                   </tr>
                              @endforelse



                         </tbody>


                    </table>


               </div>



               <div class="p-3">

                    {{ $positions->links() }}

               </div>



          </div>




     </div>
@endsection
