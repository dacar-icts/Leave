/**
 * Mobile scrolling fix for dashboards
 * This script helps with mobile scrolling issues in fixed-position layouts
 */
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on a mobile device
    const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    
    if (isMobile) {
        // Add the mobile-scroll-mode class to the body
        document.body.classList.add('mobile-scroll-mode');
        
        // For iOS devices, we need special handling for momentum scrolling
        if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
            // Add iOS-specific fix for momentum scrolling
            const styleEl = document.createElement('style');
            styleEl.textContent = `
                .mobile-scroll-mode .main-content,
                .mobile-scroll-mode .dashboard-body,
                .mobile-scroll-mode #leaveModal > div,
                .mobile-scroll-mode #changePasswordModal > div {
                    -webkit-overflow-scrolling: touch !important;
                }
                
                /* Make buttons more tappable on iOS */
                .mobile-scroll-mode .icon-btn {
                    min-width: 44px;
                    min-height: 44px;
                }
            `;
            document.head.appendChild(styleEl);
        }
        
        // Fix modals on mobile
        const fixModalScrolling = function() {
            const modals = document.querySelectorAll('#leaveModal, #changePasswordModal');
            modals.forEach(modal => {
                if (modal.style.display !== 'none') {
                    const modalContent = modal.querySelector('div');
                    if (modalContent) {
                        modalContent.style.maxHeight = '85vh';
                        modalContent.style.overflowY = 'auto';
                        modalContent.style.webkitOverflowScrolling = 'touch';
                    }
                }
            });
        };
        
        // Call once on page load
        fixModalScrolling();
        
        // And also when modals might open
        document.addEventListener('click', function(e) {
            if (e.target.closest('.view-btn, .icon-btn, #changePasswordBtn')) {
                // Wait for modal to appear
                setTimeout(fixModalScrolling, 300);
            }
        });
    }
    
    // Ensure click events work properly
    document.addEventListener('touchstart', function() {}, {passive: true});
}); 