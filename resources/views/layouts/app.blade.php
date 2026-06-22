<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SpeakUp!') — Speaking Question Card Game</title>
    <meta name="description" content="@yield('description', 'Practice English speaking with colorful question cards organized by theme and CEFR level (A1–B2).')">

    <!-- Favicon (inline emoji) -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🗣️</text></svg>">

    <!-- Tailwind Play CDN (no build step needed) -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        display: ['Baloo 2', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pop': 'pop 0.35s cubic-bezier(0.34, 1.56, 0.64, 1)',
                        'shimmer': 'shimmer 2.2s linear infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-12px)' },
                        },
                        pop: {
                            '0%': { transform: 'scale(0.85)', opacity: '0' },
                            '100%': { transform: 'scale(1)', opacity: '1' },
                        },
                        shimmer: {
                            '0%': { backgroundPosition: '-1000px 0' },
                            '100%': { backgroundPosition: '1000px 0' },
                        },
                    },
                },
            },
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js" defer></script>

    <!-- App styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')
</head>
<body class="min-h-screen flex flex-col bg-gradient-to-br from-rose-50 via-amber-50 to-violet-50 text-slate-800 font-sans antialiased">

    <!-- Decorative background blobs -->
    <div class="pointer-events-none fixed inset-0 overflow-hidden -z-10" aria-hidden="true">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-rose-300/30 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 -right-24 w-96 h-96 bg-violet-300/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-1/3 w-96 h-96 bg-amber-300/30 rounded-full blur-3xl"></div>
    </div>

    @include('partials.header')

    <main class="flex-1 w-full">
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
    <script>
        // Initialise lucide icons after every render
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) window.lucide.createIcons();
        });
    </script>
</body>
</html>
