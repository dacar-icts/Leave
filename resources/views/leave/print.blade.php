<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=850, initial-scale=1.0">
    <title>Application for Leave - Print</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body { margin: 0; padding: 0; background: #fff; }
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
        .draggable {
            position: absolute;
            z-index: 2;
            background: rgba(0, 150, 255, 0.10);
            border: 1px solid #2196f3;
            border-radius: 4px;
            padding: 2px 8px;
            cursor: move;
            font-size: 15px;
            color: #222;
            min-width: 80px;
            min-height: 20px;
            user-select: none;
            transition: box-shadow 0.2s;
            box-sizing: border-box;
        }
        .draggable:active {
            box-shadow: 0 0 8px #2196f3;
        }
        .resize-handle {
            position: absolute;
            width: 14px;
            height: 14px;
            right: 0; bottom: 0;
            background: #2196f3;
            border-radius: 0 0 4px 0;
            cursor: se-resize;
            z-index: 3;
            display: flex;
            align-items: flex-end;
            justify-content: flex-end;
        }
        .resize-handle:after {
            content: '';
            display: block;
            width: 10px;
            height: 10px;
            border-right: 2px solid #fff;
            border-bottom: 2px solid #fff;
            margin: 2px;
        }
        .label {
            font-size: 12px;
            color: #1976d2;
            font-weight: bold;
            margin-bottom: 2px;
            display: block;
        }
        .print-controls { text-align: center; margin: 30px 0 10px 0; }
        .print-btn, .download-btn, .save-layout-btn {
            background: #4CAF50; color: #fff; border: none; border-radius: 5px;
            padding: 10px 22px; font-size: 16px; margin: 0 10px; cursor: pointer;
            transition: background 0.2s;
        }
        .print-btn:hover, .download-btn:hover, .save-layout-btn:hover { background: #388e3c; }
        @media print {
            .print-controls { display: none !important; }
            body { background: #fff; }
            .print-bg-container { margin: 0; }
            .draggable { background: none !important; border: none !important; }
            .resize-handle { display: none !important; }
        }
        /* Custom checkbox style for print overlay */
        .print-bg-container input[type="checkbox"] {
            width: 11px;
            height: 11px;
            accent-color: #000;
            margin: 0 2px 0 0;
            vertical-align: middle;
        }
        .print-bg-container input[type="checkbox"]:checked {
            accent-color: #000;
        }
    </style>
</head>
<body>
    <div class="print-controls">
        <button class="print-btn" onclick="window.print()"><span class="material-icons">print</span> Print</button>
        <button class="download-btn" id="downloadPdfBtn"><span class="material-icons">download</span> Download as PDF</button>
        <button class="save-layout-btn" id="saveLayoutBtn"><span class="material-icons">save</span> Save Layout</button>
    </div>
    <div class="print-bg-container" id="printArea">
        <img src="{{ asset('cs_form_6_bg.png') }}" class="bg" alt="Form Background">
        <!-- Draggable user-editable fields with resize handles -->
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
        <div class="draggable" id="field-office" style="top:150px; left:59px; width:180px;">
            {{ $leave->user->offices ?? $leave->office ?? '' }}
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-name_last" style="top:150px; left:357px; width:120px;">
            {{ $last }}
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-name_first" style="top:151px; left:481px; width:120px;">
            {{ $first }}
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-name_middle" style="top:151px; left:608px; width:69px; height:21px;">
            {{ $middle }}
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-filing_date" style="top:188px; left:153px; width:119px; height:20px;">
            {{ $filingDate ?? ($leave->filing_date ?? '') }}
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-position" style="top:187px; left:377px; width:193px; height:20px;">
            {{ $leave->user->position ?? $leave->position ?? '' }}
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-salary" style="top:186px; left:642px; width:103px; height:20px;">
            {{ $leave->salary ?? '' }}
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-leave_type_vacation" style="top:266px; left:39px; width:95px; height:20px;">
            <input type="checkbox" id="leave_type_vacation" {{ in_array('Vacation Leave', $leaveTypesArr) ? 'checked' : '' }} disabled>
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-leave_type_mandatory" style="top:288px; left:40px; width:113px; height:20px;">
            <input type="checkbox" id="leave_type_mandatory" {{ in_array('Mandatory/Forced Leave', $leaveTypesArr) ? 'checked' : '' }} disabled>
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-leave_type_sick" style="top:310px; left:40px; width:81px; height:20px;">
            <input type="checkbox" id="leave_type_sick" {{ in_array('Sick Leave', $leaveTypesArr) ? 'checked' : '' }} disabled>
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-leave_type_maternity" style="top:332px; left:40px; width:98px; height:20px;">
            <input type="checkbox" id="leave_type_maternity" {{ in_array('Maternity Leave', $leaveTypesArr) ? 'checked' : '' }} disabled>
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-leave_type_paternity" style="top:353px; left:40px; width:94px; height:20px;">
            <input type="checkbox" id="leave_type_paternity" {{ in_array('Paternity Leave', $leaveTypesArr) ? 'checked' : '' }} disabled>
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-leave_type_special_privilege" style="top:375px; left:40px; width:150px; height:20px;">
            <input type="checkbox" id="leave_type_special_privilege" {{ in_array('Special Privilege Leave', $leaveTypesArr) ? 'checked' : '' }} disabled>
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-leave_type_solo_parent" style="top:398px; left:40px; width:120px; height:20px;">
            <input type="checkbox" id="leave_type_solo_parent" {{ in_array('Solo Parent Leave', $leaveTypesArr) ? 'checked' : '' }} disabled>
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-leave_type_study" style="top:420px; left:40px; width:80px; height:20px;">
            <input type="checkbox" id="leave_type_study" {{ in_array('Study Leave', $leaveTypesArr) ? 'checked' : '' }} disabled>
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-leave_type_vawc" style="top:442px; left:40px; width:102px; height:20px;">
            <input type="checkbox" id="leave_type_vawc" {{ in_array('10-Day VAWC Leave', $leaveTypesArr) ? 'checked' : '' }} disabled>
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-leave_type_rehabilitation" style="top:465px; left:40px; width:128px; height:20px;">
            <input type="checkbox" id="leave_type_rehabilitation" {{ in_array('Rehabilitation Privilege', $leaveTypesArr) ? 'checked' : '' }} disabled>
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-leave_type_calamity" style="top:508px; left:40px; width:100px; height:20px;">
            <input type="checkbox" id="leave_type_calamity" {{ in_array('Special Emergency (Calamity) Leave', $leaveTypesArr) ? 'checked' : '' }} disabled>
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-leave_type_adoption" style="top:530px; left:40px; width:106px; height:20px;">
            <input type="checkbox" id="leave_type_adoption" {{ in_array('Adoption Leave', $leaveTypesArr) ? 'checked' : '' }} disabled>
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-leave_type_other" style="top:598px; left:54px; width:245px; height:21px;">
            {{ $leave->leave_type_other ?? '' }}
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-within_ph" style="top:289px; left:437px; width:109px; height:22px;">
            <input type="checkbox" id="within_ph" {{ $leave->within_ph == 'Yes' ? 'checked' : '' }} disabled>
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-within_ph_details" style="top:289px; left:580px; width:180px;">
            {{ $leave->within_ph_details ?? '' }}
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-abroad" style="top:310px; left:437px; width:117px; height:20px;">
            <input type="checkbox" id="abroad" {{ $leave->abroad == 'Yes' ? 'checked' : '' }} disabled>
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-abroad_details" style="top:310px; left:555px; width:194px; height:20px;">
            {{ $leave->abroad_details ?? '' }}
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-in_hospital" style="top:353px; left:437px; width:113px; height:20px;">
            <input type="checkbox" id="in_hospital" {{ $leave->in_hospital == 'Yes' ? 'checked' : '' }} disabled>
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-in_hospital_details" style="top:355px; left:607px; width:146px; height:20px;">
            {{ $leave->in_hospital_details ?? '' }}
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-out_patient" style="top:375px; left:437px; width:111px; height:22px;">
            <input type="checkbox" id="out_patient" {{ $leave->out_patient == 'Yes' ? 'checked' : '' }} disabled>
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-out_patient_details" style="top:396px; left:452px; width:289px; height:23px;">
            {{ $leave->out_patient_details ?? '' }}
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-special_leave_benefits" style="top:487px; left:40px; width:207px; height:20px;">
            <input type="checkbox" id="special_leave_benefits" {{ $leave->special_leave == 'Yes' ? 'checked' : '' }} disabled>
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-special_leave_details" style="top:464px; left:449px; width:292px; height:20px;">
            {{ $leave->special_leave_details ?? '' }}
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-completion_masters" style="top:508px; left:437px; width:162px; height:20px;">
            <input type="checkbox" id="completion_masters" {{ $leave->completion_masters == 'Yes' ? 'checked' : '' }} disabled>
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-bar_exam" style="top:532px; left:438px; width:114px; height:20px;">
            <input type="checkbox" id="bar_exam" {{ $leave->bar_exam == 'Yes' ? 'checked' : '' }} disabled>
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-monetization" style="top:576px; left:437px; width:147px; height:20px;">
            <input type="checkbox" id="monetization" {{ $leave->monetization == 'Yes' ? 'checked' : '' }} disabled>
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-terminal_leave" style="top:598px; left:438px; width:155px; height:20px;">
            <input type="checkbox" id="terminal_leave" {{ $leave->terminal_leave == 'Yes' ? 'checked' : '' }} disabled>
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-num_days" style="top:646px; left:67px; width:259px; height:20px;">
            {{ $leave->num_days ?? '' }}
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-inclusive_dates" style="top:692px; left:66px; width:258px; height:20px;">
            {{ $leave->inclusive_dates ?? '' }}
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-commutation_not_requested" style="top:647px; left:437px; width:142px; height:20px;">
            <input type="checkbox" id="commutation_not_requested" {{ $leave->commutation == 'Not Requested' ? 'checked' : '' }} disabled>
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-commutation_requested" style="top:670px; left:438px; width:111px; height:30px;">
            <input type="checkbox" id="commutation_requested" {{ $leave->commutation == 'Requested' ? 'checked' : '' }} disabled>
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-cert_as_of_date" style="top:774px; left:167px; width:152px; height:20px;">
            {{ $certData['as_of_date'] ?? $certDate ?? '' }}
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-cert_vl_earned" style="top:814px; left:184px; width:113px; height:20px;">
            {{ $certData['vl_earned'] ?? '' }}
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-cert_vl_less" style="top:829px; left:182px; width:115px; height:20px;">
            {{ $certData['vl_less'] ?? '' }}
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-cert_vl_balance" style="top:845px; left:181px; width:114px; height:20px;">
            {{ $certData['vl_balance'] ?? '' }}
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-cert_sl_earned" style="top:813px; left:296px; width:109px; height:21px;">
            {{ $certData['sl_earned'] ?? '' }}
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-cert_sl_less" style="top:831px; left:295px; width:111px; height:20px;">
            {{ $certData['sl_less'] ?? '' }}
            <div class="resize-handle"></div>
        </div>
        <div class="draggable" id="field-cert_sl_balance" style="top:846px; left:294px; width:113px; height:20px;">
            {{ $certData['sl_balance'] ?? '' }}
            <div class="resize-handle"></div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.getElementById('downloadPdfBtn').addEventListener('click', function() {
            const element = document.getElementById('printArea');
            html2pdf().set({
                margin: 0,
                filename: 'leave-application.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'pt', format: 'a4', orientation: 'portrait' }
            }).from(element).save();
        });

        // Drag-and-resize logic for all .draggable fields
        document.querySelectorAll('.draggable').forEach(function(el) {
            let offsetX, offsetY, startX, startY, dragging = false, resizing = false, startW, startH;
            const handle = el.querySelector('.resize-handle');
            // Drag
            el.addEventListener('mousedown', function(e) {
                if (e.target === handle) return; // Don't drag if resizing
                dragging = true;
                startX = e.clientX;
                startY = e.clientY;
                offsetX = parseInt(el.style.left) || 0;
                offsetY = parseInt(el.style.top) || 0;
                el.style.zIndex = 10;
                document.body.style.userSelect = 'none';
            });
            // Resize
            handle.addEventListener('mousedown', function(e) {
                e.stopPropagation();
                resizing = true;
                startX = e.clientX;
                startY = e.clientY;
                startW = el.offsetWidth;
                startH = el.offsetHeight;
                el.style.zIndex = 11;
                document.body.style.userSelect = 'none';
            });
            document.addEventListener('mousemove', function(e) {
                if (dragging) {
                    let dx = e.clientX - startX;
                    let dy = e.clientY - startY;
                    let newLeft = offsetX + dx;
                    let newTop = offsetY + dy;
                    // Boundaries
                    const container = document.getElementById('printArea');
                    newLeft = Math.max(0, Math.min(newLeft, container.offsetWidth - el.offsetWidth));
                    newTop = Math.max(0, Math.min(newTop, container.offsetHeight - el.offsetHeight));
                    el.style.left = newLeft + 'px';
                    el.style.top = newTop + 'px';
                } else if (resizing) {
                    let dx = e.clientX - startX;
                    let dy = e.clientY - startY;
                    let newW = Math.max(40, startW + dx);
                    let newH = Math.max(20, startH + dy);
                    el.style.width = newW + 'px';
                    el.style.height = newH + 'px';
                }
            });
            document.addEventListener('mouseup', function(e) {
                if (dragging) {
                    dragging = false;
                    el.style.zIndex = 2;
                    document.body.style.userSelect = '';
                    // Log the CSS for this field
                    console.log(`#${el.id} { top: ${el.style.top}; left: ${el.style.left}; width: ${el.style.width}; height: ${el.style.height}; }`);
                }
                if (resizing) {
                    resizing = false;
                    el.style.zIndex = 2;
                    document.body.style.userSelect = '';
                    // Log the CSS for this field
                    console.log(`#${el.id} { top: ${el.style.top}; left: ${el.style.left}; width: ${el.style.width}; height: ${el.style.height}; }`);
                }
            });
        });

        // Save Layout button
        document.getElementById('saveLayoutBtn').addEventListener('click', function() {
            const layout = {};
            document.querySelectorAll('.draggable').forEach(function(el) {
                layout[el.id] = {
                    top: el.style.top,
                    left: el.style.left,
                    width: el.style.width,
                    height: el.style.height
                };
            });
            console.log('Layout:', JSON.stringify(layout, null, 2));
            alert('Layout JSON has been logged to the console!');
        });
    </script>
</body>
</html>