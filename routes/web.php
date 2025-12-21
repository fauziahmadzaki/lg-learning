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
Route::get('/paket', [LandingController::class, 'packages'])->name('packages.index');
Route::get('/paket/{package}', [LandingController::class, 'showPackage'])->name('packages.show');
Route::get('/paket/{package}/daftar', [LandingController::class, 'registrationForm'])->name('packages.register');
Route::get('/galeri', [LandingController::class, 'gallery'])->name('gallery.index');
Route::get('/info-jadwal', [LandingController::class, 'schedules'])->name('schedules.index');
Route::get('/pengajar', [LandingController::class, 'tutors'])->name('tutors.index');
Route::get('/kontak', [LandingController::class, 'contact'])->name('contact.index');
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




require __DIR__.'/auth.php';
