<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id;

        return [
            'first_name'     => ['required', 'string', 'max:100'],
            'last_name'      => ['required', 'string', 'max:100'],
            'email'          => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'role'           => ['required', Rule::in(User::roles())],
            'password'       => ['nullable', 'string', 'min:8', 'confirmed'],
            'phone'          => ['nullable', 'string', 'max:50'],
            'specialization' => ['nullable', 'string', 'max:150'],
        ];
    }
}
