<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRouteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $data = [];

        if ($this->has('route_code')) {
            $data['route_code'] = strtoupper(
                trim((string) $this->input('route_code'))
            );
        }

        foreach (
            [
                'route_name',
                'origin',
                'destination',
            ] as $field
        ) {
            if ($this->has($field)) {
                $data[$field] = trim(
                    (string) $this->input($field)
                );
            }
        }

        $this->merge($data);
    }

    public function rules(): array
    {
        return [
            'operator_id' => [
                'required',
                'integer',
                Rule::exists('operators', 'id'),
            ],

            'transport_mode_id' => [
                'required',
                'integer',
                Rule::exists('transport_modes', 'id'),
            ],

            'route_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('routes', 'route_code'),
            ],

            'route_name' => [
                'required',
                'string',
                'max:150',
            ],

            'origin' => [
                'required',
                'string',
                'max:150',
                'different:destination',
            ],

            'destination' => [
                'required',
                'string',
                'max:150',
                'different:origin',
            ],

            'distance_km' => [
                'nullable',
                'numeric',
                'min:0',
                'max:999999.99',
            ],

            'estimated_duration_minutes' => [
                'nullable',
                'integer',
                'min:1',
                'max:4294967295',
            ],

            'status' => [
                'nullable',
                Rule::in([
                    'active',
                    'inactive',
                    'maintenance',
                ]),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'operator_id.required' =>
            'Operator wajib dipilih.',

            'operator_id.exists' =>
            'Operator yang dipilih tidak ditemukan.',

            'transport_mode_id.required' =>
            'Moda transportasi wajib dipilih.',

            'transport_mode_id.exists' =>
            'Moda transportasi yang dipilih tidak ditemukan.',

            'route_code.required' =>
            'Kode rute wajib diisi.',

            'route_code.unique' =>
            'Kode rute sudah digunakan.',

            'route_code.max' =>
            'Kode rute maksimal 50 karakter.',

            'route_name.required' =>
            'Nama rute wajib diisi.',

            'route_name.max' =>
            'Nama rute maksimal 150 karakter.',

            'origin.required' =>
            'Lokasi asal wajib diisi.',

            'origin.different' =>
            'Lokasi asal dan tujuan tidak boleh sama.',

            'destination.required' =>
            'Lokasi tujuan wajib diisi.',

            'destination.different' =>
            'Lokasi tujuan dan asal tidak boleh sama.',

            'distance_km.numeric' =>
            'Jarak harus berupa angka.',

            'distance_km.min' =>
            'Jarak tidak boleh kurang dari 0 kilometer.',

            'estimated_duration_minutes.integer' =>
            'Estimasi waktu harus berupa bilangan bulat.',

            'estimated_duration_minutes.min' =>
            'Estimasi waktu minimal 1 menit.',

            'status.in' =>
            'Status harus active, inactive, atau maintenance.',
        ];
    }
}
