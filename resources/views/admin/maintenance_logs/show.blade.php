@extends('layouts.app')

@section('title', $title ?? 'Detail Maintenance Kendaraan')

@section('content')
     @php
          /*
    |--------------------------------------------------------------------------
    | Nilai mentah database
    |--------------------------------------------------------------------------
    | getRawOriginal digunakan agar tetap aman apabila model memakai enum cast.
    */
          $currentMaintenanceType =
              $maintenanceLog->getRawOriginal('maintenance_type') ?? ($maintenanceLog->maintenance_type ?? 'routine');

          $currentStatus = $maintenanceLog->getRawOriginal('status') ?? ($maintenanceLog->status ?? 'scheduled');

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
                  'icon' => 'fa-calendar-days',
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

          $typeData = $maintenanceTypes[$currentMaintenanceType] ?? [
              'label' => ucfirst(str_replace('_', ' ', $currentMaintenanceType)),
              'class' => 'type-default',
              'icon' => 'fa-wrench',
          ];

          $statusData = $statuses[$currentStatus] ?? [
              'label' => ucfirst(str_replace('_', ' ', $currentStatus)),
              'class' => 'status-default',
              'icon' => 'fa-circle-info',
          ];

          $vehicleName =
              $maintenanceLog->vehicle?->plate_number ??
              ($maintenanceLog->vehicle?->name ?? 'Kendaraan #' . $maintenanceLog->vehicle_id);

          $maintenanceDate = $maintenanceLog->maintenance_date
              ? \Carbon\Carbon::parse($maintenanceLog->maintenance_date)->translatedFormat('d F Y')
              : '-';

          $nextMaintenanceDate = $maintenanceLog->next_maintenance_date
              ? \Carbon\Carbon::parse($maintenanceLog->next_maintenance_date)->translatedFormat('d F Y')
              : null;

          $createdDate = $maintenanceLog->created_at
              ? $maintenanceLog->created_at->translatedFormat('d F Y, H:i')
              : '-';

          $updatedDate = $maintenanceLog->updated_at
              ? $maintenanceLog->updated_at->translatedFormat('d F Y, H:i')
              : '-';
     @endphp

     <style>
          .maintenance-show-page {
               min-height: calc(100vh - 60px);
               background:
                    radial-gradient(circle at top right,
                         rgba(99, 102, 241, 0.10),
                         transparent 30%),
                    #f6f7fb;
          }

          .detail-hero {
               position: relative;
               overflow: hidden;
               border: 0;
               border-radius: 22px;
               background: linear-gradient(135deg,
                         #312e81 0%,
                         #4f46e5 50%,
                         #7c3aed 100%);
               box-shadow: 0 18px 45px rgba(79, 70, 229, 0.22);
          }

          .detail-hero::before {
               content: "";
               position: absolute;
               width: 270px;
               height: 270px;
               top: -145px;
               right: -65px;
               border-radius: 50%;
               background: rgba(255, 255, 255, 0.10);
          }

          .detail-hero::after {
               content: "";
               position: absolute;
               width: 180px;
               height: 180px;
               right: 185px;
               bottom: -130px;
               border-radius: 50%;
               background: rgba(255, 255, 255, 0.07);
          }

          .detail-hero .card-body {
               position: relative;
               z-index: 2;
          }

          .hero-main-icon {
               width: 64px;
               height: 64px;
               display: inline-flex;
               flex-shrink: 0;
               align-items: center;
               justify-content: center;
               border-radius: 19px;
               color: #ffffff;
               background: rgba(255, 255, 255, 0.16);
               backdrop-filter: blur(8px);
               font-size: 24px;
          }

          .hero-action {
               min-height: 44px;
               border-radius: 12px;
               padding: 10px 17px;
               font-weight: 600;
               transition: all 0.2s ease;
          }

          .hero-action-light {
               border: 1px solid rgba(255, 255, 255, 0.35);
               color: #ffffff;
               background: rgba(255, 255, 255, 0.12);
               backdrop-filter: blur(8px);
          }

          .hero-action-light:hover {
               color: #312e81;
               background: #ffffff;
               transform: translateY(-2px);
          }

          .hero-action-edit {
               border: 0;
               color: #312e81;
               background: #ffffff;
               box-shadow: 0 8px 22px rgba(31, 41, 55, 0.16);
          }

          .hero-action-edit:hover {
               color: #312e81;
               background: #f8fafc;
               transform: translateY(-2px);
          }

          .hero-action-delete {
               border: 1px solid rgba(255, 255, 255, 0.35);
               color: #ffffff;
               background: rgba(220, 38, 38, 0.65);
          }

          .hero-action-delete:hover {
               color: #ffffff;
               background: #dc2626;
               transform: translateY(-2px);
          }

          .summary-card,
          .modern-detail-card {
               border: 0;
               border-radius: 18px;
               box-shadow: 0 9px 30px rgba(31, 41, 55, 0.07);
          }

          .summary-card {
               transition:
                    transform 0.2s ease,
                    box-shadow 0.2s ease;
          }

          .summary-card:hover {
               transform: translateY(-3px);
               box-shadow: 0 14px 35px rgba(31, 41, 55, 0.10);
          }

          .summary-icon {
               width: 49px;
               height: 49px;
               display: inline-flex;
               flex-shrink: 0;
               align-items: center;
               justify-content: center;
               border-radius: 15px;
          }

          .summary-icon-primary {
               color: #4f46e5;
               background: #eef2ff;
          }

          .summary-icon-success {
               color: #059669;
               background: #ecfdf5;
          }

          .summary-icon-warning {
               color: #d97706;
               background: #fffbeb;
          }

          .summary-icon-info {
               color: #0284c7;
               background: #f0f9ff;
          }

          .type-modern,
          .status-modern {
               display: inline-flex;
               gap: 7px;
               align-items: center;
               border-radius: 999px;
               padding: 8px 13px;
               font-size: 12px;
               font-weight: 700;
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

          .type-default {
               color: #475569;
               background: #f1f5f9;
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

          .status-default {
               color: #475569;
               background: #f1f5f9;
          }

          .status-dot {
               width: 7px;
               height: 7px;
               border-radius: 50%;
               background: currentColor;
          }

          .detail-card-header {
               padding: 21px 24px;
               border-bottom: 1px solid #eef0f4;
               background: #ffffff;
          }

          .detail-card-body {
               padding: 24px;
          }

          .detail-item {
               height: 100%;
               padding: 18px;
               border: 1px solid #eef0f4;
               border-radius: 15px;
               background: #fafbff;
          }

          .detail-item-icon {
               width: 45px;
               height: 45px;
               display: inline-flex;
               flex-shrink: 0;
               align-items: center;
               justify-content: center;
               border-radius: 14px;
          }

          .detail-icon-primary {
               color: #4f46e5;
               background: #eef2ff;
          }

          .detail-icon-warning {
               color: #d97706;
               background: #fffbeb;
          }

          .detail-icon-info {
               color: #0284c7;
               background: #f0f9ff;
          }

          .detail-icon-secondary {
               color: #475569;
               background: #f1f5f9;
          }

          .description-box {
               padding: 22px;
               border: 1px solid #e8eaf0;
               border-radius: 16px;
               background: #ffffff;
          }

          .description-content {
               margin-bottom: 0;
               color: #4b5563;
               line-height: 1.75;
               white-space: pre-line;
          }

          .timeline {
               position: relative;
          }

          .timeline::before {
               content: "";
               position: absolute;
               top: 12px;
               bottom: 12px;
               left: 20px;
               width: 2px;
               background: #e5e7eb;
          }

          .timeline-item {
               position: relative;
               display: flex;
               gap: 15px;
               padding-bottom: 25px;
          }

          .timeline-item:last-child {
               padding-bottom: 0;
          }

          .timeline-icon {
               position: relative;
               z-index: 2;
               width: 41px;
               height: 41px;
               display: inline-flex;
               flex-shrink: 0;
               align-items: center;
               justify-content: center;
               border-radius: 50%;
               color: #4f46e5;
               background: #eef2ff;
               border: 5px solid #ffffff;
          }

          .quick-info {
               padding: 17px;
               border: 1px solid #dbeafe;
               border-radius: 15px;
               color: #1e40af;
               background: #eff6ff;
          }

          .danger-zone {
               padding: 18px;
               border: 1px solid #fecaca;
               border-radius: 15px;
               background: #fef2f2;
          }

          .danger-zone .btn {
               border-radius: 11px;
          }

          @media (max-width: 767.98px) {

               .detail-hero,
               .summary-card,
               .modern-detail-card {
                    border-radius: 17px;
               }

               .detail-hero .card-body,
               .detail-card-body {
                    padding: 20px;
               }

               .hero-action {
                    width: 100%;
               }
          }
     </style>

     <div class="container-fluid maintenance-show-page py-4">

          {{-- Breadcrumb --}}
          <nav aria-label="breadcrumb" class="mb-3">
               <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                         <a href="{{ route('admin.maintenance-logs.index') }}" class="text-decoration-none">
                              Maintenance
                         </a>
                    </li>

                    <li class="breadcrumb-item active" aria-current="page">
                         Detail #{{ $maintenanceLog->id }}
                    </li>
               </ol>
          </nav>

          {{-- Flash message --}}
          @if (session('success'))
               <div class="alert alert-success border-0 rounded-4 shadow-sm">
                    <div class="d-flex align-items-center gap-2">
                         <i class="fas fa-circle-check"></i>
                         <span>{{ session('success') }}</span>
                    </div>
               </div>
          @endif

          @if (session('error'))
               <div class="alert alert-danger border-0 rounded-4 shadow-sm">
                    <div class="d-flex align-items-center gap-2">
                         <i class="fas fa-circle-exclamation"></i>
                         <span>{{ session('error') }}</span>
                    </div>
               </div>
          @endif

          {{-- Header --}}
          <div class="card detail-hero mb-4">
               <div class="card-body p-4 p-lg-5">
                    <div
                         class="d-flex flex-column flex-xl-row
                        justify-content-between align-items-xl-center gap-4">

                         <div class="d-flex align-items-start gap-3">
                              <div class="hero-main-icon">
                                   <i class="fas fa-car-side"></i>
                              </div>

                              <div>
                                   <div class="d-flex flex-wrap gap-2 mb-2">
                                        <span class="badge bg-white bg-opacity-25">
                                             Detail Maintenance
                                        </span>

                                        <span class="badge bg-white text-primary">
                                             #{{ $maintenanceLog->id }}
                                        </span>
                                   </div>

                                   <h2 class="text-white fw-bold mb-2">
                                        {{ $vehicleName }}
                                   </h2>

                                   <p class="text-white text-opacity-75 mb-0">
                                        {{ $title ?? 'Detail Maintenance Kendaraan' }}
                                   </p>
                              </div>
                         </div>

                         <div class="d-flex flex-column flex-sm-row gap-2">
                              <a href="{{ route('admin.maintenance-logs.index') }}"
                                   class="btn hero-action hero-action-light">
                                   <i class="fas fa-arrow-left me-2"></i>
                                   Kembali
                              </a>

                              <a href="{{ route('admin.maintenance-logs.edit', $maintenanceLog) }}"
                                   class="btn hero-action hero-action-edit">
                                   <i class="fas fa-pen-to-square me-2"></i>
                                   Edit Data
                              </a>

                              <form action="{{ route('admin.maintenance-logs.destroy', $maintenanceLog) }}"
                                   method="POST"
                                   onsubmit="return confirm(
                            'Apakah Anda yakin ingin menghapus data maintenance ini?'
                        )">
                                   @csrf
                                   @method('DELETE')

                                   <button type="submit" class="btn hero-action hero-action-delete w-100">
                                        <i class="fas fa-trash me-2"></i>
                                        Hapus
                                   </button>
                              </form>
                         </div>

                    </div>
               </div>
          </div>

          {{-- Ringkasan --}}
          <div class="row g-3 mb-4">

               {{-- Kendaraan --}}
               <div class="col-md-6 col-xl-3">
                    <div class="card summary-card h-100">
                         <div class="card-body">
                              <div class="d-flex justify-content-between gap-3">
                                   <div>
                                        <small class="text-muted fw-semibold">
                                             KENDARAAN
                                        </small>

                                        <h5 class="fw-bold mt-2 mb-1">
                                             {{ $vehicleName }}
                                        </h5>

                                        <small class="text-muted">
                                             ID: {{ $maintenanceLog->vehicle_id }}
                                        </small>
                                   </div>

                                   <div class="summary-icon summary-icon-primary">
                                        <i class="fas fa-car"></i>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

               {{-- Jenis --}}
               <div class="col-md-6 col-xl-3">
                    <div class="card summary-card h-100">
                         <div class="card-body">
                              <small class="text-muted fw-semibold">
                                   JENIS MAINTENANCE
                              </small>

                              <div class="mt-3">
                                   <span class="type-modern {{ $typeData['class'] }}">
                                        <i class="fas {{ $typeData['icon'] }}"></i>
                                        {{ $typeData['label'] }}
                                   </span>
                              </div>
                         </div>
                    </div>
               </div>

               {{-- Status --}}
               <div class="col-md-6 col-xl-3">
                    <div class="card summary-card h-100">
                         <div class="card-body">
                              <small class="text-muted fw-semibold">
                                   STATUS
                              </small>

                              <div class="mt-3">
                                   <span class="status-modern {{ $statusData['class'] }}">
                                        <span class="status-dot"></span>
                                        {{ $statusData['label'] }}
                                   </span>
                              </div>
                         </div>
                    </div>
               </div>

               {{-- Biaya --}}
               <div class="col-md-6 col-xl-3">
                    <div class="card summary-card h-100">
                         <div class="card-body">
                              <div class="d-flex justify-content-between gap-3">
                                   <div>
                                        <small class="text-muted fw-semibold">
                                             TOTAL BIAYA
                                        </small>

                                        <h5 class="fw-bold text-success mt-2 mb-0">
                                             Rp
                                             {{ number_format((float) $maintenanceLog->cost, 0, ',', '.') }}
                                        </h5>
                                   </div>

                                   <div class="summary-icon summary-icon-success">
                                        <i class="fas fa-wallet"></i>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

          </div>

          <div class="row g-4">

               {{-- Informasi utama --}}
               <div class="col-xl-8">
                    <div class="card modern-detail-card h-100">

                         <div class="detail-card-header">
                              <div class="d-flex align-items-center gap-3">
                                   <div class="summary-icon summary-icon-primary">
                                        <i class="fas fa-circle-info"></i>
                                   </div>

                                   <div>
                                        <h5 class="fw-bold mb-1">
                                             Informasi Maintenance
                                        </h5>

                                        <small class="text-muted">
                                             Informasi lengkap pekerjaan maintenance kendaraan.
                                        </small>
                                   </div>
                              </div>
                         </div>

                         <div class="detail-card-body">
                              <div class="row g-3 mb-4">

                                   {{-- Tanggal maintenance --}}
                                   <div class="col-md-6">
                                        <div class="detail-item">
                                             <div class="d-flex align-items-center gap-3">
                                                  <div class="detail-item-icon detail-icon-primary">
                                                       <i class="fas fa-calendar-check"></i>
                                                  </div>

                                                  <div>
                                                       <small class="text-muted">
                                                            Tanggal Maintenance
                                                       </small>

                                                       <div class="fw-bold mt-1">
                                                            {{ $maintenanceDate }}
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>

                                   {{-- Maintenance berikutnya --}}
                                   <div class="col-md-6">
                                        <div class="detail-item">
                                             <div class="d-flex align-items-center gap-3">
                                                  <div class="detail-item-icon detail-icon-warning">
                                                       <i class="fas fa-calendar-plus"></i>
                                                  </div>

                                                  <div>
                                                       <small class="text-muted">
                                                            Maintenance Berikutnya
                                                       </small>

                                                       <div class="fw-bold mt-1">
                                                            @if ($nextMaintenanceDate)
                                                                 {{ $nextMaintenanceDate }}
                                                            @else
                                                                 <span class="text-muted fw-normal">
                                                                      Belum ditentukan
                                                                 </span>
                                                            @endif
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>

                                   {{-- Ditangani oleh --}}
                                   <div class="col-md-6">
                                        <div class="detail-item">
                                             <div class="d-flex align-items-center gap-3">
                                                  <div class="detail-item-icon detail-icon-info">
                                                       <i class="fas fa-user-gear"></i>
                                                  </div>

                                                  <div>
                                                       <small class="text-muted">
                                                            Ditangani Oleh
                                                       </small>

                                                       <div class="fw-bold mt-1">
                                                            {{ $maintenanceLog->handled_by ?? 'Belum ditentukan' }}
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>

                                   {{-- ID maintenance --}}
                                   <div class="col-md-6">
                                        <div class="detail-item">
                                             <div class="d-flex align-items-center gap-3">
                                                  <div class="detail-item-icon detail-icon-secondary">
                                                       <i class="fas fa-hashtag"></i>
                                                  </div>

                                                  <div>
                                                       <small class="text-muted">
                                                            ID Maintenance
                                                       </small>

                                                       <div class="fw-bold mt-1">
                                                            #{{ $maintenanceLog->id }}
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>

                              </div>

                              {{-- Deskripsi --}}
                              <div class="description-box">
                                   <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="detail-item-icon detail-icon-primary">
                                             <i class="fas fa-align-left"></i>
                                        </div>

                                        <div>
                                             <h6 class="fw-bold mb-1">
                                                  Deskripsi Maintenance
                                             </h6>

                                             <small class="text-muted">
                                                  Catatan pekerjaan dan tindakan maintenance.
                                             </small>
                                        </div>
                                   </div>

                                   <p class="description-content">
                                        {{ $maintenanceLog->description ?: 'Tidak ada deskripsi maintenance.' }}
                                   </p>
                              </div>

                         </div>
                    </div>
               </div>

               {{-- Informasi sistem --}}
               <div class="col-xl-4">
                    <div class="card modern-detail-card mb-4">

                         <div class="detail-card-header">
                              <h5 class="fw-bold mb-0">
                                   <i
                                        class="fas fa-clock-rotate-left
                                  text-primary me-2"></i>
                                   Informasi Sistem
                              </h5>
                         </div>

                         <div class="detail-card-body">
                              <div class="timeline">

                                   <div class="timeline-item">
                                        <div class="timeline-icon">
                                             <i class="fas fa-calendar-plus"></i>
                                        </div>

                                        <div>
                                             <small class="text-muted d-block">
                                                  Data Dibuat
                                             </small>

                                             <span class="fw-semibold">
                                                  {{ $createdDate }}
                                             </span>
                                        </div>
                                   </div>

                                   <div class="timeline-item">
                                        <div class="timeline-icon">
                                             <i class="fas fa-pen-to-square"></i>
                                        </div>

                                        <div>
                                             <small class="text-muted d-block">
                                                  Terakhir Diperbarui
                                             </small>

                                             <span class="fw-semibold">
                                                  {{ $updatedDate }}
                                             </span>
                                        </div>
                                   </div>

                              </div>
                         </div>
                    </div>

                    {{-- Informasi tambahan --}}
                    <div class="card modern-detail-card mb-4">
                         <div class="detail-card-body">
                              <div class="quick-info">
                                   <div class="d-flex gap-3">
                                        <i class="fas fa-lightbulb mt-1"></i>

                                        <div>
                                             <h6 class="fw-bold mb-1">
                                                  Informasi
                                             </h6>

                                             <small>
                                                  Gunakan tombol Edit Data untuk memperbarui
                                                  status, biaya, jadwal, atau deskripsi
                                                  maintenance.
                                             </small>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>

                    {{-- Aksi --}}
                    <div class="card modern-detail-card">
                         <div class="detail-card-body">
                              <h6 class="fw-bold mb-3">
                                   Aksi Data
                              </h6>

                              <div class="d-grid gap-2">
                                   <a href="{{ route('admin.maintenance-logs.edit', $maintenanceLog) }}"
                                        class="btn btn-primary rounded-3">
                                        <i class="fas fa-pen-to-square me-2"></i>
                                        Edit Maintenance
                                   </a>

                                   <a href="{{ route('admin.maintenance-logs.index') }}"
                                        class="btn btn-outline-secondary rounded-3">
                                        <i class="fas fa-list me-2"></i>
                                        Lihat Semua Data
                                   </a>
                              </div>

                              <div class="danger-zone mt-4">
                                   <h6 class="fw-bold text-danger mb-2">
                                        Hapus Data
                                   </h6>

                                   <p class="small text-muted mb-3">
                                        Data yang dihapus tidak dapat dikembalikan.
                                   </p>

                                   <form action="{{ route('admin.maintenance-logs.destroy', $maintenanceLog) }}"
                                        method="POST"
                                        onsubmit="return confirm(
                                'Apakah Anda yakin ingin menghapus data maintenance ini?'
                            )">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-outline-danger w-100">
                                             <i class="fas fa-trash me-2"></i>
                                             Hapus Maintenance
                                        </button>
                                   </form>
                              </div>
                         </div>
                    </div>

               </div>
          </div>

     </div>
@endsection
