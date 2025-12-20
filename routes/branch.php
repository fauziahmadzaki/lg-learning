<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Branch\DashboardController;

Route::middleware(['auth', 'verified', 'branch.check'])
    ->prefix('cabang/{branch}') // {branch} is bound to the Branch model
    ->name('branch.')
    ->group(function(){
        Route::controller(DashboardController::class)->group(function(){
            Route::get('/dashboard', 'index')->name('dashboard');
            
            // Classes / Packages
            Route::get('/kelas', 'courses')->name('courses.index');
            Route::get('/kelas/{package}', 'courseShow')->name('courses.show');

            // Reports
            Route::get('/laporan', 'reports')->name('reports.index');
        });

        // Student Management
        Route::resource('siswa', \App\Http\Controllers\Branch\StudentController::class)
            ->names('students')
            ->parameters(['siswa' => 'student']);
        
        // Manual Payment & Bill Routes
        Route::post('siswa/{student}/bill', [\App\Http\Controllers\Branch\StudentController::class, 'storeBill'])
            ->name('students.bill.store');
        Route::post('siswa/{student}/pay-manual', [\App\Http\Controllers\Branch\StudentController::class, 'storeManualPayment'])
            ->name('students.pay.manual');
        Route::post('siswa/{student}/bill/{bill}/pay', [\App\Http\Controllers\Branch\StudentController::class, 'payBillManually'])
            ->name('students.bills.pay_manual');

        // Route Reports (Branch Specific)
        Route::controller(App\Http\Controllers\Branch\ReportController::class)->group(function() {
            Route::get('reports', 'index')->name('reports.index');
            Route::get('reports/students', 'students')->name('reports.students');
        });

        // Package Management
        Route::resource('paket', \App\Http\Controllers\Branch\PackageController::class)
            ->names('packages')
            ->parameters(['paket' => 'package']);
    });
