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
use App\Http\Controllers\Admin\EmployeeListController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin routes
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/leave-requests', [AdminLeaveRequestController::class, 'index'])->name('admin.leave-requests.index');
    Route::get('/admin/list-of-employees', [EmployeeListController::class, 'index'])->name('admin.list-of-employees.index');
    Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/employees', [EmployeeController::class, 'index']);
    Route::get('/admin/employees/{id}', [EmployeeController::class, 'show']);
    Route::post('/admin/employees', [EmployeeController::class, 'store']);
    Route::put('/admin/employees/{id}', [EmployeeController::class, 'update']);
    Route::post('/admin/leave-requests/{id}/update-type', [\App\Http\Controllers\Admin\LeaveRequestController::class, 'updateType']);
    Route::post('/admin/leave-requests/{id}/update-fields', [\App\Http\Controllers\Admin\LeaveRequestController::class, 'updateFields']);
    Route::get('/admin/leave-requests/by-month', [\App\Http\Controllers\Admin\LeaveRequestController::class, 'byMonth'])->name('admin.leave-requests.byMonth');
    Route::get('/admin/employees/export-month', [EmployeeListController::class, 'exportMonth']);
    Route::get('/admin/leave-requests/export-month', [AdminLeaveRequestController::class, 'exportMonth']);
    // HR routes
    Route::get('/hr/dashboard', [HRDashboardController::class, 'index'])->name('hr.dashboard');
    Route::get('/hr/leave-stats', [HRDashboardController::class, 'getLeaveStats'])->name('hr.leave-stats');
    Route::post('/hr/certify-leave', [HRDashboardController::class, 'certifyLeave'])->name('hr.certify-leave');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Change Password Route
    Route::get('/change-password', [App\Http\Controllers\Auth\PasswordController::class, 'showChangeForm'])->name('password.change');
    
    Route::get('/leave-request/create', [LeaveRequestController::class, 'create'])->name('leave.create');
    Route::post('/leave-request', [LeaveRequestController::class, 'store'])->name('leave.store');
    Route::get('/leave-requests/{id}', [DashboardController::class, 'show'])->name('leave.show');
    Route::get('/leave/print/{id}', [DashboardController::class, 'print'])->name('leave.print');
});

// API for Division Chief autocomplete
Route::get('/api/signatories/division-chief', [App\Http\Controllers\LeaveRequestController::class, 'divisionChiefAutocomplete'])->middleware('auth');

require __DIR__.'/auth.php';
