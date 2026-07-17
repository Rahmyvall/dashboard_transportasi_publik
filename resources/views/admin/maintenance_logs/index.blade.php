@extends('layouts.app')

@section('title', $title ?? 'Data Maintenance Kendaraan')

@section('content')
     @php
          $maintenanceTypes = [
              'routine' => [
                  'label' => 'Perawatan Rutin',
                  'class' => 'type-routine',
                  'icon' => 'fa-screwdriver-wrench',
              ],
              'repair' => [
                  'label' => 'Perbaikan',
                  'class' => 'type-repair',
                  'icon' => 'fa-tools',
              ],
              'inspection' => [
                  'label' => 'Inspeksi',
                  'class' => 'type-inspection',
                  'icon' => 'fa-magnifying-glass',
              ],
              'emergency' => [
                  'label' => 'Darurat',
                  'class' => 'type-emergency',
                  'icon' => 'fa-triangle-exclamation',
              ],
          ];

          $statuses = [
              'scheduled' => [
                  'label' => 'Dijadwalkan',
                  'class' => 'status-scheduled',
                  'icon' => 'fa-calendar-clock',
              ],
              'in_progress' => [
                  'label' => 'Sedang Dikerjakan',
                  'class' => 'status-progress',
                  'icon' => 'fa-spinner',
              ],
              'completed' => [
                  'label' => 'Selesai',
                  'class' => 'status-completed',
                  'icon' => 'fa-circle-check',
              ],
              'cancelled' => [
                  'label' => 'Dibatalkan',
                  'class' => 'status-cancelled',
                  'icon' => 'fa-circle-xmark',
              ],
          ];

          $activeFilterCount = collect(['search', 'maintenance_type', 'status'])
              ->filter(fn($filter) => request()->filled($filter))
              ->count();
     @endphp

     <style>
          .maintenance-page {
               --primary-color: #4f46e5;
               --primary-dark: #3730a3;
               --soft-background: #f6f7fb;
               --text-main: #1f2937;
               --text-muted: #6b7280;
          }

          .maintenance-page {
               background: var(--soft-background);
               min-height: calc(100vh - 60px);
          }

          .maintenance-hero {
               position: relative;
               overflow: hidden;
               border: 0;
               border-radius: 22px;
               background: linear-gradient(135deg,
                         #312e81 0%,
                         #4f46e5 48%,
                         #7c3aed 100%);
               box-shadow: 0 18px 45px rgba(79, 70, 229, 0.22);
          }

          .maintenance-hero::before {
               content: "";
               position: absolute;
               width: 260px;
               height: 260px;
               top: -125px;
               right: -70px;
               border-radius: 50%;
               background: rgba(255, 255, 255, 0.09);
          }

          .maintenance-hero::after {
               content: "";
               position: absolute;
               width: 180px;
               height: 180px;
               right: 180px;
               bottom: -120px;
               border-radius: 50%;
               background: rgba(255, 255, 255, 0.07);
          }

          .maintenance-hero .card-body {
               position: relative;
               z-index: 2;
          }

          .hero-icon {
               width: 58px;
               height: 58px;
               display: inline-flex;
               align-items: center;
               justify-content: center;
               border-radius: 17px;
               color: #ffffff;
               background: rgba(255, 255, 255, 0.16);
               backdrop-filter: blur(8px);
          }

          .btn-add-maintenance {
               border: 0;
               border-radius: 12px;
               padding: 11px 18px;
               color: #3730a3;
               background: #ffffff;
               font-weight: 600;
               box-shadow: 0 10px 25px rgba(31, 41, 55, 0.18);
               transition: all 0.2s ease;
          }

          .btn-add-maintenance:hover {
               color: #312e81;
               background: #f8fafc;
               transform: translateY(-2px);
          }

          .summary-card {
               border: 0;
               border-radius: 17px;
               box-shadow: 0 8px 25px rgba(31, 41, 55, 0.06);
          }

          .summary-icon {
               width: 48px;
               height: 48px;
               display: inline-flex;
               align-items: center;
               justify-content: center;
               border-radius: 14px;
          }

          .summary-icon.primary {
               color: #4f46e5;
               background: #eef2ff;
          }

          .summary-icon.success {
               color: #059669;
               background: #ecfdf5;
          }

          .summary-icon.warning {
               color: #d97706;
               background: #fffbeb;
          }

          .modern-card {
               border: 0;
               border-radius: 18px;
               box-shadow: 0 8px 30px rgba(31, 41, 55, 0.07);
          }

          .filter-title {
               color: var(--text-main);
               font-size: 16px;
               font-weight: 700;
          }

          .maintenance-page .form-control,
          .maintenance-page .form-select {
               min-height: 45px;
               border: 1px solid #e5e7eb;
               border-radius: 11px;
               background-color: #ffffff;
          }

          .maintenance-page .form-control:focus,
          .maintenance-page .form-select:focus {
               border-color: #818cf8;
               box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.13);
          }

          .search-input-group .input-group-text {
               border: 1px solid #e5e7eb;
               border-right: 0;
               border-radius: 11px 0 0 11px;
               background: #ffffff;
               color: #9ca3af;
          }

          .search-input-group .form-control {
               border-left: 0;
               border-radius: 0 11px 11px 0;
          }

          .btn-filter {
               min-height: 45px;
               border: 0;
               border-radius: 11px;
               background: linear-gradient(135deg, #4f46e5, #7c3aed);
               font-weight: 600;
          }

          .btn-filter:hover {
               background: linear-gradient(135deg, #4338ca, #6d28d9);
          }

          .btn-reset-filter {
               min-height: 45px;
               border-radius: 11px;
          }

          .table-header {
               padding: 20px 22px;
               border-bottom: 1px solid #eef0f4;
               background: #ffffff;
          }

          .maintenance-table {
               margin-bottom: 0;
          }

          .maintenance-table thead th {
               padding: 14px 16px;
               border: 0;
               background: #f8fafc;
               color: #64748b;
               font-size: 11px;
               font-weight: 700;
               letter-spacing: 0.05em;
               text-transform: uppercase;
               white-space: nowrap;
          }

          .maintenance-table tbody td {
               padding: 16px;
               border-color: #f1f5f9;
               color: #374151;
               vertical-align: middle;
          }

          .maintenance-table tbody tr {
               transition: background-color 0.2s ease;
          }

          .maintenance-table tbody tr:hover {
               background: #fafbff;
          }

          .vehicle-avatar {
               width: 42px;
               height: 42px;
               display: inline-flex;
               flex-shrink: 0;
               align-items: center;
               justify-content: center;
               border-radius: 13px;
               color: #4f46e5;
               background: #eef2ff;
          }

          .type-badge,
          .status-badge {
               display: inline-flex;
               gap: 6px;
               align-items: center;
               border-radius: 999px;
               padding: 7px 11px;
               font-size: 12px;
               font-weight: 600;
               white-space: nowrap;
          }

          .type-routine {
               color: #0369a1;
               background: #e0f2fe;
          }

          .type-repair {
               color: #b45309;
               background: #fef3c7;
          }

          .type-inspection {
               color: #4338ca;
               background: #e0e7ff;
          }

          .type-emergency {
               color: #b91c1c;
               background: #fee2e2;
          }

          .status-scheduled {
               color: #b45309;
               background: #fef3c7;
          }

          .status-progress {
               color: #1d4ed8;
               background: #dbeafe;
          }

          .status-completed {
               color: #047857;
               background: #d1fae5;
          }

          .status-cancelled {
               color: #b91c1c;
               background: #fee2e2;
          }

          .status-dot {
               width: 7px;
               height: 7px;
               border-radius: 50%;
               background: currentColor;
          }

          .action-button {
               width: 35px;
               height: 35px;
               display: inline-flex;
               align-items: center;
               justify-content: center;
               border: 0;
               border-radius: 10px;
               transition: all 0.2s ease;
          }

          .action-button:hover {
               transform: translateY(-2px);
          }

          .action-detail {
               color: #2563eb;
               background: #eff6ff;
          }

          .action-edit {
               color: #d97706;
               background: #fffbeb;
          }

          .action-delete {
               color: #dc2626;
               background: #fef2f2;
          }

          .empty-state {
               padding: 60px 20px;
               text-align: center;
          }

          .empty-state-icon {
               width: 78px;
               height: 78px;
               display: inline-flex;
               align-items: center;
               justify-content: center;
               margin-bottom: 18px;
               border-radius: 22px;
               color: #6366f1;
               background: #eef2ff;
               font-size: 30px;
          }

          .pagination-wrapper {
               padding: 16px 22px;
               border-top: 1px solid #eef0f4;
               background: #ffffff;
          }

          @media (max-width: 767.98px) {
               .maintenance-hero {
                    border-radius: 17px;
               }

               .maintenance-hero .card-body {
                    padding: 22px;
               }

               .btn-add-maintenance {
                    width: 100%;
               }
          }
     </style>

     <div class="container-fluid maintenance-page py-4">

          {{-- Header modern --}}
          <div class="card maintenance-hero mb-4">
               <div class="card-body p-4 p-lg-5">
                    <div
                         class="d-flex flex-column flex-lg-row
                        justify-content-between align-items-lg-center gap-4">

                         <div class="d-flex align-items-start gap-3">
                              <div class="hero-icon">
                                   <i class="fas fa-screwdriver-wrench fs-4"></i>
                              </div>

                              <div>
                                   <span class="badge bg-white bg-opacity-25 mb-2">
                                        Vehicle Management
                                   </span>

                                   <h2 class="text-white fw-bold mb-2">
                                        {{ $title ?? 'Data Maintenance Kendaraan' }}
                                   </h2>

                                   <p class="text-white text-opacity-75 mb-0">
                                        Kelola perawatan, perbaikan, inspeksi, dan
                                        penanganan darurat kendaraan secara terpusat.
                                   </p>
                              </div>
                         </div>

                         <a href="{{ route('admin.maintenance-logs.create') }}" class="btn btn-add-maintenance">
                              <i class="fas fa-plus me-2"></i>
                              Tambah Maintenance
                         </a>
                    </div>
               </div>
          </div>

          {{-- Flash message --}}
          @if (session('success'))
               <div class="alert alert-success alert-dismissible fade show
                    border-0 shadow-sm rounded-3"
                    role="alert">

                    <div class="d-flex align-items-center">
                         <i class="fas fa-circle-check me-2"></i>
                         <span>{{ session('success') }}</span>
                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
               </div>
          @endif

          @if (session('error'))
               <div class="alert alert-danger alert-dismissible fade show
                    border-0 shadow-sm rounded-3"
                    role="alert">

                    <div class="d-flex align-items-center">
                         <i class="fas fa-circle-exclamation me-2"></i>
                         <span>{{ session('error') }}</span>
                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
               </div>
          @endif

          {{-- Ringkasan --}}
          <div class="row g-3 mb-4">

               <div class="col-md-4">
                    <div class="card summary-card h-100">
                         <div class="card-body">
                              <div class="d-flex justify-content-between align-items-center">
                                   <div>
                                        <small class="text-muted fw-semibold">
                                             TOTAL DATA
                                        </small>

                                        <h3 class="fw-bold mb-0 mt-1">
                                             {{ number_format($maintenanceLogs->total()) }}
                                        </h3>
                                   </div>

                                   <div class="summary-icon primary">
                                        <i class="fas fa-database"></i>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

               <div class="col-md-4">
                    <div class="card summary-card h-100">
                         <div class="card-body">
                              <div class="d-flex justify-content-between align-items-center">
                                   <div>
                                        <small class="text-muted fw-semibold">
                                             DATA HALAMAN INI
                                        </small>

                                        <h3 class="fw-bold mb-0 mt-1">
                                             {{ $maintenanceLogs->count() }}
                                        </h3>
                                   </div>

                                   <div class="summary-icon success">
                                        <i class="fas fa-list-check"></i>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

               <div class="col-md-4">
                    <div class="card summary-card h-100">
                         <div class="card-body">
                              <div class="d-flex justify-content-between align-items-center">
                                   <div>
                                        <small class="text-muted fw-semibold">
                                             FILTER AKTIF
                                        </small>

                                        <h3 class="fw-bold mb-0 mt-1">
                                             {{ $activeFilterCount }}
                                        </h3>
                                   </div>

                                   <div class="summary-icon warning">
                                        <i class="fas fa-filter"></i>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

          </div>

          {{-- Filter --}}
          <div class="card modern-card mb-4">
               <div class="card-body p-4">

                    <div
                         class="d-flex justify-content-between
                        align-items-center flex-wrap gap-2 mb-3">

                         <div>
                              <div class="filter-title">
                                   <i class="fas fa-sliders me-2 text-primary"></i>
                                   Filter Data
                              </div>

                              <small class="text-muted">
                                   Cari dan saring data maintenance kendaraan.
                              </small>
                         </div>

                         @if ($activeFilterCount > 0)
                              <span class="badge rounded-pill bg-primary">
                                   {{ $activeFilterCount }} filter aktif
                              </span>
                         @endif
                    </div>

                    <form action="{{ route('admin.maintenance-logs.index') }}" method="GET">
                         <div class="row g-3">

                              <div class="col-lg-4">
                                   <label for="search" class="form-label fw-semibold">
                                        Pencarian
                                   </label>

                                   <div class="input-group search-input-group">
                                        <span class="input-group-text">
                                             <i class="fas fa-search"></i>
                                        </span>

                                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                                             class="form-control" placeholder="Deskripsi atau nama petugas">
                                   </div>
                              </div>

                              <div class="col-md-6 col-lg-3">
                                   <label for="maintenance_type" class="form-label fw-semibold">
                                        Jenis Maintenance
                                   </label>

                                   <select name="maintenance_type" id="maintenance_type" class="form-select">
                                        <option value="">Semua Jenis</option>

                                        @foreach ($maintenanceTypes as $value => $type)
                                             <option value="{{ $value }}" @selected(request('maintenance_type') === $value)>
                                                  {{ $type['label'] }}
                                             </option>
                                        @endforeach
                                   </select>
                              </div>

                              <div class="col-md-6 col-lg-3">
                                   <label for="status" class="form-label fw-semibold">
                                        Status
                                   </label>

                                   <select name="status" id="status" class="form-select">
                                        <option value="">Semua Status</option>

                                        @foreach ($statuses as $value => $status)
                                             <option value="{{ $value }}" @selected(request('status') === $value)>
                                                  {{ $status['label'] }}
                                             </option>
                                        @endforeach
                                   </select>
                              </div>

                              <div class="col-lg-2 d-flex align-items-end">
                                   <div class="d-flex gap-2 w-100">
                                        <button type="submit" class="btn btn-primary btn-filter flex-fill"
                                             title="Terapkan filter">
                                             <i class="fas fa-filter me-1"></i>
                                             Filter
                                        </button>

                                        <a href="{{ route('admin.maintenance-logs.index') }}"
                                             class="btn btn-outline-secondary
                                       btn-reset-filter"
                                             title="Reset filter">
                                             <i class="fas fa-rotate-left"></i>
                                        </a>
                                   </div>
                              </div>

                         </div>
                    </form>
               </div>
          </div>

          {{-- Tabel --}}
          <div class="card modern-card overflow-hidden">

               <div class="table-header">
                    <div
                         class="d-flex flex-column flex-md-row
                        justify-content-between align-items-md-center gap-2">

                         <div>
                              <h5 class="fw-bold mb-1">
                                   Daftar Maintenance
                              </h5>

                              <small class="text-muted">
                                   Menampilkan data maintenance kendaraan terbaru.
                              </small>
                         </div>

                         <span class="badge rounded-pill bg-primary px-3 py-2">
                              {{ number_format($maintenanceLogs->total()) }} data
                         </span>
                    </div>
               </div>

               <div class="table-responsive">
                    <table class="table maintenance-table align-middle">

                         <thead>
                              <tr>
                                   <th class="text-center">No.</th>
                                   <th>Kendaraan</th>
                                   <th>Jenis</th>
                                   <th>Deskripsi</th>
                                   <th>Biaya</th>
                                   <th>Tanggal</th>
                                   <th>Jadwal Berikutnya</th>
                                   <th>Status</th>
                                   <th>Petugas</th>
                                   <th class="text-center">Aksi</th>
                              </tr>
                         </thead>

                         <tbody>
                              @forelse ($maintenanceLogs as $maintenanceLog)
                                   @php
                                        $typeData = $maintenanceTypes[$maintenanceLog->maintenance_type] ?? [
                                            'label' => ucfirst($maintenanceLog->maintenance_type),
                                            'class' => 'bg-secondary text-white',
                                            'icon' => 'fa-wrench',
                                        ];

                                        $statusData = $statuses[$maintenanceLog->status] ?? [
                                            'label' => ucfirst($maintenanceLog->status),
                                            'class' => 'bg-secondary text-white',
                                            'icon' => 'fa-circle-info',
                                        ];

                                        $vehicleName =
                                            $maintenanceLog->vehicle?->plate_number ??
                                            ($maintenanceLog->vehicle?->name ??
                                                'Kendaraan #' . $maintenanceLog->vehicle_id);
                                   @endphp

                                   <tr>
                                        <td class="text-center text-muted">
                                             {{ $maintenanceLogs->firstItem() + $loop->index }}
                                        </td>

                                        <td style="min-width: 190px;">
                                             <div class="d-flex align-items-center gap-3">
                                                  <div class="vehicle-avatar">
                                                       <i class="fas fa-car-side"></i>
                                                  </div>

                                                  <div>
                                                       <div class="fw-semibold text-dark">
                                                            {{ $vehicleName }}
                                                       </div>

                                                       <small class="text-muted">
                                                            ID Kendaraan:
                                                            {{ $maintenanceLog->vehicle_id }}
                                                       </small>
                                                  </div>
                                             </div>
                                        </td>

                                        <td>
                                             <span class="type-badge {{ $typeData['class'] }}">
                                                  <i class="fas {{ $typeData['icon'] }}"></i>
                                                  {{ $typeData['label'] }}
                                             </span>
                                        </td>

                                        <td style="min-width: 240px;">
                                             <span title="{{ $maintenanceLog->description }}">
                                                  {{ \Illuminate\Support\Str::limit($maintenanceLog->description ?? 'Tidak ada deskripsi', 65) }}
                                             </span>
                                        </td>

                                        <td class="text-nowrap">
                                             <div class="fw-semibold text-dark">
                                                  Rp
                                                  {{ number_format((float) $maintenanceLog->cost, 0, ',', '.') }}
                                             </div>
                                        </td>

                                        <td class="text-nowrap">
                                             <div class="fw-semibold">
                                                  {{ $maintenanceLog->maintenance_date?->format('d M Y') ?? '-' }}
                                             </div>

                                             <small class="text-muted">
                                                  Maintenance
                                             </small>
                                        </td>

                                        <td class="text-nowrap">
                                             @if ($maintenanceLog->next_maintenance_date)
                                                  <div class="fw-semibold">
                                                       {{ $maintenanceLog->next_maintenance_date->format('d M Y') }}
                                                  </div>

                                                  <small class="text-muted">
                                                       Jadwal selanjutnya
                                                  </small>
                                             @else
                                                  <span class="text-muted">
                                                       <i class="far fa-calendar-xmark me-1"></i>
                                                       Belum ditentukan
                                                  </span>
                                             @endif
                                        </td>

                                        <td>
                                             <span class="status-badge {{ $statusData['class'] }}">
                                                  <span class="status-dot"></span>
                                                  {{ $statusData['label'] }}
                                             </span>
                                        </td>

                                        <td style="min-width: 150px;">
                                             @if ($maintenanceLog->handled_by)
                                                  <div class="d-flex align-items-center gap-2">
                                                       <i class="fas fa-user-gear text-muted"></i>

                                                       <span>
                                                            {{ $maintenanceLog->handled_by }}
                                                       </span>
                                                  </div>
                                             @else
                                                  <span class="text-muted">
                                                       Belum ditentukan
                                                  </span>
                                             @endif
                                        </td>

                                        <td>
                                             <div class="d-flex justify-content-center gap-2">

                                                  <a href="{{ route('admin.maintenance-logs.show', $maintenanceLog) }}"
                                                       class="action-button action-detail
                                               text-decoration-none"
                                                       title="Lihat detail">
                                                       <i class="fas fa-eye"></i>
                                                  </a>

                                                  <a href="{{ route('admin.maintenance-logs.edit', $maintenanceLog) }}"
                                                       class="action-button action-edit
                                               text-decoration-none"
                                                       title="Edit data">
                                                       <i class="fas fa-pen"></i>
                                                  </a>

                                                  <form action="{{ route('admin.maintenance-logs.destroy', $maintenanceLog) }}"
                                                       method="POST" class="d-inline"
                                                       onsubmit="return confirm(
                                            'Apakah Anda yakin ingin menghapus data maintenance ini?'
                                        )">
                                                       @csrf
                                                       @method('DELETE')

                                                       <button type="submit" class="action-button action-delete"
                                                            title="Hapus data">
                                                            <i class="fas fa-trash"></i>
                                                       </button>
                                                  </form>

                                             </div>
                                        </td>
                                   </tr>

                              @empty
                                   <tr>
                                        <td colspan="10">
                                             <div class="empty-state">
                                                  <div class="empty-state-icon">
                                                       <i class="fas fa-screwdriver-wrench"></i>
                                                  </div>

                                                  <h5 class="fw-bold">
                                                       Data maintenance belum tersedia
                                                  </h5>

                                                  <p class="text-muted mb-4">
                                                       Tambahkan data maintenance kendaraan
                                                       pertama Anda.
                                                  </p>

                                                  <a href="{{ route('admin.maintenance-logs.create') }}"
                                                       class="btn btn-primary rounded-3 px-4">
                                                       <i class="fas fa-plus me-2"></i>
                                                       Tambah Maintenance
                                                  </a>
                                             </div>
                                        </td>
                                   </tr>
                              @endforelse
                         </tbody>

                    </table>
               </div>

               @if ($maintenanceLogs->count() > 0)
                    <div class="pagination-wrapper">
                         <div
                              class="d-flex flex-column flex-md-row
                            justify-content-between align-items-md-center gap-3">

                              <small class="text-muted">
                                   Menampilkan
                                   <strong>{{ $maintenanceLogs->firstItem() }}</strong>
                                   sampai
                                   <strong>{{ $maintenanceLogs->lastItem() }}</strong>
                                   dari
                                   <strong>{{ $maintenanceLogs->total() }}</strong>
                                   data.
                              </small>

                              @if ($maintenanceLogs->hasPages())
                                   <div>
                                        {{ $maintenanceLogs->links() }}
                                   </div>
                              @endif
                         </div>
                    </div>
               @endif

          </div>
     </div>
@endsection
