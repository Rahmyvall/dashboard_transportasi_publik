<?php
namespace App\Http\Requests;

use App\Models\MaintenanceLog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MaintenanceLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicle_id'            => [
                'required',
                'integer',
                'exists:vehicles,id',
            ],

            'maintenance_type'      => [
                'required',
                Rule::in(array_keys(MaintenanceLog::TYPES)),
            ],

            'description'           => [
                'nullable',
                'string',
                'max:5000',
            ],

            'cost'                  => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999.99',
            ],

            'maintenance_date'      => [
                'required',
                'date',
            ],

            'next_maintenance_date' => [
                'nullable',
                'date',
                'after_or_equal:maintenance_date',
            ],

            'status'                => [
                'required',
                Rule::in(array_keys(MaintenanceLog::STATUSES)),
            ],

            'handled_by'            => [
                'nullable',
                'string',
                'max:150',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'vehicle_id.required'                  => 'Kendaraan wajib dipilih.',
            'vehicle_id.exists'                    => 'Kendaraan yang dipilih tidak ditemukan.',

            'maintenance_type.required'            => 'Jenis maintenance wajib dipilih.',
            'maintenance_type.in'                  => 'Jenis maintenance tidak valid.',

            'cost.required'                        => 'Biaya maintenance wajib diisi.',
            'cost.numeric'                         => 'Biaya maintenance harus berupa angka.',
            'cost.min'                             => 'Biaya maintenance tidak boleh kurang dari nol.',

            'maintenance_date.required'            => 'Tanggal maintenance wajib diisi.',
            'maintenance_date.date'                => 'Format tanggal maintenance tidak valid.',

            'next_maintenance_date.date'           => 'Format tanggal maintenance berikutnya tidak valid.',
            'next_maintenance_date.after_or_equal' =>
            'Tanggal maintenance berikutnya tidak boleh lebih awal dari tanggal maintenance.',

            'status.required'                      => 'Status wajib dipilih.',
            'status.in'                            => 'Status maintenance tidak valid.',

            'handled_by.max'                       => 'Nama petugas maksimal 150 karakter.',
        ];
    }

    public function attributes(): array
    {
        return [
            'vehicle_id'            => 'kendaraan',
            'maintenance_type'      => 'jenis maintenance',
            'description'           => 'deskripsi',
            'cost'                  => 'biaya',
            'maintenance_date'      => 'tanggal maintenance',
            'next_maintenance_date' => 'tanggal maintenance berikutnya',
            'status'                => 'status',
            'handled_by'            => 'petugas',
        ];
    }
}