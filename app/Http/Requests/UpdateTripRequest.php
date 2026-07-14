<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateTripRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $trip = $this->route('trip');

        return [
            'schedule_id' => [
                'sometimes',
                'nullable',
                'integer',
                'exists:schedules,id',
            ],

            'route_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:routes,id',
            ],

            'vehicle_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:vehicles,id',
            ],

            'driver_id' => [
                'sometimes',
                'nullable',
                'integer',
                'exists:drivers,id',
            ],

            'trip_code' => [
                'sometimes',
                'required',
                'string',
                'max:100',
                Rule::unique('trips', 'trip_code')
                    ->ignore($trip?->getKey()),
            ],

            'planned_start_time' => [
                'sometimes',
                'required',
                'date',
            ],

            'planned_end_time' => [
                'sometimes',
                'nullable',
                'date',
            ],

            'notes' => [
                'sometimes',
                'nullable',
                'string',
            ],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if (
                    $validator->errors()->has('planned_start_time') ||
                    $validator->errors()->has('planned_end_time')
                ) {
                    return;
                }

                $trip = $this->route('trip');
                $input = $this->all();

                $startTime = array_key_exists(
                    'planned_start_time',
                    $input
                )
                    ? $input['planned_start_time']
                    : $trip?->planned_start_time;

                $endTime = array_key_exists(
                    'planned_end_time',
                    $input
                )
                    ? $input['planned_end_time']
                    : $trip?->planned_end_time;

                if (!$startTime || !$endTime) {
                    return;
                }

                if (Carbon::parse($endTime)->lt(Carbon::parse($startTime))) {
                    $validator->errors()->add(
                        'planned_end_time',
                        'Waktu selesai rencana tidak boleh sebelum waktu mulai.'
                    );
                }
            },
        ];
    }
}
