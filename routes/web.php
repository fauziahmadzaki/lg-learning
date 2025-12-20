<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\LandingController;

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/packages', [LandingController::class, 'packages'])->name('packages.index');
Route::get('/packages/{package:slug}', [LandingController::class, 'showPackage'])->name('packages.show');
Route::get('/packages/{package:slug}/register', [LandingController::class, 'registerPackage'])->name('packages.register');
Route::get('/tutors', [LandingController::class, 'tutors'])->name('tutors.index');
Route::post('/daftar', [LandingController::class, 'storeRegistration'])->name('landing.packages.store');
Route::get('/pembayaran/{invoice_code}', [LandingController::class, 'showPayment'])->name('landing.payment.show');
Route::post('/pembayaran/process', [LandingController::class, 'processPayment'])->name('landing.payment.process');

// Portal Siswa (Magic Link)
Route::get('/portal/{token}', [App\Http\Controllers\StudentPortalController::class, 'index'])->name('student.portal.index');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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
