<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        return [
            'first_name'     => ['required', 'string', 'max:100'],
            'last_name'      => ['required', 'string', 'max:100'],
            'email'          => ['required', 'email', 'max:255', 'unique:users,email'],
            'role'           => ['required', Rule::in(User::roles())],
            'password'       => ['required', 'string', 'min:8', 'confirmed'],
            'phone'          => ['nullable', 'string', 'max:50'],
            'specialization' => ['nullable', 'string', 'max:150'],
        ];
    }
}
