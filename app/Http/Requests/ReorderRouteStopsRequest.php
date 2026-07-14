<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReorderRouteStopsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'route_stop_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'route_stop_ids.*' => [
                'required',
                'integer',
                'distinct',
                'exists:route_stops,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'route_stop_ids.required' => 'Daftar halte rute wajib dikirim.',
            'route_stop_ids.array' => 'Daftar halte rute harus berupa array.',
            'route_stop_ids.min' => 'Minimal terdapat satu halte.',

            'route_stop_ids.*.integer' => 'ID halte rute harus berupa angka.',
            'route_stop_ids.*.distinct' => 'ID halte rute tidak boleh duplikat.',
            'route_stop_ids.*.exists' => 'Salah satu data halte rute tidak ditemukan.',
        ];
    }
}
