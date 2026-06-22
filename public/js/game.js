/* ============================================================
   SpeakUp! — Card game logic (vanilla JS, no dependencies)
   ============================================================ */
(function () {
    'use strict';

    const cfg = window.SpeakUp || {};
    const questions = Array.isArray(cfg.questions) ? cfg.questions.slice() : [];

    if (questions.length === 0) return;

    // ---- State ----
    let currentIndex = 0;
    let isFlipped = false;
    let practiced = new Set(JSON.parse(sessionStorage.getItem(`practiced.${cfg.themeSlug}.${cfg.level}`) || '[]'));
    let timerSeconds = 0;
    let timerInterval = null;
    let timerRunning = false;

    // ---- DOM ----
    const $ = (sel) => document.querySelector(sel);
    const card = $('#card');
    const promptText = $('#promptText');
    const answerText = $('#answerText');
    const tipsText = $('#tipsText');
    const tipsBox = $('#tipsBox');
    const vocabBox = $('#vocabBox');
    const vocabList = $('#vocabList');
    const currentNum = $('#currentNum');
    const totalNum = $('#totalNum');
    const practicedCount = $('#practicedCount');
    const progressBar = $('#progressBar');
    const prevBtn = $('#prevBtn');
    const nextBtn = $('#nextBtn');
    const shuffleBtn = $('#shuffleBtn');
    const flipBtn = $('#flipBtn');
    const flipBackBtn = $('#flipBackBtn');
    const practicedBtn = $('#practicedBtn');
    const timerDisplay = $('#timerDisplay');
    const doneToast = $('#doneToast');

    totalNum.textContent = questions.length;

    // ---- Helpers ----
    function formatTime(sec) {
        const m = String(Math.floor(sec / 60)).padStart(2, '0');
        const s = String(sec % 60).padStart(2, '0');
        return `${m}:${s}`;
    }

    function renderCard() {
        const q = questions[currentIndex];
        if (!q) return;

        // Flip back to front first if currently flipped
        if (isFlipped) {
            card.classList.remove('is-flipped');
            isFlipped = false;
        }

        // Brief delay so the flip-back shows before new content
        setTimeout(() => {
            promptText.textContent = q.prompt;
            answerText.textContent = q.sample_answer || 'No sample answer provided. Try to create your own!';

            if (q.tips) {
                tipsText.textContent = q.tips;
                tipsBox.classList.remove('hidden');
            } else {
                tipsBox.classList.add('hidden');
            }

            // Vocabulary
            vocabList.innerHTML = '';
            const vocab = Array.isArray(q.vocabulary) ? q.vocabulary : [];
            if (vocab.length === 0) {
                vocabBox.classList.add('hidden');
            } else {
                vocabBox.classList.remove('hidden');
                vocab.forEach((word) => {
                    const chip = document.createElement('span');
                    chip.className = 'vocab-chip';
                    chip.textContent = word;
                    vocabList.appendChild(chip);
                });
            }

            // Re-render lucide icons inside the card
            if (window.lucide) window.lucide.createIcons();

            // Card enter animation
            card.classList.remove('card-enter');
            void card.offsetWidth; // reflow
            card.classList.add('card-enter');

            updateUI();
        }, isFlipped ? 250 : 0);
    }

    function updateUI() {
        currentNum.textContent = currentIndex + 1;
        const pct = ((currentIndex + 1) / questions.length) * 100;
        progressBar.style.width = pct + '%';

        prevBtn.disabled = currentIndex === 0;
        nextBtn.disabled = currentIndex === questions.length - 1;

        practicedCount.textContent = practiced.size;

        // Practiced button state
        const isPracticed = practiced.has(questions[currentIndex].id);
        practicedBtn.classList.toggle('bg-emerald-50', isPracticed);
        practicedBtn.classList.toggle('text-emerald-600', isPracticed);
        practicedBtn.classList.toggle('border-emerald-200', isPracticed);
        practicedBtn.querySelector('span').textContent = isPracticed ? 'Practiced ✓' : 'Mark practiced';
    }

    function flipCard() {
        isFlipped = !isFlipped;
        card.classList.toggle('is-flipped', isFlipped);
        if (isFlipped) startTimer();
    }

    function goNext() {
        if (currentIndex < questions.length - 1) {
            currentIndex++;
            renderCard();
        } else {
            showDone();
        }
    }

    function goPrev() {
        if (currentIndex > 0) {
            currentIndex--;
            renderCard();
        }
    }

    function shuffleDeck() {
        // Fisher-Yates shuffle
        for (let i = questions.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [questions[i], questions[j]] = [questions[j], questions[i]];
        }
        currentIndex = 0;
        renderCard();
    }

    function togglePracticed() {
        const id = questions[currentIndex].id;
        if (practiced.has(id)) {
            practiced.delete(id);
        } else {
            practiced.add(id);
            practicedBtn.classList.add('practiced-pulse');
            setTimeout(() => practicedBtn.classList.remove('practiced-pulse'), 700);
        }
        sessionStorage.setItem(`practiced.${cfg.themeSlug}.${cfg.level}`, JSON.stringify([...practiced]));
        updateUI();
        saveProgress();
    }

    function saveProgress() {
        if (!cfg.saveUrl) return;
        try {
            fetch(cfg.saveUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': cfg.csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    theme_slug: cfg.themeSlug,
                    level: cfg.level,
                    practiced: [...practiced],
                }),
            }).catch(() => {});
        } catch (e) { /* ignore */ }
    }

    function startTimer() {
        if (timerRunning) return;
        timerRunning = true;
        timerInterval = setInterval(() => {
            timerSeconds++;
            timerDisplay.textContent = formatTime(timerSeconds);
        }, 1000);
    }

    function showDone() {
        if (doneToast) {
            doneToast.classList.remove('hidden');
            if (window.lucide) window.lucide.createIcons();
            setTimeout(() => doneToast.classList.add('hidden'), 4000);
        }
    }

    // ---- Events ----
    card.addEventListener('click', (e) => {
        // Don't flip if clicking the explicit flip-back button
        if (e.target.closest('#flipBackBtn')) return;
        flipCard();
    });
    flipBtn.addEventListener('click', flipCard);
    flipBackBtn.addEventListener('click', (e) => { e.stopPropagation(); flipCard(); });
    nextBtn.addEventListener('click', goNext);
    prevBtn.addEventListener('click', goPrev);
    shuffleBtn.addEventListener('click', shuffleDeck);
    practicedBtn.addEventListener('click', togglePracticed);

    // Keyboard shortcuts
    document.addEventListener('keydown', (e) => {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
        if (e.key === 'ArrowRight') goNext();
        else if (e.key === 'ArrowLeft') goPrev();
        else if (e.key === ' ' || e.key === 'Enter') { e.preventDefault(); flipCard(); }
        else if (e.key.toLowerCase() === 's') shuffleDeck();
    });

    // ---- Init ----
    renderCard();
    updateUI();
})();
