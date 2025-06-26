<!DOCTYPE html>
<html>
<head>
    <title>Leave Application Form</title>
    <link href="{{ asset('css/print.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://upload.wikimedia.org/wikipedia/commons/e/e9/Department_of_Agriculture_of_the_Philippines.svg" alt="Department of Agriculture Logo" class="logo">
            <h1>Republic of the Philippines</h1>
            <h2>DEPARTMENT OF AGRICULTURE</h2>
            <h3>Cordillera Administrative Region</h3>
            <h3>BPI Compound, Easter Road, Guisad, Baguio City</h3>
        </div>
        
        <div class="form-title">APPLICATION FOR LEAVE</div>
        
        <div class="form-section">
            <table>
                <tr>
                    <td width="50%"><strong>1. OFFICE/DEPARTMENT:</strong> {{ $leave->office ?? 'Department of Agriculture' }}</td>
                    <td width="50%"><strong>2. NAME:</strong> {{ $leave->user->name ?? '' }}</td>
                </tr>
                <tr>
                    <td><strong>3. DATE OF FILING:</strong> {{ $filingDate }}</td>
                    <td><strong>4. POSITION:</strong> {{ $leave->position ?? 'Employee' }}</td>
                </tr>
                <tr>
                    <td colspan="2"><strong>5. SALARY:</strong> {{ $leave->salary ?? '' }}</td>
                </tr>
            </table>
        </div>
        
        <div class="form-section">
            <table>
                <tr>
                    <th colspan="2">6. DETAILS OF APPLICATION</th>
                </tr>
                <tr>
                    <td width="50%"><strong>TYPE OF LEAVE:</strong> {{ $leaveType }}</td>
                    <td width="50%">
                        @if($leave->leave_type_other)
                            <div><strong>Other Type:</strong> {{ $leave->leave_type_other }}</div>
                        @endif
                        
                        @if($leave->within_ph === 'Yes')
                            <div><strong>Within Philippines:</strong> {{ $leave->within_ph_details ?? 'Yes' }}</div>
                        @endif
                        
                        @if($leave->abroad === 'Yes')
                            <div><strong>Abroad:</strong> {{ $leave->abroad_details ?? 'Yes' }}</div>
                        @endif
                        
                        @if($leave->in_hospital === 'Yes')
                            <div><strong>In Hospital:</strong> {{ $leave->in_hospital_details ?? 'Yes' }}</div>
                        @endif
                        
                        @if($leave->out_patient === 'Yes')
                            <div><strong>Out Patient:</strong> {{ $leave->out_patient_details ?? 'Yes' }}</div>
                        @endif
                        
                        @if($leave->special_leave_details)
                            <div><strong>Special Leave Details:</strong> {{ $leave->special_leave_details }}</div>
                        @endif
                        
                        @if($leave->completion_masters === 'Yes')
                            <div><strong>Study Leave:</strong> Completion of Master's Degree</div>
                        @endif
                        
                        @if($leave->bar_exam === 'Yes')
                            <div><strong>Study Leave:</strong> BAR/Board Examination Review</div>
                        @endif
                        
                        @if($leave->monetization === 'Yes')
                            <div><strong>Other Purpose:</strong> Monetization of Leave Credits</div>
                        @endif
                        
                        @if($leave->terminal_leave === 'Yes')
                            <div><strong>Other Purpose:</strong> Terminal Leave</div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>NUMBER OF WORKING DAYS:</strong> {{ $leave->num_days ?? '' }}</td>
                    <td><strong>INCLUSIVE DATES:</strong> {{ $leave->inclusive_dates ?? '' }}</td>
                </tr>
                <tr>
                    <td colspan="2"><strong>COMMUTATION:</strong> {{ $leave->commutation ?? 'Not Requested' }}</td>
                </tr>
            </table>
        </div>
        
        <div class="signature-container">
            <div class="col-half">
                <div class="signature-line">Signature of Applicant</div>
            </div>
            <div class="col-half">
                <div class="signature-line">Date</div>
            </div>
        </div>
        
        <div class="certification">
            <h3 style="text-align: center; margin-bottom: 20px;">CERTIFICATION OF LEAVE CREDITS</h3>
            <p><strong>As of:</strong> {{ $certDate }}</p>
            
            <table>
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
            
            <div class="signature-container">
                <div class="col-half">
                    <div class="signature-line">HR Officer Signature</div>
                </div>
                <div class="col-half">
                    <div class="signature-line">Date Certified</div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html> 