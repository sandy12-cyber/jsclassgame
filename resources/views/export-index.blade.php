@extends('layouts.app')

@section('title', 'Export — SpeakUp!')

@section('content')
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <div class="text-center mb-8">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/70 dark:bg-slate-900/70 border border-white dark:border-slate-700 text-sm font-semibold text-emerald-600 dark:text-emerald-400 shadow-sm">
            <i data-lucide="download" class="w-4 h-4"></i> For teachers
        </span>
        <h1 class="mt-4 font-display font-extrabold text-3xl sm:text-5xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 dark:from-emerald-400 dark:via-teal-400 dark:to-cyan-400 bg-clip-text text-transparent">Export Question Bank</h1>
        <p class="mt-3 text-slate-500 dark:text-slate-400 max-w-2xl mx-auto">Download the full question bank as a CSV file. Filter by theme or level to export a subset. Open it in Excel, Google Sheets, or print it for offline lesson planning.</p>
    </div>

    <!-- Full export -->
    <div class="rounded-3xl bg-gradient-to-br from-emerald-500 to-teal-600 p-[2px] shadow-xl mb-8">
        <div class="rounded-[22px] bg-white dark:bg-slate-900 p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="grid place-items-center w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-lg">
                    <i data-lucide="file-spreadsheet" class="w-8 h-8"></i>
                </div>
                <div>
                    <h2 class="font-display font-extrabold text-xl text-slate-800 dark:text-slate-100">Full question bank</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $totalQuestions }} questions across all themes and levels.</p>
                </div>
            </div>
            <a href="{{ route('export.questions.csv') }}" class="shrink-0 inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold shadow-md hover:-translate-y-0.5 transition-all">
                <i data-lucide="download" class="w-4 h-4"></i> Download CSV
            </a>
        </div>
    </div>

    <!-- Filtered exports -->
    <h2 class="font-display font-extrabold text-xl text-slate-800 dark:text-slate-100 mb-4">Export by theme</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
        @foreach ($themes as $theme)
            <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 p-4 shadow-sm">
                <div class="flex items-center gap-2 mb-3">
                    <span class="grid place-items-center w-10 h-10 rounded-xl bg-gradient-to-br {{ $theme->gradient }} text-xl">{{ $theme->emoji }}</span>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-slate-700 dark:text-slate-200 text-sm truncate">{{ $theme->name }}</p>
                        <p class="text-[10px] text-slate-400">All levels</p>
                    </div>
                </div>
                <a href="{{ route('export.questions.csv', ['theme' => $theme->slug]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-semibold hover:bg-emerald-500 hover:text-white transition-all">
                    <i data-lucide="download" class="w-3.5 h-3.5"></i> CSV
                </a>
            </div>
        @endforeach
    </div>

    <!-- Export by level -->
    <h2 class="font-display font-extrabold text-xl text-slate-800 dark:text-slate-100 mb-4">Export by level</h2>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        @php
            $levelColors = ['A1' => 'from-emerald-400 to-green-500', 'A2' => 'from-teal-400 to-cyan-500', 'B1' => 'from-amber-400 to-orange-500', 'B2' => 'from-rose-400 to-pink-600'];
        @endphp
        @foreach (['A1','A2','B1','B2'] as $lvl)
            <a href="{{ route('export.questions.csv', ['level' => $lvl]) }}" class="group rounded-2xl bg-gradient-to-br {{ $levelColors[$lvl] }} p-[2px] shadow-md hover:shadow-lg hover:-translate-y-1 transition-all">
                <div class="rounded-[14px] bg-white dark:bg-slate-900 p-4 text-center">
                    <div class="font-display font-extrabold text-2xl bg-gradient-to-r {{ $levelColors[$lvl] }} bg-clip-text text-transparent">{{ $lvl }}</div>
                    <div class="text-[10px] text-slate-400 mt-1">All themes</div>
                    <div class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-slate-600 dark:text-slate-300 group-hover:text-emerald-600 dark:group-hover:text-emerald-400">
                        <i data-lucide="download" class="w-3 h-3"></i> CSV
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <!-- CSV format info -->
    <div class="rounded-3xl bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
        <h2 class="font-display font-extrabold text-lg text-slate-800 dark:text-slate-100 mb-3 flex items-center gap-2"><i data-lucide="info" class="w-5 h-5 text-emerald-500"></i> CSV format</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">The CSV file has these columns (UTF-8 with BOM, so Excel opens it correctly):</p>
        <div class="rounded-xl bg-slate-50 dark:bg-slate-800 p-4 font-mono text-xs text-slate-600 dark:text-slate-300 overflow-x-auto">
            theme, level, prompt, sample_answer, tips, vocabulary
        </div>
        <ul class="mt-4 space-y-1.5 text-sm text-slate-600 dark:text-slate-300">
            <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5"></i> <span><strong>theme</strong> — the theme slug (e.g. <code>daily-life</code>)</span></li>
            <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5"></i> <span><strong>level</strong> — A1, A2, B1, or B2</span></li>
            <li class="flex gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5"></i> <span><strong>vocabulary</strong> — semicolon-separated list of key words</span></li>
        </ul>
    </div>
</section>
@endsection
