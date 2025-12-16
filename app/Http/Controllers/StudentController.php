<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStudentRequest;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Ambil query pencarian
        $search = $request->input('search');

        $students = Student::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('school', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(9)
            ->withQueryString(); // Agar pagination tetap membawa parameter search

        return view('student.index', compact('students'));
    }

    public function create()
    {
        $packages = Package::all();
        return view('student.create', compact('packages'));
    }

   public function store(StoreStudentRequest $request)
{
    // 1. Ambil semua data validasi KECUALI package_id
    // Karena package_id tidak ada di tabel students, jangan dimasukkan ke create()
    $studentData = $request->safe()->except(['package_id']);
    
    // 2. Simpan Data Siswa
    $student = Student::create($studentData);

    // 3. Simpan Relasi Paket ke tabel pivot (student_packages)
    // attach() fungsinya insert ke tabel pivot
    $student->packages()->attach($request->package_id);

    return redirect()->route('students.index')
        ->with('success', 'Siswa baru berhasil didaftarkan!');
}

public function edit(Student $student)
    {
        // Ambil semua paket untuk dropdown
        $packages = Package::all();

        // Load relasi packages milik siswa (untuk pengecekan di view)
        $student->load('packages');

        return view('student.edit', compact('student', 'packages'));
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        // 1. Ambil data validasi (kecuali package_id)
        $studentData = $request->safe()->except(['package_id']);

        // 2. Update data tabel students
        $student->update($studentData);

        // 3. Update Relasi Paket (Tabel Pivot)
        // sync() akan menghapus paket lama dan memasukkan paket baru
        $student->packages()->sync($request->package_id);

        return redirect()->route('students.index')
            ->with('success', 'Data siswa berhasil diperbarui!');
    }
    // ... method lainnya (edit, update, destroy) nanti
}