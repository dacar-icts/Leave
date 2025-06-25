<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application for Leave</title>
    <link rel="stylesheet" href="/css/leave_application_form.css">
</head>
<body>
    <div class="form-container">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                Civil Service Form No. 6<br>
                Revised 2020
            </div>
            <div class="stamp-box">
                Stamp of Date of Receipt
            </div>
            <div class="logo"></div>
            <div class="header-text">
                <strong>Republic of the Philippines</strong><br>
                <strong>DEPARTMENT OF AGRICULTURE</strong><br>
                <strong>Cordillera Administrative Region</strong><br>
                <em>BPI Compound, Easter Road, Guisad, Baguio City</em>
            </div>
        </div>

        <!-- Form Title -->
        <div class="form-title">
            APPLICATION FOR LEAVE
        </div>

        <!-- Basic Information -->
        <div class="form-row">
            <div class="form-field">
                <label>1. OFFICE/DEPARTMENT</label>
                <div class="underline"></div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-field" style="flex: 2;">
                <label>2. NAME:</label>
                (Last) <span class="underline"></span>
                (First) <span class="underline"></span>
                (Middle) <span class="underline"></span>
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label>3. DATE OF FILING</label>
                <span class="underline"></span>
            </div>
            <div class="form-field">
                <label>4. POSITION</label>
                <span class="underline"></span>
            </div>
            <div class="form-field">
                <label>5. SALARY</label>
                <span class="underline"></span>
            </div>
        </div>

        <!-- Details of Application -->
        <div class="section-title">
            6. DETAILS OF APPLICATION
        </div>

        <div class="checkbox-section">
            <div class="checkbox-left">
                <strong>6.A TYPE OF LEAVE TO BE AVAILED OF</strong><br><br>
                
                <div class="checkbox-item">
                    <input type="checkbox" id="vacation"> 
                    <label for="vacation">Vacation Leave (Sec. 51, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</label>
                </div>
                
                <div class="checkbox-item">
                    <input type="checkbox" id="mandatory"> 
                    <label for="mandatory">Mandatory/Forced Leave (Sec. 25, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</label>
                </div>
                
                <div class="checkbox-item">
                    <input type="checkbox" id="sick"> 
                    <label for="sick">Sick Leave (Sec. 43, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</label>
                </div>
                
                <div class="checkbox-item">
                    <input type="checkbox" id="maternity"> 
                    <label for="maternity">Maternity Leave (R.A. No. 11210 IRR issued by CSC, DOLE and SSS)</label>
                </div>
                
                <div class="checkbox-item">
                    <input type="checkbox" id="paternity"> 
                    <label for="paternity">Paternity Leave (R.A. No. 8187/ CSC MC No. 71, s. 1998, as amended)</label>
                </div>
                
                <div class="checkbox-item">
                    <input type="checkbox" id="special_privilege"> 
                    <label for="special_privilege">Special Privilege Leave (Sec. 21, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</label>
                </div>
                
                <div class="checkbox-item">
                    <input type="checkbox" id="solo_parent"> 
                    <label for="solo_parent">Solo Parent Leave (R.A No. 8972/ CSC MC No. 8, s. 2004)</label>
                </div>
                
                <div class="checkbox-item">
                    <input type="checkbox" id="study"> 
                    <label for="study">Study Leave (Sec. 58, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</label>
                </div>
                
                <div class="checkbox-item">
                    <input type="checkbox" id="vawc"> 
                    <label for="vawc">10-Day VAWC Leave (R.A No. 9262/ CSC MC No. 15, s. 2005)</label>
                </div>
                
                <div class="checkbox-item">
                    <input type="checkbox" id="rehabilitation"> 
                    <label for="rehabilitation">Rehabilitation Privilege (Sec. 55, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</label>
                </div>
                
                <div class="checkbox-item">
                    <input type="checkbox" id="special_women"> 
                    <label for="special_women">Special Leave Benefits for Women (R.A No. 9710/ CSC MC No. 25, s. 2010)</label>
                </div>
                
                <div class="checkbox-item">
                    <input type="checkbox" id="emergency"> 
                    <label for="emergency">Special Emergency (Calamity) Leave (CSC MC No. 2, s. 2012, as amended)</label>
                </div>
                
                <div class="checkbox-item">
                    <input type="checkbox" id="adoption"> 
                    <label for="adoption">Adoption Leave (R.A. No. 8552)</label>
                </div>
                
                <div style="margin-top: 10px;">
                    <em>Others:</em><br>
                    <span class="underline" style="min-width: 300px;"></span>
                </div>
            </div>

            <div class="checkbox-right">
                <strong>6.B DETAILS OF LEAVE</strong><br><br>
                
                <em>In case of Vacation/Special Privilege Leave:</em><br>
                <input type="checkbox" id="within_ph"> Within the Philippines <span class="underline"></span><br>
                <input type="checkbox" id="abroad"> Abroad (Specify) <span class="underline"></span><br><br>
                
                <em>In case of Sick Leave:</em><br>
                <input type="checkbox" id="in_hospital"> In Hospital (Specify Illness) <span class="underline"></span><br>
                <input type="checkbox" id="out_patient"> Out Patient (Specify Illness) <span class="underline"></span><br><br>
                
                <em>In case of Special Leave Benefits for Women:</em><br>
                (Specify Illness) <span class="underline"></span><br><br>
                
                <em>In case of Study Leave:</em><br>
                <input type="checkbox" id="masters"> Completion of Master's Degree <span class="underline"></span><br>
                <input type="checkbox" id="bar_board"> BAR/Board Examination Review <span class="underline"></span><br><br>
                
                <em>Other purpose:</em><br>
                <input type="checkbox" id="monetization"> Monetization of Leave Credits <span class="underline"></span><br>
                <input type="checkbox" id="terminal"> Terminal Leave <span class="underline"></span>
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <strong>6.C NUMBER OF WORKING DAYS APPLIED FOR</strong><br><br>
                <span class="underline" style="min-width: 200px;"></span><br><br>
                <strong>INCLUSIVE DATES</strong><br>
                <span class="underline" style="min-width: 200px;"></span>
            </div>
            <div class="form-field">
                <strong>6.D COMMUTATION</strong><br><br>
                <input type="checkbox" id="not_requested"> <label for="not_requested">Not Requested</label><br>
                <input type="checkbox" id="requested"> <label for="requested">Requested</label><br><br><br><br>
                
                <div class="name-line">
                    (Signature of Applicant)
                </div>
            </div>
        </div>

        <!-- Details of Action -->
        <div class="action-section">
            7. DETAILS OF ACTION ON APPLICATION
        </div>

        <div class="action-row">
            <div class="action-field">
                <strong>7.A CERTIFICATION OF LEAVE CREDITS</strong><br><br>
                As of <span class="underline"></span><br><br>
                
                <table class="leave-table">
                    <tr>
                        <th></th>
                        <th>Vacation Leave</th>
                        <th>Sick Leave</th>
                    </tr>
                    <tr>
                        <td><em>Total Earned</em></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><em>Less this application</em></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><em>Balance</em></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                
                <div class="name-line">
                    <strong>NAME</strong><br>
                    Administrative Officer V (HRMO III)
                </div>
            </div>

            <div class="action-field">
                <strong>7.B RECOMMENDATION</strong><br><br>
                <input type="checkbox" id="approval"> <label for="approval">For approval</label><br>
                <input type="checkbox" id="disapproval"> <label for="disapproval">For disapproval due to</label> <span class="underline"></span><br>
                <span class="underline" style="min-width: 250px;"></span><br>
                <span class="underline" style="min-width: 250px;"></span><br>
                <span class="underline" style="min-width: 250px;"></span><br><br>
                
                <div class="name-line">
                    <strong>NAME</strong><br>
                    Chief, Administrative and Finance Division
                </div>
            </div>
        </div>

        <div class="approval-section">
            <div class="approval-left">
                <strong>7.C APPROVED FOR:</strong><br>
                <span class="underline"></span> days with pay<br>
                <span class="underline"></span> days without pay<br>
                <span class="underline"></span> others (Specify)<br>
                <span class="underline" style="min-width: 200px;"></span>
            </div>
            <div class="approval-right">
                <strong>7.D DISAPPROVED DUE TO:</strong><br>
                <span class="underline" style="min-width: 300px;"></span><br>
                <span class="underline" style="min-width: 300px;"></span><br>
                <span class="underline" style="min-width: 300px;"></span>
            </div>
        </div>

        <div style="text-align: center; padding: 20px; border-top: 1px solid #000;">
            <div class="name-line">
                <strong>NAME</strong><br>
                Regional Executive Director
            </div>
        </div>
    </div>
</body>
</html>