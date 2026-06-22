/* ============================================================
   SpeakUp! — Daily/Random Challenge page logic
   (lighter version of game.js: single card, flip, TTS, favorite, countdown)
   ============================================================ */
(function () {
    'use strict';

    const cfg = window.SpeakUpChallenge || {};
    if (!cfg.questionId) return;

    const card = document.getElementById('card');
    const flipBtn = document.getElementById('flipBtn');
    const flipBackBtn = document.getElementById('flipBackBtn');
    const speakPromptBtn = document.getElementById('speakPromptBtn');
    const speakAnswerBtn = document.getElementById('speakAnswerBtn');
    const favoriteBtn = document.getElementById('favoriteBtn');
    let isFlipped = false;

    // ---- Favorites (shared with game.js via localStorage) ----
    let favorites = new Set(JSON.parse(localStorage.getItem('speakup-favorites') || '[]'));

    function updateFavoriteUI() {
        const fav = favorites.has(cfg.questionId);
        favoriteBtn.classList.toggle('text-rose-500', fav);
        favoriteBtn.classList.toggle('bg-rose-50', fav);
        favoriteBtn.classList.toggle('dark:bg-rose-950/40', fav);
        favoriteBtn.classList.toggle('border-rose-200', fav);
        favoriteBtn.classList.toggle('dark:border-rose-800', fav);
        favoriteBtn.setAttribute('aria-label', fav ? 'Remove from favorites' : 'Add to favorites');
        favoriteBtn.setAttribute('title', fav ? 'Remove from favorites' : 'Add to favorites');
        if (window.lucide) window.lucide.createIcons();
    }
    function toggleFavorite() {
        if (favorites.has(cfg.questionId)) favorites.delete(cfg.questionId);
        else {
            favorites.add(cfg.questionId);
            favoriteBtn.classList.add('favorite-pop');
            setTimeout(() => favoriteBtn.classList.remove('favorite-pop'), 500);
        }
        localStorage.setItem('speakup-favorites', JSON.stringify([...favorites]));
        updateFavoriteUI();
    }

    // ---- Flip ----
    function flipCard() {
        isFlipped = !isFlipped;
        card.classList.toggle('is-flipped', isFlipped);
    }

    card.addEventListener('click', (e) => {
        if (e.target.closest('#flipBackBtn')) return;
        if (e.target.closest('.vocab-chip')) return;
        flipCard();
    });
    flipBtn.addEventListener('click', flipCard);
    flipBackBtn.addEventListener('click', (e) => { e.stopPropagation(); flipCard(); });
    favoriteBtn.addEventListener('click', (e) => { e.stopPropagation(); toggleFavorite(); });

    // ---- TTS ----
    const synth = window.speechSynthesis || null;
    let voices = [];
    function loadVoices() { if (synth) voices = synth.getVoices(); }
    if (synth) { loadVoices(); synth.onvoiceschanged = loadVoices; }
    function speak(text, { rate = 1 } = {}) {
        if (!synth || !text) return;
        synth.cancel();
        const u = new SpeechSynthesisUtterance(text);
        u.rate = rate;
        const preferred = voices.find(v => /en[-_]?(US|GB)/i.test(v.lang) && /natural|female|samantha|google/i.test(v.name))
            || voices.find(v => /^en/i.test(v.lang));
        if (preferred) u.voice = preferred;
        u.lang = preferred ? preferred.lang : 'en-US';
        try { synth.speak(u); } catch (e) {}
    }
    speakPromptBtn.addEventListener('click', () => speak(cfg.prompt, { rate: 0.95 }));
    speakAnswerBtn.addEventListener('click', (e) => { e.stopPropagation(); speak(cfg.sampleAnswer, { rate: 0.95 }); });

    // Vocab chips speak on click
    document.querySelectorAll('.vocab-chip').forEach((chip) => {
        chip.addEventListener('click', (e) => {
            e.stopPropagation();
            speak(chip.dataset.word || chip.textContent, { rate: 0.9 });
        });
    });

    // ---- Countdown to next daily card ----
    const countdownEl = document.getElementById('countdown');
    if (countdownEl) {
        const next = parseInt(countdownEl.dataset.next, 10) * 1000;
        function tick() {
            const diff = Math.max(0, next - Date.now());
            const h = String(Math.floor(diff / 3600000)).padStart(2, '0');
            const m = String(Math.floor((diff % 3600000) / 60000)).padStart(2, '0');
            const s = String(Math.floor((diff % 60000) / 1000)).padStart(2, '0');
            countdownEl.textContent = `${h}:${m}:${s}`;
            if (diff <= 0) location.reload();
        }
        tick();
        setInterval(tick, 1000);
    }

    updateFavoriteUI();
})();
