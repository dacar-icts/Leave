<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HRDashboardController;
use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/hr/dashboard', [HRDashboardController::class, 'index'])->name('hr.dashboard');
    Route::get('/hr/leave-stats', [HRDashboardController::class, 'getLeaveStats'])->name('hr.leave-stats');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/leave-request/create', [LeaveRequestController::class, 'create'])->name('leave.create');
    Route::post('/leave-request', [LeaveRequestController::class, 'store'])->name('leave.store');
    
    Route::post('/hr/certify-leave', [HRDashboardController::class, 'certifyLeave'])->name('hr.certify-leave');
});

require __DIR__.'/auth.php';
