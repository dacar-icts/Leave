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
            background-color: #f0f0f0;
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
        
        <div class="leave-form">
            <!-- Form Header -->
            <div class="form-header">
                <div style="text-align: right; font-style: italic; font-size: 9pt;">Civil Service Form No. 6<br>Revised 2020</div>
                <img src="https://upload.wikimedia.org/wikipedia/commons/e/e9/Department_of_Agriculture_of_the_Philippines.svg" alt="Department of Agriculture Logo">
                <div class="title">Republic of the Philippines</div>
                <div class="title">DEPARTMENT OF AGRICULTURE</div>
                <div class="title">Cordillera Administrative Region</div>
                <div>BPI Compound, Easter Road, Guisad, Baguio City</div>
                <div class="title" style="margin-top: 15px;">APPLICATION FOR LEAVE</div>
            </div>

            <!-- Basic Information -->
            <div class="form-row">
                <div class="form-col-half form-col-border-right">
                    <div class="label">1. OFFICE/DEPARTMENT</div>
                    <div>{{ $leave->office ?? 'Department of Agriculture' }}</div>
                </div>
                <div class="form-col-half">
                    <div class="label">2. NAME</div>
                    <div>{{ $leave->user->name ?? '' }}</div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-col-half form-col-border-right">
                    <div class="label">3. DATE OF FILING</div>
                    <div>{{ \Carbon\Carbon::parse($leave->created_at)->format('F j, Y') }}</div>
                </div>
                <div class="form-col-half">
                    <div class="label">4. POSITION</div>
                    <div>{{ $leave->position ?? $leave->user->position ?? 'Employee' }}</div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-col-full">
                    <div class="label">5. SALARY</div>
                    <div>{{ $leave->salary ?? '' }}</div>
                </div>
            </div>
            
            <!-- Application Details -->
            <div class="form-section-header">6. DETAILS OF APPLICATION</div>
            
            <div class="form-row">
                <div class="form-col-half form-col-border-right">
                    <div class="label">6.A TYPE OF LEAVE TO BE AVAILED OF</div>
                    
                    <div class="leave-types">
                        @php
                            $leaveTypeArray = is_string($leave->leave_type) && $leave->leave_type[0] === '[' 
                                ? json_decode($leave->leave_type) 
                                : [$leave->leave_type];
                            if (!is_array($leaveTypeArray)) {
                                $leaveTypeArray = [$leaveTypeArray];
                            }
                        @endphp
                        
                        <div class="leave-type-item">
                            <input type="checkbox" {{ in_array('Vacation Leave', $leaveTypeArray) ? 'checked' : '' }} disabled>
                            <label>Vacation Leave (Sec. 51, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</label>
                        </div>
                        <div class="leave-type-item">
                            <input type="checkbox" {{ in_array('Mandatory/Forced Leave', $leaveTypeArray) ? 'checked' : '' }} disabled>
                            <label>Mandatory/Forced Leave (Sec. 25, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</label>
                        </div>
                        <div class="leave-type-item">
                            <input type="checkbox" {{ in_array('Sick Leave', $leaveTypeArray) ? 'checked' : '' }} disabled>
                            <label>Sick Leave (Sec. 43, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</label>
                        </div>
                        <div class="leave-type-item">
                            <input type="checkbox" {{ in_array('Maternity Leave', $leaveTypeArray) ? 'checked' : '' }} disabled>
                            <label>Maternity Leave (R.A. No. 11210 / IRR issued by CSC, DOLE and SSS)</label>
                        </div>
                        <div class="leave-type-item">
                            <input type="checkbox" {{ in_array('Paternity Leave', $leaveTypeArray) ? 'checked' : '' }} disabled>
                            <label>Paternity Leave (R.A. No. 8187 / CSC MC No. 71, s. 1998, as amended)</label>
                        </div>
                        <div class="leave-type-item">
                            <input type="checkbox" {{ in_array('Special Privilege Leave', $leaveTypeArray) ? 'checked' : '' }} disabled>
                            <label>Special Privilege Leave (Sec. 21, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</label>
                        </div>
                        <div class="leave-type-item">
                            <input type="checkbox" {{ in_array('Solo Parent Leave', $leaveTypeArray) ? 'checked' : '' }} disabled>
                            <label>Solo Parent Leave (R.A. No. 8972 / CSC MC No. 8, s. 2004)</label>
                        </div>
                        <div class="leave-type-item">
                            <input type="checkbox" {{ in_array('Study Leave', $leaveTypeArray) ? 'checked' : '' }} disabled>
                            <label>Study Leave (Sec. 68, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</label>
                        </div>
                        <div class="leave-type-item">
                            <input type="checkbox" {{ in_array('10-Day VAWC Leave', $leaveTypeArray) ? 'checked' : '' }} disabled>
                            <label>10-Day VAWC Leave (R.A. No. 9262 / CSC MC No. 15, s. 2005)</label>
                        </div>
                        <div class="leave-type-item">
                            <input type="checkbox" {{ in_array('Rehabilitation Privilege', $leaveTypeArray) ? 'checked' : '' }} disabled>
                            <label>Rehabilitation Privilege (Sec. 55, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</label>
                        </div>
                        <div class="leave-type-item">
                            <input type="checkbox" {{ in_array('Special Leave Benefits for Women', $leaveTypeArray) ? 'checked' : '' }} disabled>
                            <label>Special Leave Benefits for Women (R.A. No. 9710 / CSC MC No. 25, s. 2010)</label>
                        </div>
                        <div class="leave-type-item">
                            <input type="checkbox" {{ in_array('Special Emergency (Calamity) Leave', $leaveTypeArray) ? 'checked' : '' }} disabled>
                            <label>Special Emergency (Calamity) Leave (CSC MC No. 2, s. 2012, as amended)</label>
                        </div>
                        <div class="leave-type-item">
                            <input type="checkbox" {{ in_array('Adoption Leave', $leaveTypeArray) ? 'checked' : '' }} disabled>
                            <label>Adoption Leave (R.A. No. 8552)</label>
                        </div>
                        
                        @if(isset($leave->leave_type_other) && $leave->leave_type_other)
                        <div class="leave-type-item">
                            <label><strong>Others:</strong> {{ $leave->leave_type_other }}</label>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="form-col-half">
                    <div class="label">6.B DETAILS OF LEAVE</div>
                    
                    <div class="leave-details">
                        <!-- Vacation/Special Privilege Leave -->
                        <div class="leave-details-section">
                            <div class="title">In case of Vacation/Special Privilege Leave:</div>
                            <div class="leave-details-item">
                                <input type="checkbox" {{ isset($leave->within_ph) && $leave->within_ph === 'Yes' ? 'checked' : '' }} disabled>
                                <label>Within the Philippines</label>
                            </div>
                            <div class="leave-details-item">
                                <input type="checkbox" {{ isset($leave->abroad) && $leave->abroad === 'Yes' ? 'checked' : '' }} disabled>
                                <label>Abroad (Specify): {{ $leave->abroad_details ?? '' }}</label>
                            </div>
                        </div>
                        
                        <!-- Sick Leave -->
                        <div class="leave-details-section">
                            <div class="title">In case of Sick Leave:</div>
                            <div class="leave-details-item">
                                <input type="checkbox" {{ isset($leave->in_hospital) && $leave->in_hospital === 'Yes' ? 'checked' : '' }} disabled>
                                <label>In Hospital (Specify Illness): {{ $leave->in_hospital_details ?? '' }}</label>
                            </div>
                            <div class="leave-details-item">
                                <input type="checkbox" {{ isset($leave->out_patient) && $leave->out_patient === 'Yes' ? 'checked' : '' }} disabled>
                                <label>Out Patient (Specify Illness): {{ $leave->out_patient_details ?? '' }}</label>
                            </div>
                        </div>
                        
                        <!-- Special Leave Benefits -->
                        <div class="leave-details-section">
                            <div class="title">In case of Special Leave Benefits for Women:</div>
                            <div class="leave-details-item">
                                <label>(Specify Illness): {{ $leave->special_leave_details ?? '' }}</label>
                            </div>
                        </div>
                        
                        <!-- Study Leave -->
                        <div class="leave-details-section">
                            <div class="title">In case of Study Leave:</div>
                            <div class="leave-details-item">
                                <input type="checkbox" {{ isset($leave->completion_masters) && $leave->completion_masters === 'Yes' ? 'checked' : '' }} disabled>
                                <label>Completion of Master's Degree</label>
                            </div>
                            <div class="leave-details-item">
                                <input type="checkbox" {{ isset($leave->bar_exam) && $leave->bar_exam === 'Yes' ? 'checked' : '' }} disabled>
                                <label>BAR/Board Examination Review</label>
                            </div>
                        </div>
                        
                        <!-- Other Purpose -->
                        <div class="leave-details-section">
                            <div class="title">Other purpose:</div>
                            <div class="leave-details-item">
                                <input type="checkbox" {{ isset($leave->monetization) && $leave->monetization === 'Yes' ? 'checked' : '' }} disabled>
                                <label>Monetization of Leave Credits</label>
                            </div>
                            <div class="leave-details-item">
                                <input type="checkbox" {{ isset($leave->terminal_leave) && $leave->terminal_leave === 'Yes' ? 'checked' : '' }} disabled>
                                <label>Terminal Leave</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-col-half form-col-border-right">
                    <div class="label">6.C NUMBER OF WORKING DAYS APPLIED FOR</div>
                    <div>{{ $leave->num_days ?? '' }}</div>
                </div>
                <div class="form-col-half">
                    <div class="label">6.D INCLUSIVE DATES</div>
                    <div>{{ $leave->inclusive_dates ?? '' }}</div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-col-full">
                    <div class="label">6.E COMMUTATION</div>
                    <div class="leave-details">
                        <div class="leave-details-item">
                            <input type="checkbox" {{ isset($leave->commutation) && $leave->commutation === 'Not Requested' ? 'checked' : '' }} disabled>
                            <label>Not Requested</label>
                        </div>
                        <div class="leave-details-item">
                            <input type="checkbox" {{ isset($leave->commutation) && $leave->commutation === 'Requested' ? 'checked' : '' }} disabled>
                            <label>Requested</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Signature -->
            <div class="form-signature">
                <div class="signature-box">
                    <div class="signature-line">{{ $leave->user->name ?? '' }}</div>
                    <div class="signature-label">(Signature of Applicant)</div>
                </div>
            </div>
            
            @if($leave->status === 'Certified')
            <!-- Certification Section -->
            <div class="certification-section">
                <div class="certification-title">7. DETAILS OF ACTION ON APPLICATION</div>
                
                <div class="form-row">
                    <div class="form-col-half form-col-border-right">
                        <div class="label">7.A CERTIFICATION OF LEAVE CREDITS</div>
                        
                        @php
                            $certData = [];
                            if (isset($leave->certification_data)) {
                                try {
                                    $certData = is_string($leave->certification_data) 
                                        ? json_decode($leave->certification_data, true) 
                                        : $leave->certification_data;
                                } catch (\Exception $e) {
                                    $certData = [];
                                }
                            }
                        @endphp
                        
                        <div style="padding: 5px;">
                            <div>As of: {{ \Carbon\Carbon::parse($certData['as_of_date'] ?? now())->format('F j, Y') }}</div>
                            
                            <table class="certification-table">
                                <tr>
                                    <th></th>
                                    <th>Vacation Leave</th>
                                    <th>Sick Leave</th>
                                </tr>
                                <tr>
                                    <td>Total Earned</td>
                                    <td>{{ $certData['vl_earned'] ?? '-' }}</td>
                                    <td>{{ $certData['sl_earned'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Less this application</td>
                                    <td>{{ $certData['vl_less'] ?? '-' }}</td>
                                    <td>{{ $certData['sl_less'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Balance</td>
                                    <td>{{ $certData['vl_balance'] ?? '-' }}</td>
                                    <td>{{ $certData['sl_balance'] ?? '-' }}</td>
                                </tr>
                            </table>
                            
                            <div class="signatory">
                                @php
                                    $hrName = $certData['hr_officer'] ?? 'JOY ROSE C. BAWAYAN';
                                    $hrPosition = $certData['hr_position'] ?? 'Administrative Officer V (HRMO III)';
                                    
                                    // Handle new combined format if present
                                    if (isset($certData['hr_signatory'])) {
                                        $hrParts = explode('|', $certData['hr_signatory']);
                                        if (count($hrParts) > 1) {
                                            $hrName = $hrParts[0];
                                            $hrPosition = $hrParts[1];
                                        }
                                    }
                                @endphp
                                <div class="signatory-name">{{ $hrName }}</div>
                                <div class="signatory-position">{{ $hrPosition }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-col-half">
                        <div class="label">7.B RECOMMENDATION</div>
                        
                        <div class="recommendation-section">
                            <div class="recommendation-item">
                                <input type="checkbox" {{ isset($certData['recommendation']) && $certData['recommendation'] === 'approval' ? 'checked' : '' }} disabled>
                                <label>For approval</label>
                            </div>
                            <div class="recommendation-item">
                                <input type="checkbox" {{ isset($certData['recommendation']) && $certData['recommendation'] === 'disapproval' ? 'checked' : '' }} disabled>
                                <label>For disapproval due to: {{ $certData['disapproval_reason'] ?? '' }}</label>
                            </div>
                            
                            <div style="margin-top: 5px;">
                                <div>{{ $certData['other_remarks'] ?? '' }}</div>
                                <div>{{ $certData['other_remarks2'] ?? '' }}</div>
                                <div>{{ $certData['other_remarks3'] ?? '' }}</div>
                            </div>
                            
                            <div class="signatory" style="margin-top: 20px;">
                                @php
                                    $adminName = $certData['admin_chief'] ?? 'AIDA Y. PAGTAN';
                                    $adminPosition = $certData['admin_position'] ?? 'Chief, Administrative and Finance Division';
                                    
                                    // Handle new combined format if present
                                    if (isset($certData['admin_signatory'])) {
                                        $adminParts = explode('|', $certData['admin_signatory']);
                                        if (count($adminParts) > 1) {
                                            $adminName = $adminParts[0];
                                            $adminPosition = $adminParts[1];
                                        }
                                    }
                                @endphp
                                <div class="signatory-name">{{ $adminName }}</div>
                                <div class="signatory-position">{{ $adminPosition }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col-half form-col-border-right">
                        <div class="label">7.C APPROVED FOR:</div>
                        <div style="padding: 5px;">
                            <div style="margin-bottom: 5px;">{{ $certData['days_with_pay'] ?? '___' }} days with pay</div>
                            <div style="margin-bottom: 5px;">{{ $certData['days_without_pay'] ?? '___' }} days without pay</div>
                            <div style="margin-bottom: 5px;">{{ $certData['others_specify'] ?? '___' }} others (Specify)</div>
                        </div>
                    </div>
                    
                    <div class="form-col-half">
                        <div class="label">7.D DISAPPROVED DUE TO:</div>
                        <div style="padding: 5px;">
                            <div>{{ $certData['disapproval_reason1'] ?? '' }}</div>
                            <div>{{ $certData['disapproval_reason2'] ?? '' }}</div>
                        </div>
                    </div>
                </div>
                
                <div style="text-align: center; padding: 10px; border-top: 1px solid #000;">
                    @php
                        $directorName = $certData['director'] ?? 'Atty. JENNILYN M. DAWAYAN, CESO IV';
                        $directorPosition = $certData['director_position'] ?? 'Regional Executive Director';
                        
                        // Handle new combined format if present
                        if (isset($certData['director_signatory'])) {
                            $directorParts = explode('|', $certData['director_signatory']);
                            if (count($directorParts) > 1) {
                                $directorName = $directorParts[0];
                                $directorPosition = $directorParts[1];
                            }
                        }
                    @endphp
                    <div class="signatory-name">{{ $directorName }}</div>
                    <div class="signatory-position">{{ $directorPosition }}</div>
                </div>
            </div>
            @endif
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