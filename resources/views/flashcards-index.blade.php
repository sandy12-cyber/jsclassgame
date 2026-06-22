@extends('layouts.app')

@section('title', 'Printable Flashcards — SpeakUp!')

@section('content')
<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <div class="text-center mb-8">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/70 dark:bg-slate-900/70 border border-white dark:border-slate-700 text-sm font-semibold text-teal-600 dark:text-teal-400 shadow-sm">
            <i data-lucide="printer" class="w-4 h-4"></i> Take them offline
        </span>
        <h1 class="mt-4 font-display font-extrabold text-3xl sm:text-5xl bg-gradient-to-r from-teal-500 via-cyan-500 to-emerald-500 dark:from-teal-400 dark:via-cyan-400 dark:to-emerald-400 bg-clip-text text-transparent">Printable Flashcards</h1>
        <p class="mt-3 text-slate-500 dark:text-slate-400 max-w-2xl mx-auto">Generate a printable sheet of question cards for any theme + level. 6 cards per A4 page — cut along the lines and use them in class, no screens required.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach ($themes as $theme)
            <div class="group relative overflow-hidden rounded-3xl bg-gradient-to-br {{ $theme->gradient }} p-[2px] shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all">
                <div class="rounded-[22px] bg-white dark:bg-slate-900 p-5 flex flex-col">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="grid place-items-center w-12 h-12 rounded-2xl bg-gradient-to-br {{ $theme->gradient }} text-2xl shadow">{{ $theme->emoji }}</span>
                        <div>
                            <h3 class="font-display font-extrabold text-lg text-slate-800 dark:text-slate-100">{{ $theme->name }}</h3>
                            <p class="text-xs text-slate-400 dark:text-slate-500">{{ array_sum($theme->level_counts) }} questions</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach (['A1','A2','B1','B2'] as $lvl)
                            @php $cnt = $theme->level_counts[$lvl] ?? 0; @endphp
                            @if ($cnt > 0)
                                <a href="{{ route('flashcards.show', [$theme, strtolower($lvl)]) }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-gradient-to-r hover:from-teal-500 hover:to-cyan-500 hover:text-white transition-all">
                                    <i data-lucide="printer" class="w-3 h-3"></i> {{ $lvl }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Print tips -->
    <div class="mt-10 rounded-3xl bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
        <h2 class="font-display font-extrabold text-xl text-slate-800 dark:text-slate-100 mb-3 flex items-center gap-2"><i data-lucide="lightbulb" class="w-5 h-5 text-amber-500"></i> Printing tips</h2>
        <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-300">
            <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5"></i> Use <strong>A4 paper</strong> in portrait orientation for the best fit.</li>
            <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5"></i> In the print dialog, enable <strong>Background graphics</strong> so the coloured headers print.</li>
            <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5"></i> Set margins to <strong>None</strong> or <strong>Minimum</strong> to fit 6 cards per page.</li>
            <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5"></i> Cut along the dashed lines, then fold or laminate for durable cards.</li>
        </ul>
    </div>
</section>
@endsection
