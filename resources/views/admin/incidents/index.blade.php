@extends('layouts.app')


@section('content')
     <div class="container-fluid py-4">


          <style>
               /* ==========================
      GLOBAL
     ========================== */

               body {

                    background:
                         linear-gradient(135deg,
                              #f8fafc,
                              #eef2ff);

                    font-family:
                         'Inter',
                         sans-serif;

               }





               /* ==========================
      HERO INCIDENT
     ========================== */


               .incident-hero {


                    background:

                         linear-gradient(135deg,
                              #020617,
                              #7f1d1d,
                              #dc2626);


                    border-radius: 35px;


                    padding: 45px;


                    color: white;


                    position: relative;


                    overflow: hidden;


                    box-shadow:

                         0 30px 70px rgba(127, 29, 29, .35);


               }




               .incident-hero::before {


                    content: "";


                    position: absolute;


                    width: 300px;


                    height: 300px;


                    background: white;


                    opacity: .08;


                    border-radius: 50%;


                    right: -100px;


                    top: -100px;


               }




               .hero-title {


                    font-size: 38px;


                    font-weight: 900;


                    letter-spacing: -1px;


               }




               .hero-desc {


                    opacity: .85;


                    font-size: 16px;


                    max-width: 600px;


               }





               .btn-add {


                    background: white;


                    color: #991b1b;


                    font-weight: 900;


                    border-radius: 18px;


                    padding: 15px 30px;


                    box-shadow:

                         0 15px 35px rgba(0, 0, 0, .25);


                    transition: .3s;


               }



               .btn-add:hover {


                    transform: translateY(-5px);


                    background: #fff7ed;


               }





               /* ==========================
      STAT CARD
     ========================== */



               .dashboard-card {


                    border: 0;


                    border-radius: 30px;


                    background: white;


                    overflow: hidden;


                    box-shadow:

                         0 20px 50px rgba(15, 23, 42, .08);


                    transition: .35s;


                    position: relative;


               }





               .dashboard-card::before {


                    content: "";


                    height: 5px;


                    width: 100%;


                    position: absolute;


                    top: 0;


                    left: 0;


                    background:

                         linear-gradient(90deg,
                              #dc2626,
                              #f97316);


               }




               .dashboard-card:hover {


                    transform:

                         translateY(-10px);


                    box-shadow:

                         0 30px 60px rgba(15, 23, 42, .15);


               }







               .icon-box {


                    width: 75px;


                    height: 75px;


                    border-radius: 25px;


                    display: flex;


                    align-items: center;


                    justify-content: center;


                    font-size: 35px;


               }





               .icon-danger {


                    background:

                         linear-gradient(135deg,
                              #fee2e2,
                              #fecaca);


                    color: #dc2626;


               }



               .icon-warning {


                    background:

                         linear-gradient(135deg,
                              #fef3c7,
                              #fde68a);


                    color: #d97706;


               }




               .icon-info {


                    background:

                         linear-gradient(135deg,
                              #dbeafe,
                              #bfdbfe);


                    color: #2563eb;


               }




               .icon-success {


                    background:

                         linear-gradient(135deg,
                              #dcfce7,
                              #bbf7d0);


                    color: #16a34a;


               }






               /* ==========================
      FILTER
     ========================== */


               .filter-box {


                    border: 0;


                    border-radius: 30px;


                    background: white;


                    box-shadow:

                         0 20px 45px rgba(15, 23, 42, .07);


               }





               .form-select,
               .form-control {


                    border-radius: 18px;


                    padding: 14px 18px;


                    border:

                         1px solid #e2e8f0;


               }





               .form-select:focus,
               .form-control:focus {


                    border-color: #dc2626;


                    box-shadow:

                         0 0 0 .25rem rgba(220, 38, 38, .15);


               }






               /* ==========================
      TABLE
     ========================== */


               .table-box {


                    border: 0;


                    border-radius: 30px;


                    overflow: hidden;


                    background: white;


                    box-shadow:

                         0 25px 60px rgba(15, 23, 42, .10);


               }





               .table thead th {


                    background:

                         linear-gradient(135deg,

                              #020617,

                              #7f1d1d);


                    color: white;


                    padding: 20px;


                    font-size: 12px;


                    text-transform: uppercase;


                    letter-spacing: 1px;


                    border: 0;


               }





               .table tbody td {


                    padding: 18px;


                    vertical-align: middle;


               }





               .table tbody tr {


                    transition: .25s;


               }




               .table tbody tr:hover {


                    background: #fff7ed;


                    transform: scale(1.01);


               }





               .title-incident {


                    font-weight: 900;


                    color: #0f172a;


                    font-size: 15px;


               }







               /* ==========================
      BADGE
     ========================== */



               .severity,
               .status {


                    padding: 9px 16px;


                    border-radius: 50px;


                    font-size: 11px;


                    font-weight: 900;


                    letter-spacing: .5px;


               }





               /* ==========================
      ACTION BUTTON
     ========================== */


               .action-btn {


                    width: 42px;


                    height: 42px;


                    border-radius: 15px;


                    display: inline-flex;


                    align-items: center;


                    justify-content: center;


                    margin: 3px;


                    transition: .3s;


                    border: 0;


               }





               .action-btn:hover {


                    transform:

                         translateY(-5px) scale(1.05);


               }




               .btn-view {


                    background: #dbeafe;


                    color: #2563eb;


               }




               .btn-edit {


                    background: #fef3c7;


                    color: #92400e;


               }




               .btn-delete {


                    background: #fee2e2;


                    color: #991b1b;


               }






               /* ==========================
      MAP BUTTON
     ========================== */



               .map-link {


                    background:

                         linear-gradient(135deg,

                              #dcfce7,

                              #bbf7d0);


                    color: #166534;


                    border-radius: 50px;


                    padding: 9px 18px;


                    font-size: 12px;


                    font-weight: 900;


                    text-decoration: none;


                    display: inline-flex;


                    align-items: center;


                    gap: 5px;


                    transition: .3s;


               }





               .map-link:hover {


                    transform:

                         translateY(-3px);


                    color: #14532d;


               }





               /* ==========================
      PAGINATION
     ========================== */


               .pagination {


                    margin-top: 25px;


               }



               .page-link {


                    border-radius: 12px !important;


                    margin: 0 3px;


                    color: #991b1b;


               }



               .page-item.active .page-link {


                    background: #dc2626;


                    border-color: #dc2626;


               }
          </style>









          {{-- HERO --}}


          <div class="incident-hero mb-4">


               <div class="row align-items-center">


                    <div class="col-md-8">


                         <div class="hero-title">

                              <i class="ri-alert-line"></i>

                              Incident Control Center

                         </div>



                         <p class="hero-desc mt-2">

                              Monitoring kecelakaan,
                              kerusakan kendaraan,
                              gangguan lalu lintas,
                              dan kejadian operasional armada.

                         </p>



                         <div class="mt-3">


                              <span class="badge bg-light text-danger px-3 py-2">

                                   <i class="ri-live-line"></i>

                                   LIVE MONITORING

                              </span>


                         </div>


                    </div>





                    <div class="col-md-4 text-md-end mt-3 mt-md-0">


                         <a href="{{ route('admin.incidents.create') }}" class="btn-add">


                              <i class="ri-add-circle-line"></i>

                              Tambah Incident


                         </a>


                    </div>



               </div>


          </div>











          {{-- STATISTICS --}}


          <div class="row g-4 mb-4">



               <div class="col-xl-3 col-md-6">


                    <div class="card dashboard-card">


                         <div class="card-body d-flex align-items-center gap-3">


                              <div class="icon-box icon-danger">


                                   <i class="ri-error-warning-line"></i>


                              </div>



                              <div>


                                   <small class="text-muted">

                                        Total Incident

                                   </small>


                                   <h2 class="fw-bold mb-0">

                                        {{ $totalIncident ?? $incidents->total() }}

                                   </h2>


                              </div>


                         </div>


                    </div>


               </div>









               <div class="col-xl-3 col-md-6">


                    <div class="card dashboard-card">


                         <div class="card-body d-flex align-items-center gap-3">


                              <div class="icon-box icon-warning">


                                   <i class="ri-time-line"></i>


                              </div>



                              <div>


                                   <small class="text-muted">

                                        Open

                                   </small>


                                   <h2 class="fw-bold mb-0">

                                        {{ $totalOpen ?? 0 }}

                                   </h2>


                              </div>


                         </div>


                    </div>


               </div>










               <div class="col-xl-3 col-md-6">


                    <div class="card dashboard-card">


                         <div class="card-body d-flex align-items-center gap-3">


                              <div class="icon-box icon-info">


                                   <i class="ri-loader-line"></i>


                              </div>



                              <div>


                                   <small class="text-muted">

                                        Progress

                                   </small>


                                   <h2 class="fw-bold mb-0">

                                        {{ $totalProgress ?? 0 }}

                                   </h2>


                              </div>


                         </div>


                    </div>


               </div>










               <div class="col-xl-3 col-md-6">


                    <div class="card dashboard-card">


                         <div class="card-body d-flex align-items-center gap-3">


                              <div class="icon-box icon-success">


                                   <i class="ri-shield-check-line"></i>


                              </div>



                              <div>


                                   <small class="text-muted">

                                        Resolved

                                   </small>


                                   <h2 class="fw-bold mb-0">

                                        {{ $totalResolved ?? 0 }}

                                   </h2>


                              </div>


                         </div>


                    </div>


               </div>


          </div>









          {{-- FILTER --}}


          <div class="card filter-box mb-4">


               <div class="card-body">


                    <form method="GET">


                         <div class="row g-3">



                              <div class="col-md-4">


                                   <select name="status" class="form-select">


                                        <option value="">

                                             Semua Status

                                        </option>


                                        <option value="open">

                                             Open

                                        </option>


                                        <option value="in_progress">

                                             In Progress

                                        </option>


                                        <option value="resolved">

                                             Resolved

                                        </option>


                                        <option value="closed">

                                             Closed

                                        </option>


                                   </select>


                              </div>





                              <div class="col-md-4">


                                   <select name="severity" class="form-select">


                                        <option>

                                             Semua Severity

                                        </option>


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






                              <div class="col-md-4">


                                   <button class="btn btn-danger w-100 rounded-4 py-3">


                                        <i class="ri-search-line"></i>

                                        Cari Incident


                                   </button>


                              </div>



                         </div>


                    </form>


               </div>


          </div>









          {{-- TABLE --}}


          <div class="card table-box">


               <div class="card-body">


                    <div class="d-flex justify-content-between mb-4">


                         <h4 class="fw-bold">

                              Incident List

                         </h4>



                         <span class="text-muted">

                              {{ $incidents->total() }} Data

                         </span>


                    </div>






                    <div class="table-responsive">


                         <table class="table">


                              <thead>

                                   <tr>

                                        <th>No</th>

                                        <th>Incident</th>

                                        <th>Armada</th>

                                        <th>Route</th>

                                        <th>Reporter</th>

                                        <th>Severity</th>

                                        <th>Status</th>

                                        <th>Map</th>

                                        <th>Action</th>

                                   </tr>


                              </thead>



                              <tbody>



                                   @forelse($incidents as $incident)
                                        <tr>



                                             <td>

                                                  {{ $loop->iteration }}

                                             </td>




                                             <td>


                                                  <div class="title-incident">

                                                       {{ $incident->title }}

                                                  </div>


                                                  <small class="text-muted">

                                                       {{ ucfirst($incident->incident_type) }}

                                                  </small>


                                             </td>







                                             <td>

                                                  {{ $incident->vehicle->plate_number ?? '-' }}

                                             </td>








                                             <td>


                                                  @if ($incident->route)
                                                       <strong>

                                                            {{ $incident->route->route_code }}

                                                       </strong>


                                                       <br>


                                                       <small>

                                                            {{ $incident->route->origin }}

                                                            -

                                                            {{ $incident->route->destination }}

                                                       </small>
                                                  @else
                                                       -
                                                  @endif


                                             </td>








                                             <td>

                                                  {{ $incident->reporter->name ?? '-' }}

                                             </td>








                                             <td>


                                                  <span class="severity bg-danger text-white">


                                                       {{ strtoupper($incident->severity) }}


                                                  </span>


                                             </td>








                                             <td>


                                                  <span class="status bg-dark text-white">


                                                       {{ strtoupper($incident->status) }}


                                                  </span>


                                             </td>








                                             <td>


                                                  @if ($incident->location_latitude)
                                                       <a target="_blank"
                                                            href="https://maps.google.com/?q={{ $incident->location_latitude }},{{ $incident->location_longitude }}"
                                                            class="map-link">


                                                            <i class="ri-map-pin-line"></i>

                                                            MAP


                                                       </a>
                                                  @else
                                                       -
                                                  @endif


                                             </td>








                                             <td>


                                                  <a href="{{ route('admin.incidents.show', $incident->id) }}"
                                                       class="action-btn btn-view">


                                                       <i class="ri-eye-line"></i>


                                                  </a>





                                                  <a href="{{ route('admin.incidents.edit', $incident->id) }}"
                                                       class="action-btn btn-edit">


                                                       <i class="ri-edit-line"></i>


                                                  </a>






                                                  <form action="{{ route('admin.incidents.destroy', $incident->id) }}"
                                                       method="POST" class="d-inline">


                                                       @csrf

                                                       @method('DELETE')


                                                       <button onclick="return confirm('Hapus incident?')"
                                                            class="action-btn btn-delete border-0">


                                                            <i class="ri-delete-bin-line"></i>


                                                       </button>


                                                  </form>



                                             </td>


                                        </tr>


                                   @empty


                                        <tr>

                                             <td colspan="9" class="text-center py-5">


                                                  Belum ada data incident


                                             </td>

                                        </tr>
                                   @endforelse



                              </tbody>


                         </table>


                    </div>






                    {{ $incidents->links() }}



               </div>


          </div>



     </div>
@endsection
