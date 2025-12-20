<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ActivityLogController;

Route::middleware(['auth', 'verified', 'central.admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function(){

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
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
    // Route khusus buat tagihan manual
    Route::post('/siswa/{student}/bill', [StudentController::class, 'storeBill'])->name('students.bill.store');
    Route::post('/siswa/{student}/pay-manual', [StudentController::class, 'storeManualPayment'])->name('students.pay.manual');
    Route::post('/siswa/{student}/bill/{bill}/pay', [StudentController::class, 'payBillManually'])->name('students.bills.pay_manual');
    Route::resource('/transaksi', TransactionController::class)->names('transactions')->parameters([
        'transaksi' => 'transaction'
    ]);
    
    Route::get('/laporan', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/laporan/siswa', [ReportController::class, 'students'])->name('reports.students');

    // Route Activity Logs
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])
            ->name('activity-logs.index');

    // Gallery & Content
    Route::resource('contents', \App\Http\Controllers\ContentController::class);

    // Site Settings (Pengaturan Website)
    Route::get('/settings', [\App\Http\Controllers\SiteSettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [\App\Http\Controllers\SiteSettingController::class, 'update'])->name('settings.update');
});
