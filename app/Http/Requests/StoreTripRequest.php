<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTripRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'schedule_id' => [
                'nullable',
                'integer',
                'exists:schedules,id',
            ],

            'route_id' => [
                'required',
                'integer',
                'exists:routes,id',
            ],

            'vehicle_id' => [
                'required',
                'integer',
                'exists:vehicles,id',
            ],

            'driver_id' => [
                'nullable',
                'integer',
                'exists:drivers,id',
            ],

            'trip_code' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('trips', 'trip_code'),
            ],

            'planned_start_time' => [
                'required',
                'date',
            ],

            'planned_end_time' => [
                'nullable',
                'date',
                'after_or_equal:planned_start_time',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'route_id.required' => 'Rute perjalanan wajib dipilih.',
            'route_id.exists' => 'Rute perjalanan tidak ditemukan.',

            'vehicle_id.required' => 'Kendaraan wajib dipilih.',
            'vehicle_id.exists' => 'Kendaraan tidak ditemukan.',

            'driver_id.exists' => 'Pengemudi tidak ditemukan.',
            'schedule_id.exists' => 'Jadwal tidak ditemukan.',

            'trip_code.unique' => 'Kode perjalanan sudah digunakan.',

            'planned_start_time.required' => 'Waktu mulai rencana wajib diisi.',
            'planned_end_time.after_or_equal' =>
            'Waktu selesai rencana tidak boleh sebelum waktu mulai.',
        ];
    }
}
