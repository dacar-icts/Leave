<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request Preview - HR</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('css/leave_application_form.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .readonly-field {
            background-color: #f8f9fa;
            color: #495057;
            cursor: not-allowed;
        }
        
        .certification-section {
            background: #f8f9fa;
            border: 2px solid #007bff;
            border-radius: 8px;
            padding: 20px;
            margin-top: 30px;
        }
        
        .certification-title {
            font-size: 1.2em;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .certification-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .certification-form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
        
        .form-section-title {
            font-weight: bold;
            margin-bottom: 15px;
            color: #495057;
        }
        
        .credits-table {
            margin-top: 15px;
        }
        
        .credits-table table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .credits-table th,
        .credits-table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: center;
        }
        
        .credits-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        .label-cell {
            text-align: left;
            font-weight: bold;
        }
        

        
        .signatory-section {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
        }
        
        .signatory-info {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }
        
        .btn-certify {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }
        
        .btn-reject {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }
        
        .btn-back {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .rejection-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .rejection-modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 500px;
        }
        
        .rejection-modal textarea {
            width: 100%;
            height: 100px;
            margin: 10px 0;
            padding: 8px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        
        .modal-buttons {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="header">
            <div class="header-title">
                Leave Request Preview - HR
                <div class="status-indicator" style="font-size: 0.8em; margin-top: 5px; padding: 4px 12px; border-radius: 20px; display: inline-block; 
                    background-color: {{ $leaveRequest->status === 'Pending' ? '#ffc107' : ($leaveRequest->status === 'Certified' ? '#28a745' : '#dc3545') }};
                    color: {{ $leaveRequest->status === 'Pending' ? '#000' : '#fff' }};">
                    {{ $leaveRequest->status === 'Certified' ? 'HR CERTIFIED' : strtoupper($leaveRequest->status) }}
                </div>
            </div>
            <a href="{{ route('hr.dashboard') }}" class="btn btn-secondary">
                <span class="material-icons">arrow_back</span>
                Back to HR Dashboard
            </a>
        </div>

        <div class="dashboard-body">
            @if(session('error'))
                <div class="alert alert-error">
                    <span class="material-icons">error</span>
                    {{ session('error') }}
                </div>
            @endif
            
            @if(session('success'))
                <div class="alert alert-success">
                    <span class="material-icons">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="form-container">
                <div class="official-form">
                    <!-- Form Header -->
                    <div class="form-header">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e9/Department_of_Agriculture_of_the_Philippines.svg" alt="Department of Agriculture Logo" class="logo">
                        <div class="header-text">
                            <h1>Republic of the Philippines</h1>
                            <h2>DEPARTMENT OF AGRICULTURE</h2>
                            <h3>Cordillera Administrative Region</h3>
                            <h3>BPI Compound, Easter Road, Guisad, Baguio City</h3>
                        </div>
                        <div class="stamp-box">
                            Stamp of Date of Receipt
                        </div>
                    </div>
                    
                    <!-- Form Title -->
                    <div class="form-title">APPLICATION FOR LEAVE</div>
                    
                    <!-- Form Content - Read Only -->
                    <div class="form-row">
                        <div class="form-cell form-cell-half">
                            <div class="form-label">1. OFFICE/DEPARTMENT</div>
                            <input type="text" class="form-input readonly-field" value="{{ $leaveRequest->office ?? ($leaveRequest->user->offices ?? 'Department of Agriculture') }}" readonly>
                        </div>
                        <div class="form-cell form-cell-half">
                            <div class="form-label">2. NAME : (Last) (First) (Middle)</div>
                            <input type="text" class="form-input readonly-field" value="{{ $leaveRequest->user->name }}" readonly>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-cell form-cell-third">
                            <div class="form-label">3. DATE OF FILING</div>
                            <input type="text" class="form-input readonly-field" value="{{ $leaveRequest->filing_date ?? $leaveRequest->created_at->format('m/d/Y') }}" readonly>
                        </div>
                        <div class="form-cell form-cell-third">
                            <div class="form-label">4. POSITION</div>
                            <input type="text" class="form-input readonly-field" value="{{ $leaveRequest->position ?? ($leaveRequest->user->position ?? 'Employee') }}" readonly>
                        </div>
                        <div class="form-cell form-cell-third">
                            <div class="form-label">5. SALARY</div>
                            <input type="text" class="form-input readonly-field" value="{{ $leaveRequest->salary ?? '' }}" readonly>
                        </div>
                    </div>
                    
                    <div class="form-section-title">6. DETAILS OF APPLICATION</div>
                    
                    <div class="form-row">
                        <div class="form-cell form-cell-half">
                            <div class="form-label">6.A TYPE OF LEAVE TO BE AVAILED OF</div>
                            @php
                                $standardTypes = [
                                    'Vacation Leave', 'Mandatory/Forced Leave', 'Sick Leave', 'Maternity Leave', 'Paternity Leave',
                                    'Special Privilege Leave', 'Solo Parent Leave', 'Study Leave', '10-Day VAWC Leave',
                                    'Rehabilitation Privilege', 'Special Leave Benefits for Women', 'Special Emergency (Calamity) Leave', 'Adoption Leave'
                                ];
                                $leaveTypeArray = is_string($leaveRequest->leave_type) && $leaveRequest->leave_type[0] === '['
                                    ? json_decode($leaveRequest->leave_type, true)
                                    : (is_array($leaveRequest->leave_type) ? $leaveRequest->leave_type : [$leaveRequest->leave_type]);
                            @endphp
                            @foreach($standardTypes as $type)
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" {{ in_array($type, $leaveTypeArray) ? 'checked' : '' }} disabled>
                                        {{ $type }}
                                    </label>
                                </div>
                            @endforeach
                            @foreach($leaveTypeArray as $type)
                                @if(!in_array($type, $standardTypes))
                                    <div class="form-group">
                                        <div class="form-label">Others:</div>
                                        <input type="text" class="form-input readonly-field" value="{{ $type }}" readonly>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="form-cell form-cell-half">
                            <div class="form-label">6.B DETAILS OF LEAVE</div>
                            
                            <div class="form-group">
                                <div class="form-label">In case of Vacation/Special Privilege Leave:</div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" {{ $leaveRequest->within_ph === 'Yes' ? 'checked' : '' }} disabled>
                                        Within the Philippines
                                    </label>
                                    @if($leaveRequest->within_ph_details)
                                        <input type="text" class="form-input readonly-field" value="{{ $leaveRequest->within_ph_details }}" readonly>
                                    @endif
                                </div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" {{ $leaveRequest->abroad === 'Yes' ? 'checked' : '' }} disabled>
                                        Abroad (Specify)
                                    </label>
                                    @if($leaveRequest->abroad_details)
                                        <input type="text" class="form-input readonly-field" value="{{ $leaveRequest->abroad_details }}" readonly>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="form-label">In case of Sick Leave:</div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" {{ $leaveRequest->in_hospital === 'Yes' ? 'checked' : '' }} disabled>
                                        In Hospital (Specify illness)
                                    </label>
                                    @if($leaveRequest->in_hospital_details)
                                        <input type="text" class="form-input readonly-field" value="{{ $leaveRequest->in_hospital_details }}" readonly>
                                    @endif
                                </div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" {{ $leaveRequest->out_patient === 'Yes' ? 'checked' : '' }} disabled>
                                        Out Patient (Specify illness)
                                    </label>
                                    @if($leaveRequest->out_patient_details)
                                        <input type="text" class="form-input readonly-field" value="{{ $leaveRequest->out_patient_details }}" readonly>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="form-label">In case of Special Leave Benefits for Women:</div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" {{ $leaveRequest->special_leave === 'Yes' ? 'checked' : '' }} disabled>
                                        (Specify illness)
                                    </label>
                                    @if($leaveRequest->special_leave_details)
                                        <input type="text" class="form-input readonly-field" value="{{ $leaveRequest->special_leave_details }}" readonly>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="form-label">In case of Study Leave:</div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" {{ $leaveRequest->completion_masters === 'Yes' ? 'checked' : '' }} disabled>
                                        Completion of Master's Degree
                                    </label>
                                </div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" {{ $leaveRequest->bar_exam === 'Yes' ? 'checked' : '' }} disabled>
                                        BAR/Board Examination Review
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="form-label">Other purpose:</div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" {{ $leaveRequest->monetization === 'Yes' ? 'checked' : '' }} disabled>
                                        Monetization of Leave Credits
                                    </label>
                                </div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" {{ $leaveRequest->terminal_leave === 'Yes' ? 'checked' : '' }} disabled>
                                        Terminal Leave
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-cell form-cell-half">
                            <div class="form-label">6.C NUMBER OF WORKING DAYS APPLIED FOR</div>
                            <input type="text" class="form-input readonly-field" value="{{ $leaveRequest->num_days ?? '' }}" readonly>
                            
                            <div class="form-label" style="margin-top: 15px;">INCLUSIVE DATES</div>
                            <div class="readonly-field" style="padding: 8px; border-radius: 4px; border: 1px solid #ced4da; background: #f8f9fa;">
                                @php
                                    $displayed = false;
                                    $raw = $leaveRequest->inclusive_dates ?? '';
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
                                                    echo $range;
                                                }
                                            } else {
                                                // Format single date as 'M j, Y'
                                                try {
                                                    $single = \Carbon\Carbon::parse($range);
                                                    echo $single->format('M j, Y');
                                                } catch (Exception $e) {
                                                    echo $range;
                                                }
                                            }
                                            if ($idx !== count($ranges) - 1) echo ', ';
                                            $displayed = true;
                                        }
                                    }
                                    if (!$displayed) {
                                        echo $raw;
                                    }
                                @endphp
                            </div>
                        </div>
                        <div class="form-cell form-cell-half">
                            <div class="form-label">6.D COMMUTATION</div>
                            <div class="checkbox-container">
                                <label class="checkbox-label">
                                    <input type="radio" {{ $leaveRequest->commutation === 'Not Requested' ? 'checked' : '' }} disabled>
                                    Not Requested
                                </label>
                            </div>
                            <div class="checkbox-container">
                                <label class="checkbox-label">
                                    <input type="radio" {{ $leaveRequest->commutation === 'Requested' ? 'checked' : '' }} disabled>
                                    Requested
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    @if($leaveRequest->admin_signatory)
                        <div class="form-row">
                            <div class="form-cell form-cell-full">
                                <div class="form-label">Division Chief (2nd Signatory)</div>
                                @php
                                    $adminParts = explode('|', $leaveRequest->admin_signatory);
                                    $adminName = $adminParts[0] ?? '';
                                    $adminPosition = $adminParts[1] ?? '';
                                @endphp
                                <input type="text" class="form-input readonly-field" value="{{ $adminName }}" readonly>
                                <div class="small-text">{{ $adminPosition }}</div>
                            </div>
                        </div>
                    @endif
                </div>
                
                @if($leaveRequest->status === 'Rejected' && isset($certData['rejection_comment']))
                    <div class="alert alert-error" style="margin: 20px 0;">
                        <span class="material-icons">block</span>
                        <strong>Rejected by HR</strong><br>
                        <strong>Reason:</strong> {{ $certData['rejection_comment'] }}<br>
                        <small>{{ $certData['rejected_by'] ?? '' }} {{ $certData['rejected_at'] ? 'on ' . \Carbon\Carbon::parse($certData['rejected_at'])->format('M d, Y g:i A') : '' }}</small>
                    </div>
                @endif
                
                <!-- Certification Section -->
                <div class="certification-section">
                    <div class="certification-title">7. DETAILS OF ACTION ON APPLICATION</div>
                    
                                            <form id="certificationForm" class="certification-form">
                            @csrf
                            <input type="hidden" name="leave_id" value="{{ $leaveRequest->id }}">
                            <input type="hidden" name="admin_signatory" value="AIDA Y. PAGTAN|Chief, Administrative and Finance Division">
                            <input type="hidden" name="director_signatory" value="Atty. JENNILYN M. DAWAYAN, CESO IV|Regional Executive Director">
                        
                        <div class="certification-grid">
                            <!-- Leave Credits Section -->
                            <div class="certification-form">
                                <div class="form-section-title">7.A CERTIFICATION OF LEAVE CREDITS</div>
                                
                                <div class="form-group">
                                    <label>As of:</label>
                                    @php
                                        $certData = [];
                                        if (isset($leaveRequest->certification_data)) {
                                            try {
                                                $certData = is_string($leaveRequest->certification_data) 
                                                    ? json_decode($leaveRequest->certification_data, true) 
                                                    : $leaveRequest->certification_data;
                                            } catch (\Exception $e) {
                                                $certData = [];
                                            }
                                        }
                                    @endphp
                                    <input type="date" name="as_of_date" class="form-input" value="{{ $certData['as_of_date'] ?? '' }}" {{ $leaveRequest->status !== 'Pending' ? 'readonly' : 'required' }} id="asOfDateInput">
                                </div>
                                
                                <div class="credits-table">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Vacation Leave</th>
                                                <th>Sick Leave</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="label-cell">Total Earned</td>
                                                <td><input type="text" name="vl_earned" class="form-input" value="{{ $certData['vl_earned'] ?? '' }}" placeholder="0" {{ $leaveRequest->status !== 'Pending' ? 'readonly' : '' }}></td>
                                                <td><input type="text" name="sl_earned" class="form-input" value="{{ $certData['sl_earned'] ?? '' }}" placeholder="0" {{ $leaveRequest->status !== 'Pending' ? 'readonly' : '' }}></td>
                                                <td>
                                                    @if($leaveRequest->status === 'Pending')
                                                   
                                                    <button type="button" class="btn-not-deducted" onclick="setCreditsRow('earned', 'Not Deducted')">Not Deducted</button>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-cell">Less this application</td>
                                                <td><input type="text" name="vl_less" class="form-input" value="{{ $certData['vl_less'] ?? '' }}" placeholder="0" {{ $leaveRequest->status !== 'Pending' ? 'readonly' : '' }}></td>
                                                <td><input type="text" name="sl_less" class="form-input" value="{{ $certData['sl_less'] ?? '' }}" placeholder="0" {{ $leaveRequest->status !== 'Pending' ? 'readonly' : '' }}></td>
                                                <td>
                                                    @if($leaveRequest->status === 'Pending')
                                                   
                                                    <button type="button" class="btn-not-deducted" onclick="setCreditsRow('less', 'Not Deducted')">Not Deducted</button>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-cell">Balance</td>
                                                <td><input type="text" name="vl_balance" class="form-input" value="{{ $certData['vl_balance'] ?? '' }}" placeholder="0" {{ $leaveRequest->status !== 'Pending' ? 'readonly' : '' }}></td>
                                                <td><input type="text" name="sl_balance" class="form-input" value="{{ $certData['sl_balance'] ?? '' }}" placeholder="0" {{ $leaveRequest->status !== 'Pending' ? 'readonly' : '' }}></td>
                                                <td>
                                                    @if($leaveRequest->status === 'Pending')
                                                 
                                                    <button type="button" class="btn-not-deducted" onclick="setCreditsRow('balance', 'Not Deducted')">Not Deducted</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                @if($leaveRequest->status === 'Pending')
                                <div class="form-group" style="margin-top:10px;">
                                    <label>
                                        <input type="checkbox" id="isLwop"> Tag as LWOP (Leave Without Pay)
                                    </label>
                                </div>
                                @endif
                                
                                <div class="signatory-section">
                                    <div class="signatory-info">
                                        <strong>HR Signatory:</strong> JOY ROSE C. BAWAYAN<br>
                                        <em>Administrative Officer V (HRMO III)</em>
                                        <input type="hidden" name="hr_signatory" value="JOY ROSE C. BAWAYAN|Administrative Officer V (HRMO III)">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Approval Section 7.C -->
                            <div class="certification-form" style="margin-top: 20px;">
                                <div class="form-section-title">7.C APPROVED FOR:</div>
                                <input type="number" name="approved_with_pay" class="form-input" style="min-width: 30px; display: inline-block; border-bottom: 1px solid #000; text-align: center;" value="{{ $certData['approved_with_pay'] ?? '' }}" {{ $leaveRequest->status !== 'Pending' ? 'readonly' : '' }}> days with pay<br>
                                <input type="number" name="approved_without_pay" class="form-input" style="min-width: 30px; display: inline-block; border-bottom: 1px solid #000; text-align: center;" value="{{ $certData['approved_without_pay'] ?? '' }}" {{ $leaveRequest->status !== 'Pending' ? 'readonly' : '' }}> days without pay<br>
                                <input type="text" name="approved_others" class="form-input" style="min-width: 30px; display: inline-block; border-bottom: 1px solid #000; text-align: center;" value="{{ $certData['approved_others'] ?? '' }}" {{ $leaveRequest->status !== 'Pending' ? 'readonly' : '' }}> others (Specify)<br>
                                <span style="min-width: 200px; display: inline-block; border-bottom: 1px solid #000;"></span>
                            </div>
                        </div>
                        
                        <div class="action-buttons">
                            @if($leaveRequest->status === 'Pending')
                                <button type="button" class="btn-reject" onclick="showRejectionModal()">
                                    <span class="material-icons">block</span>
                                    Reject
                                </button>
                                <button type="submit" class="btn-certify">
                                    <span class="material-icons">verified</span>
                                    Certify Leave Request
                                </button>
                            @else
                                <a href="{{ route('leave.print', $leaveRequest->id) }}" class="btn-certify" target="_blank" style="text-decoration: none; display: inline-block;">
                                    <span class="material-icons">print</span>
                                    Print Form
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Rejection Modal -->
    <div id="rejectionModal" class="rejection-modal">
        <div class="rejection-modal-content">
            <h3>Reject Leave Request</h3>
            <p>Please provide a reason for rejection:</p>
            <textarea id="rejectionComment" placeholder="Enter rejection reason..."></textarea>
            <div class="modal-buttons">
                <button type="button" onclick="closeRejectionModal()" class="btn-back">Cancel</button>
                <button type="button" onclick="submitRejection()" class="btn-reject">Reject</button>
            </div>
        </div>
    </div>
    
    <script>
        // Handle certification form submission
        document.getElementById('certificationForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Check if leave request is already processed
            const leaveStatus = '{{ $leaveRequest->status }}';
            if (leaveStatus !== 'Pending') {
                alert('This leave request has already been processed and cannot be modified.');
                return;
            }
            
            const formData = new FormData(this);
            formData.append('action', 'certify');
            
            // Validate required fields
            let hasEmpty = false;
            ['vl_earned','sl_earned','vl_less','sl_less','vl_balance','sl_balance'].forEach(name => {
                if (!formData.get(name)) hasEmpty = true;
            });

            if (hasEmpty) {
                const proceed = confirm('Some fields are empty. Do you want to proceed and save anyway?');
                if (!proceed) return;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="material-icons">hourglass_top</span> Processing...';
            
            try {
                const response = await fetch('{{ route('hr.certify-leave') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                if (response.ok) {
                    const data = await response.json();
                    
                    // Show success message
                    const successMessage = document.createElement('div');
                    successMessage.className = 'alert alert-success';
                    successMessage.style.position = 'fixed';
                    successMessage.style.top = '20px';
                    successMessage.style.right = '20px';
                    successMessage.style.padding = '15px 20px';
                    successMessage.style.borderRadius = '8px';
                    successMessage.style.backgroundColor = '#d4edda';
                    successMessage.style.color = '#155724';
                    successMessage.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
                    successMessage.style.zIndex = '9999';
                    successMessage.innerHTML = '<span class="material-icons" style="margin-right:8px;">check_circle</span> Leave request certified successfully!';
                    document.body.appendChild(successMessage);
                    
                    // Redirect to dashboard after a short delay
                    setTimeout(() => {
                        window.location.href = '{{ route('hr.dashboard') }}';
                    }, 1500);
                } else {
                    throw new Error('Network response was not ok');
                }
            } catch (error) {
                console.error('Error:', error);
                
                // Show error message
                const errorMessage = document.createElement('div');
                errorMessage.className = 'alert alert-error';
                errorMessage.style.position = 'fixed';
                errorMessage.style.top = '20px';
                errorMessage.style.right = '20px';
                errorMessage.style.padding = '15px 20px';
                errorMessage.style.borderRadius = '8px';
                errorMessage.style.backgroundColor = '#f8d7da';
                errorMessage.style.color = '#721c24';
                errorMessage.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
                errorMessage.style.zIndex = '9999';
                errorMessage.innerHTML = '<span class="material-icons" style="margin-right:8px;">error</span> Something went wrong. Please try again.';
                document.body.appendChild(errorMessage);
                
                // Remove error message after 3 seconds
                setTimeout(() => {
                    errorMessage.remove();
                }, 3000);
            } finally {
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        });
        
        function showRejectionModal() {
            document.getElementById('rejectionModal').style.display = 'block';
        }
        
        function closeRejectionModal() {
            document.getElementById('rejectionModal').style.display = 'none';
            document.getElementById('rejectionComment').value = '';
        }
        
        async function submitRejection() {
            // Check if leave request is already processed
            const leaveStatus = '{{ $leaveRequest->status }}';
            if (leaveStatus !== 'Pending') {
                alert('This leave request has already been processed and cannot be modified.');
                return;
            }
            
            const rejectionComment = document.getElementById('rejectionComment').value.trim();
            
            if (!rejectionComment) {
                alert('Please provide a reason for rejection.');
                return;
            }
            
            const formData = new FormData();
            formData.append('leave_id', '{{ $leaveRequest->id }}');
            formData.append('action', 'reject');
            formData.append('rejection_comment', rejectionComment);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            
            try {
                const response = await fetch('{{ route('hr.certify-leave') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                if (response.ok) {
                    const data = await response.json();
                    
                    // Show success message
                    const successMessage = document.createElement('div');
                    successMessage.className = 'alert alert-success';
                    successMessage.style.position = 'fixed';
                    successMessage.style.top = '20px';
                    successMessage.style.right = '20px';
                    successMessage.style.padding = '15px 20px';
                    successMessage.style.borderRadius = '8px';
                    successMessage.style.backgroundColor = '#d4edda';
                    successMessage.style.color = '#155724';
                    successMessage.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
                    successMessage.style.zIndex = '9999';
                    successMessage.innerHTML = '<span class="material-icons" style="margin-right:8px;">check_circle</span> Leave request rejected successfully!';
                    document.body.appendChild(successMessage);
                    
                    closeRejectionModal();
                    
                    // Redirect to dashboard after a short delay
                    setTimeout(() => {
                        window.location.href = '{{ route('hr.dashboard') }}';
                    }, 1500);
                } else {
                    throw new Error('Network response was not ok');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Something went wrong. Please try again.');
            }
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('rejectionModal');
            if (event.target === modal) {
                closeRejectionModal();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Autofill as-of-date with current date if empty and pending
            var asOfDateInput = document.getElementById('asOfDateInput');
            if (asOfDateInput && asOfDateInput.value === '' && '{{ $leaveRequest->status }}' === 'Pending') {
                var today = new Date();
                var yyyy = today.getFullYear();
                var mm = String(today.getMonth() + 1).padStart(2, '0');
                var dd = String(today.getDate()).padStart(2, '0');
                asOfDateInput.value = yyyy + '-' + mm + '-' + dd;
            }

            // Exception for Vacation Leave and Sick Leave
            try {
                var leaveTypes = @json(is_string($leaveRequest->leave_type) && $leaveRequest->leave_type && $leaveRequest->leave_type[0] === '[' ? json_decode($leaveRequest->leave_type, true) : (is_array($leaveRequest->leave_type) ? $leaveRequest->leave_type : [$leaveRequest->leave_type]));
                var hasVLorSL = Array.isArray(leaveTypes) && (leaveTypes.includes('Vacation Leave') || leaveTypes.includes('Sick Leave'));
                var isPending = '{{ $leaveRequest->status }}' === 'Pending';
                var lwopCheckbox = document.getElementById('isLwop');
                var approvedWithPay = document.querySelector('input[name="approved_with_pay"]');
                var approvedWithoutPay = document.querySelector('input[name="approved_without_pay"]');
                var approvedOthers = document.querySelector('input[name="approved_others"]');
                var numDays = {{ (int)($leaveRequest->num_days ?? 0) }};
                
                function applyVlSlException() {
                    if (!hasVLorSL || !isPending) return;
                    // Clear all 7.C prefilled values initially
                    if (approvedWithPay) approvedWithPay.value = '';
                    if (approvedWithoutPay && (!lwopCheckbox || !lwopCheckbox.checked)) approvedWithoutPay.value = '';
                    if (approvedOthers) approvedOthers.value = '';
                    // If LWOP checked, set approved_without_pay = numDays
                    if (lwopCheckbox && lwopCheckbox.checked && approvedWithoutPay) {
                        approvedWithoutPay.value = numDays > 0 ? String(numDays) : '';
                    }
                }
                applyVlSlException();
                if (lwopCheckbox) {
                    lwopCheckbox.addEventListener('change', function() {
                        applyVlSlException();
                    });
                }
            } catch (e) {}
        });
        function setCreditsRow(row, value) {
            if (row === 'earned') {
                document.querySelector('input[name="vl_earned"]').value = value;
                document.querySelector('input[name="sl_earned"]').value = value;
            } else if (row === 'less') {
                document.querySelector('input[name="vl_less"]').value = value;
                document.querySelector('input[name="sl_less"]').value = value;
            } else if (row === 'balance') {
                document.querySelector('input[name="vl_balance"]').value = value;
                document.querySelector('input[name="sl_balance"]').value = value;
            }
        }

        // Auto-fill leave credits based on leave type and working days
        document.addEventListener('DOMContentLoaded', function() {
            const leaveTypeArray = @json($leaveTypeArray);
            const numDays = {{ $leaveRequest->num_days ?? 0 }};
            
            // Check if Vacation Leave or Sick Leave is selected
            const hasVacationLeave = leaveTypeArray.includes('Vacation Leave');
            const hasSickLeave = leaveTypeArray.includes('Sick Leave');
            
            // Auto-fill "Less this application" based on leave type
            if (hasVacationLeave && numDays > 0) {
                document.querySelector('input[name="vl_less"]').value = numDays;
            }
            
            if (hasSickLeave && numDays > 0) {
                document.querySelector('input[name="sl_less"]').value = numDays;
            }
            
            // Auto-calculate balance when Total Earned values change
            const vlEarnedInput = document.querySelector('input[name="vl_earned"]');
            const slEarnedInput = document.querySelector('input[name="sl_earned"]');
            const vlLessInput = document.querySelector('input[name="vl_less"]');
            const slLessInput = document.querySelector('input[name="sl_less"]');
            const vlBalanceInput = document.querySelector('input[name="vl_balance"]');
            const slBalanceInput = document.querySelector('input[name="sl_balance"]');
            
            function calculateBalance() {
                // Calculate VL Balance
                const vlEarned = parseInt(vlEarnedInput.value) || 0;
                const vlLess = parseInt(vlLessInput.value) || 0;
                if (vlEarned > 0) {
                    vlBalanceInput.value = Math.max(0, vlEarned - vlLess);
                }
                
                // Calculate SL Balance
                const slEarned = parseInt(slEarnedInput.value) || 0;
                const slLess = parseInt(slLessInput.value) || 0;
                if (slEarned > 0) {
                    slBalanceInput.value = Math.max(0, slEarned - slLess);
                }
            }
            
            // Add event listeners for automatic calculation
            vlEarnedInput.addEventListener('input', calculateBalance);
            slEarnedInput.addEventListener('input', calculateBalance);
            vlLessInput.addEventListener('input', calculateBalance);
            slLessInput.addEventListener('input', calculateBalance);
            
            // Initial calculation
            calculateBalance();
        });
    </script>
</body>
</html>