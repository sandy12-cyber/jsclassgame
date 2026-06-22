<footer class="mt-auto border-t border-white/60 dark:border-slate-800 bg-white/50 dark:bg-slate-950/50 backdrop-blur-xl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid sm:grid-cols-3 gap-6 items-center">
            <!-- Brand -->
            <div class="flex items-center gap-2 justify-center sm:justify-start">
                <span class="grid place-items-center w-8 h-8 rounded-xl bg-gradient-to-br from-rose-500 via-fuchsia-500 to-violet-500 text-white text-sm shadow">🗣️</span>
                <span class="font-display font-bold text-slate-700 dark:text-slate-200">SpeakUp!</span>
                <span class="text-sm text-slate-400 dark:text-slate-500">· speaking card game</span>
            </div>

            <!-- Links -->
            <div class="flex flex-wrap items-center justify-center gap-x-3 gap-y-1 text-sm text-slate-500 dark:text-slate-400">
                <a href="{{ route('home') }}" class="hover:text-rose-600 dark:hover:text-rose-400 transition-colors">Themes</a>
                <a href="{{ route('challenge.daily') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Daily</a>
                <a href="{{ route('playlist.index') }}" class="hover:text-fuchsia-600 dark:hover:text-fuchsia-400 transition-colors">Playlist</a>
                <a href="{{ route('tools.timer') }}" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">Timer</a>
                <a href="{{ route('search') }}" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">Search</a>
                <a href="{{ route('favorites') }}" class="hover:text-rose-600 dark:hover:text-rose-400 transition-colors">Favorites</a>
                <a href="{{ route('dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Stats</a>
                <a href="{{ route('rubric.history') }}" class="hover:text-violet-600 dark:hover:text-violet-400 transition-colors">Rubric</a>
                <a href="{{ route('export.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Export</a>
                <a href="{{ route('welcome') }}" class="hover:text-fuchsia-600 dark:hover:text-fuchsia-400 transition-colors" title="Replay the welcome tour">Tour</a>
                <a href="{{ route('about') }}" class="hover:text-fuchsia-600 dark:hover:text-fuchsia-400 transition-colors">How</a>
            </div>

            <!-- Stats -->
            <p class="text-sm text-slate-500 dark:text-slate-400 text-center sm:text-right">
                Made with <span class="text-rose-500">♥</span> ·
                <span class="font-semibold text-slate-600 dark:text-slate-300">{{ $totalQuestions ?? '480' }}</span> questions ·
                <span class="font-semibold text-slate-600 dark:text-slate-300">A1–B2</span>
            </p>
        </div>
    </div>
</footer>
