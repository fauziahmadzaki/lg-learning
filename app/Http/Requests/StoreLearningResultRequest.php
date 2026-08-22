<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLearningResultRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tutor_id'       => ['nullable', 'exists:tutors,id'],
            'session_date'   => ['required', 'date'],
            'session_number' => ['required', 'integer', 'min:1'],
            'topic'          => ['required', 'string', 'max:255'],
            'attendance'     => ['required', 'in:hadir,izin,alfa'],
            'score'          => ['nullable', 'integer', 'min:0', 'max:100'],
            'notes'          => ['nullable', 'string'],
            'homework'       => ['nullable', 'string', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'tutor_id'       => 'tutor',
            'session_date'   => 'tanggal sesi',
            'session_number' => 'pertemuan ke-',
            'topic'          => 'materi',
            'attendance'     => 'kehadiran',
            'score'          => 'nilai',
            'notes'          => 'catatan',
            'homework'       => 'PR',
        ];
    }
}
