```blade
@extends('layouts.app')

@section('title', $title ?? 'Detail Tiket')

@section('content')
     @php
          /*
        |--------------------------------------------------------------------------
        | Label
        |--------------------------------------------------------------------------
        */

          $paymentLabels = [
              'cash' => 'Tunai',
              'emoney' => 'E-Money',
              'qris' => 'QRIS',
              'card' => 'Kartu Debit/Kredit',
              'other' => 'Lainnya',
          ];

          $paymentIcons = [
              'cash' => 'bi-cash-stack',
              'emoney' => 'bi-wallet2',
              'qris' => 'bi-qr-code-scan',
              'card' => 'bi-credit-card',
              'other' => 'bi-three-dots',
          ];

          $statusLabels = [
              'paid' => 'Dibayar',
              'refunded' => 'Dikembalikan',
              'failed' => 'Gagal',
          ];

          $statusIcons = [
              'paid' => 'bi-check-circle',
              'refunded' => 'bi-arrow-counterclockwise',
              'failed' => 'bi-x-circle',
          ];

          /*
        |--------------------------------------------------------------------------
        | Informasi perjalanan
        |--------------------------------------------------------------------------
        */

          $tripName =
              data_get($ticket->trip, 'trip_code') ??
              (data_get($ticket->trip, 'code') ??
                  (data_get($ticket->trip, 'name') ??
                      ($ticket->trip_id ? 'Perjalanan #' . $ticket->trip_id : 'Tidak dipilih')));

          $routeOrigin = data_get($ticket->route, 'origin') ?? data_get($ticket->route, 'start_point');

          $routeDestination = data_get($ticket->route, 'destination') ?? data_get($ticket->route, 'end_point');

          if ($routeOrigin && $routeDestination) {
              $routeName = $routeOrigin . ' → ' . $routeDestination;
          } else {
              $routeName =
                  data_get($ticket->route, 'route_name') ??
                  (data_get($ticket->route, 'name') ??
                      (data_get($ticket->route, 'route_code') ??
                          ($ticket->route_id ? 'Rute #' . $ticket->route_id : 'Tidak dipilih')));
          }

          $vehicleName =
              data_get($ticket->vehicle, 'plate_number') ??
              (data_get($ticket->vehicle, 'license_plate') ??
                  (data_get($ticket->vehicle, 'vehicle_name') ??
                      (data_get($ticket->vehicle, 'name') ??
                          ($ticket->vehicle_id ? 'Kendaraan #' . $ticket->vehicle_id : 'Tidak dipilih'))));

          $vehicleCode =
              data_get($ticket->vehicle, 'vehicle_code') ??
              (data_get($ticket->vehicle, 'code') ?? ($ticket->vehicle_id ? 'ID #' . $ticket->vehicle_id : '-'));

          /*
        |--------------------------------------------------------------------------
        | Informasi pembayaran dan status
        |--------------------------------------------------------------------------
        */

          $paymentMethod = $ticket->payment_method ?? 'other';

          $paymentName = $paymentLabels[$paymentMethod] ?? ucfirst($paymentMethod);

          $paymentIcon = $paymentIcons[$paymentMethod] ?? 'bi-wallet2';

          $ticketStatus = $ticket->ticket_status ?? 'unknown';

          $statusName = $statusLabels[$ticketStatus] ?? ucfirst($ticketStatus);

          $statusIcon = $statusIcons[$ticketStatus] ?? 'bi-info-circle';

          /*
        |--------------------------------------------------------------------------
        | Tanggal
        |--------------------------------------------------------------------------
        */

          $issuedAt = $ticket->issued_at ? \Illuminate\Support\Carbon::parse($ticket->issued_at) : null;

          $createdAt = $ticket->created_at ? \Illuminate\Support\Carbon::parse($ticket->created_at) : null;

          $updatedAt = $ticket->updated_at ? \Illuminate\Support\Carbon::parse($ticket->updated_at) : null;
     @endphp

     <div class="ticket-show-page">
          <div class="ticket-show-container">

               {{-- Header --}}
               <section class="ticket-header">
                    <div class="ticket-header-content">
                         <div>
                              <div class="header-label">
                                   <span></span>
                                   Detail Transaksi Tiket
                              </div>

                              <h1>{{ $ticket->ticket_code }}</h1>

                              <p>
                                   Informasi lengkap mengenai perjalanan, rute,
                                   kendaraan, pembayaran, tarif, dan status tiket.
                              </p>
                         </div>

                         <div class="header-actions">
                              <a href="{{ route('admin.tickets.edit', $ticket) }}" class="edit-button">
                                   <i class="bi bi-pencil"></i>
                                   Edit Tiket
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

               {{-- Alert --}}
               @if (session('success'))
                    <div class="ticket-alert ticket-alert-success">
                         <div class="ticket-alert-icon">
                              <i class="bi bi-check-lg"></i>
                         </div>

                         <div>
                              <strong>Berhasil</strong>
                              <p>{{ session('success') }}</p>
                         </div>
                    </div>
               @endif

               @if (session('error'))
                    <div class="ticket-alert ticket-alert-danger">
                         <div class="ticket-alert-icon">
                              <i class="bi bi-exclamation-lg"></i>
                         </div>

                         <div>
                              <strong>Terjadi kesalahan</strong>
                              <p>{{ session('error') }}</p>
                         </div>
                    </div>
               @endif

               {{-- Ringkasan --}}
               <section class="summary-grid">
                    <article class="summary-card">
                         <div class="summary-icon summary-ticket">
                              <i class="bi bi-ticket-perforated"></i>
                         </div>

                         <div>
                              <span>Kode Tiket</span>
                              <strong>{{ $ticket->ticket_code }}</strong>
                              <small>ID #{{ $ticket->id }}</small>
                         </div>
                    </article>

                    <article class="summary-card">
                         <div class="summary-icon summary-payment">
                              <i class="bi {{ $paymentIcon }}"></i>
                         </div>

                         <div>
                              <span>Metode Pembayaran</span>
                              <strong>{{ $paymentName }}</strong>
                              <small>{{ strtoupper($paymentMethod) }}</small>
                         </div>
                    </article>

                    <article class="summary-card">
                         <div class="summary-icon summary-fare">
                              <i class="bi bi-cash-coin"></i>
                         </div>

                         <div>
                              <span>Tarif</span>
                              <strong class="currency-value">
                                   Rp {{ number_format((float) $ticket->fare, 0, ',', '.') }}
                              </strong>
                              <small>Nilai transaksi tiket</small>
                         </div>
                    </article>

                    <article class="summary-card">
                         <div class="summary-icon summary-status summary-status-{{ $ticketStatus }}">
                              <i class="bi {{ $statusIcon }}"></i>
                         </div>

                         <div>
                              <span>Status Tiket</span>

                              <strong>
                                   <span class="status-badge status-{{ $ticketStatus }}">
                                        <span></span>
                                        {{ $statusName }}
                                   </span>
                              </strong>

                              <small>Status transaksi terkini</small>
                         </div>
                    </article>
               </section>

               <div class="detail-layout">
                    {{-- Detail utama --}}
                    <section class="detail-card">
                         <header class="detail-card-header">
                              <div class="detail-header-icon">
                                   <i class="bi bi-info-circle"></i>
                              </div>

                              <div>
                                   <span>Informasi Tiket</span>
                                   <h2>Detail Transaksi</h2>
                                   <p>
                                        Data utama tiket dan informasi pembayaran.
                                   </p>
                              </div>
                         </header>

                         <div class="detail-card-body">
                              <div class="detail-section">
                                   <div class="section-title">
                                        <span>01</span>

                                        <div>
                                             <h3>Informasi Utama</h3>
                                             <p>Identitas dan waktu penerbitan tiket.</p>
                                        </div>
                                   </div>

                                   <div class="information-grid">
                                        <div class="information-item">
                                             <div class="information-icon">
                                                  <i class="bi bi-upc-scan"></i>
                                             </div>

                                             <div>
                                                  <span>Kode Tiket</span>
                                                  <strong>{{ $ticket->ticket_code }}</strong>
                                             </div>
                                        </div>

                                        <div class="information-item">
                                             <div class="information-icon">
                                                  <i class="bi bi-hash"></i>
                                             </div>

                                             <div>
                                                  <span>ID Tiket</span>
                                                  <strong>#{{ $ticket->id }}</strong>
                                             </div>
                                        </div>

                                        <div class="information-item">
                                             <div class="information-icon">
                                                  <i class="bi bi-calendar3"></i>
                                             </div>

                                             <div>
                                                  <span>Diterbitkan</span>

                                                  <strong>
                                                       {{ $issuedAt ? $issuedAt->format('d M Y') : '-' }}
                                                  </strong>

                                                  <small>
                                                       {{ $issuedAt ? $issuedAt->format('H:i') . ' WIB' : 'Waktu tidak tersedia' }}
                                                  </small>
                                             </div>
                                        </div>

                                        <div class="information-item">
                                             <div class="information-icon">
                                                  <i class="bi {{ $paymentIcon }}"></i>
                                             </div>

                                             <div>
                                                  <span>Metode Pembayaran</span>
                                                  <strong>{{ $paymentName }}</strong>
                                                  <small>{{ $paymentMethod }}</small>
                                             </div>
                                        </div>

                                        <div class="information-item">
                                             <div class="information-icon">
                                                  <i class="bi bi-cash-stack"></i>
                                             </div>

                                             <div>
                                                  <span>Tarif</span>

                                                  <strong>
                                                       Rp
                                                       {{ number_format((float) $ticket->fare, 2, ',', '.') }}
                                                  </strong>
                                             </div>
                                        </div>

                                        <div class="information-item">
                                             <div class="information-icon">
                                                  <i class="bi {{ $statusIcon }}"></i>
                                             </div>

                                             <div>
                                                  <span>Status</span>

                                                  <strong>
                                                       <span class="status-badge status-{{ $ticketStatus }}">
                                                            <span></span>
                                                            {{ $statusName }}
                                                       </span>
                                                  </strong>
                                             </div>
                                        </div>
                                   </div>
                              </div>

                              <div class="detail-section">
                                   <div class="section-title">
                                        <span>02</span>

                                        <div>
                                             <h3>Informasi Perjalanan</h3>

                                             <p>
                                                  Data perjalanan, rute, dan kendaraan
                                                  yang terhubung.
                                             </p>
                                        </div>
                                   </div>

                                   <div class="travel-grid">
                                        {{-- Perjalanan --}}
                                        <article class="travel-card">
                                             <div class="travel-card-icon trip-icon">
                                                  <i class="bi bi-signpost"></i>
                                             </div>

                                             <div class="travel-card-content">
                                                  <span>Perjalanan</span>
                                                  <strong>{{ $tripName }}</strong>

                                                  <small>
                                                       {{ $ticket->trip_id ? 'ID #' . $ticket->trip_id : 'Tidak terhubung' }}
                                                  </small>
                                             </div>
                                        </article>

                                        {{-- Rute --}}
                                        <article class="travel-card">
                                             <div class="travel-card-icon route-icon">
                                                  <i class="bi bi-signpost-split"></i>
                                             </div>

                                             <div class="travel-card-content">
                                                  <span>Rute</span>
                                                  <strong>{{ $routeName }}</strong>

                                                  <small>
                                                       {{ $ticket->route_id ? 'ID #' . $ticket->route_id : 'Tidak terhubung' }}
                                                  </small>
                                             </div>
                                        </article>

                                        {{-- Kendaraan --}}
                                        <article class="travel-card">
                                             <div class="travel-card-icon vehicle-icon">
                                                  <i class="bi bi-bus-front"></i>
                                             </div>

                                             <div class="travel-card-content">
                                                  <span>Kendaraan</span>
                                                  <strong>{{ $vehicleName }}</strong>
                                                  <small>{{ $vehicleCode }}</small>
                                             </div>
                                        </article>
                                   </div>
                              </div>

                              <div class="detail-section">
                                   <div class="section-title">
                                        <span>03</span>

                                        <div>
                                             <h3>Riwayat Data</h3>
                                             <p>Informasi pembuatan dan perubahan data.</p>
                                        </div>
                                   </div>

                                   <div class="timeline">
                                        <div class="timeline-item">
                                             <div class="timeline-marker">
                                                  <i class="bi bi-plus-lg"></i>
                                             </div>

                                             <div>
                                                  <span>Data Dibuat</span>

                                                  <strong>
                                                       {{ $createdAt ? $createdAt->format('d M Y H:i') : '-' }}
                                                  </strong>
                                             </div>
                                        </div>

                                        <div class="timeline-line"></div>

                                        <div class="timeline-item">
                                             <div class="timeline-marker">
                                                  <i class="bi bi-pencil"></i>
                                             </div>

                                             <div>
                                                  <span>Terakhir Diperbarui</span>

                                                  <strong>
                                                       {{ $updatedAt ? $updatedAt->format('d M Y H:i') : '-' }}
                                                  </strong>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </section>

                    {{-- Panel aksi --}}
                    <aside class="side-panel">
                         <section class="action-card">
                              <header>
                                   <span>Aksi Tiket</span>
                                   <h3>Kelola Data</h3>
                                   <p>
                                        Ubah atau hapus data tiket ini.
                                   </p>
                              </header>

                              <div class="action-card-body">
                                   <a href="{{ route('admin.tickets.edit', $ticket) }}"
                                        class="side-action side-action-edit">
                                        <div>
                                             <i class="bi bi-pencil-square"></i>
                                        </div>

                                        <span>
                                             <strong>Edit Tiket</strong>
                                             <small>Perbarui data tiket</small>
                                        </span>

                                        <i class="bi bi-chevron-right"></i>
                                   </a>

                                   <a href="{{ route('admin.tickets.index') }}" class="side-action side-action-list">
                                        <div>
                                             <i class="bi bi-list-ul"></i>
                                        </div>

                                        <span>
                                             <strong>Daftar Tiket</strong>
                                             <small>Kembali ke halaman daftar</small>
                                        </span>

                                        <i class="bi bi-chevron-right"></i>
                                   </a>

                                   <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST"
                                        class="delete-form"
                                        onsubmit="return confirm(
                                    'Yakin ingin menghapus tiket {{ $ticket->ticket_code }}? Data yang dihapus tidak dapat dikembalikan.'
                                )">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="side-action side-action-delete">
                                             <div>
                                                  <i class="bi bi-trash"></i>
                                             </div>

                                             <span>
                                                  <strong>Hapus Tiket</strong>
                                                  <small>Hapus data secara permanen</small>
                                             </span>

                                             <i class="bi bi-chevron-right"></i>
                                        </button>
                                   </form>
                              </div>
                         </section>

                         <section class="reference-card">
                              <div class="reference-icon">
                                   <i class="bi bi-shield-check"></i>
                              </div>

                              <h3>Informasi Referensi</h3>

                              <div class="reference-list">
                                   <div>
                                        <span>Ticket ID</span>
                                        <strong>#{{ $ticket->id }}</strong>
                                   </div>

                                   <div>
                                        <span>Trip ID</span>
                                        <strong>
                                             {{ $ticket->trip_id ? '#' . $ticket->trip_id : '-' }}
                                        </strong>
                                   </div>

                                   <div>
                                        <span>Route ID</span>
                                        <strong>
                                             {{ $ticket->route_id ? '#' . $ticket->route_id : '-' }}
                                        </strong>
                                   </div>

                                   <div>
                                        <span>Vehicle ID</span>
                                        <strong>
                                             {{ $ticket->vehicle_id ? '#' . $ticket->vehicle_id : '-' }}
                                        </strong>
                                   </div>
                              </div>
                         </section>
                    </aside>
               </div>
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

          .ticket-show-page {
               min-height: 100vh;
               background:
                    radial-gradient(circle at 96% 3%,
                         rgba(79, 70, 229, 0.09),
                         transparent 24%),
                    var(--ticket-background);
          }

          .ticket-show-container {
               width: 100%;
               padding: 28px;
          }

          /*
             |--------------------------------------------------------------------------
             | Header
             |--------------------------------------------------------------------------
             */

          .ticket-header {
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

          .ticket-header-content {
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

          .ticket-header h1 {
               margin: 0 0 8px;
               color: #ffffff;
               font-size: clamp(28px, 4vw, 40px);
               font-weight: 800;
               letter-spacing: -0.035em;
          }

          .ticket-header p {
               max-width: 650px;
               margin: 0;
               color: rgba(255, 255, 255, 0.72);
               font-size: 14px;
               line-height: 1.7;
          }

          .header-actions {
               display: flex;
               flex-shrink: 0;
               gap: 9px;
          }

          .edit-button,
          .back-button {
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

          .edit-button {
               border: 1px solid rgba(255, 255, 255, 0.25);
               background: rgba(255, 255, 255, 0.12);
               color: #ffffff;
          }

          .back-button {
               background: #ffffff;
               color: var(--ticket-primary-dark);
               box-shadow: 0 13px 30px rgba(15, 23, 42, 0.2);
          }

          .edit-button:hover,
          .back-button:hover {
               transform: translateY(-2px);
          }

          .edit-button:hover {
               background: rgba(255, 255, 255, 0.2);
               color: #ffffff;
          }

          .back-button:hover {
               color: var(--ticket-primary-dark);
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

          .ticket-alert {
               display: flex;
               align-items: center;
               gap: 14px;
               margin-bottom: 24px;
               border-radius: 16px;
               padding: 15px 17px;
          }

          .ticket-alert-success {
               border: 1px solid #bbf7d0;
               background: #f0fdf4;
               color: #166534;
          }

          .ticket-alert-danger {
               border: 1px solid #fecaca;
               background: #fef2f2;
               color: #991b1b;
          }

          .ticket-alert-icon {
               width: 41px;
               height: 41px;
               display: flex;
               flex: 0 0 41px;
               align-items: center;
               justify-content: center;
               border-radius: 12px;
               background: rgba(255, 255, 255, 0.8);
               font-size: 19px;
          }

          .ticket-alert strong {
               display: block;
               font-size: 13px;
          }

          .ticket-alert p {
               margin: 2px 0 0;
               font-size: 11px;
          }

          /*
             |--------------------------------------------------------------------------
             | Summary
             |--------------------------------------------------------------------------
             */

          .summary-grid {
               display: grid;
               grid-template-columns: repeat(4, minmax(0, 1fr));
               gap: 16px;
               margin-bottom: 24px;
          }

          .summary-card {
               min-width: 0;
               display: flex;
               align-items: center;
               gap: 14px;
               border: 1px solid rgba(226, 232, 240, 0.9);
               border-radius: 19px;
               padding: 20px;
               background: #ffffff;
               box-shadow: 0 14px 38px rgba(15, 23, 42, 0.055);
          }

          .summary-icon {
               width: 52px;
               height: 52px;
               display: flex;
               flex: 0 0 52px;
               align-items: center;
               justify-content: center;
               border-radius: 16px;
               font-size: 21px;
          }

          .summary-ticket {
               background: #eef2ff;
               color: #4f46e5;
          }

          .summary-payment {
               background: #eff6ff;
               color: #2563eb;
          }

          .summary-fare {
               background: #ecfdf5;
               color: #059669;
          }

          .summary-status {
               background: #f1f5f9;
               color: #475569;
          }

          .summary-status-paid {
               background: #dcfce7;
               color: #15803d;
          }

          .summary-status-refunded {
               background: #fef3c7;
               color: #a16207;
          }

          .summary-status-failed {
               background: #fee2e2;
               color: #b91c1c;
          }

          .summary-card span {
               display: block;
               margin-bottom: 3px;
               color: #8792a5;
               font-size: 9px;
               font-weight: 800;
               letter-spacing: 0.07em;
               text-transform: uppercase;
          }

          .summary-card strong {
               display: block;
               overflow: hidden;
               color: var(--ticket-heading);
               font-size: 15px;
               font-weight: 800;
               text-overflow: ellipsis;
               white-space: nowrap;
          }

          .summary-card small {
               display: block;
               margin-top: 3px;
               color: var(--ticket-muted);
               font-size: 9px;
          }

          .summary-card .currency-value {
               font-size: 17px;
          }

          /*
             |--------------------------------------------------------------------------
             | Layout
             |--------------------------------------------------------------------------
             */

          .detail-layout {
               display: grid;
               grid-template-columns: minmax(0, 1fr) 320px;
               align-items: start;
               gap: 20px;
          }

          .detail-card,
          .action-card,
          .reference-card {
               border: 1px solid rgba(226, 232, 240, 0.9);
               border-radius: 22px;
               background: #ffffff;
               box-shadow: 0 18px 50px rgba(15, 23, 42, 0.055);
          }

          .detail-card {
               overflow: hidden;
          }

          .detail-card-header {
               display: flex;
               align-items: center;
               gap: 15px;
               border-bottom: 1px solid var(--ticket-border);
               padding: 24px 28px;
          }

          .detail-header-icon {
               width: 52px;
               height: 52px;
               display: flex;
               flex: 0 0 52px;
               align-items: center;
               justify-content: center;
               border-radius: 16px;
               background: #eef2ff;
               color: var(--ticket-primary);
               font-size: 22px;
          }

          .detail-card-header span {
               display: block;
               margin-bottom: 3px;
               color: var(--ticket-primary);
               font-size: 9px;
               font-weight: 800;
               letter-spacing: 0.09em;
               text-transform: uppercase;
          }

          .detail-card-header h2 {
               margin: 0 0 4px;
               color: var(--ticket-heading);
               font-size: 21px;
               font-weight: 800;
          }

          .detail-card-header p {
               margin: 0;
               color: var(--ticket-muted);
               font-size: 10px;
          }

          .detail-card-body {
               padding: 0 28px;
          }

          .detail-section {
               padding: 28px 0;
               border-bottom: 1px solid #edf0f4;
          }

          .detail-section:last-child {
               border-bottom: 0;
          }

          .section-title {
               display: flex;
               align-items: flex-start;
               gap: 13px;
               margin-bottom: 22px;
          }

          .section-title>span {
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

          .section-title h3 {
               margin: 0 0 4px;
               color: var(--ticket-heading);
               font-size: 15px;
               font-weight: 800;
          }

          .section-title p {
               margin: 0;
               color: var(--ticket-muted);
               font-size: 10px;
          }

          /*
             |--------------------------------------------------------------------------
             | Information
             |--------------------------------------------------------------------------
             */

          .information-grid {
               display: grid;
               grid-template-columns: repeat(2, minmax(0, 1fr));
               gap: 14px;
          }

          .information-item {
               min-width: 0;
               display: flex;
               align-items: center;
               gap: 12px;
               border: 1px solid #edf0f4;
               border-radius: 15px;
               padding: 15px;
               background: #fbfcfe;
          }

          .information-icon {
               width: 42px;
               height: 42px;
               display: flex;
               flex: 0 0 42px;
               align-items: center;
               justify-content: center;
               border-radius: 12px;
               background: #ffffff;
               color: var(--ticket-primary);
               font-size: 17px;
               box-shadow: 0 6px 15px rgba(15, 23, 42, 0.05);
          }

          .information-item span {
               display: block;
               margin-bottom: 4px;
               color: #94a3b8;
               font-size: 9px;
               font-weight: 750;
               text-transform: uppercase;
          }

          .information-item strong {
               display: block;
               overflow: hidden;
               color: #334155;
               font-size: 12px;
               font-weight: 800;
               text-overflow: ellipsis;
          }

          .information-item small {
               display: block;
               margin-top: 3px;
               color: #94a3b8;
               font-size: 9px;
          }

          /*
             |--------------------------------------------------------------------------
             | Travel
             |--------------------------------------------------------------------------
             */

          .travel-grid {
               display: grid;
               grid-template-columns: repeat(3, minmax(0, 1fr));
               gap: 14px;
          }

          .travel-card {
               min-width: 0;
               border: 1px solid #edf0f4;
               border-radius: 17px;
               padding: 18px;
               background: #ffffff;
          }

          .travel-card-icon {
               width: 45px;
               height: 45px;
               display: flex;
               align-items: center;
               justify-content: center;
               margin-bottom: 15px;
               border-radius: 14px;
               font-size: 19px;
          }

          .trip-icon {
               background: #eef2ff;
               color: #4f46e5;
          }

          .route-icon {
               background: #faf5ff;
               color: #7e22ce;
          }

          .vehicle-icon {
               background: #eff6ff;
               color: #2563eb;
          }

          .travel-card-content span {
               display: block;
               margin-bottom: 5px;
               color: #94a3b8;
               font-size: 9px;
               font-weight: 800;
               letter-spacing: 0.07em;
               text-transform: uppercase;
          }

          .travel-card-content strong {
               display: block;
               overflow: hidden;
               color: var(--ticket-heading);
               font-size: 12px;
               font-weight: 800;
               line-height: 1.5;
               text-overflow: ellipsis;
          }

          .travel-card-content small {
               display: block;
               margin-top: 5px;
               color: #94a3b8;
               font-size: 9px;
          }

          /*
             |--------------------------------------------------------------------------
             | Timeline
             |--------------------------------------------------------------------------
             */

          .timeline {
               display: flex;
               align-items: center;
               gap: 14px;
          }

          .timeline-item {
               min-width: 0;
               display: flex;
               flex: 1;
               align-items: center;
               gap: 11px;
          }

          .timeline-marker {
               width: 39px;
               height: 39px;
               display: flex;
               flex: 0 0 39px;
               align-items: center;
               justify-content: center;
               border-radius: 12px;
               background: #eef2ff;
               color: var(--ticket-primary);
          }

          .timeline-item span {
               display: block;
               margin-bottom: 4px;
               color: #94a3b8;
               font-size: 9px;
               font-weight: 750;
               text-transform: uppercase;
          }

          .timeline-item strong {
               color: #334155;
               font-size: 11px;
          }

          .timeline-line {
               width: 45px;
               height: 1px;
               background: #dfe4ec;
          }

          /*
             |--------------------------------------------------------------------------
             | Status
             |--------------------------------------------------------------------------
             */

          .status-badge {
               display: inline-flex !important;
               width: fit-content;
               align-items: center;
               justify-content: center;
               gap: 6px;
               border-radius: 999px;
               padding: 7px 10px;
               font-size: 9px !important;
               font-weight: 800;
               white-space: nowrap;
          }

          .status-badge>span {
               width: 6px;
               height: 6px;
               margin: 0;
               border-radius: 50%;
               background: currentColor;
          }

          .status-paid {
               background: #dcfce7;
               color: #15803d !important;
          }

          .status-refunded {
               background: #fef3c7;
               color: #a16207 !important;
          }

          .status-failed {
               background: #fee2e2;
               color: #b91c1c !important;
          }

          .status-unknown {
               background: #f1f5f9;
               color: #475569 !important;
          }

          /*
             |--------------------------------------------------------------------------
             | Side panel
             |--------------------------------------------------------------------------
             */

          .side-panel {
               display: grid;
               gap: 18px;
          }

          .action-card {
               overflow: hidden;
          }

          .action-card header {
               border-bottom: 1px solid var(--ticket-border);
               padding: 21px;
          }

          .action-card header span {
               display: block;
               margin-bottom: 4px;
               color: var(--ticket-primary);
               font-size: 9px;
               font-weight: 800;
               letter-spacing: 0.08em;
               text-transform: uppercase;
          }

          .action-card header h3 {
               margin: 0 0 4px;
               color: var(--ticket-heading);
               font-size: 17px;
               font-weight: 800;
          }

          .action-card header p {
               margin: 0;
               color: var(--ticket-muted);
               font-size: 10px;
          }

          .action-card-body {
               display: grid;
               gap: 9px;
               padding: 16px;
          }

          .delete-form {
               margin: 0;
          }

          .side-action {
               width: 100%;
               display: flex;
               align-items: center;
               gap: 11px;
               border: 0;
               border-radius: 14px;
               padding: 12px;
               background: transparent;
               color: #475569;
               font-family: inherit;
               text-align: left;
               text-decoration: none;
               cursor: pointer;
               transition: 0.18s ease;
          }

          .side-action:hover {
               transform: translateX(3px);
          }

          .side-action>div {
               width: 39px;
               height: 39px;
               display: flex;
               flex: 0 0 39px;
               align-items: center;
               justify-content: center;
               border-radius: 12px;
               font-size: 16px;
          }

          .side-action>span {
               min-width: 0;
               flex: 1;
          }

          .side-action strong {
               display: block;
               color: #334155;
               font-size: 11px;
               font-weight: 800;
          }

          .side-action small {
               display: block;
               margin-top: 2px;
               color: #94a3b8;
               font-size: 9px;
          }

          .side-action>i {
               color: #94a3b8;
               font-size: 11px;
          }

          .side-action-edit {
               background: #fffbeb;
          }

          .side-action-edit>div {
               background: #fef3c7;
               color: #a16207;
          }

          .side-action-list {
               background: #f8fafc;
          }

          .side-action-list>div {
               background: #e2e8f0;
               color: #475569;
          }

          .side-action-delete {
               background: #fff7f7;
          }

          .side-action-delete>div {
               background: #fee2e2;
               color: #b91c1c;
          }

          .side-action-delete strong {
               color: #b91c1c;
          }

          /*
             |--------------------------------------------------------------------------
             | Reference
             |--------------------------------------------------------------------------
             */

          .reference-card {
               padding: 21px;
          }

          .reference-icon {
               width: 45px;
               height: 45px;
               display: flex;
               align-items: center;
               justify-content: center;
               margin-bottom: 14px;
               border-radius: 14px;
               background: #ecfdf5;
               color: #059669;
               font-size: 19px;
          }

          .reference-card h3 {
               margin: 0 0 16px;
               color: var(--ticket-heading);
               font-size: 15px;
               font-weight: 800;
          }

          .reference-list {
               display: grid;
               gap: 11px;
          }

          .reference-list>div {
               display: flex;
               align-items: center;
               justify-content: space-between;
               gap: 12px;
               border-bottom: 1px dashed #e2e8f0;
               padding-bottom: 10px;
          }

          .reference-list>div:last-child {
               border-bottom: 0;
               padding-bottom: 0;
          }

          .reference-list span {
               color: #94a3b8;
               font-size: 9px;
               font-weight: 750;
               text-transform: uppercase;
          }

          .reference-list strong {
               color: #475569;
               font-size: 10px;
          }

          /*
             |--------------------------------------------------------------------------
             | Responsive
             |--------------------------------------------------------------------------
             */

          @media (max-width: 1199.98px) {
               .summary-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
               }

               .detail-layout {
                    grid-template-columns: 1fr;
               }

               .side-panel {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
               }
          }

          @media (max-width: 991.98px) {
               .travel-grid {
                    grid-template-columns: 1fr;
               }
          }

          @media (max-width: 767.98px) {
               .ticket-show-container {
                    padding: 18px 14px;
               }

               .ticket-header {
                    border-radius: 19px;
                    padding: 25px 20px;
               }

               .ticket-header-content {
                    flex-direction: column;
                    align-items: flex-start;
               }

               .header-actions {
                    width: 100%;
               }

               .edit-button,
               .back-button {
                    flex: 1;
               }

               .summary-grid,
               .information-grid,
               .side-panel {
                    grid-template-columns: 1fr;
               }

               .detail-card-header {
                    padding: 20px;
               }

               .detail-card-body {
                    padding: 0 20px;
               }

               .timeline {
                    align-items: flex-start;
                    flex-direction: column;
               }

               .timeline-line {
                    width: 1px;
                    height: 25px;
                    margin-left: 19px;
               }
          }

          @media (max-width: 480px) {
               .header-actions {
                    flex-direction: column;
               }

               .edit-button,
               .back-button {
                    width: 100%;
               }
          }
     </style>
@endsection
```
