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
        $rejectedCount = LeaveRequest::where('user_id', auth()->id())->where('status', 'Rejected')->count();
        $totalRequests = LeaveRequest::where('user_id', auth()->id())->count();
        return view('dashboard', compact('leaveRequests', 'pendingCount', 'certifiedCount', 'rejectedCount', 'totalRequests'));
    }

    public function show($id)
    {
        $leave = LeaveRequest::with('user')->findOrFail($id);
        
        // Check if the user owns this leave request or is an admin/HR
        if ($leave->user_id != auth()->id() && !in_array(auth()->id(), [2, 4])) {
            return abort(403, 'Unauthorized');
        }
        
        // Format the leave data for display
        $leaveTypes = is_string($leave->leave_type) && $leave->leave_type[0] === '[' 
            ? implode(', ', json_decode($leave->leave_type)) 
            : $leave->leave_type;
        
        // Format inclusive dates properly
        $formattedInclusiveDates = '';
        if ($leave->inclusive_dates) {
            $dates = is_string($leave->inclusive_dates) ? json_decode($leave->inclusive_dates, true) : $leave->inclusive_dates;
            if (is_array($dates)) {
                $formattedDates = [];
                foreach ($dates as $dateRange) {
                    if (strpos($dateRange, ' to ') !== false) {
                        [$start, $end] = explode(' to ', $dateRange);
                        $startDate = Carbon::createFromFormat('m/d/Y', trim($start))->format('M j, Y');
                        $endDate = Carbon::createFromFormat('m/d/Y', trim($end))->format('M j, Y');
                        $formattedDates[] = $startDate . ' to ' . $endDate;
                    } else {
                        // Single date
                        $singleDate = Carbon::createFromFormat('m/d/Y', trim($dateRange))->format('M j, Y');
                        $formattedDates[] = $singleDate;
                    }
                }
                $formattedInclusiveDates = implode(', ', $formattedDates);
            }
        }
        
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
        
        $filingDate = Carbon::parse($leave->created_at)->format('F j, Y');
        $certDate = Carbon::now()->format('F j, Y');
        
        // Return the view
        return view('leave.show', compact('leave', 'leaveTypes', 'formattedInclusiveDates', 'certData', 'filingDate', 'certDate'));
    }

    public function print($id)
    {
        try {
            $leave = LeaveRequest::with('user')->findOrFail($id);
            
            // Check if the user owns this leave request or is an admin/HR
            if ($leave->user_id != auth()->id() && !in_array(auth()->id(), [2, 4])) {
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
            
            // Format inclusive dates properly
            $formattedInclusiveDates = '';
            if ($leave->inclusive_dates) {
                $dates = is_string($leave->inclusive_dates) ? json_decode($leave->inclusive_dates, true) : $leave->inclusive_dates;
                if (is_array($dates)) {
                    $formattedDates = [];
                    foreach ($dates as $dateRange) {
                        if (strpos($dateRange, ' to ') !== false) {
                            [$start, $end] = explode(' to ', $dateRange);
                            $startDate = Carbon::createFromFormat('m/d/Y', trim($start))->format('M j, Y');
                            $endDate = Carbon::createFromFormat('m/d/Y', trim($end))->format('M j, Y');
                            $formattedDates[] = $startDate . ' to ' . $endDate;
                        } else {
                            // Single date
                            $singleDate = Carbon::createFromFormat('m/d/Y', trim($dateRange))->format('M j, Y');
                            $formattedDates[] = $singleDate;
                        }
                    }
                    $formattedInclusiveDates = implode(', ', $formattedDates);
                }
            }
            
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
            
            return view('leave.print', compact('leave', 'leaveType', 'filingDate', 'certDate', 'certData', 'formattedInclusiveDates'));
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
