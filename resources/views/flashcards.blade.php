@extends('layouts.app')

@section('title', $theme->name . ' · ' . $level . ' — Flashcards')

@php
    $levelStyles = [
        'A1' => ['gradient' => 'from-emerald-400 to-green-500', 'solid' => '#10b981', 'soft' => '#ecfdf5'],
        'A2' => ['gradient' => 'from-teal-400 to-cyan-500', 'solid' => '#14b8a6', 'soft' => '#f0fdfa'],
        'B1' => ['gradient' => 'from-amber-400 to-orange-500', 'solid' => '#f59e0b', 'soft' => '#fffbeb'],
        'B2' => ['gradient' => 'from-rose-400 to-pink-600', 'solid' => '#f43f5e', 'soft' => '#fff1f2'],
    ];
    $s = $levelStyles[$level];
@endphp

@section('content')
<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

    <!-- Screen-only header -->
    <div class="screen-only mb-6 flex flex-wrap items-center justify-between gap-3">
        <nav class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
            <a href="{{ route('flashcards.index') }}" class="hover:text-teal-600 dark:hover:text-teal-400 transition-colors">Flashcards</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $theme->name }} · {{ $level }}</span>
        </nav>
        <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-teal-500 to-cyan-500 text-white font-semibold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all">
            <i data-lucide="printer" class="w-4 h-4"></i> Print this sheet
        </button>
    </div>

    <div class="screen-only rounded-2xl bg-teal-50 dark:bg-teal-950/40 border border-teal-200 dark:border-teal-800 p-4 mb-6">
        <p class="text-sm text-teal-700 dark:text-teal-300 flex items-center gap-2"><i data-lucide="info" class="w-4 h-4"></i> {{ $questions->count() }} cards · 6 per A4 page. Use your browser's print dialog (Ctrl/Cmd + P) and enable "Background graphics".</p>
    </div>

    <!-- Flashcard grid (prints 6 per page via CSS) -->
    <div class="flashcard-grid">
        @foreach ($questions as $q)
            <div class="flashcard">
                <div class="flashcard-header" style="background: linear-gradient(135deg, {{ $s['solid'] }}, {{ $s['solid'] }}cc);">
                    <span class="flashcard-level">{{ $q->level }}</span>
                    <span class="flashcard-theme">{{ $theme->emoji }} {{ $theme->name }}</span>
                    <span class="flashcard-num">#{{ $loop->iteration }}</span>
                </div>
                <div class="flashcard-body">
                    <p class="flashcard-prompt">{{ $q->prompt }}</p>
                    @if (!empty($q->vocabulary))
                        <p class="flashcard-vocab"><strong>Key words:</strong> {{ implode(', ', array_slice($q->vocabulary, 0, 4)) }}</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection

@push('styles')
<style>
/* Flashcard print styles */
.screen-only { }
.flashcard-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
.flashcard {
    border: 2px dashed #cbd5e1;
    border-radius: 14px;
    overflow: hidden;
    break-inside: avoid;
    background: #fff;
}
.flashcard-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 12px;
    color: #fff;
    font-weight: 700;
    font-size: 11px;
}
.flashcard-level {
    background: rgba(255,255,255,0.3);
    padding: 2px 8px;
    border-radius: 6px;
    font-size: 11px;
}
.flashcard-theme { font-size: 11px; }
.flashcard-num { font-size: 10px; opacity: 0.9; }
.flashcard-body {
    padding: 14px;
    min-height: 110px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.flashcard-prompt {
    font-weight: 700;
    font-size: 14px;
    line-height: 1.4;
    color: #1e293b;
    margin-bottom: 8px;
}
.flashcard-vocab {
    font-size: 11px;
    color: #64748b;
    margin-top: auto;
}

@media print {
    @page { size: A4 portrait; margin: 10mm; }
    body { background: #fff !important; }
    .screen-only { display: none !important; }
    /* Hide everything except the flashcard grid */
    header, footer, nav, .pointer-events-none { display: none !important; }
    main { padding: 0 !important; }
    .flashcard-grid {
        gap: 8px;
    }
    .flashcard {
        border: 1.5px dashed #94a3b8;
        break-inside: avoid;
    }
    /* Force 6 per page: 2 columns x 3 rows */
    .flashcard:nth-child(7) { break-before: page; }
    .flashcard:nth-child(13) { break-before: page; }
    .flashcard-body { min-height: 95px; }
    .flashcard-prompt { font-size: 13px; }
}
</style>
@endpush
