@extends('layouts.app')

@section('title', 'Rubric History — SpeakUp!')

@section('content')
<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <div class="text-center mb-8">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/70 dark:bg-slate-900/70 border border-white dark:border-slate-700 text-sm font-semibold text-violet-600 dark:text-violet-400 shadow-sm">
            <i data-lucide="line-chart" class="w-4 h-4"></i> Lesson self-assessment
        </span>
        <h1 class="mt-4 font-display font-extrabold text-3xl sm:text-5xl bg-gradient-to-r from-violet-500 via-fuchsia-500 to-rose-500 dark:from-violet-400 dark:via-fuchsia-400 dark:to-rose-400 bg-clip-text text-transparent">Rubric History</h1>
        <p class="mt-3 text-slate-500 dark:text-slate-400 max-w-2xl mx-auto">Track your speaking-rubric scores over time. Every score you give yourself in Lesson Mode is saved on this device.</p>
    </div>

    <!-- Summary stat cards (hydrated by JS) -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        @foreach ($criteria as $c)
            <div class="rounded-2xl bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700 p-4 text-center shadow-sm">
                <div class="font-display font-extrabold text-3xl bg-gradient-to-r {{ $c['color'] }} bg-clip-text text-transparent" id="avg-{{ $c['key'] }}">—</div>
                <div class="text-xs uppercase tracking-wide text-slate-400 dark:text-slate-500 mt-1">{{ $c['label'] }}</div>
            </div>
        @endforeach
    </div>

    <!-- Overall average + count -->
    <div class="rounded-3xl bg-gradient-to-br from-violet-500 via-fuchsia-500 to-rose-500 p-[2px] shadow-xl mb-8">
        <div class="rounded-[22px] bg-white dark:bg-slate-900 p-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="grid place-items-center w-16 h-16 rounded-2xl bg-gradient-to-br from-violet-500 to-fuchsia-600 text-white shadow-lg">
                    <i data-lucide="award" class="w-8 h-8"></i>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-slate-400 dark:text-slate-500">Overall average</p>
                    <p class="font-display font-extrabold text-3xl text-slate-800 dark:text-slate-100"><span id="overallAvg">—</span> <span class="text-lg text-slate-400">/ 4.0</span></p>
                </div>
            </div>
            <div class="text-center sm:text-right">
                <p class="text-xs uppercase tracking-wide text-slate-400 dark:text-slate-500">Cards assessed</p>
                <p class="font-display font-extrabold text-3xl text-slate-800 dark:text-slate-100" id="totalAssessed">0</p>
            </div>
        </div>
    </div>

    <!-- Empty state -->
    <div id="emptyState" class="hidden text-center py-16 rounded-3xl bg-white/60 dark:bg-slate-900/60 border border-dashed border-slate-300 dark:border-slate-700">
        <div class="grid place-items-center w-20 h-20 rounded-3xl bg-slate-100 dark:bg-slate-800 text-4xl mx-auto mb-4 animate-float">📊</div>
        <h3 class="font-display font-bold text-xl text-slate-700 dark:text-slate-200">No scores yet</h3>
        <p class="text-slate-500 dark:text-slate-400 mt-1 max-w-md mx-auto">Practise in <strong>Lesson Mode</strong> and rate yourself on the rubric — your scores will appear here.</p>
        <a href="{{ route('home') }}" class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-violet-500 to-fuchsia-500 text-white font-semibold shadow-md hover:-translate-y-0.5 transition-all">
            <i data-lucide="graduation-cap" class="w-4 h-4"></i> Start a lesson
        </a>
    </div>

    <!-- Per-criterion bars + recent scores table -->
    <div id="contentArea" class="hidden grid lg:grid-cols-2 gap-6">
        <!-- Per-criterion breakdown -->
        <div class="rounded-3xl bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
            <h2 class="font-display font-extrabold text-xl text-slate-800 dark:text-slate-100 mb-4 flex items-center gap-2"><i data-lucide="bar-chart-3" class="w-5 h-5 text-violet-500"></i> Average by criterion</h2>
            <div class="space-y-4" id="criterionBars"></div>
        </div>

        <!-- Recent scores -->
        <div class="rounded-3xl bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
            <h2 class="font-display font-extrabold text-xl text-slate-800 dark:text-slate-100 mb-4 flex items-center gap-2"><i data-lucide="history" class="w-5 h-5 text-fuchsia-500"></i> Recent cards</h2>
            <div id="recentList" class="space-y-2 max-h-96 overflow-y-auto custom-scroll pr-1"></div>
        </div>
    </div>

    <!-- Clear button -->
    <div id="clearArea" class="hidden mt-8 text-center">
        <button id="clearBtn" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 text-sm font-semibold hover:text-rose-600 hover:border-rose-200 transition-colors">
            <i data-lucide="trash-2" class="w-4 h-4"></i> Clear all scores
        </button>
    </div>
</section>
@endsection

@push('scripts')
<script>
    window.SpeakUpRubricHistory = {
        resolveUrl: "{{ route('api.favorites.resolve') }}",
        csrfToken: "{{ csrf_token() }}",
        criteria: @json($criteria),
    };
</script>
<script src="{{ asset('js/rubric-history.js') }}" defer></script>
@endpush
