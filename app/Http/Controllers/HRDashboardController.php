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
        $totalRequests = LeaveRequest::count();
        
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
            'totalRequests',
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
            'recommendation' => 'nullable|string',
            'disapproval_reason' => 'nullable|string',
            'other_remarks' => 'nullable|string',
            'other_remarks2' => 'nullable|string',
            'other_remarks3' => 'nullable|string',
            'days_with_pay' => 'nullable|string',
            'days_without_pay' => 'nullable|string',
            'others_specify' => 'nullable|string',
            'disapproval_reason1' => 'nullable|string',
            'disapproval_reason2' => 'nullable|string',
            'hr_signatory' => 'nullable|string',
            'admin_signatory' => 'nullable|string',
            'director_signatory' => 'nullable|string',
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
        
        // Process signatory data
        $hrData = explode('|', $request->hr_signatory);
        $adminData = explode('|', $request->admin_signatory);
        $directorData = explode('|', $request->director_signatory);
        
        $hr_officer = $hrData[0] ?? 'JOY ROSE C. BAWAYAN';
        $hr_position = $hrData[1] ?? 'Administrative Officer V (HRMO III)';
        
        $admin_chief = $adminData[0] ?? 'AIDA Y. PAGTAN';
        $admin_position = $adminData[1] ?? 'Chief, Administrative and Finance Division';
        
        $director = $directorData[0] ?? 'Atty. JENNILYN M. DAWAYAN, CESO IV';
        $director_position = $directorData[1] ?? 'Regional Executive Director';
        
        $leave->certification_data = json_encode([
            'as_of_date' => $request->as_of_date,
            'vl_earned' => $request->vl_earned,
            'sl_earned' => $request->sl_earned,
            'vl_less' => $request->vl_less,
            'sl_less' => $request->sl_less,
            'vl_balance' => $request->vl_balance,
            'sl_balance' => $request->sl_balance,
            'recommendation' => $request->recommendation,
            'disapproval_reason' => $request->disapproval_reason,
            'other_remarks' => $request->other_remarks,
            'other_remarks2' => $request->other_remarks2,
            'other_remarks3' => $request->other_remarks3,
            'days_with_pay' => $request->days_with_pay,
            'days_without_pay' => $request->days_without_pay,
            'others_specify' => $request->others_specify,
            'disapproval_reason1' => $request->disapproval_reason1,
            'disapproval_reason2' => $request->disapproval_reason2,
            // New keys for print view compatibility
            'hr_name' => $hr_officer,
            'hr_position' => $hr_position,
            'admin_name' => $admin_chief,
            'admin_position' => $admin_position,
            'director_name' => $director,
            'director_position' => $director_position,
            // Old keys for backward compatibility
            'hr_officer' => $hr_officer,
            'admin_chief' => $admin_chief,
            'director' => $director,
            'hr_signatory' => $request->hr_signatory,
            'admin_signatory' => $request->admin_signatory,
            'director_signatory' => $request->director_signatory,
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
}
