<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $leaveRequests = LeaveRequest::where('user_id', auth()->id())->latest()->get();
        $pendingCount = LeaveRequest::where('user_id', auth()->id())->where('status', 'Pending')->count();
        $certifiedCount = LeaveRequest::where('user_id', auth()->id())->where('status', 'Certified')->count();
        $totalRequests = LeaveRequest::where('user_id', auth()->id())->count();
        return view('dashboard', compact('leaveRequests', 'pendingCount', 'certifiedCount', 'totalRequests'));
    }
}
