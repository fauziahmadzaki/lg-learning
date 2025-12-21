<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    return [
        'name'           => ['required', 'string', 'max:255'],
        
        'email'          => ['required', 'email'],
        
        'parent_phone'   => ['required', 'string', 'max:20'],
        'school'         => ['nullable', 'string', 'max:255'],
        'grade'          => ['nullable', 'string', 'max:50'],
        
        // Samakan opsi statusnya
        'status'         => ['required', 'in:active,inactive,pending'],
        
        // 'billing_cycle'  => ['required', 'in:weekly,monthly,full'],
        'package_id'     => ['required', 'exists:packages,id'],
        'join_date'      => ['required', 'date'],
    ];
}
}