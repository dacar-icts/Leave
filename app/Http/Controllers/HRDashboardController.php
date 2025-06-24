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

    public function certifyLeave(Request $request)
    {
        $request->validate([
            'leave_id' => 'required|exists:leave_requests,id',
            'as_of_date' => 'required|date',
            'vl_earned' => 'nullable|string',
            'sl_earned' => 'nullable|string',
            'vl_less' => 'nullable|string',
            'sl_less' => 'nullable|string',
            'vl_balance' => 'nullable|string',
            'sl_balance' => 'nullable|string',
        ]);

        $leave = \App\Models\LeaveRequest::findOrFail($request->leave_id);
        $leave->status = 'Certified';
        $leave->certified_at = now();
        $leave->certification_data = json_encode([
            'as_of_date' => $request->as_of_date,
            'vl_earned' => $request->vl_earned,
            'sl_earned' => $request->sl_earned,
            'vl_less' => $request->vl_less,
            'sl_less' => $request->sl_less,
            'vl_balance' => $request->vl_balance,
            'sl_balance' => $request->sl_balance,
        ]);
        $leave->save();

        return response()->json(['success' => true]);
    }
}
