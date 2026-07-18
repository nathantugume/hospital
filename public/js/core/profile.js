// ============================================
// PROFILE MODULE - Profile dropdown management
// ============================================
(function(window, document) {
    'use strict';
    
    function init() {
        const profileBtn      = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');
        
        if (!profileBtn || !profileDropdown) return;
        
        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            profileDropdown.classList.toggle('hidden');
            
            const notifDropdown = document.getElementById('notificationsDropdown');
            if (notifDropdown) notifDropdown.classList.add('hidden');
        });
        
        document.addEventListener('click', (e) => {
            if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                profileDropdown.classList.add('hidden');
            }
        });
    }
    
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();
    
})(window, document);