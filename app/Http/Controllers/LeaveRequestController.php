<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function create()
    {
        return view('leave.create_new');
    }
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'leave_type' => 'required|array',
            'leave_type_other' => 'nullable|string',
            'within_ph' => 'nullable|string',
            'within_ph_details' => 'nullable|string',
            'abroad' => 'nullable|string',
            'abroad_details' => 'nullable|string',
            'in_hospital' => 'nullable|string',
            'in_hospital_details' => 'nullable|string',
            'out_patient' => 'nullable|string',
            'out_patient_details' => 'nullable|string',
            'special_leave' => 'nullable|string',
            'special_leave_details' => 'nullable|string',
            'completion_masters' => 'nullable|string',
            'bar_exam' => 'nullable|string',
            'monetization' => 'nullable|string',
            'terminal_leave' => 'nullable|string',
            'study_leave' => 'nullable|string',
            'other_purpose' => 'nullable|string',
            'num_days' => 'nullable|integer',
            'inclusive_dates' => 'nullable|array',
            'commutation' => 'nullable|string',
            'office' => 'nullable|string',
            'position' => 'nullable|string',
            'salary' => 'nullable|string',
            'filing_date' => 'nullable|string',
            'admin_signatory' => 'nullable|string',
        ]);
        // Map special_leave_benefits to special_leave for compatibility with the print view
        if ($request->has('special_leave_benefits')) {
            $data['special_leave'] = $request->input('special_leave_benefits');
        } else {
            $data['special_leave'] = null;
        }
        $data['user_id'] = auth()->id();
        $data['leave_type'] = json_encode($data['leave_type']);
        $data['inclusive_dates'] = json_encode($data['inclusive_dates'] ?? []);
        // Save admin_signatory for later use in certification_data
        if (isset($data['admin_signatory'])) {
            $adminData = explode('|', $data['admin_signatory']);
            $data['admin_name'] = $adminData[0] ?? '';
            $data['admin_position'] = $adminData[1] ?? '';
        }
        $data['status'] = 'Pending';

        LeaveRequest::create($data);

        // Check if the request is AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Leave request submitted successfully!']);
        }

        // Regular form submission
        return redirect()->route('dashboard')->with('success', 'Leave request submitted successfully!');
    }

    public function divisionChiefAutocomplete(Request $request)
    {
        $query = $request->input('q', '');
        $currentUserId = auth()->id();
        
        $users = \App\Models\User::query()
            ->where('id', '!=', $currentUserId) // Exclude current user
            ->when($query, function($q) use ($query) {
                $q->where(function($sub) use ($query) {
                    $sub->where('name', 'like', "%$query%")
                         ->orWhere('position', 'like', "%$query%");
                });
            })
            ->select('id', 'name', 'position')
            ->orderBy('name')
            ->limit(10)
            ->get();
            
        return response()->json($users);
    }
}
