<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📝Leave Request Logs🌿</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/admin-requests.css">
</head>
<body>
    <button class="menu-toggle" id="menuToggle">
        <span class="material-icons">menu</span>
    </button>
    <div class="sidebar" id="sidebar">
    <div class="falling-leaves">
            <span class="leaf material-icons">eco</span>
            <span class="leaf material-icons">eco</span>
            <span class="leaf material-icons">eco</span>
            <span class="leaf material-icons">eco</span>
        </div>
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Department_of_Agriculture_of_the_Philippines.svg/1200px-Department_of_Agriculture_of_the_Philippines.svg.png" alt="Department of Agriculture Logo">
        <h2>Department of<br>Agriculture</h2>
        <p>1960</p>
        <a href="/admin/dashboard" class="dashboard-link">
            <span>🛡️</span>
            Admin Dashboard
        </a>
        <a href="/admin/leave-requests" class="dashboard-link">
            <span>✅</span>
            Leave Requests
        </a>
    </div>
    <div class="main-content">
        <div class="header">
            <a href="javascript:history.back()" onclick="if(document.referrer===''){window.location.href='{{ route('dashboard') }}';return false;}" style="display:flex;align-items:center;padding:8px 16px;background:#f0f0f0;color:#333;border:1px solid #ddd;border-radius:4px;text-decoration:none;font-weight:500;margin-right:18px;">
                <span style="margin-right:5px;">⬅️</span>
                Back
            </a>
            
            <div class="header-title">📝 Leave Request Logs 🌿</div>
            <div class="profile-card">
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
                    <span class="material-icons">logout</span>
                </button>
            </div>
        </div>
        
        <div style="height:5px;width:100%;background: linear-gradient(to right, var(--primary-green) 0%, var(--accent-green) 100%);;margin-bottom:18px;margin-top:18px;"></div>
        <!-- Yearly Requests Bar Graph -->
        <!-- <div style="background:#fff; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.07); padding:30px 40px; margin-bottom:10px; max-width:700px; margin-left:auto; margin-right:auto;">
                <h3 style="margin-bottom:10px; text-align:center; color:#1976d2;">Yearly Leave Requests (Last 5 Years)</h3>
                <canvas id="yearlyRequestsChart" height="100"></canvas>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var ctx = document.getElementById('yearlyRequestsChart').getContext('2d');
                    var yearlyChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: @json($yearlyRequestGraphData['years'] ?? []),
                            datasets: [{
                                label: 'Total Requests',
                                data: @json($yearlyRequestGraphData['counts'] ?? []),
                                backgroundColor: 'rgba(25, 118, 210, 0.7)',
                                borderColor: 'rgba(25, 118, 210, 1)',
                                borderWidth: 2,
                                borderRadius: 6,
                                maxBarThickness: 50,
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { display: false },
                                title: { display: false }
                            },
                            scales: {
                                x: {
                                    grid: { display: false },
                                    title: { display: true, text: 'Year' }
                                },
                                y: {
                                    beginAtZero: true,
                                    title: { display: true, text: 'Requests' },
                                    ticks: { stepSize: 1 }
                                }
                            }
                        }
                    });
                });
            </script> -->
        <div class="dashboard-body">
            <!-- Delete Previous Year Button -->
            <button id="deletePrevYearBtn" style="background:#e53935; color:#fff; border:none; border-radius:8px; padding:10px 22px; font-size:1em; font-weight:600; cursor:pointer; margin-bottom:20px; display:flex; align-items:center; gap:8px;">
                <span>🗑️</span>
                Delete All Leave Requests for {{ $previousYear }}
            </button>
            <!-- Yearly Request Stats Card -->
            <div style="display:flex; gap:30px; margin-bottom:30px; flex-wrap:wrap;">
                <!-- Existing Monthly Request Stats Cards -->
                <div style="background:#fff; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.07); padding:25px 40px; display:flex; flex-direction:column; align-items:center; min-width:220px; flex:1;">
                    <span style="font-size:2.5em; margin-bottom:10px; color:#1ecb6b;">📅</span>
                    <div id="currentMonthCount" style="font-size:2em; font-weight:700; color:#222;">{{ $currentMonthCount ?? 0 }}</div>
                    <div style="font-size:1em; color:#888; margin-top:4px; text-align:center;">Current Month Total Requests</div>
                </div>
                <div style="background:#fff; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.07); padding:25px 40px; display:flex; flex-direction:column; align-items:center; min-width:220px; flex:1;">
                    <span style="font-size:2.5em; margin-bottom:10px; color:#ff9800;">📊</span>
                    <div id="yearTotalCount" style="font-size:2em; font-weight:700; color:#222;">{{ $yearTotalCount ?? 0 }}</div>
                    <div style="font-size:1em; color:#888; margin-top:4px; text-align:center;">Total Requests for the Year</div>
                </div>
            </div>

            
            
            <div class="month-table-container">
                <div class="table-title">🗓️ MONTHLY LOGS ({{ $currentYear }})</div>
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
                                        <span style="font-size:1.2em;vertical-align:middle;">🌿</span>
                                    @endif
                                @endif
                            </td>
                            <td style="text-align:center;">
                                @if(isset($col1[$i]))
                                    <span class="emoji-bg emoji-edit" style="font-size:1.3em;cursor:pointer;margin-left:130%;" onclick="openEditModal('{{ $col1[$i] }}')">✏️</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                @if(isset($col1[$i]))
                                    <span class="emoji-bg emoji-download" style="font-size:1.3em;cursor:pointer;" onclick="downloadLeaveRequestExcel('{{ $col1[$i] }}')">⬇️</span>
                                @endif
                            </td>
                            <td class="divider"></td>
                            <td class="icon-cell">
                                @if(isset($col2[$i]))
                                    <span class="month-label">{{ $col2[$i] }}</span>
                                    @if($col2[$i] === $currentMonth)
                                        <span style="font-size:1.2em;vertical-align:middle;">🌳</span>
                                    @endif
                                @endif
                            </td>
                            <td style="text-align:center;">
                                @if(isset($col2[$i]))
                                    <span class="emoji-bg emoji-edit" style="font-size:1.3em;cursor:pointer;margin-left:130%;" onclick="openEditModal('{{ $col2[$i] }}')">✏️</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                @if(isset($col2[$i]))
                                    <span class="emoji-bg emoji-download" style="font-size:1.3em;cursor:pointer;" onclick="downloadLeaveRequestExcel('{{ $col2[$i] }}')">⬇️</span>
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
                <h2 id="editLeaveModalTitle" style="text-align:center; margin-bottom:24px; font-size:1.3em; letter-spacing:1px;">	Edit Leave Requests for <span id="editLeaveMonth"></span></h2>
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
                        <button type="button" onclick="closeEditModal()" style="background:#e53935; color:#fff; border:none; border-radius:8px; padding:8px 18px; font-size:1em; font-weight:600; cursor:pointer;">✖ Cancel</button>
                        <button type="submit" style="background:#1ecb6b; color:#fff; border:none; border-radius:8px; padding:8px 22px; font-size:1em; font-weight:600; cursor:pointer;">💾Save</button>
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
        
        // Update the month names for the cards
        document.addEventListener('DOMContentLoaded', function() {
            const currentMonthName = new Date().toLocaleString('default', { month: 'long' });
            // Only update the current month card label
            const currentMonthElement = document.querySelector('#currentMonthCount').nextElementSibling;
            if (currentMonthElement) {
                currentMonthElement.textContent = `${currentMonthName} Total Requests`;
            }
            // Do NOT update the year total card label
        });
        // Modal logic for editing leave requests by month
        function openEditModal(month) {
            var monthSpan = document.getElementById('editLeaveMonth');
            if (monthSpan) monthSpan.textContent = month;
            var modalTitle = document.getElementById('editLeaveModalTitle');
            if (modalTitle) modalTitle.textContent = '✏️	Edit Leave Requests for ' + month;
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
                                        <span style="color:#388e3c;">🗓️</span>
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
            saveBtn.innerHTML = '<span>⏳</span> Saving...';
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
                saveBtn.innerHTML = '<span>⏳</span>';
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
        document.getElementById('deletePrevYearBtn').addEventListener('click', function() {
            if (confirm('Are you sure you want to delete ALL leave requests for {{ $previousYear }}? This action cannot be undone.')) {
                fetch('{{ route('admin.leave-requests.delete-previous-year') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('Previous year\'s leave requests deleted.');
                        location.reload();
                    } else {
                        alert('Failed to delete previous year\'s leave requests.');
                    }
                });
            }
        });
        </script>
    </div>
</body>
</html>
