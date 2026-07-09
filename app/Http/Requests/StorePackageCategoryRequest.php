<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StorePackageCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255|unique:package_categories,name',
            'slug'        => 'nullable|string|max:255|unique:package_categories,slug',
            'description' => 'nullable|string',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->filled('slug')) {
            $this->merge([
                'slug' => Str::slug($this->input('name')),
            ]);
        }
    }
}
