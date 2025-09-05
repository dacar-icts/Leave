<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>🌱HR Dashboard</title>
    
    <link rel="stylesheet" href="/css/hr-dashboard.css">
    <!-- Mobile fixes -->
    <script src="{{ asset('js/mobile-fix.js') }}"></script>
</head>
<body ontouchstart="">
    
    <button class="menu-toggle" id="menuToggle">☰</button>
    
    <div class="sidebar" id="sidebar">
        <!-- Falling leaves animation -->
		<div class="falling-leaves">
			<img src="/wheat.png" class="leaf" alt="wheat">
			<img src="/wheat.png" class="leaf" alt="wheat">
			<img src="/wheat.png" class="leaf" alt="wheat">
			<img src="/wheat.png" class="leaf" alt="wheat">
		</div>
        <div class="sidebar-logo">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Department_of_Agriculture_of_the_Philippines.svg/1200px-Department_of_Agriculture_of_the_Philippines.svg.png" alt="Department of Agriculture Logo">
        </div>
        <h2 class="mb-0">Department of<br>Agriculture</h2>
        <p class="mt-2">1960</p>
        <a href="{{ route('hr.dashboard') }}" class="dashboard-link"><span class="icon-lg mr-2">🏠</span>Dashboard</a>
        <a href="#" id="changePasswordBtn" class="dashboard-link mt-3"><span class="icon-lg mr-2">🔐</span>Change Password</a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
    
    <div class="main-content">
        <div class="header">
            <div class="header-title">🌱 HR Dashboard</div>
            <div class="profile-card profile-absolute">
                <div class="profile-icon"><span class="material-icons">account_circle</span></div>
                <div class="profile-info">
                    <span>{{ auth()->user()->name }}</span>
                    <a href="#">#{{ auth()->user()->id }}</a>
                </div>
                <button class="logout-icon-btn" title="Log Out" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span class="material-icons">logout</span></button>
            </div>
        </div>
        
        <div class="dashboard-body">
            <div class="stats-row">
                <div class="stat-card pending">
                    <span class="icon">⏱️</span>
                    <div class="count" id="pendingCount" >{{ $pendingCount }}</div>
                    <div class="label">Pending Certification</div>
                </div>
                <div class="stat-card">
                    <span class="icon">✅</span>
                    <div class="count text-success">{{ $certifiedCount }}</div>
                    <div class="label">HR Certified</div>
                </div>
                <div class="stat-card status-approved" >
                    <span class="icon" >🏅</span>
                    <div class="count" id="approvedCount" >{{ $approvedCount ?? 0 }}</div>
                    <div class="label" >Approved</div>
                </div>
                <div class="stat-card rejected">
                    <span class="icon">🚫</span>
                    <div class="count" id="rejectedCount">{{ $rejectedCount }}</div>
                    <div class="label">Rejected</div>
                </div>

            </div>
            
            <div class="filters-container">
                <div class="date-range">
                    <form id="dateFilterForm" class="flex gap-3 align-center">
                        <label class="fw-500">Date Range:</label>
                        <input type="date" name="start_date" id="startDate" value="{{ request('start_date') }}">
                        <span>to</span>
                        <input type="date" name="end_date" id="endDate" value="{{ request('end_date') }}">
                        <button type="submit" class="filter-btn btn-green">✔️ Apply</button>
                        <button type="button" class="filter-btn" onclick="clearDateFilter()">❌ Clear</button>
                        <!-- <button type="button" class="filter-btn" onclick="exportCsv()">⬇️ Export CSV</button> -->
                        <div class="search-bar">
                        <span>🔍</span>
                        <input type="text" id="searchInput" placeholder="Search Name or ID #">
                        <span class="cursor-pointer" onclick="clearSearch()">❌</span>
                    </div>
                    </form>

                </div>
                
                <div class="flex align-center gap-3 flex-wrap">
                    <div class="filter-group">
                        <button class="filter-btn active" data-status="all" onclick="filterStatus(event, 'all')">📋 All</button>
                        <button class="filter-btn" data-status="Pending" onclick="filterStatus(event, 'Pending')">⏰ Pending</button>
                        <button class="filter-btn" data-status="Certified" onclick="filterStatus(event, 'Certified')">✅ Certified</button>
                    </div>

                </div>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th onclick="sortTable(0)" class="cursor-pointer">DATE <span>⇅</span></th>
                            <th onclick="sortTable(1)" class="cursor-pointer">ID # <span>⇅</span></th>
                            <th onclick="sortTable(2)" class="cursor-pointer">NAME <span>⇅</span></th>
                            <th onclick="sortTable(3)" class="cursor-pointer">STATUS <span>⇅</span></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="leaveTableBody">
                        @foreach($leaveRequests as $leave)
                        <tr data-id="{{ $leave->id }}" data-date="{{ $leave->created_at }}" data-status="{{ $leave->status }}">
                            <td>
                                <div class="table-date-row">
                                    <span class="icon">🗓️<br>🕒</span>
                                    <div>
                                    {{ \Carbon\Carbon::parse($leave->created_at)->timezone('Asia/Manila')->format('n/j/Y') }}<br>
                                        <span class="fs-sm text-muted">
                                            {{ \Carbon\Carbon::parse($leave->created_at)->timezone('Asia/Manila')->format('g:i A') }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>#{{ $leave->user->id }}</td>
                            <td>{{ strtoupper($leave->user->name) }}</td>
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
                                    <div>
                                            <span >HR CERTIFIED</span>
                                            @if($leave->certified_at)
                                                <br><span class="fs-sm text-muted">{{ \Carbon\Carbon::parse($leave->certified_at)->timezone('Asia/Manila')->format('n/j/Y g:i A') }}</span>
                                            @endif
                                        </div>
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
                                @if($leave->status === 'Pending')
                                    <a href="{{ route('hr.leave-requests.preview', $leave->id) }}" class="icon-btn text-info" title="Preview & Certify">✏️</a>
                                    <button class="icon-btn delete-btn text-danger" title="Delete" onclick="deleteTableRow(this, {{ $leave->id }})">🗑️</button>
                                @else
                                    <button class="icon-btn" title="View Details" onclick="showLeaveForm({{ $leave->id }})">👁‍🗨</button>
                                    <button class="icon-btn delete-btn text-danger" title="Delete" onclick="deleteTableRow(this, {{ $leave->id }})">🗑️</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        
                        @if(count($leaveRequests) === 0)
                        <tr>
                            <td colspan="5" class="text-center p-4">
                                <div class="text-muted fs-md">No leave requests found</div>
                                @if(request('start_date') || request('end_date'))
                                    <button class="filter-btn mt-2" onclick="clearDateFilter()">❌ Clear Filters</button>
                                @endif
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Enhanced Leave Request Preview/Certification Modal -->
    <div id="previewModal" class="modal-overlay" style="display:none;">
        <div class="modal-container">
            <!-- Modal Header -->
            <div class="modal-header">
                <div class="modal-title">
                    <span class="material-icons">description</span>
                    <h2>Leave Request Preview</h2>
                </div>
                <button class="modal-close" onclick="closePreviewModal()" aria-label="Close Preview Modal">
                    <span class="material-icons">close</span>
                </button>
            </div>
            
            <!-- Modal Content -->
            <div class="modal-content">
                <div id="previewContent" class="preview-content"></div>
                
                <!-- Enhanced Certification Form -->
                <form id="certifyForm" class="certify-form">
                    <div class="form-section">
                        <div class="section-header">
                            <span class="material-icons">verified</span>
                            <h3>Leave Certification & Recommendation</h3>
                        </div>
                        
                        <div class="certification-grid">
                            <!-- Leave Credits Section -->
                            <div class="credits-section">
                                <div class="section-title">
                                    <span class="material-icons">schedule</span>
                                    <h4>7.A CERTIFICATION OF LEAVE CREDITS</h4>
                                </div>
                                
                                <div class="date-input">
                                    <label>As of:</label>
                                    <input type="date" name="as_of_date" required>
                                </div>
                                
                                <div class="credits-table">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Vacation Leave</th>
                                                <th>Sick Leave</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="label-cell">Total Earned</td>
                                                <td><input type="text" name="vl_earned" placeholder="0"></td>
                                                <td><input type="text" name="sl_earned" placeholder="0"></td>
                                            </tr>
                                            <tr>
                                                <td class="label-cell">Less this application</td>
                                                <td><input type="text" name="vl_less" placeholder="0"></td>
                                                <td><input type="text" name="sl_less" placeholder="0"></td>
                                            </tr>
                                            <tr>
                                                <td class="label-cell">Balance</td>
                                                <td><input type="text" name="vl_balance" placeholder="0"></td>
                                                <td><input type="text" name="sl_balance" placeholder="0"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="signature-box">
                                    <div class="signature-name">JOY ROSE C. BAWAYAN</div>
                                    <div class="signature-title">Administrative Officer V (HRMO III)</div>
                                    <input type="hidden" name="hr_signatory" value="JOY ROSE C. BAWAYAN|Administrative Officer V (HRMO III)">
                                </div>
                            </div>
                            
                            <!-- Recommendation Section -->
                            <div class="recommendation-section">
                                <div class="section-title">
                                    <span class="material-icons">recommend</span>
                                    <h4>7.B RECOMMENDATION</h4>
                                </div>
                                
                                <div class="recommendation-options">
                                    <label class="checkbox-container">
                                        <input type="checkbox" id="recommendation_approval" name="recommendation" value="approval">
                                        <span class="checkmark"></span>
                                        For approval
                                    </label>
                                    
                                    <label class="checkbox-container">
                                        <input type="checkbox" id="recommendation_disapproval" name="recommendation" value="disapproval">
                                        <span class="checkmark"></span>
                                        For disapproval due to
                                    </label>
                                    
                                    <input type="text" name="disapproval_reason" placeholder="Reason for disapproval" class="disapproval-reason">
                                </div>
                                
                                <div class="remarks-section">
                                    <input type="text" name="other_remarks" placeholder="Additional remarks" class="remark-input">
                                    <input type="text" name="other_remarks2" placeholder="Additional remarks" class="remark-input">
                                    <input type="text" name="other_remarks3" placeholder="Additional remarks" class="remark-input">
                                </div>
                                
                                <div class="signature-box">
                                    <div class="signature-name" id="adminNameDisplay">AIDA Y. PAGTAN</div>
                                    <div class="signature-title" id="adminPositionDisplay">Chief, Administrative and Finance Division</div>
                                    <input type="hidden" name="admin_signatory" id="adminSignatoryInput" value="AIDA Y. PAGTAN|Chief, Administrative and Finance Division">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Approval Section -->
                        <div class="approval-section">
                            <div class="approval-grid">
                                <div class="approval-left">
                                    <div class="section-title">
                                        <span class="material-icons">check_circle</span>
                                        <h4>7.C APPROVED FOR:</h4>
                                    </div>
                                    <div class="approval-inputs">
                                        <div class="input-group">
                                            <input type="text" name="days_with_pay" placeholder="0">
                                            <label>days with pay</label>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" name="days_without_pay" placeholder="0">
                                            <label>days without pay</label>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" name="others_specify" placeholder="0">
                                            <label>others (Specify)</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="approval-right">
                                    <div class="section-title">
                                        <span class="material-icons">cancel</span>
                                        <h4>7.D DISAPPROVED DUE TO:</h4>
                                    </div>
                                    <div class="disapproval-inputs">
                                        <input type="text" name="disapproval_reason1" placeholder="Reason for disapproval">
                                        <input type="text" name="disapproval_reason2" placeholder="Additional reason">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Director Signature -->
                        <div class="director-signature">
                            <div class="signature-name">Atty. JENNILYN M. DAWAYAN, CESO IV</div>
                            <div class="signature-title">Regional Executive Director</div>
                            <input type="hidden" name="director_signatory" value="Atty. JENNILYN M. DAWAYAN, CESO IV|Regional Executive Director">
                        </div>
                    </div>
                    
                    <input type="hidden" name="leave_id" id="leave_id">
                    
                    <!-- Action Buttons -->
                    <div class="modal-actions">
                        <button type="button" onclick="discardEdit()" class="btn btn-secondary">
                            <span class="material-icons">cancel</span>
                            Discard
                        </button>
                        <button type="button" id="rejectBtn" class="btn btn-secondary bg-danger text-white">
                            <span class="material-icons">block</span>
                            Reject
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span class="material-icons">save</span>
                            Save Certification
                        </button>
                    </div>
                </form>
                
                <!-- Close Only Button -->
                <div id="closeOnly" class="modal-actions" style="display:none;">
                    <button type="button" onclick="closePreviewModal()" class="btn btn-secondary" aria-label="Close Modal">
                        <span class="material-icons">close</span>
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal (hidden by default) -->
    <div id="rejectModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.25); z-index:3000; align-items:center; justify-content:center;">
        <div style="background:#fff; border-radius:16px; max-width:420px; width:95%; max-height:90vh; overflow-y:auto; margin:20px auto; padding:28px 22px 20px 22px; box-shadow:0 8px 32px rgba(0,0,0,0.15); position:relative;">
            <h2 style="text-align:center; margin-bottom:18px; color:#e53935; font-size:1.2em;">
                <span class="material-icons" style="vertical-align:middle; margin-right:8px;">block</span>
                Reject Leave Request
            </h2>
            <textarea id="rejectionComment" rows="4" style="width:100%; border-radius:8px; border:1.5px solid #e53935; margin-bottom:18px; font-size:1em;" placeholder="Enter reason for rejection (required)"></textarea>
            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" onclick="closeRejectModal()" class="btn btn-secondary">Cancel</button>
                <button type="button" onclick="confirmReject()" class="btn btn-primary" style="background:#e53935; color:white;">Reject</button>
            </div>
        </div>
    </div>

    <!-- Add/replace the change password modal markup at the end of the body -->
    <div id="changePasswordModal">
        <div>
            <h2>
                <span>🔐</span>
                Change Password
            </h2>
            <form id="changePasswordForm">
                <div>
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div>
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div>
                    <label for="new_password_confirmation">Confirm New Password</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
                </div>
                <div id="changePasswordMsg"></div>
                <div class="modal-actions">
                    <button type="button" onclick="closeChangePasswordModal()" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Change</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const leaveRequests = @json($leaveRequests);
        let editingLeaveId = null;
        let currentSort = { column: -1, direction: 'asc' };
        let currentPreviewData = null;
        
        // Function to format inclusive dates
        function formatInclusiveDates(dates) {
            if (!dates) return '';
            
            try {
                let dateArray = dates;
                if (typeof dates === 'string') {
                    dateArray = JSON.parse(dates);
                }
                
                if (!Array.isArray(dateArray)) return dates;
                
                const formattedDates = dateArray.map(dateRange => {
                    if (dateRange.includes(' to ')) {
                        const [start, end] = dateRange.split(' to ');
                        const startDate = new Date(start.trim());
                        const endDate = new Date(end.trim());
                        
                        const formatDate = (date) => {
                            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                            return `${months[date.getMonth()]} ${date.getDate()}, ${date.getFullYear()}`;
                        };
                        
                        return `${formatDate(startDate)} to ${formatDate(endDate)}`;
                    } else {
                        const date = new Date(dateRange.trim());
                        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                        return `${months[date.getMonth()]} ${date.getDate()}, ${date.getFullYear()}`;
                    }
                });
                
                return formattedDates.join(', ');
            } catch (e) {
                return dates;
            }
        }
        
        // Menu toggle for mobile
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        function showPreviewModal(id) {
            renderPreviewModal(id);
        }

        function showLeaveForm(id) {
            // Open the leave form in a new window/tab like the print view
            window.open(`/leave/print/${id}`, '_blank');
        }

        function showEditModal(id) {
            // Always hide the reject modal if open
            const rejectModal = document.getElementById('rejectModal');
            if (rejectModal) rejectModal.style.display = 'none';
            // Reset any previous editing state first
            editingLeaveId = null;
            currentPreviewData = null;
            // Get the form and reset it
            const certifyForm = document.getElementById('certifyForm');
            if (certifyForm) {
                certifyForm.reset();
                certifyForm.style.display = 'block';
                certifyForm.classList.remove('hidden');
            }
            // Set the new editing state
            editingLeaveId = id;
            const leave = leaveRequests.find(l => l.id === id);
            if (!leave) return;
            // Store the current leave data for preview updates
            currentPreviewData = leave;
            // Fill the preview content
            fillPreviewContent(leave);
            // Set the leave ID in the hidden field
            const leaveIdField = document.getElementById('leave_id');
            if (leaveIdField) {
                leaveIdField.value = id;
            }
            // Update admin signatory if available in the leave request
            if (leave.admin_signatory) {
                const adminParts = leave.admin_signatory.split('|');
                const adminName = adminParts[0] || '';
                const adminPosition = adminParts[1] || 'Division Chief';
                document.getElementById('adminNameDisplay').textContent = adminName;
                document.getElementById('adminPositionDisplay').textContent = adminPosition;
                document.getElementById('adminSignatoryInput').value = leave.admin_signatory;
            }
            // Show the edit form and hide the close-only button
            if (certifyForm) {
                certifyForm.style.display = 'block';
                certifyForm.classList.remove('hidden');
            }
            const closeOnly = document.getElementById('closeOnly');
            if (closeOnly) {
                closeOnly.style.display = 'none';
            }
            const previewModal = document.getElementById('previewModal');
            if (previewModal) {
                previewModal.style.display = 'flex';
                previewModal.style.zIndex = 4000;
                document.body.style.overflow = 'hidden';
            }
            // Add event listeners to update the preview in real-time
            setupSignatoryListeners();
        }
        
        function setupSignatoryListeners() {
            // Add event listeners to update preview when form fields change
            const recommendationApproval = document.getElementById('recommendation_approval');
            const recommendationDisapproval = document.getElementById('recommendation_disapproval');
            const disapprovalReason = document.getElementById('disapproval_reason');
            const otherRemarks = document.getElementById('other_remarks');
            const otherRemarks2 = document.getElementById('other_remarks2');
            const otherRemarks3 = document.getElementById('other_remarks3');
            
            // Only add event listeners if elements exist
            if (recommendationApproval) recommendationApproval.addEventListener('change', updatePreviewSignatories);
            if (recommendationDisapproval) recommendationDisapproval.addEventListener('change', updatePreviewSignatories);
            if (disapprovalReason) disapprovalReason.addEventListener('input', updatePreviewSignatories);
            if (otherRemarks) otherRemarks.addEventListener('input', updatePreviewSignatories);
            if (otherRemarks2) otherRemarks2.addEventListener('input', updatePreviewSignatories);
            if (otherRemarks3) otherRemarks3.addEventListener('input', updatePreviewSignatories);
        }
        
        function updatePreviewSignatories() {
            if (!currentPreviewData) return;
            
            // Create a temporary certification data object with the current form values
            const tempCertData = {
                hr_signatory: document.querySelector('input[name="hr_signatory"]')?.value || 'JOY ROSE C. BAWAYAN|Administrative Officer V (HRMO III)',
                admin_signatory: document.querySelector('input[name="admin_signatory"]')?.value || 'AIDA Y. PAGTAN|Chief, Administrative and Finance Division',
                director_signatory: document.querySelector('input[name="director_signatory"]')?.value || 'Atty. JENNILYN M. DAWAYAN, CESO IV|Regional Executive Director',
                recommendation: document.getElementById('recommendation_approval')?.checked ? 'approval' : 'disapproval',
                disapproval_reason: document.getElementById('disapproval_reason')?.value || '',
                other_remarks: document.getElementById('other_remarks')?.value || '',
                other_remarks2: document.getElementById('other_remarks2')?.value || '',
                other_remarks3: document.getElementById('other_remarks3')?.value || ''
            };
            
            // Create a temporary leave object with the current certification data
            const tempLeave = {...currentPreviewData};
            
            // If there's existing certification data, merge it with our temporary data
            if (tempLeave.certification_data) {
                let existingData = {};
                try {
                    existingData = typeof tempLeave.certification_data === 'string' 
                        ? JSON.parse(tempLeave.certification_data) 
                        : tempLeave.certification_data;
                } catch (e) {}
                
                tempLeave.certification_data = JSON.stringify({...existingData, ...tempCertData});
            } else {
                tempLeave.certification_data = JSON.stringify(tempCertData);
            }
            
            // Re-render the preview content with updated signatories
            fillPreviewContent(tempLeave);
        }

        function fillPreviewContent(leave) {
            // Check if leave has admin_signatory
            let adminSignatoryInfo = '';
            if (leave.admin_signatory) {
                const parts = leave.admin_signatory.split('|');
                if (parts.length > 1) {
                    adminSignatoryInfo = `<div><strong>Division Chief:</strong> ${parts[0]} (${parts[1]})</div>`;
                } else {
                    adminSignatoryInfo = `<div><strong>Division Chief:</strong> ${leave.admin_signatory}</div>`;
                }
            }
            
            let html = `
                <div class="preview-grid">
                    <div class="preview-item">
                        <span class="material-icons">event</span>
                        <div>
                            <strong>Date Filed:</strong> ${leave.created_at ? new Date(leave.created_at).toLocaleDateString() : ''}
                        </div>
                    </div>
                    <div class="preview-item">
                        <span class="material-icons">badge</span>
                        <div>
                            <strong>ID #:</strong> #${leave.user ? leave.user.id : ''}
                        </div>
                    </div>
                    <div class="preview-item">
                        <span class="material-icons">person</span>
                        <div>
                            <strong>Name:</strong> ${leave.user ? leave.user.name.toUpperCase() : ''}
                        </div>
                    </div>
                    <div class="preview-item">
                        <span class="material-icons">business</span>
                        <div>
                            <strong>Office:</strong> ${leave.office || (leave.user ? leave.user.offices : '') || 'Department of Agriculture'}
                        </div>
                    </div>
                    <div class="preview-item">
                        <span class="material-icons">${leave.status === 'Pending' ? 'schedule' : leave.status === 'Rejected' ? 'block' : 'check_circle'}</span>
                        <div>
                            <strong>Status:</strong> <span style="color:${leave.status === 'Rejected' ? '#e53935' : leave.status === 'Certified' ? '#00a651' : '#222'}">${leave.status === 'Rejected' ? 'REJECTED' : (leave.status === 'Certified' ? 'HR CERTIFIED' : leave.status)}</span>
                        </div>
                    </div>
                    ${adminSignatoryInfo ? `<div class="preview-item">
                        <span class="material-icons">admin_panel_settings</span>
                        <div>${adminSignatoryInfo.replace('<div>', '').replace('</div>', '')}</div>
                    </div>` : ''}
                    <div class="preview-item">
                        <span class="material-icons">category</span>
                        <div>
                            <strong>Type of Leave:</strong> ${(Array.isArray(leave.leave_type) ? leave.leave_type.join(', ') : (leave.leave_type ? JSON.parse(leave.leave_type).join(', ') : ''))}
                        </div>
                    </div>
                    ${leave.leave_type_other ? `<div class="preview-item">
                        <span class="material-icons">more_horiz</span>
                        <div><strong>Other Type:</strong> ${leave.leave_type_other}</div>
                    </div>` : ''}
                    ${leave.within_ph ? `<div class="preview-item">
                        <span class="material-icons">location_on</span>
                        <div><strong>Within PH:</strong> ${leave.within_ph}</div>
                    </div>` : ''}
                    ${leave.abroad ? `<div class="preview-item">
                        <span class="material-icons">flight</span>
                        <div><strong>Abroad:</strong> ${leave.abroad}</div>
                    </div>` : ''}
                    ${leave.in_hospital ? `<div class="preview-item">
                        <span class="material-icons">local_hospital</span>
                        <div><strong>In Hospital:</strong> ${leave.in_hospital}</div>
                    </div>` : ''}
                    ${leave.out_patient ? `<div class="preview-item">
                        <span class="material-icons">medical_services</span>
                        <div><strong>Out Patient:</strong> ${leave.out_patient}</div>
                    </div>` : ''}
                    ${leave.special_leave ? `<div class="preview-item">
                        <span class="material-icons">star</span>
                        <div><strong>Special Leave:</strong> ${leave.special_leave}</div>
                    </div>` : ''}
                    
                    <!-- Study Leave Options -->
                    ${leave.study_leave ? `<div class="preview-item">
                        <span class="material-icons">school</span>
                        <div><strong>Study Leave:</strong> ${leave.study_leave}</div>
                    </div>` : ''}
                    ${leave.completion_masters === 'Yes' ? `<div class="preview-item">
                        <span class="material-icons">graduation_cap</span>
                        <div><strong>Completion of Master's Degree:</strong> Yes</div>
                    </div>` : ''}
                    ${leave.bar_exam === 'Yes' ? `<div class="preview-item">
                        <span class="material-icons">gavel</span>
                        <div><strong>BAR/Board Examination Review:</strong> Yes</div>
                    </div>` : ''}
                    
                    <!-- Other Purpose Options -->
                    ${leave.other_purpose ? `<div class="preview-item">
                        <span class="material-icons">help</span>
                        <div><strong>Other Purpose:</strong> ${leave.other_purpose}</div>
                    </div>` : ''}
                    ${leave.monetization === 'Yes' ? `<div class="preview-item">
                        <span class="material-icons">attach_money</span>
                        <div><strong>Monetization of Leave Credits:</strong> Yes</div>
                    </div>` : ''}
                    ${leave.terminal_leave === 'Yes' ? `<div class="preview-item">
                        <span class="material-icons">exit_to_app</span>
                        <div><strong>Terminal Leave:</strong> Yes</div>
                    </div>` : ''}
                    
                    ${leave.num_days ? `<div class="preview-item">
                        <span class="material-icons">calendar_today</span>
                        <div><strong>Number of Days:</strong> ${leave.num_days}</div>
                    </div>` : ''}
                    ${leave.inclusive_dates ? `<div class="preview-item">
                        <span class="material-icons">date_range</span>
                        <div><strong>Inclusive Dates:</strong> ${formatInclusiveDates(leave.inclusive_dates)}</div>
                    </div>` : ''}
                    ${leave.commutation ? `<div class="preview-item">
                        <span class="material-icons">swap_horiz</span>
                        <div><strong>Commutation:</strong> ${leave.commutation}</div>
                    </div>` : ''}
                    
                    <!-- Attachments Section -->
                    ${leave.attachments ? (() => {
                        let attachments = leave.attachments;
                        if (typeof attachments === 'string') {
                            try {
                                attachments = JSON.parse(attachments);
                            } catch (e) {
                                attachments = [];
                            }
                        }
                        if (Array.isArray(attachments) && attachments.length > 0) {
                            let attachmentsHtml = '<div class="preview-item" style="grid-column: 1 / -1; margin-top: 20px;">';
                            attachmentsHtml += '<span class="material-icons">attach_file</span>';
                            attachmentsHtml += '<div><strong>Attachments:</strong></div>';
                            attachmentsHtml += '<div style="margin-top: 10px;">';
                            attachments.forEach(attachment => {
                                const fileIcon = attachment.mime_type && attachment.mime_type.includes('pdf') ? 'picture_as_pdf' :
                                                attachment.mime_type && attachment.mime_type.includes('image') ? 'image' :
                                                attachment.mime_type && (attachment.mime_type.includes('word') || attachment.mime_type.includes('document')) ? 'description' :
                                                'attach_file';
                                const fileSize = attachment.size ? (attachment.size / 1024).toFixed(1) + ' KB' : '';
                                const uploadDate = attachment.uploaded_at ? new Date(attachment.uploaded_at).toLocaleDateString() : '';
                                
                                attachmentsHtml += `<div style="display: flex; align-items: center; justify-content: space-between; padding: 8px; margin: 5px 0; background: #f8f9fa; border-radius: 4px; border: 1px solid #dee2e6;">`;
                                attachmentsHtml += `<div style="display: flex; align-items: center; gap: 8px;">`;
                                attachmentsHtml += `<span class="material-icons" style="color: #6c757d; font-size: 20px;">${fileIcon}</span>`;
                                attachmentsHtml += `<div>`;
                                attachmentsHtml += `<div style="font-weight: 500;">${attachment.filename || 'Unknown file'}</div>`;
                                attachmentsHtml += `<div style="font-size: 0.85em; color: #6c757d;">${fileSize}${uploadDate ? ' • ' + uploadDate : ''}</div>`;
                                attachmentsHtml += `</div></div>`;
                                attachmentsHtml += `<div>`;
                                attachmentsHtml += `<a href="/storage/${attachment.path}" target="_blank" style="background: #007bff; color: white; padding: 4px 8px; border-radius: 3px; text-decoration: none; font-size: 0.8em; margin-right: 5px;">View</a>`;
                                attachmentsHtml += `<a href="/storage/${attachment.path}" download="${attachment.filename}" style="background: #28a745; color: white; padding: 4px 8px; border-radius: 3px; text-decoration: none; font-size: 0.8em;">Download</a>`;
                                attachmentsHtml += `</div></div>`;
                            });
                            attachmentsHtml += '</div></div>';
                            return attachmentsHtml;
                        }
                        return '';
                    })() : ''}
                </div>
            `;
            // Show rejection comment if rejected
            if (leave.status === 'Rejected' && leave.certification_data) {
                let cert = {};
                try {
                    cert = typeof leave.certification_data === 'string' ? JSON.parse(leave.certification_data) : leave.certification_data;
                } catch (e) {}
                html += `<div style="margin:24px 0 0 0; padding:18px; background:#fff5f5; border:1.5px solid #e53935; border-radius:12px;">
                    <span class="material-icons" style="color:#e53935; vertical-align:middle;">block</span>
                    <span style="color:#1e40af; font-weight:700; font-size:1.1em;">🚫 Rejected by HR</span><br>
                    <strong>Reason:</strong> <span style="color:#c53030;">${cert.rejection_comment || 'No comment provided.'}</span><br>
                    <span style="font-size:0.95em; color:#888;">${cert.rejected_by ? 'By: ' + cert.rejected_by : ''} ${cert.rejected_at ? 'on ' + new Date(cert.rejected_at).toLocaleString() : ''}</span>
                </div>`;
            }

            // If certified or we're in edit mode, show certification data
            if ((leave.status === 'Certified' && leave.certification_data) || (editingLeaveId && document.getElementById('certifyForm').style.display !== 'none')) {
                let cert = {};
                try {
                    cert = typeof leave.certification_data === 'string'
                        ? JSON.parse(leave.certification_data)
                        : leave.certification_data;
                    if (!cert || typeof cert !== 'object') cert = {};
                } catch (e) { cert = {}; }
                // If we're in edit mode, get values from the form for signatory fields if they exist
                if (editingLeaveId && document.getElementById('certifyForm').style.display !== 'none') {
                    // Ensure cert is always an object
                    if (!cert || typeof cert !== 'object') cert = {};
                    const hrSignatory = document.getElementById('hr_signatory');
                    const adminSignatory = document.getElementById('admin_signatory');
                    const directorSignatory = document.getElementById('director_signatory');
                    if (hrSignatory) cert.hr_signatory = hrSignatory.value;
                    if (adminSignatory) cert.admin_signatory = adminSignatory.value;
                    if (directorSignatory) cert.director_signatory = directorSignatory.value;
                    // Get other form values
                    cert.recommendation = document.getElementById('recommendation_approval')?.checked ? 'approval' : 
                                         (document.getElementById('recommendation_disapproval')?.checked ? 'disapproval' : '');
                    cert.disapproval_reason = document.getElementById('disapproval_reason')?.value || '';
                    cert.other_remarks = document.getElementById('other_remarks')?.value || '';
                    cert.other_remarks2 = document.getElementById('other_remarks2')?.value || '';
                    cert.other_remarks3 = document.getElementById('other_remarks3')?.value || '';
                }

                // Process signatory data (split name and position)
                let hrName = 'JOY ROSE C. BAWAYAN';
                let hrPosition = 'Administrative Officer V (HRMO III)';
                if (cert.hr_signatory) {
                    const hrParts = cert.hr_signatory.split('|');
                    if (hrParts.length > 1) {
                        hrName = hrParts[0];
                        hrPosition = hrParts[1];
                    } else {
                        hrName = cert.hr_signatory;
                    }
                }
                
                let adminName = 'AIDA Y. PAGTAN';
                let adminPosition = 'Chief, Administrative and Finance Division';
                
                // First try to get from leave.admin_signatory
                if (leave.admin_signatory) {
                    const adminParts = leave.admin_signatory.split('|');
                    if (adminParts.length > 1) {
                        adminName = adminParts[0];
                        adminPosition = adminParts[1] || 'Division Chief';
                    } else {
                        adminName = leave.admin_signatory;
                        adminPosition = 'Division Chief';
                    }
                }
                // If not found, try from certification data
                else if (cert.admin_signatory) {
                    const adminParts = cert.admin_signatory.split('|');
                    if (adminParts.length > 1) {
                        adminName = adminParts[0];
                        adminPosition = adminParts[1];
                    } else {
                        adminName = cert.admin_signatory;
                    }
                }
                
                let directorName = 'Atty. JENNILYN M. DAWAYAN, CESO IV';
                let directorPosition = 'Regional Executive Director';
                if (cert.director_signatory) {
                    const directorParts = cert.director_signatory.split('|');
                    if (directorParts.length > 1) {
                        directorName = directorParts[0];
                        directorPosition = directorParts[1];
                    } else {
                        directorName = cert.director_signatory;
                    }
                }

                html += `
                    <div class="certification-preview">
                        <div class="cert-section">
                            <h3><span class="material-icons">schedule</span> CERTIFICATION OF LEAVE CREDITS</h3>
                            <div class="cert-date">
                                <span class="material-icons">event</span>
                                <span><strong>As of:</strong> ${cert.as_of_date ? new Date(cert.as_of_date).toLocaleDateString() : '-'}</span>
                            </div>
                            <div class="cert-table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Vacation Leave</th>
                                            <th>Sick Leave</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="label-cell">Total Earned</td>
                                            <td class="text-center">${cert.vl_earned ?? '-'}</td>
                                            <td class="text-center">${cert.sl_earned ?? '-'}</td>
                                        </tr>
                                        <tr>
                                            <td class="label-cell">Less this application</td>
                                            <td class="text-center">${cert.vl_less ?? '-'}</td>
                                            <td class="text-center">${cert.sl_less ?? '-'}</td>
                                        </tr>
                                        <tr>
                                            <td class="label-cell">Balance</td>
                                            <td class="text-center">${cert.vl_balance ?? '-'}</td>
                                            <td class="text-center">${cert.sl_balance ?? '-'}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="signature-preview">
                                <div class="signature-name">${hrName}</div>
                                <div class="signature-title">${hrPosition}</div>
                            </div>
                        </div>
                        
                        <div class="cert-section">
                            <h3><span class="material-icons">recommend</span> RECOMMENDATION</h3>
                            <div class="recommendation-preview">
                                <div class="checkbox-preview ${cert.recommendation === 'approval' ? 'checked' : ''}">
                                    <span class="material-icons">${cert.recommendation === 'approval' ? 'check_circle' : 'radio_button_unchecked'}</span>
                                    <span>For approval</span>
                                </div>
                                <div class="checkbox-preview ${cert.recommendation === 'disapproval' ? 'checked' : ''}">
                                    <span class="material-icons">${cert.recommendation === 'disapproval' ? 'check_circle' : 'radio_button_unchecked'}</span>
                                    <span>For disapproval due to: ${cert.disapproval_reason || ''}</span>
                                </div>
                            </div>
                            
                            ${cert.other_remarks ? `<div class="remark-preview">${cert.other_remarks}</div>` : ''}
                            ${cert.other_remarks2 ? `<div class="remark-preview">${cert.other_remarks2}</div>` : ''}
                            ${cert.other_remarks3 ? `<div class="remark-preview">${cert.other_remarks3}</div>` : ''}
                            
                            <div class="signature-preview">
                                <div class="signature-name">${adminName}</div>
                                <div class="signature-title">${adminPosition}</div>
                            </div>
                        </div>
                        
                        <div class="cert-section">
                            <h3><span class="material-icons">check_circle</span> APPROVAL DETAILS</h3>
                            <div class="approval-preview">
                                <div class="approval-item">
                                    <span class="material-icons">calendar_today</span>
                                    <span><strong>Days with pay:</strong> ${cert.days_with_pay || '___'}</span>
                                </div>
                                <div class="approval-item">
                                    <span class="material-icons">event_busy</span>
                                    <span><strong>Days without pay:</strong> ${cert.days_without_pay || '___'}</span>
                                </div>
                                <div class="approval-item">
                                    <span class="material-icons">more_horiz</span>
                                    <span><strong>Others:</strong> ${cert.others_specify || '___'}</span>
                                </div>
                            </div>
                            
                            ${cert.disapproval_reason1 ? `<div class="disapproval-preview">
                                <span class="material-icons">cancel</span>
                                <span><strong>Disapproved due to:</strong> ${cert.disapproval_reason1}</span>
                            </div>` : ''}
                            ${cert.disapproval_reason2 ? `<div class="disapproval-preview">${cert.disapproval_reason2}</div>` : ''}
                            
                            <div class="signature-preview director">
                                <div class="signature-name">${directorName}</div>
                                <div class="signature-title">${directorPosition}</div>
                            </div>
                        </div>
                    </div>
                `;
            }

            document.getElementById('previewContent').innerHTML = html;
        }

        function renderPreviewModal(id) {
            // Reset any editing state
            editingLeaveId = null;
            currentPreviewData = null;
            
            // Reset the form if it exists
            const certifyForm = document.getElementById('certifyForm');
            if (certifyForm) {
                certifyForm.reset();
                certifyForm.style.display = 'none';
            }
            
            // Find the leave request
            const leave = leaveRequests.find(l => l.id === id);
            if (!leave) return;
            
            // Fill the preview content
            fillPreviewContent(leave);
            
            // Show the close-only button and hide the edit form
            const closeOnly = document.getElementById('closeOnly');
            if (closeOnly) {
                closeOnly.style.display = 'flex';
            }
            
            const previewModal = document.getElementById('previewModal');
            if (previewModal) {
                previewModal.style.display = 'flex';
                
                // Add body overflow control for better mobile experience
                document.body.style.overflow = 'hidden';
            }
        }
        
        function closePreviewModal() {
            const modal = document.getElementById('previewModal');
            modal.style.display = 'none';
            
            // Reset editing state to allow future edits
            editingLeaveId = null;
            currentPreviewData = null;
            
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
                document.querySelector('.stat-card:nth-child(3) .count').textContent = data.rejected;
                document.querySelector('.stat-card:nth-child(4) .count').textContent = data.total;
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

            // Get deleted rows from localStorage
            let deleted = [];
            try {
                deleted = JSON.parse(localStorage.getItem('deletedHRRows') || '[]');
            } catch (e) { deleted = []; }

            // Filter rows
            const rows = document.querySelectorAll('#leaveTableBody tr');
            let visibleCount = 0;
            rows.forEach(row => {
                if (!row.hasAttribute('data-id')) return; // Skip "no results" row
                const rowId = row.getAttribute('data-id');
                if (deleted.includes(Number(rowId)) || deleted.includes(rowId)) {
                    row.style.display = 'none';
                    return;
                }
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
        function exportCsv() {
            const params = new URLSearchParams();
            const s = document.getElementById('startDate').value;
            const e = document.getElementById('endDate').value;
            if (s) params.append('start_date', s);
            if (e) params.append('end_date', e);
            const activeBtn = document.querySelector('.filter-btn.active');
            const status = activeBtn ? activeBtn.getAttribute('data-status') : 'all';
            if (status && status !== 'all') params.append('status', status);
            const url = '/hr/leave-requests/export' + (params.toString() ? ('?' + params.toString()) : '');
            window.location.href = url;
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

        function discardEdit() {
            // Reset editing state completely
            editingLeaveId = null;
            currentPreviewData = null;
            
            // Hide the modal
            const modal = document.getElementById('previewModal');
            modal.style.display = 'none';
            
            // Restore body scrolling
            document.body.style.overflow = '';
            
            // Reset the form
            const form = document.getElementById('certifyForm');
            if (form) {
                form.reset();
                form.style.display = 'none';
            }
            
            // Show the close-only button
            const closeOnly = document.getElementById('closeOnly');
            if (closeOnly) {
                closeOnly.style.display = 'flex';
            }
        }

        function deleteTableRow(btn, rowId) {
            if (confirm('Are you sure you want to hide this request? This action will only hide it from your view.')) {
                // Find the row and remove it from the DOM
                const row = btn.closest('tr');
                if (row) row.remove();
                // Store the deleted row ID in localStorage
                let deleted = JSON.parse(localStorage.getItem('deletedHRRows') || '[]');
                if (!deleted.includes(rowId)) {
                    deleted.push(rowId);
                    localStorage.setItem('deletedHRRows', JSON.stringify(deleted));
                }
            }
        }

        // On page load, hide rows that are in localStorage
        window.addEventListener('DOMContentLoaded', function() {
            let deleted = JSON.parse(localStorage.getItem('deletedHRRows') || '[]');
            deleted.forEach(function(rowId) {
                const row = document.querySelector('tr[data-id="' + rowId + '"]');
                if (row) row.style.display = 'none';
            });
        });

        // Add reject button logic
        const rejectBtn = document.getElementById('rejectBtn');
        const rejectModal = document.getElementById('rejectModal');
        function closeRejectModal() {
            rejectModal.style.display = 'none';
        }
        if (rejectBtn) {
            rejectBtn.onclick = function() {
                // Always set editingLeaveId to the current leave being previewed if not set
                if (!editingLeaveId && currentPreviewData && currentPreviewData.id) {
                    editingLeaveId = currentPreviewData.id;
                }
                document.getElementById('rejectionComment').value = '';
                // Hide the preview modal
                const previewModal = document.getElementById('previewModal');
                if (previewModal) previewModal.style.display = 'none';
                // Show the reject modal
                rejectModal.style.display = 'flex';
            };
        }
        async function confirmReject() {
            const comment = document.getElementById('rejectionComment').value.trim();
            if (!comment) {
                alert('Please enter a reason for rejection.');
                return;
            }
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            // Send all required fields for validation
            const data = {
                leave_id: editingLeaveId,
                action: 'reject',
                rejection_comment: comment,
                as_of_date: '2000-01-01', // dummy value to satisfy required_if
                vl_earned: '',
                sl_earned: '',
                vl_less: '',
                sl_less: '',
                vl_balance: '',
                sl_balance: ''
            };
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
                    closeRejectModal();
                    closePreviewModal();
                    refreshDashboardData();
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
                    successMessage.innerHTML = '<span class="material-icons" style="margin-right:8px;">check_circle</span> Leave request rejected.';
                    document.body.appendChild(successMessage);
                    setTimeout(() => { successMessage.remove(); }, 3000);
                } else {
                    const error = await response.json();
                    alert('Rejection failed: ' + (error.message || JSON.stringify(error.errors)));
                }
            } catch (error) {
                alert('An error occurred. Please try again.');
            }
        }

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
        // Logout button logic
        const logoutBtn = document.getElementById('logoutBtn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('logout-form').submit();
            });
        }
    </script>
</body>
</html>


