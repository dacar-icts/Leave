<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $fillable = [
        'user_id',
        'leave_type',
        'leave_type_other',
        'within_ph',
        'within_ph_details',
        'abroad',
        'abroad_details',
        'in_hospital',
        'in_hospital_details',
        'out_patient',
        'out_patient_details',
        'special_leave',
        'special_leave_details',
        'completion_masters',
        'bar_exam',
        'monetization',
        'terminal_leave',
        'study_leave',
        'other_purpose',
        'num_days',
        'inclusive_dates',
        'commutation',
        'date_received',
        'office',
        'position',
        'salary',
        'filing_date',
        'status',
        'certification_data',
        'certified_at',
    ];
    protected $casts = [
        'leave_type' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
