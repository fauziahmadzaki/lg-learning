<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // <--- JANGAN LUPA IMPORT INI

class UpdateBranchRequest extends FormRequest
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
        // Ambil objek/ID branch dari URL
        // Karena route resource Anda menggunakan parameter 'branch'
        $branchId = $this->route('branch')->id; 

        return [
            "name" => ["required", "string", "max:255"],
            "address" => ["nullable", "string"],
            "phone" => [
                "required", 
                "numeric", 
                "digits_between:10,15", 
                // PERBAIKAN DISINI:
                // Cek unik di tabel branches kolom phone, TAPI abaikan ID milik $branchId
                Rule::unique('branches', 'phone')->ignore($branchId),
            ],
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
            "phone.unique" => "Nomor telepon cabang sudah terdaftar di cabang lain",
        ];
    }
}