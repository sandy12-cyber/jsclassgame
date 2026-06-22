/* ============================================================
   SpeakUp! — Achievements page logic
   Computes unlock progress from localStorage/sessionStorage and
   marks each badge as locked/in-progress/unlocked.
   ============================================================ */
(function () {
    'use strict';

    // ---- Gather metrics from storage ----
    // practiced: union of all practiced ids across decks (sessionStorage)
    let practicedCount = 0;
    let themesTouched = new Set();
    let levelsTouched = new Set();
    let deckCompleted = 0;
    try {
        for (let i = 0; i < sessionStorage.length; i++) {
            const key = sessionStorage.key(i);
            if (!key || !key.startsWith('practiced.')) continue;
            const m = key.match(/^practiced\.([^.]+)\.([A-Z12]+)$/);
            const arr = JSON.parse(sessionStorage.getItem(key) || '[]');
            practicedCount += arr.length;
            if (m) {
                themesTouched.add(m[1]);
                levelsTouched.add(m[2]);
                // Heuristic: if 6+ cards practiced in a deck, count as completed
                if (arr.length >= 6) deckCompleted = 1;
            }
        }
    } catch (e) {}

    // favorites
    let favoritesCount = 0;
    try {
        favoritesCount = JSON.parse(localStorage.getItem('speakup-favorites') || '[]').length;
    } catch (e) {}

    // streak days: stored as speakup-streak-days = ["2026-06-22", "2026-06-23", ...]
    let streakDays = [];
    try {
        streakDays = JSON.parse(localStorage.getItem('speakup-streak-days') || '[]');
    } catch (e) {}
    const streakCount = streakDays.length;

    // daily challenge done
    const dailyDone = localStorage.getItem('speakup-daily-done') === new Date().toISOString().slice(0, 10) ? 1 : 0;

    // ---- Metric resolver ----
    function metricValue(metric) {
        switch (metric) {
            case 'practiced': return practicedCount;
            case 'favorites': return favoritesCount;
            case 'streak-days': return streakCount;
            case 'themes-touched': return themesTouched.size;
            case 'levels-touched': return levelsTouched.size;
            case 'daily-done': return dailyDone;
            case 'deck-completed': return deckCompleted;
            default: return 0;
        }
    }

    // ---- Render each achievement card ----
    let unlockedCount = 0;
    document.querySelectorAll('.achievement-card').forEach((card) => {
        const goal = parseInt(card.dataset.goal, 10);
        const metric = card.dataset.metric;
        const value = metricValue(metric);
        const pct = Math.min(100, (value / goal) * 100);
        const unlocked = value >= goal;

        const bar = card.querySelector('.achievement-bar');
        const progressText = card.querySelector('.achievement-progress');
        const status = card.querySelector('.achievement-status');
        const gradient = card.querySelector('.achievement-gradient');

        if (bar) bar.style.width = pct + '%';
        if (progressText) progressText.textContent = `${Math.min(value, goal)} / ${goal}`;
        if (status) {
            if (unlocked) {
                status.textContent = 'Unlocked';
                status.className = 'achievement-status px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-100 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300';
                card.classList.add('unlocked');
                if (gradient) gradient.classList.remove('opacity-30');
                if (gradient) gradient.classList.add('opacity-60');
                unlockedCount++;
            } else if (value > 0) {
                status.textContent = 'In progress';
                status.className = 'achievement-status px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-100 dark:bg-amber-950/50 text-amber-700 dark:text-amber-300';
            } else {
                status.textContent = 'Locked';
            }
        }
    });

    // ---- Stats summary ----
    const set = (id, v) => { const el = document.getElementById(id); if (el) el.textContent = v; };
    set('statPracticed', practicedCount);
    set('statStreak', streakCount);
    set('statThemes', themesTouched.size);
    set('statUnlocked', unlockedCount);

    // ---- Helper: mark today as a streak day (call when user practises) ----
    // Exposed for other scripts (game.js, lesson.js) to call.
    window.SpeakUpMarkToday = function () {
        try {
            const today = new Date().toISOString().slice(0, 10);
            let days = JSON.parse(localStorage.getItem('speakup-streak-days') || '[]');
            if (!days.includes(today)) {
                days.push(today);
                // Keep last 30 days only
                days = days.slice(-30);
                localStorage.setItem('speakup-streak-days', JSON.stringify(days));
            }
        } catch (e) {}
    };
})();
