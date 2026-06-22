/* ============================================================
   SpeakUp! — Dashboard client-side hydration
   Reads practiced (sessionStorage) + favorites (localStorage) and
   renders the per-deck progress breakdown.
   ============================================================ */
(function () {
    'use strict';

    // Totals: practiced + favorites
    let practicedCount = 0;
    try {
        for (let i = 0; i < sessionStorage.length; i++) {
            const key = sessionStorage.key(i);
            if (key && key.startsWith('practiced.')) {
                const arr = JSON.parse(sessionStorage.getItem(key) || '[]');
                practicedCount += arr.length;
            }
        }
    } catch (e) {}

    let favoritesCount = 0;
    try {
        favoritesCount = JSON.parse(localStorage.getItem('speakup-favorites') || '[]').length;
    } catch (e) {}

    const pEl = document.getElementById('practicedTotal');
    const fEl = document.getElementById('favoritesTotal');
    if (pEl) pEl.textContent = practicedCount;
    if (fEl) fEl.textContent = favoritesCount;

    // Per-deck breakdown
    const wrap = document.getElementById('localProgress');
    if (!wrap) return;

    const decks = [];
    try {
        for (let i = 0; i < sessionStorage.length; i++) {
            const key = sessionStorage.key(i);
            if (!key || !key.startsWith('practiced.')) continue;
            // key format: practiced.{themeSlug}.{level}
            const m = key.match(/^practiced\.([^.]+)\.([A-Z12]+)$/);
            if (!m) continue;
            const arr = JSON.parse(sessionStorage.getItem(key) || '[]');
            if (arr.length > 0) {
                decks.push({ themeSlug: m[1], level: m[2], count: arr.length });
            }
        }
    } catch (e) {}

    if (!decks.length) {
        wrap.innerHTML = `
            <div class="text-center py-6">
                <p class="text-sm text-slate-400 dark:text-slate-500">You haven't practiced any cards yet.</p>
                <a href="/" class="mt-3 inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-rose-500 via-fuchsia-500 to-violet-500 text-white text-sm font-semibold shadow hover:-translate-y-0.5 transition-all">
                    Start practicing
                </a>
            </div>`;
        return;
    }

    const levelColors = {
        A1: 'from-emerald-400 to-green-500',
        A2: 'from-teal-400 to-cyan-500',
        B1: 'from-amber-400 to-orange-500',
        B2: 'from-rose-400 to-pink-600',
    };

    wrap.innerHTML = '';
    decks.forEach((d) => {
        const pct = Math.min(100, (d.count / 6) * 100); // assume ~6 per deck as a visual cap
        const row = document.createElement('div');
        row.className = 'flex items-center gap-3';
        row.innerHTML = `
            <span class="text-xs font-mono font-bold w-8 text-slate-500 dark:text-slate-400">${escapeHtml(d.level)}</span>
            <span class="text-xs font-semibold flex-1 text-slate-600 dark:text-slate-300 truncate">${escapeHtml(d.themeSlug.replace(/-/g, ' '))}</span>
            <div class="w-32 h-2.5 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                <div class="h-full bg-gradient-to-r ${levelColors[d.level] || 'from-slate-400 to-slate-500'} rounded-full" style="width:${pct}%"></div>
            </div>
            <span class="text-xs font-bold text-slate-600 dark:text-slate-300 w-8 text-right">${d.count}</span>
        `;
        wrap.appendChild(row);
    });

    function escapeHtml(s) {
        return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }
})();
