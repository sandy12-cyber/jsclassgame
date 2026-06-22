@extends('layouts.app')

@section('title', 'Playlist — SpeakUp!')

@section('content')
<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <div class="text-center mb-8">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/70 dark:bg-slate-900/70 border border-white dark:border-slate-700 text-sm font-semibold text-fuchsia-600 dark:text-fuchsia-400 shadow-sm">
            <i data-lucide="list-music" class="w-4 h-4"></i> Multi-deck session
        </span>
        <h1 class="mt-4 font-display font-extrabold text-3xl sm:text-5xl bg-gradient-to-r from-fuchsia-500 via-pink-500 to-rose-500 dark:from-fuchsia-400 dark:via-pink-400 dark:to-rose-400 bg-clip-text text-transparent">Playlist Builder</h1>
        <p class="mt-3 text-slate-500 dark:text-slate-400 max-w-2xl mx-auto">Queue several decks into a single practice session. Perfect for mixed-topic warm-ups or exam revision across levels.</p>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Deck picker (2 cols) -->
        <div class="lg:col-span-2">
            <h2 class="font-display font-extrabold text-xl text-slate-800 dark:text-slate-100 mb-4">1. Add decks to your playlist</h2>
            <div class="grid sm:grid-cols-2 gap-3" id="deckPicker">
                @foreach ($themes as $theme)
                    <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 p-4 shadow-sm">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="grid place-items-center w-9 h-9 rounded-xl bg-gradient-to-br {{ $theme->gradient }} text-lg">{{ $theme->emoji }}</span>
                            <span class="font-semibold text-slate-700 dark:text-slate-200 text-sm truncate">{{ $theme->name }}</span>
                        </div>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach (['A1','A2','B1','B2'] as $lvl)
                                @php $cnt = $theme->level_counts[$lvl] ?? 0; @endphp
                                @if ($cnt > 0)
                                    <button class="add-deck-btn px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-fuchsia-500 hover:text-white transition-all"
                                            data-theme="{{ $theme->slug }}" data-theme-name="{{ $theme->name }}" data-theme-emoji="{{ $theme->emoji }}" data-theme-gradient="{{ $theme->gradient }}"
                                            data-level="{{ $lvl }}" data-count="{{ $cnt }}">
                                        + {{ $lvl }}
                                    </button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Playlist queue (1 col, sticky) -->
        <div>
            <div class="lg:sticky lg:top-20">
                <h2 class="font-display font-extrabold text-xl text-slate-800 dark:text-slate-100 mb-4">2. Your playlist</h2>
                <div class="rounded-3xl bg-white/80 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700 p-5 shadow-sm">
                    <div id="playlistQueue" class="space-y-2 min-h-[120px]">
                        <p id="emptyQueue" class="text-sm text-slate-400 dark:text-slate-500 text-center py-8">No decks added yet. Click + buttons on the left.</p>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <div class="flex items-center justify-between text-sm mb-3">
                            <span class="text-slate-500 dark:text-slate-400">Total cards</span>
                            <span id="totalCards" class="font-bold text-slate-700 dark:text-slate-200">0</span>
                        </div>
                        <a id="playPlaylistBtn" href="#" class="block text-center px-5 py-3 rounded-xl bg-gradient-to-r from-fuchsia-500 via-pink-500 to-rose-500 text-white font-semibold shadow-md opacity-50 pointer-events-none transition-all">
                            <i data-lucide="play" class="w-4 h-4 inline -mt-0.5"></i> Start session
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    window.SpeakUpPlaylistBuilder = {
        playRoute: "{{ route('playlist.play') }}",
    };
</script>
<script src="{{ asset('js/playlist-builder.js') }}" defer></script>
@endpush
