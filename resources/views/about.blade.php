@extends('layouts.app')

@section('title', 'How to Play — SpeakUp!')

@section('content')
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">

    <div class="text-center mb-12">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/70 dark:bg-slate-900/70 border border-white dark:border-slate-700 text-sm font-semibold text-violet-600 dark:text-violet-400 shadow-sm">
            <i data-lucide="sparkles" class="w-4 h-4"></i> Quick guide
        </span>
        <h1 class="mt-4 font-display font-extrabold text-4xl sm:text-5xl">
            <span class="bg-gradient-to-r from-violet-600 to-fuchsia-600 dark:from-violet-400 dark:to-fuchsia-400 bg-clip-text text-transparent">How to play</span>
        </h1>
        <p class="mt-4 text-lg text-slate-600 dark:text-slate-300 max-w-2xl mx-auto">A simple way to practice speaking English — solo, in pairs, or with your whole class.</p>
    </div>

    <!-- Steps -->
    <div class="grid sm:grid-cols-2 gap-5 mb-12">
        @foreach ([
            ['1', 'Pick a theme', 'layout-grid', 'from-rose-400 to-pink-500', 'Choose a topic you like — travel, food, work, hobbies and more.'],
            ['2', 'Choose a level', 'layers', 'from-amber-400 to-orange-500', 'Select A1 (beginner) up to B2 (upper-intermediate) depending on your confidence.'],
            ['3', 'Draw a card', 'layers-2', 'from-emerald-400 to-teal-500', 'Read the speaking prompt aloud. Try to talk for the suggested time.'],
            ['4', 'Flip & reflect', 'rotate-cw', 'from-violet-400 to-purple-500', 'Tap the card to reveal a sample answer, a tip, and useful vocabulary.'],
        ] as $step)
            <div class="flex gap-4 rounded-3xl bg-white/80 dark:bg-slate-900/80 border border-white dark:border-slate-700 p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="grid place-items-center w-12 h-12 shrink-0 rounded-2xl bg-gradient-to-br {{ $step[3] }} text-white font-display font-extrabold text-xl shadow-lg">{{ $step[0] }}</div>
                <div>
                    <h3 class="font-display font-bold text-lg text-slate-800 dark:text-slate-100 flex items-center gap-2">
                        <i data-lucide="{{ $step[2] }}" class="w-4 h-4 text-slate-400 dark:text-slate-500"></i> {{ $step[1] }}
                    </h3>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 leading-relaxed">{{ $step[4] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <!-- CEFR levels explained -->
    <div class="rounded-3xl bg-white/80 dark:bg-slate-900/80 border border-white dark:border-slate-700 p-8 shadow-sm">
        <h2 class="font-display font-extrabold text-2xl text-slate-800 dark:text-slate-100 mb-2">The CEFR levels, explained</h2>
        <p class="text-slate-500 dark:text-slate-400 mb-6">Each theme has four difficulty levels based on the Common European Framework of Reference.</p>

        <div class="space-y-4">
            @foreach ($levels as $code => $info)
                @php
                    $styles = [
                        'A1' => 'from-emerald-400 to-green-500',
                        'A2' => 'from-teal-400 to-cyan-500',
                        'B1' => 'from-amber-400 to-orange-500',
                        'B2' => 'from-rose-400 to-pink-600',
                    ];
                @endphp
                <div class="flex items-start gap-4">
                    <span class="grid place-items-center w-14 h-14 shrink-0 rounded-2xl bg-gradient-to-br {{ $styles[$code] }} text-white font-display font-extrabold text-lg shadow-lg">{{ $code }}</span>
                    <div>
                        <h3 class="font-display font-bold text-lg text-slate-800 dark:text-slate-100">{{ $info['name'] }}</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">{{ $info['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Classroom tips -->
    <div class="mt-8 rounded-3xl bg-gradient-to-br from-violet-500 via-fuchsia-500 to-rose-500 p-8 text-white shadow-xl">
        <h2 class="font-display font-extrabold text-2xl mb-4 flex items-center gap-2"><i data-lucide="users" class="w-6 h-6"></i> Using it in class</h2>
        <ul class="space-y-2 text-white/90">
            <li class="flex gap-2"><i data-lucide="check-circle" class="w-5 h-5 shrink-0 mt-0.5"></i> <span>Pair students up — one draws a card, the other listens and asks a follow-up question.</span></li>
            <li class="flex gap-2"><i data-lucide="check-circle" class="w-5 h-5 shrink-0 mt-0.5"></i> <span>Use the built-in timer to challenge students to speak for the full suggested duration.</span></li>
            <li class="flex gap-2"><i data-lucide="check-circle" class="w-5 h-5 shrink-0 mt-0.5"></i> <span>Flip the card to reveal the sample answer as a model, then have students improve on it.</span></li>
            <li class="flex gap-2"><i data-lucide="check-circle" class="w-5 h-5 shrink-0 mt-0.5"></i> <span>Shuffle the deck for warm-ups, or work through it in order for structured practice.</span></li>
            <li class="flex gap-2"><i data-lucide="check-circle" class="w-5 h-5 shrink-0 mt-0.5"></i> <span>Use the Daily Challenge as a warm-up — every student gets the same prompt to discuss.</span></li>
            <li class="flex gap-2"><i data-lucide="check-circle" class="w-5 h-5 shrink-0 mt-0.5"></i> <span>Have learners record themselves and compare playback to the sample answer.</span></li>
        </ul>
    </div>

    <!-- Keyboard shortcuts -->
    <div class="mt-8 rounded-3xl bg-white/80 dark:bg-slate-900/80 border border-white dark:border-slate-700 p-8 shadow-sm">
        <h2 class="font-display font-extrabold text-2xl text-slate-800 dark:text-slate-100 mb-4 flex items-center gap-2"><i data-lucide="keyboard" class="w-6 h-6 text-emerald-500"></i> Keyboard shortcuts</h2>
        <div class="grid sm:grid-cols-2 gap-3">
            @foreach ([
                ['→', 'Next card'],
                ['←', 'Previous card'],
                ['Space / Enter', 'Flip the card'],
                ['S', 'Shuffle the deck'],
                ['F', 'Add to / remove from favorites'],
                ['R', 'Start / stop recording'],
            ] as $sc)
                <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-800">
                    <kbd class="grid place-items-center min-w-[2.5rem] h-9 px-2 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 font-mono font-bold text-sm text-slate-700 dark:text-slate-200 shadow-sm">{{ $sc[0] }}</kbd>
                    <span class="text-sm text-slate-600 dark:text-slate-300">{{ $sc[1] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-10 text-center">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-rose-500 via-fuchsia-500 to-violet-500 text-white font-semibold shadow-lg hover:-translate-y-0.5 transition-all">
            <i data-lucide="rocket" class="w-5 h-5"></i> Start practicing
        </a>
    </div>
</section>
@endsection
