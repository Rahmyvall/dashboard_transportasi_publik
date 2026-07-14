<?php

namespace App\Http\Controllers\Api;

use App\Enums\TripStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeTripStatusRequest;
use App\Http\Requests\IndexTripRequest;
use App\Http\Requests\StoreTripRequest;
use App\Http\Requests\UpdateTripRequest;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TripController extends Controller
{
    private const RELATIONS = [
        'schedule',
        'route',
        'vehicle',
        'driver',
    ];

    /**
     * Menampilkan daftar perjalanan.
     */
    public function index(
        IndexTripRequest $request
    ): AnonymousResourceCollection {
        $data = $request->validated();

        $query = Trip::query()
            ->with(self::RELATIONS);

        if (!empty($data['search'])) {
            $search = $data['search'];

            $query->where(
                'trip_code',
                'like',
                '%' . $search . '%'
            );
        }

        if (!empty($data['status'])) {
            $query->where('status', $data['status']);
        }

        if (!empty($data['schedule_id'])) {
            $query->where(
                'schedule_id',
                $data['schedule_id']
            );
        }

        if (!empty($data['route_id'])) {
            $query->where(
                'route_id',
                $data['route_id']
            );
        }

        if (!empty($data['vehicle_id'])) {
            $query->where(
                'vehicle_id',
                $data['vehicle_id']
            );
        }

        if (!empty($data['driver_id'])) {
            $query->where(
                'driver_id',
                $data['driver_id']
            );
        }

        if (!empty($data['planned_date'])) {
            $query->whereDate(
                'planned_start_time',
                $data['planned_date']
            );
        }

        if (!empty($data['date_from'])) {
            $query->whereDate(
                'planned_start_time',
                '>=',
                $data['date_from']
            );
        }

        if (!empty($data['date_to'])) {
            $query->whereDate(
                'planned_start_time',
                '<=',
                $data['date_to']
            );
        }

        $sortBy = $data['sort_by']
            ?? 'planned_start_time';

        $sortDirection = $data['sort_direction']
            ?? 'asc';

        $perPage = $data['per_page'] ?? 15;

        $trips = $query
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage)
            ->withQueryString();

        return TripResource::collection($trips);
    }

    /**
     * Menyimpan perjalanan baru.
     */
    public function store(
        StoreTripRequest $request
    ): JsonResponse {
        $trip = DB::transaction(
            fn(): Trip => Trip::create(
                $request->validated()
            )
        );

        $trip->load(self::RELATIONS);

        return (new TripResource($trip))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Menampilkan detail perjalanan.
     */
    public function show(Trip $trip): TripResource
    {
        return new TripResource(
            $trip->load(self::RELATIONS)
        );
    }

    /**
     * Memperbarui data perjalanan.
     */
    public function update(
        UpdateTripRequest $request,
        Trip $trip
    ): TripResource {
        $trip->update($request->validated());

        return new TripResource(
            $trip->refresh()->load(self::RELATIONS)
        );
    }

    /**
     * Menghapus perjalanan.
     */
    public function destroy(Trip $trip): Response
    {
        $trip->delete();

        return response()->noContent();
    }

    /**
     * Mengubah status perjalanan.
     */
    public function changeStatus(
        ChangeTripStatusRequest $request,
        Trip $trip
    ): JsonResponse {
        $data = $request->validated();

        return DB::transaction(function () use (
            $trip,
            $data
        ): JsonResponse {
            /*
             * Lock data agar dua permintaan status tidak
             * mengubah perjalanan secara bersamaan.
             */
            $trip = Trip::query()
                ->lockForUpdate()
                ->findOrFail($trip->id);

            $currentStatus = $trip->status;
            $targetStatus = TripStatus::from(
                $data['status']
            );

            /*
             * Permintaan dengan status yang sama dibuat
             * idempotent. Berguna untuk retry dari client.
             */
            if ($currentStatus === $targetStatus) {
                $sameStatusUpdate = [];

                if (
                    $targetStatus === TripStatus::Delayed &&
                    isset($data['delay_minutes'])
                ) {
                    $sameStatusUpdate['delay_minutes'] =
                        $data['delay_minutes'];
                }

                if (array_key_exists('notes', $data)) {
                    $sameStatusUpdate['notes'] =
                        $data['notes'];
                }

                if ($sameStatusUpdate !== []) {
                    $trip->update($sameStatusUpdate);
                }

                return (new TripResource(
                    $trip->refresh()->load(self::RELATIONS)
                ))->response();
            }

            $allowedTransitions = [
                TripStatus::Scheduled->value => [
                    TripStatus::Running,
                    TripStatus::Delayed,
                    TripStatus::Cancelled,
                ],

                TripStatus::Delayed->value => [
                    TripStatus::Scheduled,
                    TripStatus::Running,
                    TripStatus::Cancelled,
                ],

                TripStatus::Running->value => [
                    TripStatus::Completed,
                    TripStatus::Cancelled,
                ],

                TripStatus::Completed->value => [],

                TripStatus::Cancelled->value => [],
            ];

            $allowedTargets =
                $allowedTransitions[$currentStatus->value]
                ?? [];

            if (
                !in_array(
                    $targetStatus,
                    $allowedTargets,
                    true
                )
            ) {
                return response()->json([
                    'message' =>
                    'Perubahan status perjalanan tidak diizinkan.',

                    'errors' => [
                        'status' => [
                            sprintf(
                                'Status %s tidak dapat diubah menjadi %s.',
                                $currentStatus->value,
                                $targetStatus->value
                            ),
                        ],
                    ],
                ], Response::HTTP_CONFLICT);
            }

            $attributes = [
                'status' => $targetStatus,
            ];

            switch ($targetStatus) {
                case TripStatus::Scheduled:
                    /*
                     * Hanya dapat kembali ke scheduled
                     * dari status delayed.
                     */
                    $attributes['delay_minutes'] = 0;
                    $attributes['actual_start_time'] = null;
                    $attributes['actual_end_time'] = null;
                    break;

                case TripStatus::Delayed:
                    $attributes['delay_minutes'] =
                        $data['delay_minutes'];

                    $attributes['actual_start_time'] = null;
                    $attributes['actual_end_time'] = null;
                    break;

                case TripStatus::Running:
                    $actualStartTime =
                        isset($data['actual_start_time'])
                        ? Carbon::parse(
                            $data['actual_start_time']
                        )
                        : now();

                    $attributes['actual_start_time'] =
                        $actualStartTime;

                    $attributes['actual_end_time'] = null;

                    /*
                     * Menghitung keterlambatan berdasarkan
                     * waktu mulai aktual dan waktu rencana.
                     */
                    $delaySeconds =
                        $actualStartTime->getTimestamp()
                        - $trip
                        ->planned_start_time
                        ->getTimestamp();

                    $attributes['delay_minutes'] = max(
                        0,
                        intdiv(
                            max(0, $delaySeconds),
                            60
                        )
                    );
                    break;

                case TripStatus::Completed:
                    if (!$trip->actual_start_time) {
                        throw ValidationException::withMessages([
                            'actual_start_time' => [
                                'Perjalanan belum memiliki waktu mulai aktual.',
                            ],
                        ]);
                    }

                    $actualEndTime =
                        isset($data['actual_end_time'])
                        ? Carbon::parse(
                            $data['actual_end_time']
                        )
                        : now();

                    if (
                        $actualEndTime->lt(
                            $trip->actual_start_time
                        )
                    ) {
                        throw ValidationException::withMessages([
                            'actual_end_time' => [
                                'Waktu selesai aktual tidak boleh sebelum waktu mulai aktual.',
                            ],
                        ]);
                    }

                    $attributes['actual_end_time'] =
                        $actualEndTime;
                    break;

                case TripStatus::Cancelled:
                    /*
                     * Jika dibatalkan ketika sedang berjalan,
                     * isi waktu berakhir aktual.
                     */
                    if (
                        $currentStatus === TripStatus::Running &&
                        !$trip->actual_end_time
                    ) {
                        $actualEndTime =
                            isset($data['actual_end_time'])
                            ? Carbon::parse(
                                $data['actual_end_time']
                            )
                            : now();

                        if (
                            $trip->actual_start_time &&
                            $actualEndTime->lt(
                                $trip->actual_start_time
                            )
                        ) {
                            throw ValidationException::withMessages([
                                'actual_end_time' => [
                                    'Waktu pembatalan tidak boleh sebelum waktu mulai aktual.',
                                ],
                            ]);
                        }

                        $attributes['actual_end_time'] =
                            $actualEndTime;
                    }
                    break;
            }

            if (array_key_exists('notes', $data)) {
                $attributes['notes'] = $data['notes'];
            }

            $trip->update($attributes);

            return (new TripResource(
                $trip->refresh()->load(self::RELATIONS)
            ))->response();
        });
    }
}
