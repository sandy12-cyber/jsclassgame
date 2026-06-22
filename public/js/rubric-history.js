/* ============================================================
   SpeakUp! — Rubric History page logic
   Reads per-card rubric scores from localStorage (saved by Lesson
   Mode) and renders summary stats + a recent-scores list.
   ============================================================ */
(function () {
    'use strict';

    const cfg = window.SpeakUpRubricHistory || {};
    const criteria = cfg.criteria || [];

    // scores = { questionId: { fluency: 3, accuracy: 2, ... }, ... }
    let scores = {};
    try { scores = JSON.parse(localStorage.getItem('speakup-lesson-scores') || '{}'); } catch (e) {}

    const questionIds = Object.keys(scores).map(Number);
    const totalAssessed = questionIds.length;

    const emptyState = document.getElementById('emptyState');
    const contentArea = document.getElementById('contentArea');
    const clearArea = document.getElementById('clearArea');

    if (totalAssessed === 0) {
        emptyState.classList.remove('hidden');
        if (window.lucide) window.lucide.createIcons();
        return;
    }

    contentArea.classList.remove('hidden');
    clearArea.classList.remove('hidden');

    // ---- Compute averages ----
    const sums = { fluency: 0, accuracy: 0, vocabulary: 0, pronunciation: 0 };
    const counts = { fluency: 0, accuracy: 0, vocabulary: 0, pronunciation: 0 };
    Object.values(scores).forEach((s) => {
        criteria.forEach((c) => {
            if (s[c.key] && s[c.key] > 0) { sums[c.key] += s[c.key]; counts[c.key]++; }
        });
    });

    let grandSum = 0, grandCount = 0;
    criteria.forEach((c) => {
        const avg = counts[c.key] > 0 ? (sums[c.key] / counts[c.key]) : 0;
        const el = document.getElementById('avg-' + c.key);
        if (el) el.textContent = avg > 0 ? avg.toFixed(1) : '—';
        if (avg > 0) { grandSum += avg; grandCount++; }
    });
    const overallAvg = grandCount > 0 ? (grandSum / grandCount) : 0;
    document.getElementById('overallAvg').textContent = overallAvg > 0 ? overallAvg.toFixed(2) : '—';
    document.getElementById('totalAssessed').textContent = totalAssessed;

    // ---- Per-criterion bars ----
    const barsContainer = document.getElementById('criterionBars');
    barsContainer.innerHTML = '';
    criteria.forEach((c) => {
        const avg = counts[c.key] > 0 ? (sums[c.key] / counts[c.key]) : 0;
        const pct = (avg / 4) * 100;
        const row = document.createElement('div');
        row.innerHTML = `
            <div class="flex items-center justify-between text-sm mb-1.5">
                <span class="font-semibold text-slate-700 dark:text-slate-200">${c.label}</span>
                <span class="font-bold text-slate-600 dark:text-slate-300">${avg > 0 ? avg.toFixed(1) : '—'} / 4</span>
            </div>
            <div class="h-3 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                <div class="h-full bg-gradient-to-r ${c.color} rounded-full transition-all duration-700" style="width:${pct}%"></div>
            </div>
        `;
        barsContainer.appendChild(row);
    });

    // ---- Recent scores list (resolve question prompts) ----
    const recentList = document.getElementById('recentList');
    fetch(cfg.resolveUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': cfg.csrfToken,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ ids: questionIds }),
    })
    .then((r) => r.json())
    .then((data) => {
        const questions = data.questions || [];
        // Show most recently added first (we don't store timestamps, so just reverse key order)
        const reversedIds = questionIds.slice().reverse();
        reversedIds.forEach((id) => {
            const q = questions.find((x) => x.id === id);
            const s = scores[id];
            if (!s) return;
            const cardAvg = criteria.reduce((acc, c) => acc + (s[c.key] || 0), 0) / criteria.length;
            const card = document.createElement('div');
            card.className = 'flex items-center gap-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700';
            const prompt = q ? q.prompt : '(question #' + id + ')';
            const theme = q ? q.theme : null;
            card.innerHTML = `
                <span class="grid place-items-center w-10 h-10 rounded-xl bg-gradient-to-br ${theme ? theme.gradient : 'from-slate-300 to-slate-400'} text-white text-lg shrink-0">${theme ? theme.emoji : '❓'}</span>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-slate-700 dark:text-slate-200 truncate">${escapeHtml(prompt)}</p>
                    <div class="flex gap-1.5 mt-1">
                        ${criteria.map((c) => `<span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300">${c.label[0]}: ${s[c.key] || '—'}</span>`).join('')}
                    </div>
                </div>
                <span class="font-display font-extrabold text-lg ${cardAvg >= 3 ? 'text-emerald-500' : cardAvg >= 2 ? 'text-amber-500' : 'text-rose-500'}">${cardAvg > 0 ? cardAvg.toFixed(1) : '—'}</span>
            `;
            recentList.appendChild(card);
        });
        if (window.lucide) window.lucide.createIcons();
    })
    .catch(() => {
        recentList.innerHTML = '<p class="text-sm text-slate-400 text-center py-4">Could not load question details.</p>';
    });

    // ---- Clear button ----
    document.getElementById('clearBtn').addEventListener('click', () => {
        if (confirm('Clear all rubric scores? This cannot be undone.')) {
            localStorage.removeItem('speakup-lesson-scores');
            location.reload();
        }
    });

    function escapeHtml(s) {
        return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    if (window.lucide) window.lucide.createIcons();
})();
