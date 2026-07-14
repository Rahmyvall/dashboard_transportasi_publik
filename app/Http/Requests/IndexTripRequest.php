<?php

namespace App\Http\Requests;

use App\Enums\TripStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexTripRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => [
                'nullable',
                'string',
                'max:100',
            ],

            'status' => [
                'nullable',
                Rule::enum(TripStatus::class),
            ],

            'schedule_id' => [
                'nullable',
                'integer',
                'exists:schedules,id',
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

            'driver_id' => [
                'nullable',
                'integer',
                'exists:drivers,id',
            ],

            'planned_date' => [
                'nullable',
                'date_format:Y-m-d',
            ],

            'date_from' => [
                'nullable',
                'date_format:Y-m-d',
            ],

            'date_to' => [
                'nullable',
                'date_format:Y-m-d',
                'after_or_equal:date_from',
            ],

            'sort_by' => [
                'nullable',
                Rule::in([
                    'trip_code',
                    'planned_start_time',
                    'status',
                    'created_at',
                ]),
            ],

            'sort_direction' => [
                'nullable',
                Rule::in(['asc', 'desc']),
            ],

            'per_page' => [
                'nullable',
                'integer',
                'min:1',
                'max:100',
            ],
        ];
    }
}
