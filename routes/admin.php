<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TutorController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\PackageCategoryController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\ManualBookController;

Route::middleware(['auth', 'verified', 'central.admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function(){

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('cabang', BranchController::class)->names('branches')->parameters([
        'cabang' => 'branch',
    ])->except(['show']);
    
    // Custom Show Route (Detail)
    Route::get('cabang/{branch}/detail', [BranchController::class, 'show'])->name('branches.show');
    Route::resource('tutor', TutorController::class)->names('tutors');
    Route::resource('paket', PackageController::class)->names('packages')->parameters([
        'paket' => 'package'
    ]);
    Route::resource('paket-kategori', PackageCategoryController::class)->names('package-categories')->parameters([
        'paket-kategori' => 'packageCategory'
    ]);
    Route::resource('siswa', StudentController::class)->names('students')->parameters([
        'siswa' => 'student'
    ]);
    // Route khusus buat tagihan manual
    Route::post('/siswa/{student}/bill', [StudentController::class, 'storeBill'])->name('students.bill.store');
    Route::post('/siswa/{student}/pay-manual', [StudentController::class, 'storeManualPayment'])->name('students.pay.manual');
    Route::post('/siswa/{student}/bill/{bill}/pay', [StudentController::class, 'payBillManually'])->name('students.bills.pay_manual');
    // Tabungan (Savings)
    Route::post('/siswa/{student}/savings/deposit', [StudentController::class, 'storeDeposit'])->name('students.savings.deposit');
    Route::post('/siswa/{student}/savings/withdraw', [StudentController::class, 'storeWithdraw'])->name('students.savings.withdraw');

    // Hasil Belajar
    Route::get('/siswa/{student}/hasil-belajar/tambah', [\App\Http\Controllers\LearningResultController::class, 'create'])->name('learning-results.create');
    Route::post('/siswa/{student}/hasil-belajar', [\App\Http\Controllers\LearningResultController::class, 'store'])->name('learning-results.store');
    Route::get('/hasil-belajar/{learningResult}/edit', [\App\Http\Controllers\LearningResultController::class, 'edit'])->name('learning-results.edit');
    Route::put('/hasil-belajar/{learningResult}', [\App\Http\Controllers\LearningResultController::class, 'update'])->name('learning-results.update');
    Route::delete('/hasil-belajar/{learningResult}', [\App\Http\Controllers\LearningResultController::class, 'destroy'])->name('learning-results.destroy');

    Route::resource('/transaksi', TransactionController::class)->names('transactions')->parameters([
        'transaksi' => 'transaction'
    ]);
    
    // Manajemen Jadwal
    Route::resource('jadwal', \App\Http\Controllers\Admin\ScheduleController::class)->names('schedules')->parameters([
        'jadwal' => 'schedule'
    ]);
    
    Route::get('/laporan', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/laporan/siswa', [ReportController::class, 'students'])->name('reports.students');

    // Route Activity Logs
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])
            ->name('activity-logs.index');

    // Gallery & Content
    Route::resource('contents', ContentController::class);

    // Site Settings (Pengaturan Website)
    Route::get('/settings', [SiteSettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SiteSettingController::class, 'update'])->name('settings.update');

    // Manual Book / Panduan Sistem
    Route::get('/panduan', [ManualBookController::class, 'index'])->name('manual.index');
});
