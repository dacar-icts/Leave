<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use Carbon\Carbon;

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

    public function show($id)
    {
        $leave = LeaveRequest::with('user')->findOrFail($id);
        
        // Check if the user owns this leave request or is an admin/HR
        if ($leave->user_id != auth()->id() && !auth()->user()->hasRole(['admin', 'hr'])) {
            return abort(403, 'Unauthorized');
        }
        
        // Format the leave data for display
        $leaveTypes = is_string($leave->leave_type) && $leave->leave_type[0] === '[' 
            ? implode(', ', json_decode($leave->leave_type)) 
            : $leave->leave_type;
        
        // Return the view
        return view('leave.show', compact('leave', 'leaveTypes'));
    }

    public function print($id)
    {
        try {
            $leave = LeaveRequest::with('user')->findOrFail($id);
            
            // Check if the user owns this leave request or is an admin/HR
            if ($leave->user_id != auth()->id() && !auth()->user()->hasRole(['admin', 'hr'])) {
                return abort(403, 'Unauthorized');
            }
            
            // Format the leave data for display
            $leaveType = '';
            if (is_string($leave->leave_type) && $leave->leave_type[0] === '[') {
                try {
                    $decoded = json_decode($leave->leave_type);
                    $leaveType = is_array($decoded) ? implode(', ', $decoded) : $leave->leave_type;
                } catch (\Exception $e) {
                    $leaveType = $leave->leave_type;
                }
            } else {
                $leaveType = $leave->leave_type;
            }
            
            $filingDate = Carbon::parse($leave->created_at)->format('F j, Y');
            $certDate = Carbon::now()->format('F j, Y');
            
            // Get certification data if available
            $certData = [];
            if (isset($leave->certification_data)) {
                try {
                    $certData = is_string($leave->certification_data) 
                        ? json_decode($leave->certification_data, true) 
                        : $leave->certification_data;
                } catch (\Exception $e) {
                    // Silently handle JSON decode errors
                    $certData = [];
                }
            }
            
            return view('leave.print', compact('leave', 'leaveType', 'filingDate', 'certDate', 'certData'));
        } catch (\Exception $e) {
            // Return a more user-friendly error page
            return response()->view('errors.custom', [
                'message' => 'Could not load the leave request for printing.',
                'details' => $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }
}
