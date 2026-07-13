<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'role_id' => [
                'sometimes',
                'required',
                'integer',
                Rule::exists('roles', 'id'),
            ],

            'operator_id' => [
                'sometimes',
                'nullable',
                'integer',
                Rule::exists('operators', 'id'),
            ],

            'name' => [
                'sometimes',
                'required',
                'string',
                'max:100',
            ],

            'username' => [
                'sometimes',
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'username')->ignore($user),
            ],

            'email' => [
                'sometimes',
                'nullable',
                'email',
                'max:100',
                Rule::unique('users', 'email')->ignore($user),
            ],

            'password' => [
                'sometimes',
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'status' => [
                'sometimes',
                Rule::in(['aktif', 'nonaktif']),
            ],
        ];
    }
}
