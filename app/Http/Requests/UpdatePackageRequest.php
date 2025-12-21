<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePackageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->has('benefits')) {
            $this->merge([
                'benefits' => array_values(array_filter($this->benefits, function ($value) {
                    return !is_null($value) && trim($value) !== '';
                })),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'branch_id'     => 'required|exists:branches,id',
            'package_category_id' => 'required|exists:package_categories,id',
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
