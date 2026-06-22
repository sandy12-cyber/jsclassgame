@extends('layouts.app')

@section('title', 'SpeakUp! — Pick a Theme')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">

    <!-- Hero -->
    <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/70 dark:bg-slate-900/70 border border-white dark:border-slate-700 text-sm font-semibold text-rose-600 dark:text-rose-400 shadow-sm animate-float">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Practice speaking · {{ $totalQuestions }} questions ready
        </span>
        <h1 class="mt-6 font-display font-extrabold text-4xl sm:text-6xl tracking-tight leading-tight">
            <span class="bg-gradient-to-r from-rose-600 via-fuchsia-600 to-violet-600 dark:from-rose-400 dark:via-fuchsia-400 dark:to-violet-400 bg-clip-text text-transparent">Speak up</span>,
            <span class="bg-gradient-to-r from-amber-500 via-orange-500 to-rose-500 dark:from-amber-400 dark:via-orange-400 dark:to-rose-400 bg-clip-text text-transparent">level up</span>
        </h1>
        <p class="mt-5 text-lg text-slate-600 dark:text-slate-300 max-w-2xl mx-auto">
            Pick a theme, choose your level from <strong class="text-emerald-600 dark:text-emerald-400">A1</strong> to <strong class="text-rose-600 dark:text-rose-400">B2</strong>,
            and draw speaking question cards to practice aloud — alone, with a friend, or in class.
        </p>

        <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
            <a href="#themes" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-rose-500 via-fuchsia-500 to-violet-500 text-white font-semibold shadow-lg shadow-fuchsia-500/30 hover:shadow-xl hover:shadow-fuchsia-500/40 hover:-translate-y-0.5 transition-all">
                <i data-lucide="layout-grid" class="w-5 h-5"></i>
                Browse themes
            </a>
            <a href="{{ route('challenge.daily') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-amber-400 to-orange-500 text-white font-semibold shadow-lg shadow-orange-500/30 hover:shadow-xl hover:-translate-y-0.5 transition-all">
                <i data-lucide="gift" class="w-5 h-5"></i>
                Daily Challenge
            </a>
            <a href="{{ route('about') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-white/80 dark:bg-slate-900/80 border border-white dark:border-slate-700 text-slate-700 dark:text-slate-200 font-semibold shadow-sm hover:bg-white dark:hover:bg-slate-900 hover:-translate-y-0.5 transition-all">
                <i data-lucide="help-circle" class="w-5 h-5"></i>
                How to play
            </a>
        </div>

        <!-- Quick stats -->
        <div class="mt-10 grid grid-cols-3 gap-3 max-w-md mx-auto">
            <div class="rounded-2xl bg-white/70 dark:bg-slate-900/70 border border-white dark:border-slate-700 p-4 shadow-sm">
                <div class="text-2xl font-display font-extrabold text-rose-600 dark:text-rose-400">{{ $totalThemes }}</div>
                <div class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide">Themes</div>
            </div>
            <div class="rounded-2xl bg-white/70 dark:bg-slate-900/70 border border-white dark:border-slate-700 p-4 shadow-sm">
                <div class="text-2xl font-display font-extrabold text-violet-600 dark:text-violet-400">{{ $totalQuestions }}</div>
                <div class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide">Questions</div>
            </div>
            <div class="rounded-2xl bg-white/70 dark:bg-slate-900/70 border border-white dark:border-slate-700 p-4 shadow-sm">
                <div class="text-2xl font-display font-extrabold text-emerald-600 dark:text-emerald-400">4</div>
                <div class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide">Levels</div>
            </div>
        </div>
    </div>

    <!-- Themes grid -->
    <div id="themes" class="scroll-mt-24">
        <div class="flex items-end justify-between mb-6">
            <div>
                <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-800 dark:text-slate-100">Choose a theme</h2>
                <p class="text-slate-500 dark:text-slate-400 mt-1">Each theme has questions for every CEFR level.</p>
            </div>
            <span class="hidden sm:inline-flex items-center gap-1.5 text-sm text-slate-400 dark:text-slate-500">
                <i data-lucide="sparkles" class="w-4 h-4"></i> colorful & aesthetic
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
            @foreach ($themes as $theme)
                <a href="{{ route('themes.show', $theme) }}"
                   class="group relative overflow-hidden rounded-3xl bg-gradient-to-br {{ $theme->gradient }} p-[2px] shadow-lg hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 animate-pop"
                   style="animation-delay: {{ ($loop->index * 60) }}ms">
                    <div class="relative h-full rounded-[22px] bg-white/95 dark:bg-slate-900/95 backdrop-blur p-6 flex flex-col">
                        <!-- decorative blob -->
                        <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full bg-gradient-to-br {{ $theme->gradient }} opacity-20 blur-2xl group-hover:opacity-40 transition-opacity"></div>

                        <div class="relative flex items-start justify-between">
                            <div class="grid place-items-center w-16 h-16 rounded-2xl bg-gradient-to-br {{ $theme->gradient }} text-3xl shadow-lg group-hover:scale-110 group-hover:-rotate-6 transition-transform">
                                {{ $theme->emoji }}
                            </div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                {{ $loop->iteration }}
                            </span>
                        </div>

                        <h3 class="relative mt-4 font-display font-extrabold text-xl text-slate-800 dark:text-slate-100">{{ $theme->name }}</h3>
                        <p class="relative mt-2 text-sm text-slate-500 dark:text-slate-400 leading-relaxed flex-1">{{ $theme->description }}</p>

                        <!-- level pills -->
                        <div class="relative mt-5 flex flex-wrap gap-1.5">
                            @foreach (['A1' => 'emerald', 'A2' => 'teal', 'B1' => 'amber', 'B2' => 'rose'] as $lvl => $clr)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-{{ $clr }}-100 text-{{ $clr }}-700 dark:bg-{{ $clr }}-950/50 dark:text-{{ $clr }}-300">
                                    {{ $lvl }}
                                    <span class="font-medium opacity-70">· {{ $theme->level_counts[$lvl] ?? 0 }}</span>
                                </span>
                            @endforeach
                        </div>

                        <div class="relative mt-5 flex items-center justify-between text-sm font-semibold text-slate-600 dark:text-slate-300">
                            <span>{{ $theme->total_questions }} questions</span>
                            <span class="inline-flex items-center gap-1 text-{{ $theme->accent }}-600 dark:text-{{ $theme->accent }}-400 group-hover:gap-2 transition-all">
                                Start <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
