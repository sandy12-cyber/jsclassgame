@extends('layouts.app')

@section('title', 'Welcome — SpeakUp!')

@section('content')
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <!-- Hero -->
    <div class="text-center mb-12">
        <div class="grid place-items-center w-24 h-24 rounded-3xl bg-gradient-to-br from-rose-500 via-fuchsia-500 to-violet-500 text-5xl mx-auto mb-6 shadow-2xl animate-float">🗣️</div>
        <h1 class="font-display font-extrabold text-4xl sm:text-5xl">
            <span class="bg-gradient-to-r from-rose-600 via-fuchsia-600 to-violet-600 dark:from-rose-400 dark:via-fuchsia-400 dark:to-violet-400 bg-clip-text text-transparent">Welcome to SpeakUp!</span>
        </h1>
        <p class="mt-4 text-lg text-slate-600 dark:text-slate-300 max-w-2xl mx-auto">A colorful card game to practise English speaking. Let's take a quick tour — it'll take less than a minute.</p>
    </div>

    <!-- Tour steps -->
    <div class="space-y-5">
        @foreach ([
            ['1', 'Pick a theme', 'layout-grid', 'from-rose-400 to-pink-500', 'Start on the home page and choose from 12 themes — travel, food, work, dreams and more.'],
            ['2', 'Choose your level', 'layers', 'from-amber-400 to-orange-500', 'Each theme has four CEFR levels: A1 (beginner) to B2 (upper-intermediate). Pick the one that feels right.'],
            ['3', 'Draw a card & speak', 'mic', 'from-emerald-400 to-teal-500', 'Read the prompt aloud and answer it. Use the timer to challenge yourself. Record yourself to listen back.'],
            ['4', 'Flip & learn', 'rotate-cw', 'from-violet-400 to-purple-500', 'Tap the card to reveal a sample answer, a tip, and useful vocabulary. Tap any vocab chip to hear it.'],
            ['5', 'Track your progress', 'bar-chart-3', 'from-cyan-400 to-blue-500', 'Mark cards as practiced, star your favourites, and watch your stats grow on the dashboard. Earn achievements!'],
        ] as $step)
            <div class="flex gap-4 rounded-3xl bg-white/80 dark:bg-slate-900/80 border border-white dark:border-slate-700 p-5 sm:p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="grid place-items-center w-12 h-12 shrink-0 rounded-2xl bg-gradient-to-br {{ $step[3] }} text-white font-display font-extrabold text-xl shadow-lg">{{ $step[0] }}</div>
                <div class="flex-1">
                    <h3 class="font-display font-bold text-lg text-slate-800 dark:text-slate-100 flex items-center gap-2">
                        <i data-lucide="{{ $step[2] }}" class="w-4 h-4 text-slate-400 dark:text-slate-500"></i> {{ $step[1] }}
                    </h3>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 leading-relaxed">{{ $step[4] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Quick links -->
    <div class="mt-10 grid sm:grid-cols-3 gap-4">
        <a href="{{ route('home') }}" class="group rounded-2xl bg-gradient-to-br from-rose-500 to-pink-600 p-5 text-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all">
            <i data-lucide="layout-grid" class="w-6 h-6 mb-2"></i>
            <h3 class="font-display font-bold text-lg">Browse themes</h3>
            <p class="text-sm text-white/80">12 topics, 480 cards</p>
        </a>
        <a href="{{ route('challenge.daily') }}" class="group rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 p-5 text-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all">
            <i data-lucide="gift" class="w-6 h-6 mb-2"></i>
            <h3 class="font-display font-bold text-lg">Daily Challenge</h3>
            <p class="text-sm text-white/80">One card, same for everyone</p>
        </a>
        <a href="{{ route('dashboard') }}" class="group rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 p-5 text-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all">
            <i data-lucide="bar-chart-3" class="w-6 h-6 mb-2"></i>
            <h3 class="font-display font-bold text-lg">Your stats</h3>
            <p class="text-sm text-white/80">Track progress & badges</p>
        </a>
    </div>

    <!-- Begin button -->
    <div class="mt-10 text-center">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-2xl bg-gradient-to-r from-rose-500 via-fuchsia-500 to-violet-500 text-white font-semibold shadow-xl hover:shadow-2xl hover:-translate-y-0.5 transition-all">
            <i data-lucide="rocket" class="w-5 h-5"></i> Let's start!
        </a>
        <p class="mt-3 text-xs text-slate-400 dark:text-slate-500">{{ $totalQuestions }} questions across {{ $totalThemes }} themes · A1–B2</p>
    </div>
</section>
@endsection

@push('scripts')
<script>
// Mark the welcome tour as seen so the home banner doesn't reappear
try { localStorage.setItem('speakup-welcomed', '1'); } catch (e) {}
</script>
@endpush
