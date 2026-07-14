<?php

namespace App\Http\Requests;

use App\Enums\TripStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeTripStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => [
                'required',
                Rule::enum(TripStatus::class),
            ],

            'actual_start_time' => [
                'nullable',
                'date',
            ],

            'actual_end_time' => [
                'nullable',
                'date',
            ],

            'delay_minutes' => [
                Rule::requiredIf(
                    fn(): bool =>
                    $this->input('status') ===
                        TripStatus::Delayed->value
                ),
                'nullable',
                'integer',
                'min:1',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Status perjalanan wajib diisi.',
            'status.enum' => 'Status perjalanan tidak valid.',

            'delay_minutes.required' =>
            'Jumlah keterlambatan wajib diisi untuk status delayed.',

            'delay_minutes.min' =>
            'Jumlah keterlambatan minimal 1 menit.',
        ];
    }
}
