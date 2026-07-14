<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOperatorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'operator_name' => [
                'required',
                'string',
                'max:100',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'email' => [
                'nullable',
                'email',
                'max:100',
                'unique:operators,email',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'status' => [
                'nullable',
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

            'status.in' => 'Status hanya boleh aktif atau nonaktif.',
        ];
    }
}
