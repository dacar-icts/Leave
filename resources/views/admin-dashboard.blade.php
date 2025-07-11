<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <button class="menu-toggle" id="menuToggle">
        <span class="material-icons">menu</span>
    </button>
    
    <div class="sidebar" id="sidebar">
        <!-- Falling leaves animation -->
        <div class="falling-leaves">
            <span class="leaf material-icons">eco</span>
            <span class="leaf material-icons">eco</span>
            <span class="leaf material-icons">eco</span>
            <span class="leaf material-icons">eco</span>
        </div>
        <div class="sidebar-logo">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Department_of_Agriculture_of_the_Philippines.svg/1200px-Department_of_Agriculture_of_the_Philippines.svg.png" alt="Department of Agriculture Logo">
        </div>
        <h2 class="mb-0">Department of<br>Agriculture</h2>
        <p class="mt-2">1960</p>
        <a href="{{ route('admin.dashboard') }}" class="dashboard-link"><span class="icon-lg mr-2">🛡️</span>Admin Dashboard</a>
        <a href="#" id="changePasswordBtn" class="dashboard-link mt-3"><span class="icon-lg mr-2">🔐</span>Change Password</a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
    <div class="main-content">
        <div class="header">
            <div class="header-title"><span class="material-icons">admin_panel_settings</span> Admin</div>
            <div class="profile-card">
                <div class="profile-icon">
                    <span class="material-icons">account_circle</span>
                </div>
                <div class="profile-info">
                    <span>{{ auth()->user()->name }}</span>
                    <a href="#">#{{ auth()->user()->id }}</a>
                </div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Logout">
                    <span class="material-icons" >logout</span>
                </a>
            </div>
        </div>
        
        <div style="height:5px;width:100%;background: linear-gradient(145deg, #396426 0%, #668a24 100% 100%);margin-bottom:18px;margin-top:18px;"></div>
        <div class="dashboard-top-row">
            <div class="yearly-graph-card">
                <h3>Yearly Leave Requests (Last 5 Years)</h3>
                <canvas id="yearlyRequestsChart" height="100"></canvas>
            </div>
            <div class="stats-row">
                <div class="stat-card">
                    <span class="icon">👥</span>
                    <div class="count" style="font-size: 2em; font-weight: 600;">{{ $employeeCount ?? 0 }}</div>
                    <div class="label" style="font-family: 'Inter', 'Roboto', 'Segoe UI', 'Helvetica Neue', Arial, sans-serif; font-weight:500;">Total Employees</div>
                </div>
                <div class="stat-card">
                    <span class="icon">📝</span>
                    <div class="count" style="font-size: 2em; font-weight: 600;">{{ $leaveCount ?? 0 }}</div>
                    <div class="label" style="font-family: 'Inter', 'Roboto', 'Segoe UI', 'Helvetica Neue', Arial, sans-serif; font-weight:500;">Leave Requests</div>
                </div>
            </div>
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
                            backgroundColor: 'rgba(6, 166, 56, 0.7)',
                            borderColor: 'rgb(10, 161, 113)',
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
        </script>
        <div class="dashboard-body">
            <div class="admin-actions">
                <div class="action-card">
                    <span class="icon">➕</span>
                    <div class="label">ADD NEW EMPLOYEE</div>
                </div>
                <div class="action-card">
                    <span class="icon">✅</span>
                    <div class="label">MANAGE LEAVE REQUESTS</div>
                </div>
                <div class="action-card">
                    <span class="icon">👥</span>
                    <div class="label">LIST OF EMPLOYEES</div>
                </div>
                <div class="action-card">
                    <span class="icon">📊</span>
                    <div class="label">GENERATE REPORTS</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Change Password Modal -->
    <div id="changePasswordModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.25); z-index:3000; align-items:center; justify-content:center; overflow-y:auto; -webkit-overflow-scrolling:touch;">
        <div style="background:#fff; border-radius:24px; max-width:420px; width:95%; max-height:90vh; overflow-y:auto; margin:32px auto; padding:36px 28px 28px 28px; box-shadow:0 8px 32px rgba(20,83,45,0.18); position:relative; font-family:'Roboto', Arial, sans-serif;">
            <h2 style="text-align:center; margin-bottom:24px; font-size:1.3em; letter-spacing:1px; color:#14532d; font-weight:800;">
                <span class="material-icons" style="vertical-align:middle; margin-right:8px; font-size:1.2em; color:#e3d643;">lock</span>
                Change Password
            </h2>
            <form id="changePasswordForm">
                <div style="margin-bottom:18px;">
                    <label for="current_password" style="display:block; margin-bottom:6px; font-weight:600; color:#14532d;">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required style="width:100%; padding:12px; border-radius:12px; border:1.5px solid #e3d643; font-size:1em;">
                </div>
                <div style="margin-bottom:18px;">
                    <label for="new_password" style="display:block; margin-bottom:6px; font-weight:600; color:#14532d;">New Password</label>
                    <input type="password" id="new_password" name="new_password" required style="width:100%; padding:12px; border-radius:12px; border:1.5px solid #e3d643; font-size:1em;">
                </div>
                <div style="margin-bottom:18px;">
                    <label for="new_password_confirmation" style="display:block; margin-bottom:6px; font-weight:600; color:#14532d;">Confirm New Password</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" required style="width:100%; padding:12px; border-radius:12px; border:1.5px solid #e3d643; font-size:1em;">
                </div>
                <div id="changePasswordMsg" style="margin-bottom:12px; color:#e53935; text-align:center; display:none;"></div>
                <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:18px;">
                    <button type="button" onclick="closeChangePasswordModal()" class="btn btn-secondary" style="border-radius:999px; background:#6c757d; color:#fff; font-weight:600; padding:12px 28px; font-size:1em; box-shadow:0 2px 8px rgba(20,83,45,0.10); transition:all 0.2s;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="border-radius:999px; background:linear-gradient(135deg,#166534 0%,#14532d 100%); color:#fff; font-weight:700; padding:12px 32px; font-size:1em; box-shadow:0 6px 24px 0 rgba(67,233,123,0.18); transition:all 0.2s;">Change</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Add New Employee Modal -->
    <div id="addEmployeeModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.25); z-index:3000; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:16px; max-width:420px; width:95vw; margin:auto; padding:32px 24px 24px 24px; box-shadow:0 8px 32px rgba(0,0,0,0.15); position:relative;">
            <h2 style="text-align:center; margin-bottom:18px; font-size:1.3em; letter-spacing:1px;">➕ Add New Employee</h2>
            <form id="addEmployeeForm">
                <div style="display:flex; gap:8px; margin-bottom:10px;">
                    <input type="text" name="first_name" placeholder="First Name" required style="flex: 1; padding:8px; border-radius:6px; border:1px solid #ccc;">
                    <input type="text" name="last_name" placeholder="Last Name" required style="flex:1; padding:8px; border-radius:6px; border:1px solid #ccc;">
                    <input type="text" name="middle_initial" placeholder="M.I." maxlength="2" style="width:30px; padding:8px; border-radius:6px; border:1px solid #ccc;">
                </div>
                <input type="email" name="email" placeholder="Email" style="width:95%; margin-bottom:10px; padding:8px; border-radius:6px; border:1px solid #ccc;">
                <input type="text" name="position" placeholder="Position" required style="width:95%; margin-bottom:10px; padding:8px; border-radius:6px; border:1px solid #ccc;">
                <input type="text" name="offices" placeholder="Office/Department" required style="width:95%; margin-bottom:10px; padding:8px; border-radius:6px; border:1px solid #ccc;">
                <input type="text" name="password" placeholder="Password" required style="width:95%; margin-bottom:18px; padding:8px; border-radius:6px; border:1px solid #ccc;">
                <div style="display:flex; justify-content:flex-end; gap:12px;">
                    <button type="button" onclick="closeAddEmployeeModal()" style="background:#e53935; color:#fff; border:none; border-radius:8px; padding:8px 22px; font-size:1em; font-weight:600; cursor:pointer;">✖ Cancel</button>
                    
                    <button type="submit" style="background:#1ecb6b; color:#fff; border:none; border-radius:8px; padding:8px 22px; font-size:1em; font-weight:600; cursor:pointer;">✚ Add</button>
                </div>
            </form>
        </div>
        </div>
    
    <!-- Employee List Modal -->
    <div id="employeeListModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.25); z-index:3000; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:16px; width:min(98vw,1200px); max-height:92vh; overflow-y:auto; margin:auto; padding:20px 10px 10px 10px; box-shadow:0 8px 32px rgba(0,0,0,0.15); position:relative;">
            <div style="position:relative;">
                <button onclick="closeEmployeeListModal()" style="position:absolute; top:-10px; right:-10px; background:#e53935; color:#fff; border:none; border-radius:50%; width:32px; height:32px; font-size:18px; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 8px rgba(0,0,0,0.2);">×</button>
                <h2 style="text-align:center; margin-bottom:24px; font-size:1.3em; letter-spacing:1px;">
                    <span class="material-icons" style="vertical-align:middle; margin-right:8px; font-size:1.2em; "></span>
                    👥 List of Employees
                </h2>
            </div>
            
            <!-- Search and Sort Controls -->
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:10px;">
                <div style="display:flex; align-items:center; gap:10px;">
                    <input type="text" id="employeeSearch" placeholder="Search by name..." style="padding:8px 12px; border:1px solid #ccc; border-radius:6px; min-width:200px;">
                    <button onclick="searchEmployees()" style="background:#1ecb6b; color:#fff; border:none; border-radius:6px; padding:8px 12px; cursor:pointer;">🔍 Search</button>
                    <button onclick="clearSearch()" style="background:#e53935; color:#fff; border:none; border-radius:6px; padding:8px 12px; cursor:pointer;">✖ Clear</button>
                </div>
                <div style="display:flex; align-items:center; gap:10px;">
                    <label style="font-weight:600; color:#333;">Sort by:</label>
                    <select id="sortField" onchange="sortEmployees()" style="padding:6px 10px; border:1px solid #ccc; border-radius:4px;">
                        <option value="id">ID#</option>
                        <option value="name">Name</option>
                        <option value="position">Position</option>
                        <option value="offices">Office</option>
                    </select>
                    <button onclick="toggleSortOrder()" id="sortOrderBtn" style="background:#2196F3; color:#fff; border:none; border-radius:4px; padding:6px 10px; cursor:pointer;">↑ Asc</button>
                </div>
            </div>
            
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; table-layout:auto;">
                    <thead>
                        <tr style="background:linear-gradient(to right,#43a047 0%,#1ecb6b 100%); color:#fff;">
                            <th style="padding:14px 18px; text-align:left;">ID#</th>
                            <th style="padding:14px 18px; text-align:left;">Name</th>
                            <th style="padding:14px 18px; text-align:left;">Position</th>
                            <th style="padding:14px 18px; text-align:left;">Office</th>
                            <th style="padding:14px 18px; text-align:center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="employeeTableBody">
                        <!-- Employee rows will be dynamically inserted here -->
                    </tbody>
                </table>
            </div>
            <div style="display:flex; justify-content:center; align-items:center; margin-top:24px;">
                <div id="employeeCount" style="color:#666; font-size:0.9em;">Total: 0 employees</div>
            </div>
        </div>
    </div>

    <!-- Edit Employee Modal -->
    <div id="editEmployeeModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.25); z-index:3001; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:20px; max-width:470px; width:95vw; margin:auto; padding:32px 24px 24px 0px; box-shadow:0 8px 32px rgba(0,0,0,0.15); position:relative; display:flex; flex-direction:column; align-items:center;">
            <button type="button" onclick="closeEditEmployeeModal()" style="position:absolute; top:16px; right:16px; background:#e53935; color:#fff; border:none; border-radius:50%; width:32px; height:40px; font-size:1.3em; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 8px rgba(0,0,0,0.2);">×</button>
            <h2 style="background: var(--pale-green, #e8f5e8); display:inline-block; padding:8px 24px; border-radius:5px; margin-bottom:24px; font-weight:700; box-shadow:0 2px 8px var(--shadow-soft, rgba(45,90,39,0.1)); text-align:center; font-size:1.3em; letter-spacing:1px;">✏️Edit Employee Information</h2>
            <form id="editEmployeeForm" style="width:100%; max-width:370px; margin:0 auto;">
                <input type="hidden" id="editEmployeeId" name="id">
                <div style="display:flex; gap:8px; margin-bottom:14px;">
                    <input type="text" id="editFirstName" name="first_name" placeholder="First Name" required style="flex:1; padding:10px; border-radius:6px; border:1px solid #ccc;">
                    <input type="text" id="editLastName" name="last_name" placeholder="Last Name" required style="flex:1; padding:10px; border-radius:6px; border:1px solid #ccc;">
                    <input type="text" id="editMiddleInitial" name="middle_initial" placeholder="M.I." maxlength="2" style="width:20px; padding:10px; border-radius:6px; border:1px solid #ccc;">
                </div>
                <input type="email" id="editEmail" name="email" placeholder="Email" style="width:100%; margin-bottom:14px; padding:10px; border-radius:6px; border:1px solid #ccc;">
                <input type="text" id="editPosition" name="position" placeholder="Position" required style="width:100%; margin-bottom:14px; padding:10px; border-radius:6px; border:1px solid #ccc;">
                <input type="text" id="editOffices" name="offices" placeholder="Office/Department" required style="width:100%; margin-bottom:22px; padding:10px; border-radius:6px; border:1px solid #ccc;">
                <button type="submit" style="background:#1ecb6b; color:#fff; border:none; border-radius:8px; padding:12px 0; font-size:1em; font-weight:600; cursor:pointer; width:100%; margin-top:8px;">Update</button>
            </form>
        </div>
    </div>
<footer>
    
</footer>
    <script>
        // Menu toggle for mobile
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
        
        // Change password modal logic
        const changePasswordModal = document.getElementById('changePasswordModal');
        const changePasswordBtn = document.getElementById('changePasswordBtn');
        if (changePasswordBtn) {
            changePasswordBtn.addEventListener('click', function(e) {
                e.preventDefault();
                changePasswordModal.style.display = 'flex';
                setTimeout(() => changePasswordModal.classList.add('show'), 10);
                changePasswordModal.style.overflowY = 'auto';
                document.body.style.overflow = 'hidden';
            });
        }
        function closeChangePasswordModal() {
            changePasswordModal.classList.remove('show');
            setTimeout(() => {
                changePasswordModal.style.display = 'none';
                document.body.style.overflow = '';
            }, 300);
        }
        const changePasswordForm = document.getElementById('changePasswordForm');
        if (changePasswordForm) {
            changePasswordForm.onsubmit = function(e) {
                e.preventDefault();
                const msg = document.getElementById('changePasswordMsg');
                msg.style.display = 'none';
                msg.style.color = '#e53935';
                msg.textContent = '';
                const data = {
                    current_password: this.current_password.value,
                    password: this.new_password.value,
                    password_confirmation: this.new_password_confirmation.value,
                    _method: 'PUT',
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                };
                fetch('/password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': data._token
                    },
                    body: JSON.stringify(data)
                })
                .then(async response => {
                    if (response.ok) {
                        msg.style.display = 'block';
                        msg.style.color = '#1ecb6b';
                        msg.textContent = 'Password changed successfully!';
                        setTimeout(() => {
                            closeChangePasswordModal();
                        }, 1200);
                    } else {
                        const res = await response.json();
                        let errorMsg = 'An error occurred.';
                        if (res && res.errors) {
                            errorMsg = Object.values(res.errors).map(arr => arr.join(' ')).join(' ');
                        } else if (res && res.message) {
                            errorMsg = res.message;
                        }
                        msg.style.display = 'block';
                        msg.textContent = errorMsg;
                    }
                })
                .catch(() => {
                    msg.style.display = 'block';
                    msg.textContent = 'An error occurred.';
                });
            };
        }
        
        // Dark mode toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const darkModeToggle = document.getElementById('darkModeToggle');
            const body = document.body;
            
            // Check for saved dark mode preference
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            
            // Apply saved preference on page load
            if (isDarkMode) {
                body.classList.add('dark-mode');
                darkModeToggle.querySelector('.material-icons').textContent = 'light_mode';
            }
            
            // Toggle dark mode on button click
            darkModeToggle.addEventListener('click', function() {
                body.classList.toggle('dark-mode');
                const isDark = body.classList.contains('dark-mode');
                
                // Save preference to localStorage
                localStorage.setItem('darkMode', isDark);
                
                // Update icon based on mode
                darkModeToggle.querySelector('.material-icons').textContent = 
                    isDark ? 'light_mode' : 'dark_mode';
            });
        });
        
        document.querySelectorAll('.action-card').forEach((card, idx) => {
            card.addEventListener('click', function() {
                switch(idx) {
                    case 0:
                        // Add New Employee: Show modal only, do NOT redirect
                        document.getElementById('addEmployeeModal').style.display = 'flex';
                        break;
                    case 1:
                        // Manage Leave Requests
                        window.location.href = '/admin/leave-requests';
                        break;
                    case 2:
                        // List of Employees: Show modal
                        loadEmployees();
                        document.getElementById('employeeListModal').style.display = 'flex';
                        break;
                    case 3:
                        // Generate Reports
                        window.location.href = '/admin/reports';
                        break;
                }
            });
        });
        
        function closeAddEmployeeModal() {
            document.getElementById('addEmployeeModal').style.display = 'none';
        }
        // Handle form submission
        const addEmployeeForm = document.getElementById('addEmployeeForm');
        if(addEmployeeForm) {
            addEmployeeForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const data = {};
                formData.forEach((value, key) => data[key] = value);
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                try {
                    const response = await fetch('/admin/employees', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                            // Remove 'Content-Type': 'application/json' to let browser set correct boundary for FormData
                        },
                        body: formData // send FormData directly
                    });
                    if (response.ok) {
                        alert('Employee added successfully!');
                        closeAddEmployeeModal();
                        window.location.reload();
                    } else {
                        const error = await response.json();
                        alert('Failed to add employee. ' + (error.message || JSON.stringify(error)));
                    }
                } catch (err) {
                    alert('Failed to add employee. ' + err);
                }
            });
        }
        
        // Employee List Modal Functions
        let allEmployees = []; // Store all employees for search/sort
        let currentSortField = 'id';
        let currentSortOrder = 'asc';
        
        function closeEmployeeListModal() {
            document.getElementById('employeeListModal').style.display = 'none';
        }
        
        function closeEditEmployeeModal() {
            document.getElementById('editEmployeeModal').style.display = 'none';
        }
        
        function loadEmployees() {
            fetch('/admin/employees', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                allEmployees = data; // Store all employees
                // Sort by ID# by default
                const sortedEmployees = [...data].sort((a, b) => {
                    const aValue = parseInt(a.id) || 0;
                    const bValue = parseInt(b.id) || 0;
                    return aValue - bValue;
                });
                displayEmployees(sortedEmployees);
                updateEmployeeCount(data.length);
            })
            .catch(error => {
                console.error('Error loading employees:', error);
                document.getElementById('employeeTableBody').innerHTML = '<tr><td colspan="5" style="text-align:center; padding:30px; color:#e53935;">Error loading employees</td></tr>';
                updateEmployeeCount(0);
            });
        }
        
        function displayEmployees(employees) {
            const tbody = document.getElementById('employeeTableBody');
            if (employees.length > 0) {
                tbody.innerHTML = employees.map(employee => `
                    <tr>
                        <td style="padding:12px 18px;">${employee.id}</td>
                        <td style="padding:12px 18px;">${employee.name}</td>
                        <td style="padding:12px 18px;">${employee.position || '-'}</td>
                        <td style="padding:12px 18px;">${employee.offices || '-'}</td>
                        <td style="padding:12px 18px; text-align:center;">
                            <button onclick="editEmployee(${employee.id})" style="background:#1ecb6b; color:#fff; border:none; border-radius:4px; padding:4px 8px; font-size:0.9em; cursor:pointer;">✏️Edit</button>
                        </td>
                    </tr>
                `).join('');
            } else {
                tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; padding:30px; color:#888;">No employees found</td></tr>';
            }
        }
        
        function updateEmployeeCount(count) {
            document.getElementById('employeeCount').textContent = `Total: ${count} employees`;
        }
        
        function searchEmployees() {
            const searchTerm = document.getElementById('employeeSearch').value.toLowerCase().trim();
            if (searchTerm === '') {
                displayEmployees(allEmployees);
                updateEmployeeCount(allEmployees.length);
                return;
            }
            
            const filteredEmployees = allEmployees.filter(employee => 
                employee.name.toLowerCase().includes(searchTerm)
            );
            
            displayEmployees(filteredEmployees);
            updateEmployeeCount(filteredEmployees.length);
        }
        
        function clearSearch() {
            document.getElementById('employeeSearch').value = '';
            displayEmployees(allEmployees);
            updateEmployeeCount(allEmployees.length);
        }
        
        function sortEmployees() {
            currentSortField = document.getElementById('sortField').value;
            const sortedEmployees = [...allEmployees].sort((a, b) => {
                let aValue = a[currentSortField] || '';
                let bValue = b[currentSortField] || '';
                
                // Special handling for ID field - sort numerically
                if (currentSortField === 'id') {
                    aValue = parseInt(aValue) || 0;
                    bValue = parseInt(bValue) || 0;
                    
                    if (currentSortOrder === 'asc') {
                        return aValue - bValue;
                    } else {
                        return bValue - aValue;
                    }
                } else {
                    // For other fields, convert to string for comparison
                    aValue = String(aValue).toLowerCase();
                    bValue = String(bValue).toLowerCase();
                    
                    if (currentSortOrder === 'asc') {
                        return aValue.localeCompare(bValue);
                    } else {
                        return bValue.localeCompare(aValue);
                    }
                }
            });
            
            displayEmployees(sortedEmployees);
        }
        
        function toggleSortOrder() {
            currentSortOrder = currentSortOrder === 'asc' ? 'desc' : 'asc';
            const btn = document.getElementById('sortOrderBtn');
            btn.textContent = currentSortOrder === 'asc' ? '↑ Asc' : '↓ Desc';
            btn.style.background = currentSortOrder === 'asc' ? '#2196F3' : '#FF9800';
            sortEmployees();
        }
        
        function editEmployee(id) {
            fetch(`/admin/employees/${id}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(employee => {
                // Parse the name format: "Last,First Middle" (only one comma)
                let lastName = '', firstName = '', middleInitial = '';
                if (employee.name) {
                    const commaIdx = employee.name.indexOf(',');
                    if (commaIdx !== -1) {
                        lastName = employee.name.substring(0, commaIdx).trim();
                        const right = employee.name.substring(commaIdx + 1).trim();
                        const rightParts = right.split(' ');
                        firstName = rightParts[0] ? rightParts[0].trim() : '';
                        middleInitial = rightParts.length > 1 ? rightParts.slice(1).join(' ').trim() : '';
                    } else {
                        lastName = employee.name.trim();
                    }
                }
                document.getElementById('editEmployeeId').value = employee.id;
                document.getElementById('editFirstName').value = firstName;
                document.getElementById('editLastName').value = lastName;
                document.getElementById('editMiddleInitial').value = middleInitial;
                document.getElementById('editEmail').value = employee.email || '';
                document.getElementById('editPosition').value = employee.position || '';
                document.getElementById('editOffices').value = employee.offices || '';
                document.getElementById('editEmployeeModal').style.display = 'flex';
            })
            .catch(error => {
                console.error('Error loading employee:', error);
                alert('Error loading employee data');
            });
        }
        
        // Search input event listener for real-time search
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('employeeSearch');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    // Debounce the search to avoid too many calls
                    clearTimeout(this.searchTimeout);
                    this.searchTimeout = setTimeout(() => {
                        searchEmployees();
                    }, 300);
                });
            }
        });
        
        // Edit Employee Form Submission
        const editEmployeeForm = document.getElementById('editEmployeeForm');
        if (editEmployeeForm) {
            editEmployeeForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const data = {};
                formData.forEach((value, key) => data[key] = value);
                
                // Format name as: LAST NAME, FIRST NAME MIDDLE INITIAL (all caps)
                const firstName = data.first_name.toUpperCase().trim();
                const lastName = data.last_name.toUpperCase().trim();
                const middleInitial = data.middle_initial.toUpperCase().trim();
                
                data.name = lastName + ', ' + firstName;
                if (middleInitial) {
                    data.name += ' ' + middleInitial;
                }
                
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                try {
                    const response = await fetch(`/admin/employees/${data.id}`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data)
                    });
                    if (response.ok) {
                        alert('Employee updated successfully!');
                        closeEditEmployeeModal();
                        loadEmployees(); // Refresh the list
                    } else {
                        const error = await response.json();
                        alert('Failed to update employee. ' + (error.message || JSON.stringify(error)));
                    }
                } catch (err) {
                    alert('Failed to update employee. ' + err);
                }
            });
        }
    </script>
</body>
</html>
