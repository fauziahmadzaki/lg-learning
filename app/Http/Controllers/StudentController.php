<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Services\StudentService;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Carbon\Carbon;           // <--- WAJIB: Untuk atur tanggal
use Illuminate\Support\Str; // <--- WAJIB: Untuk generate token acak

class StudentController extends Controller
{
public function index(Request $request)
{
    $search = $request->input('search');

    $students = Student::query()
        ->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                            ->orWhere('school', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(9)
        ->withQueryString();

    // --- LOGIKA LIVE SEARCH ---
    // Jika request datang dari Alpine (AJAX), kembalikan potongan view saja
    if ($request->ajax()) {
        return view('admin.student._list', compact('students'))->render();
    }

    // Jika akses biasa, kembalikan halaman full layout
    return view('admin.student.index', compact('students'));
}

    public function create()
    {
        $packages = Package::all();
        return view('admin.student.create', compact('packages'));
    }

    public function store(StoreStudentRequest $request, StudentService $studentService)
        {
            $validatedData = $request->safe()->except(['package_id']);
  
            $studentService->registerStudent($validatedData, $request->package_id);

            return redirect()->route('students.index')
                ->with('success', 'Siswa berhasil didaftarkan! Tagihan dan jadwal telah diatur otomatis.');
        }

    public function edit(Student $student)
    {
        $packages = Package::all();
        $student->load('packages');
        return view('admin.student.edit', compact('student', 'packages'));
    }

public function update(UpdateStudentRequest $request, Student $student)
    {
        // 1. Ambil data validasi
        // Kita exclude 'package_id' (karena pivot) DAN 'billing_cycle' (karena read-only)
        $studentData = $request->safe()->except(['package_id', 'billing_cycle']);

        // 2. Update data tabel students
        $student->update($studentData);

        // 3. Update Relasi Paket
        if($request->has('package_id')) {
            $student->packages()->sync($request->package_id);
        } else {
            $student->packages()->detach();
        }

        return redirect()->route('students.index')
            ->with('success', 'Data siswa berhasil diperbarui!');
    }

   public function show(Student $student)
    {
        $student->load([
            'packages',
            // Ambil Tagihan, urutkan dari yang jatuh temponya paling baru
            'bills' => function($query) {
                $query->orderBy('due_date', 'desc');
            },
            // Ambil Transaksi, urutkan dari yang terbaru dibuat
            'transactions' => function($query) {
                $query->latest(); 
            }
        ]);

        return view('admin.student.show', compact('student'));
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Data siswa berhasil dihapus');
    }
}