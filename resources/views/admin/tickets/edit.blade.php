@extends('layouts.app')

@section('title', $title ?? 'Edit Tiket')

@section('content')
     @php
          $paymentMethods = $paymentMethods ?? ['cash', 'emoney', 'qris', 'card', 'other'];

          $ticketStatuses = $ticketStatuses ?? ['paid', 'refunded', 'failed'];

          $paymentLabels = [
              'cash' => 'Tunai',
              'emoney' => 'E-Money',
              'qris' => 'QRIS',
              'card' => 'Kartu Debit/Kredit',
              'other' => 'Lainnya',
          ];

          $statusLabels = [
              'paid' => 'Dibayar',
              'refunded' => 'Dikembalikan',
              'failed' => 'Gagal',
          ];

          $issuedAtValue = old('issued_at');

          if ($issuedAtValue === null && $ticket->issued_at) {
              $issuedAtValue = \Illuminate\Support\Carbon::parse($ticket->issued_at)->format('Y-m-d\TH:i');
          }
     @endphp

     <div class="ticket-edit-page">
          <div class="ticket-edit-container">

               {{-- Header --}}
               <section class="page-header">
                    <div class="page-header-content">
                         <div>
                              <div class="header-label">
                                   <span></span>
                                   Manajemen Transportasi
                              </div>

                              <h1>Edit Tiket</h1>

                              <p>
                                   Perbarui informasi tiket
                                   <strong>{{ $ticket->ticket_code }}</strong>,
                                   termasuk perjalanan, pembayaran, tarif,
                                   dan status tiket.
                              </p>
                         </div>

                         <div class="header-actions">
                              <a href="{{ route('admin.tickets.show', $ticket) }}" class="detail-button">
                                   <i class="bi bi-eye"></i>
                                   Detail
                              </a>

                              <a href="{{ route('admin.tickets.index') }}" class="back-button">
                                   <i class="bi bi-arrow-left"></i>
                                   Kembali
                              </a>
                         </div>
                    </div>

                    <div class="header-decoration decoration-one"></div>
                    <div class="header-decoration decoration-two"></div>
               </section>

               {{-- Error validasi --}}
               @if ($errors->any())
                    <div class="form-alert">
                         <div class="form-alert-icon">
                              <i class="bi bi-exclamation-triangle"></i>
                         </div>

                         <div>
                              <strong>Data belum dapat diperbarui</strong>

                              <ul>
                                   @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                   @endforeach
                              </ul>
                         </div>
                    </div>
               @endif

               <form action="{{ route('admin.tickets.update', $ticket) }}" method="POST" class="ticket-form"
                    id="ticketEditForm">
                    @csrf
                    @method('PUT')

                    <div class="form-card">
                         <header class="form-card-header">
                              <div class="form-header-icon">
                                   <i class="bi bi-pencil-square"></i>
                              </div>

                              <div>
                                   <span>Formulir Edit</span>

                                   <h2>Perbarui Informasi Tiket</h2>

                                   <p>
                                        ID tiket #{{ $ticket->id }}.
                                        Kolom bertanda bintang wajib diisi.
                                   </p>
                              </div>
                         </header>

                         <div class="form-card-body">

                              {{-- Informasi utama --}}
                              <section class="form-section">
                                   <div class="section-heading">
                                        <span class="section-number">01</span>

                                        <div>
                                             <h3>Informasi Utama</h3>

                                             <p>
                                                  Perbarui kode dan waktu penerbitan tiket.
                                             </p>
                                        </div>
                                   </div>

                                   <div class="form-grid">
                                        {{-- Kode tiket --}}
                                        <div class="form-group">
                                             <label for="ticket_code">
                                                  Kode Tiket
                                                  <span class="required">*</span>
                                             </label>

                                             <div class="input-wrapper">
                                                  <i class="bi bi-upc-scan"></i>

                                                  <input type="text" id="ticket_code" name="ticket_code"
                                                       value="{{ old('ticket_code', $ticket->ticket_code) }}" maxlength="100"
                                                       placeholder="Contoh: TKT-20260714-001"
                                                       class="@error('ticket_code') input-error @enderror" required
                                                       autofocus>
                                             </div>

                                             @error('ticket_code')
                                                  <small class="error-message">
                                                       <i class="bi bi-exclamation-circle"></i>
                                                       {{ $message }}
                                                  </small>
                                             @enderror
                                        </div>

                                        {{-- Waktu diterbitkan --}}
                                        <div class="form-group">
                                             <label for="issued_at">
                                                  Waktu Diterbitkan
                                                  <span class="required">*</span>
                                             </label>

                                             <div class="input-wrapper">
                                                  <i class="bi bi-calendar3"></i>

                                                  <input type="datetime-local" id="issued_at" name="issued_at"
                                                       value="{{ $issuedAtValue }}"
                                                       class="@error('issued_at') input-error @enderror" required>
                                             </div>

                                             @error('issued_at')
                                                  <small class="error-message">
                                                       <i class="bi bi-exclamation-circle"></i>
                                                       {{ $message }}
                                                  </small>
                                             @enderror
                                        </div>
                                   </div>
                              </section>

                              {{-- Informasi perjalanan --}}
                              <section class="form-section">
                                   <div class="section-heading">
                                        <span class="section-number">02</span>

                                        <div>
                                             <h3>Informasi Perjalanan</h3>

                                             <p>
                                                  Pilih perjalanan, rute, dan kendaraan
                                                  yang terhubung dengan tiket.
                                             </p>
                                        </div>
                                   </div>

                                   <div class="form-grid form-grid-three">
                                        {{-- Trip --}}
                                        <div class="form-group">
                                             <label for="trip_id">
                                                  Perjalanan
                                             </label>

                                             <div class="select-wrapper">
                                                  <i class="bi bi-signpost"></i>

                                                  <select id="trip_id" name="trip_id"
                                                       class="@error('trip_id') input-error @enderror">
                                                       <option value="">
                                                            Tidak dipilih
                                                       </option>

                                                       @foreach ($trips ?? [] as $trip)
                                                            @php
                                                                 $tripName =
                                                                     data_get($trip, 'trip_code') ??
                                                                     (data_get($trip, 'code') ??
                                                                         (data_get($trip, 'name') ??
                                                                             'Perjalanan #' . $trip->id));
                                                            @endphp

                                                            <option value="{{ $trip->id }}"
                                                                 @selected((string) old('trip_id', $ticket->trip_id) === (string) $trip->id)>
                                                                 {{ $tripName }}
                                                            </option>
                                                       @endforeach
                                                  </select>
                                             </div>

                                             @error('trip_id')
                                                  <small class="error-message">
                                                       <i class="bi bi-exclamation-circle"></i>
                                                       {{ $message }}
                                                  </small>
                                             @enderror
                                        </div>

                                        {{-- Rute --}}
                                        <div class="form-group">
                                             <label for="route_id">
                                                  Rute
                                             </label>

                                             <div class="select-wrapper">
                                                  <i class="bi bi-signpost-split"></i>

                                                  <select id="route_id" name="route_id"
                                                       class="@error('route_id') input-error @enderror">
                                                       <option value="">
                                                            Tidak dipilih
                                                       </option>

                                                       @foreach ($routes ?? [] as $route)
                                                            @php
                                                                 $routeOrigin =
                                                                     data_get($route, 'origin') ??
                                                                     data_get($route, 'start_point');

                                                                 $routeDestination =
                                                                     data_get($route, 'destination') ??
                                                                     data_get($route, 'end_point');

                                                                 if ($routeOrigin && $routeDestination) {
                                                                     $routeName =
                                                                         $routeOrigin . ' → ' . $routeDestination;
                                                                 } else {
                                                                     $routeName =
                                                                         data_get($route, 'route_name') ??
                                                                         (data_get($route, 'name') ??
                                                                             (data_get($route, 'route_code') ??
                                                                                 'Rute #' . $route->id));
                                                                 }
                                                            @endphp

                                                            <option value="{{ $route->id }}"
                                                                 @selected((string) old('route_id', $ticket->route_id) === (string) $route->id)>
                                                                 {{ $routeName }}
                                                            </option>
                                                       @endforeach
                                                  </select>
                                             </div>

                                             @error('route_id')
                                                  <small class="error-message">
                                                       <i class="bi bi-exclamation-circle"></i>
                                                       {{ $message }}
                                                  </small>
                                             @enderror
                                        </div>

                                        {{-- Kendaraan --}}
                                        <div class="form-group">
                                             <label for="vehicle_id">
                                                  Kendaraan
                                             </label>

                                             <div class="select-wrapper">
                                                  <i class="bi bi-bus-front"></i>

                                                  <select id="vehicle_id" name="vehicle_id"
                                                       class="@error('vehicle_id') input-error @enderror">
                                                       <option value="">
                                                            Tidak dipilih
                                                       </option>

                                                       @foreach ($vehicles ?? [] as $vehicle)
                                                            @php
                                                                 $vehicleName =
                                                                     data_get($vehicle, 'plate_number') ??
                                                                     (data_get($vehicle, 'license_plate') ??
                                                                         (data_get($vehicle, 'vehicle_name') ??
                                                                             (data_get($vehicle, 'name') ??
                                                                                 'Kendaraan #' . $vehicle->id)));

                                                                 $vehicleCode =
                                                                     data_get($vehicle, 'vehicle_code') ??
                                                                     data_get($vehicle, 'code');
                                                            @endphp

                                                            <option value="{{ $vehicle->id }}"
                                                                 @selected((string) old('vehicle_id', $ticket->vehicle_id) === (string) $vehicle->id)>
                                                                 {{ $vehicleName }}

                                                                 @if ($vehicleCode)
                                                                      — {{ $vehicleCode }}
                                                                 @endif
                                                            </option>
                                                       @endforeach
                                                  </select>
                                             </div>

                                             @error('vehicle_id')
                                                  <small class="error-message">
                                                       <i class="bi bi-exclamation-circle"></i>
                                                       {{ $message }}
                                                  </small>
                                             @enderror
                                        </div>
                                   </div>

                                   <p class="field-note">
                                        <i class="bi bi-info-circle"></i>

                                        Perjalanan, rute, dan kendaraan boleh
                                        dikosongkan karena kolom database bersifat
                                        nullable.
                                   </p>
                              </section>

                              {{-- Pembayaran --}}
                              <section class="form-section">
                                   <div class="section-heading">
                                        <span class="section-number">03</span>

                                        <div>
                                             <h3>Pembayaran dan Status</h3>

                                             <p>
                                                  Perbarui metode pembayaran, tarif,
                                                  dan status transaksi tiket.
                                             </p>
                                        </div>
                                   </div>

                                   <div class="form-grid form-grid-three">
                                        {{-- Metode pembayaran --}}
                                        <div class="form-group">
                                             <label for="payment_method">
                                                  Metode Pembayaran
                                                  <span class="required">*</span>
                                             </label>

                                             <div class="select-wrapper">
                                                  <i class="bi bi-wallet2"></i>

                                                  <select id="payment_method" name="payment_method"
                                                       class="@error('payment_method') input-error @enderror" required>
                                                       @foreach ($paymentMethods as $method)
                                                            <option value="{{ $method }}"
                                                                 @selected(old('payment_method', $ticket->payment_method) === $method)>
                                                                 {{ $paymentLabels[$method] ?? ucfirst($method) }}
                                                            </option>
                                                       @endforeach
                                                  </select>
                                             </div>

                                             @error('payment_method')
                                                  <small class="error-message">
                                                       <i class="bi bi-exclamation-circle"></i>
                                                       {{ $message }}
                                                  </small>
                                             @enderror
                                        </div>

                                        {{-- Tarif --}}
                                        <div class="form-group">
                                             <label for="fare">
                                                  Tarif
                                                  <span class="required">*</span>
                                             </label>

                                             <div class="input-wrapper currency-input">
                                                  <span class="currency-prefix">Rp</span>

                                                  <input type="number" id="fare" name="fare"
                                                       value="{{ old('fare', $ticket->fare) }}" min="0"
                                                       max="9999999999.99" step="0.01" inputmode="decimal"
                                                       placeholder="0" class="@error('fare') input-error @enderror"
                                                       required>
                                             </div>

                                             @error('fare')
                                                  <small class="error-message">
                                                       <i class="bi bi-exclamation-circle"></i>
                                                       {{ $message }}
                                                  </small>
                                             @enderror
                                        </div>

                                        {{-- Status tiket --}}
                                        <div class="form-group">
                                             <label for="ticket_status">
                                                  Status Tiket
                                                  <span class="required">*</span>
                                             </label>

                                             <div class="select-wrapper">
                                                  <i class="bi bi-check-circle"></i>

                                                  <select id="ticket_status" name="ticket_status"
                                                       class="@error('ticket_status') input-error @enderror" required>
                                                       @foreach ($ticketStatuses as $status)
                                                            <option value="{{ $status }}"
                                                                 @selected(old('ticket_status', $ticket->ticket_status) === $status)>
                                                                 {{ $statusLabels[$status] ?? ucfirst($status) }}
                                                            </option>
                                                       @endforeach
                                                  </select>
                                             </div>

                                             @error('ticket_status')
                                                  <small class="error-message">
                                                       <i class="bi bi-exclamation-circle"></i>
                                                       {{ $message }}
                                                  </small>
                                             @enderror
                                        </div>
                                   </div>
                              </section>
                         </div>

                         {{-- Tombol --}}
                         <footer class="form-card-footer">
                              <div class="footer-information">
                                   <i class="bi bi-clock-history"></i>

                                   <span>
                                        Terakhir diperbarui:
                                        {{ $ticket->updated_at ? $ticket->updated_at->format('d M Y H:i') : '-' }}
                                   </span>
                              </div>

                              <div class="footer-actions">
                                   <a href="{{ route('admin.tickets.index') }}" class="cancel-button">
                                        <i class="bi bi-x-lg"></i>
                                        Batal
                                   </a>

                                   <button type="submit" class="submit-button" id="submitButton">
                                        <i class="bi bi-check-lg"></i>
                                        <span>Simpan Perubahan</span>
                                   </button>
                              </div>
                         </footer>
                    </div>
               </form>
          </div>
     </div>

     <style>
          :root {
               --ticket-primary: #4f46e5;
               --ticket-primary-dark: #3730a3;
               --ticket-heading: #172033;
               --ticket-text: #475569;
               --ticket-muted: #94a3b8;
               --ticket-border: #e2e8f0;
               --ticket-background: #f4f7fb;
          }

          * {
               box-sizing: border-box;
          }

          .ticket-edit-page {
               min-height: 100vh;
               background:
                    radial-gradient(circle at 96% 3%,
                         rgba(79, 70, 229, 0.09),
                         transparent 24%),
                    var(--ticket-background);
          }

          .ticket-edit-container {
               width: 100%;
               padding: 28px;
          }

          /*
             |--------------------------------------------------------------------------
             | Header
             |--------------------------------------------------------------------------
             */

          .page-header {
               position: relative;
               overflow: hidden;
               margin-bottom: 24px;
               border-radius: 24px;
               padding: 34px;
               background: linear-gradient(135deg,
                         #1e1b4b 0%,
                         #4338ca 55%,
                         #6366f1 100%);
               box-shadow: 0 22px 50px rgba(55, 48, 163, 0.22);
          }

          .page-header-content {
               position: relative;
               z-index: 2;
               display: flex;
               align-items: center;
               justify-content: space-between;
               gap: 24px;
          }

          .header-label {
               display: inline-flex;
               align-items: center;
               gap: 9px;
               margin-bottom: 13px;
               border: 1px solid rgba(255, 255, 255, 0.18);
               border-radius: 999px;
               padding: 7px 12px;
               background: rgba(255, 255, 255, 0.1);
               color: rgba(255, 255, 255, 0.88);
               font-size: 11px;
               font-weight: 700;
               letter-spacing: 0.08em;
               text-transform: uppercase;
          }

          .header-label span {
               width: 7px;
               height: 7px;
               border-radius: 50%;
               background: #86efac;
               box-shadow: 0 0 0 5px rgba(134, 239, 172, 0.15);
          }

          .page-header h1 {
               margin: 0 0 8px;
               color: #ffffff;
               font-size: clamp(28px, 4vw, 40px);
               font-weight: 800;
               letter-spacing: -0.035em;
          }

          .page-header p {
               max-width: 650px;
               margin: 0;
               color: rgba(255, 255, 255, 0.72);
               font-size: 14px;
               line-height: 1.7;
          }

          .page-header p strong {
               color: #ffffff;
          }

          .header-actions {
               display: flex;
               flex-shrink: 0;
               gap: 9px;
          }

          .back-button,
          .detail-button {
               min-height: 47px;
               display: inline-flex;
               align-items: center;
               justify-content: center;
               gap: 8px;
               border-radius: 13px;
               padding: 11px 17px;
               font-size: 12px;
               font-weight: 700;
               text-decoration: none;
               transition: 0.2s ease;
          }

          .back-button {
               background: #ffffff;
               color: var(--ticket-primary-dark);
               box-shadow: 0 13px 30px rgba(15, 23, 42, 0.2);
          }

          .detail-button {
               border: 1px solid rgba(255, 255, 255, 0.25);
               background: rgba(255, 255, 255, 0.12);
               color: #ffffff;
          }

          .back-button:hover,
          .detail-button:hover {
               transform: translateY(-2px);
          }

          .back-button:hover {
               color: var(--ticket-primary-dark);
          }

          .detail-button:hover {
               background: rgba(255, 255, 255, 0.2);
               color: #ffffff;
          }

          .header-decoration {
               position: absolute;
               border-radius: 50%;
               background: rgba(255, 255, 255, 0.06);
          }

          .decoration-one {
               width: 220px;
               height: 220px;
               top: -100px;
               right: -40px;
          }

          .decoration-two {
               width: 115px;
               height: 115px;
               right: 170px;
               bottom: -75px;
          }

          /*
             |--------------------------------------------------------------------------
             | Alert
             |--------------------------------------------------------------------------
             */

          .form-alert {
               display: flex;
               gap: 14px;
               margin-bottom: 24px;
               border: 1px solid #fecaca;
               border-radius: 16px;
               padding: 17px;
               background: #fef2f2;
               color: #991b1b;
          }

          .form-alert-icon {
               width: 42px;
               height: 42px;
               display: flex;
               flex: 0 0 42px;
               align-items: center;
               justify-content: center;
               border-radius: 12px;
               background: #ffffff;
               font-size: 19px;
          }

          .form-alert strong {
               display: block;
               margin-bottom: 5px;
               font-size: 13px;
          }

          .form-alert ul {
               margin: 0;
               padding-left: 18px;
               font-size: 11px;
               line-height: 1.7;
          }

          /*
             |--------------------------------------------------------------------------
             | Form card
             |--------------------------------------------------------------------------
             */

          .form-card {
               overflow: hidden;
               border: 1px solid rgba(226, 232, 240, 0.9);
               border-radius: 22px;
               background: #ffffff;
               box-shadow: 0 18px 50px rgba(15, 23, 42, 0.065);
          }

          .form-card-header {
               display: flex;
               align-items: center;
               gap: 15px;
               border-bottom: 1px solid var(--ticket-border);
               padding: 24px 28px;
          }

          .form-header-icon {
               width: 52px;
               height: 52px;
               display: flex;
               flex: 0 0 52px;
               align-items: center;
               justify-content: center;
               border-radius: 16px;
               background: #fef3c7;
               color: #a16207;
               font-size: 22px;
          }

          .form-card-header span {
               display: block;
               margin-bottom: 3px;
               color: var(--ticket-primary);
               font-size: 10px;
               font-weight: 800;
               letter-spacing: 0.09em;
               text-transform: uppercase;
          }

          .form-card-header h2 {
               margin: 0 0 4px;
               color: var(--ticket-heading);
               font-size: 21px;
               font-weight: 800;
          }

          .form-card-header p {
               margin: 0;
               color: var(--ticket-muted);
               font-size: 11px;
          }

          .form-card-body {
               padding: 4px 28px;
          }

          .form-section {
               padding: 28px 0;
               border-bottom: 1px solid #edf0f4;
          }

          .form-section:last-child {
               border-bottom: 0;
          }

          .section-heading {
               display: flex;
               align-items: flex-start;
               gap: 13px;
               margin-bottom: 22px;
          }

          .section-number {
               width: 35px;
               height: 35px;
               display: flex;
               flex: 0 0 35px;
               align-items: center;
               justify-content: center;
               border-radius: 11px;
               background: #eef2ff;
               color: var(--ticket-primary);
               font-size: 10px;
               font-weight: 800;
          }

          .section-heading h3 {
               margin: 0 0 4px;
               color: var(--ticket-heading);
               font-size: 15px;
               font-weight: 800;
          }

          .section-heading p {
               margin: 0;
               color: var(--ticket-muted);
               font-size: 10px;
          }

          /*
             |--------------------------------------------------------------------------
             | Input
             |--------------------------------------------------------------------------
             */

          .form-grid {
               display: grid;
               grid-template-columns: repeat(2, minmax(0, 1fr));
               gap: 20px;
          }

          .form-grid-three {
               grid-template-columns: repeat(3, minmax(0, 1fr));
          }

          .form-group {
               min-width: 0;
          }

          .form-group label {
               display: block;
               margin-bottom: 8px;
               color: #334155;
               font-size: 11px;
               font-weight: 750;
          }

          .required {
               color: #dc2626;
          }

          .input-wrapper,
          .select-wrapper {
               position: relative;
          }

          .input-wrapper>i,
          .select-wrapper>i {
               position: absolute;
               z-index: 2;
               top: 50%;
               left: 15px;
               color: #94a3b8;
               font-size: 15px;
               transform: translateY(-50%);
               pointer-events: none;
          }

          .input-wrapper input,
          .select-wrapper select {
               width: 100%;
               min-height: 47px;
               border: 1px solid #dce2ea;
               border-radius: 12px;
               background: #ffffff;
               color: #334155;
               font-size: 12px;
               outline: none;
               transition: 0.2s ease;
          }

          .input-wrapper input {
               padding: 11px 15px 11px 44px;
          }

          .select-wrapper select {
               padding: 11px 38px 11px 44px;
               cursor: pointer;
          }

          .input-wrapper input:focus,
          .select-wrapper select:focus {
               border-color: #8b83ef;
               box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.09);
          }

          .input-error {
               border-color: #ef4444 !important;
               background: #fffafa !important;
          }

          .error-message {
               display: flex;
               align-items: center;
               gap: 5px;
               margin-top: 6px;
               color: #dc2626;
               font-size: 9px;
          }

          .currency-input .currency-prefix {
               position: absolute;
               z-index: 2;
               top: 50%;
               left: 15px;
               color: #64748b;
               font-size: 12px;
               font-weight: 800;
               transform: translateY(-50%);
          }

          .currency-input input {
               padding-left: 47px;
          }

          .field-note {
               display: flex;
               align-items: center;
               gap: 7px;
               margin: 14px 0 0;
               color: #7c8798;
               font-size: 9px;
          }

          /*
             |--------------------------------------------------------------------------
             | Footer
             |--------------------------------------------------------------------------
             */

          .form-card-footer {
               display: flex;
               align-items: center;
               justify-content: space-between;
               gap: 18px;
               border-top: 1px solid var(--ticket-border);
               padding: 20px 28px;
               background: #fbfcfe;
          }

          .footer-information {
               display: flex;
               align-items: center;
               gap: 7px;
               color: #94a3b8;
               font-size: 10px;
          }

          .footer-actions {
               display: flex;
               align-items: center;
               gap: 11px;
          }

          .cancel-button,
          .submit-button {
               min-height: 45px;
               display: inline-flex;
               align-items: center;
               justify-content: center;
               gap: 8px;
               border-radius: 12px;
               padding: 10px 18px;
               font-size: 12px;
               font-weight: 750;
               text-decoration: none;
               cursor: pointer;
               transition: 0.2s ease;
          }

          .cancel-button {
               border: 1px solid #dfe4ec;
               background: #ffffff;
               color: #64748b;
          }

          .cancel-button:hover {
               border-color: #cbd5e1;
               color: #334155;
          }

          .submit-button {
               border: 0;
               background: var(--ticket-primary);
               color: #ffffff;
               box-shadow: 0 10px 22px rgba(79, 70, 229, 0.2);
          }

          .submit-button:hover {
               background: var(--ticket-primary-dark);
               transform: translateY(-1px);
          }

          .submit-button:disabled {
               cursor: not-allowed;
               opacity: 0.7;
               transform: none;
          }

          /*
             |--------------------------------------------------------------------------
             | Responsive
             |--------------------------------------------------------------------------
             */

          @media (max-width: 991.98px) {
               .form-grid-three {
                    grid-template-columns: 1fr;
               }

               .form-card-footer {
                    align-items: flex-start;
                    flex-direction: column;
               }

               .footer-actions {
                    width: 100%;
                    justify-content: flex-end;
               }
          }

          @media (max-width: 767.98px) {
               .ticket-edit-container {
                    padding: 18px 14px;
               }

               .page-header {
                    border-radius: 19px;
                    padding: 25px 20px;
               }

               .page-header-content {
                    flex-direction: column;
                    align-items: flex-start;
               }

               .header-actions {
                    width: 100%;
               }

               .back-button,
               .detail-button {
                    flex: 1;
               }

               .form-card-header,
               .form-card-footer {
                    padding: 20px;
               }

               .form-card-body {
                    padding: 0 20px;
               }

               .form-grid {
                    grid-template-columns: 1fr;
               }

               .footer-actions {
                    flex-direction: column-reverse;
               }

               .cancel-button,
               .submit-button {
                    width: 100%;
               }
          }
     </style>

     <script>
          document.addEventListener('DOMContentLoaded', function() {
               const form = document.getElementById('ticketEditForm');
               const submitButton = document.getElementById('submitButton');

               if (!form || !submitButton) {
                    return;
               }

               form.addEventListener('submit', function() {
                    if (!form.checkValidity()) {
                         return;
                    }

                    submitButton.disabled = true;

                    submitButton.innerHTML = `
                    <span
                        class="spinner-border spinner-border-sm"
                        aria-hidden="true"
                    ></span>
                    <span>Menyimpan...</span>
                `;
               });
          });
     </script>
@endsection
