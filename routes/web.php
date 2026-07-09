<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\PublicController;

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/paket', [PublicController::class, 'packages'])->name('packages.index');
Route::get('/paket/{package}', [PublicController::class, 'showPackage'])->name('packages.show');
Route::get('/paket/{package}/daftar', [PublicController::class, 'registrationForm'])->name('packages.register');
Route::get('/galeri', [PublicController::class, 'gallery'])->name('gallery.index');
Route::get('/info-jadwal', [PublicController::class, 'schedules'])->name('schedules.index');
Route::get('/pengajar', [PublicController::class, 'tutors'])->name('tutors.index');
Route::get('/kontak', [PublicController::class, 'contact'])->name('contact.index');
Route::post('/daftar', [PublicController::class, 'storeRegistration'])->name('landing.packages.store');
Route::get('/pembayaran/{invoice_code}', [PublicController::class, 'showPayment'])->name('landing.payment.show');
Route::post('/pembayaran/process', [PublicController::class, 'processPayment'])->name('landing.payment.process');
Route::get('/portal/{token}', [PublicController::class, 'studentPortal'])->name('student.portal.index');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




require __DIR__.'/auth.php';
