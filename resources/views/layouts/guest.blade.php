<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CoRide') }} — Espace Authentification</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-slate-900">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-900">
            <div class="text-center">
                <a href="/" class="inline-flex items-center gap-3">
                    <div class="h-12 w-12 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/30">
                        <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7h8m-8 4h8m-4 4h4M3 9l4-4m0 0l4 4M7 5v14"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <span class="text-3xl font-extrabold tracking-tight text-white block">CoRide</span>
                        <span class="text-xs text-indigo-400 font-semibold tracking-widest uppercase -mt-1 block">MobiliTech</span>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-6 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden sm:rounded-2xl border dark:border-gray-700">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
