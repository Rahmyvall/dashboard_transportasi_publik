<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStopRequest extends FormRequest
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
        $stopId = $this->route('stop');

        return [
            'stop_code' => [
                'sometimes',
                'required',
                'string',
                'max:50',
                Rule::unique('stops', 'stop_code')
                    ->ignore($stopId),
            ],

            'stop_name' => [
                'sometimes',
                'required',
                'string',
                'max:150',
            ],

            'stop_type' => [
                'sometimes',
                'required',
                Rule::in([
                    'halte',
                    'terminal',
                    'shelter',
                    'stasiun',
                ]),
            ],

            'latitude' => [
                'sometimes',
                'nullable',
                'numeric',
                'between:-90,90',
            ],

            'longitude' => [
                'sometimes',
                'nullable',
                'numeric',
                'between:-180,180',
            ],

            'address' => [
                'sometimes',
                'nullable',
                'string',
                'max:1000',
            ],

            'is_active' => [
                'sometimes',
                'required',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'stop_code.required' => 'Kode pemberhentian tidak boleh kosong.',
            'stop_code.unique' => 'Kode pemberhentian sudah digunakan.',
            'stop_name.required' => 'Nama pemberhentian tidak boleh kosong.',
            'stop_type.in' => 'Jenis pemberhentian tidak valid.',
            'latitude.between' => 'Latitude harus antara -90 sampai 90.',
            'longitude.between' => 'Longitude harus antara -180 sampai 180.',
            'is_active.boolean' => 'Status aktif harus true atau false.',
        ];
    }
}
