<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Tutor;
use App\Models\LearningResult;
use App\Services\ActivityLogger;
use App\Http\Requests\StoreLearningResultRequest;
use App\Http\Requests\UpdateLearningResultRequest;
use Illuminate\Http\Request;

class LearningResultController extends Controller
{
    /**
     * Tampilkan form tambah hasil belajar untuk siswa tertentu.
     * Route: GET /admin/siswa/{student}/hasil-belajar/tambah
     */
    public function create(Student $student)
    {
        $tutors = Tutor::with('user')->get()->sortBy('name')->values();

        // Auto-isi session_number berikutnya
        $nextSession = $student->learningResults()->max('session_number') + 1;

        return view('admin.learning-result.create', compact('student', 'tutors', 'nextSession'));
    }

    /**
     * Simpan hasil belajar baru.
     * Route: POST /admin/siswa/{student}/hasil-belajar
     */
    public function store(StoreLearningResultRequest $request, Student $student)
    {
        $data = $request->validated();
        $data['student_id'] = $student->id;

        $result = LearningResult::create($data);

        ActivityLogger::log(
            "Admin menginput hasil belajar sesi #{$result->session_number} untuk siswa: {$student->name}",
            $student
        );

        return redirect()
            ->route('admin.students.show', $student)
            ->with('success', "Hasil belajar sesi #{$result->session_number} berhasil disimpan!");
    }

    /**
     * Tampilkan form edit hasil belajar.
     * Route: GET /admin/hasil-belajar/{learningResult}/edit
     */
    public function edit(LearningResult $learningResult)
    {
        $tutors  = Tutor::with('user')->get()->sortBy('name')->values();
        $student = $learningResult->student;

        return view('admin.learning-result.edit', compact('learningResult', 'tutors', 'student'));
    }

    /**
     * Update hasil belajar.
     * Route: PUT /admin/hasil-belajar/{learningResult}
     */
    public function update(UpdateLearningResultRequest $request, LearningResult $learningResult)
    {
        $learningResult->update($request->validated());

        ActivityLogger::log(
            "Admin memperbarui hasil belajar sesi #{$learningResult->session_number} untuk siswa: {$learningResult->student->name}",
            $learningResult->student
        );

        return redirect()
            ->route('admin.students.show', $learningResult->student)
            ->with('success', 'Hasil belajar berhasil diperbarui!');
    }

    /**
     * Hapus hasil belajar.
     * Route: DELETE /admin/hasil-belajar/{learningResult}
     */
    public function destroy(LearningResult $learningResult)
    {
        $student = $learningResult->student;
        $session = $learningResult->session_number;

        $learningResult->delete();

        ActivityLogger::log(
            "Admin menghapus hasil belajar sesi #{$session} untuk siswa: {$student->name}",
            $student
        );

        return redirect()
            ->route('admin.students.show', $student)
            ->with('success', "Hasil belajar sesi #{$session} berhasil dihapus.");
    }
}
