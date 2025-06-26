<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Dashboard</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,italic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', Arial, sans-serif;
            background: #f9f9e6;
            min-height: 100vh;
        }
        .sidebar {
            width: 220px;
            background: linear-gradient(to bottom, #006400 0%, #43a047 100%);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding-top: 24px;
            z-index: 100;
            transition: transform 0.3s ease;
        }
        .sidebar img {
            width: 70px;
            margin-left: 24px;
            margin-bottom: 10px;
        }
        .sidebar h2 {
            font-size: 1.2em;
            margin: 0 0 0 24px;
            font-weight: 700;
        }
        .sidebar p {
            margin: 0 0 0 24px;
            font-size: 0.95em;
        }
        .sidebar .dashboard-link {
            margin: 40px 0 0 24px;
            font-size: 1.1em;
            color: #fff;
            background: #388e3c;
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
            color: #fff;
            font-weight: 500;
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: 1.1em;
            margin-left: 24px;
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
        .header-title i {
            font-style: italic;
            font-weight: 400;
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
            min-width: 220px;
            flex: 1;
        }
        .stat-card .icon {
            font-size: 2.5em;
            margin-bottom: 10px;
            color: #888;
        }
        .stat-card .count {
            font-size: 2em;
            font-weight: 700;
            color: #e53935;
        }
        .stat-card .label {
            font-size: 1em;
            color: #888;
            margin-top: 4px;
            text-align: center;
        }
        .search-bar {
            display: flex;
            align-items: center;
            float: right;
            margin-bottom: 16px;
            margin-top: -10px;
        }
        .search-bar .material-icons {
            color: #444;
            font-size: 1.5em;
            margin-right: 8px;
        }
        .search-bar input {
            border: none;
            border-radius: 20px;
            padding: 8px 16px;
            font-size: 1em;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.07);
            outline: none;
        }
        .table-container {
            background: linear-gradient(to right, #43a047 0%, #a8e063 100%);
            border-radius: 12px 12px 0 0;
            padding: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            margin-top: 20px;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 0 0 12px 12px;
            overflow: hidden;
        }
        th, td {
            padding: 16px 18px;
            text-align: left;
        }
        th {
            background: transparent;
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
        .icon-btn.edit {
            color: #43a047;
        }
        .filter-group {
            display: flex;
            gap: 4px;
            flex-wrap: wrap;
        }
        .filter-btn {
            background: #fff;
            border: 1px solid #43a047;
            color: #43a047;
            padding: 6px 16px;
            border-radius: 18px;
            font-size: 1em;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
        }
        .filter-btn.active, .filter-btn:hover {
            background: #43a047;
            color: #fff;
        }
        
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: #43a047;
            font-size: 2em;
            cursor: pointer;
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 200;
        }
        
        .filters-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            margin-top: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        /* Responsive styles */
        @media (max-width: 1200px) {
            .stat-card {
                padding: 20px 30px;
                min-width: 180px;
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
            .filters-container {
                flex-direction: column;
                align-items: flex-start;
            }
            #dateFilterForm {
                flex-wrap: wrap;
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
                align-self: flex-end;
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
            .search-bar {
                float: none;
                margin-top: 15px;
                width: 100%;
            }
            .search-bar input {
                width: 100%;
            }
            .filter-group {
                width: 100%;
                justify-content: space-between;
            }
            .filter-btn {
                flex: 1;
                text-align: center;
                padding: 6px 8px;
            }
            #dateFilterForm {
                width: 100%;
            }
            #dateFilterForm input[type="date"] {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <button class="menu-toggle" id="menuToggle">
        <span class="material-icons">menu</span>
    </button>
    
    <div class="sidebar" id="sidebar">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Department_of_Agriculture_of_the_Philippines.svg/1200px-Department_of_Agriculture_of_the_Philippines.svg.png" alt="Department of Agriculture Logo">
        <h2>Department of<br>Agriculture</h2>
        <p>1960</p>
        <a href="#" class="dashboard-link">
            <span class="material-icons">account_circle</span>
            HR Dashboard
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
            <div class="header-title">
                Application Leave Form <i>(Requests)</i>
            </div>
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
                    <span class="material-icons icon">access_time</span>
                    <div class="count">{{ $pendingCount }}</div>
                    <div class="label">Pending Certification</div>
                </div>
                <div class="stat-card">
                    <span class="material-icons icon" style="color:#1ecb6b;">check_circle</span>
                    <div class="count" style="color:#1ecb6b;">{{ $certifiedCount }}</div>
                    <div class="label">HR Certified</div>
                </div>
                <div class="stat-card">
                    <span class="material-icons icon" style="color:#2196f3;">insights</span>
                    <div class="count" style="color:#2196f3;">{{ $totalRequests }}</div>
                    <div class="label">Total Requests</div>
                </div>
                <div class="stat-card">
                    <span class="material-icons icon" style="color:#ff9800;">event</span>
                    <div class="count" style="color:#ff9800;">{{ $recentRequests }}</div>
                    <div class="label">Last 7 Days</div>
                </div>
            </div>
            
            <div class="filters-container">
                <div>
                    <form id="dateFilterForm" style="display:flex; gap:10px; align-items:center;">
                        <label style="font-weight:500;">Date Range:</label>
                        <input type="date" name="start_date" id="startDate" style="padding:6px 10px; border-radius:6px; border:1px solid #ccc;" value="{{ request('start_date') }}">
                        <span>to</span>
                        <input type="date" name="end_date" id="endDate" style="padding:6px 10px; border-radius:6px; border:1px solid #ccc;" value="{{ request('end_date') }}">
                        <button type="submit" class="filter-btn" style="background:#43a047; color:#fff;">Apply</button>
                        <button type="button" class="filter-btn" onclick="clearDateFilter()">Clear</button>
                    </form>
                </div>
                
                <div style="display:flex; align-items:center; gap:12px; flex-wrap: wrap;">
                    <div class="filter-group">
                        <button class="filter-btn active" data-status="all" onclick="filterStatus(event, 'all')">All</button>
                        <button class="filter-btn" data-status="Pending" onclick="filterStatus(event, 'Pending')">Pending</button>
                        <button class="filter-btn" data-status="Certified" onclick="filterStatus(event, 'Certified')">Certified</button>
                    </div>
                    <div class="search-bar">
                        <span class="material-icons">search</span>
                        <input type="text" id="searchInput" placeholder="Search Name or ID #">
                        <span class="material-icons" style="color:#888;cursor:pointer;" onclick="clearSearch()">close</span>
                    </div>
                </div>
            </div>
            
            <!-- Most Requested Leave Types -->
            <div style="margin-bottom:20px; background:#fff; border-radius:12px; padding:20px; box-shadow:0 2px 8px rgba(0,0,0,0.07);">
                <h3 style="margin-top:0; margin-bottom:15px; font-size:1.2em; color:#333;">Most Requested Leave Types</h3>
                <div style="display:flex; gap:15px; flex-wrap:wrap;">
                    @foreach($leaveTypeStats as $stat)
                        <div style="padding:10px 16px; background:#f5f5f5; border-radius:8px; font-weight:500;">
                            {{ str_replace('"', '', $stat->leave_type) }}: <span style="color:#43a047; font-weight:700;">{{ $stat->count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th onclick="sortTable(0)" style="cursor:pointer;">DATE <span class="material-icons" style="font-size:16px; vertical-align:middle;">unfold_more</span></th>
                            <th onclick="sortTable(1)" style="cursor:pointer;">ID # <span class="material-icons" style="font-size:16px; vertical-align:middle;">unfold_more</span></th>
                            <th onclick="sortTable(2)" style="cursor:pointer;">NAME <span class="material-icons" style="font-size:16px; vertical-align:middle;">unfold_more</span></th>
                            <th onclick="sortTable(3)" style="cursor:pointer;">STATUS <span class="material-icons" style="font-size:16px; vertical-align:middle;">unfold_more</span></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="leaveTableBody">
                        @foreach($leaveRequests as $leave)
                        <tr data-id="{{ $leave->id }}" data-date="{{ $leave->created_at }}" data-status="{{ $leave->status }}">
                            <td>
                                {{ \Carbon\Carbon::parse($leave->created_at)->format('n/j/Y') }}<br>
                                <span style="font-size:0.95em; color:#888;">
                                    {{ \Carbon\Carbon::parse($leave->created_at)->format('g:i A') }}
                                </span>
                            </td>
                            <td>#{{ $leave->user->id }}</td>
                            <td>{{ strtoupper($leave->user->name) }}</td>
                            <td class="{{ $leave->status === 'Pending' ? 'status-pending' : ($leave->status === 'Certified' ? 'status-certified' : '') }}">
                                {{ $leave->status === 'Certified' ? 'HR CERTIFIED' : strtoupper($leave->status) }}
                            </td>
                            <td>
                                <button class="icon-btn" title="View" onclick="showPreviewModal({{ $leave->id }})">
                                    <span class="material-icons">visibility</span>
                                </button>
                                @if($leave->status === 'Pending')
                                    <button class="icon-btn edit" title="Edit" onclick="showEditModal({{ $leave->id }})">
                                        <span class="material-icons">edit</span>
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        
                        @if(count($leaveRequests) === 0)
                        <tr>
                            <td colspan="5" style="text-align:center; padding:30px;">
                                <div style="color:#888; font-size:1.1em;">No leave requests found</div>
                                @if(request('start_date') || request('end_date'))
                                    <button class="filter-btn" onclick="clearDateFilter()" style="margin-top:10px;">Clear Filters</button>
                                @endif
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Leave Request Preview/Certification Modal -->
    <div id="previewModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.25); z-index:2000; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:16px; max-width:520px; width:98vw; max-height:95vh; overflow-y:auto; margin:auto; padding:32px 24px 24px 24px; box-shadow:0 8px 32px rgba(0,0,0,0.15); position:relative;">
            <h2 style="text-align:center; margin-bottom:18px; font-size:1.3em; letter-spacing:1px;">Leave Request Preview</h2>
            <div id="previewContent"></div>
            <form id="certifyForm" style="display:none; margin-top:32px;">
                <h3 style="margin-bottom:10px;">CERTIFICATION OF LEAVE CREDITS</h3>
                <div style="display:flex; align-items:center; margin-bottom:10px; flex-wrap:wrap;">
                    <span style="font-weight:500; margin-right:10px;">As of</span>
                    <input type="date" name="as_of_date" required style="padding:4px 8px; border-radius:6px; border:1px solid #ccc;">
                </div>
                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse; margin-bottom:18px;">
                        <tr>
                            <td></td>
                            <td style="text-align:center; font-weight:600;">Vacation Leave</td>
                            <td style="text-align:center; font-weight:600;">Sick Leave</td>
                        </tr>
                        <tr>
                            <td style="font-style:italic;">Total Earned</td>
                            <td><input type="text" name="vl_earned" style="width:90%; background:#e0e0e0; border:none; border-radius:6px; padding:4px 8px;"></td>
                            <td><input type="text" name="sl_earned"  style="width:90%; background:#e0e0e0; border:none; border-radius:6px; padding:4px 8px;"></td>
                        </tr>
                        <tr>
                            <td style="font-style:italic;">Less this application</td>
                            <td><input type="text" name="vl_less"  style="width:90%; background:#e0e0e0; border:none; border-radius:6px; padding:4px 8px;"></td>
                            <td><input type="text" name="sl_less"  style="width:90%; background:#e0e0e0; border:none; border-radius:6px; padding:4px 8px;"></td>
                        </tr>
                        <tr>
                            <td style="font-style:italic;">Balance</td>
                            <td><input type="text" name="vl_balance"  style="width:90%; background:#e0e0e0; border:none; border-radius:6px; padding:4px 8px;"></td>
                            <td><input type="text" name="sl_balance"  style="width:90%; background:#e0e0e0; border:none; border-radius:6px; padding:4px 8px;"></td>
                        </tr>
                    </table>
                </div>
                <div style="display:flex; justify-content:flex-end; gap:18px; flex-wrap:wrap;">
                    <button type="button" onclick="closePreviewModal()" style="background:#e53935; color:#fff; border:none; border-radius:8px; padding:8px 22px; font-size:1em; font-weight:600; cursor:pointer;">Discard</button>
                    <button type="submit" style="background:#1ecb6b; color:#fff; border:none; border-radius:8px; padding:8px 22px; font-size:1em; font-weight:600; cursor:pointer;">Save</button>
                </div>
            </form>
            <div id="closeOnly" style="display:flex; justify-content:flex-end; margin-top:18px;">
                <button type="button" onclick="closePreviewModal()" style="background:#e53935; color:#fff; border:none; border-radius:8px; padding:8px 22px; font-size:1em; font-weight:600; cursor:pointer;">Close</button>
            </div>
        </div>
    </div>

    <script>
        const leaveRequests = @json($leaveRequests);
        let editingLeaveId = null;
        let currentSort = { column: -1, direction: 'asc' };
        
        // Menu toggle for mobile
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        function showPreviewModal(id) {
            editingLeaveId = null;
            const leave = leaveRequests.find(l => l.id === id);
            if (!leave) return;
            fillPreviewContent(leave);
            document.getElementById('certifyForm').style.display = 'none';
            document.getElementById('closeOnly').style.display = 'flex';
            document.getElementById('previewModal').style.display = 'flex';
        }

        function showEditModal(id) {
            editingLeaveId = id;
            const leave = leaveRequests.find(l => l.id === id);
            if (!leave) return;
            fillPreviewContent(leave);
            document.getElementById('certifyForm').reset();
            document.getElementById('certifyForm').style.display = 'block';
            document.getElementById('closeOnly').style.display = 'none';
            document.getElementById('previewModal').style.display = 'flex';
        }

        function fillPreviewContent(leave) {
            let html = `
                <div><strong>Date Filed:</strong> ${leave.created_at ? new Date(leave.created_at).toLocaleDateString() : ''}</div>
                <div><strong>ID #:</strong> #${leave.user ? leave.user.id : ''}</div>
                <div><strong>Name:</strong> ${leave.user ? leave.user.name.toUpperCase() : ''}</div>
                <div><strong>Status:</strong> ${leave.status}</div>
                <div><strong>Type of Leave:</strong> ${(Array.isArray(leave.leave_type) ? leave.leave_type.join(', ') : (leave.leave_type ? JSON.parse(leave.leave_type).join(', ') : ''))}</div>
                ${leave.leave_type_other ? `<div><strong>Other Type:</strong> ${leave.leave_type_other}</div>` : ''}
                ${leave.within_ph ? `<div><strong>Within PH:</strong> ${leave.within_ph}</div>` : ''}
                ${leave.abroad ? `<div><strong>Abroad:</strong> ${leave.abroad}</div>` : ''}
                ${leave.in_hospital ? `<div><strong>In Hospital:</strong> ${leave.in_hospital}</div>` : ''}
                ${leave.out_patient ? `<div><strong>Out Patient:</strong> ${leave.out_patient}</div>` : ''}
                ${leave.special_leave ? `<div><strong>Special Leave:</strong> ${leave.special_leave}</div>` : ''}
                ${leave.study_leave ? `<div><strong>Study Leave:</strong> ${leave.study_leave}</div>` : ''}
                ${leave.other_purpose ? `<div><strong>Other Purpose:</strong> ${leave.other_purpose}</div>` : ''}
                ${leave.num_days ? `<div><strong>Number of Days:</strong> ${leave.num_days}</div>` : ''}
                ${leave.inclusive_dates ? `<div><strong>Inclusive Dates:</strong> ${leave.inclusive_dates}</div>` : ''}
                ${leave.commutation ? `<div><strong>Commutation:</strong> ${leave.commutation}</div>` : ''}
            `;

            // If certified, show certification data
            if (leave.status === 'Certified' && leave.certification_data) {
                let cert = {};
                try {
                    cert = typeof leave.certification_data === 'string'
                        ? JSON.parse(leave.certification_data)
                        : leave.certification_data;
                } catch (e) {}

                html += `
                    <hr style="margin:18px 0;">
                    <h3 style="margin-bottom:10px;">CERTIFICATION OF LEAVE CREDITS</h3>
                    <div style="display:flex; align-items:center; margin-bottom:10px;">
                        <span style="font-weight:500; margin-right:10px;">As of</span>
                        <span>${cert.as_of_date ? cert.as_of_date : '-'}</span>
                    </div>
                    <table style="width:100%; border-collapse:collapse; margin-bottom:18px;">
                        <tr>
                            <td></td>
                            <td style="text-align:center; font-weight:600;">Vacation Leave</td>
                            <td style="text-align:center; font-weight:600;">Sick Leave</td>
                        </tr>
                        <tr>
                            <td style="font-style:italic;">Total Earned</td>
                            <td style="text-align:center;">${cert.vl_earned ?? '-'}</td>
                            <td style="text-align:center;">${cert.sl_earned ?? '-'}</td>
                        </tr>
                        <tr>
                            <td style="font-style:italic;">Less this application</td>
                            <td style="text-align:center;">${cert.vl_less ?? '-'}</td>
                            <td style="text-align:center;">${cert.sl_less ?? '-'}</td>
                        </tr>
                        <tr>
                            <td style="font-style:italic;">Balance</td>
                            <td style="text-align:center;">${cert.vl_balance ?? '-'}</td>
                            <td style="text-align:center;">${cert.sl_balance ?? '-'}</td>
                        </tr>
                    </table>
                `;
            }

            document.getElementById('previewContent').innerHTML = html;
        }

        function closePreviewModal() {
            document.getElementById('previewModal').style.display = 'none';
        }

        // Handle certification form submission
        document.getElementById('certifyForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            let hasEmpty = false;
            ['vl_earned','sl_earned','vl_less','sl_less','vl_balance','sl_balance'].forEach(name => {
                if (!formData.get(name)) hasEmpty = true;
            });

            if (hasEmpty) {
                const proceed = confirm('Some fields are empty. Do you want to proceed and save anyway?');
                if (!proceed) return;
            }

            const data = {};
            formData.forEach((value, key) => data[key] = value);
            data.leave_id = editingLeaveId;

            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            try {
                const response = await fetch('/hr/certify-leave', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                
                if (response.ok) {
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
                    
                    // Remove the message after 3 seconds
                    setTimeout(() => {
                        successMessage.remove();
                    }, 3000);
                    
                    closePreviewModal();
                    
                    // Update the table and stats without full page reload
                    refreshDashboardData();
                } else {
                    const error = await response.json();
                    alert('Certification failed: ' + (error.message || JSON.stringify(error.errors)));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            }
        });

        // Function to refresh dashboard data
        function refreshDashboardData() {
            // First update the stats
            fetch('/hr/leave-stats', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Update the count elements
                document.querySelector('.stat-card:nth-child(1) .count').textContent = data.pending;
                document.querySelector('.stat-card:nth-child(2) .count').textContent = data.certified;
                document.querySelector('.stat-card:nth-child(3) .count').textContent = data.total;
                document.querySelector('.stat-card:nth-child(4) .count').textContent = data.recent;
            })
            .catch(error => console.error('Error fetching stats:', error));
            
            // Then refresh the table content
            fetch(window.location.href + '?_=' + new Date().getTime(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Create a temporary DOM element to parse the HTML
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Update the table content
                const newTableBody = doc.getElementById('leaveTableBody');
                if (newTableBody) {
                    document.getElementById('leaveTableBody').innerHTML = newTableBody.innerHTML;
                }
                
                // Update the leaveRequests variable for the modal
                const scriptContent = Array.from(doc.scripts).find(script => script.textContent.includes('leaveRequests = '));
                if (scriptContent) {
                    const match = scriptContent.textContent.match(/leaveRequests = (.*?);/);
                    if (match && match[1]) {
                        leaveRequests = JSON.parse(match[1]);
                    }
                }
                
                // Reapply any active filters
                const activeFilterBtn = document.querySelector('.filter-btn.active');
                if (activeFilterBtn) {
                    filterStatus({target: activeFilterBtn}, activeFilterBtn.getAttribute('data-status'));
                }
            })
            .catch(error => console.error('Error refreshing table data:', error));
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const filter = this.value.trim().toLowerCase();
            const rows = document.querySelectorAll('#leaveTableBody tr');
            rows.forEach(row => {
                if (!row.hasAttribute('data-id')) return; // Skip "no results" row
                
                const idCell = row.children[1]?.textContent.replace('#', '').toLowerCase() || '';
                const nameCell = row.children[2]?.textContent.toLowerCase() || '';
                if (idCell.includes(filter) || nameCell.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        function clearSearch() {
            document.getElementById('searchInput').value = '';
            const activeBtn = document.querySelector('.filter-btn.active');
            filterStatus({target: activeBtn}, activeBtn.getAttribute('data-status'));
        }

        function filterStatus(e, status) {
            // Set active button
            document.querySelectorAll('.filter-btn').forEach(btn => {
                if (btn.getAttribute('data-status') === status) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            // Get search filter
            const searchFilter = document.getElementById('searchInput').value.trim().toLowerCase();

            // Filter rows
            const rows = document.querySelectorAll('#leaveTableBody tr');
            let visibleCount = 0;
            
            rows.forEach(row => {
                if (!row.hasAttribute('data-id')) return; // Skip "no results" row
                
                const rowStatus = row.getAttribute('data-status') || '';
                const idCell = row.children[1]?.textContent.replace('#', '').toLowerCase() || '';
                const nameCell = row.children[2]?.textContent.toLowerCase() || '';
                const matchesStatus = (status === 'all') || (rowStatus === status);
                const matchesSearch = idCell.includes(searchFilter) || nameCell.includes(searchFilter);

                if (matchesStatus && matchesSearch) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Show "no results" message if needed
            let noResultsRow = document.querySelector('#noResultsRow');
            if (visibleCount === 0) {
                if (!noResultsRow) {
                    noResultsRow = document.createElement('tr');
                    noResultsRow.id = 'noResultsRow';
                    noResultsRow.innerHTML = `
                        <td colspan="5" style="text-align:center; padding:30px;">
                            <div style="color:#888; font-size:1.1em;">No matching leave requests found</div>
                            <button class="filter-btn" onclick="clearAllFilters()" style="margin-top:10px;">Clear All Filters</button>
                        </td>
                    `;
                    document.getElementById('leaveTableBody').appendChild(noResultsRow);
                }
            } else if (noResultsRow) {
                noResultsRow.remove();
            }
        }

        // Date filter functions
        function clearDateFilter() {
            document.getElementById('startDate').value = '';
            document.getElementById('endDate').value = '';
            document.getElementById('dateFilterForm').submit();
        }
        
        function clearAllFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('startDate').value = '';
            document.getElementById('endDate').value = '';
            
            const allButton = document.querySelector('.filter-btn[data-status="all"]');
            if (allButton) {
                document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
                allButton.classList.add('active');
                filterStatus({target: allButton}, 'all');
            }
            
            document.getElementById('dateFilterForm').submit();
        }
        
        // Table sorting
        function sortTable(columnIndex) {
            const table = document.querySelector('#leaveTableBody');
            const rows = Array.from(table.querySelectorAll('tr[data-id]'));
            
            // Determine sort direction
            if (currentSort.column === columnIndex) {
                currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
            } else {
                currentSort.column = columnIndex;
                currentSort.direction = 'asc';
            }
            
            // Sort the rows
            rows.sort((a, b) => {
                let valueA, valueB;
                
                if (columnIndex === 0) { // Date column
                    valueA = new Date(a.getAttribute('data-date'));
                    valueB = new Date(b.getAttribute('data-date'));
                } else {
                    valueA = a.children[columnIndex].textContent.trim().toLowerCase();
                    valueB = b.children[columnIndex].textContent.trim().toLowerCase();
                    
                    // If column 1 (ID), strip the # and convert to number
                    if (columnIndex === 1) {
                        valueA = parseInt(valueA.replace('#', ''));
                        valueB = parseInt(valueB.replace('#', ''));
                    }
                }
                
                if (valueA < valueB) return currentSort.direction === 'asc' ? -1 : 1;
                if (valueA > valueB) return currentSort.direction === 'asc' ? 1 : -1;
                return 0;
            });
            
            // Reorder the rows in the table
            rows.forEach(row => table.appendChild(row));
            
            // Update header indicators
            const headers = document.querySelectorAll('th');
            headers.forEach((header, index) => {
                const icon = header.querySelector('.material-icons');
                if (icon) {
                    if (index === columnIndex) {
                        icon.textContent = currentSort.direction === 'asc' ? 'arrow_downward' : 'arrow_upward';
                    } else {
                        icon.textContent = 'unfold_more';
                    }
                }
            });
        }
    </script>
</body>
</html>
