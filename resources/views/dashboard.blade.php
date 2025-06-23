<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application Leave Form</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', Arial, sans-serif;
            background: linear-gradient(to right, #a8e063 0%, #f7f7d4 100%);
            min-height: 100vh;
        }
        .sidebar {
            width: 220px;
            background: linear-gradient(to bottom, #4caf50 0%, #cdecb0 100%);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 24px;
        }
        .sidebar img {
            width: 70px;
            margin-bottom: 10px;
        }
        .sidebar h2 {
            font-size: 1.2em;
            margin: 0;
            font-weight: 700;
        }
        .sidebar p {
            margin: 0;
            font-size: 0.95em;
        }
        .sidebar .dashboard-link {
            margin: 40px 0 0 0;
            font-size: 1.1em;
            color: #226d1b;
            background: #eafbe7;
            padding: 8px 18px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            font-weight: 500;
            text-decoration: none;
        }
        .sidebar .dashboard-link i {
            margin-right: 8px;
        }
        .sidebar .logout {
            margin-top: auto;
            margin-bottom: 30px;
            color: #226d1b;
            font-weight: 500;
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: 1.1em;
        }
        .sidebar .logout i {
            margin-right: 8px;
        }
        .main-content {
            margin-left: 220px;
            padding: 0;
            min-height: 100vh;
            background: #f9f9e6;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px 40px 0 40px;
        }
        .header-title {
            font-size: 2.3em;
            font-weight: 700;
            color: #222;
        }
        .profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #f5f5f5;
            border-radius: 30px;
            padding: 8px 18px;
        }
        .profile-icon {
            width: 38px;
            height: 38px;
            background: #e0e0e0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.7em;
            color: #888;
        }
        .profile-info {
            display: flex;
            flex-direction: column;
        }
        .profile-info span {
            font-weight: 700;
            color: #222;
            font-size: 1.1em;
        }
        .profile-info a {
            color: #4caf50;
            font-size: 0.95em;
            text-decoration: none;
        }
        .dashboard-body {
            padding: 30px 40px 0 40px;
        }
        .stats-row {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            padding: 30px 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 180px;
        }
        .stat-card .icon {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        .stat-card .count {
            font-size: 2em;
            font-weight: 700;
            color: #4caf50;
        }
        .stat-card .label {
            font-size: 1em;
            color: #888;
            margin-top: 4px;
        }
        .stat-card.pending .icon {
            color: #888;
        }
        .stat-card.pending .count {
            color: #e53935;
        }
        .stat-card.pending .label {
            color: #888;
        }
        .new-btn {
            background: #1ecb6b;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 28px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            float: right;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(30,203,107,0.08);
            text-decoration: none;
        }
        .table-container {
            background: linear-gradient(to right, #a8e063 0%, #f7f7d4 100%);
            border-radius: 12px;
            padding: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
        }
        th, td {
            padding: 16px 18px;
            text-align: left;
        }
        th {
            background: linear-gradient(to right, #43a047 0%, #a8e063 100%);
            color: #fff;
            font-size: 1.1em;
            font-weight: 700;
        }
        tr:not(:last-child) {
            border-bottom: 1px solid #e0e0e0;
        }
        .status-pending {
            color: #e53935;
            font-weight: 700;
        }
        .status-certified {
            color: #1ecb6b;
            font-weight: 700;
        }
        .icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.3em;
            color: #1ecb6b;
            margin-right: 8px;
        }
        .icon-btn.print {
            color: #43a047;
        }
        @media (max-width: 900px) {
            .header, .dashboard-body {
                padding: 20px;
            }
            .sidebar {
                width: 100px;
                padding-top: 10px;
            }
            .main-content {
                margin-left: 100px;
            }
        }
    </style>
    <!-- Material Icons CDN -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <div class="sidebar">
        <img src="https://i.ibb.co/6bQw4yT/da-logo.png" alt="Department of Agriculture Logo">
        <h2>Department of<br>Agriculture</h2>
        <p>1998</p>
        <a href="#" class="dashboard-link">
            <span class="material-icons">dashboard</span>
            User Dashboard
        </a>
        <a href="{{ route('logout') }}" class="logout"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span class="material-icons">logout</span>
            Log Out
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    <div class="main-content">
        <div class="header">
            <div class="header-title">Application Leave Form</div>
            <div class="profile">
                <div class="profile-icon">
                    <span class="material-icons">account_circle</span>
                </div>
                <div class="profile-info">
                    <span>{{ auth()->user()->name }}</span>
                    <a href="#">#{{ auth()->user()->id }}</a>
                </div>
            </div>
        </div>
        <div class="dashboard-body">
            <div class="stats-row">
                <div class="stat-card">
                    <span class="material-icons icon" style="color:#1ecb6b;">check_circle</span>
                    <div class="count">2</div>
                    <div class="label">HR Certified</div>
                </div>
                <div class="stat-card pending">
                    <span class="material-icons icon" style="color:#888;">access_time</span>
                    <div class="count" style="color:#e53935;">1</div>
                    <div class="label">Pending Approval</div>
                </div>
                <a href="#" class="new-btn" style="margin-left:auto;">
                    <span class="material-icons">add_circle</span>
                    NEW
                </a>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>DATE FILED</th>
                            <th>TYPE OF LEAVE</th>
                            <th>STATUS</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1/16/2025</td>
                            <td>SICK LEAVE</td>
                            <td class="status-pending">PENDING</td>
                            <td>
                                <button class="icon-btn" title="View"><span class="material-icons">visibility</span></button>
                            </td>
                        </tr>
                        <tr>
                            <td>1/15/2025</td>
                            <td>TRAVEL</td>
                            <td class="status-certified">HR CERTIFIED</td>
                            <td>
                                <button class="icon-btn" title="View"><span class="material-icons">visibility</span></button>
                                <button class="icon-btn print" title="Print"><span class="material-icons">print</span></button>
                            </td>
                        </tr>
                        <tr>
                            <td>1/14/2025</td>
                            <td>VACATION LEAVE</td>
                            <td class="status-certified">HR CERTIFIED</td>
                            <td>
                                <button class="icon-btn" title="View"><span class="material-icons">visibility</span></button>
                                <button class="icon-btn print" title="Print"><span class="material-icons">print</span></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Leave Application Modal -->
    <div id="leaveModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.25); z-index:1000; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:16px; max-width:420px; width:95vw; max-height:90vh; overflow-y:auto; margin:auto; padding:32px 24px 24px 24px; box-shadow:0 8px 32px rgba(0,0,0,0.15); position:relative;">
            <h2 style="text-align:center; margin-bottom:18px; font-size:1.3em; letter-spacing:1px;">DETAILS OF APPLICATION</h2>
            <form id="leaveForm">
                <div style="margin-bottom:18px;">
                    <div style="font-weight:600; margin-bottom:8px;">TYPE OF LEAVE TO BE AVAILED OF</div>
                    <div style="display:flex; flex-direction:column; gap:4px; font-size:0.98em;">
                        <label><input type="checkbox" name="leave_type[]" value="Mandatory/Forced Leave"> Mandatory / Forced Leave</label>
                        <label><input type="checkbox" name="leave_type[]" value="Vacation Leave"> Vacation Leave</label>
                        <label><input type="checkbox" name="leave_type[]" value="Sick Leave"> Sick Leave</label>
                        <label><input type="checkbox" name="leave_type[]" value="Maternity Leave"> Maternity Leave</label>
                        <label><input type="checkbox" name="leave_type[]" value="Paternity Leave"> Paternity Leave</label>
                        <label><input type="checkbox" name="leave_type[]" value="Special Privilege Leave"> Special Privilege Leave</label>
                        <label><input type="checkbox" name="leave_type[]" value="Solo Parent Leave"> Solo Parent Leave</label>
                        <label><input type="checkbox" name="leave_type[]" value="Study Leave"> Study Leave</label>
                        <label><input type="checkbox" name="leave_type[]" value="10-day VAWC Leave"> 10-day VAWC Leave</label>
                        <label><input type="checkbox" name="leave_type[]" value="Rehabilitation Privilege"> Rehabilitation Privilege</label>
                        <label><input type="checkbox" name="leave_type[]" value="Special Leave Benefits for Women"> Special Leave Benefits for Women</label>
                        <label><input type="checkbox" name="leave_type[]" value="Special Emergency (Calamity) Leave"> Special Emergency (Calamity) Leave</label>
                        <label><input type="checkbox" name="leave_type[]" value="Adoption Leave"> Adoption Leave</label>
                    </div>
                    <div style="margin-top:8px;">
                        <label style="font-size:0.98em;">OTHERS:</label>
                        <input type="text" name="leave_type_other" placeholder="STATE YOUR REASON" style="width:100%; margin-top:2px; padding:6px; border-radius:6px; border:1px solid #ccc;">
                    </div>
                </div>
                <div style="margin-bottom:18px;">
                    <div style="font-weight:600; margin-bottom:8px;">DETAILS OF ‘LEAVE’</div>
                    <input type="text" name="within_ph" placeholder="Within the Philippines" style="width:100%; margin-bottom:6px; padding:6px; border-radius:6px; border:1px solid #ccc;">
                    <input type="text" name="abroad" placeholder="Abroad (Specify)" style="width:100%; margin-bottom:6px; padding:6px; border-radius:6px; border:1px solid #ccc;">
                    <input type="text" name="in_hospital" placeholder="In Hospital (Specify Illness)" style="width:100%; margin-bottom:6px; padding:6px; border-radius:6px; border:1px solid #ccc;">
                    <input type="text" name="out_patient" placeholder="Out Patient (Specify Illness)" style="width:100%; margin-bottom:6px; padding:6px; border-radius:6px; border:1px solid #ccc;">
                    <input type="text" name="special_leave" placeholder="Special Leave Benefits for Women (Specify Illness)" style="width:100%; margin-bottom:6px; padding:6px; border-radius:6px; border:1px solid #ccc;">
                    <input type="text" name="study_leave" placeholder="Study Leave (Completion of Master’s Degree, BAR/Board Review)" style="width:100%; margin-bottom:6px; padding:6px; border-radius:6px; border:1px solid #ccc;">
                    <input type="text" name="other_purpose" placeholder="Other purpose (Monetization/Terminal Leave)" style="width:100%; margin-bottom:6px; padding:6px; border-radius:6px; border:1px solid #ccc;">
                </div>
                <div style="margin-bottom:18px;">
                    <div style="font-weight:600; margin-bottom:8px;">LEAVE DURATION</div>
                    <input type="number" name="num_days" placeholder="Number of Working Days Applied For" style="width:100%; margin-bottom:6px; padding:6px; border-radius:6px; border:1px solid #ccc;">
                    <input type="text" name="inclusive_dates" placeholder="Inclusive Dates" style="width:100%; margin-bottom:6px; padding:6px; border-radius:6px; border:1px solid #ccc;">
                </div>
                <div style="margin-bottom:18px;">
                    <div style="font-weight:600; margin-bottom:8px;">COMMUTATION</div>
                    <label><input type="radio" name="commutation" value="Not Requested"> Not Requested</label>
                    <label style="margin-left:18px;"><input type="radio" name="commutation" value="Requested"> Requested</label>
                </div>
                <div style="display:flex; justify-content:flex-end; gap:12px;">
                    <button type="button" onclick="closeLeaveModal()" style="background:#e53935; color:#fff; border:none; border-radius:8px; padding:8px 22px; font-size:1em; font-weight:600; cursor:pointer;">Discard</button>
                    <button type="submit" style="background:#1ecb6b; color:#fff; border:none; border-radius:8px; padding:8px 22px; font-size:1em; font-weight:600; cursor:pointer;">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Open modal on NEW button click
        document.querySelectorAll('.new-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('leaveModal').style.display = 'flex';
            });
        });

        // Close modal
        function closeLeaveModal() {
            document.getElementById('leaveModal').style.display = 'none';
        }

        // Optional: Handle form submission (AJAX or normal)
        document.getElementById('leaveForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Leave application submitted! (Connect this to your backend)');
            closeLeaveModal();
            this.reset();
        });
    </script>
</body>
</html>
