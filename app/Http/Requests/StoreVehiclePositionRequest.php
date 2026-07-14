<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVehiclePositionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicle_id' => [
                'required',
                'integer',
                'exists:vehicles,id',
            ],

            'trip_id' => [
                'nullable',
                'integer',
                'exists:trips,id',
            ],

            'latitude' => [
                'required',
                'numeric',
                'between:-90,90',
            ],

            'longitude' => [
                'required',
                'numeric',
                'between:-180,180',
            ],

            'speed_kmh' => [
                'sometimes',
                'numeric',
                'min:0',
                'max:9999.99',
            ],

            'heading_degree' => [
                'nullable',
                'integer',
                'between:0,359',
            ],

            'accuracy_meter' => [
                'nullable',
                'numeric',
                'min:0',
                'max:999999.99',
            ],

            'status' => [
                'sometimes',
                Rule::in([
                    'moving',
                    'idle',
                    'stopped',
                ]),
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
            'vehicle_id.required' => 'Kendaraan wajib dipilih.',
            'vehicle_id.exists' => 'Kendaraan tidak ditemukan.',

            'trip_id.exists' => 'Data perjalanan tidak ditemukan.',

            'latitude.required' => 'Latitude wajib diisi.',
            'latitude.between' => 'Latitude harus berada antara -90 sampai 90.',

            'longitude.required' => 'Longitude wajib diisi.',
            'longitude.between' => 'Longitude harus berada antara -180 sampai 180.',

            'speed_kmh.min' => 'Kecepatan tidak boleh bernilai negatif.',

            'heading_degree.between' =>
            'Arah kendaraan harus berada antara 0 sampai 359 derajat.',

            'accuracy_meter.min' =>
            'Akurasi GPS tidak boleh bernilai negatif.',

            'status.in' =>
            'Status hanya boleh moving, idle, atau stopped.',

            'recorded_at.required' =>
            'Waktu perekaman GPS wajib diisi.',

            'recorded_at.date' =>
            'Format waktu perekaman GPS tidak valid.',
        ];
    }
}
