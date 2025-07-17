<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>🌿 Dashboard</title>
    
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    
    
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
        
        .new-btn:hover {
            scale: 1.05;
            background: linear-gradient(135deg, var(--secondary-green) 0%, var(--accent-green) 100%);
            box-shadow: 0 4px 16px rgba(67,160,71,0.15);
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
        <!-- Falling leaves animation -->
        <div class="falling-leaves">
            <span class="leaf material-icons">eco</span>
            <span class="leaf material-icons">eco</span>
            <span class="leaf material-icons">eco</span>
            <span class="leaf material-icons">eco</span>
        </div>
        
        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e9/Department_of_Agriculture_of_the_Philippines.svg" alt="Department of Agriculture Logo">
        <h2>Department of<br>Agriculture</h2>
        <p>1998</p>
        <a href="#" class="dashboard-link">
            <span >🏠</span>
            Dashboard
        </a>
        <a href="#" id="changePasswordBtn" class="dashboard-link">
            <span >🔐</span>
            Change Password
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    <div class="main-content">
        <div class="header">
            <div class="header-title">🌱 Online Leave Application</div>
            <div class="profile">
                <div class="profile-card">
                    <div class="profile-icon">
                        <span class="material-icons">account_circle</span>
                    </div>
                    <div class="profile-info">
                        <span>{{ auth()->user()->name }}</span>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <a href="#">#{{ auth()->user()->id }}</a>
                        </div>
                    </div>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-btn" title="Logout">
                        <span class="material-icons logout-icon">logout</span></a>
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
                    <span class="icon">⏱️</span>
                    <div class="count" id="pendingCount" >{{ $pendingCount }}</div>
                    <div class="label">Pending</div>
                </div>
                <div class="stat-card">
                    <span class="icon">✅</span>
                    <div class="count text-success">{{ $certifiedCount }}</div>
                    <div class="label">Certified</div>
                </div>
                <div class="stat-card status-approved" >
                    <span class="icon" >🏅</span>
                    <div class="count" id="approvedCount" ">{{ $approvedCount ?? 0 }}</div>
                    <div class="label" ">Approved</div>
                </div>
                <div class="stat-card rejected">
                    <span class="icon">🚫</span>
                    <div class="count" id="rejectedCount" >{{ $rejectedCount }}</div>
                    <div class="label">Rejected</div>
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
                                                <div class="table-date-row">
                                                    <span class="icon">🗓️<br>🕒</span>
                                                    <div>
                                                        {{ \Carbon\Carbon::parse($leave->created_at)->timezone('Asia/Manila')->format('n/j/Y') }}<br>
                                                        <span class="table-date-time">
                                                            {{ \Carbon\Carbon::parse($leave->created_at)->timezone('Asia/Manila')->format('g:i A') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="table-leave-type-row">
                                                    <span class="icon">📋</span>
                                                    <span>
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
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="{{ $leave->status === 'Pending' ? 'status-pending' : ($leave->status === 'Certified' ? 'status-certified' : ($leave->status === 'Rejected' ? 'status-rejected' : ($leave->status === 'Approved' ? 'status-approved' : ''))) }}">
                                                <div class="table-status-row">
                                                    <span class="icon">
                                                        @if($leave->status === 'Pending')
                                                            ⏳
                                                        @elseif($leave->status === 'Certified')
                                                            ✅
                                                        @elseif($leave->status === 'Rejected')
                                                            🚫
                                                        @elseif($leave->status === 'Approved')
                                                            🏅
                                                        @endif
                                                    </span>
                                                    @if($leave->status === 'Pending')
                                                        <span >PENDING</span>
                                                    @elseif($leave->status === 'Certified')
                                                        <span >HR CERTIFIED</span>
                                                    @elseif($leave->status === 'Rejected')
                                                        <span >REJECTED</span>
                                                    @elseif($leave->status === 'Approved')
                                                        <span>APPROVED</span>
                                                    @else
                                                        {{ strtoupper($leave->status) }}
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="action-btns" style="display: flex; align-items: center;">
                                                    @if($leave->status === 'Certified')
                                                        <a href="{{ route('leave.print', $leave->id) }}" class="icon-btn print-btn" data-id="{{ $leave->id }}" title="Print Certificate" target="_blank">
                                                            <span>🖨️</span>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('leave.show', $leave->id) }}" class="icon-btn view-btn" data-id="{{ $leave->id }}" title="View Details">
                                                            <span>👁‍🗨</span>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                            @else
                                <tr>
                                    <td colspan="4">
                                        <div class="table-empty">
                                            <span class="icon">🌿</span>
                                            <div class="main">No leave requests found</div>
                                            <div class="sub">Start by creating your first leave request</div>
                                        </div>
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
    <div id="changePasswordModal" class="change-password-modal">
        <div class="change-password-modal-content">
            <h2 class="change-password-modal-title">
                <span class="icon">🔐</span>
                Change Password
            </h2>
            <form id="changePasswordForm" class="change-password-modal-form">
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password_confirmation">Confirm New Password</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
                </div>
                <div id="changePasswordMsg" class="error"></div>
                <div class="actions">
                    <button type="button" onclick="closeChangePasswordModal()" class="cancel">Cancel</button>
                    <button type="submit">Change</button>
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
