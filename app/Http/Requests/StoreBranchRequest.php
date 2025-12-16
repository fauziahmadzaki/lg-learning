<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBranchRequest extends FormRequest
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
            "name" => ["required", "string", "max:255"],
            "address" => ["nullable", "string"],
            "phone" => ["required", "numeric","digits_between:10,15", "unique:branches,phone"],
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "Nama cabang harus diisi",
            "name.string" => "Nama cabang harus berupa string",
            "name.max" => "Nama cabang tidak boleh lebih dari 255 karakter",
            "address.string" => "Alamat cabang harus berupa string",
            "phone.required" => "Nomor telepon cabang harus diisi",
            "phone.numeric" => "Nomor telepon cabang harus berupa angka",
            "phone.digits_between" => "Nomor telepon cabang harus antara 10 sampai 15 digit",
            "phone.unique" => "Nomor telepon cabang sudah terdaftar",
        ];
    }
}
