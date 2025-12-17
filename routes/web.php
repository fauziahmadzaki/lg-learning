<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'verified', 'central.admin'])
->prefix('admin')
->name('admin.')
->group(function(){
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::resource('cabang', BranchController::class)->names('branches')->parameters([
        'cabang' => 'branch',
    ]);
    Route::resource('tutor', TutorController::class)->names('tutors');
    Route::resource('paket', PackageController::class)->names('packages')->parameters([
        'paket' => 'package'
    ]);
    Route::resource('siswa', StudentController::class)->names('students')->parameters([
        'siswa' => 'student'
    ]);
    Route::resource('/transaksi', TransactionController::class)->names('transactions')->parameters([
        'transaksi' => 'transaction'
    ]);
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'branch.check'])
    ->prefix('cabang/{id}')
    ->name('branch.')
    ->group(function(){
        Route::get('/dashboard', function(){
            return view('tutor.dashboard');
        })->name('dashboard');
    });

// Testing Route (Hapus nanti kalau production)
Route::get('/test-payment', function () {
    // Hardcode data dummy (pastikan ID siswa 1 dan ID paket 1 ada di DB)
    $student = \App\Models\Student::first(); 
    $package = \App\Models\Package::first();

    if (!$student || !$package) {
        return "Data siswa atau paket kosong. Isi dulu master data.";
    }

    return view('test-payment', compact('student', 'package'));
});
require __DIR__.'/auth.php';
