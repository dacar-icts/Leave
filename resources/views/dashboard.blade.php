<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>
    
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/leave-form.css') }}">
    
    <!-- Mobile fixes -->
    <script src="{{ asset('js/mobile-fix.js') }}"></script>
    
    <!-- Styling for modals and buttons -->
    <style>
        /* Additional styling for buttons and modals */
        .icon-btn {
            cursor: pointer !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            margin-right: 5px;
            transition: all 0.2s ease;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
        }
        .icon-btn:hover {
            background-color: #e0e0e0;
            transform: scale(1.1);
        }
        .view-btn {
            color: #2196F3;
        }
        .print-btn {
            color: #4CAF50;
        }
        .icon-btn .material-icons {
            font-size: 20px;
        }
        #leaveModal {
            z-index: 2000 !important;
        }
        #leaveModal, #changePasswordModal {
            opacity: 0;
            transition: opacity 0.3s ease;
            -webkit-overflow-scrolling: touch; /* Improve mobile scrolling */
        }
        #leaveModal.show, #changePasswordModal.show {
            opacity: 1;
        }
        
        /* Spinner animation */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Mobile responsiveness improvements */
        @media (max-width: 768px) {
            .main-content {
                width: 100% !important;
                left: 0 !important;
                overflow-x: hidden !important;
            }
            .dashboard-body {
                overflow-y: auto !important;
                -webkit-overflow-scrolling: touch !important;
                max-height: calc(100vh - 120px) !important;
                padding-bottom: 80px !important;
            }
            .table-container {
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch !important;
            }
            #leaveModal > div, #changePasswordModal > div {
                width: 90% !important;
                max-height: 85vh !important;
                overflow-y: auto !important;
                -webkit-overflow-scrolling: touch !important;
                padding: 20px 15px 15px 15px !important;
            }
            /* Fix for iOS momentum scrolling */
            body, html {
                height: 100%;
                overflow: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            /* Make buttons more tappable on mobile */
            .icon-btn {
                width: 44px;
                height: 44px;
                margin-right: 10px;
            }
            
            .icon-btn .material-icons {
                font-size: 24px;
            }
            
            /* Increase spacing between action buttons */
            td .icon-btn + .icon-btn {
                margin-left: 5px;
            }
        }
        
        @media print {
            .sidebar, .header, .menu-toggle, .dashboard-body > div:not(.table-container), .wave-container {
                display: none !important;
            }
        }
    </style>
</head>
<body ontouchstart="">
    <button class="menu-toggle" id="menuToggle">
        <span class="material-icons">menu</span>
    </button>
    
    <div class="sidebar" id="sidebar">
        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e9/Department_of_Agriculture_of_the_Philippines.svg" alt="Department of Agriculture Logo">
        <h2>Department of<br>Agriculture</h2>
        <p>1998</p>
        <a href="#" class="dashboard-link">
            <span class="material-icons">account_circle</span>
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
                        <span>{{ auth()->user()->name }}
                            
                            <a href="#" id="changePasswordBtn" style="font-size:0.9em; color:#b8860b; margin-left:10px; text-decoration:underline; font-weight:500;">Change Password</a>
                        </span>
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
            @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <span class="material-icons">check_circle</span>
                {{ session('success') }}
                <button type="button" class="close" onclick="this.parentElement.style.display='none'">
                    <span class="material-icons">close</span>
                </button>
            </div>
            @endif
            
            @if(session('error'))
            <div class="alert alert-error alert-dismissible">
                <span class="material-icons">error</span>
                {{ session('error') }}
                <button type="button" class="close" onclick="this.parentElement.style.display='none'">
                    <span class="material-icons">close</span>
                </button>
            </div>
            @endif
            
            <div class="stats-row">
                <div class="stat-card pending">
                    <span class="material-icons icon">access_time</span>
                    <div class="count" id="pendingCount">{{ $pendingCount }}</div>
                    <div class="label">Pending Requests</div>
                </div>
                <div class="stat-card">
                    <span class="material-icons icon" style="color:#1ecb6b;">check_circle</span>
                    <div class="count" id="certifiedCount">{{ $certifiedCount }}</div>
                    <div class="label">Certified</div>
                </div>
                <div class="stat-card">
                    <span class="material-icons icon" style="color:#2196f3;">insights</span>
                    <div class="count" id="totalRequests" style="color:#2196f3;">{{ $totalRequests }}</div>
                    <div class="label">Total Requests</div>
                </div>
            </div>
            
            <div class="table-container">
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>DATE FILED</th>
                                <th>LEAVE TYPE</th>
                                <th>STATUS</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody id="leaveRequestsTable">
                            @if(count($leaveRequests) > 0)
                                @foreach($leaveRequests as $leave)
                                    <tr>
                                        <td>
                                            {{ \Carbon\Carbon::parse($leave->created_at)->timezone('Asia/Manila')->format('n/j/Y') }}<br>
                                            <span style="font-size:0.95em; color:#888;">
                                                {{ \Carbon\Carbon::parse($leave->created_at)->timezone('Asia/Manila')->format('g:i A') }}
                                            </span>
                                        </td>
                                        <td>
                                            @if(is_array($leave->leave_type))
                                                {{ implode(', ', $leave->leave_type) }}
                                            @elseif(is_string($leave->leave_type) && $leave->leave_type[0] === '[')
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
                                            <a href="{{ route('leave.show', $leave->id) }}" class="icon-btn view-btn" data-id="{{ $leave->id }}" title="View">
                                                <span class="material-icons">visibility</span>
                                            </a>
                                            @if($leave->status === 'Certified')
                                                <a href="{{ route('leave.print', $leave->id) }}" class="icon-btn print-btn" data-id="{{ $leave->id }}" title="Print" target="_blank">
                                                    <span class="material-icons">print</span>
                                                </a>
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
        
        <div class="wave-container">
            <div class="wave wave-1"></div>
            <div class="wave wave-2"></div>
            <div class="wave wave-3"></div>
        </div>
    </div>
    
    <!-- Change Password Modal -->
    <div id="changePasswordModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.25); z-index:3000; align-items:center; justify-content:center; overflow-y:auto; -webkit-overflow-scrolling:touch;">
        <div style="background:#fff; border-radius:16px; max-width:420px; width:95%; max-height:90vh; overflow-y:auto; margin:20px auto; padding:28px 22px 20px 22px; box-shadow:0 8px 32px rgba(0,0,0,0.15); position:relative;">
        <h2 style="text-align:center; margin-bottom:24px; font-size:1.3em; letter-spacing:1px; color:#1ecb6b;">
                    <span class="material-icons" style="vertical-align:middle; margin-right:8px; font-size:1.2em; color:#1ecb6b;">people</span>
                    Change Password
                </h2>
            <form id="changePasswordForm">
                <div style="margin-bottom:18px;">
                    <label for="current_password" style="display:block; margin-bottom:6px; font-weight:600;">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required style="width:85%; padding:10px; border-radius:6px; border:1px solid #ccc;">
                </div>
                <div style="margin-bottom:18px;">
                    <label for="new_password" style="display:block; margin-bottom:6px; font-weight:600;">New Password</label>
                    <input type="password" id="new_password" name="new_password" required style="width:85%; padding:10px; border-radius:6px; border:1px solid #ccc;">
                </div>
                <div style="margin-bottom:18px;">
                    <label for="new_password_confirmation" style="display:block; margin-bottom:6px; font-weight:600;">Confirm New Password</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" required style="width:85%; padding:10px; border-radius:6px; border:1px solid #ccc;">
                </div>
                <div id="changePasswordMsg" style="margin-bottom:12px; color:#e53935; text-align:center; display:none;"></div>
                <div style="display:flex; justify-content:flex-end; gap:10px;">
                    <button type="button" onclick="closeChangePasswordModal()" style="background:rgb(239, 54, 51); color:#fff; border:none; border-radius:8px; padding:8px 18px; font-size:1em; font-weight:600; cursor:pointer;">Cancel</button>
                    <button type="submit" style="background:#1ecb6b; color:#fff; border:none; border-radius:8px; padding:8px 22px; font-size:1em; font-weight:600; cursor:pointer;">Change</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let leaveRequests = @json($leaveRequests);
        
        // Document ready function to ensure DOM is fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Menu toggle for mobile
            document.getElementById('menuToggle').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('active');
            });
            
            // Auto-hide success message after 5 seconds
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.display = 'none';
                }, 5000);
            }
        });
        
        // Change password modal
        const changePasswordModal = document.getElementById('changePasswordModal');
        const changePasswordBtn = document.getElementById('changePasswordBtn');
        if (changePasswordBtn) {
            changePasswordBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Show modal with flex display
                changePasswordModal.style.display = 'flex';
                setTimeout(() => changePasswordModal.classList.add('show'), 10);
                
                // Enable modal scrolling, disable body scrolling
                changePasswordModal.style.overflowY = 'auto';
                document.body.style.overflow = 'hidden';
            });
        }
        
        function closeChangePasswordModal() {
            // Hide modal
            changePasswordModal.classList.remove('show');
            setTimeout(() => {
                changePasswordModal.style.display = 'none';
                
                // Restore body scrolling
                document.body.style.overflow = '';
            }, 300);
        }
        
        // Function to refresh the dashboard data
        function refreshDashboardData() {
            fetch('/dashboard?_=' + new Date().getTime(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Create a temporary DOM element to parse the HTML
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Update the counts
                document.getElementById('pendingCount').textContent = doc.getElementById('pendingCount').textContent;
                document.getElementById('certifiedCount').textContent = doc.getElementById('certifiedCount').textContent;
                document.getElementById('totalRequests').textContent = doc.getElementById('totalRequests').textContent;
                
                // Update the table content
                const newTableContent = doc.getElementById('leaveRequestsTable').innerHTML;
                document.getElementById('leaveRequestsTable').innerHTML = newTableContent;
                
                // Update the leaveRequests variable for the modal
                const scriptContent = Array.from(doc.scripts).find(script => script.textContent.includes('leaveRequests = '));
                if (scriptContent) {
                    const match = scriptContent.textContent.match(/leaveRequests = (.*?);/);
                    if (match && match[1]) {
                        leaveRequests = JSON.parse(match[1]);
                    }
                }
            })
            .catch(error => console.error('Error refreshing dashboard data:', error));
        }
        
        // Check for new data every 30 seconds
        setInterval(refreshDashboardData, 30000);

        // AJAX for change password
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

        // For iOS to recognize touch events properly
        document.addEventListener('touchstart', function() {}, {passive: true});
    </script>
</body>
</html>
