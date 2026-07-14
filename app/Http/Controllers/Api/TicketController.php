<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Route as TripRoute;
use App\Models\Ticket;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TicketController extends Controller
{
  /**
   * Metode pembayaran sesuai enum database.
   */
  private const PAYMENT_METHODS = [
    'cash',
    'emoney',
    'qris',
    'card',
    'other',
  ];

  /**
   * Status tiket sesuai enum database.
   */
  private const TICKET_STATUSES = [
    'paid',
    'refunded',
    'failed',
  ];

  /**
   * Menampilkan daftar tiket.
   *
   * Filter:
   * - search
   * - trip_id
   * - route_id
   * - vehicle_id
   * - payment_method
   * - ticket_status
   * - from
   * - to
   * - min_fare
   * - max_fare
   * - sort_by
   * - sort_direction
   * - per_page
   */
  public function index(
    Request $request
  ): AnonymousResourceCollection {
    $validated = $this->validateListRequest($request);

    $query = Ticket::query()
      ->with([
        'trip',
        'route',
        'vehicle',
      ]);

    $this->applyFilters($query, $validated);

    $sortBy = $validated['sort_by'] ?? 'issued_at';
    $sortDirection = $validated['sort_direction'] ?? 'desc';
    $perPage = $validated['per_page'] ?? 20;

    $tickets = $query
      ->orderBy($sortBy, $sortDirection)
      ->orderBy('id', $sortDirection)
      ->paginate($perPage)
      ->withQueryString();

    return TicketResource::collection($tickets)
      ->additional([
        'success' => true,
        'message' => 'Daftar tiket berhasil diambil.',
      ]);
  }

  /**
   * Menyimpan tiket baru.
   *
   * Ticket code dibuat otomatis oleh sistem.
   */
  public function store(
    StoreTicketRequest $request
  ): JsonResponse {
    $data = $request->validated();

    $data['ticket_code'] = $this->generateTicketCode();

    $data['payment_method'] ??= 'emoney';
    $data['fare'] ??= 0;
    $data['ticket_status'] ??= 'paid';
    $data['issued_at'] ??= now();

    $ticket = Ticket::query()->create($data);

    $ticket->load([
      'trip',
      'route',
      'vehicle',
    ]);

    return (new TicketResource($ticket))
      ->additional([
        'success' => true,
        'message' =>
        "Tiket {$ticket->ticket_code} berhasil dibuat.",
      ])
      ->response()
      ->setStatusCode(Response::HTTP_CREATED);
  }

  /**
   * Menampilkan detail satu tiket.
   */
  public function show(
    Ticket $ticket
  ): TicketResource {
    $ticket->loadMissing([
      'trip',
      'route',
      'vehicle',
    ]);

    return new TicketResource($ticket);
  }

  /**
   * Memperbarui tiket.
   *
   * Ticket code tidak dapat diubah.
   */
  public function update(
    UpdateTicketRequest $request,
    Ticket $ticket
  ): TicketResource {
    $data = $request->validated();

    /*
         * Pastikan kode tiket tidak bisa diubah
         * walaupun dikirim secara manual.
         */
    unset($data['ticket_code']);

    $ticket->update($data);

    $ticket->refresh()->load([
      'trip',
      'route',
      'vehicle',
    ]);

    return new TicketResource($ticket);
  }

  /**
   * Menghapus tiket.
   */
  public function destroy(
    Ticket $ticket
  ): Response {
    $ticket->delete();

    return response()->noContent();
  }

  /**
   * Menampilkan tiket berdasarkan perjalanan.
   */
  public function byTrip(
    Request $request,
    Trip $trip
  ): AnonymousResourceCollection {
    $validated = $this->validateListRequest($request);

    unset($validated['trip_id']);

    $query = Ticket::query()
      ->with([
        'trip',
        'route',
        'vehicle',
      ])
      ->where('trip_id', $trip->id);

    $this->applyFilters($query, $validated);

    $perPage = $validated['per_page'] ?? 20;

    $tickets = $query
      ->orderByDesc('issued_at')
      ->orderByDesc('id')
      ->paginate($perPage)
      ->withQueryString();

    return TicketResource::collection($tickets)
      ->additional([
        'success' => true,
        'message' =>
        'Daftar tiket perjalanan berhasil diambil.',
      ]);
  }

  /**
   * Menampilkan tiket berdasarkan rute.
   */
  public function byRoute(
    Request $request,
    TripRoute $route
  ): AnonymousResourceCollection {
    $validated = $this->validateListRequest($request);

    unset($validated['route_id']);

    $query = Ticket::query()
      ->with([
        'trip',
        'route',
        'vehicle',
      ])
      ->where('route_id', $route->id);

    $this->applyFilters($query, $validated);

    $perPage = $validated['per_page'] ?? 20;

    $tickets = $query
      ->orderByDesc('issued_at')
      ->orderByDesc('id')
      ->paginate($perPage)
      ->withQueryString();

    return TicketResource::collection($tickets)
      ->additional([
        'success' => true,
        'message' =>
        'Daftar tiket rute berhasil diambil.',
      ]);
  }

  /**
   * Menampilkan tiket berdasarkan kendaraan.
   */
  public function byVehicle(
    Request $request,
    Vehicle $vehicle
  ): AnonymousResourceCollection {
    $validated = $this->validateListRequest($request);

    unset($validated['vehicle_id']);

    $query = Ticket::query()
      ->with([
        'trip',
        'route',
        'vehicle',
      ])
      ->where('vehicle_id', $vehicle->id);

    $this->applyFilters($query, $validated);

    $perPage = $validated['per_page'] ?? 20;

    $tickets = $query
      ->orderByDesc('issued_at')
      ->orderByDesc('id')
      ->paginate($perPage)
      ->withQueryString();

    return TicketResource::collection($tickets)
      ->additional([
        'success' => true,
        'message' =>
        'Daftar tiket kendaraan berhasil diambil.',
      ]);
  }

  /**
   * Menampilkan tiket terbaru.
   */
  public function latest(): TicketResource
  {
    $ticket = Ticket::query()
      ->with([
        'trip',
        'route',
        'vehicle',
      ])
      ->orderByDesc('issued_at')
      ->orderByDesc('id')
      ->firstOrFail();

    return new TicketResource($ticket);
  }

  /**
   * Menampilkan ringkasan statistik tiket.
   *
   * Filter yang digunakan sama dengan index.
   */
  public function summary(
    Request $request
  ): JsonResponse {
    $validated = $this->validateListRequest($request);

    $query = Ticket::query();

    $this->applyFilters($query, $validated);

    $totalTickets = (clone $query)->count();

    $paidCount = (clone $query)
      ->where('ticket_status', 'paid')
      ->count();

    $refundedCount = (clone $query)
      ->where('ticket_status', 'refunded')
      ->count();

    $failedCount = (clone $query)
      ->where('ticket_status', 'failed')
      ->count();

    $totalIncome = (clone $query)
      ->where('ticket_status', 'paid')
      ->sum('fare');

    return response()->json([
      'success' => true,
      'message' =>
      'Ringkasan tiket berhasil diambil.',

      'data' => [
        'total_tickets' => $totalTickets,
        'paid' => $paidCount,
        'refunded' => $refundedCount,
        'failed' => $failedCount,

        'total_income' => (float) $totalIncome,

        'total_income_formatted' =>
        'Rp ' . number_format(
          (float) $totalIncome,
          0,
          ',',
          '.'
        ),
      ],
    ]);
  }

  /**
   * Validasi filter daftar tiket.
   */
  private function validateListRequest(
    Request $request
  ): array {
    return $request->validate([
      'search' => [
        'nullable',
        'string',
        'max:100',
      ],

      'trip_id' => [
        'nullable',
        'integer',
        'exists:trips,id',
      ],

      'route_id' => [
        'nullable',
        'integer',
        'exists:routes,id',
      ],

      'vehicle_id' => [
        'nullable',
        'integer',
        'exists:vehicles,id',
      ],

      'payment_method' => [
        'nullable',
        Rule::in(self::PAYMENT_METHODS),
      ],

      'ticket_status' => [
        'nullable',
        Rule::in(self::TICKET_STATUSES),
      ],

      'from' => [
        'nullable',
        'date',
      ],

      'to' => [
        'nullable',
        'date',
        'after_or_equal:from',
      ],

      'min_fare' => [
        'nullable',
        'numeric',
        'min:0',
      ],

      'max_fare' => [
        'nullable',
        'numeric',
        'min:0',
        'gte:min_fare',
      ],

      'sort_by' => [
        'nullable',
        Rule::in([
          'id',
          'ticket_code',
          'payment_method',
          'fare',
          'ticket_status',
          'issued_at',
          'created_at',
          'updated_at',
        ]),
      ],

      'sort_direction' => [
        'nullable',
        Rule::in([
          'asc',
          'desc',
        ]),
      ],

      'per_page' => [
        'nullable',
        'integer',
        'min:1',
        'max:100',
      ],
    ]);
  }

  /**
   * Menerapkan filter ke query tiket.
   */
  private function applyFilters(
    Builder $query,
    array $filters
  ): void {
    if (!empty($filters['search'])) {
      $search = trim($filters['search']);

      $query->where(
        function (Builder $searchQuery) use ($search): void {
          $searchQuery->where(
            'ticket_code',
            'like',
            '%' . $search . '%'
          );

          if (ctype_digit($search)) {
            $searchQuery->orWhere(
              'id',
              (int) $search
            );
          }
        }
      );
    }

    if (isset($filters['trip_id'])) {
      $query->where(
        'trip_id',
        $filters['trip_id']
      );
    }

    if (isset($filters['route_id'])) {
      $query->where(
        'route_id',
        $filters['route_id']
      );
    }

    if (isset($filters['vehicle_id'])) {
      $query->where(
        'vehicle_id',
        $filters['vehicle_id']
      );
    }

    if (!empty($filters['payment_method'])) {
      $query->where(
        'payment_method',
        $filters['payment_method']
      );
    }

    if (!empty($filters['ticket_status'])) {
      $query->where(
        'ticket_status',
        $filters['ticket_status']
      );
    }

    if (!empty($filters['from'])) {
      $query->where(
        'issued_at',
        '>=',
        $filters['from']
      );
    }

    if (!empty($filters['to'])) {
      $query->where(
        'issued_at',
        '<=',
        $filters['to']
      );
    }

    if (isset($filters['min_fare'])) {
      $query->where(
        'fare',
        '>=',
        $filters['min_fare']
      );
    }

    if (isset($filters['max_fare'])) {
      $query->where(
        'fare',
        '<=',
        $filters['max_fare']
      );
    }
  }

  /**
   * Membuat kode tiket unik otomatis.
   *
   * Contoh:
   * TKT-20260714-A8K2PL
   */
  private function generateTicketCode(): string
  {
    do {
      $ticketCode = sprintf(
        'TKT-%s-%s',
        now()->format('Ymd'),
        Str::upper(Str::random(6))
      );
    } while (
      Ticket::query()
      ->where('ticket_code', $ticketCode)
      ->exists()
    );

    return $ticketCode;
  }
}
