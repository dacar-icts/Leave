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
        // Check if user is authorized (ID 190620)
        if (Auth::id() != 190620) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access the admin dashboard.');
        }
        
        $employeeCount = User::count();
        $leaveCount = LeaveRequest::count();
        $pendingCount = LeaveRequest::where('status', 'Pending')->count();

        // Yearly graph data (last 5 years)
        $currentYear = now()->year;
        $years = collect(range($currentYear - 4, $currentYear));
        $yearlyCounts = $years->map(function($year) {
            return LeaveRequest::whereYear('created_at', $year)->count();
        });
        $yearlyRequestGraphData = [
            'years' => $years->toArray(),
            'counts' => $yearlyCounts->toArray(),
        ];
        
        return view('admin-dashboard', compact('employeeCount', 'leaveCount', 'pendingCount', 'yearlyRequestGraphData'));
    }
} 