@extends('layouts.app')

@section('title', $theme->name . ' · ' . $level . ' — Lesson')

@php
    $levelStyles = [
        'A1' => ['gradient' => 'from-emerald-400 to-green-500', 'text' => 'text-emerald-600 dark:text-emerald-400', 'soft' => 'bg-emerald-50 dark:bg-emerald-950/40', 'border' => 'border-emerald-200 dark:border-emerald-800', 'emoji' => '🌱'],
        'A2' => ['gradient' => 'from-teal-400 to-cyan-500', 'text' => 'text-teal-600 dark:text-teal-400', 'soft' => 'bg-teal-50 dark:bg-teal-950/40', 'border' => 'border-teal-200 dark:border-teal-800', 'emoji' => '🌿'],
        'B1' => ['gradient' => 'from-amber-400 to-orange-500', 'text' => 'text-amber-600 dark:text-amber-400', 'soft' => 'bg-amber-50 dark:bg-amber-950/40', 'border' => 'border-amber-200 dark:border-amber-800', 'emoji' => '⚡'],
        'B2' => ['gradient' => 'from-rose-400 to-pink-600', 'text' => 'text-rose-600 dark:text-rose-400', 'soft' => 'bg-rose-50 dark:bg-rose-950/40', 'border' => 'border-rose-200 dark:border-rose-800', 'emoji' => '🔥'],
    ];
    $s = $levelStyles[$level];
@endphp

@section('content')
<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

    <!-- Top bar -->
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <nav class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
            <a href="{{ route('home') }}" class="hover:text-rose-600 dark:hover:text-rose-400 transition-colors">Themes</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <a href="{{ route('themes.show', $theme) }}" class="hover:text-rose-600 dark:hover:text-rose-400 transition-colors">{{ $theme->name }}</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="inline-flex items-center gap-1 font-semibold {{ $s['text'] }}"><i data-lucide="graduation-cap" class="w-3.5 h-3.5"></i> Lesson · {{ $level }}</span>
        </nav>
        <a href="{{ route('game.play', [$theme, strtolower($level)]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
            <i data-lucide="play" class="w-3.5 h-3.5"></i> Quick play
        </a>
    </div>

    <!-- Lesson header -->
    <div class="rounded-3xl bg-gradient-to-br {{ $theme->gradient }} p-[2px] shadow-xl mb-6">
        <div class="rounded-[22px] bg-white dark:bg-slate-900 p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="grid place-items-center w-16 h-16 rounded-2xl bg-gradient-to-br {{ $theme->gradient }} text-3xl shadow-lg shrink-0">{{ $theme->emoji }}</div>
            <div class="flex-1">
                <h1 class="font-display font-extrabold text-2xl text-slate-800 dark:text-slate-100">{{ $theme->name }} · Lesson Mode</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Practise each card, then self-assess on a 4-criterion speaking rubric. Your scores are saved on this device.</p>
            </div>
            <div class="flex items-center gap-2">
                <div class="text-center px-4 py-2 rounded-xl bg-slate-50 dark:bg-slate-800">
                    <div class="font-display font-extrabold text-2xl {{ $s['text'] }}" id="lessonCardNum">1</div>
                    <div class="text-[10px] uppercase tracking-wide text-slate-400">of {{ $questions->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- The card -->
    <div class="relative mx-auto max-w-2xl mb-6" style="perspective: 1600px;">
        <button id="favoriteBtn" type="button" class="absolute -top-3 -right-3 z-20 grid place-items-center w-11 h-11 rounded-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-400 hover:text-rose-500 shadow-lg hover:scale-110 transition-all" aria-label="Add to favorites" title="Add to favorites">
            <i data-lucide="heart" class="w-5 h-5"></i>
        </button>

        <div id="card" class="relative w-full cursor-pointer transition-transform duration-500" style="transform-style: preserve-3d; min-height: 360px;">
            <!-- FRONT -->
            <div class="card-face absolute inset-0 rounded-3xl bg-gradient-to-br {{ $theme->gradient }} p-[2px] shadow-2xl" style="backface-visibility: hidden;">
                <div class="relative h-full rounded-[22px] bg-white dark:bg-slate-900 p-8 sm:p-10 flex flex-col">
                    <div class="absolute top-5 right-5 flex items-center gap-2">
                        <span class="px-3 py-1 rounded-lg text-xs font-bold bg-gradient-to-r {{ $s['gradient'] }} text-white shadow">{{ $level }}</span>
                        <button type="button" id="speakPromptBtn" class="grid place-items-center w-9 h-9 rounded-xl {{ $s['soft'] }} {{ $s['text'] }} hover:scale-110 transition-transform" aria-label="Read prompt aloud">
                            <i data-lucide="volume-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                    <div class="flex-1 flex flex-col items-center justify-center text-center">
                        <span class="text-xs font-bold uppercase tracking-widest {{ $s['text'] }} mb-4">Speaking prompt</span>
                        <p id="promptText" class="font-display font-bold text-2xl sm:text-3xl text-slate-800 dark:text-slate-100 leading-snug max-w-lg"></p>
                    </div>
                    <div class="mt-6 flex items-center justify-center gap-2 text-sm text-slate-400 dark:text-slate-500">
                        <i data-lucide="rotate-cw" class="w-4 h-4"></i>
                        <span>Tap to reveal the sample answer</span>
                    </div>
                </div>
            </div>

            <!-- BACK -->
            <div class="card-face absolute inset-0 rounded-3xl bg-gradient-to-br {{ $s['gradient'] }} p-[2px] shadow-2xl" style="backface-visibility: hidden; transform: rotateY(180deg);">
                <div class="relative h-full rounded-[22px] bg-white dark:bg-slate-900 p-8 sm:p-10 flex flex-col overflow-hidden">
                    <div class="absolute -top-12 -right-12 w-40 h-40 rounded-full bg-gradient-to-br {{ $s['gradient'] }} opacity-20 blur-2xl"></div>
                    <div class="relative flex items-center justify-between mb-3">
                        <span class="px-3 py-1 rounded-lg text-xs font-bold bg-gradient-to-r {{ $s['gradient'] }} text-white shadow">Sample answer</span>
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

    <!-- Self-assessment rubric -->
    <div class="max-w-2xl mx-auto rounded-3xl bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
        <div class="flex items-center gap-2 mb-1">
            <i data-lucide="clipboard-check" class="w-5 h-5 {{ $s['text'] }}"></i>
            <h2 class="font-display font-bold text-lg text-slate-800 dark:text-slate-100">Self-assessment</h2>
        </div>
        <p class="text-sm text-slate-500 dark:text-slate-400 mb-5">Rate your own answer on each criterion. Be honest — this is for your growth, not a grade.</p>

        <div class="space-y-4" id="rubricContainer">
            @foreach ($rubric as $r)
                <div class="rubric-row" data-key="{{ $r['key'] }}">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <i data-lucide="{{ $r['icon'] }}" class="w-4 h-4 {{ $s['text'] }}"></i>
                            <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $r['label'] }}</span>
                        </div>
                        <span class="text-xs text-slate-400 dark:text-slate-500">{{ $r['desc'] }}</span>
                    </div>
                    <div class="grid grid-cols-4 gap-1.5">
                        @foreach ($r['scale'] as $i => $label)
                            <button type="button" class="rubric-btn px-2 py-2 rounded-lg text-xs font-semibold border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all" data-score="{{ $i + 1 }}" data-key="{{ $r['key'] }}">
                                <span class="block font-bold text-sm">{{ $i + 1 }}</span>
                                <span class="block opacity-80">{{ $label }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Lesson controls -->
        <div class="mt-6 flex flex-wrap items-center justify-between gap-3">
            <button id="prevBtn" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-semibold shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 disabled:opacity-40 disabled:cursor-not-allowed transition-all">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Prev
            </button>
            <div class="text-sm text-slate-500 dark:text-slate-400">
                Avg score: <span id="avgScore" class="font-bold {{ $s['text'] }}">—</span>
            </div>
            <button id="nextBtn" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r {{ $s['gradient'] }} text-white font-semibold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
                Next <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </button>
        </div>
    </div>

    <!-- Back to theme -->
    <div class="mt-10 text-center">
        <a href="{{ route('themes.show', $theme) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 dark:text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to {{ $theme->name }}
        </a>
    </div>
</section>
@endsection

@push('scripts')
<script>
    window.SpeakUpLesson = {
        themeSlug: "{{ $theme->slug }}",
        level: "{{ $level }}",
        questions: @json($questions->values()),
        csrfToken: "{{ csrf_token() }}",
        saveUrl: "{{ route('api.progress.save') }}",
    };
</script>
<script src="{{ asset('js/lesson.js') }}" defer></script>
@endpush
