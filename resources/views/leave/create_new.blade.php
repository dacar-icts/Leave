<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application for Leave</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('css/leave_application_form.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    

    
    <div class="main-content">
        <div class="header">
            <div class="header-title">Application for Leave</div>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            <span class="material-icons">arrow_back</span>
                            Back to Dashboard
                        </a>
        </div>

        
        <div class="dashboard-body">
            @if(session('error'))
                <div class="alert alert-error">
                    <span class="material-icons">error</span>
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="form-container">
                <form action="{{ route('leave.store') }}" method="POST">
                    @csrf
                    
                    <div class="official-form">
                        <!-- Form Header -->

                        <div class="form-header">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/e/e9/Department_of_Agriculture_of_the_Philippines.svg" alt="Department of Agriculture Logo" class="logo">
                            <div class="header-text">
                                <h1>Republic of the Philippines</h1>
                                <h2>DEPARTMENT OF AGRICULTURE</h2>
                                <h3>Cordillera Administrative Region</h3>
                                <h3>BPI Compound, Easter Road, Guisad, Baguio City</h3>
                            </div>
                            <div class="stamp-box">
                                Stamp of Date of Receipt
                            </div>
                        </div>
                        
                        <!-- Form Title -->
                        <div class="form-title">APPLICATION FOR LEAVE</div>
                        
                        <!-- Form Content -->
                        <div class="form-row">
                            <div class="form-cell form-cell-half">
                                <div class="form-label">1. OFFICE/DEPARTMENT</div>
                                @php
                                    $officeFull = auth()->user()->offices ?? '';
                                    if (preg_match('/\(([^)]+)\)/', $officeFull, $matches)) {
                                        $officeShortcut = $matches[1];
                                    } else {
                                        $officeShortcut = '';
                                    }
                                @endphp
                                <input type="text" class="form-input" name="office" value="{{ $officeShortcut }}" readonly>
                            </div>
                            <div class="form-cell form-cell-half">
                                <div class="form-label">2. NAME : (Last) (First) (Middle)</div>
                                <input type="text" class="form-input" name="name" value="{{ auth()->user()->name }}" readonly>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-cell form-cell-third">
                                <div class="form-label">3. DATE OF FILING</div>
                                <input type="text" class="form-input" name="filing_date" value="{{ date('m/d/Y') }}" readonly>
                            </div>
                            <div class="form-cell form-cell-third">
                                <div class="form-label">4. POSITION</div>
                                <input type="text" class="form-input" name="position" value="{{ auth()->user()->position ?? 'Employee' }}" readonly>
                            </div>
                            <div class="form-cell form-cell-third">
                                <div class="form-label">5. SALARY</div>
                                <input type="text" class="form-input" name="salary" placeholder="Enter your salary">
                            </div>
                        </div>
                        
                        
                        <div class="form-section-title">6. DETAILS OF APPLICATION</div>
                        
                        <div class="form-row">
                            <div class="form-cell form-cell-half">
                                <div class="form-label">6.A TYPE OF LEAVE TO BE AVAILED OF</div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="leave_type[]" value="Vacation Leave">
                                        Vacation Leave <span class="small-text">(Sec. 51, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</span>
                                    </label>
                                </div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="leave_type[]" value="Mandatory/Forced Leave">
                                        Mandatory/Forced Leave<span class="small-text">(Sec. 25, Rule XVI, Omnibus Rules Implementing E.O. No.292)</span>
                                    </label>
                                </div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="leave_type[]" value="Sick Leave">
                                        Sick Leave <span class="small-text">(Sec. 43, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</span>
                                    </label>
                                </div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="leave_type[]" value="Maternity Leave">
                                        Maternity Leave <span class="small-text">(R.A. No. 11210/IRR issued by CSC, DOLE and SSS)</span>
                                    </label>
                                </div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="leave_type[]" value="Paternity Leave">
                                        Paternity Leave <span class="small-text">(R.A. No. 8187/CSC MC No. 71, s. 1998, as amended)</span>
                                    </label>
                                </div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="leave_type[]" value="Special Privilege Leave">
                                        Special Privilege Leave <span class="small-text">(Sec. 21, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</span>
                                    </label>
                                </div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="leave_type[]" value="Solo Parent Leave">
                                        Solo Parent Leave <span class="small-text">(RA No. 8972/CSC MC No. 8, s. 2004)</span>
                                    </label>
                                </div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="leave_type[]" value="Study Leave">
                                        Study Leave <span class="small-text">(Sec. 68, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</span>
                                    </label>
                                </div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="leave_type[]" value="10-Day VAWC Leave">
                                        10-Day VAWC Leave <span class="small-text">(RA No. 9262/CSC MC No. 15, s. 2005)</span>
                                    </label>
                                </div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="leave_type[]" value="Rehabilitation Privilege">
                                        Rehabilitation Privilege <span class="small-text">(Sec. 55, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</span>
                                    </label>
                                </div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="leave_type[]" value="Special Leave Benefits for Women">
                                        Special Leave Benefits for Women <span class="small-text">(RA No. 9710/CSC MC No. 25, s. 2010)</span>
                                    </label>
                                </div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="leave_type[]" value="Special Emergency (Calamity) Leave">
                                        Special Emergency (Calamity) Leave <span class="small-text">(CSC MC No. 2, s. 2012, as amended)</span>
                                    </label>
                                </div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="leave_type[]" value="Adoption Leave">
                                        Adoption Leave <span class="small-text">(R.A. No. 8552)</span>
                                    </label>
                                </div>
                                
                                <div class="form-group">
                                    <div class="form-label">Others:</div>
                                    <input type="text" class="form-input" name="leave_type_other" placeholder="Specify other leave types">
                                </div>
                            </div>
                            <div class="form-cell form-cell-half">
                                <div class="form-label">6.B DETAILS OF LEAVE</div>
                                
                                <div class="form-group">
                                    <div class="form-label">In case of Vacation/Special Privilege Leave:</div>
                                    <div class="checkbox-container">
                                        <label class="checkbox-label">
                                            <input type="checkbox" name="within_ph" value="Yes">
                                            Within the Philippines
                                        </label>
                                        <input type="text" class="form-input" name="within_ph_details" placeholder="Specify location">
                                    </div>
                                    <div class="checkbox-container">
                                        <label class="checkbox-label">
                                            <input type="checkbox" name="abroad" value="Yes">
                                            Abroad (Specify)
                                        </label>
                                        <input type="text" class="form-input" name="abroad_details" placeholder="Specify country">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="form-label">In case of Sick Leave:</div>
                                    <div class="checkbox-container">
                                        <label class="checkbox-label">
                                            <input type="checkbox" name="in_hospital" value="Yes">
                                            In Hospital (Specify illness)
                                        </label>
                                        <input type="text" class="form-input" name="in_hospital_details" placeholder="Specify illness">
                                    </div>
                                    <div class="checkbox-container">
                                        <label class="checkbox-label">
                                            <input type="checkbox" name="out_patient" value="Yes">
                                            Out Patient (Specify illness)
                                        </label>
                                        <input type="text" class="form-input" name="out_patient_details" placeholder="Specify illness">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="form-label">In case of Special Leave Benefits for Women:</div>
                                    <div class="checkbox-container">
                                        <label class="checkbox-label">
                                            <input type="checkbox" name="special_leave" value="Yes">
                                            (Specify illness)
                                        </label>
                                        <input type="text" class="form-input" name="special_leave_details" placeholder="Specify illness">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="form-label">In case of Study Leave:</div>
                                    <div class="checkbox-container">
                                        <label class="checkbox-label">
                                            <input type="checkbox" name="completion_masters" value="Yes">
                                            Completion of Master's Degree
                                        </label>
                                    </div>
                                    <div class="checkbox-container">
                                        <label class="checkbox-label">
                                            <input type="checkbox" name="bar_exam" value="Yes">
                                            BAR/Board Examination Review
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="form-label">Other purpose:</div>
                                    <div class="checkbox-container">
                                        <label class="checkbox-label">
                                            <input type="checkbox" name="monetization" value="Yes">
                                            Monetization of Leave Credits
                                        </label>
                                    </div>
                                    <div class="checkbox-container">
                                        <label class="checkbox-label">
                                            <input type="checkbox" name="terminal_leave" value="Yes">
                                            Terminal Leave
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-cell form-cell-half">
                                <div class="form-label">6.C NUMBER OF WORKING DAYS APPLIED FOR</div>
                                <input type="number" class="form-input" name="num_days" placeholder="Enter number of days" min="1" required>
                                
                                <div class="form-label" style="margin-top: 15px;">INCLUSIVE DATES</div>
                                <div id="inclusiveDatesContainer">
                                    <div class="date-input-container inclusive-dates-row">
                                        <input type="text" class="form-input date-range-picker" name="inclusive_dates[]" placeholder="Select dates" required>
                                        <span class="material-icons">calendar_today</span>
                                        <button type="button" class="remove-date-range-btn" style="display:none;margin-left:8px;background:#e53935;color:#fff;border:none;border-radius:4px;padding:2px 8px;cursor:pointer;">Remove</button>
                                    </div>
                                </div>
                                <button type="button" id="addDateRangeBtn" style="margin-top:8px;background:#1ecb6b;color:#fff;border:none;border-radius:4px;padding:6px 16px;cursor:pointer;display:flex;align-items:center;gap:6px;">
                                    <span class="material-icons">add</span> Add Date Range
                                </button>
                            </div>
                            <div class="form-cell form-cell-half">
                                <div class="form-label">6.D COMMUTATION</div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="commutation" value="Not Requested" >
                                        Not Requested
                                    </label>
                                </div>
                                <div class="checkbox-container">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="commutation" value="Requested">
                                        Requested
                                    </label>
                                </div>
                            </div>
                            
                        </div>
                        <!-- Division Chief (Admin Signatory) Autocomplete -->
                        <div class="form-row">
                            <div class="form-cell form-cell-full">
                                <div class="form-label">Division Chief (2nd Signatory)</div>
                                <input type="text" class="form-input"style= "width: 50%;" name="division_chief" id="divisionChiefInput" placeholder="Type to search for any user..." autocomplete="off">
                                <input type="hidden"  name="admin_signatory" id="adminSignatoryHidden">
                                <div id="divisionChiefSuggestions" style="position:relative; width:50%;"></div>
                                <div class="small-text">Leave blank if not applicable. Start typing to search for any user by name or position.</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                    <a> </a>
                        <button type="submit" class="btn btn-primary">
                            <span class="material-icons">send</span>
                            Submit Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Toggle sidebar on mobile
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            if (menuToggle) {
                menuToggle.addEventListener('click', function() {
                    document.getElementById('sidebar').classList.toggle('active');
                });
            }
            
            // Initialize date picker
            function initDatePickers() {
                document.querySelectorAll('.date-range-picker').forEach(function(input) {
                    if (input._flatpickr) return; // Prevent re-initialization
                    flatpickr(input, {
                        mode: "range",
                        dateFormat: "m/d/Y",
                        altFormat: "m/d/Y",
                        conjunction: " - ",
                        allowInput: true,
                        static: true,
                        onChange: function(selectedDates, dateStr, instance) {
                            // If this is the first or only range, update num_days with the sum of all ranges
                            let totalDays = 0;
                            document.querySelectorAll('.date-range-picker').forEach(function(inp) {
                                if (inp._flatpickr && inp.value) {
                                    const dates = inp.value.split(' to ');
                                    if (dates.length === 2) {
                                        // Date range - calculate days between start and end
                                        const start = new Date(dates[0]);
                                        const end = new Date(dates[1]);
                                        const diffTime = Math.abs(end - start);
                                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                                        totalDays += diffDays;
                                    } else if (dates.length === 1 && dates[0].trim()) {
                                        // Single date - count as 1 day
                                        totalDays += 1;
                                    }
                                }
                            });
                            document.querySelector('input[name="num_days"]').value = totalDays;
                        }
                    });
                });
            }
            function bindCalendarIcons() {
                document.querySelectorAll('.date-input-container .material-icons').forEach(function(icon) {
                    icon.onclick = function() {
                        const input = this.parentElement.querySelector('.date-range-picker');
                        if (input && input._flatpickr) {
                            input._flatpickr.open();
                        }
                    };
                });
            }
            initDatePickers();
            bindCalendarIcons();
            // Add new date range row
            document.getElementById('addDateRangeBtn').addEventListener('click', function() {
                const container = document.getElementById('inclusiveDatesContainer');
                const newRow = document.createElement('div');
                newRow.className = 'date-input-container inclusive-dates-row';
                newRow.innerHTML = `
                    <input type="text" class="form-input date-range-picker" name="inclusive_dates[]" placeholder="Select dates" required>
                    <span class="material-icons">calendar_today</span>
                    <button type="button" class="remove-date-range-btn" style="margin-left:8px;background:#e53935;color:#fff;border:none;border-radius:4px;padding:2px 8px;cursor:pointer;">Remove</button>
                `;
                container.appendChild(newRow);
                initDatePickers();
                bindCalendarIcons();
                updateRemoveButtons();
            });
            // Remove date range row
            function updateRemoveButtons() {
                const rows = document.querySelectorAll('.inclusive-dates-row');
                rows.forEach(function(row, idx) {
                    const btn = row.querySelector('.remove-date-range-btn');
                    if (btn) {
                        btn.style.display = (rows.length > 1) ? 'inline-block' : 'none';
                        btn.onclick = function() {
                            row.remove();
                            // Recalculate total days
                            let totalDays = 0;
                            document.querySelectorAll('.date-range-picker').forEach(function(inp) {
                                if (inp._flatpickr && inp.value) {
                                    const dates = inp.value.split(' to ');
                                    if (dates.length === 2) {
                                        // Date range - calculate days between start and end
                                        const start = new Date(dates[0]);
                                        const end = new Date(dates[1]);
                                        const diffTime = Math.abs(end - start);
                                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                                        totalDays += diffDays;
                                    } else if (dates.length === 1 && dates[0].trim()) {
                                        // Single date - count as 1 day
                                        totalDays += 1;
                                    }
                                }
                            });
                            document.querySelector('input[name="num_days"]').value = totalDays;
                            updateRemoveButtons();
                            bindCalendarIcons();
                        }
                    }
                });
            }
            updateRemoveButtons();
            
            // Handle form submission with AJAX
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Before collecting form data, ensure hidden admin_signatory is set if user typed a value
                const chiefInputEl = document.getElementById('divisionChiefInput');
                const chiefHiddenEl = document.getElementById('adminSignatoryHidden');
                if (chiefInputEl && chiefHiddenEl) {
                    if (chiefInputEl.value && !chiefHiddenEl.value) {
                        chiefHiddenEl.value = chiefInputEl.value + '|';
                    }
                }
                
                // Show loading state
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="material-icons">hourglass_top</span> Submitting...';
                
                // Get form data
                const formData = new FormData(form);
                
                // Send AJAX request
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
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
                    successMessage.innerHTML = '<span class="material-icons" style="margin-right:8px;">check_circle</span> Leave request submitted successfully!';
                    document.body.appendChild(successMessage);
                    
                    // Redirect to dashboard after a short delay
                    setTimeout(() => {
                        window.location.href = '{{ route('dashboard') }}';
                    }, 1500);
                })
                .catch(error => {
                    console.error('Error:', error);
                    
                    // Show error message
                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'alert alert-error';
                    errorMessage.style.position = 'fixed';
                    errorMessage.style.top = '20px';
                    errorMessage.style.right = '20px';
                    errorMessage.style.padding = '15px 20px';
                    errorMessage.style.borderRadius = '8px';
                    errorMessage.style.backgroundColor = '#f8d7da';
                    errorMessage.style.color = '#721c24';
                    errorMessage.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
                    errorMessage.style.zIndex = '9999';
                    errorMessage.innerHTML = '<span class="material-icons" style="margin-right:8px;">error</span> Something went wrong. Please try again.';
                    document.body.appendChild(errorMessage);
                    
                    // Reset button state
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                    
                    // Remove error message after 3 seconds
                    setTimeout(() => {
                        errorMessage.remove();
                    }, 3000);
                });
            });
            
            // Division Chief autocomplete
            const chiefInput = document.getElementById('divisionChiefInput');
            const chiefHidden = document.getElementById('adminSignatoryHidden');
            const suggestionsBox = document.getElementById('divisionChiefSuggestions');
            let selectedChief = null;
            let debounceTimeout = null;

            chiefInput.addEventListener('input', function() {
                const query = this.value.trim();
                selectedChief = null;
                chiefHidden.value = '';
                if (debounceTimeout) clearTimeout(debounceTimeout);
                if (!query) {
                    suggestionsBox.innerHTML = '';
                    return;
                }
                debounceTimeout = setTimeout(() => {
                    fetch(`/api/signatories/division-chief?q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(data => {
                            if (Array.isArray(data) && data.length > 0) {
                                suggestionsBox.innerHTML = '<div style="position:absolute; background:#fff; border:1px solid #ccc; z-index:1000; width:100%; max-height:180px; overflow-y:auto;">' +
                                    data.map(user => `<div class='chief-suggestion' data-name="${user.name}" data-position="${user.position}" style='padding:8px; cursor:pointer;'>${user.name} <span style='color:#888; font-size:0.95em;'>(${user.position})</span></div>`).join('') +
                                    '</div>';
                                Array.from(suggestionsBox.querySelectorAll('.chief-suggestion')).forEach(el => {
                                    el.addEventListener('mousedown', function(e) {
                                        e.preventDefault();
                                        chiefInput.value = this.getAttribute('data-name');
                                        chiefHidden.value = this.getAttribute('data-name') + '|' + this.getAttribute('data-position');
                                        selectedChief = chiefHidden.value;
                                        suggestionsBox.innerHTML = '';
                                    });
                                });
                            } else {
                                suggestionsBox.innerHTML = '';
                            }
                        });
                }, 250);
            });
            // Hide suggestions on blur
            chiefInput.addEventListener('blur', function() {
                setTimeout(() => { suggestionsBox.innerHTML = ''; }, 200);
            });
            // Clear hidden input if user clears the field
            chiefInput.addEventListener('change', function() {
                if (!this.value.trim()) {
                    chiefHidden.value = '';
                    selectedChief = null;
                }
            });
            // On form submit, set hidden input if suggestion was selected, else blank
            const formSubmit = document.querySelector('form');
            formSubmit.addEventListener('submit', function(e) {
                if (chiefInput.value && !chiefHidden.value) {
                    // If user typed but didn't select, just use the typed value as name, position blank
                    chiefHidden.value = chiefInput.value + '|';
                }
            });
        });
    </script>
</body>
</html>
