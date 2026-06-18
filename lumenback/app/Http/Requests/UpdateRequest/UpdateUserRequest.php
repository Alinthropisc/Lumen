<?php

namespace App\Http\Requests\UpdateRequest;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user') ?? $this->route('usersId');

        return [
            'name' => ['sometimes', 'string', 'min:2', 'max:100'],
            'email' => ['sometimes', 'email', 'string', Rule::unique('users', 'email')->ignore($userId)],
            'password' => ['sometimes', 'confirmed', 'min:8', 'max:100'],
        ];
    }
}
