<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HRDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Check if user is authorized (ID 4)
        if (Auth::id() != 4) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access the HR dashboard.');
        }
        
        // Get date range filter if provided
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        // Build query with filters
        $query = LeaveRequest::with('user')->latest();
        
        // Apply date filters if provided
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
        
        // Get statistics
        $pendingCount = LeaveRequest::where('status', 'Pending')->count();
        $certifiedCount = LeaveRequest::where('status', 'Certified')->count();
        $rejectedCount = LeaveRequest::where('status', 'Rejected')->count();
        
        // Get leave type statistics
        $leaveTypeStats = DB::table('leave_requests')
            ->select(DB::raw('JSON_EXTRACT(leave_type, "$[0]") as leave_type'), DB::raw('count(*) as count'))
            ->whereNotNull('leave_type')
            ->groupBy(DB::raw('JSON_EXTRACT(leave_type, "$[0]")'))
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();
            
        // Get recent requests (last 7 days)
        $recentRequests = LeaveRequest::where('created_at', '>=', Carbon::now()->subDays(7))
            ->count();
            
        // Get request count by day of week (for chart)
        $requestsByDayOfWeek = DB::table('leave_requests')
            ->select(DB::raw('DAYOFWEEK(created_at) as day_of_week'), DB::raw('count(*) as count'))
            ->groupBy('day_of_week')
            ->get()
            ->keyBy('day_of_week')
            ->map(function ($item) {
                return $item->count;
            })
            ->toArray();
            
        // Ensure all days of week are present (1=Sunday, 7=Saturday)
        $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $chartData = [];
        foreach ($daysOfWeek as $index => $day) {
            $dayNumber = $index + 1;
            $chartData[$day] = $requestsByDayOfWeek[$dayNumber] ?? 0;
        }
        
        // Get all leave requests
        $leaveRequests = $query->get();

        return view('hr-dashboard', compact(
            'leaveRequests', 
            'pendingCount', 
            'certifiedCount', 
            'rejectedCount', 
            'leaveTypeStats',
            'recentRequests',
            'chartData'
        ));
    }

    public function certifyLeave(Request $request)
    {
        // Check if user is authorized (ID 4)
        if (Auth::id() != 4) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $request->validate([
            'leave_id' => 'required|exists:leave_requests,id',
            'as_of_date' => 'required_if:action,certify|date',
            'vl_earned' => 'nullable|string',
            'sl_earned' => 'nullable|string',
            'vl_less' => 'nullable|string',
            'sl_less' => 'nullable|string',
            'vl_balance' => 'nullable|string',
            'sl_balance' => 'nullable|string',
            'approved_with_pay' => 'nullable|string',
            'approved_without_pay' => 'nullable|string',
            'approved_others' => 'nullable|string',
            'action' => 'required|string|in:certify,reject',
            'rejection_comment' => 'required_if:action,reject|string|nullable',
        ]);

        $leave = LeaveRequest::findOrFail($request->leave_id);

        if ($request->action === 'reject') {
            $leave->status = 'Rejected';
            $leave->certified_at = now();
            // Store rejection comment in certification_data
            $certData = [
                'rejection_comment' => $request->rejection_comment,
                'rejected_by' => Auth::user()->name,
                'rejected_at' => now()->toDateTimeString(),
            ];
            $leave->certification_data = json_encode($certData);
            $leave->save();
            return response()->json(['success' => true, 'rejected' => true]);
        }
        
        $leave->status = 'Certified';
        $leave->certified_at = now();
        
        // Set fixed signatory data (HR cannot edit these)
        $hr_officer = 'JOY ROSE C. BAWAYAN';
        $hr_position = 'Administrative Officer V (HRMO III)';
        
        $admin_chief = 'AIDA Y. PAGTAN';
        $admin_position = 'Chief, Administrative and Finance Division';
        
        $director = 'Atty. JENNILYN M. DAWAYAN, CESO IV';
        $director_position = 'Regional Executive Director';
        
        $leave->certification_data = json_encode([
            'as_of_date' => $request->as_of_date,
            'vl_earned' => $request->vl_earned,
            'sl_earned' => $request->sl_earned,
            'vl_less' => $request->vl_less,
            'sl_less' => $request->sl_less,
            'vl_balance' => $request->vl_balance,
            'sl_balance' => $request->sl_balance,
            // Fixed signatory data
            'hr_name' => $hr_officer,
            'hr_position' => $hr_position,
            'admin_name' => $admin_chief,
            'admin_position' => $admin_position,
            'director_name' => $director,
            'director_position' => $director_position,
            // Backward compatibility
            'hr_officer' => $hr_officer,
            'admin_chief' => $admin_chief,
            'director' => $director,
            'hr_signatory' => $hr_officer . '|' . $hr_position,
            'admin_signatory' => $admin_chief . '|' . $admin_position,
            'director_signatory' => $director . '|' . $director_position,
            // APPROVED FOR section
            'approved_with_pay' => $request->approved_with_pay,
            'approved_without_pay' => $request->approved_without_pay,
            'approved_others' => $request->approved_others,
        ]);
        $leave->save();

        return response()->json(['success' => true]);
    }
    
    public function getLeaveStats()
    {
        // Check if user is authorized (ID 4)
        if (Auth::id() != 4) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // API endpoint to get updated stats for AJAX calls
        $stats = [
            'pending' => LeaveRequest::where('status', 'Pending')->count(),
            'certified' => LeaveRequest::where('status', 'Certified')->count(),
            'total' => LeaveRequest::count(),
        ];
        
        return response()->json($stats);
    }

    public function previewLeaveRequest($id)
    {
        // Check if user is authorized (ID 4)
        if (Auth::id() != 4) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
        }
        
        $leaveRequest = LeaveRequest::with('user')->findOrFail($id);
        
        // Format inclusive dates properly
        $formattedInclusiveDates = '';
        if ($leaveRequest->inclusive_dates) {
            $dates = is_string($leaveRequest->inclusive_dates) ? json_decode($leaveRequest->inclusive_dates, true) : $leaveRequest->inclusive_dates;
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
        
        return view('hr.leave-request-preview', compact('leaveRequest', 'formattedInclusiveDates'));
    }

    public function exportCsv(Request $request)
    {
        if (Auth::id() != 4) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to export.');
        }
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');

        $query = LeaveRequest::with('user')->latest();
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
        if ($status && in_array($status, ['Pending','Certified','Rejected','Approved'])) {
            $query->where('status', $status);
        }

        $rows = $query->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="hr-leave-requests.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($rows) {
            $handle = fopen('php://output', 'w');
            // BOM for Excel UTF-8
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            // Header row
            fputcsv($handle, [
                'Date Filed', 'ID #', 'Name', 'Office', 'Type of Leave', 'Status', 'Num Days', 'Inclusive Dates', 'Commutation'
            ]);
            foreach ($rows as $leave) {
                $types = '';
                if (is_array($leave->leave_type)) {
                    $types = implode(', ', $leave->leave_type);
                } elseif (is_string($leave->leave_type) && $leave->leave_type && $leave->leave_type[0] === '[') {
                    $decoded = json_decode($leave->leave_type, true);
                    $types = is_array($decoded) ? implode(', ', $decoded) : (string) $leave->leave_type;
                } else {
                    $types = (string) $leave->leave_type;
                }
                $datesOut = '';
                $dates = is_string($leave->inclusive_dates) ? json_decode($leave->inclusive_dates, true) : $leave->inclusive_dates;
                if (is_array($dates)) {
                    $formatted = [];
                    foreach ($dates as $range) {
                        if (strpos($range, ' to ') !== false) {
                            [$s,$e] = explode(' to ', $range);
                            try {
                                $sF = Carbon::createFromFormat('m/d/Y', trim($s))->format('M j, Y');
                                $eF = Carbon::createFromFormat('m/d/Y', trim($e))->format('M j, Y');
                                $formatted[] = "$sF to $eF";
                            } catch (\Exception $ex) {
                                $formatted[] = $range;
                            }
                        } else {
                            try {
                                $formatted[] = Carbon::createFromFormat('m/d/Y', trim($range))->format('M j, Y');
                            } catch (\Exception $ex) {
                                $formatted[] = $range;
                            }
                        }
                    }
                    $datesOut = implode(', ', $formatted);
                } else {
                    $datesOut = (string) $leave->inclusive_dates;
                }

                fputcsv($handle, [
                    optional($leave->created_at)->timezone('Asia/Manila')->format('n/j/Y'),
                    optional($leave->user)->id,
                    optional($leave->user)->name,
                    $leave->office ?? optional($leave->user)->offices,
                    $types,
                    $leave->status,
                    $leave->num_days,
                    $datesOut,
                    $leave->commutation,
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
