<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Check if user is authorized (ID 2)
        if (Auth::id() != 2) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access the admin dashboard.');
        }
        
        $employeeCount = User::count();
        $leaveCount = LeaveRequest::count();
        $pendingCount = LeaveRequest::where('status', 'Pending')->count();
        
        return view('admin-dashboard', compact('employeeCount', 'leaveCount', 'pendingCount'));
    }
} 