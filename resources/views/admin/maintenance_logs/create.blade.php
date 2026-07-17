@extends('layouts.app')

@section('title', $title ?? 'Tambah Maintenance Kendaraan')

@section('content')
     <style>
          .maintenance-create-page {
               min-height: calc(100vh - 60px);
               background:
                    radial-gradient(circle at top right,
                         rgba(99, 102, 241, 0.09),
                         transparent 28%),
                    #f6f7fb;
          }

          .modern-create-header {
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

          .modern-create-header::before {
               content: "";
               position: absolute;
               width: 250px;
               height: 250px;
               top: -135px;
               right: -55px;
               border-radius: 50%;
               background: rgba(255, 255, 255, 0.1);
          }

          .modern-create-header::after {
               content: "";
               position: absolute;
               width: 160px;
               height: 160px;
               right: 170px;
               bottom: -115px;
               border-radius: 50%;
               background: rgba(255, 255, 255, 0.07);
          }

          .modern-create-header .card-body {
               position: relative;
               z-index: 2;
          }

          .header-main-icon {
               width: 62px;
               height: 62px;
               display: inline-flex;
               flex-shrink: 0;
               align-items: center;
               justify-content: center;
               border-radius: 18px;
               color: #ffffff;
               background: rgba(255, 255, 255, 0.15);
               backdrop-filter: blur(8px);
               font-size: 23px;
          }

          .btn-header-back {
               border: 1px solid rgba(255, 255, 255, 0.35);
               border-radius: 12px;
               padding: 10px 17px;
               color: #ffffff;
               background: rgba(255, 255, 255, 0.12);
               font-weight: 600;
               backdrop-filter: blur(8px);
               transition: all 0.2s ease;
          }

          .btn-header-back:hover {
               color: #312e81;
               background: #ffffff;
               transform: translateY(-2px);
          }

          .modern-form-card {
               overflow: hidden;
               border: 0;
               border-radius: 22px;
               box-shadow: 0 12px 40px rgba(31, 41, 55, 0.08);
          }

          .modern-form-card-header {
               padding: 22px 26px;
               border-bottom: 1px solid #eef0f4;
               background: #ffffff;
          }

          .modern-form-card-body {
               padding: 26px;
               background: #ffffff;
          }

          .form-section {
               padding: 24px;
               border: 1px solid #eef0f4;
               border-radius: 17px;
               background: #ffffff;
               transition: border-color 0.2s ease,
                    box-shadow 0.2s ease;
          }

          .form-section:hover {
               border-color: #dfe3ff;
               box-shadow: 0 8px 25px rgba(79, 70, 229, 0.05);
          }

          .form-section-header {
               display: flex;
               gap: 14px;
               align-items: center;
               margin-bottom: 22px;
               padding-bottom: 17px;
               border-bottom: 1px solid #f0f2f6;
          }

          .section-icon {
               width: 46px;
               height: 46px;
               display: inline-flex;
               flex-shrink: 0;
               align-items: center;
               justify-content: center;
               border-radius: 14px;
               color: #4f46e5;
               background: #eef2ff;
          }

          .section-icon-warning {
               color: #d97706;
               background: #fffbeb;
          }

          .section-icon-success {
               color: #059669;
               background: #ecfdf5;
          }

          .section-icon-info {
               color: #0284c7;
               background: #f0f9ff;
          }

          .section-title {
               margin-bottom: 3px;
               color: #1f2937;
               font-size: 16px;
               font-weight: 700;
          }

          .section-description {
               margin-bottom: 0;
               color: #6b7280;
               font-size: 13px;
          }

          .modern-label {
               display: block;
               margin-bottom: 8px;
               color: #374151;
               font-size: 14px;
               font-weight: 600;
          }

          .modern-input-group {
               position: relative;
          }

          .input-icon {
               position: absolute;
               z-index: 5;
               top: 50%;
               left: 15px;
               color: #9ca3af;
               transform: translateY(-50%);
               pointer-events: none;
          }

          .modern-control {
               min-height: 49px;
               padding-left: 44px;
               border: 1px solid #e5e7eb;
               border-radius: 12px;
               color: #374151;
               background-color: #ffffff;
          }

          select.modern-control {
               padding-left: 44px;
          }

          .modern-control:focus,
          .modern-textarea:focus {
               border-color: #818cf8;
               box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.13);
          }

          .modern-control.is-invalid,
          .modern-textarea.is-invalid {
               border-color: #ef4444;
               background-image: none;
          }

          .input-prefix {
               position: absolute;
               z-index: 5;
               top: 50%;
               left: 14px;
               color: #4f46e5;
               font-weight: 700;
               transform: translateY(-50%);
          }

          .cost-control {
               padding-left: 48px;
          }

          .modern-textarea {
               width: 100%;
               padding: 14px 16px;
               border: 1px solid #e5e7eb;
               border-radius: 12px;
               color: #374151;
               resize: vertical;
          }

          .field-help {
               display: block;
               margin-top: 7px;
               color: #9ca3af;
               font-size: 12px;
          }

          .invalid-message {
               margin-top: 7px;
               color: #dc2626;
               font-size: 12px;
          }

          .validation-icon {
               width: 38px;
               height: 38px;
               display: inline-flex;
               flex-shrink: 0;
               align-items: center;
               justify-content: center;
               border-radius: 12px;
               color: #dc2626;
               background: rgba(220, 38, 38, 0.1);
          }

          .form-actions {
               margin-top: 28px;
               padding-top: 23px;
               border-top: 1px solid #eef0f4;
          }

          .btn-back-modern,
          .btn-reset-modern,
          .btn-save-modern {
               min-height: 44px;
               border-radius: 11px;
               padding: 10px 18px;
               font-weight: 600;
          }

          .btn-back-modern {
               border: 1px solid #e5e7eb;
               color: #4b5563;
               background: #ffffff;
          }

          .btn-back-modern:hover {
               color: #374151;
               background: #f9fafb;
          }

          .btn-reset-modern {
               border: 1px solid #d1d5db;
               color: #4b5563;
               background: #ffffff;
          }

          .btn-reset-modern:hover {
               color: #1f2937;
               background: #f3f4f6;
          }

          .btn-save-modern {
               border: 0;
               color: #ffffff;
               background: linear-gradient(135deg,
                         #4f46e5,
                         #7c3aed);
               box-shadow: 0 8px 20px rgba(79, 70, 229, 0.24);
               transition: all 0.2s ease;
          }

          .btn-save-modern:hover {
               color: #ffffff;
               background: linear-gradient(135deg,
                         #4338ca,
                         #6d28d9);
               transform: translateY(-2px);
          }

          .information-box {
               padding: 18px;
               border: 1px solid #dbeafe;
               border-radius: 15px;
               color: #1e40af;
               background: #eff6ff;
          }

          @media (max-width: 767.98px) {

               .modern-create-header,
               .modern-form-card {
                    border-radius: 17px;
               }

               .modern-create-header .card-body,
               .modern-form-card-body {
                    padding: 20px;
               }

               .form-section {
                    padding: 18px;
               }

               .btn-header-back {
                    width: 100%;
               }

               .btn-back-modern,
               .btn-reset-modern,
               .btn-save-modern {
                    width: 100%;
               }
          }
     </style>

     <div class="container-fluid maintenance-create-page py-4">

          {{-- Breadcrumb --}}
          <nav aria-label="breadcrumb" class="mb-3">
               <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                         <a href="{{ route('admin.maintenance-logs.index') }}" class="text-decoration-none">
                              Maintenance
                         </a>
                    </li>

                    <li class="breadcrumb-item active" aria-current="page">
                         Tambah Data
                    </li>
               </ol>
          </nav>

          {{-- Header --}}
          <div class="card modern-create-header mb-4">
               <div class="card-body p-4 p-lg-5">

                    <div
                         class="d-flex flex-column flex-lg-row
                        justify-content-between align-items-lg-center gap-4">

                         <div class="d-flex align-items-start gap-3">
                              <div class="header-main-icon">
                                   <i class="fas fa-screwdriver-wrench"></i>
                              </div>

                              <div>
                                   <span class="badge bg-white bg-opacity-25 mb-2">
                                        Form Maintenance
                                   </span>

                                   <h2 class="text-white fw-bold mb-2">
                                        {{ $title ?? 'Tambah Maintenance Kendaraan' }}
                                   </h2>

                                   <p class="text-white text-opacity-75 mb-0">
                                        Lengkapi informasi maintenance kendaraan
                                        dengan benar dan menyeluruh.
                                   </p>
                              </div>
                         </div>

                         <a href="{{ route('admin.maintenance-logs.index') }}" class="btn btn-header-back">
                              <i class="fas fa-arrow-left me-2"></i>
                              Kembali
                         </a>
                    </div>

               </div>
          </div>

          <div class="row g-4">
               {{-- Form utama --}}
               <div class="col-xl-9">
                    <div class="card modern-form-card">

                         <div class="modern-form-card-header">
                              <div class="d-flex align-items-center gap-3">
                                   <div class="section-icon">
                                        <i class="fas fa-pen-to-square"></i>
                                   </div>

                                   <div>
                                        <h5 class="fw-bold mb-1">
                                             Form Data Maintenance
                                        </h5>

                                        <p class="text-muted small mb-0">
                                             Kolom dengan tanda
                                             <span class="text-danger">*</span>
                                             wajib diisi.
                                        </p>
                                   </div>
                              </div>
                         </div>

                         <div class="modern-form-card-body">
                              <form id="maintenanceForm"
                                   action="{{ route('admin.maintenance-logs.store') }}"
                                   method="POST">
                                   @csrf

                                   @include('admin.maintenance_logs._form', [
                                       'buttonText' => 'Simpan Maintenance',
                                       'formId' => 'maintenanceForm',
                                   ])
                              </form>
                         </div>

                    </div>
               </div>

               {{-- Informasi samping --}}
               <div class="col-xl-3">
                    <div class="card modern-form-card sticky-xl-top" style="top: 20px;">

                         <div class="modern-form-card-header">
                              <h6 class="fw-bold mb-0">
                                   <i class="fas fa-circle-info text-primary me-2"></i>
                                   Panduan Pengisian
                              </h6>
                         </div>

                         <div class="modern-form-card-body">
                              <div class="information-box mb-4">
                                   <div class="d-flex gap-3">
                                        <i class="fas fa-lightbulb mt-1"></i>

                                        <small>
                                             Pastikan kendaraan sudah tersedia pada
                                             data master kendaraan.
                                        </small>
                                   </div>
                              </div>

                              <div class="d-flex gap-3 mb-4">
                                   <div class="section-icon flex-shrink-0">
                                        <i class="fas fa-car"></i>
                                   </div>

                                   <div>
                                        <h6 class="fw-semibold mb-1">
                                             Kendaraan
                                        </h6>

                                        <small class="text-muted">
                                             Pilih kendaraan yang sedang atau akan
                                             dilakukan maintenance.
                                        </small>
                                   </div>
                              </div>

                              <div class="d-flex gap-3 mb-4">
                                   <div
                                        class="section-icon section-icon-warning
                                    flex-shrink-0">
                                        <i class="fas fa-calendar-days"></i>
                                   </div>

                                   <div>
                                        <h6 class="fw-semibold mb-1">
                                             Jadwal
                                        </h6>

                                        <small class="text-muted">
                                             Jadwal berikutnya tidak boleh lebih awal
                                             dari tanggal maintenance.
                                        </small>
                                   </div>
                              </div>

                              <div class="d-flex gap-3">
                                   <div
                                        class="section-icon section-icon-success
                                    flex-shrink-0">
                                        <i class="fas fa-floppy-disk"></i>
                                   </div>

                                   <div>
                                        <h6 class="fw-semibold mb-1">
                                             Simpan Data
                                        </h6>

                                        <small class="text-muted">
                                             Periksa kembali data sebelum menekan
                                             tombol Simpan Maintenance.
                                        </small>
                                   </div>
                              </div>
                         </div>

                    </div>
               </div>
          </div>

     </div>
@endsection
