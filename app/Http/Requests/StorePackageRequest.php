<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePackageRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'name'          => 'required|string|max:255',
        'branch_id'     => 'required|exists:branches,id',
        'grade'         => 'required|string|max:50', // Misal: 12 SMA
        'price'         => 'required|numeric|min:0',
        'duration'      => 'required|integer|min:1', // Dalam Hari
        'session_count' => 'required|integer|min:1', // Jumlah Pertemuan
        'description'   => 'nullable|string',
        
        // Validasi Array Benefits (JSON)
        'benefits'      => 'nullable|array',
        'benefits.*'    => 'string|max:255',

        // Validasi Multi-Select Tutor
        'tutors'        => 'nullable|array',
        'tutors.*'      => 'exists:tutors,id', // Pastikan ID tutor valid
        
        'category' => ['required', 'string', 'in:PRIVATE,ROMBEL'],

        'image'         => 'nullable|image|max:2048',
    ];
}
}
