@extends('layouts.app')

@section('title', $theme->name . ' · ' . $level . ' — Pair Work')

@php
    $levelStyles = [
        'A1' => ['gradient' => 'from-emerald-400 to-green-500', 'text' => 'text-emerald-600 dark:text-emerald-400', 'soft' => 'bg-emerald-50 dark:bg-emerald-950/40'],
        'A2' => ['gradient' => 'from-teal-400 to-cyan-500', 'text' => 'text-teal-600 dark:text-teal-400', 'soft' => 'bg-teal-50 dark:bg-teal-950/40'],
        'B1' => ['gradient' => 'from-amber-400 to-orange-500', 'text' => 'text-amber-600 dark:text-amber-400', 'soft' => 'bg-amber-50 dark:bg-amber-950/40'],
        'B2' => ['gradient' => 'from-rose-400 to-pink-600', 'text' => 'text-rose-600 dark:text-rose-400', 'soft' => 'bg-rose-50 dark:bg-rose-950/40'],
    ];
    $s = $levelStyles[$level];
@endphp

@section('content')
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

    <!-- Top bar -->
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <nav class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
            <a href="{{ route('pairwork.setup') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Pair Work</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="font-semibold {{ $s['text'] }}">{{ $theme->name }} · {{ $level }}</span>
        </nav>
        <span class="text-sm text-slate-400 dark:text-slate-500">Card <span id="cardNum">1</span> / {{ $questions->count() }}</span>
    </div>

    <!-- Turn indicator -->
    <div class="mb-6">
        <div id="turnBanner" class="rounded-3xl p-[2px] bg-gradient-to-r from-indigo-500 to-fuchsia-500 shadow-lg transition-all">
            <div class="rounded-[22px] bg-white dark:bg-slate-900 p-5 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <span id="turnAvatar" class="grid place-items-center w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white font-display font-extrabold text-2xl shadow-lg">A</span>
                    <div>
                        <p class="text-xs uppercase tracking-wide text-slate-400 dark:text-slate-500">Now speaking</p>
                        <p id="turnName" class="font-display font-extrabold text-xl text-slate-800 dark:text-slate-100">Player A</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xs uppercase tracking-wide text-slate-400 dark:text-slate-500">Task</p>
                    <p id="turnTask" class="font-semibold text-sm text-indigo-600 dark:text-indigo-400">Answer the prompt</p>
                </div>
            </div>
        </div>
    </div>

    <!-- The card -->
    <div class="relative mx-auto max-w-2xl mb-6">
        <div id="card" class="relative w-full rounded-3xl bg-gradient-to-br {{ $theme->gradient }} p-[2px] shadow-2xl">
            <div class="rounded-[22px] bg-white dark:bg-slate-900 p-8 sm:p-10 flex flex-col min-h-[280px]">
                <div class="flex items-center justify-between mb-4">
                    <span class="px-3 py-1 rounded-lg text-xs font-bold bg-gradient-to-r {{ $s['gradient'] }} text-white shadow">{{ $level }} · {{ $theme->name }}</span>
                    <button type="button" id="speakBtn" class="grid place-items-center w-9 h-9 rounded-xl {{ $s['soft'] }} {{ $s['text'] }} hover:scale-110 transition-transform" aria-label="Read prompt aloud">
                        <i data-lucide="volume-2" class="w-4 h-4"></i>
                    </button>
                </div>
                <div class="flex-1 flex flex-col items-center justify-center text-center">
                    <span class="text-xs font-bold uppercase tracking-widest {{ $s['text'] }} mb-4">Speaking prompt</span>
                    <p id="promptText" class="font-display font-bold text-2xl sm:text-3xl text-slate-800 dark:text-slate-100 leading-snug max-w-lg"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Controls -->
    <div class="flex flex-wrap items-center justify-center gap-3 mb-6">
        <button id="prevBtn" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-semibold shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 disabled:opacity-40 disabled:cursor-not-allowed transition-all">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Prev
        </button>
        <button id="revealBtn" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-indigo-500 to-fuchsia-500 text-white font-semibold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
            <i data-lucide="eye" class="w-4 h-4"></i> Reveal sample answer
        </button>
        <button id="nextBtn" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-semibold shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 disabled:opacity-40 disabled:cursor-not-allowed transition-all">
            Next <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </button>
    </div>

    <!-- Sample answer (hidden until revealed) -->
    <div id="answerPanel" class="hidden max-w-2xl mx-auto rounded-3xl bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="px-3 py-1 rounded-lg text-xs font-bold bg-gradient-to-r {{ $s['gradient'] }} text-white shadow">Sample answer</span>
            <button type="button" id="speakAnswerBtn" class="grid place-items-center w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors" aria-label="Read answer aloud">
                <i data-lucide="volume-2" class="w-4 h-4"></i>
            </button>
        </div>
        <p id="answerText" class="text-base text-slate-700 dark:text-slate-200 leading-relaxed"></p>
    </div>

    <!-- Back -->
    <div class="mt-10 text-center">
        <a href="{{ route('pairwork.setup') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Pick another deck
        </a>
    </div>
</section>
@endsection

@push('scripts')
<script>
    window.SpeakUpPairwork = {
        questions: @json($questions->values()),
        suggestedTime: {{ $suggestedTime }},
    };
</script>
<script src="{{ asset('js/pairwork.js') }}" defer></script>
@endpush
