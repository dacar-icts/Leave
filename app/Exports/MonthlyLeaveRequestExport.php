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
            ->where('status', 'Certified')
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
                $startDate = Carbon::createFromFormat('m/d/Y', trim($start))->format('d-m-Y');
                $endDate = Carbon::createFromFormat('m/d/Y', trim($end))->format('d-m-Y');
                $formatted[] = $startDate . ' to ' . $endDate;
            } else {
                $formatted[] = Carbon::createFromFormat('m/d/Y', trim($dateRange))->format('d-m-Y');
            }
        }
        return implode(', ', $formatted);
    }

    public function map($leave): array
    {
        // Date Received
        $dateReceived = $leave->date_received ? date('j-M-y', strtotime($leave->date_received)) : ($leave->created_at ? $leave->created_at->format('j-M-y') : '-');
        // LN Code
        $type = $leave->leave_type;
        if (is_string($type) && $type && $type[0] === '[') {
            $type = json_decode($type);
            $type = is_array($type) ? implode(' ', $type) : (string)$type;
        } elseif (is_array($type)) {
            $type = implode(' ', $type);
        }
        preg_match_all('/\b([A-Z])/i', $type, $matches);
        $code = strtoupper(implode('', $matches[1] ?? []));
        $date = $leave->date_received ? date('ymd', strtotime($leave->date_received)) : ($leave->created_at ? $leave->created_at->format('ymd') : '--');
        $lnCode = $date . '-' . $code . ':' . $leave->id;
        // Leave Number
        $leaveNumber = $leave->id;
        // Particular (inclusive dates) - formatted
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