@extends('layouts.app')

@section('title', 'Stats — SpeakUp!')

@section('content')
<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <div class="text-center mb-8">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/70 dark:bg-slate-900/70 border border-white dark:border-slate-700 text-sm font-semibold text-emerald-600 dark:text-emerald-400 shadow-sm">
            <i data-lucide="bar-chart-3" class="w-4 h-4"></i> Your progress
        </span>
        <h1 class="mt-4 font-display font-extrabold text-3xl sm:text-5xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 dark:from-emerald-400 dark:via-teal-400 dark:to-cyan-400 bg-clip-text text-transparent">Dashboard</h1>
        <p class="mt-3 text-slate-500 dark:text-slate-400">A snapshot of the question bank and your local practice progress.</p>
    </div>

    <!-- Top stat cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="rounded-3xl bg-gradient-to-br from-rose-500 to-pink-600 p-5 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <i data-lucide="layout-grid" class="w-6 h-6 opacity-80"></i>
                <span class="text-xs font-bold uppercase tracking-wider opacity-80">Themes</span>
            </div>
            <div class="mt-3 font-display font-extrabold text-4xl">{{ $totalThemes }}</div>
        </div>
        <div class="rounded-3xl bg-gradient-to-br from-violet-500 to-fuchsia-600 p-5 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <i data-lucide="layers" class="w-6 h-6 opacity-80"></i>
                <span class="text-xs font-bold uppercase tracking-wider opacity-80">Questions</span>
            </div>
            <div class="mt-3 font-display font-extrabold text-4xl">{{ $totalQuestions }}</div>
        </div>
        <div class="rounded-3xl bg-gradient-to-br from-amber-500 to-orange-600 p-5 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <i data-lucide="check-circle-2" class="w-6 h-6 opacity-80"></i>
                <span class="text-xs font-bold uppercase tracking-wider opacity-80">Practiced</span>
            </div>
            <div class="mt-3 font-display font-extrabold text-4xl"><span id="practicedTotal">0</span></div>
        </div>
        <div class="rounded-3xl bg-gradient-to-br from-emerald-500 to-teal-600 p-5 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <i data-lucide="heart" class="w-6 h-6 opacity-80"></i>
                <span class="text-xs font-bold uppercase tracking-wider opacity-80">Favorites</span>
            </div>
            <div class="mt-3 font-display font-extrabold text-4xl"><span id="favoritesTotal">0</span></div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- By level -->
        <div class="lg:col-span-2 rounded-3xl bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
            <h2 class="font-display font-extrabold text-xl text-slate-800 dark:text-slate-100 mb-1">Questions by level</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-5">Total available per CEFR level across all themes.</p>

            <div class="space-y-4">
                @php
                    $max = max(array_map(fn($l) => $l['count'], $byLevel)) ?: 1;
                    $levelColors = ['A1' => 'from-emerald-400 to-green-500', 'A2' => 'from-teal-400 to-cyan-500', 'B1' => 'from-amber-400 to-orange-500', 'B2' => 'from-rose-400 to-pink-600'];
                @endphp
                @foreach ($byLevel as $l)
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1.5">
                            <span class="font-bold text-slate-700 dark:text-slate-200">{{ $l['code'] }} <span class="text-slate-400 dark:text-slate-500 font-medium">· {{ explode(' — ', $l['description'])[0] }}</span></span>
                            <span class="font-bold text-slate-600 dark:text-slate-300">{{ $l['count'] }}</span>
                        </div>
                        <div class="h-3 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                            <div class="h-full bg-gradient-to-r {{ $levelColors[$l['code']] }} rounded-full transition-all duration-700" style="width: {{ ($l['count'] / $max) * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Themes list -->
        <div class="rounded-3xl bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
            <h2 class="font-display font-extrabold text-xl text-slate-800 dark:text-slate-100 mb-1">All themes</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Tap to practice.</p>
            <div class="max-h-72 overflow-y-auto custom-scroll space-y-1 pr-1">
                @foreach ($themes as $theme)
                    <a href="{{ route('themes.show', $theme) }}" class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                        <span class="grid place-items-center w-9 h-9 rounded-xl bg-gradient-to-br {{ $theme->gradient }} text-lg shrink-0">{{ $theme->emoji }}</span>
                        <span class="flex-1 min-w-0">
                            <span class="block text-sm font-semibold text-slate-700 dark:text-slate-200 truncate">{{ $theme->name }}</span>
                            <span class="block text-xs text-slate-400 dark:text-slate-500">{{ $theme->total_questions }} questions</span>
                        </span>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300"></i>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Featured questions -->
    <div class="mt-6 rounded-3xl bg-gradient-to-br from-violet-500 via-fuchsia-500 to-rose-500 p-[2px] shadow-xl">
        <div class="rounded-[22px] bg-white dark:bg-slate-900 p-6 sm:p-8">
            <h2 class="font-display font-extrabold text-xl text-slate-800 dark:text-slate-100 mb-1 flex items-center gap-2">
                <i data-lucide="sparkles" class="w-5 h-5 text-fuchsia-500"></i> Featured prompts
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-5">Three random questions to spark a practice session.</p>

            <div class="grid sm:grid-cols-3 gap-4">
                @foreach ($featuredQuestions as $fq)
                    <a href="{{ route('game.play', [$fq->theme, strtolower($fq->level)]) }}" class="group rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 p-4 hover:shadow-md hover:-translate-y-0.5 transition-all">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-fuchsia-600 dark:text-fuchsia-400">{{ $fq->theme->emoji }} {{ $fq->theme->name }}</span>
                            <span class="text-xs font-bold text-slate-400">{{ $fq->level }}</span>
                        </div>
                        <p class="text-sm text-slate-700 dark:text-slate-200 leading-snug">{{ Illuminate\Support\Str::limit($fq->prompt, 100) }}</p>
                        <span class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-fuchsia-600 dark:text-fuchsia-400 group-hover:gap-2 transition-all">Practice <i data-lucide="arrow-right" class="w-3 h-3"></i></span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Local progress (themes practiced) -->
    <div class="mt-6 rounded-3xl bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
        <h2 class="font-display font-extrabold text-xl text-slate-800 dark:text-slate-100 mb-1">Practiced cards per deck</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">From your browser's session storage. Resets if you clear site data.</p>
        <div id="localProgress" class="space-y-2">
            <p class="text-sm text-slate-400 dark:text-slate-500">Loading…</p>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/dashboard.js') }}" defer></script>
@endpush
