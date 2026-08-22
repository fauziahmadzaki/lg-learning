<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'type'        => 'required|in:Kegiatan,Testimoni,Galeri',
            'image'       => 'nullable|image|max:2048',
            'description' => 'required|string',
        ];
    }
}
