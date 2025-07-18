<?php

namespace App\Exports;

use App\Models\LeaveRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class MonthlyLeaveRequestExport implements FromCollection, WithHeadings, WithMapping
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
        $monthNum = date('m', strtotime($this->month));
        return LeaveRequest::with('user')
            ->whereYear('created_at', $this->year)
            ->whereMonth('created_at', $monthNum)
            ->where('status', 'Approved')
            ->orderBy('id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Date Received',
            'LN Code',
            'Leave Number',
            'Particular',
            'Type of Leave',
            'Code',
            'Name',
        ];
    }

    private function formatInclusiveDates($dates)
    {
        if (is_string($dates)) {
            $dates = json_decode($dates, true);
        }
        if (!is_array($dates)) return $dates;
        
        $formatted = [];
        foreach ($dates as $dateRange) {
            if (strpos($dateRange, ' to ') !== false) {
                [$start, $end] = explode(' to ', $dateRange);
                $startDate = Carbon::createFromFormat('m/d/Y', trim($start));
                $endDate = Carbon::createFromFormat('m/d/Y', trim($end));
                
                // Calculate working days
                $workingDays = 0;
                $currentDate = $startDate->copy();
                while ($currentDate <= $endDate) {
                    if ($currentDate->isWeekday()) {
                        $workingDays++;
                    }
                    $currentDate->addDay();
                }
                
                // Format for display
                $startMonth = $startDate->format('F');
                $endMonth = $endDate->format('F');
                $startDay = $startDate->day;
                $endDay = $endDate->day;
                
                if ($startMonth === $endMonth) {
                    if ($startDay === $endDay) {
                        $datePart = "{$startMonth} {$startDay}";
                    } else {
                        $datePart = "{$startMonth} {$startDay}-{$endDay}";
                    }
                } else {
                    $datePart = "{$startMonth} {$startDay}, {$endMonth} {$endDay}";
                }
                
                $daysText = $workingDays === 1 ? '1 day' : "{$workingDays} days";
                $formatted[] = "{$daysText} - {$datePart}";
            } else {
                // Single date - calculate as 1 working day if it's a weekday
                $singleDate = Carbon::createFromFormat('m/d/Y', trim($dateRange));
                $workingDays = $singleDate->isWeekday() ? 1 : 0;
                $month = $singleDate->format('F');
                $day = $singleDate->day;
                $daysText = $workingDays === 1 ? '1 day' : "{$workingDays} days";
                $formatted[] = "{$daysText} - {$month} {$day}";
            }
        }
        return implode(', ', $formatted);
    }

    public function map($leave): array
    {
        // Leave type code mapping (same as frontend)
        $leaveTypeCodeMap = [
            'Vacation Leave' => 'VL',
            'Mandatory/Forced Leave' => 'MFL',
            'Sick Leave' => 'SL',
            'Maternity Leave' => 'MatL',
            'Paternity Leave' => 'PL',
            'Special Privilege Leave' => 'SPL',
            'Solo Parent Leave' => 'SoloPL',
            'Study Leave' => 'StudyL',
            '10-Day VAWC Leave' => 'VAWCL',
            'Rehabilitation Privilege' => 'RehabPriv',
            'Special Leave Benefits for Women' => 'SLBW',
            'Special Emergency (Calamity) Leave' => 'SECL',
            'Adoption Leave' => 'AdoptL',
            'Leave Without Pay (Vacation)' => 'LWOP',
            'Terminal Leave' => 'TermnL',
            'Compensatory Time Off' => 'CTO',
            'Monetization of Leave Credits' => 'MLC'
        ];

        // Date Received
        $dateReceived = $leave->date_received ? date('j-M-y', strtotime($leave->date_received)) : ($leave->created_at ? $leave->created_at->format('j-M-y') : '-');
        
        // Type of Leave
        $type = $leave->leave_type;
        if (is_string($type) && $type && $type[0] === '[') {
            $type = json_decode($type);
            $type = is_array($type) ? implode(' ', $type) : (string)$type;
        } elseif (is_array($type)) {
            $type = implode(' ', $type);
        }
        
        // Code (from leave type mapping)
        $code = $leaveTypeCodeMap[$type] ?? '';
        
        // LN Code (same logic as frontend generateLnCode function)
        $date = $leave->date_received ? date('ymd', strtotime($leave->date_received)) : ($leave->created_at ? $leave->created_at->format('ymd') : '--');
        $lnCode = $date . '-' . $code . $leave->id;
        
        // Leave Number
        $leaveNumber = $leave->id;
        
        // Particular (inclusive dates) - formatted with working days calculation
        $particular = $this->formatInclusiveDates($leave->inclusive_dates);
        
        // Type of Leave
        $typeOfLeave = $type;
        
        // Name
        $name = $leave->user ? $leave->user->name : '-';
        
        return [
            $dateReceived,
            $lnCode,
            $leaveNumber,
            $particular,
            $typeOfLeave,
            $code,
            $name,
        ];
    }
} 