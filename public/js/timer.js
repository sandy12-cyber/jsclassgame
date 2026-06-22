/* ============================================================
   SpeakUp! — Speaking Timer (standalone tool)
   Countdown ring + chime + warm-up prompts.
   ============================================================ */
(function () {
    'use strict';

    const warmups = (window.SpeakUpTimer && window.SpeakUpTimer.warmups) || [];
    let totalSecs = 60;
    let remaining = 60;
    let interval = null;
    let running = false;

    const $ = (s) => document.querySelector(s);
    const ring = $('#timerRing');
    const display = $('#timeDisplay');
    const status = $('#timerStatus');
    const startBtn = $('#startBtn');
    const pauseBtn = $('#pauseBtn');
    const resetBtn = $('#resetBtn');
    const newWarmupBtn = $('#newWarmupBtn');
    const warmupList = $('#warmupList');

    const CIRC = 2 * Math.PI * 90; // ~565.48

    function fmt(sec) {
        const m = String(Math.floor(sec / 60)).padStart(2, '0');
        const s = String(sec % 60).padStart(2, '0');
        return `${m}:${s}`;
    }

    function render() {
        display.textContent = fmt(remaining);
        const pct = totalSecs > 0 ? remaining / totalSecs : 0;
        ring.style.strokeDashoffset = String(CIRC * (1 - pct));
        // Color shift near the end
        if (remaining <= 5 && running) {
            ring.style.stroke = '#f43f5e';
            display.classList.add('text-rose-500');
            display.classList.remove('text-slate-800', 'dark:text-slate-100');
        } else {
            ring.style.stroke = 'url(#timerGrad)';
            display.classList.remove('text-rose-500');
            display.classList.add('text-slate-800', 'dark:text-slate-100');
        }
    }

    function chime() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const now = ctx.currentTime;
            [880, 1100, 1320].forEach((freq, i) => {
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.frequency.value = freq;
                osc.type = 'sine';
                gain.gain.setValueAtTime(0, now + i * 0.15);
                gain.gain.linearRampToValueAtTime(0.3, now + i * 0.15 + 0.02);
                gain.gain.exponentialRampToValueAtTime(0.001, now + i * 0.15 + 0.5);
                osc.connect(gain).connect(ctx.destination);
                osc.start(now + i * 0.15);
                osc.stop(now + i * 0.15 + 0.5);
            });
        } catch (e) {}
    }

    function start() {
        if (running) return;
        running = true;
        startBtn.classList.add('hidden');
        pauseBtn.classList.remove('hidden');
        status.textContent = 'Speaking…';
        interval = setInterval(() => {
            remaining--;
            render();
            if (remaining <= 0) {
                clearInterval(interval);
                running = false;
                status.textContent = 'Time! 🎉';
                chime();
                startBtn.classList.remove('hidden');
                pauseBtn.classList.add('hidden');
                startBtn.querySelector('span').textContent = 'Restart';
            }
        }, 1000);
    }

    function pause() {
        if (!running) return;
        running = false;
        clearInterval(interval);
        startBtn.classList.remove('hidden');
        pauseBtn.classList.add('hidden');
        startBtn.querySelector('span').textContent = 'Resume';
        status.textContent = 'Paused';
    }

    function reset() {
        running = false;
        clearInterval(interval);
        remaining = totalSecs;
        startBtn.classList.remove('hidden');
        pauseBtn.classList.add('hidden');
        startBtn.querySelector('span').textContent = 'Start';
        status.textContent = 'Ready';
        render();
    }

    function setDuration(secs) {
        totalSecs = secs;
        remaining = secs;
        running = false;
        clearInterval(interval);
        startBtn.classList.remove('hidden');
        pauseBtn.classList.add('hidden');
        startBtn.querySelector('span').textContent = 'Start';
        status.textContent = 'Ready';
        render();
    }

    startBtn.addEventListener('click', start);
    pauseBtn.addEventListener('click', pause);
    resetBtn.addEventListener('click', reset);
    document.querySelectorAll('.preset-btn').forEach((btn) => {
        btn.addEventListener('click', () => setDuration(parseInt(btn.dataset.secs, 10)));
    });

    // Keyboard: Space = start/pause, R = reset
    document.addEventListener('keydown', (e) => {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
        if (e.key === ' ') { e.preventDefault(); running ? pause() : start(); }
        else if (e.key.toLowerCase() === 'r') reset();
    });

    // Warm-up prompts
    function renderWarmups() {
        warmupList.innerHTML = '';
        const shuffled = warmups.slice().sort(() => Math.random() - 0.5).slice(0, 5);
        shuffled.forEach((q) => {
            const item = document.createElement('div');
            item.className = 'flex items-start gap-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-800';
            item.innerHTML = `
                <span class="grid place-items-center w-9 h-9 rounded-xl bg-gradient-to-br ${q.theme.gradient} text-lg shrink-0">${q.theme.emoji}</span>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-slate-700 dark:text-slate-200">${escapeHtml(q.prompt)}</p>
                    <p class="text-[10px] text-slate-400 mt-0.5">${q.theme.name} · ${q.level}</p>
                </div>
                <button class="speak-warmup grid place-items-center w-7 h-7 rounded-lg bg-slate-200 dark:bg-slate-700 text-slate-500 hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors" data-prompt="${escapeHtml(q.prompt)}" aria-label="Read aloud">
                    <i data-lucide="volume-2" class="w-3.5 h-3.5"></i>
                </button>
            `;
            warmupList.appendChild(item);
        });
        // Wire speak buttons
        warmupList.querySelectorAll('.speak-warmup').forEach((b) => {
            b.addEventListener('click', () => speak(b.dataset.prompt));
        });
        if (window.lucide) window.lucide.createIcons();
    }

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

    function escapeHtml(s) {
        return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    newWarmupBtn.addEventListener('click', renderWarmups);
    renderWarmups();
    render();
})();
