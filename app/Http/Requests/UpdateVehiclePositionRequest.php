<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVehiclePositionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicle_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:vehicles,id',
            ],

            'trip_id' => [
                'sometimes',
                'nullable',
                'integer',
                'exists:trips,id',
            ],

            'latitude' => [
                'sometimes',
                'required',
                'numeric',
                'between:-90,90',
            ],

            'longitude' => [
                'sometimes',
                'required',
                'numeric',
                'between:-180,180',
            ],

            'speed_kmh' => [
                'sometimes',
                'required',
                'numeric',
                'min:0',
                'max:9999.99',
            ],

            'heading_degree' => [
                'sometimes',
                'nullable',
                'integer',
                'between:0,359',
            ],

            'accuracy_meter' => [
                'sometimes',
                'nullable',
                'numeric',
                'min:0',
                'max:999999.99',
            ],

            'status' => [
                'sometimes',
                'required',
                Rule::in([
                    'moving',
                    'idle',
                    'stopped',
                ]),
            ],

            'recorded_at' => [
                'sometimes',
                'required',
                'date',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'vehicle_id.exists' => 'Kendaraan tidak ditemukan.',
            'trip_id.exists' => 'Data perjalanan tidak ditemukan.',

            'latitude.between' =>
            'Latitude harus berada antara -90 sampai 90.',

            'longitude.between' =>
            'Longitude harus berada antara -180 sampai 180.',

            'speed_kmh.min' =>
            'Kecepatan tidak boleh bernilai negatif.',

            'heading_degree.between' =>
            'Arah kendaraan harus berada antara 0 sampai 359 derajat.',

            'accuracy_meter.min' =>
            'Akurasi GPS tidak boleh bernilai negatif.',

            'status.in' =>
            'Status hanya boleh moving, idle, atau stopped.',

            'recorded_at.date' =>
            'Format waktu perekaman GPS tidak valid.',
        ];
    }
}
