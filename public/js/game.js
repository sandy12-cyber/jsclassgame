/* ============================================================
   SpeakUp! — Card game logic (vanilla JS, no dependencies)
   Features: flip, shuffle, timer, practiced, TTS, audio recording,
             favorites, confetti, keyboard shortcuts.
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
    let favorites = new Set(JSON.parse(localStorage.getItem('speakup-favorites') || '[]'));
    let timerSeconds = 0;
    let timerInterval = null;
    let timerRunning = false;

    // Recording state
    let mediaRecorder = null;
    let recordedChunks = [];
    let recordedBlobUrl = null;
    let recordStream = null;
    let recTimerSeconds = 0;
    let recTimerInterval = null;
    let isRecording = false;

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
    const favoriteBtn = $('#favoriteBtn');
    const speakPromptBtn = $('#speakPromptBtn');
    const speakAnswerBtn = $('#speakAnswerBtn');

    // Recording DOM
    const recordBtn = $('#recordBtn');
    const playRecordingBtn = $('#playRecordingBtn');
    const deleteRecordingBtn = $('#deleteRecordingBtn');
    const recordingPlayer = $('#recordingPlayer');
    const recordingStatus = $('#recordingStatus');
    const recordingTimer = $('#recordingTimer');
    const confettiContainer = $('#confettiContainer');

    totalNum.textContent = questions.length;

    // ---- Helpers ----
    function formatTime(sec) {
        const m = String(Math.floor(sec / 60)).padStart(2, '0');
        const s = String(sec % 60).padStart(2, '0');
        return `${m}:${s}`;
    }

    // ---- Text-to-Speech (Web Speech API) ----
    const synth = window.speechSynthesis || null;
    let voices = [];
    function loadVoices() {
        if (!synth) return;
        voices = synth.getVoices();
    }
    if (synth) {
        loadVoices();
        synth.onvoiceschanged = loadVoices;
    }

    function speak(text, { rate = 1, pitch = 1 } = {}) {
        if (!synth || !text) return;
        synth.cancel();
        const u = new SpeechSynthesisUtterance(text);
        u.rate = rate;
        u.pitch = pitch;
        // Prefer a natural English voice
        const preferred = voices.find(v => /en[-_]?(US|GB)/i.test(v.lang) && /natural|female|samantha|google/i.test(v.name))
            || voices.find(v => /^en/i.test(v.lang));
        if (preferred) u.voice = preferred;
        u.lang = preferred ? preferred.lang : 'en-US';
        try { synth.speak(u); } catch (e) {}
    }

    // ---- Favorites ----
    function persistFavorites() {
        localStorage.setItem('speakup-favorites', JSON.stringify([...favorites]));
    }
    function isFavorited(id) { return favorites.has(id); }
    function toggleFavorite() {
        const id = questions[currentIndex].id;
        if (favorites.has(id)) {
            favorites.delete(id);
        } else {
            favorites.add(id);
            favoriteBtn.classList.add('favorite-pop');
            setTimeout(() => favoriteBtn.classList.remove('favorite-pop'), 500);
        }
        persistFavorites();
        updateFavoriteUI();
    }
    function updateFavoriteUI() {
        const id = questions[currentIndex].id;
        const fav = isFavorited(id);
        favoriteBtn.classList.toggle('text-rose-500', fav);
        favoriteBtn.classList.toggle('bg-rose-50', fav);
        favoriteBtn.classList.toggle('dark:bg-rose-950/40', fav);
        favoriteBtn.classList.toggle('border-rose-200', fav);
        favoriteBtn.classList.toggle('dark:border-rose-800', fav);
        favoriteBtn.setAttribute('aria-label', fav ? 'Remove from favorites' : 'Add to favorites');
        favoriteBtn.setAttribute('title', fav ? 'Remove from favorites' : 'Add to favorites');
        // Swap icon fill via lucide doesn't work cross-browser; instead colour is enough.
        if (window.lucide) window.lucide.createIcons();
    }

    // ---- Render ----
    function renderCard() {
        const q = questions[currentIndex];
        if (!q) return;

        if (isFlipped) {
            card.classList.remove('is-flipped');
            isFlipped = false;
        }

        setTimeout(() => {
            promptText.textContent = q.prompt;
            answerText.textContent = q.sample_answer || 'No sample answer provided. Try to create your own!';

            if (q.tips) {
                tipsText.textContent = q.tips;
                tipsBox.classList.remove('hidden');
            } else {
                tipsBox.classList.add('hidden');
            }

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
                    chip.style.cursor = 'pointer';
                    chip.title = 'Hear this word';
                    chip.addEventListener('click', (e) => {
                        e.stopPropagation();
                        speak(word, { rate: 0.9 });
                    });
                    vocabList.appendChild(chip);
                });
            }

            if (window.lucide) window.lucide.createIcons();

            card.classList.remove('card-enter');
            void card.offsetWidth;
            card.classList.add('card-enter');

            updateUI();
            updateFavoriteUI();
        }, isFlipped ? 250 : 0);
    }

    function updateUI() {
        currentNum.textContent = currentIndex + 1;
        const pct = ((currentIndex + 1) / questions.length) * 100;
        progressBar.style.width = pct + '%';

        prevBtn.disabled = currentIndex === 0;
        nextBtn.disabled = currentIndex === questions.length - 1;

        practicedCount.textContent = practiced.size;

        const isPracticed = practiced.has(questions[currentIndex].id);
        practicedBtn.classList.toggle('bg-emerald-50', isPracticed);
        practicedBtn.classList.toggle('dark:bg-emerald-950/40', isPracticed);
        practicedBtn.classList.toggle('text-emerald-600', isPracticed);
        practicedBtn.classList.toggle('dark:text-emerald-400', isPracticed);
        practicedBtn.classList.toggle('border-emerald-200', isPracticed);
        practicedBtn.classList.toggle('dark:border-emerald-800', isPracticed);
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

        // Mark today as a streak day (for achievements)
        if (typeof window.SpeakUpMarkToday === 'function') {
            window.SpeakUpMarkToday();
        } else {
            // Fallback: define the helper inline if achievements.js hasn't loaded
            try {
                const today = new Date().toISOString().slice(0, 10);
                let days = JSON.parse(localStorage.getItem('speakup-streak-days') || '[]');
                if (!days.includes(today)) {
                    days.push(today);
                    days = days.slice(-30);
                    localStorage.setItem('speakup-streak-days', JSON.stringify(days));
                }
            } catch (e) {}
        }

        // If all cards practiced, celebrate
        const allPracticed = questions.every(q => practiced.has(q.id));
        if (allPracticed) showDone();
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
        } catch (e) {}
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
            setTimeout(() => doneToast.classList.add('hidden'), 4500);
        }
        launchConfetti();
    }

    // ---- Confetti ----
    function launchConfetti() {
        if (!confettiContainer) return;
        confettiContainer.innerHTML = '';
        const colors = ['#f43f5e', '#8b5cf6', '#f59e0b', '#10b981', '#06b6d4', '#ec4899'];
        const count = 80;
        for (let i = 0; i < count; i++) {
            const piece = document.createElement('div');
            const size = 6 + Math.random() * 8;
            piece.style.position = 'absolute';
            piece.style.left = Math.random() * 100 + 'vw';
            piece.style.top = '-20px';
            piece.style.width = size + 'px';
            piece.style.height = (size * 1.6) + 'px';
            piece.style.background = colors[Math.floor(Math.random() * colors.length)];
            piece.style.borderRadius = '2px';
            piece.style.opacity = '0.9';
            piece.style.animation = `confetti-fall ${1.8 + Math.random() * 1.5}s ease-in ${Math.random() * 0.6}s forwards`;
            piece.style.transform = `rotate(${Math.random() * 360}deg)`;
            confettiContainer.appendChild(piece);
        }
        setTimeout(() => { confettiContainer.innerHTML = ''; }, 4000);
    }

    // ---- Audio Recording (MediaRecorder) ----
    async function startRecording() {
        if (!navigator.mediaDevices || !window.MediaRecorder) {
            alert('Audio recording is not supported in this browser.');
            return;
        }
        try {
            recordStream = await navigator.mediaDevices.getUserMedia({ audio: true });
        } catch (err) {
            alert('Could not access the microphone. Please allow microphone permission and try again.');
            return;
        }

        recordedChunks = [];
        // Prefer webm; fall back to whatever the browser supports
        let mimeType = 'audio/webm';
        if (!MediaRecorder.isTypeSupported(mimeType)) {
            mimeType = 'audio/ogg';
            if (!MediaRecorder.isTypeSupported(mimeType)) mimeType = '';
        }
        mediaRecorder = new MediaRecorder(recordStream, mimeType ? { mimeType } : undefined);
        mediaRecorder.addEventListener('dataavailable', (e) => {
            if (e.data.size > 0) recordedChunks.push(e.data);
        });
        mediaRecorder.addEventListener('stop', () => {
            const blob = new Blob(recordedChunks, { type: mimeType || 'audio/webm' });
            if (recordedBlobUrl) URL.revokeObjectURL(recordedBlobUrl);
            recordedBlobUrl = URL.createObjectURL(blob);
            recordingPlayer.src = recordedBlobUrl;
            recordingPlayer.classList.remove('hidden');
            playRecordingBtn.classList.remove('hidden');
            deleteRecordingBtn.classList.remove('hidden');
        });

        mediaRecorder.start();
        isRecording = true;
        recTimerSeconds = 0;
        recordingStatus.classList.remove('hidden');
        recordingTimer.textContent = '00:00';
        recordBtn.querySelector('span').textContent = 'Stop';
        recordBtn.classList.add('bg-rose-500', 'from-rose-500', 'to-rose-600');
        recordBtn.classList.remove('bg-gradient-to-r', cfg.gradientClass || '');

        recTimerInterval = setInterval(() => {
            recTimerSeconds++;
            recordingTimer.textContent = formatTime(recTimerSeconds);
        }, 1000);
    }

    function stopRecording() {
        if (!mediaRecorder || mediaRecorder.state === 'inactive') return;
        mediaRecorder.stop();
        if (recordStream) {
            recordStream.getTracks().forEach(t => t.stop());
        }
        clearInterval(recTimerInterval);
        isRecording = false;
        recordingStatus.classList.add('hidden');
        recordBtn.querySelector('span').textContent = 'Start';
        // Restore gradient via class re-add
        recordBtn.classList.remove('bg-rose-500', 'from-rose-500', 'to-rose-600');
    }

    function deleteRecording() {
        if (recordedBlobUrl) URL.revokeObjectURL(recordedBlobUrl);
        recordedBlobUrl = null;
        recordedChunks = [];
        recordingPlayer.src = '';
        recordingPlayer.classList.add('hidden');
        playRecordingBtn.classList.add('hidden');
        deleteRecordingBtn.classList.add('hidden');
    }

    // ---- Events ----
    card.addEventListener('click', (e) => {
        if (e.target.closest('#flipBackBtn')) return;
        if (e.target.closest('.vocab-chip')) return;
        flipCard();
    });
    flipBtn.addEventListener('click', flipCard);
    flipBackBtn.addEventListener('click', (e) => { e.stopPropagation(); flipCard(); });
    nextBtn.addEventListener('click', goNext);
    prevBtn.addEventListener('click', goPrev);
    shuffleBtn.addEventListener('click', shuffleDeck);
    practicedBtn.addEventListener('click', togglePracticed);
    favoriteBtn.addEventListener('click', (e) => { e.stopPropagation(); toggleFavorite(); });

    if (speakPromptBtn) speakPromptBtn.addEventListener('click', () => speak(questions[currentIndex].prompt, { rate: 0.95 }));
    if (speakAnswerBtn) speakAnswerBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        speak(questions[currentIndex].sample_answer || '', { rate: 0.95 });
    });

    if (recordBtn) recordBtn.addEventListener('click', () => {
        if (isRecording) stopRecording(); else startRecording();
    });
    if (playRecordingBtn) playRecordingBtn.addEventListener('click', () => {
        if (recordedBlobUrl) { recordingPlayer.currentTime = 0; recordingPlayer.play(); }
    });
    if (deleteRecordingBtn) deleteRecordingBtn.addEventListener('click', deleteRecording);

    // Keyboard shortcuts
    document.addEventListener('keydown', (e) => {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
        if (e.key === 'ArrowRight') goNext();
        else if (e.key === 'ArrowLeft') goPrev();
        else if (e.key === ' ' || e.key === 'Enter') { e.preventDefault(); flipCard(); }
        else if (e.key.toLowerCase() === 's') shuffleDeck();
        else if (e.key.toLowerCase() === 'f') toggleFavorite();
        else if (e.key.toLowerCase() === 'r') { if (recordBtn) recordBtn.click(); }
    });

    // Stop speech on page unload
    window.addEventListener('beforeunload', () => {
        if (synth) synth.cancel();
        if (isRecording) stopRecording();
    });

    // ---- Init ----
    renderCard();
    updateUI();
    updateFavoriteUI();
})();
