<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        return [
            'system_name' => ['required', 'string', 'max:120'],
            'system_tagline' => ['required', 'string', 'max:255'],
            'support_email' => ['required', 'email', 'max:255'],
            'clinic_phone' => ['required', 'string', 'max:80'],
            'clinic_address' => ['required', 'string', 'max:255'],
            'business_hours' => ['required', 'string', 'max:120'],
        ];
    }
}
