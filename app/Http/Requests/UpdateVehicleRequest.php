<?php

namespace App\Http\Requests;

use App\Models\Vehicle;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $data = [];

        if ($this->exists('vehicle_code')) {
            $data['vehicle_code'] = Str::upper(
                trim((string) $this->vehicle_code)
            );
        }

        if ($this->exists('plate_number')) {
            $data['plate_number'] = filled($this->plate_number)
                ? Str::upper(trim((string) $this->plate_number))
                : null;
        }

        if ($this->exists('notes')) {
            $data['notes'] = filled($this->notes)
                ? trim((string) $this->notes)
                : null;
        }

        $this->merge($data);
    }

    public function rules(): array
    {
        /** @var Vehicle $vehicle */
        $vehicle = $this->route('vehicle');

        return [
            'operator_id' => [
                'sometimes',
                'required',
                'integer',
                Rule::exists('operators', 'id'),
            ],

            'transport_mode_id' => [
                'sometimes',
                'required',
                'integer',
                Rule::exists('transport_modes', 'id'),
            ],

            'vehicle_code' => [
                'sometimes',
                'required',
                'string',
                'max:50',
                Rule::unique('vehicles', 'vehicle_code')
                    ->ignore($vehicle),
            ],

            'plate_number' => [
                'sometimes',
                'nullable',
                'string',
                'max:50',
                Rule::unique('vehicles', 'plate_number')
                    ->ignore($vehicle),
            ],

            'capacity' => [
                'sometimes',
                'integer',
                'min:0',
            ],

            'manufacture_year' => [
                'sometimes',
                'nullable',
                'integer',
                'min:1900',
                'max:' . (now()->year + 1),
            ],

            'status' => [
                'sometimes',
                Rule::in(Vehicle::STATUSES),
            ],

            'last_service_date' => [
                'sometimes',
                'nullable',
                'date_format:Y-m-d',
                'before_or_equal:today',
            ],

            'notes' => [
                'sometimes',
                'nullable',
                'string',
                'max:5000',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'operator_id' => 'operator',
            'transport_mode_id' => 'jenis transportasi',
            'vehicle_code' => 'kode kendaraan',
            'plate_number' => 'nomor polisi',
            'capacity' => 'kapasitas',
            'manufacture_year' => 'tahun produksi',
            'status' => 'status kendaraan',
            'last_service_date' => 'tanggal servis terakhir',
            'notes' => 'catatan',
        ];
    }

    public function messages(): array
    {
        return [
            'vehicle_code.unique' => 'Kode kendaraan sudah digunakan.',
            'plate_number.unique' => 'Nomor polisi sudah digunakan.',
            'operator_id.exists' => 'Operator tidak ditemukan.',
            'transport_mode_id.exists' => 'Jenis transportasi tidak ditemukan.',
            'status.in' => 'Status kendaraan tidak valid.',
        ];
    }
}
