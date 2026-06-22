/* ============================================================
   SpeakUp! — Lesson Mode logic
   Flip cards + 4-criterion speaking rubric self-assessment.
   Scores are saved per card in localStorage and surfaced as an average.
   ============================================================ */
(function () {
    'use strict';

    const cfg = window.SpeakUpLesson || {};
    const questions = Array.isArray(cfg.questions) ? cfg.questions.slice() : [];
    if (!questions.length) return;

    let currentIndex = 0;
    let isFlipped = false;
    // scores[questionId] = { fluency: 3, accuracy: 2, vocabulary: 3, pronunciation: 4 }
    let scores = JSON.parse(localStorage.getItem('speakup-lesson-scores') || '{}');
    let favorites = new Set(JSON.parse(localStorage.getItem('speakup-favorites') || '[]'));

    // ---- DOM ----
    const $ = (s) => document.querySelector(s);
    const card = $('#card');
    const promptText = $('#promptText');
    const answerText = $('#answerText');
    const tipsText = $('#tipsText');
    const tipsBox = $('#tipsBox');
    const vocabBox = $('#vocabBox');
    const vocabList = $('#vocabList');
    const cardNum = $('#lessonCardNum');
    const prevBtn = $('#prevBtn');
    const nextBtn = $('#nextBtn');
    const avgScore = $('#avgScore');
    const favoriteBtn = $('#favoriteBtn');
    const flipBackBtn = $('#flipBackBtn');
    const speakPromptBtn = $('#speakPromptBtn');

    // ---- TTS ----
    const synth = window.speechSynthesis || null;
    let voices = [];
    if (synth) { voices = synth.getVoices(); synth.onvoiceschanged = () => voices = synth.getVoices(); }
    function speak(text, { rate = 0.95 } = {}) {
        if (!synth || !text) return;
        synth.cancel();
        const u = new SpeechSynthesisUtterance(text);
        u.rate = rate;
        const v = voices.find(v => /en[-_]?(US|GB)/i.test(v.lang) && /natural|female|samantha|google/i.test(v.name)) || voices.find(v => /^en/i.test(v.lang));
        if (v) u.voice = v;
        u.lang = v ? v.lang : 'en-US';
        try { synth.speak(u); } catch (e) {}
    }

    // ---- Render ----
    function renderCard() {
        const q = questions[currentIndex];
        if (!q) return;
        if (isFlipped) { card.classList.remove('is-flipped'); isFlipped = false; }
        setTimeout(() => {
            promptText.textContent = q.prompt;
            answerText.textContent = q.sample_answer || 'No sample answer provided.';
            if (q.tips) { tipsText.textContent = q.tips; tipsBox.classList.remove('hidden'); }
            else { tipsBox.classList.add('hidden'); }
            vocabList.innerHTML = '';
            const vocab = Array.isArray(q.vocabulary) ? q.vocabulary : [];
            if (!vocab.length) { vocabBox.classList.add('hidden'); }
            else {
                vocabBox.classList.remove('hidden');
                vocab.forEach((w) => {
                    const chip = document.createElement('span');
                    chip.className = 'vocab-chip';
                    chip.textContent = w;
                    chip.addEventListener('click', (e) => { e.stopPropagation(); speak(w, { rate: 0.9 }); });
                    vocabList.appendChild(chip);
                });
            }
            if (window.lucide) window.lucide.createIcons();
            card.classList.remove('card-enter'); void card.offsetWidth; card.classList.add('card-enter');
            cardNum.textContent = currentIndex + 1;
            prevBtn.disabled = currentIndex === 0;
            nextBtn.disabled = currentIndex === questions.length - 1;
            renderRubricState();
            updateFavoriteUI();
        }, isFlipped ? 250 : 0);
    }

    function flipCard() { isFlipped = !isFlipped; card.classList.toggle('is-flipped', isFlipped); }

    // ---- Rubric ----
    function renderRubricState() {
        const q = questions[currentIndex];
        const cardScores = scores[q.id] || {};
        let total = 0, count = 0;
        document.querySelectorAll('.rubric-row').forEach((row) => {
            const key = row.dataset.key;
            const current = cardScores[key] || 0;
            row.querySelectorAll('.rubric-btn').forEach((btn) => {
                const active = parseInt(btn.dataset.score, 10) === current;
                btn.classList.toggle('btn-active', active);
                if (active) {
                    btn.classList.add('bg-gradient-to-r', window.s_gradient || 'from-rose-500 to-fuchsia-500', 'text-white', 'border-transparent', 'shadow');
                    btn.classList.remove('text-slate-500', 'dark:text-slate-300', 'bg-white', 'dark:bg-slate-800');
                } else {
                    btn.classList.remove('bg-gradient-to-r', 'from-rose-500', 'to-fuchsia-500', 'text-white', 'border-transparent', 'shadow');
                    btn.classList.add('text-slate-500', 'dark:text-slate-300', 'bg-white', 'dark:bg-slate-800');
                }
            });
            if (current > 0) { total += current; count++; }
        });
        avgScore.textContent = count > 0 ? (total / count).toFixed(1) : '—';
    }

    function setScore(key, score) {
        const q = questions[currentIndex];
        if (!scores[q.id]) scores[q.id] = {};
        scores[q.id][key] = score;
        localStorage.setItem('speakup-lesson-scores', JSON.stringify(scores));
        renderRubricState();
    }

    document.querySelectorAll('.rubric-btn').forEach((btn) => {
        btn.addEventListener('click', () => setScore(btn.dataset.key, parseInt(btn.dataset.score, 10)));
    });

    // ---- Favorites ----
    function updateFavoriteUI() {
        const q = questions[currentIndex];
        const fav = favorites.has(q.id);
        favoriteBtn.classList.toggle('text-rose-500', fav);
        favoriteBtn.classList.toggle('bg-rose-50', fav);
        favoriteBtn.classList.toggle('dark:bg-rose-950/40', fav);
        favoriteBtn.classList.toggle('border-rose-200', fav);
        favoriteBtn.classList.toggle('dark:border-rose-800', fav);
        favoriteBtn.setAttribute('aria-label', fav ? 'Remove from favorites' : 'Add to favorites');
        if (window.lucide) window.lucide.createIcons();
    }
    function toggleFavorite() {
        const q = questions[currentIndex];
        if (favorites.has(q.id)) favorites.delete(q.id);
        else { favorites.add(q.id); favoriteBtn.classList.add('favorite-pop'); setTimeout(() => favoriteBtn.classList.remove('favorite-pop'), 500); }
        localStorage.setItem('speakup-favorites', JSON.stringify([...favorites]));
        updateFavoriteUI();
    }

    // ---- Events ----
    card.addEventListener('click', (e) => {
        if (e.target.closest('#flipBackBtn') || e.target.closest('.vocab-chip') || e.target.closest('#speakPromptBtn')) return;
        flipCard();
    });
    flipBackBtn.addEventListener('click', (e) => { e.stopPropagation(); flipCard(); });
    speakPromptBtn.addEventListener('click', (e) => { e.stopPropagation(); speak(questions[currentIndex].prompt); });
    favoriteBtn.addEventListener('click', (e) => { e.stopPropagation(); toggleFavorite(); });
    prevBtn.addEventListener('click', () => { if (currentIndex > 0) { currentIndex--; renderCard(); } });
    nextBtn.addEventListener('click', () => { if (currentIndex < questions.length - 1) { currentIndex++; renderCard(); } });

    document.addEventListener('keydown', (e) => {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
        if (e.key === 'ArrowRight' && currentIndex < questions.length - 1) { currentIndex++; renderCard(); }
        else if (e.key === 'ArrowLeft' && currentIndex > 0) { currentIndex--; renderCard(); }
        else if (e.key === ' ' || e.key === 'Enter') { e.preventDefault(); flipCard(); }
        else if (e.key.toLowerCase() === 'f') toggleFavorite();
    });

    renderCard();
})();
