<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTicketRequest extends FormRequest
{
  private const PAYMENT_METHODS = [
    'cash',
    'emoney',
    'qris',
    'card',
    'other',
  ];

  private const TICKET_STATUSES = [
    'paid',
    'refunded',
    'failed',
  ];

  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      /*
             * Semua field menggunakan sometimes agar
             * API mendukung request PATCH.
             *
             * ticket_code tidak dapat diperbarui.
             */

      'trip_id' => [
        'sometimes',
        'nullable',
        'integer',
        'exists:trips,id',
      ],

      'route_id' => [
        'sometimes',
        'nullable',
        'integer',
        'exists:routes,id',
      ],

      'vehicle_id' => [
        'sometimes',
        'nullable',
        'integer',
        'exists:vehicles,id',
      ],

      'payment_method' => [
        'sometimes',
        'required',
        Rule::in(self::PAYMENT_METHODS),
      ],

      'fare' => [
        'sometimes',
        'required',
        'numeric',
        'min:0',
        'max:9999999999.99',
      ],

      'ticket_status' => [
        'sometimes',
        'required',
        Rule::in(self::TICKET_STATUSES),
      ],

      'issued_at' => [
        'sometimes',
        'required',
        'date',
      ],
    ];
  }

  public function messages(): array
  {
    return [
      'trip_id.integer' =>
      'Perjalanan yang dipilih tidak valid.',

      'trip_id.exists' =>
      'Data perjalanan tidak ditemukan.',

      'route_id.integer' =>
      'Rute yang dipilih tidak valid.',

      'route_id.exists' =>
      'Data rute tidak ditemukan.',

      'vehicle_id.integer' =>
      'Kendaraan yang dipilih tidak valid.',

      'vehicle_id.exists' =>
      'Data kendaraan tidak ditemukan.',

      'payment_method.required' =>
      'Metode pembayaran wajib diisi.',

      'payment_method.in' =>
      'Metode pembayaran tidak valid.',

      'fare.required' =>
      'Tarif tiket wajib diisi.',

      'fare.numeric' =>
      'Tarif tiket harus berupa angka.',

      'fare.min' =>
      'Tarif tiket tidak boleh kurang dari nol.',

      'fare.max' =>
      'Tarif tiket melebihi batas maksimal.',

      'ticket_status.required' =>
      'Status tiket wajib diisi.',

      'ticket_status.in' =>
      'Status tiket tidak valid.',

      'issued_at.required' =>
      'Waktu penerbitan tiket wajib diisi.',

      'issued_at.date' =>
      'Waktu penerbitan tiket tidak valid.',
    ];
  }
}
