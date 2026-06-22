/* ============================================================
   SpeakUp! — Playlist builder logic
   Maintains a queue of {theme_slug, level, name, emoji, gradient, count}
   in localStorage, renders it, and builds the play URL.
   ============================================================ */
(function () {
    'use strict';

    const STORAGE_KEY = 'speakup-playlist';
    let queue = [];
    try { queue = JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]'); } catch (e) {}

    const queueEl = document.getElementById('playlistQueue');
    const emptyEl = document.getElementById('emptyQueue');
    const totalEl = document.getElementById('totalCards');
    const playBtn = document.getElementById('playPlaylistBtn');

    function persist() {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(queue));
    }

    function render() {
        queueEl.innerHTML = '';
        if (queue.length === 0) {
            queueEl.appendChild(emptyEl);
            emptyEl.classList.remove('hidden');
            totalEl.textContent = '0';
            playBtn.classList.add('opacity-50', 'pointer-events-none');
            return;
        }
        emptyEl.classList.add('hidden');
        const total = queue.reduce((acc, d) => acc + d.count, 0);
        totalEl.textContent = total;

        queue.forEach((d, i) => {
            const row = document.createElement('div');
            row.className = 'flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700';
            row.innerHTML = `
                <span class="grid place-items-center w-8 h-8 rounded-lg bg-gradient-to-br ${d.gradient} text-base shrink-0">${d.emoji}</span>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-slate-700 dark:text-slate-200 truncate">${escapeHtml(d.name)}</p>
                    <p class="text-[10px] text-slate-400">${d.level} · ${d.count} cards</p>
                </div>
                <button class="remove-deck grid place-items-center w-7 h-7 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors" data-idx="${i}" aria-label="Remove">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            `;
            queueEl.appendChild(row);
        });

        // Wire remove buttons
        queueEl.querySelectorAll('.remove-deck').forEach((b) => {
            b.addEventListener('click', () => {
                queue.splice(parseInt(b.dataset.idx, 10), 1);
                persist();
                render();
            });
        });

        // Build play URL with query string
        const params = new URLSearchParams();
        queue.forEach((d, i) => {
            params.append(`d[${i}][theme_slug]`, d.theme_slug);
            params.append(`d[${i}][level]`, d.level);
        });
        playBtn.href = window.SpeakUpPlaylistBuilder.playRoute + '?' + params.toString();
        playBtn.classList.remove('opacity-50', 'pointer-events-none');

        if (window.lucide) window.lucide.createIcons();
    }

    // Wire add buttons
    document.querySelectorAll('.add-deck-btn').forEach((btn) => {
        btn.addEventListener('click', () => {
            const deck = {
                theme_slug: btn.dataset.theme,
                name: btn.dataset.themeName,
                emoji: btn.dataset.themeEmoji,
                gradient: btn.dataset.themeGradient,
                level: btn.dataset.level,
                count: parseInt(btn.dataset.count, 10),
            };
            // Prevent duplicates
            if (queue.some((d) => d.theme_slug === deck.theme_slug && d.level === deck.level)) return;
            queue.push(deck);
            persist();
            render();
            // Brief feedback
            btn.classList.add('scale-90');
            setTimeout(() => btn.classList.remove('scale-90'), 150);
        });
    });

    function escapeHtml(s) {
        return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    render();
})();
