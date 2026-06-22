/* ============================================================
   SpeakUp! — Playlist session player
   Reads the deck queue from the URL query string, resolves it via
   the API, then plays through all cards across all decks in order.
   ============================================================ */
(function () {
    'use strict';

    const cfg = window.SpeakUpPlaylistPlay || {};

    const $ = (s) => document.querySelector(s);
    const loadingState = $('#loadingState');
    const emptyState = $('#emptyState');
    const cardArea = $('#cardArea');

    // Parse decks from URL query: ?d[0][theme_slug]=x&d[0][level]=A1&d[1]...
    const params = new URLSearchParams(location.search);
    const decksParam = [];
    let i = 0;
    while (params.has(`d[${i}][theme_slug]`)) {
        decksParam.push({
            theme_slug: params.get(`d[${i}][theme_slug]`),
            level: params.get(`d[${i}][level]`),
        });
        i++;
    }

    if (decksParam.length === 0) {
        loadingState.classList.add('hidden');
        emptyState.classList.remove('hidden');
        if (window.lucide) window.lucide.createIcons();
        return;
    }

    // Resolve decks via API
    fetch(cfg.resolveUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': cfg.csrfToken,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ decks: decksParam }),
    })
    .then((r) => r.json())
    .then((data) => {
        const decks = data.decks || [];
        if (decks.length === 0) {
            loadingState.classList.add('hidden');
            emptyState.classList.remove('hidden');
            if (window.lucide) window.lucide.createIcons();
            return;
        }
        // Flatten into a single card list, tagging each card with its deck
        const cards = [];
        decks.forEach((deck) => {
            deck.questions.forEach((q) => {
                cards.push({ ...q, _deck: deck });
            });
        });
        startSession(cards, decks);
    })
    .catch(() => {
        loadingState.classList.add('hidden');
        emptyState.querySelector('p').textContent = 'Could not load the playlist. Please try again.';
        emptyState.classList.remove('hidden');
        if (window.lucide) window.lucide.createIcons();
    });

    // ---- Session state ----
    let currentIndex = 0;
    let isFlipped = false;
    let timerSeconds = 0;
    let timerInterval = null;
    let timerRunning = false;
    let favorites = new Set(JSON.parse(localStorage.getItem('speakup-favorites') || '[]'));

    const levelStyles = {
        A1: { gradient: 'from-emerald-400 to-green-500', text: 'text-emerald-600 dark:text-emerald-400', soft: 'bg-emerald-50 dark:bg-emerald-950/40', border: 'border-emerald-200 dark:border-emerald-800' },
        A2: { gradient: 'from-teal-400 to-cyan-500', text: 'text-teal-600 dark:text-teal-400', soft: 'bg-teal-50 dark:bg-teal-950/40', border: 'border-teal-200 dark:border-teal-800' },
        B1: { gradient: 'from-amber-400 to-orange-500', text: 'text-amber-600 dark:text-amber-400', soft: 'bg-amber-50 dark:bg-amber-950/40', border: 'border-amber-200 dark:border-amber-800' },
        B2: { gradient: 'from-rose-400 to-pink-600', text: 'text-rose-600 dark:text-rose-400', soft: 'bg-rose-50 dark:bg-rose-950/40', border: 'border-rose-200 dark:border-rose-800' },
    };

    function startSession(cards, decks) {
        loadingState.classList.add('hidden');
        cardArea.classList.remove('hidden');

        const cardNum = $('#cardNum');
        const cardTotal = $('#cardTotal');
        const sessionBar = $('#sessionBar');
        const deckInfo = $('#deckInfo');
        const timerDisplay = $('#timerDisplay');

        cardTotal.textContent = cards.length;

        function fmt(sec) {
            const m = String(Math.floor(sec / 60)).padStart(2, '0');
            const s = String(sec % 60).padStart(2, '0');
            return `${m}:${s}`;
        }
        function startTimer() {
            if (timerRunning) return;
            timerRunning = true;
            timerInterval = setInterval(() => {
                timerSeconds++;
                timerDisplay.textContent = fmt(timerSeconds);
            }, 1000);
        }

        function renderCard() {
            const q = cards[currentIndex];
            const ls = levelStyles[q.level] || levelStyles.A1;
            const deck = q._deck;

            // Update deck info
            deckInfo.textContent = `${deck.theme.name} · ${q.level} · deck ${decks.indexOf(deck) + 1} of ${decks.length}`;

            // Apply gradient to card front/back borders
            $('#cardFront').className = `card-face absolute inset-0 rounded-3xl bg-gradient-to-br ${ls.gradient} p-[2px] shadow-2xl`;
            $('#cardBack').className = `card-face absolute inset-0 rounded-3xl bg-gradient-to-br ${ls.gradient} p-[2px] shadow-2xl`;

            // Badges
            const levelBadge = $('#levelBadge');
            levelBadge.className = `px-3 py-1 rounded-lg text-xs font-bold text-white shadow bg-gradient-to-r ${ls.gradient}`;
            levelBadge.textContent = q.level;
            const backBadge = $('#backBadge');
            backBadge.className = `px-3 py-1 rounded-lg text-xs font-bold text-white shadow bg-gradient-to-r ${ls.gradient}`;
            $('#themeEmoji').textContent = deck.theme.emoji;
            $('#themeEmoji').className = `grid place-items-center w-9 h-9 rounded-xl ${ls.soft} text-lg`;
            $('#promptLabel').className = `text-xs font-bold uppercase tracking-widest mb-4 ${ls.text}`;
            $('#promptLabel').textContent = `${deck.theme.name} · speaking prompt`;
            $('#promptText').textContent = q.prompt;
            $('#answerText').textContent = q.sample_answer || 'No sample answer provided.';

            const tipsBox = $('#tipsBox');
            if (q.tips) {
                $('#tipsText').textContent = q.tips;
                tipsBox.className = `mt-5 rounded-2xl ${ls.soft} border ${ls.border} p-4`;
                tipsBox.classList.remove('hidden');
            } else {
                tipsBox.classList.add('hidden');
            }

            const vocabBox = $('#vocabBox');
            const vocabList = $('#vocabList');
            vocabList.innerHTML = '';
            const vocab = Array.isArray(q.vocabulary) ? q.vocabulary : [];
            if (vocab.length === 0) {
                vocabBox.classList.add('hidden');
            } else {
                vocabBox.classList.remove('hidden');
                vocab.forEach((w) => {
                    const chip = document.createElement('span');
                    chip.className = 'vocab-chip';
                    chip.textContent = w;
                    vocabList.appendChild(chip);
                });
            }

            // Reset flip
            if (isFlipped) { $('#card').classList.remove('is-flipped'); isFlipped = false; }

            cardNum.textContent = currentIndex + 1;
            sessionBar.style.width = ((currentIndex + 1) / cards.length * 100) + '%';
            $('#prevBtn').disabled = currentIndex === 0;
            $('#nextBtn').disabled = currentIndex === cards.length - 1;
            updateFavoriteUI(q.id);

            if (window.lucide) window.lucide.createIcons();
        }

        function flipCard() {
            isFlipped = !isFlipped;
            $('#card').classList.toggle('is-flipped', isFlipped);
            if (isFlipped) startTimer();
        }

        function next() { if (currentIndex < cards.length - 1) { currentIndex++; renderCard(); } else showDone(); }
        function prev() { if (currentIndex > 0) { currentIndex--; renderCard(); } }

        function showDone() {
            $('#doneToast').classList.remove('hidden');
            if (window.lucide) window.lucide.createIcons();
            setTimeout(() => $('#doneToast').classList.add('hidden'), 4500);
            launchConfetti();
        }

        function launchConfetti() {
            const c = $('#confettiContainer');
            if (!c) return;
            c.innerHTML = '';
            const colors = ['#f43f5e', '#8b5cf6', '#f59e0b', '#10b981', '#06b6d4', '#ec4899'];
            for (let k = 0; k < 80; k++) {
                const p = document.createElement('div');
                const sz = 6 + Math.random() * 8;
                p.style.cssText = `position:absolute;left:${Math.random()*100}vw;top:-20px;width:${sz}px;height:${sz*1.6}px;background:${colors[Math.floor(Math.random()*colors.length)]};border-radius:2px;opacity:0.9;animation:confetti-fall ${1.8+Math.random()*1.5}s ease-in ${Math.random()*0.6}s forwards;transform:rotate(${Math.random()*360}deg)`;
                c.appendChild(p);
            }
            setTimeout(() => { c.innerHTML = ''; }, 4000);
        }

        function updateFavoriteUI(qid) {
            const fav = favorites.has(qid);
            const btn = $('#favoriteBtn');
            btn.classList.toggle('text-rose-500', fav);
            btn.classList.toggle('bg-rose-50', fav);
            btn.classList.toggle('dark:bg-rose-950/40', fav);
            btn.classList.toggle('border-rose-200', fav);
            btn.classList.toggle('dark:border-rose-800', fav);
            btn.setAttribute('aria-label', fav ? 'Remove from favorites' : 'Add to favorites');
        }
        function toggleFavorite() {
            const qid = cards[currentIndex].id;
            if (favorites.has(qid)) favorites.delete(qid);
            else { favorites.add(qid); $('#favoriteBtn').classList.add('favorite-pop'); setTimeout(() => $('#favoriteBtn').classList.remove('favorite-pop'), 500); }
            localStorage.setItem('speakup-favorites', JSON.stringify([...favorites]));
            updateFavoriteUI(qid);
        }

        // Events
        $('#card').addEventListener('click', (e) => {
            if (e.target.closest('#flipBackBtn') || e.target.closest('.vocab-chip') || e.target.closest('#favoriteBtn')) return;
            flipCard();
        });
        $('#flipBtn').addEventListener('click', flipCard);
        $('#flipBackBtn').addEventListener('click', (e) => { e.stopPropagation(); flipCard(); });
        $('#nextBtn').addEventListener('click', next);
        $('#prevBtn').addEventListener('click', prev);
        $('#favoriteBtn').addEventListener('click', (e) => { e.stopPropagation(); toggleFavorite(); });

        document.addEventListener('keydown', (e) => {
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
            if (e.key === 'ArrowRight') next();
            else if (e.key === 'ArrowLeft') prev();
            else if (e.key === ' ' || e.key === 'Enter') { e.preventDefault(); flipCard(); }
            else if (e.key.toLowerCase() === 'f') toggleFavorite();
        });

        renderCard();
    }

    if (window.lucide) window.lucide.createIcons();
})();
