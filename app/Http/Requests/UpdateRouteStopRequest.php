<?php

namespace App\Http\Requests;

use App\Models\RouteStop;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRouteStopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var RouteStop|null $routeStop */
        $routeStop = $this->route('routeStop');

        $routeId = (int) $this->input(
            'route_id',
            $routeStop?->route_id
        );

        $uniqueStop = Rule::unique('route_stops', 'stop_id')
            ->where(
                fn($query) => $query
                    ->where('route_id', $routeId)
            );

        $uniqueOrder = Rule::unique('route_stops', 'stop_order')
            ->where(
                fn($query) => $query
                    ->where('route_id', $routeId)
            );

        if ($routeStop !== null) {
            $uniqueStop->ignore($routeStop->getKey());
            $uniqueOrder->ignore($routeStop->getKey());
        }

        return [
            'route_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:routes,id',
            ],

            'stop_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:stops,id',
                $uniqueStop,
            ],

            'stop_order' => [
                'sometimes',
                'required',
                'integer',
                'min:1',
                $uniqueOrder,
            ],

            'distance_from_start_km' => [
                'sometimes',
                'nullable',
                'numeric',
                'min:0',
                'max:999999.99',
                'decimal:0,2',
            ],

            'estimated_arrival_minutes' => [
                'sometimes',
                'nullable',
                'integer',
                'min:0',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'route_id.exists' => 'Rute tidak ditemukan.',

            'stop_id.exists' => 'Halte tidak ditemukan.',
            'stop_id.unique' => 'Halte tersebut sudah terdaftar pada rute ini.',

            'stop_order.integer' => 'Urutan halte harus berupa angka.',
            'stop_order.min' => 'Urutan halte minimal 1.',
            'stop_order.unique' => 'Urutan tersebut sudah digunakan pada rute ini.',

            'distance_from_start_km.numeric' => 'Jarak harus berupa angka.',
            'distance_from_start_km.min' => 'Jarak tidak boleh negatif.',
            'distance_from_start_km.decimal' => 'Jarak maksimal memiliki 2 angka desimal.',

            'estimated_arrival_minutes.integer' => 'Estimasi waktu harus berupa angka.',
            'estimated_arrival_minutes.min' => 'Estimasi waktu tidak boleh negatif.',
        ];
    }
}
