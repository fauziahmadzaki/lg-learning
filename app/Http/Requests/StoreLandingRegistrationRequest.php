<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLandingRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'package_id'    => ['required', 'exists:packages,id'],
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email'],
            'parent_phone'  => ['required', 'numeric'],
            'school'        => ['nullable', 'string'],
            'grade'         => ['nullable', 'string'],
            'address'       => ['nullable', 'string'],
            'billing_cycle' => ['required', 'in:daily,weekly,monthly,full'],
        ];
    }
}
