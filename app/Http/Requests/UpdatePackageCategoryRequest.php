<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdatePackageCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('packageCategory')?->id ?? $this->route('package_category');
        return [
            'name'        => 'required|string|max:255|unique:package_categories,name,' . $id,
            'slug'        => 'nullable|string|max:255|unique:package_categories,slug,' . $id,
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
