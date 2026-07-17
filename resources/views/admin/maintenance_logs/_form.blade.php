@php
     $maintenanceTypes = [
         'routine' => [
             'label' => 'Perawatan Rutin',
             'description' => 'Servis dan perawatan berkala kendaraan.',
             'icon' => 'fa-screwdriver-wrench',
         ],
         'repair' => [
             'label' => 'Perbaikan',
             'description' => 'Perbaikan kerusakan atau komponen kendaraan.',
             'icon' => 'fa-tools',
         ],
         'inspection' => [
             'label' => 'Inspeksi',
             'description' => 'Pemeriksaan kondisi dan kelayakan kendaraan.',
             'icon' => 'fa-magnifying-glass',
         ],
         'emergency' => [
             'label' => 'Darurat',
             'description' => 'Penanganan kerusakan mendesak.',
             'icon' => 'fa-triangle-exclamation',
         ],
     ];

     $statuses = [
         'scheduled' => 'Dijadwalkan',
         'in_progress' => 'Sedang Dikerjakan',
         'completed' => 'Selesai',
         'cancelled' => 'Dibatalkan',
     ];

     $maintenanceDate = old(
         'maintenance_date',
         $maintenanceLog->maintenance_date
             ? \Carbon\Carbon::parse($maintenanceLog->maintenance_date)->format('Y-m-d')
             : now()->format('Y-m-d'),
     );

     $nextMaintenanceDate = old(
         'next_maintenance_date',
         $maintenanceLog->next_maintenance_date
             ? \Carbon\Carbon::parse($maintenanceLog->next_maintenance_date)->format('Y-m-d')
             : '',
     );
@endphp

{{-- Error validasi --}}
@if ($errors->any())
     <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">
          <div class="d-flex gap-3">
               <div class="validation-icon">
                    <i class="fas fa-circle-exclamation"></i>
               </div>

               <div class="flex-grow-1">
                    <h6 class="fw-bold mb-2">
                         Data belum dapat disimpan
                    </h6>

                    <ul class="mb-0 ps-3 small">
                         @foreach ($errors->all() as $error)
                              <li class="mb-1">
                                   {{ $error }}
                              </li>
                         @endforeach
                    </ul>
               </div>
          </div>
     </div>
@endif

<div class="form-section mb-4">
     <div class="form-section-header">
          <div class="section-icon">
               <i class="fas fa-car-side"></i>
          </div>

          <div>
               <h5 class="section-title">
                    Informasi Kendaraan
               </h5>

               <p class="section-description">
                    Pilih kendaraan dan jenis maintenance yang akan dilakukan.
               </p>
          </div>
     </div>

     <div class="row g-4">
          {{-- Kendaraan --}}
          <div class="col-lg-6">
               <label for="vehicle_id" class="modern-label">
                    Kendaraan
                    <span class="text-danger">*</span>
               </label>

               <div class="modern-input-group">
                    <span class="input-icon">
                         <i class="fas fa-car"></i>
                    </span>

                    <select name="vehicle_id" id="vehicle_id"
                         class="form-select modern-control
                           @error('vehicle_id') is-invalid @enderror"
                         required>
                         <option value="">
                              Pilih kendaraan
                         </option>

                         @forelse ($vehicles as $vehicle)
                              <option value="{{ $vehicle->id }}" @selected(old('vehicle_id', $maintenanceLog->vehicle_id) == $vehicle->id)>
                                   {{ $vehicle->plate_number ?? ($vehicle->name ?? 'Kendaraan #' . $vehicle->id) }}
                              </option>
                         @empty
                              <option value="" disabled>
                                   Data kendaraan belum tersedia
                              </option>
                         @endforelse
                    </select>
               </div>

               @error('vehicle_id')
                    <div class="invalid-message">
                         <i class="fas fa-circle-exclamation me-1"></i>
                         {{ $message }}
                    </div>
               @enderror

               <small class="field-help">
                    Pilih kendaraan yang akan dilakukan maintenance.
               </small>
          </div>

          {{-- Jenis Maintenance --}}
          <div class="col-lg-6">
               <label for="maintenance_type" class="modern-label">
                    Jenis Maintenance
                    <span class="text-danger">*</span>
               </label>

               <div class="modern-input-group">
                    <span class="input-icon">
                         <i class="fas fa-screwdriver-wrench"></i>
                    </span>

                    <select name="maintenance_type" id="maintenance_type"
                         class="form-select modern-control
                           @error('maintenance_type') is-invalid @enderror"
                         required>
                         <option value="">
                              Pilih jenis maintenance
                         </option>

                         @foreach ($maintenanceTypes as $value => $type)
                              <option value="{{ $value }}" @selected(old('maintenance_type', $maintenanceLog->maintenance_type ?? 'routine') === $value)>
                                   {{ $type['label'] }}
                              </option>
                         @endforeach
                    </select>
               </div>

               @error('maintenance_type')
                    <div class="invalid-message">
                         <i class="fas fa-circle-exclamation me-1"></i>
                         {{ $message }}
                    </div>
               @enderror

               <small class="field-help">
                    Tentukan kategori maintenance kendaraan.
               </small>
          </div>
     </div>
</div>

<div class="form-section mb-4">
     <div class="form-section-header">
          <div class="section-icon section-icon-warning">
               <i class="fas fa-calendar-days"></i>
          </div>

          <div>
               <h5 class="section-title">
                    Jadwal Maintenance
               </h5>

               <p class="section-description">
                    Tentukan tanggal pelaksanaan dan jadwal maintenance berikutnya.
               </p>
          </div>
     </div>

     <div class="row g-4">
          {{-- Tanggal maintenance --}}
          <div class="col-lg-6">
               <label for="maintenance_date" class="modern-label">
                    Tanggal Maintenance
                    <span class="text-danger">*</span>
               </label>

               <div class="modern-input-group">
                    <span class="input-icon">
                         <i class="fas fa-calendar-check"></i>
                    </span>

                    <input type="date" name="maintenance_date" id="maintenance_date" value="{{ $maintenanceDate }}"
                         class="form-control modern-control
                           @error('maintenance_date') is-invalid @enderror"
                         required>
               </div>

               @error('maintenance_date')
                    <div class="invalid-message">
                         <i class="fas fa-circle-exclamation me-1"></i>
                         {{ $message }}
                    </div>
               @enderror
          </div>

          {{-- Tanggal berikutnya --}}
          <div class="col-lg-6">
               <label for="next_maintenance_date" class="modern-label">
                    Maintenance Berikutnya
               </label>

               <div class="modern-input-group">
                    <span class="input-icon">
                         <i class="fas fa-calendar-plus"></i>
                    </span>

                    <input type="date" name="next_maintenance_date" id="next_maintenance_date"
                         value="{{ $nextMaintenanceDate }}" min="{{ $maintenanceDate }}"
                         class="form-control modern-control
                           @error('next_maintenance_date') is-invalid @enderror">
               </div>

               @error('next_maintenance_date')
                    <div class="invalid-message">
                         <i class="fas fa-circle-exclamation me-1"></i>
                         {{ $message }}
                    </div>
               @enderror

               <small class="field-help">
                    Boleh dikosongkan jika belum ditentukan.
               </small>
          </div>
     </div>
</div>

<div class="form-section mb-4">
     <div class="form-section-header">
          <div class="section-icon section-icon-success">
               <i class="fas fa-file-invoice-dollar"></i>
          </div>

          <div>
               <h5 class="section-title">
                    Biaya dan Status
               </h5>

               <p class="section-description">
                    Masukkan biaya maintenance dan status pengerjaan.
               </p>
          </div>
     </div>

     <div class="row g-4">
          {{-- Biaya --}}
          <div class="col-lg-6">
               <label for="cost" class="modern-label">
                    Biaya Maintenance
                    <span class="text-danger">*</span>
               </label>

               <div class="modern-input-group">
                    <span class="input-prefix">
                         Rp
                    </span>

                    <input type="number" name="cost" id="cost"
                         value="{{ old('cost', $maintenanceLog->cost ?? 0) }}"
                         class="form-control modern-control cost-control
                           @error('cost') is-invalid @enderror"
                         min="0" step="0.01" placeholder="0" required>
               </div>

               @error('cost')
                    <div class="invalid-message">
                         <i class="fas fa-circle-exclamation me-1"></i>
                         {{ $message }}
                    </div>
               @enderror
          </div>

          {{-- Status --}}
          <div class="col-lg-6">
               <label for="status" class="modern-label">
                    Status
                    <span class="text-danger">*</span>
               </label>

               <div class="modern-input-group">
                    <span class="input-icon">
                         <i class="fas fa-chart-line"></i>
                    </span>

                    <select name="status" id="status"
                         class="form-select modern-control
                           @error('status') is-invalid @enderror"
                         required>
                         <option value="">
                              Pilih status
                         </option>

                         @foreach ($statuses as $value => $label)
                              <option value="{{ $value }}" @selected(old('status', $maintenanceLog->status ?? 'scheduled') === $value)>
                                   {{ $label }}
                              </option>
                         @endforeach
                    </select>
               </div>

               @error('status')
                    <div class="invalid-message">
                         <i class="fas fa-circle-exclamation me-1"></i>
                         {{ $message }}
                    </div>
               @enderror
          </div>
     </div>
</div>

<div class="form-section mb-4">
     <div class="form-section-header">
          <div class="section-icon section-icon-info">
               <i class="fas fa-clipboard-list"></i>
          </div>

          <div>
               <h5 class="section-title">
                    Informasi Pekerjaan
               </h5>

               <p class="section-description">
                    Tambahkan petugas dan detail pekerjaan maintenance.
               </p>
          </div>
     </div>

     <div class="row g-4">
          {{-- Ditangani oleh --}}
          <div class="col-12">
               <label for="handled_by" class="modern-label">
                    Ditangani Oleh
               </label>

               <div class="modern-input-group">
                    <span class="input-icon">
                         <i class="fas fa-user-gear"></i>
                    </span>

                    <input type="text" name="handled_by" id="handled_by"
                         value="{{ old('handled_by', $maintenanceLog->handled_by) }}"
                         class="form-control modern-control
                           @error('handled_by') is-invalid @enderror"
                         maxlength="150" placeholder="Nama teknisi, mekanik, tim, atau bengkel">
               </div>

               @error('handled_by')
                    <div class="invalid-message">
                         <i class="fas fa-circle-exclamation me-1"></i>
                         {{ $message }}
                    </div>
               @enderror
          </div>

          {{-- Deskripsi --}}
          <div class="col-12">
               <label for="description" class="modern-label">
                    Deskripsi Maintenance
               </label>

               <textarea name="description" id="description" rows="5" maxlength="5000"
                    class="form-control modern-textarea
                       @error('description') is-invalid @enderror"
                    placeholder="Tuliskan detail pekerjaan, komponen yang diperiksa, kerusakan, atau tindakan yang dilakukan...">{{ old('description', $maintenanceLog->description) }}</textarea>

               <div class="d-flex justify-content-between mt-2">
                    @error('description')
                         <div class="invalid-message mt-0">
                              <i class="fas fa-circle-exclamation me-1"></i>
                              {{ $message }}
                         </div>
                    @else
                         <small class="field-help mt-0">
                              Berikan informasi yang jelas dan lengkap.
                         </small>
                    @enderror

                    <small class="field-help mt-0">
                         Maksimal 5.000 karakter
                    </small>
               </div>
          </div>
     </div>
</div>

{{-- Tombol aksi --}}
<div class="form-actions">
     <div class="d-flex flex-column flex-sm-row
                justify-content-between align-items-sm-center gap-3">

          <a href="{{ route('admin.maintenance-logs.index') }}" class="btn btn-back-modern">
               <i class="fas fa-arrow-left me-2"></i>
               Kembali
          </a>

          <div class="d-flex flex-column flex-sm-row gap-2">
               <button type="reset" form="{{ $formId ?? 'maintenanceForm' }}" class="btn btn-reset-modern">
                    <i class="fas fa-rotate-left me-2"></i>
                    Reset
               </button>

               <button type="submit" form="{{ $formId ?? 'maintenanceForm' }}" class="btn btn-save-modern">
                    <i class="fas fa-floppy-disk me-2"></i>
                    {{ $buttonText ?? 'Simpan Data' }}
               </button>
          </div>

     </div>
</div>

<script>
     document.addEventListener('DOMContentLoaded', function() {
          const maintenanceDate = document.getElementById(
               'maintenance_date'
          );

          const nextMaintenanceDate = document.getElementById(
               'next_maintenance_date'
          );

          if (maintenanceDate && nextMaintenanceDate) {
               maintenanceDate.addEventListener('change', function() {
                    nextMaintenanceDate.min = this.value;

                    if (
                         nextMaintenanceDate.value &&
                         nextMaintenanceDate.value < this.value
                    ) {
                         nextMaintenanceDate.value = '';
                    }
               });
          }
     });
</script>
