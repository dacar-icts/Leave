<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Leave Request - Print</title>
    
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <style>
        @page {
            size: A4;
            margin: 0.5cm;
        }
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;
            font-size: 11pt;
        }
        
        .container {
            width: 100%;
            max-width: 21cm;
            margin: 0 auto;
            padding: 0;
            box-sizing: border-box;
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
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
            }
            
            .container {
                width: 100%;
                box-shadow: none;
            }
            
            .leave-form {
                border: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
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
                            <div>As of: {{ isset($certData['as_of_date']) ? \Carbon\Carbon::parse($certData['as_of_date'])->format('F j, Y') : '' }}</div>
                            
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
                                <div class="signatory-name">JOY ROSE C. BAWAYAN</div>
                                <div class="signatory-position">Administrative Officer V (HRMO III)</div>
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
                                <div class="signatory-name">AIDA Y. PAGTAN</div>
                                <div class="signatory-position">Chief, Administrative and Finance Division</div>
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
                    <div class="signatory-name">Atty. JENNILYN M. DAWAYAN, CESO IV</div>
                    <div class="signatory-position">Regional Executive Director</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>