<header class="sticky top-0 z-40 backdrop-blur-xl bg-white/70 dark:bg-slate-950/70 border-b border-white/60 dark:border-slate-800 shadow-sm">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-2">
        <a href="{{ route('home') }}" class="flex items-center gap-2 group shrink-0">
            <span class="grid place-items-center w-10 h-10 rounded-2xl bg-gradient-to-br from-rose-500 via-fuchsia-500 to-violet-500 text-white text-xl shadow-lg shadow-rose-500/30 group-hover:scale-105 group-hover:rotate-3 transition-transform">🗣️</span>
            <span class="font-display font-extrabold text-xl sm:text-2xl tracking-tight bg-gradient-to-r from-rose-600 via-fuchsia-600 to-violet-600 dark:from-rose-400 dark:via-fuchsia-400 dark:to-violet-400 bg-clip-text text-transparent">SpeakUp!</span>
        </a>

        <div class="flex items-center gap-0.5 sm:gap-1">
            <a href="{{ route('home') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors {{ request()->routeIs('home') ? 'text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/40' : '' }}">
                <i data-lucide="layout-grid" class="w-4 h-4"></i> Themes
            </a>
            <a href="{{ route('challenge.daily') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-950/40 transition-colors {{ request()->routeIs('challenge.*') ? 'text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/40' : '' }}">
                <i data-lucide="gift" class="w-4 h-4"></i> Daily
            </a>
            <a href="{{ route('search') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-violet-600 dark:hover:text-violet-400 hover:bg-violet-50 dark:hover:bg-violet-950/40 transition-colors {{ request()->routeIs('search') ? 'text-violet-600 dark:text-violet-400 bg-violet-50 dark:bg-violet-950/40' : '' }}">
                <i data-lucide="search" class="w-4 h-4"></i> Search
            </a>
            <a href="{{ route('favorites') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors {{ request()->routeIs('favorites') ? 'text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/40' : '' }}">
                <i data-lucide="heart" class="w-4 h-4"></i> Favorites
            </a>
            <a href="{{ route('dashboard') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 transition-colors {{ request()->routeIs('dashboard') ? 'text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/40' : '' }}">
                <i data-lucide="bar-chart-3" class="w-4 h-4"></i> Stats
            </a>
            <a href="{{ route('about') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-fuchsia-600 dark:hover:text-fuchsia-400 hover:bg-fuchsia-50 dark:hover:bg-fuchsia-950/40 transition-colors {{ request()->routeIs('about') ? 'text-fuchsia-600 dark:text-fuchsia-400 bg-fuchsia-50 dark:bg-fuchsia-950/40' : '' }}">
                <i data-lucide="help-circle" class="w-4 h-4"></i> How
            </a>

            <!-- Dark mode toggle -->
            <button id="themeToggle" type="button" class="grid place-items-center w-9 h-9 rounded-xl text-slate-500 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" aria-label="Toggle dark mode">
                <i data-lucide="sun" class="w-5 h-5 hidden dark:block"></i>
                <i data-lucide="moon" class="w-5 h-5 block dark:hidden"></i>
            </button>

            <!-- Mobile menu button -->
            <button id="mobileMenuBtn" type="button" class="sm:hidden grid place-items-center w-9 h-9 rounded-xl text-slate-500 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" aria-label="Open menu">
                <i data-lucide="menu" class="w-5 h-5"></i>
            </button>

            <a href="https://github.com/sandy12-cyber/jsclassgame" target="_blank" rel="noopener" class="hidden sm:grid place-items-center w-9 h-9 rounded-xl text-slate-500 dark:text-slate-300 hover:text-slate-800 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" aria-label="GitHub repository">
                <i data-lucide="github" class="w-5 h-5"></i>
            </a>
        </div>
    </nav>

    <!-- Mobile menu (collapsible) -->
    <div id="mobileMenu" class="sm:hidden hidden border-t border-slate-100 dark:border-slate-800 bg-white/95 dark:bg-slate-950/95 backdrop-blur-xl">
        <div class="px-4 py-3 grid grid-cols-2 gap-2">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-rose-50 dark:hover:bg-rose-950/40"><i data-lucide="layout-grid" class="w-4 h-4"></i> Themes</a>
            <a href="{{ route('challenge.daily') }}" class="inline-flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-amber-50 dark:hover:bg-amber-950/40"><i data-lucide="gift" class="w-4 h-4"></i> Daily</a>
            <a href="{{ route('search') }}" class="inline-flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-violet-50 dark:hover:bg-violet-950/40"><i data-lucide="search" class="w-4 h-4"></i> Search</a>
            <a href="{{ route('favorites') }}" class="inline-flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-rose-50 dark:hover:bg-rose-950/40"><i data-lucide="heart" class="w-4 h-4"></i> Favorites</a>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-950/40"><i data-lucide="bar-chart-3" class="w-4 h-4"></i> Stats</a>
            <a href="{{ route('about') }}" class="inline-flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-fuchsia-50 dark:hover:bg-fuchsia-950/40"><i data-lucide="help-circle" class="w-4 h-4"></i> How to play</a>
        </div>
    </div>
</header>
