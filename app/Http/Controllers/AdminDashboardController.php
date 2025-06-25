<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $employeeCount = User::count();
        $leaveCount = LeaveRequest::count();
        $pendingCount = LeaveRequest::where('status', 'Pending')->count();
        
        return view('admin-dashboard', compact('employeeCount', 'leaveCount', 'pendingCount'));
    }
} 