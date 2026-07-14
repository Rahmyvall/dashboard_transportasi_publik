@extends('layouts.app')

@section('title', $title ?? 'Manajemen Tiket')

@section('content')
     @php
          $currentTickets = $tickets->getCollection();

          $paidCount = $currentTickets->where('ticket_status', 'paid')->count();

          $refundedCount = $currentTickets->where('ticket_status', 'refunded')->count();

          $failedCount = $currentTickets->where('ticket_status', 'failed')->count();

          $income = $currentTickets->where('ticket_status', 'paid')->sum('fare');

          $paymentLabels = [
              'cash' => 'Tunai',
              'emoney' => 'E-Money',
              'qris' => 'QRIS',
              'card' => 'Kartu',
              'other' => 'Lainnya',
          ];

          $paymentIcons = [
              'cash' => 'bi-cash-stack',
              'emoney' => 'bi-wallet2',
              'qris' => 'bi-qr-code-scan',
              'card' => 'bi-credit-card',
              'other' => 'bi-three-dots',
          ];
     @endphp

     <div class="ticket-page">
          <div class="ticket-container">

               {{-- Header --}}
               <section class="ticket-header">
                    <div class="ticket-header-content">
                         <div>
                              <div class="header-label">
                                   <span></span>
                                   Manajemen Transportasi
                              </div>

                              <h1>
                                   Manajemen Tiket
                              </h1>

                              <p>
                                   Kelola tiket perjalanan, rute, kendaraan,
                                   pembayaran, tarif, dan status transaksi.
                              </p>
                         </div>

                         <a href="{{ route('admin.tickets.create') }}" class="create-ticket-button">
                              <i class="bi bi-plus-lg"></i>
                              Tambah Tiket
                         </a>
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

               {{-- Statistik --}}
               <section class="stat-grid">
                    <article class="stat-card">
                         <div class="stat-icon stat-primary">
                              <i class="bi bi-ticket-perforated"></i>
                         </div>

                         <div>
                              <span class="stat-title">
                                   Total Tiket
                              </span>

                              <strong class="stat-value">
                                   {{ number_format($tickets->total(), 0, ',', '.') }}
                              </strong>

                              <span class="stat-description">
                                   Seluruh data tiket
                              </span>
                         </div>
                    </article>

                    <article class="stat-card">
                         <div class="stat-icon stat-success">
                              <i class="bi bi-check-circle"></i>
                         </div>

                         <div>
                              <span class="stat-title">
                                   Sudah Dibayar
                              </span>

                              <strong class="stat-value">
                                   {{ number_format($paidCount, 0, ',', '.') }}
                              </strong>

                              <span class="stat-description">
                                   Pada halaman ini
                              </span>
                         </div>
                    </article>

                    <article class="stat-card">
                         <div class="stat-icon stat-warning">
                              <i class="bi bi-arrow-counterclockwise"></i>
                         </div>

                         <div>
                              <span class="stat-title">
                                   Dikembalikan
                              </span>

                              <strong class="stat-value">
                                   {{ number_format($refundedCount, 0, ',', '.') }}
                              </strong>

                              <span class="stat-description">
                                   Pada halaman ini
                              </span>
                         </div>
                    </article>

                    <article class="stat-card">
                         <div class="stat-icon stat-income">
                              <i class="bi bi-cash-coin"></i>
                         </div>

                         <div>
                              <span class="stat-title">
                                   Pendapatan
                              </span>

                              <strong class="stat-value stat-currency">
                                   Rp {{ number_format((float) $income, 0, ',', '.') }}
                              </strong>

                              <span class="stat-description">
                                   Tiket dibayar di halaman ini
                              </span>
                         </div>
                    </article>
               </section>

               {{-- Data card --}}
               <section class="data-card">
                    <header class="data-card-header">
                         <div>
                              <span class="data-eyebrow">
                                   Data Tiket
                              </span>

                              <h2>
                                   Daftar Transaksi Tiket
                              </h2>

                              <p>
                                   Menampilkan
                                   {{ $tickets->firstItem() ?? 0 }}
                                   sampai
                                   {{ $tickets->lastItem() ?? 0 }}
                                   dari
                                   {{ $tickets->total() }}
                                   data.
                              </p>
                         </div>

                         <div class="data-header-actions">
                              <span class="active-badge">
                                   <span></span>
                                   Data Aktif
                              </span>

                              <button type="button" class="refresh-button" onclick="window.location.reload()"
                                   title="Muat ulang">
                                   <i class="bi bi-arrow-clockwise"></i>
                              </button>
                         </div>
                    </header>

                    {{-- Filter --}}
                    <div class="filter-toolbar">
                         <div class="search-input">
                              <i class="bi bi-search"></i>

                              <input type="search" id="ticketSearch"
                                   placeholder="Cari kode tiket, perjalanan, rute, atau kendaraan..." autocomplete="off">
                         </div>

                         <select id="statusFilter" class="filter-select">
                              <option value="">Semua Status</option>
                              <option value="paid">Dibayar</option>
                              <option value="refunded">Dikembalikan</option>
                              <option value="failed">Gagal</option>
                         </select>

                         <select id="paymentFilter" class="filter-select">
                              <option value="">Semua Pembayaran</option>
                              <option value="cash">Tunai</option>
                              <option value="emoney">E-Money</option>
                              <option value="qris">QRIS</option>
                              <option value="card">Kartu</option>
                              <option value="other">Lainnya</option>
                         </select>

                         <button type="button" id="resetFilter" class="reset-button">
                              <i class="bi bi-arrow-counterclockwise"></i>
                              Reset
                         </button>
                    </div>

                    {{-- Table --}}
                    <div class="ticket-table-responsive">
                         <table class="ticket-table">
                              <thead>
                                   <tr>
                                        <th>No.</th>
                                        <th>Informasi Tiket</th>
                                        <th>Perjalanan</th>
                                        <th>Rute</th>
                                        <th>Kendaraan</th>
                                        <th>Pembayaran</th>
                                        <th>Tarif</th>
                                        <th>Status</th>
                                        <th>Diterbitkan</th>
                                        <th class="text-center">Aksi</th>
                                   </tr>
                              </thead>

                              <tbody>
                                   @forelse ($tickets as $ticket)
                                        @php
                                             $tripName =
                                                 data_get($ticket->trip, 'trip_code') ??
                                                 (data_get($ticket->trip, 'code') ??
                                                     (data_get($ticket->trip, 'name') ??
                                                         ($ticket->trip_id
                                                             ? 'Perjalanan #' . $ticket->trip_id
                                                             : 'Tidak dipilih')));

                                             $routeOrigin =
                                                 data_get($ticket->route, 'origin') ??
                                                 data_get($ticket->route, 'start_point');

                                             $routeDestination =
                                                 data_get($ticket->route, 'destination') ??
                                                 data_get($ticket->route, 'end_point');

                                             if ($routeOrigin && $routeDestination) {
                                                 $routeName = $routeOrigin . ' → ' . $routeDestination;
                                             } else {
                                                 $routeName =
                                                     data_get($ticket->route, 'route_name') ??
                                                     (data_get($ticket->route, 'name') ??
                                                         (data_get($ticket->route, 'route_code') ??
                                                             ($ticket->route_id
                                                                 ? 'Rute #' . $ticket->route_id
                                                                 : 'Tidak dipilih')));
                                             }

                                             $vehicleName =
                                                 data_get($ticket->vehicle, 'plate_number') ??
                                                 (data_get($ticket->vehicle, 'license_plate') ??
                                                     (data_get($ticket->vehicle, 'vehicle_name') ??
                                                         (data_get($ticket->vehicle, 'name') ??
                                                             ($ticket->vehicle_id
                                                                 ? 'Kendaraan #' . $ticket->vehicle_id
                                                                 : 'Tidak dipilih'))));

                                             $vehicleCode =
                                                 data_get($ticket->vehicle, 'vehicle_code') ??
                                                 data_get($ticket->vehicle, 'code');

                                             $paymentName =
                                                 $paymentLabels[$ticket->payment_method] ??
                                                 ucfirst($ticket->payment_method);

                                             $paymentIcon = $paymentIcons[$ticket->payment_method] ?? 'bi-wallet2';

                                             $searchText = strtolower(
                                                 implode(' ', [
                                                     $ticket->ticket_code,
                                                     $tripName,
                                                     $routeName,
                                                     $vehicleName,
                                                     $paymentName,
                                                 ]),
                                             );
                                        @endphp

                                        <tr class="ticket-row" data-search="{{ $searchText }}"
                                             data-status="{{ $ticket->ticket_status }}"
                                             data-payment="{{ $ticket->payment_method }}">
                                             <td class="number-cell">
                                                  {{ ($tickets->firstItem() ?? 1) + $loop->index }}
                                             </td>

                                             {{-- Ticket --}}
                                             <td>
                                                  <div class="ticket-info">
                                                       <div class="ticket-icon">
                                                            <i class="bi bi-ticket-perforated-fill"></i>
                                                       </div>

                                                       <div>
                                                            <a href="{{ route('admin.tickets.show', $ticket) }}"
                                                                 class="ticket-code">
                                                                 {{ $ticket->ticket_code }}
                                                            </a>

                                                            <small>
                                                                 ID #{{ $ticket->id }}
                                                            </small>
                                                       </div>
                                                  </div>
                                             </td>

                                             {{-- Trip --}}
                                             <td>
                                                  <div class="primary-value">
                                                       {{ $tripName }}
                                                  </div>

                                                  @if ($ticket->trip_id)
                                                       <small class="secondary-value">
                                                            ID #{{ $ticket->trip_id }}
                                                       </small>
                                                  @endif
                                             </td>

                                             {{-- Route --}}
                                             <td>
                                                  <div class="route-info">
                                                       <i class="bi bi-signpost-split"></i>

                                                       <span>
                                                            {{ $routeName }}
                                                       </span>
                                                  </div>

                                                  @if ($ticket->route_id)
                                                       <small class="secondary-value">
                                                            ID #{{ $ticket->route_id }}
                                                       </small>
                                                  @endif
                                             </td>

                                             {{-- Vehicle --}}
                                             <td>
                                                  <div class="vehicle-info">
                                                       <div class="vehicle-icon">
                                                            <i class="bi bi-bus-front"></i>
                                                       </div>

                                                       <div>
                                                            <strong>
                                                                 {{ $vehicleName }}
                                                            </strong>

                                                            <small>
                                                                 {{ $vehicleCode ?: ($ticket->vehicle_id ? 'ID #' . $ticket->vehicle_id : '-') }}
                                                            </small>
                                                       </div>
                                                  </div>
                                             </td>

                                             {{-- Payment --}}
                                             <td>
                                                  <span class="payment-badge payment-{{ $ticket->payment_method }}">
                                                       <i class="bi {{ $paymentIcon }}"></i>
                                                       {{ $paymentName }}
                                                  </span>
                                             </td>

                                             {{-- Fare --}}
                                             <td>
                                                  <strong class="fare-value">
                                                       Rp
                                                       {{ number_format((float) $ticket->fare, 0, ',', '.') }}
                                                  </strong>
                                             </td>

                                             {{-- Status --}}
                                             <td>
                                                  @switch($ticket->ticket_status)
                                                       @case('paid')
                                                            <span class="status-badge status-paid">
                                                                 <span></span>
                                                                 Dibayar
                                                            </span>
                                                       @break

                                                       @case('refunded')
                                                            <span class="status-badge status-refunded">
                                                                 <span></span>
                                                                 Dikembalikan
                                                            </span>
                                                       @break

                                                       @case('failed')
                                                            <span class="status-badge status-failed">
                                                                 <span></span>
                                                                 Gagal
                                                            </span>
                                                       @break

                                                       @default
                                                            <span class="status-badge status-default">
                                                                 <span></span>
                                                                 {{ ucfirst($ticket->ticket_status) }}
                                                            </span>
                                                  @endswitch
                                             </td>

                                             {{-- Date --}}
                                             <td>
                                                  @if ($ticket->issued_at)
                                                       <div class="date-info">
                                                            <i class="bi bi-calendar3"></i>

                                                            <div>
                                                                 <strong>
                                                                      {{ $ticket->issued_at->format('d M Y') }}
                                                                 </strong>

                                                                 <small>
                                                                      {{ $ticket->issued_at->format('H:i') }}
                                                                      WIB
                                                                 </small>
                                                            </div>
                                                       </div>
                                                  @else
                                                       <span class="empty-value">-</span>
                                                  @endif
                                             </td>

                                             {{-- Actions --}}
                                             <td>
                                                  <div class="action-buttons">
                                                       <a href="{{ route('admin.tickets.show', $ticket) }}"
                                                            class="action-button action-view" title="Detail tiket">
                                                            <i class="bi bi-eye"></i>
                                                       </a>

                                                       <a href="{{ route('admin.tickets.edit', $ticket) }}"
                                                            class="action-button action-edit" title="Edit tiket">
                                                            <i class="bi bi-pencil"></i>
                                                       </a>

                                                       <form action="{{ route('admin.tickets.destroy', $ticket) }}"
                                                            method="POST" class="delete-form"
                                                            onsubmit="return confirm(
                                                'Yakin ingin menghapus tiket {{ $ticket->ticket_code }}?'
                                            )">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="action-button action-delete"
                                                                 title="Hapus tiket">
                                                                 <i class="bi bi-trash"></i>
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
                                                                 <i class="bi bi-ticket-perforated"></i>
                                                            </div>

                                                            <h3>
                                                                 Belum Ada Data Tiket
                                                            </h3>

                                                            <p>
                                                                 Tambahkan tiket pertama untuk mulai
                                                                 mengelola transaksi perjalanan.
                                                            </p>

                                                            <a href="{{ route('admin.tickets.create') }}"
                                                                 class="empty-create-button">
                                                                 <i class="bi bi-plus-lg"></i>
                                                                 Tambah Tiket
                                                            </a>
                                                       </div>
                                                  </td>
                                             </tr>
                                        @endforelse

                                        <tr id="filterEmptyRow" class="hidden-row">
                                             <td colspan="10">
                                                  <div class="empty-state">
                                                       <div class="empty-state-icon">
                                                            <i class="bi bi-search"></i>
                                                       </div>

                                                       <h3>
                                                            Data Tidak Ditemukan
                                                       </h3>

                                                       <p>
                                                            Coba gunakan kata kunci atau filter berbeda.
                                                       </p>
                                                  </div>
                                             </td>
                                        </tr>
                                   </tbody>
                              </table>
                         </div>

                         {{-- Pagination --}}
                         <footer class="data-card-footer">
                              <div>
                                   Menampilkan
                                   <strong>{{ $tickets->firstItem() ?? 0 }}</strong>
                                   sampai
                                   <strong>{{ $tickets->lastItem() ?? 0 }}</strong>
                                   dari
                                   <strong>{{ $tickets->total() }}</strong>
                                   tiket
                              </div>

                              @if ($tickets->hasPages())
                                   <div class="pagination-container">
                                        {{ $tickets->links('pagination::bootstrap-5') }}
                                   </div>
                              @endif
                         </footer>
                    </section>
               </div>
          </div>

          <style>
               :root {
                    --ticket-primary: #4f46e5;
                    --ticket-primary-dark: #3730a3;
                    --ticket-heading: #172033;
                    --ticket-text: #475569;
                    --ticket-muted: #94a3b8;
                    --ticket-border: #e7eaf0;
                    --ticket-background: #f4f7fb;
               }

               * {
                    box-sizing: border-box;
               }

               .ticket-page {
                    min-height: 100vh;
                    background:
                         radial-gradient(circle at 96% 3%,
                              rgba(79, 70, 229, 0.09),
                              transparent 24%),
                         var(--ticket-background);
               }

               .ticket-container {
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
                    color: rgba(255, 255, 255, 0.7);
                    font-size: 14px;
                    line-height: 1.7;
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

               .create-ticket-button {
                    display: inline-flex;
                    min-height: 47px;
                    flex-shrink: 0;
                    align-items: center;
                    justify-content: center;
                    gap: 9px;
                    border-radius: 13px;
                    padding: 11px 19px;
                    background: #ffffff;
                    color: var(--ticket-primary-dark);
                    font-size: 13px;
                    font-weight: 700;
                    text-decoration: none;
                    box-shadow: 0 13px 30px rgba(15, 23, 42, 0.2);
                    transition: 0.2s ease;
               }

               .create-ticket-button:hover {
                    color: var(--ticket-primary-dark);
                    transform: translateY(-2px);
                    box-shadow: 0 17px 35px rgba(15, 23, 42, 0.28);
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
                    box-shadow: 0 10px 28px rgba(15, 23, 42, 0.06);
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
                    background: rgba(255, 255, 255, 0.75);
                    font-size: 19px;
               }

               .ticket-alert strong {
                    display: block;
                    font-size: 13px;
               }

               .ticket-alert p {
                    margin: 2px 0 0;
                    font-size: 12px;
               }

               /*
              |--------------------------------------------------------------------------
              | Statistik
              |--------------------------------------------------------------------------
              */

               .stat-grid {
                    display: grid;
                    grid-template-columns: repeat(4, minmax(0, 1fr));
                    gap: 16px;
                    margin-bottom: 24px;
               }

               .stat-card {
                    min-width: 0;
                    display: flex;
                    align-items: center;
                    gap: 16px;
                    border: 1px solid rgba(226, 232, 240, 0.85);
                    border-radius: 19px;
                    padding: 21px;
                    background: #ffffff;
                    box-shadow: 0 14px 38px rgba(15, 23, 42, 0.055);
                    transition: 0.2s ease;
               }

               .stat-card:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 18px 44px rgba(15, 23, 42, 0.09);
               }

               .stat-icon {
                    width: 54px;
                    height: 54px;
                    display: flex;
                    flex: 0 0 54px;
                    align-items: center;
                    justify-content: center;
                    border-radius: 16px;
                    font-size: 22px;
               }

               .stat-primary {
                    background: #eef2ff;
                    color: #4f46e5;
               }

               .stat-success {
                    background: #dcfce7;
                    color: #15803d;
               }

               .stat-warning {
                    background: #fef3c7;
                    color: #a16207;
               }

               .stat-income {
                    background: #e0f2fe;
                    color: #0369a1;
               }

               .stat-title {
                    display: block;
                    margin-bottom: 3px;
                    color: #8792a5;
                    font-size: 10px;
                    font-weight: 800;
                    letter-spacing: 0.07em;
                    text-transform: uppercase;
               }

               .stat-value {
                    display: block;
                    overflow: hidden;
                    color: var(--ticket-heading);
                    font-size: 25px;
                    font-weight: 800;
                    line-height: 1.25;
                    text-overflow: ellipsis;
                    white-space: nowrap;
               }

               .stat-currency {
                    font-size: 19px;
               }

               .stat-description {
                    color: var(--ticket-muted);
                    font-size: 10px;
               }

               /*
              |--------------------------------------------------------------------------
              | Data card
              |--------------------------------------------------------------------------
              */

               .data-card {
                    overflow: hidden;
                    border: 1px solid rgba(226, 232, 240, 0.85);
                    border-radius: 22px;
                    background: #ffffff;
                    box-shadow: 0 18px 50px rgba(15, 23, 42, 0.065);
               }

               .data-card-header {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 20px;
                    border-bottom: 1px solid var(--ticket-border);
                    padding: 24px;
               }

               .data-eyebrow {
                    display: block;
                    margin-bottom: 5px;
                    color: var(--ticket-primary);
                    font-size: 10px;
                    font-weight: 800;
                    letter-spacing: 0.1em;
                    text-transform: uppercase;
               }

               .data-card-header h2 {
                    margin: 0 0 5px;
                    color: var(--ticket-heading);
                    font-size: 21px;
                    font-weight: 800;
               }

               .data-card-header p {
                    margin: 0;
                    color: #8490a4;
                    font-size: 11px;
               }

               .data-header-actions {
                    display: flex;
                    align-items: center;
                    gap: 9px;
               }

               .active-badge {
                    display: inline-flex;
                    align-items: center;
                    gap: 7px;
                    border-radius: 999px;
                    padding: 8px 12px;
                    background: #ecfdf5;
                    color: #047857;
                    font-size: 10px;
                    font-weight: 800;
                    white-space: nowrap;
               }

               .active-badge span {
                    width: 7px;
                    height: 7px;
                    border-radius: 50%;
                    background: #22c55e;
                    box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.13);
               }

               .refresh-button {
                    width: 39px;
                    height: 39px;
                    border: 1px solid #e2e8f0;
                    border-radius: 11px;
                    background: #f8fafc;
                    color: #64748b;
                    cursor: pointer;
                    transition: 0.2s ease;
               }

               .refresh-button:hover {
                    background: #eef2ff;
                    color: var(--ticket-primary);
               }

               /*
              |--------------------------------------------------------------------------
              | Filter
              |--------------------------------------------------------------------------
              */

               .filter-toolbar {
                    display: grid;
                    grid-template-columns:
                         minmax(280px, 1fr) minmax(150px, 190px) minmax(160px, 200px) auto;
                    gap: 11px;
                    border-bottom: 1px solid var(--ticket-border);
                    padding: 18px 24px;
                    background: #fbfcfe;
               }

               .search-input {
                    position: relative;
               }

               .search-input i {
                    position: absolute;
                    top: 50%;
                    left: 15px;
                    color: #9aa4b4;
                    transform: translateY(-50%);
               }

               .search-input input,
               .filter-select {
                    width: 100%;
                    min-height: 44px;
                    border: 1px solid #dfe4ec;
                    border-radius: 12px;
                    background: #ffffff;
                    color: #334155;
                    font-size: 12px;
                    outline: none;
                    transition: 0.2s ease;
               }

               .search-input input {
                    padding: 10px 15px 10px 44px;
               }

               .search-input input::placeholder {
                    color: #a1aaba;
               }

               .filter-select {
                    padding: 10px 34px 10px 13px;
                    cursor: pointer;
               }

               .search-input input:focus,
               .filter-select:focus {
                    border-color: #8b83ef;
                    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.09);
               }

               .reset-button {
                    min-height: 44px;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    gap: 7px;
                    border: 1px solid #e2e6ed;
                    border-radius: 12px;
                    padding: 10px 15px;
                    background: #ffffff;
                    color: #64748b;
                    font-size: 11px;
                    font-weight: 700;
                    cursor: pointer;
               }

               .reset-button:hover {
                    border-color: #cbd5e1;
                    color: var(--ticket-primary);
               }

               /*
              |--------------------------------------------------------------------------
              | Table
              |--------------------------------------------------------------------------
              */

               .ticket-table-responsive {
                    width: 100%;
                    overflow-x: auto;
               }

               .ticket-table {
                    width: 100%;
                    min-width: 1280px;
                    border-collapse: collapse;
               }

               .ticket-table th {
                    border-bottom: 1px solid var(--ticket-border);
                    padding: 14px 16px;
                    background: #f8fafc;
                    color: #7f8a9e;
                    font-size: 9px;
                    font-weight: 800;
                    letter-spacing: 0.07em;
                    text-align: left;
                    text-transform: uppercase;
                    white-space: nowrap;
               }

               .ticket-table td {
                    border-bottom: 1px solid #f0f2f6;
                    padding: 17px 16px;
                    color: var(--ticket-text);
                    font-size: 11px;
                    vertical-align: middle;
               }

               .ticket-table tbody tr {
                    transition: background-color 0.18s ease;
               }

               .ticket-table tbody tr:hover {
                    background: #fafbff;
               }

               .number-cell {
                    color: #9aa4b4 !important;
                    font-weight: 700;
               }

               /*
              |--------------------------------------------------------------------------
              | Informasi data
              |--------------------------------------------------------------------------
              */

               .ticket-info,
               .vehicle-info,
               .date-info {
                    display: flex;
                    align-items: center;
                    gap: 11px;
               }

               .ticket-icon,
               .vehicle-icon {
                    width: 43px;
                    height: 43px;
                    display: flex;
                    flex: 0 0 43px;
                    align-items: center;
                    justify-content: center;
                    border-radius: 13px;
               }

               .ticket-icon {
                    background: linear-gradient(135deg, #ede9fe, #e0e7ff);
                    color: var(--ticket-primary);
                    font-size: 19px;
               }

               .vehicle-icon {
                    background: #eff6ff;
                    color: #2563eb;
                    font-size: 18px;
               }

               .ticket-code {
                    display: block;
                    color: #1e293b;
                    font-size: 11px;
                    font-weight: 800;
                    text-decoration: none;
                    white-space: nowrap;
               }

               .ticket-code:hover {
                    color: var(--ticket-primary);
               }

               .ticket-info small,
               .vehicle-info small,
               .date-info small,
               .secondary-value {
                    display: block;
                    margin-top: 3px;
                    color: #9aa4b4;
                    font-size: 9px;
               }

               .primary-value,
               .vehicle-info strong,
               .date-info strong {
                    display: block;
                    color: #354156;
                    font-size: 11px;
                    font-weight: 700;
                    white-space: nowrap;
               }

               .route-info {
                    display: flex;
                    align-items: center;
                    gap: 7px;
                    color: #354156;
                    font-weight: 650;
                    white-space: nowrap;
               }

               .route-info i {
                    color: #8b5cf6;
               }

               .date-info>i {
                    color: #64748b;
                    font-size: 17px;
               }

               .fare-value {
                    color: #1f2937;
                    font-size: 11px;
                    font-weight: 800;
                    white-space: nowrap;
               }

               /*
              |--------------------------------------------------------------------------
              | Badge
              |--------------------------------------------------------------------------
              */

               .payment-badge,
               .status-badge {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    gap: 6px;
                    border-radius: 999px;
                    padding: 7px 10px;
                    font-size: 9px;
                    font-weight: 800;
                    white-space: nowrap;
               }

               .payment-cash {
                    background: #ecfdf5;
                    color: #047857;
               }

               .payment-emoney {
                    background: #eef2ff;
                    color: #4338ca;
               }

               .payment-qris {
                    background: #eff6ff;
                    color: #1d4ed8;
               }

               .payment-card {
                    background: #faf5ff;
                    color: #7e22ce;
               }

               .payment-other {
                    background: #f1f5f9;
                    color: #475569;
               }

               .status-badge span {
                    width: 6px;
                    height: 6px;
                    border-radius: 50%;
                    background: currentColor;
               }

               .status-paid {
                    background: #dcfce7;
                    color: #15803d;
               }

               .status-refunded {
                    background: #fef3c7;
                    color: #a16207;
               }

               .status-failed {
                    background: #fee2e2;
                    color: #b91c1c;
               }

               .status-default {
                    background: #f1f5f9;
                    color: #475569;
               }

               /*
              |--------------------------------------------------------------------------
              | Action
              |--------------------------------------------------------------------------
              */

               .action-buttons {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 6px;
               }

               .delete-form {
                    margin: 0;
               }

               .action-button {
                    width: 35px;
                    height: 35px;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    border: 0;
                    border-radius: 10px;
                    text-decoration: none;
                    cursor: pointer;
                    transition: 0.18s ease;
               }

               .action-button:hover {
                    transform: translateY(-2px);
               }

               .action-view {
                    background: #e0f2fe;
                    color: #0369a1;
               }

               .action-view:hover {
                    background: #0369a1;
                    color: #ffffff;
               }

               .action-edit {
                    background: #fef3c7;
                    color: #a16207;
               }

               .action-edit:hover {
                    background: #a16207;
                    color: #ffffff;
               }

               .action-delete {
                    background: #fee2e2;
                    color: #b91c1c;
               }

               .action-delete:hover {
                    background: #b91c1c;
                    color: #ffffff;
               }

               /*
              |--------------------------------------------------------------------------
              | Empty state
              |--------------------------------------------------------------------------
              */

               .empty-state {
                    max-width: 430px;
                    margin: 0 auto;
                    padding: 65px 20px;
                    text-align: center;
               }

               .empty-state-icon {
                    width: 76px;
                    height: 76px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin: 0 auto 18px;
                    border-radius: 23px;
                    background: #eef2ff;
                    color: var(--ticket-primary);
                    font-size: 31px;
               }

               .empty-state h3 {
                    margin: 0 0 8px;
                    color: var(--ticket-heading);
                    font-size: 18px;
                    font-weight: 800;
               }

               .empty-state p {
                    margin: 0 0 22px;
                    color: #8490a4;
                    font-size: 11px;
               }

               .empty-create-button {
                    display: inline-flex;
                    min-height: 43px;
                    align-items: center;
                    justify-content: center;
                    gap: 8px;
                    border-radius: 12px;
                    padding: 10px 17px;
                    background: var(--ticket-primary);
                    color: #ffffff;
                    font-size: 12px;
                    font-weight: 700;
                    text-decoration: none;
               }

               .empty-create-button:hover {
                    background: var(--ticket-primary-dark);
                    color: #ffffff;
               }

               .hidden-row {
                    display: none;
               }

               /*
              |--------------------------------------------------------------------------
              | Pagination
              |--------------------------------------------------------------------------
              */

               .data-card-footer {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 14px;
                    border-top: 1px solid var(--ticket-border);
                    padding: 18px 24px;
                    color: #8a95a8;
                    font-size: 10px;
               }

               .data-card-footer strong {
                    color: #475569;
               }

               .pagination-container .pagination {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 3px;
                    margin: 0;
                    padding: 0;
                    list-style: none;
               }

               .pagination-container .page-link {
                    min-width: 34px;
                    height: 34px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border: 0;
                    border-radius: 9px !important;
                    color: #64748b;
                    font-size: 10px;
                    text-decoration: none;
                    box-shadow: none;
               }

               .pagination-container .page-item.active .page-link {
                    background: var(--ticket-primary);
                    color: #ffffff;
               }

               /*
              |--------------------------------------------------------------------------
              | Responsive
              |--------------------------------------------------------------------------
              */

               @media (max-width: 1199.98px) {
                    .stat-grid {
                         grid-template-columns: repeat(2, minmax(0, 1fr));
                    }

                    .filter-toolbar {
                         grid-template-columns: 1fr 1fr;
                    }

                    .search-input {
                         grid-column: 1 / -1;
                    }
               }

               @media (max-width: 767.98px) {
                    .ticket-container {
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

                    .create-ticket-button {
                         width: 100%;
                    }

                    .stat-grid {
                         grid-template-columns: 1fr;
                    }

                    .data-card-header {
                         flex-direction: column;
                         align-items: flex-start;
                    }

                    .filter-toolbar {
                         grid-template-columns: 1fr;
                         padding: 16px;
                    }

                    .search-input {
                         grid-column: auto;
                    }

                    .reset-button {
                         width: 100%;
                    }

                    .data-card-footer {
                         flex-direction: column;
                    }
               }
          </style>

          <script>
               document.addEventListener('DOMContentLoaded', function() {
                    const searchInput = document.getElementById('ticketSearch');
                    const statusFilter = document.getElementById('statusFilter');
                    const paymentFilter = document.getElementById('paymentFilter');
                    const resetFilter = document.getElementById('resetFilter');
                    const rows = document.querySelectorAll('.ticket-row');
                    const emptyRow = document.getElementById('filterEmptyRow');

                    function filterTickets() {
                         const keyword = searchInput ?
                              searchInput.value.toLowerCase().trim() :
                              '';

                         const status = statusFilter ?
                              statusFilter.value :
                              '';

                         const payment = paymentFilter ?
                              paymentFilter.value :
                              '';

                         let visibleCount = 0;

                         rows.forEach(function(row) {
                              const searchableText = row.dataset.search || '';
                              const rowStatus = row.dataset.status || '';
                              const rowPayment = row.dataset.payment || '';

                              const matchesKeyword = !keyword ||
                                   searchableText.includes(keyword);

                              const matchesStatus = !status ||
                                   rowStatus === status;

                              const matchesPayment = !payment ||
                                   rowPayment === payment;

                              const isVisible =
                                   matchesKeyword &&
                                   matchesStatus &&
                                   matchesPayment;

                              row.style.display = isVisible ?
                                   '' :
                                   'none';

                              if (isVisible) {
                                   visibleCount++;
                              }
                         });

                         if (emptyRow) {
                              emptyRow.style.display =
                                   visibleCount === 0 && rows.length > 0 ?
                                   '' :
                                   'none';
                         }
                    }

                    searchInput?.addEventListener(
                         'input',
                         filterTickets
                    );

                    statusFilter?.addEventListener(
                         'change',
                         filterTickets
                    );

                    paymentFilter?.addEventListener(
                         'change',
                         filterTickets
                    );

                    resetFilter?.addEventListener(
                         'click',
                         function() {
                              if (searchInput) {
                                   searchInput.value = '';
                              }

                              if (statusFilter) {
                                   statusFilter.value = '';
                              }

                              if (paymentFilter) {
                                   paymentFilter.value = '';
                              }

                              filterTickets();
                              searchInput?.focus();
                         }
                    );
               });
          </script>
     @endsection
