<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRouteRequest extends FormRequest
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
        $route = $this->route('route');
        $routeId = $route?->getKey();

        return [
            'operator_id' => [
                'sometimes',
                'required',
                'integer',
                Rule::exists('operators', 'id'),
            ],

            'transport_mode_id' => [
                'sometimes',
                'required',
                'integer',
                Rule::exists('transport_modes', 'id'),
            ],

            'route_code' => [
                'sometimes',
                'required',
                'string',
                'max:50',
                Rule::unique('routes', 'route_code')
                    ->ignore($routeId),
            ],

            'route_name' => [
                'sometimes',
                'required',
                'string',
                'max:150',
            ],

            'origin' => [
                'sometimes',
                'required',
                'string',
                'max:150',
                'different:destination',
            ],

            'destination' => [
                'sometimes',
                'required',
                'string',
                'max:150',
                'different:origin',
            ],

            'distance_km' => [
                'sometimes',
                'nullable',
                'numeric',
                'min:0',
                'max:999999.99',
            ],

            'estimated_duration_minutes' => [
                'sometimes',
                'nullable',
                'integer',
                'min:1',
                'max:4294967295',
            ],

            'status' => [
                'sometimes',
                'required',
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
            'operator_id.exists' =>
            'Operator yang dipilih tidak ditemukan.',

            'transport_mode_id.exists' =>
            'Moda transportasi yang dipilih tidak ditemukan.',

            'route_code.unique' =>
            'Kode rute sudah digunakan oleh rute lain.',

            'route_code.max' =>
            'Kode rute maksimal 50 karakter.',

            'route_name.max' =>
            'Nama rute maksimal 150 karakter.',

            'origin.different' =>
            'Lokasi asal dan tujuan tidak boleh sama.',

            'destination.different' =>
            'Lokasi tujuan dan asal tidak boleh sama.',

            'distance_km.numeric' =>
            'Jarak harus berupa angka.',

            'estimated_duration_minutes.integer' =>
            'Estimasi waktu harus berupa bilangan bulat.',

            'status.in' =>
            'Status harus active, inactive, atau maintenance.',
        ];
    }
}
