<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePassengerCountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'trip_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:trips,id',
            ],

            'vehicle_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:vehicles,id',
            ],

            'stop_id' => [
                'sometimes',
                'nullable',
                'integer',
                'exists:stops,id',
            ],

            'boarding_count' => [
                'sometimes',
                'integer',
                'min:0',
            ],

            'alighting_count' => [
                'sometimes',
                'integer',
                'min:0',
            ],

            'current_load' => [
                'sometimes',
                'integer',
                'min:0',
            ],

            'vehicle_capacity' => [
                'sometimes',
                'nullable',
                'integer',
                'min:1',
            ],

            'recorded_at' => [
                'sometimes',
                'required',
                'date',
            ],
        ];
    }

    public function after(): array
    {
        return [
            function ($validator) {
                $passengerCount = $this->route('passenger_count');

                $currentLoad = (int) $this->input(
                    'current_load',
                    $passengerCount?->current_load ?? 0
                );

                $capacity = $this->has('vehicle_capacity')
                    ? $this->input('vehicle_capacity')
                    : $passengerCount?->vehicle_capacity;

                if ($capacity !== null && $currentLoad > (int) $capacity) {
                    $validator->errors()->add(
                        'current_load',
                        'Jumlah penumpang saat ini tidak boleh melebihi kapasitas kendaraan.'
                    );
                }
            },
        ];
    }
}
