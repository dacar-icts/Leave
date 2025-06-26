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
            'abroad' => 'nullable|string',
            'in_hospital' => 'nullable|string',
            'out_patient' => 'nullable|string',
            'special_leave' => 'nullable|string',
            'study_leave' => 'nullable|string',
            'other_purpose' => 'nullable|string',
            'num_days' => 'nullable|integer',
            'inclusive_dates' => 'nullable|string',
            'commutation' => 'nullable|string',
        ]);
        $data['user_id'] = auth()->id();
        $data['leave_type'] = json_encode($data['leave_type']);
        $data['status'] = 'Pending';

        LeaveRequest::create($data);

        // Check if the request is AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Leave request submitted successfully!']);
        }
        
        // Regular form submission
        return redirect()->route('dashboard')->with('success', 'Leave request submitted successfully!');
    }
}
