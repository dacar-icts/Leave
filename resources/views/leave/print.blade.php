<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=850, initial-scale=1.0">
    <title>Application for Leave - Print</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @yield('styles')
    <style>
        body { 
            margin: 0; 
            padding: 0; 
            background: #fff;
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
        
        .leave-form {
            border: 1px solid #000;
            width: 100%;
            box-sizing: border-box;
            page-break-inside: avoid;
        }
        
        /* Form Header */
        .form-header {
            text-align: center;
            padding: 10px 0;
            border-bottom: 1px solid #000;
        }
        
        .form-header img {
            height: 60px;
            margin-bottom: 5px;
        }
        
        .title {
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        /* Form Rows */
        .form-row {
            display: flex;
            border-bottom: 1px solid #000;
        }
        
        .form-col-full {
            width: 100%;
            padding: 5px 10px;
        }
        
        .form-col-half {
            width: 50%;
            padding: 5px 10px;
        }
        
        .form-col-border-right {
            border-right: 1px solid #000;
        }
        
        .label {
            font-weight: bold;
            margin-bottom: 3px;
            font-size: 10pt;
        }
        
        /* Section Headers */
        .form-section-header {
            font-weight: bold;
            padding: 5px 10px;
            background-color: #f2f2f2;
            border-bottom: 1px solid #000;
            text-align: center;
        }
        
        /* Leave Types */
        .leave-types {
            display: flex;
            flex-direction: column;
            gap: 2px;
            padding: 5px 0;
        }
        
        .leave-type-item {
            display: flex;
            align-items: flex-start;
            gap: 5px;
        }
        
        /* Leave Details */
        .leave-details {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .leave-details-section {
            margin-bottom: 5px;
        }
        
        .leave-details-section .title {
            font-weight: bold;
            font-size: 10pt;
            margin-bottom: 3px;
        }
        
        .leave-details-item {
            display: flex;
            align-items: flex-start;
            gap: 5px;
            margin-left: 10px;
        }
        
        /* Signature */
        .form-signature {
            padding: 10px;
            display: flex;
            justify-content: flex-end;
            border-bottom: 1px solid #000;
        }
        
        .signature-box {
            width: 250px;
            text-align: center;
        }
        
        .signature-line {
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            margin-bottom: 3px;
            font-weight: bold;
        }
        
        .signature-label {
            font-size: 9pt;
        }
        
        /* Certification Section */
        .certification-section {
            border-top: 1px solid #000;
        }
        
        .certification-title {
            font-weight: bold;
            padding: 5px 10px;
            background-color: #f2f2f2;
            border-bottom: 1px solid #000;
            text-align: center;
        }
        
        .certification-table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0;
        }
        
        .certification-table th, .certification-table td {
            border: 1px solid #000;
            padding: 3px 5px;
            text-align: center;
        }
        
        .certification-table th {
            background-color: #f9f9f9;
        }
        
        .signatory {
            text-align: center;
            margin-top: 10px;
        }
        
        .signatory-name {
            font-weight: bold;
            color: #006400;
        }
        
        .signatory-position {
            font-size: 9pt;
        }
        
        .recommendation-section {
            padding: 5px 10px;
        }
        
        .recommendation-item {
            display: flex;
            align-items: flex-start;
            gap: 5px;
            margin-bottom: 5px;
        }
        
        .approval-section {
            display: flex;
            border-top: 1px solid #000;
        }
        
        .approval-section > div {
            width: 50%;
            padding: 5px 10px;
        }
        
        .approval-section > div:first-child {
            border-right: 1px solid #000;
        }
        
        .approval-items {
            margin-top: 5px;
        }
        
        .approval-item {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 3px;
        }
        
        .approval-item-line {
            flex-grow: 1;
            border-bottom: 1px solid #000;
            margin: 0 5px;
        }
        
        @media print {
            body { 
                background: #fff; 
                margin: 0;
                padding: 0;
            }
            .print-bg-container { 
                margin: 0; 
                page-break-inside: avoid;
                break-inside: avoid;
            }
            @page {
                margin: 0;
                size: A4 portrait;
            }
        }
        /* Custom checkbox style for print overlay */
        .print-bg-container .custom-checkbox {
            display: inline-block;
            width: 11px;
            height: 11px;
            border: 1px solid #000;
            background: #fff;
            position: relative;
            vertical-align: middle;
            margin: 0 2px 0 0;
        }
        .print-bg-container .custom-checkbox.checked::after {
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
        .print-bg-container input[type="checkbox"] {
            display: none !important;
        }
        @media print {
            #printBtn, #downloadBtn, .size-indicator { display: none !important; }
            .print-bg-container { border: none; }
        }
    </style>
</head>
<body>
    @yield('print_buttons')
    @if(!$__env->hasSection('print_buttons'))
    <div style="position:fixed; top:20px; right:30px; z-index:1000; display:flex; gap:10px;">
        <button id="downloadBtn" style="padding:10px 22px; font-size:16px; background:#2196F3; color:#fff; border:none; border-radius:5px; cursor:pointer;">
            Download PDF
        </button>
        <button id="printBtn" style="padding:10px 22px; font-size:16px; background:#4CAF50; color:#fff; border:none; border-radius:5px; cursor:pointer;">
            Print
        </button>
    </div>
    @endif
    
    @yield('header_controls')
    @yield('rejection_notice')
    
    <div class="print-bg-container" id="printArea">
        <img src="{{ asset('cs_form_6_bg.png') }}" class="bg" alt="Form Background">
        <!-- Form fields -->
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
            $standardTypes = [
                'Vacation Leave', 'Mandatory/Forced Leave', 'Sick Leave', 'Maternity Leave', 'Paternity Leave',
                'Special Privilege Leave', 'Solo Parent Leave', 'Study Leave', '10-Day VAWC Leave',
                'Rehabilitation Privilege', 'Special Leave Benefits for Women', 'Special Emergency (Calamity) Leave', 'Adoption Leave'
            ];
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
        @endphp
        
        <div class="field" id="field-office" style="top:160px; left:59px; width:180px;">
            {{ $officeShortcut }}
        </div>
        <div class="field" id="field-name_last" style="top:160px; left:345px; width:120px;">
            {{ $last }}
        </div>
        <div class="field" id="field-name_first" style="top:160px; left:466px; width:120px;">
            {{ $first }}
        </div>
        <div class="field" id="field-name_middle" style="top:160px; left:619px; width:69px; height:21px;">
            {{ $middle }}
        </div>
        <div class="field" id="field-filing_date" style="top:193px; left:140px; width:119px; height:20px;">
            {{ $filingDate ?? ($leave->filing_date ?? '') }}
        </div>
        <div class="field" id="field-position" style="top:193px; left:360px; width:193px; height:20px;">
            {{ $leave->user->position ?? $leave->position ?? '' }}
        </div>
        <div class="field" id="field-salary" style="top:193px; left: 625px;px; width:103px; height:20px;">
            {{ $leave->salary ?? '' }}
        </div>
        
        <!-- Leave Type Checkboxes (keep original positions) -->
        <div class="field" id="field-leave_type_vacation" style="top:272px; left:26px; width:40px; height:20px;">
            <span class="custom-checkbox{{ in_array('Vacation Leave', $leaveTypesArr) ? ' checked' : '' }}"></span>
        </div>
        <div class="field" id="field-leave_type_mandatory" style="top:295px; left:26px; width:40px; height:20px;">
            <span class="custom-checkbox{{ in_array('Mandatory/Forced Leave', $leaveTypesArr) ? ' checked' : '' }}"></span>
        </div>
        <div class="field" id="field-leave_type_sick" style="top:317px; left:26px; width:40px; height:20px;">
            <span class="custom-checkbox{{ in_array('Sick Leave', $leaveTypesArr) ? ' checked' : '' }}"></span>
        </div>
        <div class="field" id="field-leave_type_maternity" style="top:339px; left:26px; width:40px; height:20px;">
            <span class="custom-checkbox{{ in_array('Maternity Leave', $leaveTypesArr) ? ' checked' : '' }}"></span>
        </div>
        <div class="field" id="field-leave_type_paternity" style="top:360px; left:26px; width:40px; height:20px;">
            <span class="custom-checkbox{{ in_array('Paternity Leave', $leaveTypesArr) ? ' checked' : '' }}"></span>
        </div>
        <div class="field" id="field-leave_type_special_privilege" style="top:382px; left:26px; width:40px; height:20px;">
            <span class="custom-checkbox{{ in_array('Special Privilege Leave', $leaveTypesArr) ? ' checked' : '' }}"></span>
        </div>
        <div class="field" id="field-leave_type_solo_parent" style="top:405px; left:26px; width:40px; height:20px;">
            <span class="custom-checkbox{{ in_array('Solo Parent Leave', $leaveTypesArr) ? ' checked' : '' }}"></span>
        </div>
        <div class="field" id="field-leave_type_study" style="top:429px; left:26px; width:40px; height:20px;">
            <span class="custom-checkbox{{ in_array('Study Leave', $leaveTypesArr) ? ' checked' : '' }}"></span>
        </div>
        <div class="field" id="field-leave_type_vawc" style="top:450px; left:26px; width:40px; height:20px;">
            <span class="custom-checkbox{{ in_array('10-Day VAWC Leave', $leaveTypesArr) ? ' checked' : '' }}"></span>
        </div>
        <div class="field" id="field-leave_type_rehabilitation" style="top:473px; left:26px; width:40px; height:20px;">
            <span class="custom-checkbox{{ in_array('Rehabilitation Privilege', $leaveTypesArr) ? ' checked' : '' }}"></span>
        </div>
        <div class="field" id="field-special_leave_benefits" style="top:495px; left:26px; width:40px; height:20px;">
            <span class="custom-checkbox{{ in_array('Special Leave Benefits for Women', $leaveTypesArr) ? ' checked' : '' }}"></span>
        </div>
        <div class="field" id="field-leave_type_calamity" style="top:517px; left:26px; width:40px; height:20px;">
            <span class="custom-checkbox{{ in_array('Special Emergency (Calamity) Leave', $leaveTypesArr) ? ' checked' : '' }}"></span>
        </div>
        <div class="field" id="field-leave_type_adoption" style="top:539px; left:26px; width:40px; height:20px;">
            <span class="custom-checkbox{{ in_array('Adoption Leave', $leaveTypesArr) ? ' checked' : '' }}"></span>
        </div>
        <!-- Others field -->
        <div class="field" id="field-leave_type_other" style="top:607px; left:40px; width:245px; height:20px;">
            @foreach($leaveTypesArr as $type)
                @if(!in_array($type, $standardTypes))
                    <label>{{ $type }}</label>
                @endif
            @endforeach
        </div>
        
        <!-- Detail Checkboxes -->
        <div class="field" id="field-within_ph" style="top:295px; left:423px; width:40px; height:20px;">
            <span class="custom-checkbox{{ $leave->within_ph == 'Yes' ? ' checked' : '' }}"></span>
        </div>
        <div class="field" id="field-within_ph_details" style="top:295px; left:563px; width:180px; height:20px;">
            {{ $leave->within_ph_details ?? '' }}
        </div>
        <div class="field" id="field-abroad" style="top:317px; left:423px; width:40px; height:20px;">
            <span class="custom-checkbox{{ $leave->abroad == 'Yes' ? ' checked' : '' }}"></span>
        </div>
        <div class="field" id="field-abroad_details" style="top:317px; left:538px; width:194px; height:20px;">
            {{ $leave->abroad_details ?? '' }}
        </div>
        <div class="field" id="field-in_hospital" style="top:360px; left:423px; width:40px; height:20px;">
            <span class="custom-checkbox{{ $leave->in_hospital == 'Yes' ? ' checked' : '' }}"></span>
        </div>
        <div class="field" id="field-in_hospital_details" style="top:363px; left:585px; width:146px; height:20px;">
            {{ $leave->in_hospital_details ?? '' }}
        </div>
        <div class="field" id="field-out_patient" style="top:382px; left:423px; width:40px; height:20px;">
            <span class="custom-checkbox{{ $leave->out_patient == 'Yes' ? ' checked' : '' }}"></span>
        </div>
        <div class="field" id="field-out_patient_details" style="top:407px; left:440px; width:289px; height:23px;">
            {{ $leave->out_patient_details ?? '' }}
        </div>

        <div class="field" id="field-special_leave_details" style="top:473px; left:440px; width:292px; height:20px;">
            {{ $leave->special_leave_details ?? '' }}
        </div>
        <div class="field" id="field-completion_masters" style="top:517px; left:423px; width:40px; height:20px;">
            <span class="custom-checkbox{{ $leave->completion_masters == 'Yes' ? ' checked' : '' }}"></span>
        </div>
        <div class="field" id="field-bar_exam" style="top:540px; left:423px; width:40px; height:20px;">
            <span class="custom-checkbox{{ $leave->bar_exam == 'Yes' ? ' checked' : '' }}"></span>
        </div>
        <div class="field" id="field-monetization" style="top:585px; left:423px; width:40px; height:20px;">
            <span class="custom-checkbox{{ $leave->monetization == 'Yes' ? ' checked' : '' }}"></span>
        </div>
        <div class="field" id="field-terminal_leave" style="top:607px; left:423px; width:40px; height:20px;">
            <span class="custom-checkbox{{ $leave->terminal_leave == 'Yes' ? ' checked' : '' }}"></span>
        </div>
        
        <!-- Number of Days and Dates -->
        <div class="field" id="field-num_days" style="top:658px; left:100px; width:259px; height:20px;">
            {{ $leave->num_days ?? '' }}
        </div>
        <div class="field" id="field-inclusive_dates" style="top:705px; left:50px; width:350px; height:20px; ">
            @php
                $displayed = false;
                $raw = $leave->inclusive_dates ?? '';
                $ranges = [];
                // Try to decode JSON if it looks like a JSON array
                if (is_string($raw) && strlen($raw) > 0 && $raw[0] === '[') {
                    $decoded = json_decode($raw, true);
                    if (is_array($decoded)) {
                        $ranges = $decoded;
                    }
                } elseif (is_array($raw)) {
                    $ranges = $raw;
                } elseif (is_string($raw)) {
                    $ranges = explode(',', $raw);
                }
                if (count($ranges)) {
                    foreach($ranges as $idx => $range) {
                        $range = trim($range, " \"");
                        $dates = explode(' to ', $range);
                        if(count($dates) === 2) {
                            try {
                                $start = \Carbon\Carbon::parse($dates[0]);
                                $end = \Carbon\Carbon::parse($dates[1]);
                                if ($start->format('M Y') === $end->format('M Y')) {
                                    echo $start->format('M j') . '-' . $end->format('j, Y');
                                } elseif ($start->format('Y') === $end->format('Y')) {
                                    echo $start->format('M j') . ' - ' . $end->format('M j, Y');
                                } else {
                                    echo $start->format('M j, Y') . ' - ' . $end->format('M j, Y');
                                }
                            } catch (Exception $e) {
                                echo e($range);
                            }
                        } else {
                            // Format single date as 'M j, Y'
                            try {
                                $single = \Carbon\Carbon::parse($range);
                                echo $single->format('M j, Y');
                            } catch (Exception $e) {
                                echo e($range);
                            }
                        }
                        if ($idx !== count($ranges) - 1) echo ', ';
                        $displayed = true;
                    }
                }
                if (!$displayed) {
                    echo e($formattedInclusiveDates ?? $raw);
                }
            @endphp
        </div>
        
        
        <!-- Commutation Checkboxes -->
        <div class="field" id="field-commutation_not_requested" style="top:660px; left:423px; width:40px; height:20px;">
            <span class="custom-checkbox{{ $leave->commutation == 'Not Requested' ? ' checked' : '' }}"></span>
        </div>
        <div class="field" id="field-commutation_requested" style="top:680px; left:423px; width:40px; height:20px;">
            <span class="custom-checkbox{{ $leave->commutation == 'Requested' ? ' checked' : '' }}"></span>
        </div>
        
        <!-- Certification Fields -->
        <div class="field" id="field-cert_as_of_date" style="top:790px; left:137.5px; width:152px; height:20px; font-size:12.4px; opacity:0.8">
            f
        </div>
        <div class="field" id="field-cert_as_of_date" style="top:785px; left:180px; width:152px; height:20px;">
            {{ $certData['as_of_date'] ?? $certDate ?? '' }}
        </div>
        <div class="field" id="field-cert_vl_earned" style="top:828px; left:165px; width:95px; height:20px; text-align:center;">
            {{ $certData['vl_earned'] ?? '' }}
        </div>
        <div class="field" id="field-cert_vl_less" style="top:843px; left:165px; width:95px; height:20px; text-align:center;">
            {{ $certData['vl_less'] ?? '' }}
        </div>
        <div class="field" id="field-cert_vl_balance" style="top:859px; left:165px; width:95px; height:20px; text-align:center;">
            {{ $certData['vl_balance'] ?? '' }}
        </div>
        <div class="field" id="field-cert_sl_earned" style="top:827px; left:280px; width:95px; height:20px; text-align:center;">
            {{ $certData['sl_earned'] ?? '' }}
        </div>
        <div class="field" id="field-cert_sl_less" style="top:843px; left:280px; width:95px; height:20px;text-align:center;">
            {{ $certData['sl_less'] ?? '' }}
        </div>
        <div class="field" id="field-cert_sl_balance" style="top:859px; left:280px; width:95px; height:20px;text-align:center;">
            {{ $certData['sl_balance'] ?? '' }}
        </div>
        
        <!-- Overlay white boxes and dynamic signatory names/positions -->
        <!-- 1st signatory (HR) -->

        <div class="F-letter">f</div>
        <div style="position:absolute; top:915px; left:120px; width:220px; height=27px; background:#fff; z-index:10;"></div>
        <div style="position:absolute; top:915px; left:120px; width=210px; z-index=11; text-align:center;">
            <span style="font-family:Cambria,serif; font-size:10pt; font-weight:bold; letter-spacing:0.5px;">{{ $certData['hr_name'] ?? 'JOY ROSE C. BAWAYAN' }}</span>
            <span style="font-family:Cambria,serif; font-size:9pt; display:block; line-height:1.1; margin-top:-2px;">{{ $certData['hr_position'] ?? 'Administrative Officer V (HRMO III)' }}</span>
        </div>
        <div style="position:absolute; bottom:177px; right:70px; width:200px; height=27px; background:#fff; z-index:10;"></div>
        <!-- 2nd signatory (Admin) - Only show if user provided one -->
        @php
            // Only show 2nd signatory if user provided one
            $adminName = '';
            $adminPosition = '';
            
            if (!empty($leave->admin_signatory)) {
                $adminParts = explode('|', $leave->admin_signatory);
                $adminName = $adminParts[0] ?? '';
                $adminPosition = $adminParts[1] ?? '';
            }
        @endphp
        @if(!empty($adminName))
            <div style="position:absolute; top:915px; left:435px; width:300px; height=27px; background:#fff; z-index:10;"></div>
            <div style="position:absolute; top:915px; left:435px; width:300px; z-index=11; text-align:center;">
                <span style="font-family:Cambria,serif; font-size:10pt; font-weight:bold; letter-spacing:0.5px;">{{ $adminName }}</span>
                <span style="font-family:Cambria,serif; font-size:9pt; display:block; line-height:1.1; margin-top:-2px;">{{ $adminPosition }}</span>
            </div>
        @endif
        <!-- 3rd signatory (Director) -->
        
        <div style="position:absolute; top:1065px; left:210px; width:400px; height=30px; background:#fff; z-index:10;">
        </div>
        <div style="position:absolute; top:1065px; left:210px; width=390px; z-index=11; text-align:center;">
            <span style="font-family:Cambria,serif; font-size:10pt; font-weight:bold; letter-spacing:0.5px;">{{ $certData['director_name'] ?? 'Atty. JENNILYN M. DAWAYAN, CESO IV' }}</span>
            <span style="font-family:Cambria,serif; font-size:9pt; display:block; line-height:1.1; margin-top:-2px;">{{ $certData['director_position'] ?? 'Regional Executive Director' }}</span>
        </div>
        <div class="withPAY" style="position:absolute; top:965px; left:55px; width:390px; z-index: 11;">
            <span style="font-size:10pt; letter-spacing:0.5px;">
                {{ $certData['approved_with_pay'] ?? '' }}
            </span>
        </div>
        <div class="withoutPAY" style="position:absolute; top:981px; left:55px; width:390px; z-index: 11;">
            <span style="font-size:10pt; letter-spacing:0.5px;">
                {{ $certData['approved_without_pay'] ?? '' }}
            </span>
        </div>
        <div class="otherPAY" style="position:absolute; top:997px; left:55px; width:390px; z-index: 11;">
            <span style="font-size:10pt; letter-spacing:0.5px;">
                {{ $certData['approved_others'] ?? '' }}
            </span>
        </div>
        
        @yield('signatory_overlay')
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        // PDF download functionality
        function downloadPDF() {
            const element = document.getElementById('printArea');
            element.scrollIntoView({ behavior: 'instant', block: 'start' }); // Scrolls form to top
            setTimeout(() => {
                html2pdf().set({
                    margin: [0, 0, 0, 0],
                    filename: 'leave-application.pdf',
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { 
                        scale: 2,
                        useCORS: true,
                        allowTaint: true
                    },
                    jsPDF: { 
                        unit: 'pt', 
                        format: 'a4', 
                        orientation: 'portrait',
                        compress: true
                    }
                }).from(element).save();
            }, 200); // Wait a moment for scroll to finish
        }

        document.addEventListener('DOMContentLoaded', function() {
            var printBtn = document.getElementById('printBtn');
            var downloadBtn = document.getElementById('downloadBtn');
            
            if (printBtn) printBtn.addEventListener('click', function() { window.print(); });
            if (downloadBtn) downloadBtn.addEventListener('click', function() { downloadPDF(); });
        });
    </script>
</body>
</html>
