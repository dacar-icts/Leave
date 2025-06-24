<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
</head>
<body>
    <div class="sidebar">
        <img src="https://i.ibb.co/6bQw4yT/da-logo.png" alt="Department of Agriculture Logo">
        <h2>Department of<br>Agriculture</h2>
        <p>1960</p>
        <a href="#" class="dashboard-link">
            <span class="material-icons">dashboard</span>
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
            </div>
            <div style="display:flex; align-items:center; justify-content:flex-end; gap:12px; margin-bottom:16px; margin-top:-10px;">
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
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>DATE</th>
                            <th>ID #</th>
                            <th>NAME</th>
                            <th>STATUS</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="leaveTableBody">
                        @foreach($leaveRequests as $leave)
                        <tr>
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
                <div style="display:flex; align-items:center; margin-bottom:10px;">
                    <span style="font-weight:500; margin-right:10px;">As of</span>
                    <input type="date" name="as_of_date" required style="padding:4px 8px; border-radius:6px; border:1px solid #ccc;">
                </div>
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
                <div style="display:flex; justify-content:flex-end; gap:18px;">
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
                alert('Leave request certified!');
                closePreviewModal();
                window.location.reload();
            } else {
                const error = await response.json();
                alert('Certification failed: ' + (error.message || JSON.stringify(error.errors)));
            }
        });

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const filter = this.value.trim().toLowerCase();
            const rows = document.querySelectorAll('#leaveTableBody tr');
            rows.forEach(row => {
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
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            e.target.classList.add('active');

            // Get search filter
            const searchFilter = document.getElementById('searchInput').value.trim().toLowerCase();

            // Filter rows
            const rows = document.querySelectorAll('#leaveTableBody tr');
            rows.forEach(row => {
                const statusCell = row.children[3]?.textContent.trim().toLowerCase() || '';
                const idCell = row.children[1]?.textContent.replace('#', '').toLowerCase() || '';
                const nameCell = row.children[2]?.textContent.toLowerCase() || '';
                const matchesStatus = (status === 'all') ||
                    (status === 'Pending' && statusCell.includes('pending')) ||
                    (status === 'Certified' && statusCell.includes('certified'));
                const matchesSearch = idCell.includes(searchFilter) || nameCell.includes(searchFilter);

                if (matchesStatus && matchesSearch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Update filter when searching
        document.getElementById('searchInput').addEventListener('input', function() {
            const activeBtn = document.querySelector('.filter-btn.active');
            filterStatus({target: activeBtn}, activeBtn.getAttribute('data-status'));
        });
    </script>
</body>
</html>
