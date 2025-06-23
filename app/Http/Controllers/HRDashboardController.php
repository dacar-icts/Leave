<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Models\User;

class HRDashboardController extends Controller
{
    public function index()
    {
        // You can filter or paginate as needed
        $leaveRequests = LeaveRequest::with('user')->latest()->get();
        $pendingCount = LeaveRequest::where('status', 'Pending')->count();

        return view('hr-dashboard', compact('leaveRequests', 'pendingCount'));
    }
}
