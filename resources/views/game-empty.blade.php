@extends('layouts.app')

@section('title', $theme->name . ' · ' . $level . ' — Empty')

@section('content')
<section class="max-w-2xl mx-auto px-4 py-20 text-center">
    <div class="grid place-items-center w-24 h-24 rounded-3xl bg-gradient-to-br from-slate-100 to-slate-200 text-5xl mx-auto mb-6">📭</div>
    <h1 class="font-display font-extrabold text-3xl text-slate-800">No cards here yet</h1>
    <p class="mt-3 text-slate-500">There are no {{ $level }} questions for <strong>{{ $theme->name }}</strong> yet. Try another level!</p>
    <div class="mt-8">
        <a href="{{ route('themes.show', $theme) }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-rose-500 via-fuchsia-500 to-violet-500 text-white font-semibold shadow-lg hover:-translate-y-0.5 transition-all">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to levels
        </a>
    </div>
</section>
@endsection
