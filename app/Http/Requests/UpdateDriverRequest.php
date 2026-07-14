<?php

namespace App\Http\Requests;

use App\Enums\DriverStatus;
use App\Models\Driver;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDriverRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $routeDriver = $this->route('driver');

        $driverId = $routeDriver instanceof Driver
            ? $routeDriver->getKey()
            : $routeDriver;

        return [
            'operator_id' => [
                'sometimes',
                'required',
                'integer',
                Rule::exists('operators', 'id'),
            ],

            'driver_name' => [
                'sometimes',
                'required',
                'string',
                'max:150',
            ],

            'license_number' => [
                'sometimes',
                'required',
                'string',
                'max:100',
                Rule::unique('drivers', 'license_number')
                    ->ignore($driverId),
            ],

            'phone' => [
                'sometimes',
                'nullable',
                'string',
                'max:30',
            ],

            'address' => [
                'sometimes',
                'nullable',
                'string',
            ],

            'status' => [
                'sometimes',
                'required',
                Rule::enum(DriverStatus::class),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'operator_id.required' => 'Operator wajib dipilih.',
            'operator_id.integer' => 'ID operator harus berupa angka.',
            'operator_id.exists' => 'Operator tidak ditemukan.',

            'driver_name.required' => 'Nama driver wajib diisi.',
            'driver_name.string' => 'Nama driver harus berupa teks.',
            'driver_name.max' => 'Nama driver maksimal 150 karakter.',

            'license_number.required' => 'Nomor SIM wajib diisi.',
            'license_number.string' => 'Nomor SIM harus berupa teks.',
            'license_number.max' => 'Nomor SIM maksimal 100 karakter.',
            'license_number.unique' => 'Nomor SIM sudah digunakan.',

            'phone.string' => 'Nomor telepon harus berupa teks.',
            'phone.max' => 'Nomor telepon maksimal 30 karakter.',

            'address.string' => 'Alamat harus berupa teks.',

            'status.enum' => 'Status harus active, inactive, atau on_duty.',
        ];
    }
}
