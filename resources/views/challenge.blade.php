@extends('layouts.app')

@section('title', ($mode === 'daily' ? 'Daily Challenge' : 'Random Card') . ' — SpeakUp!')

@php
    $q = $question;
    $s = $levelStyle;
@endphp

@section('content')
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <!-- Header -->
    <div class="text-center mb-8">
        @if ($mode === 'daily')
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gradient-to-r from-amber-400 to-orange-500 text-white text-sm font-semibold shadow-md animate-float">
                <i data-lucide="gift" class="w-4 h-4"></i> Card of the day
            </span>
            <h1 class="mt-4 font-display font-extrabold text-3xl sm:text-5xl bg-gradient-to-r from-amber-500 via-orange-500 to-rose-500 dark:from-amber-400 dark:via-orange-400 dark:to-rose-400 bg-clip-text text-transparent">Daily Challenge</h1>
            <p class="mt-3 text-slate-500 dark:text-slate-400">A new speaking prompt every day. Same card for everyone — discuss it with your class!</p>
        @else
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gradient-to-r from-violet-500 to-fuchsia-500 text-white text-sm font-semibold shadow-md animate-float">
                <i data-lucide="shuffle" class="w-4 h-4"></i> Surprise me
            </span>
            <h1 class="mt-4 font-display font-extrabold text-3xl sm:text-5xl bg-gradient-to-r from-violet-500 via-fuchsia-500 to-rose-500 dark:from-violet-400 dark:via-fuchsia-400 dark:to-rose-400 bg-clip-text text-transparent">Random Card</h1>
            <p class="mt-3 text-slate-500 dark:text-slate-400">A fresh random prompt. Draw again whenever you want a new one.</p>
        @endif
    </div>

    <!-- The card (static, with flip via JS) -->
    <div class="relative mx-auto max-w-2xl mb-6" style="perspective: 1600px;">
        <button id="favoriteBtn" type="button" class="absolute -top-3 -right-3 z-20 grid place-items-center w-11 h-11 rounded-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-400 hover:text-rose-500 shadow-lg hover:scale-110 transition-all" aria-label="Add to favorites" title="Add to favorites">
            <i data-lucide="heart" class="w-5 h-5"></i>
        </button>

        <div id="card" class="relative w-full cursor-pointer transition-transform duration-500" style="transform-style: preserve-3d; min-height: 440px;" data-question-id="{{ $q->id }}" data-level="{{ $q->level }}">

            <!-- FRONT -->
            <div class="card-face absolute inset-0 rounded-3xl bg-gradient-to-br {{ $theme->gradient }} p-[2px] shadow-2xl" style="backface-visibility: hidden;">
                <div class="relative h-full rounded-[22px] bg-white dark:bg-slate-900 p-8 sm:p-10 flex flex-col">
                    <div class="absolute top-5 right-5 flex items-center gap-2">
                        <span class="px-3 py-1 rounded-lg text-xs font-bold bg-gradient-to-r {{ $s['gradient'] }} text-white shadow">{{ $q->level }}</span>
                        <span class="grid place-items-center w-9 h-9 rounded-xl {{ $s['soft'] }} text-lg">{{ $theme->emoji }}</span>
                    </div>

                    <div class="flex-1 flex flex-col items-center justify-center text-center">
                        <span class="text-xs font-bold uppercase tracking-widest {{ $s['text'] }} mb-4">Speaking prompt · {{ $theme->name }}</span>
                        <p id="promptText" class="font-display font-bold text-2xl sm:text-3xl text-slate-800 dark:text-slate-100 leading-snug max-w-lg">{{ $q->prompt }}</p>
                    </div>

                    <div class="mt-6 flex items-center justify-center gap-2 text-sm text-slate-400 dark:text-slate-500">
                        <i data-lucide="rotate-cw" class="w-4 h-4"></i>
                        <span>Tap card to reveal a sample answer</span>
                    </div>
                </div>
            </div>

            <!-- BACK -->
            <div class="card-face absolute inset-0 rounded-3xl bg-gradient-to-br {{ $s['gradient'] }} p-[2px] shadow-2xl" style="backface-visibility: hidden; transform: rotateY(180deg);">
                <div class="relative h-full rounded-[22px] bg-white dark:bg-slate-900 p-8 sm:p-10 flex flex-col overflow-hidden">
                    <div class="absolute -top-12 -right-12 w-40 h-40 rounded-full bg-gradient-to-br {{ $s['gradient'] }} opacity-20 blur-2xl"></div>

                    <div class="relative flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 rounded-lg text-xs font-bold bg-gradient-to-r {{ $s['gradient'] }} text-white shadow">Sample answer</span>
                            <button type="button" id="speakAnswerBtn" class="grid place-items-center w-7 h-7 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors" aria-label="Read answer aloud">
                                <i data-lucide="volume-2" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                        <button type="button" id="flipBackBtn" class="grid place-items-center w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors" aria-label="Flip back">
                            <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                        </button>
                    </div>

                    <div class="relative flex-1 overflow-y-auto custom-scroll pr-1">
                        <p id="answerText" class="text-base text-slate-700 dark:text-slate-200 leading-relaxed">{{ $q->sample_answer }}</p>

                        @if ($q->tips)
                            <div class="mt-5 rounded-2xl {{ $s['soft'] }} border {{ $s['border'] }} p-4">
                                <p class="text-xs font-bold uppercase tracking-wide {{ $s['text'] }} mb-1 flex items-center gap-1.5"><i data-lucide="lightbulb" class="w-3.5 h-3.5"></i> Tip</p>
                                <p class="text-sm text-slate-600 dark:text-slate-300">{{ $q->tips }}</p>
                            </div>
                        @endif

                        @if (!empty($q->vocabulary))
                            <div class="mt-4">
                                <p class="text-xs font-bold uppercase tracking-wide text-slate-400 dark:text-slate-500 mb-2 flex items-center gap-1.5"><i data-lucide="book-open" class="w-3.5 h-3.5"></i> Useful vocabulary</p>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach ($q->vocabulary as $word)
                                        <span class="vocab-chip" data-word="{{ $word }}">{{ $word }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Controls -->
    <div class="flex flex-wrap items-center justify-center gap-3 mb-4">
        <button id="flipBtn" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r {{ $s['gradient'] }} text-white font-semibold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
            <i data-lucide="rotate-cw" class="w-4 h-4"></i> Flip
        </button>
        <button id="speakPromptBtn" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-semibold shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
            <i data-lucide="volume-2" class="w-4 h-4"></i> Read aloud
        </button>
        @if ($mode === 'daily')
            <a href="{{ route('challenge.random') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-semibold shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                <i data-lucide="shuffle" class="w-4 h-4"></i> Surprise me
            </a>
        @else
            <a href="{{ route('challenge.random') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-semibold shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i> Another one
            </a>
        @endif
        <a href="{{ route('game.play', [$theme, strtolower($q->level)]) }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-semibold shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
            <i data-lucide="layers" class="w-4 h-4"></i> Full deck
        </a>
    </div>

    @if ($mode === 'daily' && $nextDay)
        <!-- Countdown to next card -->
        <div class="max-w-2xl mx-auto mt-6 rounded-2xl bg-white/70 dark:bg-slate-900/70 border border-slate-200 dark:border-slate-700 p-5 text-center">
            <p class="text-sm text-slate-500 dark:text-slate-400">Next daily card in</p>
            <p id="countdown" class="font-display font-extrabold text-2xl text-amber-600 dark:text-amber-400 mt-1 tabular-nums" data-next="{{ $nextDay->timestamp }}">--:--:--</p>
        </div>
    @endif
</section>
@endsection

@push('scripts')
<script>
    window.SpeakUpChallenge = {
        questionId: {{ $q->id }},
        prompt: @json($q->prompt),
        sampleAnswer: @json($q->sample_answer),
        csrfToken: "{{ csrf_token() }}",
    };
</script>
<script src="{{ asset('js/challenge.js') }}" defer></script>
@endpush
