<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CoRide') }} — Espace Authentification</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-100 bg-[#0B0F19] antialiased min-h-screen flex flex-col justify-center items-center py-10 px-4">
        <!-- Logo -->
        <div class="mb-6 text-center">
            <a href="/" class="inline-flex items-center gap-3 group">
                <div class="h-11 w-11 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-500/25 group-hover:bg-blue-500 transition">
                    <svg class="h-6 w-6 stroke-[2.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h8m-8 4h8m-4 4h4M3 9l4-4m0 0l4 4M7 5v14"/>
                    </svg>
                </div>
                <div class="text-left">
                    <span class="font-display font-extrabold text-2xl tracking-tight text-white block">CoRide</span>
                    <span class="text-xs font-mono font-semibold uppercase text-blue-400 tracking-wider -mt-1 block">MobiliTech</span>
                </div>
            </a>
        </div>

        <!-- Auth Container Card -->
        <div class="w-full sm:max-w-md bg-[#151D2A] border border-white/10 rounded-2xl shadow-2xl p-8 space-y-6">
            {{ $slot }}
        </div>

        <p class="mt-8 text-xs font-mono text-slate-400">
            © 2026 MOBILITECH — MOBILITÉ COVOITURAGE ENTREPRISE
        </p>
    </body>
</html>
