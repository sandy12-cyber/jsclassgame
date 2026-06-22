@extends('layouts.app')

@section('title', 'Pair Work — SpeakUp!')

@section('content')
<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <div class="text-center mb-8">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/70 dark:bg-slate-900/70 border border-white dark:border-slate-700 text-sm font-semibold text-indigo-600 dark:text-indigo-400 shadow-sm">
            <i data-lucide="users" class="w-4 h-4"></i> For two learners
        </span>
        <h1 class="mt-4 font-display font-extrabold text-3xl sm:text-5xl bg-gradient-to-r from-indigo-500 via-violet-500 to-fuchsia-500 dark:from-indigo-400 dark:via-violet-400 dark:to-fuchsia-400 bg-clip-text text-transparent">Pair Work Mode</h1>
        <p class="mt-3 text-slate-500 dark:text-slate-400 max-w-2xl mx-auto">Take turns: one of you answers the prompt, the other asks a follow-up question. Then swap. Perfect for classrooms and study buddies.</p>
    </div>

    <!-- How it works -->
    <div class="max-w-3xl mx-auto mb-10 rounded-3xl bg-gradient-to-br from-indigo-500 via-violet-500 to-fuchsia-500 p-[2px] shadow-xl">
        <div class="rounded-[22px] bg-white dark:bg-slate-900 p-6 sm:p-8">
            <h2 class="font-display font-extrabold text-xl text-slate-800 dark:text-slate-100 mb-4 flex items-center gap-2"><i data-lucide="info" class="w-5 h-5 text-indigo-500"></i> How it works</h2>
            <div class="grid sm:grid-cols-2 gap-4">
                <div class="flex gap-3">
                    <span class="grid place-items-center w-9 h-9 rounded-xl bg-indigo-100 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 font-bold shrink-0">A</span>
                    <p class="text-sm text-slate-600 dark:text-slate-300"><strong>Player A</strong> answers the prompt. Card 1, 3, 5… = Player A's turn to speak.</p>
                </div>
                <div class="flex gap-3">
                    <span class="grid place-items-center w-9 h-9 rounded-xl bg-fuchsia-100 dark:bg-fuchsia-950/50 text-fuchsia-600 dark:text-fuchsia-400 font-bold shrink-0">B</span>
                    <p class="text-sm text-slate-600 dark:text-slate-300"><strong>Player B</strong> asks a follow-up question. Card 2, 4, 6… = Player B's turn to speak.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Theme picker -->
    <h2 class="font-display font-extrabold text-2xl text-slate-800 dark:text-slate-100 mb-4">Pick a deck to play together</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach ($themes as $theme)
            <div class="group relative overflow-hidden rounded-3xl bg-gradient-to-br {{ $theme->gradient }} p-[2px] shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all">
                <div class="rounded-[22px] bg-white dark:bg-slate-900 p-5 flex flex-col">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="grid place-items-center w-12 h-12 rounded-2xl bg-gradient-to-br {{ $theme->gradient }} text-2xl shadow">{{ $theme->emoji }}</span>
                        <div>
                            <h3 class="font-display font-extrabold text-lg text-slate-800 dark:text-slate-100">{{ $theme->name }}</h3>
                            <p class="text-xs text-slate-400 dark:text-slate-500">{{ $theme->total_questions }} questions</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach (['A1','A2','B1','B2'] as $lvl)
                            @php $cnt = $theme->level_counts[$lvl] ?? 0; @endphp
                            @if ($cnt > 0)
                                <a href="{{ route('pairwork.play', [$theme, strtolower($lvl)]) }}" class="px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-gradient-to-r hover:from-indigo-500 hover:to-fuchsia-500 hover:text-white transition-all">{{ $lvl }} · {{ $cnt }}</a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
