<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MonthlyLeaveRequestExport;

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

        // Calculate current month and yearly request counts
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $previousYear = $currentYear - 1;

        $currentMonthCount = LeaveRequest::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->count();
        
        // Yearly total (for current year)
        $yearTotalCount = LeaveRequest::whereYear('created_at', $currentYear)->count();

        // Yearly graph data (last 5 years)
        $years = collect(range($currentYear - 4, $currentYear));
        $yearlyCounts = $years->map(function($year) {
            return LeaveRequest::whereYear('created_at', $year)->count();
        });
        $yearlyRequestGraphData = [
            'years' => $years->toArray(),
            'counts' => $yearlyCounts->toArray(),
        ];

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
        
        return view('admin.leave-requests.index', compact('leaveRequests', 'currentMonthCount', 'yearTotalCount', 'yearlyRequestGraphData', 'currentYear', 'previousYear'));
    }

    public function updateType(Request $request, $id)
    {
        // Accept JSON or form data
        $leaveType = $request->input('leave_type');
        if (!$leaveType) {
            return response()->json([
                'success' => false,
                'message' => 'Missing leave_type.'
            ], 422);
        }
        $leave = \App\Models\LeaveRequest::findOrFail($id);
        $leave->leave_type = [$leaveType];
        $leave->save();

        // Recalculate fields for the updated row
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

    public function byMonth(Request $request)
    {
        $month = $request->query('month');
        // Remove quotes if present (from JS fetch)
        $month = trim($month, '"');
        $year = date('Y');
        $monthNum = date('m', strtotime($month));
        $leaveRequests = \App\Models\LeaveRequest::with('user')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $monthNum)
            ->where('status', 'Certified')
            ->orderBy('id')
            ->get()
            ->map(function($lr) {
                // LEAVE NUMBER (auto-increment id)
                $leave_number = $lr->id;
                // PARTICULAR (inclusive dates)
                $particular = $lr->inclusive_dates;
                // CODE (initials of type of leave)
                $type = $lr->leave_type;
                if (is_string($type) && $type && $type[0] === '[') {
                    $type = json_decode($type);
                    $type = is_array($type) ? implode(' ', $type) : (string)$type;
                } elseif (is_array($type)) {
                    $type = implode(' ', $type);
                }
                preg_match_all('/\b([A-Z])/i', $type, $matches);
                $code = strtoupper(implode('', $matches[1] ?? []));
                // LN CODE (YYMMDD-CODE:LEAVE_NUMBER)
                $date = $lr->date_received ? date('ymd', strtotime($lr->date_received)) : ($lr->created_at ? $lr->created_at->format('ymd') : '--');
                $ln_code = $date . '-' . $code . ':' . $leave_number;
                // DATE RECEIVED: use current day if null
                $date_received = $lr->date_received ? \Carbon\Carbon::parse($lr->date_received)->format('j-M-y') : now()->format('j-M-y');
                return [
                    'date_received' => $date_received,
                    'ln_code' => $ln_code,
                    'leave_number' => $leave_number,
                    'particular' => $particular,
                    'type_of_leave' => $type,
                    'code' => $code,
                    'name' => $lr->user ? $lr->user->name : '-',
                ];
            });
        return response()->json($leaveRequests);
    }

    public function exportMonth(Request $request)
    {
        $month = $request->query('month');
        $year = date('Y');
        $filename = 'leave_requests_' . strtolower($month) . '_' . $year . '.xlsx';
        return Excel::download(new MonthlyLeaveRequestExport($month, $year), $filename);
    }

    // Add a method to delete all leave requests from the previous year
    public function deletePreviousYear(Request $request)
    {
        $previousYear = now()->year - 1;
        $deleted = LeaveRequest::whereYear('created_at', $previousYear)->delete();
        return response()->json(['success' => true, 'deleted' => $deleted]);
    }
}
