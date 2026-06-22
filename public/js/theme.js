/* ============================================================
   SpeakUp! — global theme (dark mode) + mobile menu + toast helper
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

        // "More" dropdown (desktop)
        const moreBtn = document.getElementById('moreBtn');
        const moreMenu = document.getElementById('moreMenu');
        if (moreBtn && moreMenu) {
            moreBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                moreMenu.classList.toggle('hidden');
            });
            // Close on link click
            moreMenu.querySelectorAll('a').forEach((a) => {
                a.addEventListener('click', () => moreMenu.classList.add('hidden'));
            });
            // Close when clicking outside
            document.addEventListener('click', (e) => {
                if (!moreBtn.contains(e.target) && !moreMenu.contains(e.target)) {
                    moreMenu.classList.add('hidden');
                }
            });
        }
    }

    // ---- Global toast helper (available as window.SpeakUpToast) ----
    window.SpeakUpToast = function (message, type, duration) {
        type = type || 'info';
        duration = duration || 2500;
        let el = document.getElementById('globalToast');
        if (!el) {
            el = document.createElement('div');
            el.id = 'globalToast';
            el.className = 'toast';
            document.body.appendChild(el);
        }
        el.className = 'toast toast-' + type;
        const icon = { success: '✓', info: 'ℹ', warning: '!', error: '✕' }[type] || 'ℹ';
        el.innerHTML = '<span style="font-size:1.1rem">' + icon + '</span><span>' + message + '</span>';
        // force reflow then show
        void el.offsetWidth;
        el.classList.add('show');
        clearTimeout(el._timer);
        el._timer = setTimeout(() => el.classList.remove('show'), duration);
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
