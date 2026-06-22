/* ============================================================
   SpeakUp! — global theme (dark mode) + mobile menu
   ============================================================ */
(function () {
    'use strict';

    function init() {
        const toggle = document.getElementById('themeToggle');
        if (toggle) {
            toggle.addEventListener('click', () => {
                const isDark = document.documentElement.classList.toggle('dark');
                try {
                    localStorage.setItem('speakup-theme', isDark ? 'dark' : 'light');
                } catch (e) {}
                // Re-render icons (sun/moon swap)
                if (window.lucide) window.lucide.createIcons();
            });
        }

        const menuBtn = document.getElementById('mobileMenuBtn');
        const menu = document.getElementById('mobileMenu');
        if (menuBtn && menu) {
            menuBtn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });
            // Close on link click
            menu.querySelectorAll('a').forEach((a) => {
                a.addEventListener('click', () => menu.classList.add('hidden'));
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
