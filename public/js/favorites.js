/* ============================================================
   SpeakUp! — Favorites page logic
   Reads favorite ids from localStorage, resolves them via the API,
   and renders a colorful grid.
   ============================================================ */
(function () {
    'use strict';

    const cfg = window.SpeakUpFavorites || {};

    const loading = document.getElementById('favoritesLoading');
    const empty = document.getElementById('favoritesEmpty');
    const grid = document.getElementById('favoritesGrid');

    const levelStyles = {
        A1: { gradient: 'from-emerald-400 to-green-500', text: 'text-emerald-600 dark:text-emerald-400', soft: 'bg-emerald-50 dark:bg-emerald-950/40' },
        A2: { gradient: 'from-teal-400 to-cyan-500', text: 'text-teal-600 dark:text-teal-400', soft: 'bg-teal-50 dark:bg-teal-950/40' },
        B1: { gradient: 'from-amber-400 to-orange-500', text: 'text-amber-600 dark:text-amber-400', soft: 'bg-amber-50 dark:bg-amber-950/40' },
        B2: { gradient: 'from-rose-400 to-pink-600', text: 'text-rose-600 dark:text-rose-400', soft: 'bg-rose-50 dark:bg-rose-950/40' },
    };

    function escapeHtml(s) {
        return String(s || '')
            .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }

    async function load() {
        let ids = [];
        try {
            ids = JSON.parse(localStorage.getItem('speakup-favorites') || '[]');
        } catch (e) {}

        if (!ids.length) {
            loading.classList.add('hidden');
            empty.classList.remove('hidden');
            return;
        }

        try {
            const res = await fetch(cfg.resolveUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': cfg.csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ ids }),
            });
            const data = await res.json();
            render(data.questions || []);
        } catch (err) {
            loading.classList.add('hidden');
            grid.classList.remove('hidden');
            grid.innerHTML = '<p class="col-span-full text-center text-slate-500 dark:text-slate-400 py-12">Could not load favorites. Please refresh.</p>';
        }
    }

    function render(questions) {
        loading.classList.add('hidden');
        if (!questions.length) {
            empty.classList.remove('hidden');
            return;
        }
        grid.classList.remove('hidden');
        grid.innerHTML = '';

        questions.forEach((q) => {
            const ls = levelStyles[q.level] || levelStyles.A1;
            const playUrl = cfg.playRoute
                .replace('__THEME__', encodeURIComponent(q.theme.slug))
                .replace('__LEVEL__', encodeURIComponent(q.level.toLowerCase()));

            const vocabHtml = (q.vocabulary || []).slice(0, 3).map((w) =>
                `<span class="text-[10px] font-semibold px-1.5 py-0.5 rounded ${ls.soft} ${ls.text}">${escapeHtml(w)}</span>`
            ).join(' ');

            const card = document.createElement('a');
            card.href = playUrl;
            card.className = 'group relative overflow-hidden rounded-2xl bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all flex flex-col';
            card.innerHTML = `
                <div class="flex items-center justify-between mb-3">
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold ${ls.text}">
                        <span class="px-2 py-0.5 rounded bg-gradient-to-r ${ls.gradient} text-white">${escapeHtml(q.level)}</span>
                        <span class="text-slate-400 dark:text-slate-500">${escapeHtml(q.theme.emoji)} ${escapeHtml(q.theme.name)}</span>
                    </span>
                    <i data-lucide="heart" class="w-4 h-4 text-rose-500 fill-rose-500"></i>
                </div>
                <p class="text-slate-700 dark:text-slate-200 font-medium leading-snug flex-1">${escapeHtml(q.prompt)}</p>
                <div class="mt-3 flex flex-wrap gap-1">${vocabHtml}</div>
                <div class="mt-3 flex items-center gap-1 text-sm font-semibold text-rose-500 group-hover:gap-2 transition-all">
                    Practice <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </div>
            `;
            grid.appendChild(card);
        });

        if (window.lucide) window.lucide.createIcons();
    }

    load();
})();
