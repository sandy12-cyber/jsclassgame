/* ============================================================
   SpeakUp! — Pair Work mode logic
   Alternates Player A (answer) and Player B (follow-up question).
   Features: per-turn countdown timer, manual swap-roles button,
   reveal sample answer, TTS.
   ============================================================ */
(function () {
    'use strict';

    const cfg = window.SpeakUpPairwork || {};
    const questions = Array.isArray(cfg.questions) ? cfg.questions.slice() : [];
    if (!questions.length) return;

    let currentIndex = 0;
    // roleOverride lets a teacher manually swap roles. Default: even=A, odd=B.
    let roleOverride = 0; // 0 = default, 1 = swapped

    const $ = (s) => document.querySelector(s);
    const promptText = $('#promptText');
    const answerText = $('#answerText');
    const answerPanel = $('#answerPanel');
    const cardNum = $('#cardNum');
    const turnAvatar = $('#turnAvatar');
    const turnName = $('#turnName');
    const turnTask = $('#turnTask');
    const turnBanner = $('#turnBanner');
    const turnTimer = $('#turnTimer');
    const turnTimerStartBtn = $('#turnTimerStartBtn');
    const swapRolesBtn = $('#swapRolesBtn');
    const prevBtn = $('#prevBtn');
    const nextBtn = $('#nextBtn');
    const revealBtn = $('#revealBtn');
    const speakBtn = $('#speakBtn');
    const speakAnswerBtn = $('#speakAnswerBtn');

    // Per-turn countdown timer
    let turnSecs = cfg.suggestedTime || 60;
    let turnInterval = null;
    let turnRunning = false;

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

    function isPlayerA() {
        // even index = A, odd = B; override flips it
        return ((currentIndex % 2 === 0) ? 0 : 1) === roleOverride;
    }

    function chime() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const now = ctx.currentTime;
            [660, 880].forEach((freq, i) => {
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.frequency.value = freq;
                osc.type = 'sine';
                gain.gain.setValueAtTime(0, now + i * 0.12);
                gain.gain.linearRampToValueAtTime(0.25, now + i * 0.12 + 0.02);
                gain.gain.exponentialRampToValueAtTime(0.001, now + i * 0.12 + 0.4);
                osc.connect(gain).connect(ctx.destination);
                osc.start(now + i * 0.12);
                osc.stop(now + i * 0.12 + 0.4);
            });
        } catch (e) {}
    }

    function resetTurnTimer() {
        clearInterval(turnInterval);
        turnRunning = false;
        turnSecs = cfg.suggestedTime || 60;
        turnTimer.textContent = turnSecs + 's';
        turnTimer.classList.remove('text-rose-500');
        turnTimerStartBtn.querySelector('span').textContent = 'Start timer';
        turnTimerStartBtn.querySelector('[data-lucide]')?.classList?.remove('hidden');
    }

    function startTurnTimer() {
        if (turnRunning) {
            // pause
            clearInterval(turnInterval);
            turnRunning = false;
            turnTimerStartBtn.querySelector('span').textContent = 'Resume';
            return;
        }
        turnRunning = true;
        turnTimerStartBtn.querySelector('span').textContent = 'Pause';
        turnInterval = setInterval(() => {
            turnSecs--;
            turnTimer.textContent = turnSecs + 's';
            if (turnSecs <= 5) turnTimer.classList.add('text-rose-500');
            if (turnSecs <= 0) {
                clearInterval(turnInterval);
                turnRunning = false;
                chime();
                turnTimer.textContent = 'Time!';
                turnTimerStartBtn.querySelector('span').textContent = 'Restart';
            }
        }, 1000);
    }

    function render() {
        const q = questions[currentIndex];
        if (!q) return;
        promptText.textContent = q.prompt;
        answerText.textContent = q.sample_answer || 'No sample answer provided.';
        answerPanel.classList.add('hidden');
        cardNum.textContent = currentIndex + 1;
        prevBtn.disabled = currentIndex === 0;
        nextBtn.disabled = currentIndex === questions.length - 1;

        const playerA = isPlayerA();
        if (playerA) {
            turnAvatar.textContent = 'A';
            turnName.textContent = 'Player A';
            turnTask.textContent = 'Answer the prompt';
            turnBanner.className = 'rounded-3xl p-[2px] bg-gradient-to-r from-indigo-500 to-violet-600 shadow-lg transition-all';
            turnAvatar.className = 'grid place-items-center w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white font-display font-extrabold text-2xl shadow-lg';
        } else {
            turnAvatar.textContent = 'B';
            turnName.textContent = 'Player B';
            turnTask.textContent = 'Ask a follow-up question';
            turnBanner.className = 'rounded-3xl p-[2px] bg-gradient-to-r from-fuchsia-500 to-pink-600 shadow-lg transition-all';
            turnAvatar.className = 'grid place-items-center w-14 h-14 rounded-2xl bg-gradient-to-br from-fuchsia-500 to-pink-600 text-white font-display font-extrabold text-2xl shadow-lg';
        }
        resetTurnTimer();
    }

    prevBtn.addEventListener('click', () => { if (currentIndex > 0) { currentIndex--; render(); } });
    nextBtn.addEventListener('click', () => { if (currentIndex < questions.length - 1) { currentIndex++; render(); } });
    revealBtn.addEventListener('click', () => answerPanel.classList.remove('hidden'));
    speakBtn.addEventListener('click', () => speak(questions[currentIndex].prompt));
    speakAnswerBtn.addEventListener('click', () => speak(questions[currentIndex].sample_answer || ''));

    swapRolesBtn.addEventListener('click', () => {
        roleOverride = roleOverride === 0 ? 1 : 0;
        render();
    });
    turnTimerStartBtn.addEventListener('click', startTurnTimer);

    document.addEventListener('keydown', (e) => {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
        if (e.key === 'ArrowRight' && currentIndex < questions.length - 1) { currentIndex++; render(); }
        else if (e.key === 'ArrowLeft' && currentIndex > 0) { currentIndex--; render(); }
        else if (e.key.toLowerCase() === 'r') answerPanel.classList.toggle('hidden');
        else if (e.key.toLowerCase() === 't') startTurnTimer();
        else if (e.key.toLowerCase() === 'w') { roleOverride = roleOverride === 0 ? 1 : 0; render(); }
    });

    render();
    if (window.lucide) window.lucide.createIcons();
})();
