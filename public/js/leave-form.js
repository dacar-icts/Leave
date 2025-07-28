// Toggle sidebar on mobile
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }
    
    // Add date validation
    const dateInput = document.querySelector('input[name="inclusive_dates"]');
    if (dateInput) {
        dateInput.addEventListener('blur', function() {
            const datePattern = /^\d{2}\/\d{2}\/\d{4} - \d{2}\/\d{2}\/\d{4}$/;
            if (!datePattern.test(this.value) && this.value !== '') {
                alert('Please use the format mm/dd/yyyy - mm/dd/yyyy for inclusive dates');
            }
        });
    }
    
    // Add form validation and enhancement
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Basic form validation
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('error');
                } else {
                    field.classList.remove('error');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    }
    
    // Add checkbox validation for leave types
    const leaveTypeCheckboxes = document.querySelectorAll('input[name="leave_type[]"]');
    const otherLeaveTypeInput = document.querySelector('input[name="leave_type_other"]');
    
    if (leaveTypeCheckboxes.length > 0) {
        leaveTypeCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                validateLeaveTypeSelection();
            });
        });
    }
    
    if (otherLeaveTypeInput) {
        otherLeaveTypeInput.addEventListener('input', function() {
            validateLeaveTypeSelection();
        });
    }
    
    function validateLeaveTypeSelection() {
        const checkedBoxes = document.querySelectorAll('input[name="leave_type[]"]:checked');
        const otherValue = otherLeaveTypeInput ? otherLeaveTypeInput.value.trim() : '';
        const monetizationChecked = document.querySelector('input[name="monetization"]:checked');
        const terminalLeaveChecked = document.querySelector('input[name="terminal_leave"]:checked');

        if (
            checkedBoxes.length === 0 &&
            otherValue === '' &&
            !monetizationChecked &&
            !terminalLeaveChecked
        ) {
            // Show warning or highlight the section
            const leaveTypeSection = document.querySelector('.form-cell:has(input[name="leave_type[]"])');
            if (leaveTypeSection) {
                leaveTypeSection.style.borderColor = '#ff6b6b';
            }
        } else {
            // Remove warning styling
            const leaveTypeSection = document.querySelector('.form-cell:has(input[name="leave_type[]"])');
            if (leaveTypeSection) {
                leaveTypeSection.style.borderColor = '';
            }
        }
    }
}); 