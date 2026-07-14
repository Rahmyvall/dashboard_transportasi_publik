<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransportModeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mode_code' => [
                'required',
                'string',
                'max:50',
                'unique:transport_modes,mode_code',
            ],
            'mode_name' => [
                'required',
                'string',
                'max:100',
            ],
            'description' => [
                'nullable',
                'string',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'mode_code.required' => 'Kode moda transportasi wajib diisi.',
            'mode_code.string' => 'Kode moda transportasi harus berupa teks.',
            'mode_code.max' => 'Kode moda transportasi maksimal 50 karakter.',
            'mode_code.unique' => 'Kode moda transportasi sudah digunakan.',

            'mode_name.required' => 'Nama moda transportasi wajib diisi.',
            'mode_name.string' => 'Nama moda transportasi harus berupa teks.',
            'mode_name.max' => 'Nama moda transportasi maksimal 100 karakter.',

            'description.string' => 'Deskripsi harus berupa teks.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'mode_code' => $this->filled('mode_code')
                ? strtoupper(trim($this->mode_code))
                : null,

            'mode_name' => $this->filled('mode_name')
                ? trim($this->mode_name)
                : null,
        ]);
    }
}
