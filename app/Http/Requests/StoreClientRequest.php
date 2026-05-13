<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) ($this->user()?->isAdmin() || $this->user()?->isReceptionist());
    }

    public function rules(): array
    {
        return [
            'first_name'  => ['required', 'string', 'max:100'],
            'last_name'   => ['required', 'string', 'max:100'],
            'email'       => ['nullable', 'email', 'max:255'],
            'phone'       => ['required', 'string', 'max:50'],
            'address'     => ['nullable', 'string', 'max:255'],
            'notes'       => ['nullable', 'string'],
            'pet_name'    => ['required', 'string', 'max:100'],
            'pet_species' => ['required', 'string', 'max:100'],
            'pet_breed'   => ['nullable', 'string', 'max:100'],
        ];
    }
}
