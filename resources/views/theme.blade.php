@extends('layouts.app')

@section('title', $theme->name . ' — SpeakUp!')

@section('content')
<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-rose-600 transition-colors">Themes</a>
        <i data-lucide="chevron-right" class="w-4 h-4"></i>
        <span class="font-semibold text-slate-700">{{ $theme->name }}</span>
    </nav>

    <!-- Theme hero -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br {{ $theme->gradient }} p-8 sm:p-12 shadow-xl">
        <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full bg-white/20 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-10 w-72 h-72 rounded-full bg-black/10 blur-3xl"></div>

        <div class="relative flex flex-col sm:flex-row items-start sm:items-center gap-6">
            <div class="grid place-items-center w-24 h-24 rounded-3xl bg-white/95 text-5xl shadow-2xl animate-float">{{ $theme->emoji }}</div>
            <div class="text-white">
                <h1 class="font-display font-extrabold text-4xl sm:text-5xl drop-shadow-sm">{{ $theme->name }}</h1>
                <p class="mt-3 text-white/90 max-w-2xl text-lg leading-relaxed">{{ $theme->description }}</p>
            </div>
        </div>
    </div>

    <!-- Choose level -->
    <div class="mt-10">
        <div class="flex items-end justify-between mb-6">
            <div>
                <h2 class="font-display font-extrabold text-2xl sm:text-3xl text-slate-800">Pick your level</h2>
                <p class="text-slate-500 mt-1">From beginner (A1) to upper-intermediate (B2). Higher levels = more complex prompts.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach ($levels as $level)
                @php
                    $levelStyles = [
                        'A1' => ['gradient' => 'from-emerald-400 to-green-500', 'text' => 'text-emerald-700', 'bg' => 'bg-emerald-50', 'border' => 'border-emerald-200', 'emoji' => '🌱'],
                        'A2' => ['gradient' => 'from-teal-400 to-cyan-500', 'text' => 'text-teal-700', 'bg' => 'bg-teal-50', 'border' => 'border-teal-200', 'emoji' => '🌿'],
                        'B1' => ['gradient' => 'from-amber-400 to-orange-500', 'text' => 'text-amber-700', 'bg' => 'bg-amber-50', 'border' => 'border-amber-200', 'emoji' => '⚡'],
                        'B2' => ['gradient' => 'from-rose-400 to-pink-600', 'text' => 'text-rose-700', 'bg' => 'bg-rose-50', 'border' => 'border-rose-200', 'emoji' => '🔥'],
                    ];
                    $s = $levelStyles[$level['code']];
                @endphp

                <div class="group relative overflow-hidden rounded-3xl bg-white border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 {{ $level['count'] > 0 ? '' : 'opacity-60' }}">
                    <div class="flex">
                        <!-- left color band -->
                        <div class="w-2 bg-gradient-to-b {{ $s['gradient'] }}"></div>

                        <div class="flex-1 p-6 sm:p-7">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="grid place-items-center w-14 h-14 rounded-2xl bg-gradient-to-br {{ $s['gradient'] }} text-2xl shadow-lg group-hover:scale-110 transition-transform">{{ $s['emoji'] }}</span>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-display font-extrabold text-2xl {{ $s['text'] }}">{{ $level['code'] }}</span>
                                            <span class="text-sm font-semibold text-slate-400">· {{ $level['name'] }}</span>
                                        </div>
                                        <p class="text-xs text-slate-400 mt-0.5">~{{ $level['time'] }}s per card</p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $s['bg'] }} {{ $s['text'] }}">{{ $level['count'] }} cards</span>
                            </div>

                            <p class="mt-4 text-sm text-slate-600 leading-relaxed">{{ $level['description'] }}</p>

                            @if (!empty($sampleQuestions[$level['code']]))
                                <div class="mt-4 rounded-xl {{ $s['bg'] }} border {{ $s['border'] }} p-3">
                                    <p class="text-xs font-bold uppercase tracking-wide {{ $s['text'] }} mb-1">Sample prompt</p>
                                    <p class="text-sm text-slate-700 italic">"{{ \Illuminate\Support\Str::limit($sampleQuestions[$level['code']]->prompt, 110) }}"</p>
                                </div>
                            @endif

                            <div class="mt-5">
                                @if ($level['count'] > 0)
                                    <a href="{{ route('game.play', [$theme, strtolower($level['code'])]) }}"
                                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r {{ $s['gradient'] }} text-white font-semibold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
                                        <i data-lucide="play" class="w-4 h-4"></i>
                                        Play {{ $level['code'] }} deck
                                    </a>
                                @else
                                    <span class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-100 text-slate-400 font-semibold cursor-not-allowed">
                                        <i data-lucide="lock" class="w-4 h-4"></i>
                                        Coming soon
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Back link -->
    <div class="mt-10">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-rose-600 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> All themes
        </a>
    </div>
</section>
@endsection
