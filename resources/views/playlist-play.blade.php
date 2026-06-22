@extends('layouts.app')

@section('title', 'Playlist Session — SpeakUp!')

@section('content')
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

    <!-- Top bar -->
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <nav class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
            <a href="{{ route('playlist.index') }}" class="hover:text-fuchsia-600 dark:hover:text-fuchsia-400 transition-colors">Playlist</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="font-semibold text-slate-700 dark:text-slate-200">Session</span>
        </nav>
        <span class="text-sm text-slate-400 dark:text-slate-500">Card <span id="cardNum">0</span> / <span id="cardTotal">0</span></span>
    </div>

    <!-- Session header -->
    <div class="rounded-3xl bg-gradient-to-br from-fuchsia-500 via-pink-500 to-rose-500 p-[2px] shadow-xl mb-6">
        <div class="rounded-[22px] bg-white dark:bg-slate-900 p-5 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="grid place-items-center w-12 h-12 rounded-2xl bg-gradient-to-br from-fuchsia-500 to-rose-600 text-white shadow-lg"><i data-lucide="list-music" class="w-6 h-6"></i></span>
                <div>
                    <h1 class="font-display font-extrabold text-xl text-slate-800 dark:text-slate-100">Playlist Session</h1>
                    <p id="deckInfo" class="text-sm text-slate-500 dark:text-slate-400">Loading…</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div id="timerCard" class="flex items-center gap-2 px-4 py-2 rounded-2xl bg-slate-50 dark:bg-slate-800">
                    <i data-lucide="timer" class="w-4 h-4 text-fuchsia-500"></i>
                    <span id="timerDisplay" class="font-mono font-bold text-lg tabular-nums text-fuchsia-500">00:00</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress across all decks -->
    <div class="mb-6">
        <div class="h-2 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">
            <div id="sessionBar" class="h-full bg-gradient-to-r from-fuchsia-500 via-pink-500 to-rose-500 rounded-full transition-all duration-300" style="width: 0%"></div>
        </div>
    </div>

    <!-- Loading / empty / card -->
    <div id="loadingState" class="text-center py-16">
        <div class="grid place-items-center w-16 h-16 rounded-3xl bg-fuchsia-100 dark:bg-fuchsia-950/40 text-3xl mx-auto mb-4 animate-float">⏳</div>
        <p class="text-slate-500 dark:text-slate-400">Loading your playlist…</p>
    </div>

    <div id="emptyState" class="hidden text-center py-16">
        <div class="grid place-items-center w-20 h-20 rounded-3xl bg-slate-100 dark:bg-slate-800 text-4xl mx-auto mb-4">📭</div>
        <h3 class="font-display font-bold text-xl text-slate-700 dark:text-slate-200">No playlist to play</h3>
        <p class="text-slate-500 dark:text-slate-400 mt-1">Head back to the builder and add some decks first.</p>
        <a href="{{ route('playlist.index') }}" class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-fuchsia-500 to-rose-500 text-white font-semibold shadow-md hover:-translate-y-0.5 transition-all">
            <i data-lucide="list-music" class="w-4 h-4"></i> Build a playlist
        </a>
    </div>

    <div id="cardArea" class="hidden">
        <!-- The card -->
        <div class="relative mx-auto max-w-2xl mb-6" style="perspective: 1600px;">
            <button id="favoriteBtn" type="button" class="absolute -top-3 -right-3 z-20 grid place-items-center w-11 h-11 rounded-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-400 hover:text-rose-500 shadow-lg hover:scale-110 transition-all" aria-label="Add to favorites">
                <i data-lucide="heart" class="w-5 h-5"></i>
            </button>
            <div id="card" class="relative w-full cursor-pointer transition-transform duration-500" style="transform-style: preserve-3d; min-height: 380px;">
                <!-- FRONT -->
                <div class="card-face absolute inset-0 rounded-3xl bg-gradient-to-br p-[2px] shadow-2xl" id="cardFront" style="backface-visibility: hidden;">
                    <div class="relative h-full rounded-[22px] bg-white dark:bg-slate-900 p-8 sm:p-10 flex flex-col">
                        <div class="absolute top-5 right-5 flex items-center gap-2">
                            <span id="levelBadge" class="px-3 py-1 rounded-lg text-xs font-bold text-white shadow"></span>
                            <span id="themeEmoji" class="grid place-items-center w-9 h-9 rounded-xl text-lg"></span>
                        </div>
                        <div class="flex-1 flex flex-col items-center justify-center text-center">
                            <span class="text-xs font-bold uppercase tracking-widest mb-4" id="promptLabel"></span>
                            <p id="promptText" class="font-display font-bold text-2xl sm:text-3xl text-slate-800 dark:text-slate-100 leading-snug max-w-lg"></p>
                        </div>
                        <div class="mt-6 flex items-center justify-center gap-2 text-sm text-slate-400 dark:text-slate-500">
                            <i data-lucide="rotate-cw" class="w-4 h-4"></i><span>Tap to reveal sample answer</span>
                        </div>
                    </div>
                </div>
                <!-- BACK -->
                <div class="card-face absolute inset-0 rounded-3xl bg-gradient-to-br p-[2px] shadow-2xl" id="cardBack" style="backface-visibility: hidden; transform: rotateY(180deg);">
                    <div class="relative h-full rounded-[22px] bg-white dark:bg-slate-900 p-8 sm:p-10 flex flex-col overflow-hidden">
                        <div class="relative flex items-center justify-between mb-3">
                            <span class="px-3 py-1 rounded-lg text-xs font-bold text-white shadow" id="backBadge">Sample answer</span>
                            <button type="button" id="flipBackBtn" class="grid place-items-center w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors" aria-label="Flip back">
                                <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                            </button>
                        </div>
                        <div class="relative flex-1 overflow-y-auto custom-scroll pr-1">
                            <p id="answerText" class="text-base text-slate-700 dark:text-slate-200 leading-relaxed"></p>
                            <div id="tipsBox" class="mt-5 rounded-2xl p-4 border hidden">
                                <p class="text-xs font-bold uppercase tracking-wide mb-1 flex items-center gap-1.5"><i data-lucide="lightbulb" class="w-3.5 h-3.5"></i> Tip</p>
                                <p id="tipsText" class="text-sm text-slate-600 dark:text-slate-300"></p>
                            </div>
                            <div id="vocabBox" class="mt-4 hidden">
                                <p class="text-xs font-bold uppercase tracking-wide text-slate-400 dark:text-slate-500 mb-2 flex items-center gap-1.5"><i data-lucide="book-open" class="w-3.5 h-3.5"></i> Useful vocabulary</p>
                                <div id="vocabList" class="flex flex-wrap gap-1.5"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <div class="flex flex-wrap items-center justify-center gap-3">
            <button id="prevBtn" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-semibold shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 disabled:opacity-40 disabled:cursor-not-allowed transition-all">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Prev
            </button>
            <button id="flipBtn" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-fuchsia-500 to-rose-500 text-white font-semibold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
                <i data-lucide="rotate-cw" class="w-4 h-4"></i> Flip
            </button>
            <button id="nextBtn" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-semibold shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 disabled:opacity-40 disabled:cursor-not-allowed transition-all">
                Next <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </button>
        </div>
    </div>

    <!-- Completion toast -->
    <div id="doneToast" class="hidden fixed bottom-6 left-1/2 -translate-x-1/2 z-50 px-6 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-semibold shadow-2xl flex items-center gap-3 animate-pop">
        <i data-lucide="party-popper" class="w-5 h-5"></i>
        <span>Playlist complete! Great job 🎉</span>
    </div>
    <div id="confettiContainer" class="pointer-events-none fixed inset-0 z-40 overflow-hidden" aria-hidden="true"></div>
</section>
@endsection

@push('scripts')
<script>
    window.SpeakUpPlaylistPlay = {
        resolveUrl: "{{ route('api.playlist.resolve') }}",
        csrfToken: "{{ csrf_token() }}",
    };
</script>
<script src="{{ asset('js/playlist-play.js') }}" defer></script>
@endpush
