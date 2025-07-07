<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Leave Request Details</title>
    
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/leave-form.css') }}">
    <style>
        body {
            background-color: #f5f5f5;
            padding: 20px 0;
        }
        
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        .header-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .back-btn {
            display: flex;
            align-items: center;
            padding: 8px 16px;
            background-color:#1ecb6b;
            color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-btn .material-icons {
            margin-right: 5px;
        }
        
        .print-btn {
            display: flex;
            align-items: center;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
        }
        
        .print-btn .material-icons {
            margin-right: 5px;
        }
        
        /* Optimize for single page */
        .leave-form {
            transform: scale(0.95);
            transform-origin: top center;
            margin-bottom: -20px;
        }
        
        /* Reduce some spacing */
        .form-row > div {
            padding: 6px 8px;
        }
        
        .leave-types {
            gap: 2px;
            padding: 6px;
        }
        
        .leave-details-section {
            margin-bottom: 6px;
        }
        
        .leave-details-item {
            margin-bottom: 3px;
        }
        
        .form-signature {
            padding: 10px 20px;
        }
        
        .signature-line {
            padding-bottom: 10px;
        }
        
        /* Certification section optimizations */
        .certification-section {
            margin-top: 10px;
        }
        
        .certification-title {
            padding: 5px 0;
        }
        
        .certification-table {
            margin: 5px 0;
        }
        
        .signatory {
            margin-top: 10px;
        }
        
        .print-bg-container {
            position: relative;
            width: 750px;
            height: 1120px;
            margin: 0 auto 0 auto;
            background: #fff;
            border: none;
        }
        
        .print-bg-container img.bg {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: 1;
            user-select: none;
            pointer-events: none;
        }
        
        .field {
            position: absolute;
            z-index: 2;
            font-size: 15px;
            color: #000;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        @media print {
            .header-controls {
                display: none;
            }
            
            body {
                background-color: white;
                padding: 0;
            }
            
            .container {
                max-width: 100%;
                width: 100%;
                padding: 0;
            }
            
            .leave-form {
                transform: none;
                margin-bottom: 0;
                border: none;
            }
            
            @page {
                size: A4;
                margin: 0.5cm;
            }
        }
        
        .custom-checkbox {
            display: inline-block;
            width: 11px;
            height: 11px;
            border: 1px solid #000;
            background: #fff;
            position: relative;
            vertical-align: middle;
            margin: 0 2px 0 0;
        }
        .custom-checkbox.checked::after {
            content: '';
            position: absolute;
            left: 3px;
            top: 0px;
            width: 4px;
            height: 7px;
            border: solid #000;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-controls">
            <a href="{{ route('dashboard') }}" class="back-btn">
                <span class="material-icons">arrow_back</span>
                Back to Dashboard
            </a>
            
            @if($leave->status === 'Certified')
            <a href="{{ route('leave.print', $leave->id) }}" class="print-btn" target="_blank">
                <span class="material-icons">print</span>
                Print
            </a>
            @endif
        </div>
        
        <div class="print-bg-container" id="previewArea">
            <img src="{{ asset('cs_form_6_bg.png') }}" class="bg" alt="Form Background">
            @php
                $fullName = $leave->user->name ?? '';
                $last = $first = $middle = '';
                if (strpos($fullName, ',') !== false) {
                    [$last, $rest] = explode(',', $fullName, 2);
                    $rest = trim($rest);
                    $restParts = explode(' ', $rest);
                    $first = $restParts[0] ?? '';
                    $middle = isset($restParts[1]) ? $restParts[1] : '';
                } else {
                    $parts = explode(' ', $fullName);
                    $first = $parts[0] ?? '';
                    $middle = $parts[1] ?? '';
                    $last = $parts[2] ?? '';
                }
                if (is_array($leave->leave_type)) {
                    $leaveTypesArr = $leave->leave_type;
                } elseif (is_string($leave->leave_type) && $leave->leave_type && $leave->leave_type[0] === '[') {
                    $leaveTypesArr = json_decode($leave->leave_type, true) ?? [];
                } else {
                    $leaveTypesArr = [];
                }
                $officeFull = $leave->office ?? ($leave->user->offices ?? '');
                if (preg_match('/\(([^)]+)\)/', $officeFull, $matches)) {
                    $officeShortcut = $matches[1];
                } else {
                    $officeShortcut = '';
                }
                $inclusiveDatesArr = [];
                if (is_array($leave->inclusive_dates)) {
                    $inclusiveDatesArr = $leave->inclusive_dates;
                } elseif (is_string($leave->inclusive_dates) && $leave->inclusive_dates && $leave->inclusive_dates[0] === '[') {
                    $inclusiveDatesArr = json_decode($leave->inclusive_dates, true) ?? [];
                }
                $monthShort = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'Jun',7=>'Jul',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec'];
                $formattedRanges = [];
                foreach ($inclusiveDatesArr as $range) {
                    $parts = explode(' to ', $range);
                    if (count($parts) === 2) {
                        $start = date_create_from_format('m/d/Y', trim($parts[0]));
                        $end = date_create_from_format('m/d/Y', trim($parts[1]));
                        if ($start && $end) {
                            $startStr = $monthShort[(int)$start->format('n')] . ' ' . $start->format('j, Y');
                            $endStr = $monthShort[(int)$end->format('n')] . ' ' . $end->format('j, Y');
                            $formattedRanges[] = $startStr . ' to ' . $endStr;
                        } else {
                            $formattedRanges[] = $range;
                        }
                    } else {
                        $formattedRanges[] = $range;
                    }
                }
                $inclusiveDatesDisplay = implode(', ', $formattedRanges);
            @endphp
            <div class="field" id="field-office" style="top:160px; left:59px; width:180px;">{{ $officeShortcut }}</div>
            <div class="field" id="field-name_last" style="top:160px; left:345px; width:120px;">{{ $last }}</div>
            <div class="field" id="field-name_first" style="top:160px; left:466px; width:120px;">{{ $first }}</div>
            <div class="field" id="field-name_middle" style="top:160px; left:619px; width:69px; height:21px;">{{ $middle }}</div>
            <div class="field" id="field-filing_date" style="top:193px; left:140px; width:119px; height:20px;">{{ $filingDate ?? ($leave->filing_date ?? '') }}</div>
            <div class="field" id="field-position" style="top:193px; left:360px; width:193px; height:20px;">{{ $leave->user->position ?? $leave->position ?? '' }}</div>
            <div class="field" id="field-salary" style="top:193px; left: 625px;px; width:103px; height:20px;">{{ $leave->salary ?? '' }}</div>
            <!-- Leave Type Checkboxes -->
            <div class="field" id="field-leave_type_vacation" style="top:272px; left:26px; width:40px; height:20px;"><span class="custom-checkbox{{ in_array('Vacation Leave', $leaveTypesArr) ? ' checked' : '' }}"></span></div>
            <div class="field" id="field-leave_type_mandatory" style="top:295px; left:26px; width:40px; height:20px;"><span class="custom-checkbox{{ in_array('Mandatory/Forced Leave', $leaveTypesArr) ? ' checked' : '' }}"></span></div>
            <div class="field" id="field-leave_type_sick" style="top:317px; left:26px; width:40px; height:20px;"><span class="custom-checkbox{{ in_array('Sick Leave', $leaveTypesArr) ? ' checked' : '' }}"></span></div>
            <div class="field" id="field-leave_type_maternity" style="top:339px; left:26px; width:40px; height:20px;"><span class="custom-checkbox{{ in_array('Maternity Leave', $leaveTypesArr) ? ' checked' : '' }}"></span></div>
            <div class="field" id="field-leave_type_paternity" style="top:360px; left:26px; width:40px; height:20px;"><span class="custom-checkbox{{ in_array('Paternity Leave', $leaveTypesArr) ? ' checked' : '' }}"></span></div>
            <div class="field" id="field-leave_type_special_privilege" style="top:382px; left:26px; width:40px; height:20px;"><span class="custom-checkbox{{ in_array('Special Privilege Leave', $leaveTypesArr) ? ' checked' : '' }}"></span></div>
            <div class="field" id="field-leave_type_solo_parent" style="top:405px; left:26px; width:40px; height:20px;"><span class="custom-checkbox{{ in_array('Solo Parent Leave', $leaveTypesArr) ? ' checked' : '' }}"></span></div>
            <div class="field" id="field-leave_type_study" style="top:429px; left:26px; width:40px; height:20px;"><span class="custom-checkbox{{ in_array('Study Leave', $leaveTypesArr) ? ' checked' : '' }}"></span></div>
            <div class="field" id="field-leave_type_vawc" style="top:450px; left:26px; width:40px; height:20px;"><span class="custom-checkbox{{ in_array('10-Day VAWC Leave', $leaveTypesArr) ? ' checked' : '' }}"></span></div>
            <div class="field" id="field-leave_type_rehabilitation" style="top:473px; left:26px; width:40px; height:20px;"><span class="custom-checkbox{{ in_array('Rehabilitation Privilege', $leaveTypesArr) ? ' checked' : '' }}"></span></div>
            <div class="field" id="field-special_leave_benefits" style="top:495px; left:26px; width:40px; height:20px;"><span class="custom-checkbox{{ in_array('Special Leave Benefits for Women', $leaveTypesArr) ? ' checked' : '' }}"></span></div>
            <div class="field" id="field-leave_type_calamity" style="top:517px; left:26px; width:40px; height:20px;"><span class="custom-checkbox{{ in_array('Special Emergency (Calamity) Leave', $leaveTypesArr) ? ' checked' : '' }}"></span></div>
            <div class="field" id="field-leave_type_adoption" style="top:539px; left:26px; width:40px; height:20px;"><span class="custom-checkbox{{ in_array('Adoption Leave', $leaveTypesArr) ? ' checked' : '' }}"></span></div>
            <div class="field" id="field-leave_type_other" style="top:607px; left:40px; width:245px; height:20px;">{{ $leave->leave_type_other ?? '' }}</div>
            <!-- Detail Checkboxes -->
            <div class="field" id="field-within_ph" style="top:295px; left:423px; width:40px; height:20px;"><span class="custom-checkbox{{ $leave->within_ph == 'Yes' ? ' checked' : '' }}"></span></div>
            <div class="field" id="field-within_ph_details" style="top:295px; left:563px; width:180px; height:20px;">{{ $leave->within_ph_details ?? '' }}</div>
            <div class="field" id="field-abroad" style="top:317px; left:423px; width:40px; height:20px;"><span class="custom-checkbox{{ $leave->abroad == 'Yes' ? ' checked' : '' }}"></span></div>
            <div class="field" id="field-abroad_details" style="top:317px; left:538px; width:194px; height:20px;">{{ $leave->abroad_details ?? '' }}</div>
            <div class="field" id="field-in_hospital" style="top:360px; left:423px; width:40px; height:20px;"><span class="custom-checkbox{{ $leave->in_hospital == 'Yes' ? ' checked' : '' }}"></span></div>
            <div class="field" id="field-in_hospital_details" style="top:363px; left:585px; width:146px; height:20px;">{{ $leave->in_hospital_details ?? '' }}</div>
            <div class="field" id="field-out_patient" style="top:382px; left:423px; width:40px; height:20px;"><span class="custom-checkbox{{ $leave->out_patient == 'Yes' ? ' checked' : '' }}"></span></div>
            <div class="field" id="field-out_patient_details" style="top:407px; left:440px; width:289px; height:23px;">{{ $leave->out_patient_details ?? '' }}</div>
            <div class="field" id="field-special_leave_details" style="top:473px; left:440px; width:292px; height:20px;">{{ $leave->special_leave_details ?? '' }}</div>
            <div class="field" id="field-completion_masters" style="top:517px; left:423px; width:40px; height:20px;"><span class="custom-checkbox{{ $leave->completion_masters == 'Yes' ? ' checked' : '' }}"></span></div>
            <div class="field" id="field-bar_exam" style="top:540px; left:423px; width:40px; height:20px;"><span class="custom-checkbox{{ $leave->bar_exam == 'Yes' ? ' checked' : '' }}"></span></div>
            <div class="field" id="field-monetization" style="top:585px; left:423px; width:40px; height:20px;"><span class="custom-checkbox{{ $leave->monetization == 'Yes' ? ' checked' : '' }}"></span></div>
            <div class="field" id="field-terminal_leave" style="top:607px; left:423px; width:40px; height:20px;"><span class="custom-checkbox{{ $leave->terminal_leave == 'Yes' ? ' checked' : '' }}"></span></div>
            <!-- Number of Days and Dates -->
            <div class="field" id="field-num_days" style="top:658px; left:100px; width:259px; height:20px;">{{ $leave->num_days ?? '' }}</div>
            <div class="field" id="field-inclusive_dates" style="font-size:13px;top:705px; left:50px; width:300px; height:20px;">{{ $inclusiveDatesDisplay }}</div>
            <!-- Commutation Checkboxes -->
            <div class="field" id="field-commutation_not_requested" style="top:660px; left:423px; width:40px; height:20px;"><span class="custom-checkbox{{ $leave->commutation == 'Not Requested' ? ' checked' : '' }}"></span></div>
            <div class="field" id="field-commutation_requested" style="top:680px; left:423px; width:40px; height:20px;"><span class="custom-checkbox{{ $leave->commutation == 'Requested' ? ' checked' : '' }}"></span></div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // For iOS to recognize touch events properly
            document.addEventListener('touchstart', function() {}, {passive: true});
        });
    </script>
</body>
</html> 