<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HR Dashboard</title>
    
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/hr-dashboard.css') }}">
    
    <!-- Mobile fixes -->
    <script src="{{ asset('js/mobile-fix.js') }}"></script>
    
    <style>
        body {
            background-color: #f9f9e6;
            font-family: 'Roboto', Arial, sans-serif;
        }
        
        .sidebar {
            background: linear-gradient(to bottom, #00a651 0%, #8dc63f 100%);
        }
        
        .header-title {
            font-size: 2.2em;
            font-weight: 600;
            color: #333;
        }
        
        .stats-row {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            min-width: 180px;
        }
        
        .stat-card .icon {
            font-size: 2.2em;
            margin-bottom: 10px;
        }
        
        .stat-card .count {
            font-size: 2.5em;
            font-weight: 700;
        }
        
        .stat-card .label {
            font-size: 0.9em;
            color: #666;
            margin-top: 5px;
            text-align: center;
        }
        
        .filters-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .date-range {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .date-range input[type="date"] {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 8px 12px;
        }
        
        .filter-group {
            display: flex;
            gap: 8px;
        }
        
        .filter-btn {
            background: #fff;
            border: 1px solid #00a651;
            color: #00a651;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .filter-btn.active {
            background: #00a651;
            color: #fff;
        }
        
        .search-bar {
            display: flex;
            align-items: center;
            background: #fff;
            border-radius: 20px;
            padding: 5px 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .search-bar input {
            border: none;
            padding: 8px;
            font-size: 0.9em;
            outline: none;
            width: 200px;
        }
        
        .table-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            overflow: hidden;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background-color: #00a651;
            color: white;
        }
        
        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        
        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .status-pending {
            color: #f44336;
            font-weight: 600;
        }
        
        .status-certified {
            color: #00a651;
            font-weight: 600;
        }
        
        .icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: #00a651;
            margin-right: 5px;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.2s;
        }
        
        .icon-btn:hover {
            background-color: rgba(0, 166, 81, 0.1);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f1f1f1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .user-details {
            text-align: right;
        }
        
        .user-name {
            font-weight: 600;
            color: #333;
        }
        
        .user-id {
            color: #00a651;
            font-size: 0.8em;
        }
        
        @media (max-width: 768px) {
            .stats-row {
                flex-direction: column;
                gap: 15px;
            }
            
            .filters-container {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .search-bar {
                width: 100%;
            }
            
            .search-bar input {
                width: 100%;
            }
        }
    </style>
</head>
<body ontouchstart="">
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
                Leave Request Logs
            </div>
            <div class="user-info">
                <div class="user-details">
                    <div class="user-name">{{ strtoupper(auth()->user()->name) }}</div>
                    <div class="user-id">#{{ auth()->user()->id }}</div>
                </div>
                <div class="user-avatar">
                    <span class="material-icons">account_circle</span>
                </div>
            </div>
        </div>
        <div class="dashboard-body">
            <div class="stats-row">
                <div class="stat-card">
                    <span class="material-icons icon" style="color:#777;">schedule</span>
                    <div class="count" style="color:#e53935;">{{ $pendingCount }}</div>
                    <div class="label">Pending Certification</div>
                </div>
                <div class="stat-card">
                    <span class="material-icons icon" style="color:#00a651;">check_circle</span>
                    <div class="count" style="color:#00a651;">{{ $certifiedCount }}</div>
                    <div class="label">HR Certified</div>
                </div>
                <div class="stat-card">
                    <span class="material-icons icon" style="color:#2196f3;">insights</span>
                    <div class="count" style="color:#2196f3;">{{ $totalRequests }}</div>
                    <div class="label">Total Requests</div>
                </div>
            </div>
            
            <div class="filters-container">
                <div class="date-range">
                    <form id="dateFilterForm" style="display:flex; gap:10px; align-items:center;">
                        <label style="font-weight:500;">Date Range:</label>
                        <input type="date" name="start_date" id="startDate" value="{{ request('start_date') }}">
                        <span>to</span>
                        <input type="date" name="end_date" id="endDate" value="{{ request('end_date') }}">
                        <button type="submit" class="filter-btn" style="background:#00a651; color:#fff;">Apply</button>
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
        
        <div class="wave-container">
            <div class="wave wave-1"></div>
            <div class="wave wave-2"></div>
            <div class="wave wave-3"></div>
        </div>
    </div>

    <!-- Leave Request Preview/Certification Modal -->
    <div id="previewModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.25); z-index:2000; align-items:center; justify-content:center; overflow-y:auto; -webkit-overflow-scrolling:touch;">
        <div style="background:#fff; border-radius:16px; max-width:520px; width:95%; max-height:90vh; overflow-y:auto; margin:20px auto; padding:28px 22px 20px 22px; box-shadow:0 8px 32px rgba(0,0,0,0.15); position:relative;">
            <h2 style="text-align:center; margin-bottom:18px; font-size:1.3em; letter-spacing:1px;">Leave Request Preview</h2>
            <div id="previewContent"></div>
            <form id="certifyForm" style="display:none; margin-top:32px;">
                <div style="border:1px solid #000; margin-top:20px; font-family: Arial, sans-serif;">
                    <table style="width:100%; border-collapse:collapse; border-bottom:1px solid #000;">
                        <tr>
                            <td style="border-right:1px solid #000; width:50%; padding:8px; text-align:center; font-weight:bold; background-color:#f2f2f2;">
                                7.A CERTIFICATION OF LEAVE CREDITS
                            </td>
                            <td style="padding:8px; text-align:center; font-weight:bold; background-color:#f2f2f2;">
                                7.B RECOMMENDATION
                            </td>
                        </tr>
                    </table>
                    
                    <table style="width:100%; border-collapse:collapse;">
                        <tr>
                            <td style="border-right:1px solid #000; width:50%; padding:8px; vertical-align:top;">
                                <div style="text-align:center; margin-bottom:10px;">
                                    As of <input type="date" name="as_of_date" required style="width:150px; border:none; border-bottom:1px solid #000; text-align:center;">
                                </div>
                                <table style="width:100%; border-collapse:collapse;">
                                    <tr>
                                        <th style="border:1px solid #000; padding:5px; background-color:#f9f9f9;"></th>
                                        <th style="border:1px solid #000; padding:5px; text-align:center; background-color:#f9f9f9;">Vacation Leave</th>
                                        <th style="border:1px solid #000; padding:5px; text-align:center; background-color:#f9f9f9;">Sick Leave</th>
                                    </tr>
                                    <tr>
                                        <td style="border:1px solid #000; padding:5px; font-style:italic;">Total Earned</td>
                                        <td style="border:1px solid #000; padding:5px; text-align:center;">
                                            <input type="text" name="vl_earned" style="width:90%; border:none; text-align:center;">
                                        </td>
                                        <td style="border:1px solid #000; padding:5px; text-align:center;">
                                            <input type="text" name="sl_earned" style="width:90%; border:none; text-align:center;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border:1px solid #000; padding:5px; font-style:italic;">Less this application</td>
                                        <td style="border:1px solid #000; padding:5px; text-align:center;">
                                            <input type="text" name="vl_less" style="width:90%; border:none; text-align:center;">
                                        </td>
                                        <td style="border:1px solid #000; padding:5px; text-align:center;">
                                            <input type="text" name="sl_less" style="width:90%; border:none; text-align:center;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border:1px solid #000; padding:5px; font-style:italic;">Balance</td>
                                        <td style="border:1px solid #000; padding:5px; text-align:center;">
                                            <input type="text" name="vl_balance" style="width:90%; border:none; text-align:center;">
                                        </td>
                                        <td style="border:1px solid #000; padding:5px; text-align:center;">
                                            <input type="text" name="sl_balance" style="width:90%; border:none; text-align:center;">
                                        </td>
                                    </tr>
                                </table>
                                <div style="text-align:center; margin-top:20px; padding:8px; border-top:1px solid #000; color:#006400; font-weight:bold;">
                                    JOY ROSE C. BAWAYAN
                                </div>
                                <div style="text-align:center; font-size:0.9em;">
                                    Administrative Officer V (HRMO III)
                                </div>
                            </td>
                            <td style="vertical-align:top; padding:8px;">
                                <div style="margin-bottom:10px;">
                                    <input type="checkbox" id="recommendation_approval" name="recommendation" value="approval">
                                    <label for="recommendation_approval">For approval</label>
                                </div>
                                <div style="margin-bottom:10px;">
                                    <input type="checkbox" id="recommendation_disapproval" name="recommendation" value="disapproval">
                                    <label for="recommendation_disapproval">For disapproval due to</label>
                                    <input type="text" name="disapproval_reason" style="width:100%; border:none; border-bottom:1px solid #000;">
                                </div>
                                <div style="margin-top:10px;">
                                    <input type="text" name="other_remarks" style="width:100%; border:none; border-bottom:1px solid #000; margin-bottom:5px;">
                                    <input type="text" name="other_remarks2" style="width:100%; border:none; border-bottom:1px solid #000; margin-bottom:5px;">
                                    <input type="text" name="other_remarks3" style="width:100%; border:none; border-bottom:1px solid #000;">
                                </div>
                                <div style="text-align:center; margin-top:20px; padding:8px; border-top:1px solid #000; color:#006400; font-weight:bold;">
                                    AIDA Y. PAGTAN
                                </div>
                                <div style="text-align:center; font-size:0.9em;">
                                    Chief, Administrative and Finance Division
                                </div>
                            </td>
                        </tr>
                    </table>
                    
                    <table style="width:100%; border-collapse:collapse; border-top:1px solid #000;">
                        <tr>
                            <td style="border-right:1px solid #000; width:50%; padding:8px; text-align:center; font-weight:bold; background-color:#f2f2f2;">
                                7.C APPROVED FOR:
                            </td>
                            <td style="padding:8px; text-align:center; font-weight:bold; background-color:#f2f2f2;">
                                7.D DISAPPROVED DUE TO:
                            </td>
                        </tr>
                    </table>
                    
                    <table style="width:100%; border-collapse:collapse;">
                        <tr>
                            <td style="border-right:1px solid #000; width:50%; padding:8px; vertical-align:top;">
                                <div style="margin-bottom:5px;">
                                    <input type="text" name="days_with_pay" style="width:30px; border:none; border-bottom:1px solid #000; text-align:center;"> days with pay
                                </div>
                                <div style="margin-bottom:5px;">
                                    <input type="text" name="days_without_pay" style="width:30px; border:none; border-bottom:1px solid #000; text-align:center;"> days without pay
                                </div>
                                <div style="margin-bottom:5px;">
                                    <input type="text" name="others_specify" style="width:30px; border:none; border-bottom:1px solid #000; text-align:center;"> others (Specify)
                                </div>
                            </td>
                            <td style="vertical-align:top; padding:8px;">
                                <div style="margin-bottom:5px;">
                                    <input type="text" name="disapproval_reason1" style="width:100%; border:none; border-bottom:1px solid #000;">
                                </div>
                                <div style="margin-bottom:5px;">
                                    <input type="text" name="disapproval_reason2" style="width:100%; border:none; border-bottom:1px solid #000;">
                                </div>
                            </td>
                        </tr>
                    </table>
                    
                    <div style="text-align:center; margin-top:30px; padding:10px;">
                        <div style="font-weight:bold; color:#006400;">
                            Atty. JENNILYN M. DAWAYAN, CESO IV
                        </div>
                        <div style="font-size:0.9em;">
                            Regional Executive Director
                        </div>
                    </div>
                </div>
                
                <input type="hidden" name="leave_id" id="leave_id">
                
                <div style="display:flex; justify-content:flex-end; margin-top:20px; gap:18px; flex-wrap:wrap;">
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
            document.getElementById('leave_id').value = id; // Set the leave ID in the hidden field
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
                        <span>${cert.as_of_date ? new Date(cert.as_of_date).toLocaleDateString() : '-'}</span>
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
                    
                    <h3 style="margin-bottom:10px; margin-top:20px;">RECOMMENDATION</h3>
                    <div style="margin-bottom:5px;">
                        <input type="checkbox" ${cert.recommendation === 'approval' ? 'checked' : ''} disabled>
                        <label>For approval</label>
                    </div>
                    <div style="margin-bottom:5px;">
                        <input type="checkbox" ${cert.recommendation === 'disapproval' ? 'checked' : ''} disabled>
                        <label>For disapproval due to: ${cert.disapproval_reason || ''}</label>
                    </div>
                    
                    ${cert.other_remarks ? `<div>${cert.other_remarks}</div>` : ''}
                    ${cert.other_remarks2 ? `<div>${cert.other_remarks2}</div>` : ''}
                    ${cert.other_remarks3 ? `<div>${cert.other_remarks3}</div>` : ''}
                    
                    <h3 style="margin-bottom:10px; margin-top:20px;">APPROVAL DETAILS</h3>
                    <div style="margin-bottom:5px;">${cert.days_with_pay || '___'} days with pay</div>
                    <div style="margin-bottom:5px;">${cert.days_without_pay || '___'} days without pay</div>
                    <div style="margin-bottom:5px;">${cert.others_specify || '___'} others (Specify)</div>
                    
                    ${cert.disapproval_reason1 ? `<div><strong>Disapproved due to:</strong> ${cert.disapproval_reason1}</div>` : ''}
                    ${cert.disapproval_reason2 ? `<div>${cert.disapproval_reason2}</div>` : ''}
                `;
            }

            document.getElementById('previewContent').innerHTML = html;
        }

        function showPreviewModal(id) {
            const modal = document.getElementById('previewModal');
            
            // Add body overflow control for better mobile experience
            document.body.style.overflow = 'hidden';
            
            // Show the modal
            modal.style.display = 'flex';
            
            // Now load and display the leave request
            renderPreviewModal(id);
        }
        
        function closePreviewModal() {
            const modal = document.getElementById('previewModal');
            modal.style.display = 'none';
            
            // Restore body scrolling
            document.body.style.overflow = '';
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
