@extends('layouts.app')

@section('title', 'Search — SpeakUp!')

@section('content')
<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <div class="text-center mb-8">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/70 dark:bg-slate-900/70 border border-white dark:border-slate-700 text-sm font-semibold text-violet-600 dark:text-violet-400 shadow-sm">
            <i data-lucide="search" class="w-4 h-4"></i> Find a prompt
        </span>
        <h1 class="mt-4 font-display font-extrabold text-3xl sm:text-5xl bg-gradient-to-r from-violet-600 via-fuchsia-600 to-rose-600 dark:from-violet-400 dark:via-fuchsia-400 dark:to-rose-400 bg-clip-text text-transparent">Search questions</h1>
        <p class="mt-3 text-slate-500 dark:text-slate-400">Filter by keyword, theme, or CEFR level across the whole bank.</p>
    </div>

    <!-- Filter form -->
    <form method="GET" action="{{ route('search') }}" class="rounded-3xl bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700 p-5 sm:p-6 shadow-sm mb-8">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Keyword -->
            <div class="lg:col-span-2">
                <label class="block text-xs font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400 mb-1.5">Keyword</label>
                <div class="relative">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="q" value="{{ $filters['q'] }}" placeholder="e.g. favourite, travel, family…"
                           class="w-full pl-9 pr-3 py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 placeholder-slate-400 focus:ring-2 focus:ring-violet-400 focus:border-violet-400 outline-none">
                </div>
            </div>

            <!-- Theme -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400 mb-1.5">Theme</label>
                <select name="theme" class="w-full px-3 py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-violet-400 focus:border-violet-400 outline-none">
                    <option value="">All themes</option>
                    @foreach ($themes as $t)
                        <option value="{{ $t->slug }}" {{ $filters['theme'] === $t->slug ? 'selected' : '' }}>{{ $t->emoji }} {{ $t->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Levels -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400 mb-1.5">Levels</label>
                <div class="flex flex-wrap gap-1.5">
                    @foreach (['A1' => 'emerald', 'A2' => 'teal', 'B1' => 'amber', 'B2' => 'rose'] as $lvl => $clr)
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="levels[]" value="{{ $lvl }}" {{ in_array($lvl, $filters['levels']) ? 'checked' : '' }} class="peer sr-only">
                            <span class="px-3 py-1.5 rounded-lg text-xs font-bold border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-800 peer-checked:bg-{{ $clr }}-500 peer-checked:text-white peer-checked:border-{{ $clr }}-500 transition-all">{{ $lvl }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-5 flex flex-wrap items-center gap-2">
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-violet-500 via-fuchsia-500 to-rose-500 text-white font-semibold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
                <i data-lucide="filter" class="w-4 h-4"></i> Apply filters
            </button>
            <a href="{{ route('search') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-semibold shadow-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
                <i data-lucide="x" class="w-4 h-4"></i> Clear
            </a>
            <span class="ml-auto text-sm text-slate-400 dark:text-slate-500">{{ $questions->total() }} result(s)</span>
        </div>
    </form>

    <!-- Results -->
    @if ($questions->isEmpty())
        <div class="text-center py-16">
            <div class="grid place-items-center w-20 h-20 rounded-3xl bg-slate-100 dark:bg-slate-800 text-4xl mx-auto mb-4">🔍</div>
            <h3 class="font-display font-bold text-xl text-slate-700 dark:text-slate-200">No questions match</h3>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Try a different keyword or clear some filters.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
            @php
                $levelStyles = [
                    'A1' => ['gradient' => 'from-emerald-400 to-green-500', 'text' => 'text-emerald-600 dark:text-emerald-400', 'soft' => 'bg-emerald-50 dark:bg-emerald-950/40'],
                    'A2' => ['gradient' => 'from-teal-400 to-cyan-500', 'text' => 'text-teal-600 dark:text-teal-400', 'soft' => 'bg-teal-50 dark:bg-teal-950/40'],
                    'B1' => ['gradient' => 'from-amber-400 to-orange-500', 'text' => 'text-amber-600 dark:text-amber-400', 'soft' => 'bg-amber-50 dark:bg-amber-950/40'],
                    'B2' => ['gradient' => 'from-rose-400 to-pink-600', 'text' => 'text-rose-600 dark:text-rose-400', 'soft' => 'bg-rose-50 dark:bg-rose-950/40'],
                ];
            @endphp
            @foreach ($questions as $q)
                @php $ls = $levelStyles[$q->level]; @endphp
                <a href="{{ route('game.play', [$q->theme, strtolower($q->level)]) }}#card-{{ $q->id }}"
                   class="group relative overflow-hidden rounded-2xl bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 p-5 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all flex flex-col">
                    <div class="flex items-center justify-between mb-3">
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold {{ $ls['text'] }}">
                            <span class="px-2 py-0.5 rounded bg-gradient-to-r {{ $ls['gradient'] }} text-white">{{ $q->level }}</span>
                            <span class="text-slate-400 dark:text-slate-500">{{ $q->theme->emoji }} {{ $q->theme->name }}</span>
                        </span>
                        <i data-lucide="arrow-up-right" class="w-4 h-4 text-slate-300 group-hover:text-rose-500 transition-colors"></i>
                    </div>
                    <p class="text-slate-700 dark:text-slate-200 font-medium leading-snug flex-1">{{ Illuminate\Support\Str::limit($q->prompt, 140) }}</p>
                    @if ($q->vocabulary)
                        <div class="mt-3 flex flex-wrap gap-1">
                            @foreach (array_slice($q->vocabulary, 0, 3) as $w)
                                <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded {{ $ls['soft'] }} {{ $ls['text'] }}">{{ $w }}</span>
                            @endforeach
                        </div>
                    @endif
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $questions->links() }}
        </div>
    @endif
</section>
@endsection
