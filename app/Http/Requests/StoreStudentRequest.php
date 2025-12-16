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
        // Ubah jadi true agar request diizinkan
        return true; 
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'unique:students,email'], // Cek unik di tabel students
            'parent_phone'  => ['required', 'numeric', 'digits_between:10,15'], // Tambahan validasi digit
            'school'        => ['required', 'string', 'max:255'],
            'grade'         => ['required', 'string'],
            'status'        => ['required', 'in:pending,active,inactive'],
            'join_date'     => ['required', 'date'],
        ];
    }

    /**
     * Mengubah nama atribut agar pesan error lebih manusiawi.
     */
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
        ];
    }
}