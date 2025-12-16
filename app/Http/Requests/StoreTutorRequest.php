<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class StoreTutorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

   public function rules(): array
{
    return [
        'branch_id' => ['required', 'exists:branches,id'], // Wajib pilih dan ID harus valid
        // User Data
        'name'     => ['required', 'string', 'max:255'],
        'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],

        // Tutor Data
        'address' => ['nullable', 'string'], // Tambahan baru
        'phone'   => ['nullable', 'string', 'max:20'],
        'bio'     => ['nullable', 'string'], // Tambahan baru
        
        // Ganti 'pekerjaan' jadi 'jobs'
        'jobs'    => ['nullable', 'array'], 
        'jobs.*'  => ['string', 'max:100'],

        // Ganti 'photo' jadi 'image'
        'image'   => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
    ];
}
}