<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePassengerCountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'trip_id' => [
                'required',
                'integer',
                'exists:trips,id',
            ],

            'vehicle_id' => [
                'required',
                'integer',
                'exists:vehicles,id',
            ],

            'stop_id' => [
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
                'nullable',
                'integer',
                'min:1',
            ],

            'recorded_at' => [
                'required',
                'date',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'trip_id.required' => 'Trip wajib diisi.',
            'trip_id.exists' => 'Trip tidak ditemukan.',

            'vehicle_id.required' => 'Vehicle wajib diisi.',
            'vehicle_id.exists' => 'Vehicle tidak ditemukan.',

            'stop_id.exists' => 'Stop tidak ditemukan.',

            'boarding_count.min' => 'Jumlah penumpang naik tidak boleh negatif.',
            'alighting_count.min' => 'Jumlah penumpang turun tidak boleh negatif.',
            'current_load.min' => 'Jumlah penumpang saat ini tidak boleh negatif.',

            'vehicle_capacity.min' => 'Kapasitas kendaraan minimal 1.',

            'recorded_at.required' => 'Waktu pencatatan wajib diisi.',
            'recorded_at.date' => 'Format waktu pencatatan tidak valid.',
        ];
    }

    public function after(): array
    {
        return [
            function ($validator) {
                $currentLoad = (int) $this->input('current_load', 0);
                $capacity = $this->input('vehicle_capacity');

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
