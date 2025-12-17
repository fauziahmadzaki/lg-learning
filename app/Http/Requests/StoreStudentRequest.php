<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email', 'unique:students,email'],
            'parent_phone'   => ['required', 'string', 'max:20'], // Tambah max biar aman
            'school'         => ['nullable', 'string', 'max:255'],
            'grade'          => ['nullable', 'string', 'max:50'],
            
            // PERBAIKAN BUG STATUS:
            // Tambahkan 'pending' agar sesuai dengan opsi di form view
            'status'         => ['required', 'in:active,inactive,pending'], 
            
            'billing_cycle'  => ['required', 'in:weekly,monthly,full'],
            'package_id'     => ['required', 'exists:packages,id'],
            
            // TAMBAHAN:
            'join_date'      => ['required', 'date'],
        ];
    }
}