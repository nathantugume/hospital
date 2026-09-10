// ============================================
// NOTIFICATIONS MODULE - Dropdown & toast messages
// ============================================
(function(window, document) {
    'use strict';
    
    function showToast(message, isError) {
        isError = isError || false;
        document.querySelectorAll('.toast-message').forEach(t => t.remove());
        
        const toast = document.createElement('div');
        toast.className = 'toast-message';
        toast.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: ${isError ? '#ef4444' : '#10b981'};
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            z-index: 1200;
            animation: slideIn 0.3s ease-out;
            max-width: 400px;
            word-wrap: break-word;
            font-size: 14px;
        `;
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            if (toast.parentNode) {
                toast.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => toast.remove(), 300);
            }
        }, 3000);
    }
    
    function init() {
        const notifBtn      = document.getElementById('notificationsBtn');
        const notifDropdown = document.getElementById('notificationsDropdown');
        const markAllBtn    = document.getElementById('markAllReadBtn');
        
        if (notifBtn && notifDropdown) {
            notifBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                notifDropdown.classList.toggle('hidden');
                
                const profileDropdown = document.getElementById('profileDropdown');
                if (profileDropdown) profileDropdown.classList.add('hidden');
            });
        }
        
        if (markAllBtn) {
            markAllBtn.addEventListener('click', () => showToast('All notifications marked as read'));
        }
        
        document.addEventListener('click', (e) => {
            if (notifDropdown && notifBtn && 
                !notifBtn.contains(e.target) && 
                !notifDropdown.contains(e.target)) {
                notifDropdown.classList.add('hidden');
            }
        });
    }
    
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();
    
    window.MeditrackNotifications = { showToast };
    
})(window, document);