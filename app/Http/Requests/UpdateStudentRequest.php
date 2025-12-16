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
            'name'          => ['required', 'string', 'max:255'],
            // IGNORE ID SISWA SAAT INI AGAR TIDAK ERROR UNIQUE
            'email'         => ['required', 'email', Rule::unique('students')->ignore($this->student)], 
            
            'parent_phone'  => ['required', 'numeric', 'digits_between:10,15'],
            'school'        => ['required', 'string', 'max:255'],
            'grade'         => ['required', 'string'],
            'status'        => ['required', 'in:pending,active,inactive'],
            'join_date'     => ['required', 'date'],
            
            // Validasi Paket
            'package_id'    => ['required', 'exists:packages,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'          => 'Nama Siswa',
            'email'         => 'Email Siswa',
            'parent_phone'  => 'No. WhatsApp Orang Tua',
            'school'        => 'Asal Sekolah',
            'grade'         => 'Jenjang / Kelas',
            'status'        => 'Status Pendaftaran',
            'join_date'     => 'Tanggal Bergabung',
            'package_id'    => 'Paket Belajar',
        ];
    }
}