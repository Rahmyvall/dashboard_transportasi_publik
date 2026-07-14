<?php

namespace App\Http\Requests;

use App\Models\TransportMode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTransportModeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $transportMode = $this->route('transport_mode');

        $transportModeId = $transportMode instanceof TransportMode
            ? $transportMode->getKey()
            : $transportMode;

        return [
            'mode_code' => [
                'sometimes',
                'required',
                'string',
                'max:50',
                Rule::unique('transport_modes', 'mode_code')
                    ->ignore($transportModeId),
            ],
            'mode_name' => [
                'sometimes',
                'required',
                'string',
                'max:100',
            ],
            'description' => [
                'sometimes',
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
        $data = [];

        if ($this->has('mode_code')) {
            $data['mode_code'] = strtoupper(trim((string) $this->mode_code));
        }

        if ($this->has('mode_name')) {
            $data['mode_name'] = trim((string) $this->mode_name);
        }

        $this->merge($data);
    }
}
