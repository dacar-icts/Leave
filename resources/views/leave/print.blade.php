<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=850, initial-scale=1.0">
    <title>Application for Leave - Print</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body { 
            margin: 0; 
            padding: 0; 
            background: #fff; 
        }
        .print-bg-container {
            position: relative;
            width: 850px;
            height: 1200px;
            margin: 30px auto;
            background: #fff;
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
        }
        @media print {
            body { background: #fff; }
            .print-bg-container { margin: 0; }
        }
        /* Custom checkbox style for print overlay */
        .print-bg-container input[type="checkbox"] {
            width: 11px;
            height: 12px;
            margin: 0 2px 0 0;
            vertical-align: middle;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            border: 1px solid #000;
            background-color: #fff;
            border-radius: 2px;
            position: relative;
            cursor: pointer;
        }
        .print-bg-container input[type="checkbox"]:checked {
            background-color: #fff;
            border-color: #000;
        }
        .print-bg-container input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            left: 2px;
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
            // Ensure leave_type is always an array for checkbox checks
            if (is_array($leave->leave_type)) {
                $leaveTypesArr = $leave->leave_type;
            } elseif (is_string($leave->leave_type) && $leave->leave_type && $leave->leave_type[0] === '[') {
                $leaveTypesArr = json_decode($leave->leave_type, true) ?? [];
            } else {
                $leaveTypesArr = [];
            }
        @endphp
        
        <div class="field" id="field-office" style="top:150px; left:59px; width:180px;">
            {{ $leave->user->offices ?? $leave->office ?? '' }}
        </div>
        <div class="field" id="field-name_last" style="top:150px; left:357px; width:120px;">
            {{ $last }}
        </div>
        <div class="field" id="field-name_first" style="top:151px; left:481px; width:120px;">
            {{ $first }}
        </div>
        <div class="field" id="field-name_middle" style="top:151px; left:631px; width:69px; height:21px;">
            {{ $middle }}
        </div>
        <div class="field" id="field-filing_date" style="top:190px; left:160px; width:119px; height:20px;">
            {{ $filingDate ?? ($leave->filing_date ?? '') }}
        </div>
        <div class="field" id="field-position" style="top:190px; left:380px; width:193px; height:20px;">
            {{ $leave->user->position ?? $leave->position ?? '' }}
        </div>
        <div class="field" id="field-salary" style="top:190px; left:645px; width:103px; height:20px;">
            {{ $leave->salary ?? '' }}
        </div>
        
        <!-- Leave Type Checkboxes -->
        <div class="field" id="field-leave_type_vacation" style="top:268px; left:53px; width:40px; height:20px;">
            <input type="checkbox" id="leave_type_vacation" {{ in_array('Vacation Leave', $leaveTypesArr) ? 'checked' : '' }} disabled>
        </div>
        <div class="field" id="field-leave_type_mandatory" style="top:291px; left:53px; width:40px; height:20px;">
            <input type="checkbox" id="leave_type_mandatory" {{ in_array('Mandatory/Forced Leave', $leaveTypesArr) ? 'checked' : '' }} disabled>
        </div>
        <div class="field" id="field-leave_type_sick" style="top:313px; left:53px; width:40px; height:20px;">
            <input type="checkbox" id="leave_type_sick" {{ in_array('Sick Leave', $leaveTypesArr) ? 'checked' : '' }} disabled>
        </div>
        <div class="field" id="field-leave_type_maternity" style="top:335px; left:53px; width:40px; height:20px;">
            <input type="checkbox" id="leave_type_maternity" {{ in_array('Maternity Leave', $leaveTypesArr) ? 'checked' : '' }} disabled>
        </div>
        <div class="field" id="field-leave_type_paternity" style="top:356px; left:53px; width:40px; height:20px;">
            <input type="checkbox" id="leave_type_paternity" {{ in_array('Paternity Leave', $leaveTypesArr) ? 'checked' : '' }} disabled>
        </div>
        <div class="field" id="field-leave_type_special_privilege" style="top:378px; left:53px; width:40px; height:20px;">
            <input type="checkbox" id="leave_type_special_privilege" {{ in_array('Special Privilege Leave', $leaveTypesArr) ? 'checked' : '' }} disabled>
        </div>
        <div class="field" id="field-leave_type_solo_parent" style="top:401px; left:53px; width:40px; height:20px;">
            <input type="checkbox" id="leave_type_solo_parent" {{ in_array('Solo Parent Leave', $leaveTypesArr) ? 'checked' : '' }} disabled>
        </div>
        <div class="field" id="field-leave_type_study" style="top:423px; left:53px; width:40px; height:20px;">
            <input type="checkbox" id="leave_type_study" {{ in_array('Study Leave', $leaveTypesArr) ? 'checked' : '' }} disabled>
        </div>
        <div class="field" id="field-leave_type_vawc" style="top:445px; left:53px; width:40px; height:20px;">
            <input type="checkbox" id="leave_type_vawc" {{ in_array('10-Day VAWC Leave', $leaveTypesArr) ? 'checked' : '' }} disabled>
        </div>
        <div class="field" id="field-leave_type_rehabilitation" style="top:467px; left:53px; width:40px; height:20px;">
            <input type="checkbox" id="leave_type_rehabilitation" {{ in_array('Rehabilitation Privilege', $leaveTypesArr) ? 'checked' : '' }} disabled>
        </div>
        <div class="field" id="field-special_leave_benefits" style="top:489px; left:53px; width:40px; height:20px;">
            <input type="checkbox" id="special_leave_benefits" {{ in_array('Special Leave Benefits for Women', $leaveTypesArr) ? 'checked' : '' }} disabled>
        </div>
        <div class="field" id="field-leave_type_calamity" style="top:511px; left:53px; width:40px; height:20px;">
            <input type="checkbox" id="leave_type_calamity" {{ in_array('Special Emergency (Calamity) Leave', $leaveTypesArr) ? 'checked' : '' }} disabled>
        </div>
        <div class="field" id="field-leave_type_adoption" style="top:533px; left:53px; width:40px; height:20px;">
            <input type="checkbox" id="leave_type_adoption" {{ in_array('Adoption Leave', $leaveTypesArr) ? 'checked' : '' }} disabled>
        </div>
        <div class="field" id="field-leave_type_other" style="top:600px; left:60px; width:245px; height:20px;">
            {{ $leave->leave_type_other ?? '' }}
        </div>
        
        <!-- Detail Checkboxes -->
        <div class="field" id="field-within_ph" style="top:290px; left:450px; width:40px; height:20px;">
            <input type="checkbox" id="within_ph" {{ $leave->within_ph == 'Yes' ? 'checked' : '' }} disabled>
        </div>
        <div class="field" id="field-within_ph_details" style="top:290px; left:590px; width:180px; height:20px;">
            {{ $leave->within_ph_details ?? '' }}
        </div>
        <div class="field" id="field-abroad" style="top:312px; left:450px; width:40px; height:20px;">
            <input type="checkbox" id="abroad" {{ $leave->abroad == 'Yes' ? 'checked' : '' }} disabled>
        </div>
        <div class="field" id="field-abroad_details" style="top:312px; left:565px; width:194px; height:20px;">
            {{ $leave->abroad_details ?? '' }}
        </div>
        <div class="field" id="field-in_hospital" style="top:355px; left:450px; width:40px; height:20px;">
            <input type="checkbox" id="in_hospital" {{ $leave->in_hospital == 'Yes' ? 'checked' : '' }} disabled>
        </div>
        <div class="field" id="field-in_hospital_details" style="top:358px; left:612px; width:146px; height:20px;">
            {{ $leave->in_hospital_details ?? '' }}
        </div>
        <div class="field" id="field-out_patient" style="top:377px; left:450px; width:40px; height:20px;">
            <input type="checkbox" id="out_patient" {{ $leave->out_patient == 'Yes' ? 'checked' : '' }} disabled>
        </div>
        <div class="field" id="field-out_patient_details" style="top:400px; left:455px; width:289px; height:23px;">
            {{ $leave->out_patient_details ?? '' }}
        </div>

        <div class="field" id="field-special_leave_details" style="top:468px; left:455px; width:292px; height:20px;">
            {{ $leave->special_leave_details ?? '' }}
        </div>
        <div class="field" id="field-completion_masters" style="top:510px; left:450px; width:40px; height:20px;">
            <input type="checkbox" id="completion_masters" {{ $leave->completion_masters == 'Yes' ? 'checked' : '' }} disabled>
        </div>
        <div class="field" id="field-bar_exam" style="top:533px; left:450px; width:40px; height:20px;">
            <input type="checkbox" id="bar_exam" {{ $leave->bar_exam == 'Yes' ? 'checked' : '' }} disabled>
        </div>
        <div class="field" id="field-monetization" style="top:577px; left:450px; width:40px; height:20px;">
            <input type="checkbox" id="monetization" {{ $leave->monetization == 'Yes' ? 'checked' : '' }} disabled>
        </div>
        <div class="field" id="field-terminal_leave" style="top:599px; left:450px; width:40px; height:20px;">
            <input type="checkbox" id="terminal_leave" {{ $leave->terminal_leave == 'Yes' ? 'checked' : '' }} disabled>
        </div>
        
        <!-- Number of Days and Dates -->
        <div class="field" id="field-num_days" style="top:650px; left:100px; width:259px; height:20px;">
            {{ $leave->num_days ?? '' }}
        </div>
        <div class="field" id="field-inclusive_dates" style="top:694px; left:66px; width:258px; height:20px;">
            {{ $leave->inclusive_dates ?? '' }}
        </div>
        
        <!-- Commutation Checkboxes -->
        <div class="field" id="field-commutation_not_requested" style="top:649px; left:450px; width:40px; height:20px;">
            <input type="checkbox" id="commutation_not_requested" {{ $leave->commutation == 'Not Requested' ? 'checked' : '' }} disabled>
        </div>
        <div class="field" id="field-commutation_requested" style="top:671px; left:450px; width:40px; height:20px;">
            <input type="checkbox" id="commutation_requested" {{ $leave->commutation == 'Requested' ? 'checked' : '' }} disabled>
        </div>
        
        <!-- Certification Fields -->
        <div class="field" id="field-cert_as_of_date" style="top:776px; left:180px; width:152px; height:20px;">
            {{ $certData['as_of_date'] ?? $certDate ?? '' }}
        </div>
        <div class="field" id="field-cert_vl_earned" style="top:816px; left:188px; width:113px; height:20px;">
            {{ $certData['vl_earned'] ?? '' }}
        </div>
        <div class="field" id="field-cert_vl_less" style="top:831px; left:188px; width:115px; height:20px;">
            {{ $certData['vl_less'] ?? '' }}
        </div>
        <div class="field" id="field-cert_vl_balance" style="top:847px; left:188px; width:114px; height:20px;">
            {{ $certData['vl_balance'] ?? '' }}
        </div>
        <div class="field" id="field-cert_sl_earned" style="top:815px; left:300px; width:109px; height:20px;">
            {{ $certData['sl_earned'] ?? '' }}
        </div>
        <div class="field" id="field-cert_sl_less" style="top:833px; left:300px; width:111px; height:20px;">
            {{ $certData['sl_less'] ?? '' }}
        </div>
        <div class="field" id="field-cert_sl_balance" style="top:848px; left:300px; width:113px; height:20px;">
            {{ $certData['sl_balance'] ?? '' }}
        </div>
        
        <!-- Overlay white boxes and dynamic signatory names/positions -->
        <!-- 1st signatory (HR) -->
        <div style="position:absolute; top:905px; left:150px; width:220px; height:25px; background:#fff; z-index:10;"></div>
        <div style="position:absolute; top:900px; left:150px; width:210px; z-index:11; text-align:center;">
            <span style="font-family:Cambria,serif; font-size:10pt; font-weight:bold; letter-spacing:0.5px;">{{ $certData['hr_name'] ?? 'JOY ROSE C. BAWAYAN' }}</span>
            <span style="font-family:Cambria,serif; font-size:9pt; display:block; line-height:1.1; margin-top:-2px;">{{ $certData['hr_position'] ?? 'Administrative Officer V (HRMO III)' }}</span>
        </div>
        <!-- 2nd signatory (Admin) -->
        <div style="position:absolute; top:905px; left:440px; width:300px; height:25px; background:#fff; z-index:10;"></div>
        <div style="position:absolute; top:900px; left:445px; width:300px; z-index:11; text-align:center;">
            <span style="font-family:Cambria,serif; font-size:10pt; font-weight:bold; letter-spacing:0.5px;">{{ $certData['admin_name'] ?? 'AIDA Y. PAGTAN' }}</span>
            <span style="font-family:Cambria,serif; font-size:9pt; display:block; line-height:1.1; margin-top:-2px;">{{ $certData['admin_position'] ?? 'Chief, Administrative and Finance Division' }}</span>
        </div>
        <!-- 3rd signatory (Director) -->
        <div style="position:absolute; top:1050px; left:220px; width:400px; height:30px; background:#fff; z-index:10;"></div>
        <div style="position:absolute; top:1045px; left:225px; width:390px; z-index:11; text-align:center;">
            <span style="font-family:Cambria,serif; font-size:10pt; font-weight:bold; letter-spacing:0.5px;">{{ $certData['director_name'] ?? 'Atty. JENNILYN M. DAWAYAN, CESO IV' }}</span>
            <span style="font-family:Cambria,serif; font-size:9pt; display:block; line-height:1.1; margin-top:-2px;">{{ $certData['director_position'] ?? 'Regional Executive Director' }}</span>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        // Simple print functionality
        window.print = function() {
            window.print();
        };
        
        // PDF download functionality
        function downloadPDF() {
            const element = document.getElementById('printArea');
            html2pdf().set({
                margin: 0,
                filename: 'leave-application.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'pt', format: 'a4', orientation: 'portrait' }
            }).from(element).save();
        }
    </script>
</body>
</html>
