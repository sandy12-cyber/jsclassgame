@extends('layouts.app')

@section('title', 'Favorites — SpeakUp!')

@section('content')
<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <div class="text-center mb-8">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/70 dark:bg-slate-900/70 border border-white dark:border-slate-700 text-sm font-semibold text-rose-600 dark:text-rose-400 shadow-sm">
            <i data-lucide="heart" class="w-4 h-4"></i> Saved by you
        </span>
        <h1 class="mt-4 font-display font-extrabold text-3xl sm:text-5xl bg-gradient-to-r from-rose-500 via-pink-500 to-fuchsia-500 dark:from-rose-400 dark:via-pink-400 dark:to-fuchsia-400 bg-clip-text text-transparent">Your favorites</h1>
        <p class="mt-3 text-slate-500 dark:text-slate-400">Cards you've starred across all themes and levels — stored on this device.</p>
    </div>

    <!-- Loading / empty / content shell (hydrated by JS) -->
    <div id="favoritesShell">
        <div id="favoritesLoading" class="text-center py-16">
            <div class="grid place-items-center w-20 h-20 rounded-3xl bg-rose-100 dark:bg-rose-950/40 text-4xl mx-auto mb-4 animate-float">❤️</div>
            <p class="text-slate-500 dark:text-slate-400">Loading your favorites…</p>
        </div>
        <div id="favoritesEmpty" class="hidden text-center py-16">
            <div class="grid place-items-center w-20 h-20 rounded-3xl bg-slate-100 dark:bg-slate-800 text-4xl mx-auto mb-4">💖</div>
            <h3 class="font-display font-bold text-xl text-slate-700 dark:text-slate-200">No favorites yet</h3>
            <p class="text-slate-500 dark:text-slate-400 mt-1 max-w-md mx-auto">Tap the heart on any card while playing to save it here for quick practice later.</p>
            <a href="{{ route('home') }}" class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-rose-500 via-fuchsia-500 to-violet-500 text-white font-semibold shadow-md hover:-translate-y-0.5 transition-all">
                <i data-lucide="layout-grid" class="w-4 h-4"></i> Browse themes
            </a>
        </div>
        <div id="favoritesGrid" class="hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5"></div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    window.SpeakUpFavorites = {
        resolveUrl: "{{ route('api.favorites.resolve') }}",
        csrfToken: "{{ csrf_token() }}",
        playRoute: "{{ route('game.play', ['__THEME__', '__LEVEL__']) }}",
    };
</script>
<script src="{{ asset('js/favorites.js') }}" defer></script>
@endpush
