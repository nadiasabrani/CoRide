<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CoRide') }} — Mobilité Entreprise</title>
        <meta name="description" content="Plateforme de covoiturage entreprise intelligente proposée par MobiliTech.">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-100 bg-[#0B0F19] min-h-screen">
        <div class="min-h-screen flex flex-col bg-[#0B0F19]">

            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-[#111827] border-b border-white/10 shadow-sm py-5">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="border-t border-white/10 bg-[#090D16] py-6 text-xs text-slate-400 font-mono">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <p>© 2026 MOBILITECH — CORIDE ENTREPRISE MOBILITY</p>
                    <div class="flex gap-6">
                        <span>CASABLANCA, MAROC</span>
                        <span>•</span>
                        <span class="text-emerald-400 font-semibold">ECO-RESPONSABLE</span>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
