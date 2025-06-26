<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    public function index()
    {
        // Check if user is authorized (ID 2)
        if (Auth::id() != 2) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access the admin dashboard.');
        }
        
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
            preg_match_all('/\b([A-Z])/i', $typeString, $matches);
            $leave->code = strtoupper(implode('', $matches[1] ?? []));

            // LN CODE (YYMMDD-CODE:LEAVE_NUMBER)
            $date = $leave->date_received ? date('ymd', strtotime($leave->date_received)) : ($leave->created_at ? $leave->created_at->format('ymd') : '--');
            $leave->ln_code = $date . '-' . $leave->code . ':' . $leave->leave_number;

            // TYPE OF LEAVE (for inline editing)
            $leave->type_of_leave = $typeString;

            // NAME (user name)
            $leave->name = $leave->user ? $leave->user->name : '-';

            // DATE RECEIVED (for display)
            $leave->date_received_display = $leave->date_received ? date('j-M-y', strtotime($leave->date_received)) : ($leave->created_at ? $leave->created_at->format('j-M-y') : '-');

            return $leave;
        });
        return view('admin.leave-requests.index', compact('leaveRequests'));
    }

    public function updateType(Request $request, $id)
    {
        $leave = \App\Models\LeaveRequest::findOrFail($id);
        $leave->leave_type = [$request->leave_type];
        $leave->save();

        // Recalculate fields for the updated row
        $typeString = $request->leave_type;
        preg_match_all('/\b([A-Z])/i', $typeString, $matches);
        $code = strtoupper(implode('', $matches[1] ?? []));
        $date = $leave->created_at ? $leave->created_at->format('ymd') : '--';
        $ln_code = $date . '-' . $code . ':' . $leave->id;

        return response()->json([
            'success' => true,
            'type_of_leave' => $typeString,
            'code' => $code,
            'ln_code' => $ln_code,
        ]);
    }

    public function updateFields(Request $request, $id)
    {
        $leave = \App\Models\LeaveRequest::findOrFail($id);
        if ($request->has('leave_type')) {
            $leave->leave_type = [$request->leave_type];
        }
        if ($request->has('date_received')) {
            $leave->date_received = date('Y-m-d', strtotime($request->date_received));
        }
        $leave->save();

        $typeString = is_array($leave->leave_type) ? implode(' ', $leave->leave_type) : $leave->leave_type;
        preg_match_all('/\b([A-Z])/i', $typeString, $matches);
        $code = strtoupper(implode('', $matches[1] ?? []));
        $date = $leave->date_received ? date('ymd', strtotime($leave->date_received)) : ($leave->created_at ? $leave->created_at->format('ymd') : '--');
        $ln_code = $date . '-' . $code . ':' . $leave->id;
        $date_display = $leave->date_received ? date('j-M-y', strtotime($leave->date_received)) : ($leave->created_at ? $leave->created_at->format('j-M-y') : '-');

        return response()->json([
            'success' => true,
            'type_of_leave' => $typeString,
            'code' => $code,
            'ln_code' => $ln_code,
            'date_received' => $date_display
        ]);
    }
}
