@extends('layouts.app')

@section('title', $theme->name . ' · ' . $level . ' — Play')

@php
    $levelStyles = [
        'A1' => ['gradient' => 'from-emerald-400 to-green-500', 'text' => 'text-emerald-600', 'bg' => 'bg-emerald-500', 'soft' => 'bg-emerald-50', 'border' => 'border-emerald-200', 'emoji' => '🌱'],
        'A2' => ['gradient' => 'from-teal-400 to-cyan-500', 'text' => 'text-teal-600', 'bg' => 'bg-teal-500', 'soft' => 'bg-teal-50', 'border' => 'border-teal-200', 'emoji' => '🌿'],
        'B1' => ['gradient' => 'from-amber-400 to-orange-500', 'text' => 'text-amber-600', 'bg' => 'bg-amber-500', 'soft' => 'bg-amber-50', 'border' => 'border-amber-200', 'emoji' => '⚡'],
        'B2' => ['gradient' => 'from-rose-400 to-pink-600', 'text' => 'text-rose-600', 'bg' => 'bg-rose-500', 'soft' => 'bg-rose-50', 'border' => 'border-rose-200', 'emoji' => '🔥'],
    ];
    $s = $levelStyles[$level];
@endphp

@section('content')
<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

    <!-- Top bar: breadcrumb + level switcher -->
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <nav class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
            <a href="{{ route('home') }}" class="hover:text-rose-600 dark:hover:text-rose-400 transition-colors">Themes</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <a href="{{ route('themes.show', $theme) }}" class="hover:text-rose-600 dark:hover:text-rose-400 transition-colors">{{ $theme->name }}</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="font-semibold {{ $s['text'] }}">{{ $level }}</span>
        </nav>

        <!-- Level switcher -->
        <div class="inline-flex items-center rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 p-1 shadow-sm">
            @foreach (['A1','A2','B1','B2'] as $lvl)
                @php $ls = $levelStyles[$lvl]; @endphp
                <a href="{{ route('game.play', [$theme, strtolower($lvl)]) }}"
                   class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $level === $lvl ? 'bg-gradient-to-r '.$ls['gradient'].' text-white shadow' : 'text-slate-500 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                    {{ $lvl }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Game header -->
    <div class="flex items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <span class="grid place-items-center w-12 h-12 rounded-2xl bg-gradient-to-br {{ $theme->gradient }} text-2xl shadow-lg">{{ $theme->emoji }}</span>
            <div>
                <h1 class="font-display font-extrabold text-xl sm:text-2xl text-slate-800 dark:text-slate-100 leading-tight">{{ $theme->name }}</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $level }} deck · {{ $questions->count() }} cards</p>
            </div>
        </div>

        <!-- Timer + TTS -->
        <div class="flex items-center gap-2 sm:gap-3">
            <button id="speakPromptBtn" type="button" class="grid place-items-center w-11 h-11 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-300 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors" aria-label="Read prompt aloud" title="Read prompt aloud (Text-to-Speech)">
                <i data-lucide="volume-2" class="w-5 h-5"></i>
            </button>
            <div id="timerCard" class="flex items-center gap-2 px-4 py-2 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 shadow-sm">
                <i data-lucide="timer" class="w-4 h-4 {{ $s['text'] }}"></i>
                <span id="timerDisplay" class="font-mono font-bold text-lg tabular-nums {{ $s['text'] }}">00:00</span>
            </div>
        </div>
    </div>

    <!-- Progress bar -->
    <div class="mb-6">
        <div class="flex items-center justify-between text-sm mb-1.5">
            <span class="font-semibold text-slate-600 dark:text-slate-300">Card <span id="currentNum" class="{{ $s['text'] }}">1</span> of <span id="totalNum">{{ $questions->count() }}</span></span>
            <span class="text-slate-400 dark:text-slate-500">Practiced: <span id="practicedCount" class="font-bold {{ $s['text'] }}">0</span></span>
        </div>
        <div class="h-2.5 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">
            <div id="progressBar" class="h-full bg-gradient-to-r {{ $s['gradient'] }} rounded-full transition-all duration-300" style="width: 0%"></div>
        </div>
    </div>

    <!-- The card -->
    <div class="relative mx-auto max-w-2xl mb-6" style="perspective: 1600px;">
        <!-- Favorite star (top-right floating) -->
        <button id="favoriteBtn" type="button" class="absolute -top-3 -right-3 z-20 grid place-items-center w-11 h-11 rounded-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-400 hover:text-rose-500 shadow-lg hover:scale-110 transition-all" aria-label="Add to favorites" title="Add to favorites">
            <i data-lucide="heart" class="w-5 h-5"></i>
        </button>

        <div id="card" class="relative w-full cursor-pointer transition-transform duration-500" style="transform-style: preserve-3d; min-height: 460px;">

            <!-- FRONT: the question -->
            <div class="card-face absolute inset-0 rounded-3xl bg-gradient-to-br {{ $theme->gradient }} p-[2px] shadow-2xl" style="backface-visibility: hidden;">
                <div class="relative h-full rounded-[22px] bg-white dark:bg-slate-900 p-8 sm:p-10 flex flex-col">
                    <div class="absolute top-5 right-5 flex items-center gap-2">
                        <span class="px-3 py-1 rounded-lg text-xs font-bold bg-gradient-to-r {{ $s['gradient'] }} text-white shadow">{{ $level }}</span>
                        <span class="grid place-items-center w-9 h-9 rounded-xl {{ $s['soft'] }} text-lg">{{ $theme->emoji }}</span>
                    </div>

                    <div class="flex-1 flex flex-col items-center justify-center text-center">
                        <span class="text-xs font-bold uppercase tracking-widest {{ $s['text'] }} mb-4">Speaking prompt</span>
                        <p id="promptText" class="font-display font-bold text-2xl sm:text-3xl text-slate-800 dark:text-slate-100 leading-snug max-w-lg"></p>
                    </div>

                    <div class="mt-6 flex items-center justify-center gap-2 text-sm text-slate-400 dark:text-slate-500">
                        <i data-lucide="rotate-cw" class="w-4 h-4"></i>
                        <span>Tap card to reveal a sample answer</span>
                    </div>
                </div>
            </div>

            <!-- BACK: sample answer + tips + vocab -->
            <div class="card-face absolute inset-0 rounded-3xl bg-gradient-to-br {{ $s['gradient'] }} p-[2px] shadow-2xl" style="backface-visibility: hidden; transform: rotateY(180deg);">
                <div class="relative h-full rounded-[22px] bg-white dark:bg-slate-900 p-8 sm:p-10 flex flex-col overflow-hidden">
                    <div class="absolute -top-12 -right-12 w-40 h-40 rounded-full bg-gradient-to-br {{ $s['gradient'] }} opacity-20 blur-2xl"></div>

                    <div class="relative flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 rounded-lg text-xs font-bold bg-gradient-to-r {{ $s['gradient'] }} text-white shadow">Sample answer</span>
                            <button type="button" id="speakAnswerBtn" class="grid place-items-center w-7 h-7 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors" aria-label="Read answer aloud" title="Read answer aloud">
                                <i data-lucide="volume-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                        <button type="button" id="flipBackBtn" class="grid place-items-center w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors" aria-label="Flip back">
                            <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                        </button>
                    </div>

                    <div class="relative flex-1 overflow-y-auto custom-scroll pr-1">
                        <p id="answerText" class="text-base text-slate-700 dark:text-slate-200 leading-relaxed"></p>

                        <div id="tipsBox" class="mt-5 rounded-2xl {{ $s['soft'] }} border {{ $s['border'] }} p-4">
                            <p class="text-xs font-bold uppercase tracking-wide {{ $s['text'] }} mb-1 flex items-center gap-1.5"><i data-lucide="lightbulb" class="w-3.5 h-3.5"></i> Tip</p>
                            <p id="tipsText" class="text-sm text-slate-600 dark:text-slate-300"></p>
                        </div>

                        <div id="vocabBox" class="mt-4">
                            <p class="text-xs font-bold uppercase tracking-wide text-slate-400 dark:text-slate-500 mb-2 flex items-center gap-1.5"><i data-lucide="book-open" class="w-3.5 h-3.5"></i> Useful vocabulary</p>
                            <div id="vocabList" class="flex flex-wrap gap-1.5"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Controls -->
    <div class="flex flex-wrap items-center justify-center gap-3 mb-4">
        <button id="prevBtn" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-semibold shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 disabled:opacity-40 disabled:cursor-not-allowed transition-all">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Prev
        </button>

        <button id="shuffleBtn" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-semibold shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
            <i data-lucide="shuffle" class="w-4 h-4"></i> Shuffle
        </button>

        <button id="practicedBtn" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-semibold shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
            <i data-lucide="check" class="w-4 h-4"></i> <span>Mark practiced</span>
        </button>

        <button id="flipBtn" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r {{ $s['gradient'] }} text-white font-semibold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
            <i data-lucide="rotate-cw" class="w-4 h-4"></i> Flip
        </button>

        <button id="nextBtn" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-semibold shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 disabled:opacity-40 disabled:cursor-not-allowed transition-all">
            Next <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </button>
    </div>

    <!-- Voice recording panel -->
    <div class="max-w-2xl mx-auto mt-6 rounded-2xl bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700 p-5 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <i data-lucide="mic" class="w-5 h-5 {{ $s['text'] }}"></i>
                <span class="font-semibold text-slate-700 dark:text-slate-200">Record yourself</span>
                <span class="text-xs text-slate-400 dark:text-slate-500 hidden sm:inline">— listen back and self-assess</span>
            </div>
            <div class="flex items-center gap-2">
                <button id="recordBtn" type="button" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r {{ $s['gradient'] }} text-white font-semibold shadow-sm hover:shadow-md transition-all">
                    <i data-lucide="mic" class="w-4 h-4"></i> <span>Start</span>
                </button>
                <button id="playRecordingBtn" type="button" class="hidden inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-semibold shadow-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
                    <i data-lucide="play" class="w-4 h-4"></i> Play
                </button>
                <button id="deleteRecordingBtn" type="button" class="hidden grid place-items-center w-9 h-9 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-300 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-all" aria-label="Delete recording">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
        <div id="recordingStatus" class="hidden mt-3 flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
            <span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-pulse"></span>
            <span id="recordingTimer" class="font-mono">00:00</span>
            <span>recording…</span>
        </div>
        <audio id="recordingPlayer" class="hidden w-full mt-3" controls></audio>
        <p id="recordingHint" class="mt-3 text-xs text-slate-400 dark:text-slate-500">Tip: speak for the suggested {{ $suggestedTime }}s, then play it back to compare with the sample answer.</p>
    </div>

    <!-- Completion toast -->
    <div id="doneToast" class="hidden fixed bottom-6 left-1/2 -translate-x-1/2 z-50 px-6 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-semibold shadow-2xl flex items-center gap-3 animate-pop">
        <i data-lucide="party-popper" class="w-5 h-5"></i>
        <span>Deck complete! Great job practicing 🎉</span>
    </div>

    <!-- Confetti container -->
    <div id="confettiContainer" class="pointer-events-none fixed inset-0 z-40 overflow-hidden" aria-hidden="true"></div>

    <!-- Back to theme -->
    <div class="mt-10 text-center">
        <a href="{{ route('themes.show', $theme) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 dark:text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Try another level
        </a>
    </div>
</section>
@endsection

@push('scripts')
<script>
    window.SpeakUp = {
        themeSlug: "{{ $theme->slug }}",
        level: "{{ $level }}",
        suggestedTime: {{ $suggestedTime }},
        questions: @json($questions->values()),
        csrfToken: "{{ csrf_token() }}",
        saveUrl: "{{ route('api.progress.save') }}",
    };
</script>
<script src="{{ asset('js/game.js') }}" defer></script>
@endpush
