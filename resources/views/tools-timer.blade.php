@extends('layouts.app')

@section('title', 'Speaking Timer — SpeakUp!')

@section('content')
<section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <div class="text-center mb-8">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/70 dark:bg-slate-900/70 border border-white dark:border-slate-700 text-sm font-semibold text-cyan-600 dark:text-cyan-400 shadow-sm">
            <i data-lucide="timer" class="w-4 h-4"></i> Standalone tool
        </span>
        <h1 class="mt-4 font-display font-extrabold text-3xl sm:text-5xl bg-gradient-to-r from-cyan-500 via-teal-500 to-emerald-500 dark:from-cyan-400 dark:via-teal-400 dark:to-emerald-400 bg-clip-text text-transparent">Speaking Timer</h1>
        <p class="mt-3 text-slate-500 dark:text-slate-400 max-w-2xl mx-auto">A focused stopwatch for self-timed speaking practice. Pick a duration, hit start, and speak until the chime.</p>
    </div>

    <!-- The timer ring -->
    <div class="relative mx-auto w-72 h-72 mb-8">
        <svg class="w-full h-full -rotate-90" viewBox="0 0 200 200">
            <circle cx="100" cy="100" r="90" fill="none" stroke="currentColor" stroke-width="10" class="text-slate-200 dark:text-slate-700"></circle>
            <circle id="timerRing" cx="100" cy="100" r="90" fill="none" stroke="url(#timerGrad)" stroke-width="10" stroke-linecap="round" stroke-dasharray="565.48" stroke-dashoffset="565.48" style="transition: stroke-dashoffset 1s linear;"></circle>
            <defs>
                <linearGradient id="timerGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#06b6d4"></stop>
                    <stop offset="100%" stop-color="#10b981"></stop>
                </linearGradient>
            </defs>
        </svg>
        <div class="absolute inset-0 flex flex-col items-center justify-center">
            <span id="timeDisplay" class="font-display font-extrabold text-6xl text-slate-800 dark:text-slate-100 tabular-nums">01:00</span>
            <span id="timerStatus" class="text-sm text-slate-400 dark:text-slate-500 mt-1">Ready</span>
        </div>
    </div>

    <!-- Preset durations -->
    <div class="grid grid-cols-3 sm:grid-cols-6 gap-2 mb-6">
        @foreach ($presets as $p)
            <button class="preset-btn group relative overflow-hidden rounded-2xl p-[2px] shadow-sm hover:shadow-md transition-all" data-secs="{{ $p['secs'] }}">
                <div class="rounded-[14px] bg-gradient-to-br {{ $p['color'] }} p-[2px]">
                    <div class="rounded-[12px] bg-white dark:bg-slate-900 px-2 py-3 text-center">
                        <div class="font-display font-extrabold text-lg bg-gradient-to-r {{ $p['color'] }} bg-clip-text text-transparent">{{ $p['label'] }}</div>
                        <div class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">{{ $p['desc'] }}</div>
                    </div>
                </div>
            </button>
        @endforeach
    </div>

    <!-- Controls -->
    <div class="flex flex-wrap items-center justify-center gap-3 mb-8">
        <button id="startBtn" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-cyan-500 to-emerald-500 text-white font-semibold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
            <i data-lucide="play" class="w-5 h-5"></i> <span>Start</span>
        </button>
        <button id="pauseBtn" class="hidden inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-semibold shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
            <i data-lucide="pause" class="w-5 h-5"></i> Pause
        </button>
        <button id="resetBtn" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-semibold shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
            <i data-lucide="rotate-ccw" class="w-5 h-5"></i> Reset
        </button>
    </div>

    <!-- Warm-up prompts -->
    <div class="rounded-3xl bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-display font-extrabold text-lg text-slate-800 dark:text-slate-100 flex items-center gap-2"><i data-lucide="lightbulb" class="w-5 h-5 text-amber-500"></i> Warm-up prompts</h2>
            <button id="newWarmupBtn" class="text-xs font-semibold text-cyan-600 dark:text-cyan-400 hover:underline">Shuffle</button>
        </div>
        <div id="warmupList" class="space-y-2"></div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    window.SpeakUpTimer = {
        warmups: @json($warmups->map(fn($q) => ['id' => $q->id, 'prompt' => $q->prompt, 'level' => $q->level, 'theme' => ['name' => $q->theme->name, 'emoji' => $q->theme->emoji, 'gradient' => $q->theme->gradient]])),
    };
</script>
<script src="{{ asset('js/timer.js') }}" defer></script>
@endpush
