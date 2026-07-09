@extends('layouts.app')

@section('content')
     <div class="container-fluid px-4 route-page">

          <!-- HERO -->
          <div class="route-hero mb-4">

               <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>
                         <div class="hero-badge mb-2">
                              <i class="bi bi-signpost-2"></i>
                              Route Management
                         </div>

                         <h2 class="hero-title">Manajemen Rute</h2>

                         <p class="hero-subtitle">
                              Kelola data rute transportasi secara real-time, rapi, dan terstruktur.
                         </p>
                    </div>

                    <a href="{{ route('admin.routes.create') }}" class="btn btn-light btn-add-route">
                         <i class="bi bi-plus-lg me-1"></i>
                         Tambah Rute
                    </a>

               </div>

          </div>

          <!-- SUMMARY CARD -->
          <div class="row g-3 mb-4">

               <div class="col-md-4">
                    <div class="summary-card">
                         <div class="summary-icon primary">
                              <i class="bi bi-map"></i>
                         </div>

                         <div>
                              <div class="summary-label">Total Rute</div>
                              <div class="summary-value">{{ $routes->total() }}</div>
                         </div>
                    </div>
               </div>

               <div class="col-md-4">
                    <div class="summary-card">
                         <div class="summary-icon success">
                              <i class="bi bi-check-circle"></i>
                         </div>

                         <div>
                              <div class="summary-label">Data Ditampilkan</div>
                              <div class="summary-value">{{ $routes->count() }}</div>
                         </div>
                    </div>
               </div>

               <div class="col-md-4">
                    <div class="summary-card">
                         <div class="summary-icon warning">
                              <i class="bi bi-layers"></i>
                         </div>

                         <div>
                              <div class="summary-label">Halaman Aktif</div>
                              <div class="summary-value">{{ $routes->currentPage() }}</div>
                         </div>
                    </div>
               </div>

          </div>

          <!-- TABLE CARD -->
          <div class="card route-card border-0">

               <!-- HEADER -->
               <div class="card-header route-card-header border-0">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                         <div>
                              <h5 class="card-title-custom mb-1">Daftar Rute</h5>
                              <p class="card-subtitle-custom mb-0">
                                   Total {{ $routes->total() }} data rute tersedia di sistem.
                              </p>
                         </div>

                         <div class="table-mini-info">
                              <i class="bi bi-database"></i>
                              Active Data
                         </div>

                    </div>

               </div>

               <!-- TABLE -->
               <div class="card-body p-0">

                    <div class="table-responsive">

                         <table class="table route-table mb-0 align-middle">

                              <thead>
                                   <tr>
                                        <th style="width: 70px;">No</th>
                                        <th>Kode</th>
                                        <th>Rute</th>
                                        <th>Operator</th>
                                        <th>Transport</th>
                                        <th>Jarak</th>
                                        <th>Status</th>
                                        <th class="text-center" style="width: 160px;">Action</th>
                                   </tr>
                              </thead>

                              <tbody>

                                   @forelse($routes as $i => $r)
                                        <tr>

                                             <td>
                                                  <span class="number-text">
                                                       {{ $routes->firstItem() + $i }}
                                                  </span>
                                             </td>

                                             <td>
                                                  <span class="route-code">
                                                       {{ $r->route_code }}
                                                  </span>
                                             </td>

                                             <td>
                                                  <div class="route-name">
                                                       {{ $r->route_name }}
                                                  </div>

                                                  <div class="route-path">
                                                       <i class="bi bi-geo-alt"></i>
                                                       {{ $r->origin }} → {{ $r->destination }}
                                                  </div>
                                             </td>

                                             <td>
                                                  <span class="text-dark fw-medium">
                                                       {{ $r->operator->operator_name ?? '-' }}
                                                  </span>
                                             </td>

                                             <td>
                                                  <span class="transport-chip">
                                                       <i class="bi bi-bus-front"></i>
                                                       {{ $r->transportMode->mode_name ?? '-' }}
                                                  </span>
                                             </td>

                                             <td>
                                                  <span class="distance-text">
                                                       {{ $r->distance_km ?? 0 }} km
                                                  </span>
                                             </td>

                                             <td>
                                                  @if ($r->status == 'active')
                                                       <span class="status-pill active">
                                                            <span></span>
                                                            Active
                                                       </span>
                                                  @elseif($r->status == 'inactive')
                                                       <span class="status-pill inactive">
                                                            <span></span>
                                                            Inactive
                                                       </span>
                                                  @else
                                                       <span class="status-pill maintenance">
                                                            <span></span>
                                                            Maintenance
                                                       </span>
                                                  @endif
                                             </td>

                                             <td>
                                                  <div class="table-action">

                                                       <a href="{{ route('admin.routes.show', $r->id) }}"
                                                            class="action-btn view" title="Detail">
                                                            <i class="bi bi-eye"></i>
                                                       </a>

                                                       <a href="{{ route('admin.routes.edit', $r->id) }}"
                                                            class="action-btn edit" title="Edit">
                                                            <i class="bi bi-pencil-square"></i>
                                                       </a>

                                                       <form action="{{ route('admin.routes.destroy', $r->id) }}"
                                                            method="POST" class="m-0">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="action-btn delete" title="Hapus"
                                                                 onclick="return confirm('Yakin ingin menghapus data rute ini?')">
                                                                 <i class="bi bi-trash3"></i>
                                                            </button>

                                                       </form>

                                                  </div>
                                             </td>

                                        </tr>

                                   @empty

                                        <tr>
                                             <td colspan="8">
                                                  <div class="empty-state">
                                                       <div class="empty-icon">
                                                            <i class="bi bi-map"></i>
                                                       </div>

                                                       <h6>Belum ada data rute</h6>

                                                       <p>
                                                            Silakan tambahkan data rute baru untuk mulai mengelola sistem
                                                            transportasi.
                                                       </p>

                                                       <a href="{{ route('admin.routes.create') }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="bi bi-plus-lg me-1"></i>
                                                            Tambah Rute
                                                       </a>
                                                  </div>
                                             </td>
                                        </tr>
                                   @endforelse

                              </tbody>

                         </table>

                    </div>

               </div>

               <!-- FOOTER -->
               <div class="card-footer route-card-footer border-0">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                         <small class="footer-text">
                              @if ($routes->count())
                                   Menampilkan {{ $routes->firstItem() }} sampai {{ $routes->lastItem() }}
                                   dari {{ $routes->total() }} data
                              @else
                                   Tidak ada data yang ditampilkan
                              @endif
                         </small>

                         <div class="pagination-wrapper">
                              {{ $routes->links() }}
                         </div>

                    </div>

               </div>

          </div>

     </div>

     <style>
          .route-page {
               font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
          }

          .route-hero {
               position: relative;
               overflow: hidden;
               padding: 28px;
               border-radius: 24px;
               background:
                    radial-gradient(circle at top right, rgba(255, 255, 255, .45), transparent 32%),
                    linear-gradient(135deg, #2563eb 0%, #4f46e5 48%, #7c3aed 100%);
               color: #fff;
               box-shadow: 0 18px 45px rgba(37, 99, 235, .28);
          }

          .route-hero::after {
               content: "";
               position: absolute;
               width: 180px;
               height: 180px;
               right: -50px;
               bottom: -70px;
               border-radius: 50%;
               background: rgba(255, 255, 255, .16);
          }

          .hero-badge {
               position: relative;
               z-index: 1;
               display: inline-flex;
               align-items: center;
               gap: 8px;
               padding: 7px 12px;
               border-radius: 999px;
               background: rgba(255, 255, 255, .16);
               border: 1px solid rgba(255, 255, 255, .22);
               font-size: 12px;
               font-weight: 600;
               letter-spacing: .3px;
          }

          .hero-title {
               position: relative;
               z-index: 1;
               margin: 0;
               font-size: 26px;
               font-weight: 800;
               letter-spacing: -.5px;
          }

          .hero-subtitle {
               position: relative;
               z-index: 1;
               margin: 7px 0 0;
               max-width: 560px;
               color: rgba(255, 255, 255, .84);
               font-size: 14px;
          }

          .btn-add-route {
               position: relative;
               z-index: 1;
               border: 0;
               border-radius: 14px;
               padding: 11px 17px;
               font-size: 14px;
               font-weight: 700;
               color: #2563eb;
               box-shadow: 0 12px 28px rgba(15, 23, 42, .18);
               transition: all .2s ease;
          }

          .btn-add-route:hover {
               transform: translateY(-2px);
               color: #1d4ed8;
          }

          .summary-card {
               display: flex;
               align-items: center;
               gap: 14px;
               padding: 18px;
               min-height: 98px;
               border-radius: 20px;
               background: #fff;
               border: 1px solid #edf0f5;
               box-shadow: 0 12px 35px rgba(15, 23, 42, .06);
               transition: all .2s ease;
          }

          .summary-card:hover {
               transform: translateY(-3px);
               box-shadow: 0 18px 45px rgba(15, 23, 42, .09);
          }

          .summary-icon {
               width: 48px;
               height: 48px;
               display: flex;
               align-items: center;
               justify-content: center;
               border-radius: 16px;
               font-size: 21px;
          }

          .summary-icon.primary {
               background: #eff6ff;
               color: #2563eb;
          }

          .summary-icon.success {
               background: #ecfdf5;
               color: #059669;
          }

          .summary-icon.warning {
               background: #fffbeb;
               color: #d97706;
          }

          .summary-label {
               font-size: 13px;
               color: #64748b;
               margin-bottom: 3px;
          }

          .summary-value {
               font-size: 24px;
               font-weight: 800;
               color: #0f172a;
               line-height: 1;
          }

          .route-card {
               border-radius: 24px;
               overflow: hidden;
               background: #fff;
               box-shadow: 0 20px 55px rgba(15, 23, 42, .08);
          }

          .route-card-header {
               padding: 20px 22px;
               background: #fff;
               border-bottom: 1px solid #f1f5f9 !important;
          }

          .card-title-custom {
               font-size: 17px;
               font-weight: 800;
               color: #0f172a;
          }

          .card-subtitle-custom {
               font-size: 13px;
               color: #64748b;
          }

          .table-mini-info {
               display: inline-flex;
               align-items: center;
               gap: 7px;
               padding: 8px 12px;
               border-radius: 999px;
               background: #f8fafc;
               color: #475569;
               font-size: 12px;
               font-weight: 700;
               border: 1px solid #e2e8f0;
          }

          .route-table {
               border-collapse: separate;
               border-spacing: 0;
          }

          .route-table thead th {
               padding: 15px 16px;
               background: #f8fafc;
               color: #475569;
               font-size: 11px;
               font-weight: 800;
               letter-spacing: .7px;
               text-transform: uppercase;
               border-bottom: 1px solid #e2e8f0;
               white-space: nowrap;
          }

          .route-table tbody td {
               padding: 16px;
               color: #334155;
               font-size: 14px;
               border-bottom: 1px solid #f1f5f9;
               vertical-align: middle;
          }

          .route-table tbody tr {
               transition: all .18s ease;
          }

          .route-table tbody tr:hover {
               background: #f8fbff;
          }

          .number-text {
               color: #94a3b8;
               font-weight: 700;
          }

          .route-code {
               display: inline-flex;
               align-items: center;
               padding: 7px 11px;
               border-radius: 12px;
               background: #eef2ff;
               color: #3730a3;
               font-size: 12px;
               font-weight: 800;
               letter-spacing: .3px;
               white-space: nowrap;
          }

          .route-name {
               color: #0f172a;
               font-weight: 800;
               margin-bottom: 4px;
          }

          .route-path {
               display: flex;
               align-items: center;
               gap: 5px;
               color: #64748b;
               font-size: 12px;
          }

          .transport-chip {
               display: inline-flex;
               align-items: center;
               gap: 6px;
               padding: 7px 10px;
               border-radius: 999px;
               background: #f8fafc;
               color: #475569;
               font-size: 12px;
               font-weight: 700;
               border: 1px solid #e2e8f0;
               white-space: nowrap;
          }

          .distance-text {
               color: #475569;
               font-weight: 700;
               white-space: nowrap;
          }

          .status-pill {
               display: inline-flex;
               align-items: center;
               gap: 7px;
               padding: 7px 11px;
               border-radius: 999px;
               font-size: 12px;
               font-weight: 800;
               white-space: nowrap;
          }

          .status-pill span {
               width: 7px;
               height: 7px;
               border-radius: 50%;
          }

          .status-pill.active {
               background: #dcfce7;
               color: #166534;
          }

          .status-pill.active span {
               background: #16a34a;
          }

          .status-pill.inactive {
               background: #fee2e2;
               color: #991b1b;
          }

          .status-pill.inactive span {
               background: #dc2626;
          }

          .status-pill.maintenance {
               background: #fef3c7;
               color: #92400e;
          }

          .status-pill.maintenance span {
               background: #d97706;
          }

          .table-action {
               display: flex;
               align-items: center;
               justify-content: center;
               gap: 8px;
          }

          .action-btn {
               width: 36px;
               height: 36px;
               display: inline-flex;
               align-items: center;
               justify-content: center;
               border-radius: 12px;
               border: 1px solid #e2e8f0;
               background: #fff;
               color: #475569;
               text-decoration: none;
               transition: all .18s ease;
          }

          .action-btn:hover {
               transform: translateY(-2px);
          }

          .action-btn.view:hover {
               background: #ecfeff;
               border-color: #a5f3fc;
               color: #0891b2;
          }

          .action-btn.edit:hover {
               background: #eff6ff;
               border-color: #bfdbfe;
               color: #2563eb;
          }

          .action-btn.delete:hover {
               background: #fef2f2;
               border-color: #fecaca;
               color: #dc2626;
          }

          .empty-state {
               padding: 54px 20px;
               text-align: center;
          }

          .empty-icon {
               width: 64px;
               height: 64px;
               display: flex;
               align-items: center;
               justify-content: center;
               margin: 0 auto 14px;
               border-radius: 20px;
               background: #eff6ff;
               color: #2563eb;
               font-size: 28px;
          }

          .empty-state h6 {
               margin-bottom: 6px;
               font-weight: 800;
               color: #0f172a;
          }

          .empty-state p {
               margin: 0 auto 16px;
               max-width: 420px;
               color: #64748b;
               font-size: 13px;
          }

          .route-card-footer {
               padding: 16px 22px;
               background: #fff;
               border-top: 1px solid #f1f5f9 !important;
          }

          .footer-text {
               color: #64748b;
               font-size: 13px;
               font-weight: 600;
          }

          .pagination-wrapper nav {
               margin: 0;
          }

          .pagination-wrapper .pagination {
               margin-bottom: 0;
          }

          .pagination-wrapper .page-link {
               border-radius: 10px;
               margin: 0 3px;
               color: #2563eb;
               border: 1px solid #e2e8f0;
               font-size: 13px;
          }

          .pagination-wrapper .page-item.active .page-link {
               background: #2563eb;
               border-color: #2563eb;
          }

          @media (max-width: 768px) {
               .route-hero {
                    padding: 22px;
               }

               .hero-title {
                    font-size: 22px;
               }

               .route-table thead th,
               .route-table tbody td {
                    padding: 13px;
               }

               .summary-card {
                    min-height: auto;
               }

               .route-card-footer {
                    text-align: center;
               }
          }
     </style>
@endsection
