<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTutorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

public function rules(): array
{
    $tutor = $this->route('tutor'); // Ambil data tutor yg sedang diedit

    return [
        'branch_id' => ['required', 'exists:branches,id'],
        'packages'  => ['nullable', 'array'],
        'packages.*' => [
            'exists:packages,id',
            function ($attribute, $value, $fail) {
                $package = \App\Models\Package::find($value);
                if ($package && $package->branch_id != $this->branch_id) {
                    $fail('Paket yang dipilih tidak tersedia di cabang ini.');
                }
            }
        ],

        'name'     => ['required', 'string', 'max:255'],
        'email'    => ['required', 'email', Rule::unique('users')->ignore($tutor->user_id)],
        'password' => ['nullable', 'confirmed', 'min:8'],

        'address' => ['nullable', 'string'],
        'phone'   => ['nullable', 'string', 'max:20'],
        'bio'     => ['nullable', 'string'],
        
        'jobs'    => ['nullable', 'array'],
        'jobs.*'  => ['string'],
        
        'image'   => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
    ];
}
}