<?php

namespace App\Exports;

use App\Models\User;
use App\Models\LeaveRequest;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MonthlyEmployeeExport implements FromCollection, WithHeadings, WithMapping
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        // Get user IDs with leave requests in the given month/year
        $monthNum = date('m', strtotime($this->month));
        $userIds = LeaveRequest::whereYear('created_at', $this->year)
            ->whereMonth('created_at', $monthNum)
            ->pluck('user_id')
            ->unique();

        // Get users with those IDs
        return User::whereIn('id', $userIds)
            ->select('id', 'name', 'position', 'offices')
            ->orderBy('id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID#',
            'Name',
            'Position',
            'Office',
        ];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->position,
            $user->offices,
        ];
    }
} 