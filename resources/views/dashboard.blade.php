<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            z-index: 100;
            transition: transform 0.3s ease;
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
            transition: margin-left 0.3s ease;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px 40px 0 40px;
            flex-wrap: wrap;
        }
        .header-title {
            font-size: 2.3em;
            font-weight: 700;
            color: #222;
        }
        .profile {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 12px;
        }
        .profile-card {
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
            flex-wrap: wrap;
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
            flex: 1;
        }
        .stat-card .icon {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        .stat-card .count {
            font-size: 2em;
            font-weight: 700;
            color:#1ecb6b;
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
            color:rgb(239, 54, 51);
        }
        .stat-card.pending .label {
            color: #888;
        }
        .new-btn {
            background: #1ecb6b;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 6px rgba(30,203,107,0.08);
            text-decoration: none;
        }
        .table-container {
            background: linear-gradient(to right, #a8e063 0%, #f7f7d4 100%);
            border-radius: 12px;
            padding: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            overflow-x: auto;
            margin-top: 20px;
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
        
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: #4caf50;
            font-size: 2em;
            cursor: pointer;
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 200;
        }
        
        /* Responsive styles */
        @media (max-width: 1200px) {
            .stat-card {
                padding: 20px 30px;
                min-width: 160px;
            }
            .stats-row {
                gap: 15px;
            }
        }
        
        @media (max-width: 992px) {
            .header-title {
                font-size: 1.8em;
            }
            .sidebar {
                width: 180px;
            }
            .main-content {
                margin-left: 180px;
            }
            .header, .dashboard-body {
                padding: 20px;
            }
            .new-btn {
                padding: 6px 14px;
                font-size: 0.95em;
            }
        }
        
        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }
            .sidebar {
                transform: translateX(-100%);
                width: 220px;
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            .profile {
                align-self: stretch;
                align-items: flex-start;
            }
            .profile-card {
                width: 100%;
                box-sizing: border-box;
                justify-content: space-between;
            }
            .stats-row {
                flex-wrap: wrap;
            }
            .stat-card {
                min-width: calc(50% - 15px);
                flex: 0 0 calc(50% - 15px);
                padding: 15px;
            }
            .table-container {
                overflow-x: auto;
            }
            table {
                min-width: 600px;
            }
        }
        
        @media (max-width: 576px) {
            .header-title {
                font-size: 1.5em;
            }
            .stat-card {
                min-width: 100%;
                flex: 0 0 100%;
            }
            .profile {
                width: 100%;
            }
            .profile-card {
                width: 100%;
                flex-wrap: wrap;
                justify-content: center;
                border-radius: 15px;
            }
            .new-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
    <!-- Material Icons CDN -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <button class="menu-toggle" id="menuToggle">
        <span class="material-icons">menu</span>
    </button>
    
    <div class="sidebar" id="sidebar">
        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e9/Department_of_Agriculture_of_the_Philippines.svg" alt="Department of Agriculture Logo">
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
                <div class="profile-card">
                    <div class="profile-icon">
                        <span class="material-icons">account_circle</span>
                    </div>
                    <div class="profile-info">
                        <span>{{ auth()->user()->name }}</span>
                        <a href="#">#{{ auth()->user()->id }}</a>
                    </div>
                </div>
                <a href="{{ route('leave.create') }}" class="new-btn">
                    <span class="material-icons">add</span>
                    New Leave Request
                </a>
            </div>
        </div>
        <div class="dashboard-body">
            <div class="stats-row">
                <div class="stat-card pending">
                    <span class="material-icons icon">access_time</span>
                    <div class="count">{{ $pendingCount }}</div>
                    <div class="label">Pending Requests</div>
                </div>
                <div class="stat-card">
                    <span class="material-icons icon" style="color:#1ecb6b;">check_circle</span>
                    <div class="count">{{ $certifiedCount }}</div>
                    <div class="label">Certified</div>
                </div>
                <div class="stat-card">
                    <span class="material-icons icon" style="color:#2196f3;">insights</span>
                    <div class="count" style="color:#2196f3;">{{ $totalRequests }}</div>
                    <div class="label">Total Requests</div>
                </div>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>DATE FILED</th>
                            <th>LEAVE TYPE</th>
                            <th>STATUS</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($leaveRequests) > 0)
                            @foreach($leaveRequests as $leave)
                                <tr>
                                    <td>
                                        {{ \Carbon\Carbon::parse($leave->created_at)->format('n/j/Y') }}<br>
                                        <span style="font-size:0.95em; color:#888;">
                                            {{ \Carbon\Carbon::parse($leave->created_at)->format('g:i A') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if(is_string($leave->leave_type) && $leave->leave_type[0] === '[')
                                            @php
                                                $types = json_decode($leave->leave_type);
                                                echo is_array($types) ? implode(', ', $types) : $leave->leave_type;
                                            @endphp
                                        @else
                                            {{ $leave->leave_type }}
                                        @endif
                                    </td>
                                    <td class="{{ $leave->status === 'Pending' ? 'status-pending' : ($leave->status === 'Certified' ? 'status-certified' : '') }}">
                                        {{ strtoupper($leave->status) }}
                                    </td>
                                    <td>
                                        <button class="icon-btn" title="View" onclick="showLeaveModal({{ $leave->id }})">
                                            <span class="material-icons">visibility</span>
                                        </button>
                                        @if($leave->status === 'Certified')
                                            <button class="icon-btn print" title="Print" onclick="printLeave({{ $leave->id }})">
                                                <span class="material-icons">print</span>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" style="text-align:center; padding:30px;">
                                    <div style="color:#888; font-size:1.1em;">No leave requests found</div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Leave Request Modal -->
    <div id="leaveModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.25); z-index:2000; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:16px; max-width:520px; width:95%; max-height:90vh; overflow-y:auto; margin:auto; padding:32px 24px 24px 24px; box-shadow:0 8px 32px rgba(0,0,0,0.15); position:relative;">
            <div id="leaveModalContent"></div>
            <div style="display:flex; justify-content:flex-end; margin-top:24px;">
                <button onclick="closeLeaveModal()" style="background:#e53935; color:#fff; border:none; border-radius:8px; padding:8px 22px; font-size:1em; font-weight:600; cursor:pointer;">Close</button>
            </div>
        </div>
    </div>

    <script>
        const leaveRequests = @json($leaveRequests);
        
        // Menu toggle for mobile
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
        
        function showLeaveModal(id) {
            const leave = leaveRequests.find(l => l.id === id);
            if (!leave) return;
            
            // Format leave type for display
            let leaveType = '';
            if (typeof leave.leave_type === 'string' && leave.leave_type[0] === '[') {
                try {
                    const types = JSON.parse(leave.leave_type);
                    leaveType = Array.isArray(types) ? types.join(', ') : leave.leave_type;
                } catch (e) {
                    leaveType = leave.leave_type;
                }
            } else {
                leaveType = leave.leave_type;
            }
            
            let html = `
                <h2 style="text-align:center; margin-bottom:24px; font-size:1.3em; letter-spacing:1px;">Leave Request Details</h2>
                <div><strong>Date Filed:</strong> ${new Date(leave.created_at).toLocaleDateString()}</div>
                <div><strong>Leave Type:</strong> ${leaveType}</div>
                ${leave.leave_type_other ? `<div><strong>Other Type:</strong> ${leave.leave_type_other}</div>` : ''}
                ${leave.num_days ? `<div><strong>Number of Days:</strong> ${leave.num_days}</div>` : ''}
                ${leave.inclusive_dates ? `<div><strong>Inclusive Dates:</strong> ${leave.inclusive_dates}</div>` : ''}
                <div><strong>Status:</strong> ${leave.status}</div>
                ${leave.within_ph ? `<div><strong>Within Philippines:</strong> ${leave.within_ph}</div>` : ''}
                ${leave.abroad ? `<div><strong>Abroad:</strong> ${leave.abroad}</div>` : ''}
                ${leave.in_hospital ? `<div><strong>In Hospital:</strong> ${leave.in_hospital}</div>` : ''}
                ${leave.out_patient ? `<div><strong>Out Patient:</strong> ${leave.out_patient}</div>` : ''}
                ${leave.special_leave ? `<div><strong>Special Leave:</strong> ${leave.special_leave}</div>` : ''}
                ${leave.study_leave ? `<div><strong>Study Leave:</strong> ${leave.study_leave}</div>` : ''}
                ${leave.other_purpose ? `<div><strong>Other Purpose:</strong> ${leave.other_purpose}</div>` : ''}
                ${leave.commutation ? `<div><strong>Commutation:</strong> ${leave.commutation}</div>` : ''}
            `;
            
            // If certified, show certification data
            if (leave.status === 'Certified' && leave.certification_data) {
                let certData;
                try {
                    certData = JSON.parse(leave.certification_data);
                    html += `
                        <div style="margin-top:24px; padding-top:16px; border-top:1px solid #e0e0e0;">
                            <h3 style="margin-bottom:10px;">CERTIFICATION OF LEAVE CREDITS</h3>
                            <div><strong>As of:</strong> ${new Date(certData.as_of_date).toLocaleDateString()}</div>
                            <div style="margin-top:10px;">
                                <table style="width:100%; border-collapse:collapse;">
                                    <tr style="background:#f5f5f5;">
                                        <th style="padding:8px; text-align:left; background:#f5f5f5; color:#333;">Type</th>
                                        <th style="padding:8px; text-align:center; background:#f5f5f5; color:#333;">Vacation Leave</th>
                                        <th style="padding:8px; text-align:center; background:#f5f5f5; color:#333;">Sick Leave</th>
                                    </tr>
                                    <tr>
                                        <td style="padding:8px; font-style:italic;">Total Earned</td>
                                        <td style="padding:8px; text-align:center;">${certData.vl_earned || '-'}</td>
                                        <td style="padding:8px; text-align:center;">${certData.sl_earned || '-'}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:8px; font-style:italic;">Less this application</td>
                                        <td style="padding:8px; text-align:center;">${certData.vl_less || '-'}</td>
                                        <td style="padding:8px; text-align:center;">${certData.sl_less || '-'}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:8px; font-style:italic;">Balance</td>
                                        <td style="padding:8px; text-align:center; font-weight:700;">${certData.vl_balance || '-'}</td>
                                        <td style="padding:8px; text-align:center; font-weight:700;">${certData.sl_balance || '-'}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    `;
                } catch (e) {
                    console.error('Error parsing certification data:', e);
                }
            }
            
            document.getElementById('leaveModalContent').innerHTML = html;
            document.getElementById('leaveModal').style.display = 'flex';
        }
        
        function closeLeaveModal() {
            document.getElementById('leaveModal').style.display = 'none';
        }
        
        function printLeave(id) {
            // Implement print functionality
            alert('Print functionality will be implemented here');
        }
    </script>
</body>
</html>
