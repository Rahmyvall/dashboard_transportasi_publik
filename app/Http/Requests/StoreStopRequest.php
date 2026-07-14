<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $data = [];

        if ($this->has('stop_code')) {
            $data['stop_code'] = strtoupper(
                trim((string) $this->stop_code)
            );
        }

        if ($this->has('stop_name')) {
            $data['stop_name'] = trim(
                (string) $this->stop_name
            );
        }

        if ($this->has('stop_type')) {
            $data['stop_type'] = strtolower(
                trim((string) $this->stop_type)
            );
        }

        $this->merge($data);
    }

    public function rules(): array
    {
        return [
            'stop_code' => [
                'required',
                'string',
                'max:50',
                'unique:stops,stop_code',
            ],

            'stop_name' => [
                'required',
                'string',
                'max:150',
            ],

            'stop_type' => [
                'nullable',
                Rule::in([
                    'halte',
                    'terminal',
                    'shelter',
                    'stasiun',
                ]),
            ],

            'latitude' => [
                'nullable',
                'numeric',
                'between:-90,90',
                'required_with:longitude',
            ],

            'longitude' => [
                'nullable',
                'numeric',
                'between:-180,180',
                'required_with:latitude',
            ],

            'address' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'stop_code.required' => 'Kode pemberhentian wajib diisi.',
            'stop_code.unique' => 'Kode pemberhentian sudah digunakan.',
            'stop_name.required' => 'Nama pemberhentian wajib diisi.',
            'stop_type.in' => 'Jenis pemberhentian tidak valid.',
            'latitude.between' => 'Latitude harus antara -90 sampai 90.',
            'longitude.between' => 'Longitude harus antara -180 sampai 180.',
            'latitude.required_with' => 'Latitude wajib diisi bersama longitude.',
            'longitude.required_with' => 'Longitude wajib diisi bersama latitude.',
            'is_active.boolean' => 'Status aktif harus true atau false.',
        ];
    }
}
