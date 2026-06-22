@extends('layouts.app')

@section('title', 'Achievements — SpeakUp!')

@section('content')
<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <div class="text-center mb-8">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/70 dark:bg-slate-900/70 border border-white dark:border-slate-700 text-sm font-semibold text-amber-600 dark:text-amber-400 shadow-sm">
            <i data-lucide="trophy" class="w-4 h-4"></i> Earn badges as you practise
        </span>
        <h1 class="mt-4 font-display font-extrabold text-3xl sm:text-5xl bg-gradient-to-r from-amber-500 via-orange-500 to-rose-500 dark:from-amber-400 dark:via-orange-400 dark:to-rose-400 bg-clip-text text-transparent">Achievements</h1>
        <p class="mt-3 text-slate-500 dark:text-slate-400">Unlock badges by practising cards, saving favourites, building streaks, and exploring themes. All progress is stored on this device.</p>
    </div>

    <!-- Streak summary -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        <div class="rounded-2xl bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700 p-4 text-center shadow-sm">
            <div class="font-display font-extrabold text-3xl text-rose-500" id="statPracticed">0</div>
            <div class="text-xs uppercase tracking-wide text-slate-400 dark:text-slate-500 mt-1">Practiced</div>
        </div>
        <div class="rounded-2xl bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700 p-4 text-center shadow-sm">
            <div class="font-display font-extrabold text-3xl text-amber-500" id="statStreak">0</div>
            <div class="text-xs uppercase tracking-wide text-slate-400 dark:text-slate-500 mt-1">Active days</div>
        </div>
        <div class="rounded-2xl bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700 p-4 text-center shadow-sm">
            <div class="font-display font-extrabold text-3xl text-violet-500" id="statThemes">0</div>
            <div class="text-xs uppercase tracking-wide text-slate-400 dark:text-slate-500 mt-1">Themes</div>
        </div>
        <div class="rounded-2xl bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700 p-4 text-center shadow-sm">
            <div class="font-display font-extrabold text-3xl text-emerald-500" id="statUnlocked">0</div>
            <div class="text-xs uppercase tracking-wide text-slate-400 dark:text-slate-500 mt-1">Unlocked</div>
        </div>
    </div>

    <!-- Achievement grid -->
    <div id="achievementsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach ($achievements as $a)
            <div class="achievement-card group relative overflow-hidden rounded-3xl p-[2px] shadow-md" data-id="{{ $a['id'] }}" data-goal="{{ $a['goal'] }}" data-metric="{{ $a['metric'] }}">
                <div class="achievement-gradient absolute inset-0 bg-gradient-to-br {{ $a['color'] }} opacity-30 transition-opacity"></div>
                <div class="relative rounded-[22px] bg-white dark:bg-slate-900 p-5 h-full flex flex-col">
                    <div class="flex items-start justify-between mb-3">
                        <div class="grid place-items-center w-14 h-14 rounded-2xl bg-gradient-to-br {{ $a['color'] }} text-white shadow-lg">
                            <i data-lucide="{{ $a['icon'] }}" class="w-7 h-7"></i>
                        </div>
                        <span class="achievement-status px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">Locked</span>
                    </div>
                    <h3 class="font-display font-bold text-lg text-slate-800 dark:text-slate-100">{{ $a['title'] }}</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 flex-1">{{ $a['desc'] }}</p>
                    <!-- Progress bar -->
                    <div class="mt-4">
                        <div class="flex items-center justify-between text-xs mb-1">
                            <span class="text-slate-400 dark:text-slate-500">Progress</span>
                            <span class="achievement-progress font-bold text-slate-600 dark:text-slate-300">0 / {{ $a['goal'] }}</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                            <div class="achievement-bar h-full bg-gradient-to-r {{ $a['color'] }} rounded-full transition-all duration-500" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Call to action -->
    <div class="mt-10 text-center">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-rose-500 via-fuchsia-500 to-violet-500 text-white font-semibold shadow-lg hover:-translate-y-0.5 transition-all">
            <i data-lucide="rocket" class="w-5 h-5"></i> Keep practising
        </a>
    </div>
</section>
@endsection

@push('scripts')
<script>
    window.SpeakUpAchievements = {
        definitions: @json($achievements),
    };
</script>
<script src="{{ asset('js/achievements.js') }}" defer></script>
@endpush
