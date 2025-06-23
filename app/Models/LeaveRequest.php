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
        'abroad',
        'in_hospital',
        'out_patient',
        'special_leave',
        'study_leave',
        'other_purpose',
        'num_days',
        'inclusive_dates',
        'commutation',
    ];
    protected $casts = [
        'leave_type' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
