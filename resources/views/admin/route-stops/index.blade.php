@extends('layouts.app')

@section('content')
     <div class="route-stop-page">

          <div class="container-fluid px-4">

               {{-- HERO SECTION --}}
               <div class="hero-card mb-4">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                         <div>
                              <div class="page-badge mb-2">
                                   <i class="bi bi-signpost-2"></i>
                                   Route Stop Management
                              </div>

                              <h2 class="page-title mb-1">
                                   Manajemen Route Stops
                              </h2>

                              <p class="page-subtitle mb-0">
                                   Kelola urutan halte, jarak tempuh, dan estimasi waktu tiba pada setiap rute transportasi.
                              </p>
                         </div>

                         <a href="{{ route('admin.route-stops.create') }}" class="btn btn-add">
                              <i class="bi bi-plus-circle me-1"></i>
                              Tambah Route Stop
                         </a>

                    </div>

               </div>

               {{-- SUMMARY CARD --}}
               <div class="row g-3 mb-4">

                    <div class="col-md-4">
                         <div class="summary-card">
                              <div class="summary-icon blue">
                                   <i class="bi bi-list-ol"></i>
                              </div>
                              <div>
                                   <div class="summary-label">Total Data</div>
                                   <div class="summary-value">{{ $routeStops->total() }}</div>
                              </div>
                         </div>
                    </div>

                    <div class="col-md-4">
                         <div class="summary-card">
                              <div class="summary-icon green">
                                   <i class="bi bi-map"></i>
                              </div>
                              <div>
                                   <div class="summary-label">Data Halaman Ini</div>
                                   <div class="summary-value">{{ $routeStops->count() }}</div>
                              </div>
                         </div>
                    </div>

                    <div class="col-md-4">
                         <div class="summary-card">
                              <div class="summary-icon purple">
                                   <i class="bi bi-clock-history"></i>
                              </div>
                              <div>
                                   <div class="summary-label">Status</div>
                                   <div class="summary-value">Aktif</div>
                              </div>
                         </div>
                    </div>

               </div>

               {{-- MAIN CARD --}}
               <div class="main-card">

                    {{-- CARD HEADER --}}
                    <div class="main-card-header">

                         <div>
                              <h5 class="card-title mb-1">Daftar Route Stops</h5>
                              <p class="card-desc mb-0">
                                   Data urutan halte berdasarkan rute yang tersedia dalam sistem.
                              </p>
                         </div>

                         <div class="table-info-box">
                              {{ $routeStops->total() }} data
                         </div>

                    </div>

                    {{-- TABLE --}}
                    <div class="table-responsive">

                         <table class="table table-custom align-middle mb-0">

                              <thead>
                                   <tr>
                                        <th>No</th>
                                        <th>Route</th>
                                        <th>Stop</th>
                                        <th>Order</th>
                                        <th>Distance</th>
                                        <th>ETA</th>
                                        <th class="text-center">Action</th>
                                   </tr>
                              </thead>

                              <tbody>

                                   @forelse($routeStops as $i => $item)
                                        <tr>

                                             <td>
                                                  <span class="number-cell">
                                                       {{ $routeStops->firstItem() + $i }}
                                                  </span>
                                             </td>

                                             <td>
                                                  <div class="route-name">
                                                       {{ $item->route->route_name ?? '-' }}
                                                  </div>
                                                  <small class="route-sub">
                                                       Route ID: {{ $item->route_id ?? '-' }}
                                                  </small>
                                             </td>

                                             <td>
                                                  <span class="stop-badge">
                                                       <i class="bi bi-geo-alt"></i>
                                                       {{ $item->stop_id }}
                                                  </span>
                                             </td>

                                             <td>
                                                  <span class="order-chip">
                                                       #{{ $item->stop_order }}
                                                  </span>
                                             </td>

                                             <td>
                                                  <span class="data-text">
                                                       {{ $item->distance_from_start_km ?? 0 }} km
                                                  </span>
                                             </td>

                                             <td>
                                                  <span class="eta-chip">
                                                       <i class="bi bi-clock"></i>
                                                       {{ $item->estimated_arrival_minutes ?? 0 }} min
                                                  </span>
                                             </td>

                                             <td>
                                                  <div class="action-wrapper">

                                                       <a href="{{ route('admin.route-stops.edit', $item->id) }}"
                                                            class="action-btn edit" title="Edit data">
                                                            <i class="bi bi-pencil-square"></i>
                                                       </a>

                                                       <form action="{{ route('admin.route-stops.destroy', $item->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="action-btn delete"
                                                                 title="Hapus data">
                                                                 <i class="bi bi-trash3"></i>
                                                            </button>

                                                       </form>

                                                  </div>
                                             </td>

                                        </tr>

                                   @empty

                                        <tr>
                                             <td colspan="7">
                                                  <div class="empty-state">
                                                       <div class="empty-icon">
                                                            <i class="bi bi-inbox"></i>
                                                       </div>
                                                       <h6>Belum ada data route stop</h6>
                                                       <p>Tambahkan data route stop untuk mulai mengatur urutan halte.</p>

                                                       <a href="{{ route('admin.route-stops.create') }}"
                                                            class="btn btn-add btn-sm">
                                                            <i class="bi bi-plus-circle me-1"></i>
                                                            Tambah Data
                                                       </a>
                                                  </div>
                                             </td>
                                        </tr>
                                   @endforelse

                              </tbody>

                         </table>

                    </div>

                    {{-- FOOTER --}}
                    <div class="main-card-footer">

                         <small class="text-muted">
                              @if ($routeStops->total() > 0)
                                   Menampilkan {{ $routeStops->firstItem() }} sampai {{ $routeStops->lastItem() }}
                                   dari {{ $routeStops->total() }} data
                              @else
                                   Tidak ada data yang ditampilkan
                              @endif
                         </small>

                         <div class="pagination-wrapper">
                              {{ $routeStops->links() }}
                         </div>

                    </div>

               </div>

          </div>

     </div>

     <style>
          .route-stop-page {
               min-height: 100vh;
               padding: 24px 0;
               background:
                    radial-gradient(circle at top left, rgba(37, 99, 235, 0.10), transparent 32%),
                    linear-gradient(180deg, #f8fafc 0%, #eef2f7 100%);
          }

          .hero-card {
               padding: 24px;
               border-radius: 24px;
               background: linear-gradient(135deg, #2563eb 0%, #4f46e5 55%, #7c3aed 100%);
               color: #ffffff;
               box-shadow: 0 20px 45px rgba(37, 99, 235, 0.22);
               position: relative;
               overflow: hidden;
          }

          .hero-card::after {
               content: "";
               position: absolute;
               width: 240px;
               height: 240px;
               right: -80px;
               top: -80px;
               border-radius: 50%;
               background: rgba(255, 255, 255, 0.14);
          }

          .page-badge {
               display: inline-flex;
               align-items: center;
               gap: 7px;
               padding: 7px 12px;
               border-radius: 999px;
               font-size: 12px;
               font-weight: 600;
               background: rgba(255, 255, 255, 0.18);
               backdrop-filter: blur(8px);
          }

          .page-title {
               font-size: 26px;
               font-weight: 800;
               letter-spacing: -0.4px;
          }

          .page-subtitle {
               max-width: 620px;
               font-size: 14px;
               color: rgba(255, 255, 255, 0.82);
          }

          .btn-add {
               position: relative;
               z-index: 2;
               border: none;
               border-radius: 14px;
               padding: 11px 18px;
               font-weight: 700;
               color: #2563eb;
               background: #ffffff;
               box-shadow: 0 12px 28px rgba(15, 23, 42, 0.18);
               transition: 0.2s ease;
          }

          .btn-add:hover {
               color: #1d4ed8;
               background: #f8fafc;
               transform: translateY(-2px);
          }

          .summary-card {
               height: 100%;
               padding: 18px;
               border-radius: 20px;
               background: rgba(255, 255, 255, 0.86);
               border: 1px solid rgba(226, 232, 240, 0.9);
               box-shadow: 0 14px 34px rgba(15, 23, 42, 0.06);
               display: flex;
               align-items: center;
               gap: 14px;
          }

          .summary-icon {
               width: 46px;
               height: 46px;
               border-radius: 15px;
               display: flex;
               align-items: center;
               justify-content: center;
               font-size: 21px;
          }

          .summary-icon.blue {
               color: #2563eb;
               background: #dbeafe;
          }

          .summary-icon.green {
               color: #059669;
               background: #d1fae5;
          }

          .summary-icon.purple {
               color: #7c3aed;
               background: #ede9fe;
          }

          .summary-label {
               font-size: 13px;
               color: #64748b;
               font-weight: 600;
          }

          .summary-value {
               font-size: 21px;
               color: #0f172a;
               font-weight: 800;
               line-height: 1.2;
          }

          .main-card {
               border-radius: 24px;
               background: #ffffff;
               border: 1px solid #e2e8f0;
               box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
               overflow: hidden;
          }

          .main-card-header {
               padding: 22px 24px;
               display: flex;
               justify-content: space-between;
               align-items: center;
               gap: 14px;
               border-bottom: 1px solid #e2e8f0;
               background: #ffffff;
          }

          .card-title {
               color: #0f172a;
               font-size: 18px;
               font-weight: 800;
          }

          .card-desc {
               color: #64748b;
               font-size: 13px;
          }

          .table-info-box {
               padding: 8px 13px;
               border-radius: 999px;
               color: #2563eb;
               background: #eff6ff;
               font-size: 13px;
               font-weight: 700;
               white-space: nowrap;
          }

          .table-custom {
               color: #334155;
          }

          .table-custom thead th {
               padding: 15px 18px;
               font-size: 12px;
               font-weight: 800;
               text-transform: uppercase;
               letter-spacing: 0.6px;
               color: #64748b;
               background: #f8fafc;
               border-bottom: 1px solid #e2e8f0;
               white-space: nowrap;
          }

          .table-custom tbody td {
               padding: 17px 18px;
               border-bottom: 1px solid #f1f5f9;
               vertical-align: middle;
          }

          .table-custom tbody tr {
               transition: 0.18s ease;
          }

          .table-custom tbody tr:hover {
               background: #f8fafc;
          }

          .number-cell {
               width: 32px;
               height: 32px;
               border-radius: 10px;
               display: inline-flex;
               align-items: center;
               justify-content: center;
               color: #475569;
               background: #f1f5f9;
               font-size: 13px;
               font-weight: 700;
          }

          .route-name {
               color: #0f172a;
               font-weight: 800;
               font-size: 14px;
          }

          .route-sub {
               color: #94a3b8;
               font-size: 12px;
          }

          .stop-badge {
               display: inline-flex;
               align-items: center;
               gap: 6px;
               padding: 7px 11px;
               border-radius: 12px;
               color: #475569;
               background: #f8fafc;
               border: 1px solid #e2e8f0;
               font-size: 13px;
               font-weight: 700;
               white-space: nowrap;
          }

          .order-chip {
               display: inline-flex;
               align-items: center;
               padding: 7px 12px;
               border-radius: 999px;
               color: #4338ca;
               background: #eef2ff;
               font-size: 13px;
               font-weight: 800;
          }

          .data-text {
               color: #475569;
               font-weight: 700;
               white-space: nowrap;
          }

          .eta-chip {
               display: inline-flex;
               align-items: center;
               gap: 6px;
               padding: 7px 11px;
               border-radius: 999px;
               color: #0f766e;
               background: #ccfbf1;
               font-size: 13px;
               font-weight: 800;
               white-space: nowrap;
          }

          .action-wrapper {
               display: flex;
               justify-content: center;
               align-items: center;
               gap: 8px;
          }

          .action-btn {
               width: 38px;
               height: 38px;
               border-radius: 13px;
               border: 1px solid #e2e8f0;
               background: #ffffff;
               display: inline-flex;
               align-items: center;
               justify-content: center;
               text-decoration: none;
               transition: 0.2s ease;
               font-size: 16px;
          }

          .action-btn.edit {
               color: #2563eb;
          }

          .action-btn.delete {
               color: #dc2626;
          }

          .action-btn.edit:hover {
               color: #ffffff;
               background: #2563eb;
               border-color: #2563eb;
               transform: translateY(-2px);
          }

          .action-btn.delete:hover {
               color: #ffffff;
               background: #dc2626;
               border-color: #dc2626;
               transform: translateY(-2px);
          }

          .empty-state {
               padding: 56px 20px;
               text-align: center;
          }

          .empty-icon {
               width: 72px;
               height: 72px;
               margin: 0 auto 16px;
               border-radius: 24px;
               background: #f1f5f9;
               color: #64748b;
               display: flex;
               align-items: center;
               justify-content: center;
               font-size: 34px;
          }

          .empty-state h6 {
               color: #0f172a;
               font-weight: 800;
               margin-bottom: 6px;
          }

          .empty-state p {
               color: #64748b;
               font-size: 14px;
               margin-bottom: 18px;
          }

          .main-card-footer {
               padding: 16px 24px;
               display: flex;
               justify-content: space-between;
               align-items: center;
               gap: 16px;
               background: #ffffff;
               border-top: 1px solid #e2e8f0;
               flex-wrap: wrap;
          }

          .pagination-wrapper nav {
               margin-bottom: 0;
          }

          .pagination {
               margin-bottom: 0;
          }

          .page-link {
               border-radius: 10px;
               margin: 0 3px;
               border: 1px solid #e2e8f0;
               color: #2563eb;
               font-weight: 700;
          }

          .page-item.active .page-link {
               background: #2563eb;
               border-color: #2563eb;
          }

          @media (max-width: 768px) {
               .route-stop-page {
                    padding: 16px 0;
               }

               .hero-card {
                    padding: 20px;
                    border-radius: 20px;
               }

               .page-title {
                    font-size: 22px;
               }

               .main-card-header {
                    align-items: flex-start;
                    flex-direction: column;
               }

               .table-custom thead th,
               .table-custom tbody td {
                    padding: 14px;
               }

               .main-card-footer {
                    align-items: flex-start;
                    flex-direction: column;
               }
          }
     </style>
@endsection
