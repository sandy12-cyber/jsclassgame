<header class="sticky top-0 z-40 backdrop-blur-xl bg-white/70 border-b border-white/60 shadow-sm">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
            <span class="grid place-items-center w-10 h-10 rounded-2xl bg-gradient-to-br from-rose-500 via-fuchsia-500 to-violet-500 text-white text-xl shadow-lg shadow-rose-500/30 group-hover:scale-105 transition-transform">🗣️</span>
            <span class="font-display font-extrabold text-xl sm:text-2xl tracking-tight bg-gradient-to-r from-rose-600 via-fuchsia-600 to-violet-600 bg-clip-text text-transparent">SpeakUp!</span>
        </a>

        <div class="flex items-center gap-1 sm:gap-2">
            <a href="{{ route('home') }}" class="px-3 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:text-rose-600 hover:bg-rose-50 transition-colors {{ request()->routeIs('home') ? 'text-rose-600 bg-rose-50' : '' }}">Themes</a>
            <a href="{{ route('about') }}" class="px-3 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:text-violet-600 hover:bg-violet-50 transition-colors {{ request()->routeIs('about') ? 'text-violet-600 bg-violet-50' : '' }}">How to Play</a>
            <a href="https://github.com/sandy12-cyber/jsclassgame" target="_blank" rel="noopener" class="hidden sm:grid place-items-center w-9 h-9 rounded-xl text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition-colors" aria-label="GitHub repository">
                <i data-lucide="github" class="w-5 h-5"></i>
            </a>
        </div>
    </nav>
</header>
