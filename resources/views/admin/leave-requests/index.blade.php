<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Logs (2025)</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', Arial, sans-serif;
            background: #f9f9e6;
            min-height: 100vh;
        }
        .sidebar {
            width: 240px;
            background: linear-gradient(to bottom, #03d081 0%, #e3d643 100%);
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
            margin: 0 0 10px 0;
            display: block;
        }
        .sidebar h2, .sidebar p {
            margin: 0;
            text-align: center;
            width: 100%;
        }
        .sidebar .dashboard-link {
            margin: 40px 0 0 0;
            font-size: 1.1em;
            color: #fff;
            background: #08bd72;
            padding: 8px 18px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            font-weight: 500;
            text-decoration: none;
            justify-content: center;
        }
        .sidebar .dashboard-link i {
            margin-right: 8px;
        }
        .sidebar .nav-menu {
            margin-top: 30px;
            width: 100%;
        }
        .sidebar .nav-menu a {
            display: block;
            padding: 14px 0 14px 40px;
            color: #fff;
            text-decoration: none;
            font-size: 1.1em;
            font-weight: 500;
            border-left: 4px solid transparent;
            transition: background 0.2s, border-color 0.2s;
        }
        .sidebar .nav-menu a.active,
        .sidebar .nav-menu a:hover {
            background: #eafbe7;
            color: #226d1b;
            border-left: 4px solid #226d1b;
        }
        .sidebar .logout {
            display: none;
        }
        .logout-icon-btn {
            background: none;
            border: none;
            color: #e53935;
            font-size: 1.7em;
            cursor: pointer;
            margin-left: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background 0.2s;
        }
        .logout-icon-btn:hover {
            background: #ffeaea;
        }
        .main-content {
            margin-left: 240px;
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
        /* --- Monthly Log Table Styles --- */
        .month-table-container {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            background: #fff;
            max-width: 800px;
            margin: 40px auto 0 auto;
            
        }
        .month-table-container table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Roboto', Arial, sans-serif;
            table-layout: fixed;
            
        }
        .month-table-container th, .month-table-container td {
            padding: 18px 18px;
            text-align: left;
        }
        .month-table-container td {
            width: 16.66%;
        }
        .month-table-container td.divider {
            border-left: 2px solid #e0e0e0;
            padding: 0;
            width: 0;
        }
        .month-table-container tbody tr {
            background: #fff;
            border-bottom: 1px solid #e0e0e0;
        }
        .month-table-container tbody tr:last-child {
            border-bottom: none;
        }
        .icon-cell {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .icon-star {
            color: #1ecb6b;
            font-size: 1.2em;
            vertical-align: middle;
        }
        .icon-edit {
            color: #1ecb6b;
            font-size: 1.3em;
            cursor: pointer;
            margin-left: 130%;
        }
        .icon-download {
            color: #4fc3f7;
            font-size: 1.3em;
            cursor: pointer;
        }
        .month-label {
            font-weight: bold;
            font-size: 1.08em;
            color:#816969;
        }
        .table-title {
            background: linear-gradient(to right, #09d07e );
            color: #fff;
            font-size: 1.1em;
            font-weight: 700;
            text-align: center;
            padding: 12px 0;
            letter-spacing: 1px;
        }
        /* Responsive styles for dashboard */
        @media (max-width: 1200px) {
            .dashboard-body {
                padding: 20px;
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
            .sidebar .nav-menu a {
                padding: 12px 0 12px 24px;
                font-size: 1em;
            }
        }
        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }
            .sidebar {
                transform: translateX(-100%);
                width: 240px;
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
        }
        @media (max-width: 576px) {
            .header-title {
                font-size: 1.5em;
            }
        }
        .material-icons.icon-edit, .material-icons.icon-download, .material-icons[style*="color:#388e3c"] {
            background: #eafbe7;
            border-radius: 50%;
            padding: 6px;
            font-size: 1.3em;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        /* Force header padding to match admin-dashboard */
        .header {
            padding: 24px 40px 0 40px !important;
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
        <a href="/admin/dashboard" class="dashboard-link">
            <span class="material-icons" style="margin-right:5px">account_circle</span>
            Admin Dashboard
        </a>
    </div>
    <div class="main-content">
        <div class="header">
            <div class="header-title">Leave Request Logs </div>
            <div class="profile">
                <div class="profile-icon">
                    <span class="material-icons">account_circle</span>
                </div>
                <div class="profile-info">
                    <span>{{ auth()->user()->name ?? 'Admin' }}</span>
                    <a href="#">#{{ auth()->user()->id ?? '0001' }}</a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button class="logout-icon-btn" title="Log Out" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="material-icons">exit_to_app</span>
                </button>
            </div>
        </div>
        <div style="height:5px;width:100%;background:linear-gradient(145deg,#00d082 0%,#fcb900 100%);margin-bottom:18px;margin-top:18px;"></div>
        <div class="dashboard-body">
            <div class="month-table-container">
                <div class="table-title">MONTHLY LOGS (2025)</div>
                <table>
                    <tbody>
                        <?php
                            $months = [
                                'January', 'February', 'March', 'April', 'May', 'June',
                                'July', 'August', 'September', 'October', 'November', 'December'
                            ];
                            $currentMonth = date('F');
                            $half = ceil(count($months) / 2);
                            $col1 = array_slice($months, 0, $half);
                            $col2 = array_slice($months, $half);
                        ?>
                        @for($i = 0; $i < $half; $i++)
                        <tr>
                            <td class="icon-cell">
                                @if(isset($col1[$i]))
                                    <span class="month-label">{{ $col1[$i] }}</span>
                                    @if($col1[$i] === $currentMonth)
                                        <span class="material-icons icon-star">star</span>
                                    @endif
                                @endif
                            </td>
                            <td style="text-align:center;">
                                @if(isset($col1[$i]))
                                    <span class="material-icons icon-edit" onclick="openEditModal('{{ $col1[$i] }}')">edit_square</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                @if(isset($col1[$i]))
                                    <span class="material-icons icon-download" onclick="downloadLeaveRequestExcel('{{ $col1[$i] }}')">download</span>
                                @endif
                            </td>
                            <td class="divider"></td>
                            <td class="icon-cell">
                                @if(isset($col2[$i]))
                                    <span class="month-label">{{ $col2[$i] }}</span>
                                    @if($col2[$i] === $currentMonth)
                                        <span class="material-icons icon-star">star</span>
                                    @endif
                                @endif
                            </td>
                            <td style="text-align:center;">
                                @if(isset($col2[$i]))
                                    <span class="material-icons icon-edit" onclick="openEditModal('{{ $col2[$i] }}')">edit_square</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                @if(isset($col2[$i]))
                                    <span class="material-icons icon-download" onclick="downloadLeaveRequestExcel('{{ $col2[$i] }}')">download</span>
                                @endif
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Leave Edit Modal -->
        <div id="editLeaveModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.25); z-index:3000; align-items:center; justify-content:center;">
            <div style="background:#fff; border-radius:16px; width:min(98vw,1200px); max-height:92vh; overflow-y:auto; margin:auto; padding:20px 10px 10px 10px; box-shadow:0 8px 32px rgba(0,0,0,0.15); position:relative;">
                <h2 id="editLeaveModalTitle" style="text-align:center; margin-bottom:24px; font-size:1.3em; letter-spacing:1px;">Edit Leave Requests for <span id="editLeaveMonth"></span></h2>
                <form id="editLeaveForm">
                    <div style="overflow-x:auto;">
                        <table style="width:auto; min-width:100%; border-collapse:collapse; table-layout:auto;">
                            <thead>
                                <tr style="background:linear-gradient(to right,#43a047 0%,#1ecb6b 100%); color:#fff;">
                                    <th style="padding:14px 18px; min-width:120px;">DATE RECEIVED</th>
                                    <th style="padding:14px 18px; min-width:140px;">LN CODE</th>
                                    <th style="padding:14px 18px; min-width:90px;">LEAVE NUMBER</th>
                                    <th style="padding:14px 18px; min-width:120px;">PARTICULAR</th>
                                    <th style="padding:14px 18px; min-width:150px;">TYPE OF LEAVE</th>
                                    <th style="padding:14px 18px; min-width:60px;">CODE</th>
                                    <th style="padding:14px 18px; min-width:120px;">NAME</th>
                                   
                                </tr>
                            </thead>
                            <tbody id="editLeaveTableBody">
                                <!-- Rows will be dynamically inserted here -->
                            </tbody>
                        </table>
                    </div>
                    <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:24px;">
                        <button type="button" onclick="closeEditModal()" style="background:#888; color:#fff; border:none; border-radius:8px; padding:8px 18px; font-size:1em; font-weight:600; cursor:pointer;">Cancel</button>
                        <button type="submit" style="background:#1ecb6b; color:#fff; border:none; border-radius:8px; padding:8px 22px; font-size:1em; font-weight:600; cursor:pointer;">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
        // Menu toggle for mobile
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
        // Modal logic for editing leave requests by month
        function openEditModal(month) {
            var monthSpan = document.getElementById('editLeaveMonth');
            if (monthSpan) monthSpan.textContent = month;
            var modalTitle = document.getElementById('editLeaveModalTitle');
            if (modalTitle) modalTitle.textContent = 'Edit Leave Requests for ' + month;
            fetch(`/admin/leave-requests/by-month?month="${month}"`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (Array.isArray(data) && data.length > 0) {
                    document.getElementById('editLeaveTableBody').innerHTML = data.map((lr, idx) => `
                        <tr data-id="${lr.leave_number}">
                            <td style="padding:12px 18px;">
                                <div class="date-received-cell" style="display:flex;align-items:center;gap:8px;">
                                    
                                    
                                    <button type="button" class="calendar-btn" style="background:none;border:none;cursor:pointer;padding:0;margin-left:4px;" onclick="showDateInput(this)">
                                        <span class="material-icons" style="color:#388e3c;">edit_calendar</span>
                                    </button>
                                    <input type="text" class="date-received-input" value="${lr.date_received}" style="display:none;width:110px;margin-left:6px;" />
                                    <button type="button" class="save-date-btn" style="display:none;margin-left:2px;background:#1ecb6b;color:#fff;border:none;border-radius:4px;padding:2px 8px;font-size:0.95em;cursor:pointer;">Save</button>
                                    <span class="date-received-text" style="font-size:1em; font-family:inherit; color:#222;">${lr.date_received}</span>
                                </div>
                            </td>
                            <td style="padding:12px 18px;">${lr.ln_code}</td>
                            <td style="padding:12px 18px;">${lr.leave_number}</td>
                            <td style="padding:12px 18px;">${lr.particular}</td>
                            <td style="padding:12px 18px;">
                                <div style="display:flex;align-items:center;gap:6px;">
                                    <select class="form-input type-of-leave-select" style="width:170px;">
                                        <option value="Vacation Leave" ${lr.type_of_leave === 'Vacation Leave' ? 'selected' : ''}>Vacation Leave</option>
                                        <option value="Mandatory/Forced Leave" ${lr.type_of_leave === 'Mandatory/Forced Leave' ? 'selected' : ''}>Mandatory/Forced Leave</option>
                                        <option value="Sick Leave" ${lr.type_of_leave === 'Sick Leave' ? 'selected' : ''}>Sick Leave</option>
                                        <option value="Maternity Leave" ${lr.type_of_leave === 'Maternity Leave' ? 'selected' : ''}>Maternity Leave</option>
                                        <option value="Paternity Leave" ${lr.type_of_leave === 'Paternity Leave' ? 'selected' : ''}>Paternity Leave</option>
                                        <option value="Special Privilege Leave" ${lr.type_of_leave === 'Special Privilege Leave' ? 'selected' : ''}>Special Privilege Leave</option>
                                        <option value="Solo Parent Leave" ${lr.type_of_leave === 'Solo Parent Leave' ? 'selected' : ''}>Solo Parent Leave</option>
                                        <option value="Study Leave" ${lr.type_of_leave === 'Study Leave' ? 'selected' : ''}>Study Leave</option>
                                        <option value="10-Day VAWC Leave" ${lr.type_of_leave === '10-Day VAWC Leave' ? 'selected' : ''}>10-Day VAWC Leave</option>
                                        <option value="Rehabilitation Privilege" ${lr.type_of_leave === 'Rehabilitation Privilege' ? 'selected' : ''}>Rehabilitation Privilege</option>
                                        <option value="Special Leave Benefits for Women" ${lr.type_of_leave === 'Special Leave Benefits for Women' ? 'selected' : ''}>Special Leave Benefits for Women</option>
                                        <option value="Special Emergency (Calamity) Leave" ${lr.type_of_leave === 'Special Emergency (Calamity) Leave' ? 'selected' : ''}>Special Emergency (Calamity) Leave</option>
                                        <option value="Adoption Leave" ${lr.type_of_leave === 'Adoption Leave' ? 'selected' : ''}>Adoption Leave</option>
                                        <option value="Others" ${lr.type_of_leave === 'Others' ? 'selected' : ''}>Others</option>
                                    </select>
                                    <button type="button" class="save-type-btn" style="display:none;margin-left:2px;background:#1ecb6b;color:#fff;border:none;border-radius:4px;padding:2px 8px;font-size:0.95em;cursor:pointer;">Save</button>
                                </div>
                            </td>
                            <td style="padding:12px 18px;">${lr.code}</td>
                            <td style="padding:12px 18px;">${lr.name}</td>
                            <td style="text-align:center; padding:12px 18px;"></td>
                        </tr>
                    `).join('');
                } else {
                    document.getElementById('editLeaveTableBody').innerHTML = '<tr><td colspan="8" style="text-align:center; color:#888;">No certified leave requests for this month.</td></tr>';
                }
                document.getElementById('editLeaveModal').style.display = 'flex';
            })
            .catch(() => {
                document.getElementById('editLeaveTableBody').innerHTML = '<tr><td colspan="8" style="text-align:center; color:#e53935;">Error loading data.</td></tr>';
                document.getElementById('editLeaveModal').style.display = 'flex';
            });
        }
        function closeEditModal() {
            document.getElementById('editLeaveModal').style.display = 'none';
            // Clear modal table body to prevent stale DOM issues
            var tbody = document.getElementById('editLeaveTableBody');
            if (tbody) tbody.innerHTML = '';
        }
        // Save handler (AJAX stub)
        document.getElementById('editLeaveForm').onsubmit = function(e) {
            e.preventDefault();
            // Collect all changed type of leave values
            const rows = document.querySelectorAll('#editLeaveTableBody tr');
            const updates = [];
            rows.forEach(row => {
                const id = row.getAttribute('data-id');
                const select = row.querySelector('.type-of-leave-select');
                if (select) {
                    updates.push({
                        id: id,
                        leave_type: select.value
                    });
                }
            });
            if (updates.length === 0) {
                closeEditModal();
                return;
            }
            // Show loading state
            const saveBtn = document.querySelector('#editLeaveForm button[type="submit"]');
            const originalBtnText = saveBtn.innerHTML;
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<span class="material-icons">hourglass_top</span> Saving...';
            // Send updates one by one (could be optimized to batch)
            let completed = 0;
            updates.forEach(update => {
                fetch(`/admin/leave-requests/${update.id}/update-type`, {
                    method: 'POST', // Use POST to match the route definition
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ leave_type: update.leave_type })
                })
                .then(response => response.json())
                .then(data => {
                    // Update columns in the modal for this row
                    const row = document.querySelector(`#editLeaveTableBody tr[data-id='${update.id}']`);
                    if (row && data.success) {
                        row.querySelector('.type-of-leave-select').value = data.type_of_leave;
                        row.querySelectorAll('td')[5].textContent = data.code;
                        row.querySelectorAll('td')[1].textContent = data.ln_code;
                    }
                })
                .catch(() => {})
                .finally(() => {
                    completed++;
                    if (completed === updates.length) {
                        saveBtn.disabled = false;
                        saveBtn.innerHTML = originalBtnText;
                        closeEditModal();
                    }
                });
            });
        };
        // --- Calendar button logic for Date Received ---
        function showDateInput(btn) {
            const cell = btn.closest('.date-received-cell');
            const text = cell.querySelector('.date-received-text');
            const input = cell.querySelector('.date-received-input');
            const saveBtn = cell.querySelector('.save-date-btn');
            if (text && input && saveBtn) {
                // Always show calendar button and text
                // Input is visually hidden but present
                // Convert display date (e.g., 27-Jun-25) to ISO (YYYY-MM-DD) for flatpickr
                let isoDate = '';
                if (input.value && !/^\d{4}-\d{2}-\d{2}$/.test(input.value)) {
                    // Try to parse DD-MMM-YY to YYYY-MM-DD
                    const parts = input.value.match(/(\d{1,2})-(\w{3})-(\d{2,4})/);
                    if (parts) {
                        const day = parts[1].padStart(2, '0');
                        const monthStr = parts[2];
                        const year = parts[3].length === 2 ? '20' + parts[3] : parts[3];
                        const months = {
                            Jan: '01', Feb: '02', Mar: '03', Apr: '04', May: '05', Jun: '06',
                            Jul: '07', Aug: '08', Sep: '09', Oct: '10', Nov: '11', Dec: '12'
                        };
                        const month = months[monthStr] || '01';
                        isoDate = `${year}-${month}-${day}`;
                    }
                } else {
                    isoDate = input.value;
                }
                // Initialize flatpickr if not already
                if (!input._flatpickr) {
                    flatpickr(input, {
                        dateFormat: 'Y-m-d',
                        defaultDate: isoDate || undefined,
                        allowInput: false,
                        clickOpens: true,
                        onChange: function(selectedDates, dateStr, instance) {
                            if (selectedDates.length) {
                                input.value = dateStr;
                                saveBtn.style.display = 'inline-block';
                            }
                        }
                    });
                }
                input._flatpickr.open();
            }
        }
        // Save date button logic
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('save-date-btn')) {
                const cell = e.target.closest('.date-received-cell');
                const input = cell.querySelector('.date-received-input');
                const text = cell.querySelector('.date-received-text');
                const calendarBtn = cell.querySelector('.calendar-btn');
                const tr = e.target.closest('tr');
                const id = tr.getAttribute('data-id');
                const newDate = input.value;
                // AJAX update for date_received
                fetch(`/admin/leave-requests/${id}/update-fields`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ date_received: newDate })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && text) {
                        text.textContent = data.date_received;
                        input.value = data.date_received;
                    }
                })
                .finally(() => {
                    input.style.display = 'none';
                    e.target.style.display = 'none';
                    if (text) text.style.display = 'inline-block';
                    if (calendarBtn) calendarBtn.style.display = 'inline-block';
                });
            }
        });
        // Add JS for type-of-leave save button
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('type-of-leave-select')) {
                const row = e.target.closest('tr');
                const saveBtn = row.querySelector('.save-type-btn');
                if (saveBtn) saveBtn.style.display = 'inline-block';
            }
        });
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('save-type-btn')) {
                const row = e.target.closest('tr');
                const select = row.querySelector('.type-of-leave-select');
                const id = row.getAttribute('data-id');
                const saveBtn = e.target;
                saveBtn.disabled = true;
                saveBtn.innerHTML = '<span class="material-icons" style="font-size:1em;vertical-align:middle;">hourglass_top</span>';
                fetch(`/admin/leave-requests/${id}/update-type`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ leave_type: select.value })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        select.value = data.type_of_leave;
                        row.querySelectorAll('td')[5].textContent = data.code;
                        row.querySelectorAll('td')[1].textContent = data.ln_code;
                    }
                })
                .finally(() => {
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = 'Save';
                    saveBtn.style.display = 'none';
                });
            }
        });
        function downloadLeaveRequestExcel(month) {
            const url = `/admin/leave-requests/export-month?month=${encodeURIComponent(month)}`;
            window.location.href = url;
        }
        </script>
    </div>
</body>
</html>
