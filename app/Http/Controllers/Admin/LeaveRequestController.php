<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;

class LeaveRequestController extends Controller
{
    public function index()
    {
        // Fetch leave requests from the database with user relationship
        $leaveRequests = LeaveRequest::with('user')->orderByDesc('created_at')->get();

        // Add custom formatted fields for the table
        $leaveRequests->transform(function ($leave) {
            // LEAVE NUMBER
            $leave->leave_number = $leave->id;

            // PARTICULAR (inclusive dates)
            $leave->particular = $leave->inclusive_dates;

            // CODE (initials of type of leave)
            $type = $leave->leave_type;
            if (is_array($type)) {
                $typeString = implode(' ', $type);
            } else {
                $typeString = $type;
            }
            // Get initials (e.g., "Sick Leave" => "SL")
            preg_match_all('/\b([A-Z])/i', $typeString, $matches);
            $leave->code = strtoupper(implode('', $matches[1] ?? []));

            // LN CODE (YYMMDD-CODE:LEAVE_NUMBER)
            $date = $leave->created_at ? $leave->created_at->format('ymd') : '--';
            $leave->ln_code = $date . '-' . $leave->code . ':' . $leave->leave_number;

            // TYPE OF LEAVE (for inline editing)
            $leave->type_of_leave = $typeString;

            // NAME (user name)
            $leave->name = $leave->user ? $leave->user->name : '-';

            return $leave;
        });

        return view('admin.leave-requests.index', compact('leaveRequests'));
    }
}
