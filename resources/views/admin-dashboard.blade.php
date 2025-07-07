<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
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
            padding: 24px 40px 0 40px !important; /* Match leave-requests */
            min-height: 82px; /* Ensures consistent height */
            flex-wrap: wrap;
        }
        .header-title {
            font-size: 2.3em;
            font-weight: 700;
            color: #222;
            line-height: 1.1;
            margin-bottom: 0;
        }
        .profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #f5f5f5;
            border-radius: 30px;
            padding: 8px 18px;
            min-height: 54px;
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
            justify-content: center;
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
            padding: 10px 40px 0 40px;
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
            color: #1ecb6b;
        }
        .stat-card .count {
            font-size: 2em;
            font-weight: 700;
            color: #222;
        }
        .stat-card .label {
            font-size: 1em;
            color: #888;
            margin-top: 4px;
            text-align: center;
        }
        .admin-actions {
            display: flex;
            gap: 30px;
            margin-top: 40px;
            flex-wrap: wrap;
        }
        .action-card {
            background: #1ecb6b;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            padding: 30px 40px 20px 40px;
            display: flex;
            flex-direction: column;
            position: relative;
            align-items: center;
            min-width: 220px;
            flex: 1;
            cursor: pointer;
            transition: all 0.3s ease-out;
            overflow: hidden;
        }
        .action-card:hover {
            scale: 1.05;
            transition: scale 0.3s;
            background:rgb(29, 127, 39);
            box-shadow: 0 4px 16px rgba(67,160,71,0.15);
        }
        .action-card::after,
        .action-card::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 3px;
            background: linear-gradient(to right,rgb(158, 163, 0),rgb(26, 87, 27));
            left: 0;
            transform: scaleX(0);
            transition: transform 0.4s ease-out;    
        }
        .action-card::after {
            bottom: 0;
            transform-origin: right;
        }
        .action-card::before {
            top: 0;
            transform-origin: left;
        }
        .action-card:hover {
            background: #18b35f;
            box-shadow: 0 6px 20px rgba(67,160,71,0.25);
        }
        .action-card:hover::after,
        .action-card:hover::before {
            transform: scaleX(1);
        }
        .action-card .icon {
            font-size: 2.5em;
            color: #fff;
            margin-bottom: 10px;
        }
        .action-card .label {
            font-size: 1.1em;
            color:rgb(255, 255, 255);
            font-weight: 700;
            margin-top: 12px;
            text-align: center;
            letter-spacing: 1px;
        }
        
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: #006400;
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
                min-width: 180px;
            }
            .stats-row {
                gap: 15px;
            }
            .admin-actions {
                gap: 15px;
            }
            .action-card {
                padding: 20px 30px 15px 30px;
                min-width: 180px;
            }
        }
        
        @media (max-width: 992px) {
            .header-title {
                font-size: 1.8em;
            }
            .header, .dashboard-body {
                padding: 20px !important;
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
                min-height: unset;
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
            .action-card {
                min-width: calc(50% - 15px);
                flex: 0 0 calc(50% - 15px);
                padding: 20px 15px 15px 15px;
            }
        }
        
        @media (max-width: 576px) {
            .header-title {
                font-size: 1.5em;
            }
        }
        
        /* Dark mode toggle button */
        .dark-mode-toggle {
            background: none;
            border: none;
            color: #333;
            font-size: 1.2em;
            cursor: pointer;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            border-radius: 50%;
            background-color: #f0f0f0;
            transition: all 0.3s ease;
        }
        
        .dark-mode-toggle:hover {
            background-color: #e0e0e0;
        }
        
        /* Dark mode styles */
        body.dark-mode {
            background: #121212;
            color: #e0e0e0;
        }
        
        body.dark-mode .main-content {
            background: #121212;
        }
        
        body.dark-mode .header-title {
            color: #e0e0e0;
        }
        
        body.dark-mode .profile {
            background: #1e1e1e;
        }
        
        body.dark-mode .profile-info span {
            color: #e0e0e0;
        }
        
        body.dark-mode .stat-card {
            background: #1e1e1e;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        
        body.dark-mode .stat-card .count {
            color: #e0e0e0;
        }
        
        body.dark-mode .action-card {
            background: #0a5a2d;
        }
        
        body.dark-mode .action-card:hover {
            background: #083d1e;
        }
        
        body.dark-mode .dark-mode-toggle {
            color: #e0e0e0;
            background-color: #333;
        }
        
        body.dark-mode .dark-mode-toggle:hover {
            background-color: #444;
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
        <a href="{{ route('admin.dashboard') }}" class="dashboard-link">
            <span class="material-icons" style="margin-right:5px">account_circle</span>
            Admin Dashboard
        </a>
        <a href="{{ route('password.change') }}" class="dashboard-link" style="margin-top: 15px; background: #e0e0e0; color: #333;">
            <span class="material-icons">lock</span>
            Change Password
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    <div class="main-content">
        <div class="header">
            <div class="header-title">Admin</div>
            <div class="profile">
                <button id="darkModeToggle" class="dark-mode-toggle" title="Toggle Dark Mode">
                    <span class="material-icons">dark_mode</span>
                </button>
                <div class="profile-icon">
                    <span class="material-icons">account_circle</span>
                </div>
                <div class="profile-info">
                    <span>{{ auth()->user()->name }}</span>
                    <a href="#">#{{ auth()->user()->id }}</a>
                </div>
                <button class="logout-icon-btn" title="Log Out" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="material-icons">exit_to_app</span>
                </button>
            </div>
        </div>
        
        <div style="height:5px;width:100%;background:linear-gradient(145deg,#00d082 0%,#fcb900 100%);margin-bottom:18px;margin-top:18px;"></div>
        <!-- Yearly Requests Bar Graph -->
        <div style="background:#fff; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.07); padding:30px 40px; margin-bottom:30px; max-width:700px; margin-left:40px; margin-right:auto;">
                <h3 style="margin-bottom:20px; text-align:center; color:#1976d2;">Yearly Leave Requests (Last 5 Years)</h3>
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
            </script>
        <div class="dashboard-body">
            <div class="stats-row">
                <div class="stat-card">
                    <span class="material-icons icon">people</span>
                    <div class="count">{{ $employeeCount ?? 0 }}</div>
                    <div class="label">Total Employees</div>
                </div>
                <div class="stat-card">
                    <span class="material-icons icon">assignment</span>
                    <div class="count">{{ $leaveCount ?? 0 }}</div>
                    <div class="label">Leave Requests</div>
                </div>
                <div class="stat-card">
                    <span class="material-icons icon">event_available</span>
                    <div class="count">{{ $pendingCount ?? 0 }}</div>
                    <div class="label">Pending Requests</div>
                </div>
            </div>
            
            
            <div class="admin-actions">
                <div class="action-card">
                    <span class="material-icons icon">person_add</span>
                    <div class="label">ADD NEW EMPLOYEE</div>
                </div>
                <div class="action-card">
                    <span class="material-icons icon">assignment_turned_in</span>
                    <div class="label">MANAGE LEAVE REQUESTS</div>
                </div>
                <div class="action-card">
                    <span class="material-icons icon">people</span>
                    <div class="label">LIST OF EMPLOYEES</div>
                </div>
                <div class="action-card">
                    <span class="material-icons icon">assessment</span>
                    <div class="label">GENERATE REPORTS</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add New Employee Modal -->
    <div id="addEmployeeModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.25); z-index:3000; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:16px; max-width:420px; width:95vw; margin:auto; padding:32px 24px 24px 24px; box-shadow:0 8px 32px rgba(0,0,0,0.15); position:relative;">
            <h2 style="text-align:center; margin-bottom:18px; font-size:1.3em; letter-spacing:1px;">Add New Employee</h2>
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
                    <button type="button" onclick="closeAddEmployeeModal()" style="background:#e53935; color:#fff; border:none; border-radius:8px; padding:8px 22px; font-size:1em; font-weight:600; cursor:pointer;">Cancel</button>
                    
                    <button type="submit" style="background:#1ecb6b; color:#fff; border:none; border-radius:8px; padding:8px 22px; font-size:1em; font-weight:600; cursor:pointer;">Add</button>
                </div>
            </form>
        </div>
        </div>
    
    <!-- Employee List Modal -->
    <div id="employeeListModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.25); z-index:3000; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:16px; width:min(98vw,1200px); max-height:92vh; overflow-y:auto; margin:auto; padding:20px 10px 10px 10px; box-shadow:0 8px 32px rgba(0,0,0,0.15); position:relative;">
            <div style="position:relative;">
                <button onclick="closeEmployeeListModal()" style="position:absolute; top:-10px; right:-10px; background:#e53935; color:#fff; border:none; border-radius:50%; width:30px; height:30px; font-size:18px; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 8px rgba(0,0,0,0.2);">×</button>
                <h2 style="text-align:center; margin-bottom:24px; font-size:1.3em; letter-spacing:1px; color:#1ecb6b;">
                    <span class="material-icons" style="vertical-align:middle; margin-right:8px; font-size:1.2em; color:#1ecb6b;">people</span>
                    List of Employees
                </h2>
            </div>
            
            <!-- Search and Sort Controls -->
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:10px;">
                <div style="display:flex; align-items:center; gap:10px;">
                    <input type="text" id="employeeSearch" placeholder="Search by name..." style="padding:8px 12px; border:1px solid #ccc; border-radius:6px; min-width:200px;">
                    <button onclick="searchEmployees()" style="background:#1ecb6b; color:#fff; border:none; border-radius:6px; padding:8px 12px; cursor:pointer;">Search</button>
                    <button onclick="clearSearch()" style="background:#e53935; color:#fff; border:none; border-radius:6px; padding:8px 12px; cursor:pointer;">Clear</button>
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
        <div style="background:#fff; border-radius:16px; max-width:500px; width:95vw; margin:auto; padding:32px 24px 24px 24px; box-shadow:0 8px 32px rgba(0,0,0,0.15); position:relative;">
            <h2 style="text-align:center; margin-bottom:18px; font-size:1.3em; letter-spacing:1px;">Edit Employee</h2>
            <form id="editEmployeeForm">
                <input type="hidden" id="editEmployeeId" name="id">
                <div style="display:flex; gap:8px; margin-bottom:10px;">
                    <input type="text" id="editFirstName" name="first_name" placeholder="First Name" required style="flex:1; padding:8px; border-radius:6px; border:1px solid #ccc;">
                    <input type="text" id="editLastName" name="last_name" placeholder="Last Name" required style="flex:1; padding:8px; border-radius:6px; border:1px solid #ccc;">
                    <input type="text" id="editMiddleInitial" name="middle_initial" placeholder="M.I." maxlength="2" style="width:60px; padding:8px; border-radius:6px; border:1px solid #ccc;">
                </div>
                <input type="email" id="editEmail" name="email" placeholder="Email" style="width:95%; margin-bottom:10px; padding:8px; border-radius:6px; border:1px solid #ccc;">
                <input type="text" id="editPosition" name="position" placeholder="Position" required style="width:95%; margin-bottom:10px; padding:8px; border-radius:6px; border:1px solid #ccc;">
                <input type="text" id="editOffices" name="offices" placeholder="Office/Department" required style="width:95%; margin-bottom:18px; padding:8px; border-radius:6px; border:1px solid #ccc;">
                <div style="display:flex; justify-content:flex-end; gap:12px;">
                    <button type="button" onclick="closeEditEmployeeModal()" style="background:#e53935; color:#fff; border:none; border-radius:8px; padding:8px 22px; font-size:1em; font-weight:600; cursor:pointer;">Cancel</button>
                    <button type="submit" style="background:#1ecb6b; color:#fff; border:none; border-radius:8px; padding:8px 22px; font-size:1em; font-weight:600; cursor:pointer;">Update</button>
                </div>
            </form>
        </div>
    </div>
<footer>
    <div class="footer-content">
        <div class="footer-section">
            <h3>About Us</h3>
            <p>We are a team of dedicated professionals who are passionate about providing the best possible service to our clients.</p>
        </div>
        
    </div>
</footer>
    <script>
        // Menu toggle for mobile
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
        
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
                            <button onclick="editEmployee(${employee.id})" style="background:#1ecb6b; color:#fff; border:none; border-radius:4px; padding:4px 8px; font-size:0.9em; cursor:pointer;">Edit</button>
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
                // Parse the name format: "LAST NAME, FIRST NAME MIDDLE INITIAL"
                const nameParts = employee.name.split(', ');
                const lastName = nameParts[0];
                const firstNameAndMI = nameParts[1] ? nameParts[1].split(' ') : ['', ''];
                const firstName = firstNameAndMI[0] || '';
                const middleInitial = firstNameAndMI[1] || '';
                
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
