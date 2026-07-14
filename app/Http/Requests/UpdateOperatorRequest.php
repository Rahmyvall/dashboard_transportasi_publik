<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOperatorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $operatorId = $this->route('operator')?->id
            ?? $this->route('operator');

        return [
            'operator_name' => [
                'sometimes',
                'required',
                'string',
                'max:100',
            ],

            'phone' => [
                'sometimes',
                'nullable',
                'string',
                'max:20',
            ],

            'email' => [
                'sometimes',
                'nullable',
                'email',
                'max:100',
                Rule::unique('operators', 'email')
                    ->ignore($operatorId),
            ],

            'address' => [
                'sometimes',
                'nullable',
                'string',
            ],

            'status' => [
                'sometimes',
                'required',
                'in:aktif,nonaktif',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'operator_name.required' => 'Nama operator wajib diisi.',
            'operator_name.max' => 'Nama operator maksimal 100 karakter.',

            'phone.max' => 'Nomor telepon maksimal 20 karakter.',

            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'email.max' => 'Email maksimal 100 karakter.',

            'status.required' => 'Status wajib diisi.',
            'status.in' => 'Status hanya boleh aktif atau nonaktif.',
        ];
    }
}
