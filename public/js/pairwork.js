/* ============================================================
   SpeakUp! — Pair Work mode logic
   Alternates Player A (answer) and Player B (follow-up question).
   ============================================================ */
(function () {
    'use strict';

    const cfg = window.SpeakUpPairwork || {};
    const questions = Array.isArray(cfg.questions) ? cfg.questions.slice() : [];
    if (!questions.length) return;

    let currentIndex = 0;
    const $ = (s) => document.querySelector(s);
    const promptText = $('#promptText');
    const answerText = $('#answerText');
    const answerPanel = $('#answerPanel');
    const cardNum = $('#cardNum');
    const turnAvatar = $('#turnAvatar');
    const turnName = $('#turnName');
    const turnTask = $('#turnTask');
    const turnBanner = $('#turnBanner');
    const prevBtn = $('#prevBtn');
    const nextBtn = $('#nextBtn');
    const revealBtn = $('#revealBtn');
    const speakBtn = $('#speakBtn');
    const speakAnswerBtn = $('#speakAnswerBtn');

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

    function render() {
        const q = questions[currentIndex];
        if (!q) return;
        promptText.textContent = q.prompt;
        answerText.textContent = q.sample_answer || 'No sample answer provided.';
        answerPanel.classList.add('hidden');
        cardNum.textContent = currentIndex + 1;
        prevBtn.disabled = currentIndex === 0;
        nextBtn.disabled = currentIndex === questions.length - 1;

        // Even card (0-indexed) = Player A answers; odd = Player B asks follow-up
        const isPlayerA = currentIndex % 2 === 0;
        if (isPlayerA) {
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
    }

    prevBtn.addEventListener('click', () => { if (currentIndex > 0) { currentIndex--; render(); } });
    nextBtn.addEventListener('click', () => { if (currentIndex < questions.length - 1) { currentIndex++; render(); } });
    revealBtn.addEventListener('click', () => answerPanel.classList.remove('hidden'));
    speakBtn.addEventListener('click', () => speak(questions[currentIndex].prompt));
    speakAnswerBtn.addEventListener('click', () => speak(questions[currentIndex].sample_answer || ''));

    document.addEventListener('keydown', (e) => {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
        if (e.key === 'ArrowRight' && currentIndex < questions.length - 1) { currentIndex++; render(); }
        else if (e.key === 'ArrowLeft' && currentIndex > 0) { currentIndex--; render(); }
        else if (e.key.toLowerCase() === 'r') answerPanel.classList.toggle('hidden');
    });

    render();
})();
