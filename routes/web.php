<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HRDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\LeaveRequestController as AdminLeaveRequestController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin routes
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/leave-requests', [AdminLeaveRequestController::class, 'index'])->name('admin.leave-requests.index');
    Route::get('/admin/settings', [SettingsController::class, 'index'])->name('admin.settings.index');
    Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
    Route::post('/admin/employees', [EmployeeController::class, 'store']);
    Route::post('/admin/leave-requests/{id}/update-type', [\App\Http\Controllers\Admin\LeaveRequestController::class, 'updateType'])->middleware(['auth', 'admin']);
    Route::post('/admin/leave-requests/{id}/update-fields', [\App\Http\Controllers\Admin\LeaveRequestController::class, 'updateFields'])->middleware(['auth', 'admin']);
    Route::get('/admin/leave-requests/by-month', [\App\Http\Controllers\Admin\LeaveRequestController::class, 'byMonth'])->name('admin.leave-requests.byMonth');
    // HR routes
    Route::get('/hr/dashboard', [HRDashboardController::class, 'index'])->name('hr.dashboard');
    Route::get('/hr/leave-stats', [HRDashboardController::class, 'getLeaveStats'])->name('hr.leave-stats');
    Route::post('/hr/certify-leave', [HRDashboardController::class, 'certifyLeave'])->name('hr.certify-leave');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/leave-request/create', [LeaveRequestController::class, 'create'])->name('leave.create');
    Route::post('/leave-request', [LeaveRequestController::class, 'store'])->name('leave.store');
});

require __DIR__.'/auth.php';
