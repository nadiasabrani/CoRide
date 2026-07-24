<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CoRide — Mobility Solutions by MobiliTech</title>
    <meta name="description" content="Solution de covoiturage entreprise intelligente proposée par MobiliTech avec algorithme de compatibilité IA.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="h-full bg-slate-900 text-slate-100 antialiased selection:bg-indigo-500 selection:text-white">

    <!-- Background glowing Orbs -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-indigo-600/30 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -left-40 w-96 h-96 bg-purple-600/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 right-1/3 w-96 h-96 bg-emerald-600/20 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 min-h-screen flex flex-col justify-between">

        <!-- Navigation Header -->
        <header class="max-w-7xl w-full mx-auto px-6 py-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/30">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7h8m-8 4h8m-4 4h4M3 9l4-4m0 0l4 4M7 5v14"/>
                    </svg>
                </div>
                <div>
                    <span class="text-2xl font-extrabold tracking-tight bg-gradient-to-r from-white via-indigo-200 to-indigo-400 bg-clip-text text-transparent">CoRide</span>
                    <span class="text-xs text-indigo-400 block -mt-1 font-semibold tracking-wider uppercase">by MobiliTech</span>
                </div>
            </div>

            <nav class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-indigo-600/30 transition duration-200">
                            Tableau de bord →
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="text-slate-300 hover:text-white font-medium px-4 py-2 transition">
                            Se connecter
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-indigo-500/25 transition duration-200">
                                S'inscrire
                            </a>
                        @endif
                    @endauth
                @endif
            </nav>
        </header>

        <!-- Hero Section -->
        <main class="max-w-7xl mx-auto px-6 py-16 text-center lg:text-left grid lg:grid-cols-2 items-center gap-12 my-auto">
            <div class="space-y-8">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 text-sm font-medium">
                    <span class="flex h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Solution Mobilité Durable d'Entreprise
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-none">
                    Le covoiturage entre collègues <span class="bg-gradient-to-r from-indigo-400 via-purple-300 to-emerald-400 bg-clip-text text-transparent">propulsé par l'IA</span>
                </h1>

                <p class="text-lg text-slate-300 leading-relaxed max-w-xl">
                    CoRide résout les trajets domicile-travail des salariés d'entreprises partenaires grâce à un algorithme de scoring intégrant villes de départ, récurrence hebdomadaire et tolérance horaire explicative.
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center justify-center gap-3 bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-600 hover:from-indigo-400 hover:to-purple-400 text-white font-bold px-8 py-4 rounded-2xl shadow-xl shadow-indigo-500/30 text-lg transition duration-200 transform hover:-translate-y-0.5">
                        🚗 Publier ou Réserver un trajet
                    </a>
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center justify-center gap-2 bg-slate-800/80 hover:bg-slate-800 border border-slate-700/80 text-slate-200 font-semibold px-6 py-4 rounded-2xl transition duration-200">
                        🔑 Espace employé
                    </a>
                </div>

                <!-- Features list -->
                <div class="grid grid-cols-3 gap-4 pt-6 border-t border-slate-800">
                    <div>
                        <p class="text-2xl font-extrabold text-white">5</p>
                        <p class="text-xs text-slate-400">Entreprises clientes</p>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold text-indigo-400">0-100%</p>
                        <p class="text-xs text-slate-400">Score IA expliqué</p>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold text-emerald-400">100%</p>
                        <p class="text-xs text-slate-400">Éco-responsable</p>
                    </div>
                </div>
            </div>

            <!-- Hero Card Mockup -->
            <div class="relative">
                <div class="bg-gradient-to-b from-slate-800/90 to-slate-900/90 backdrop-blur-xl border border-slate-700/60 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6">
                    <div class="flex items-center justify-between border-b border-slate-700/60 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 bg-indigo-500/20 rounded-full flex items-center justify-center text-indigo-400 font-bold">
                                KB
                            </div>
                            <div>
                                <p class="font-bold text-white">Karim Benali</p>
                                <p class="text-xs text-slate-400">MobiliTech • Conducteur</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-emerald-500/20 text-emerald-300 rounded-full text-xs font-semibold">3 places libres</span>
                    </div>

                    <!-- Trajet Card -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-slate-400 uppercase tracking-wider">Départ</p>
                                <p class="text-xl font-bold text-white">Casablanca</p>
                                <p class="text-xs text-indigo-300">07:30</p>
                            </div>
                            <div class="flex flex-col items-center">
                                <span class="text-xs text-slate-500">45 km</span>
                                <div class="w-24 h-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 my-1"></div>
                                <span class="text-xs text-purple-300">Lun - Ven</span>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-slate-400 uppercase tracking-wider">Arrivée</p>
                                <p class="text-xl font-bold text-white">Rabat</p>
                                <p class="text-xs text-emerald-400 font-bold">50 DH</p>
                            </div>
                        </div>

                        <!-- IA Score Widget Preview -->
                        <div class="bg-indigo-950/50 border border-indigo-500/30 rounded-2xl p-4 space-y-2">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-indigo-300 flex items-center gap-1.5">
                                    ✨ Score de compatibilité IA
                                </span>
                                <span class="font-bold text-emerald-400 text-sm">95/100</span>
                            </div>
                            <div class="w-full bg-slate-800 rounded-full h-2">
                                <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-2 rounded-full w-[95%]"></div>
                            </div>
                            <p class="text-xs text-slate-300">
                                ✅ Ville de départ idéale, itinéraire direct et créneau horaire identique.
                            </p>
                        </div>
                    </div>

                    <!-- Companies badges -->
                    <div class="pt-4 border-t border-slate-700/60 text-center">
                        <p class="text-xs text-slate-500 uppercase tracking-widest mb-3">Entreprises partenaires</p>
                        <div class="flex flex-wrap justify-center gap-3">
                            <span class="px-3 py-1 bg-slate-800 text-slate-300 rounded-lg text-xs font-semibold">MobiliTech</span>
                            <span class="px-3 py-1 bg-slate-800 text-slate-300 rounded-lg text-xs font-semibold">NextBuild</span>
                            <span class="px-3 py-1 bg-slate-800 text-slate-300 rounded-lg text-xs font-semibold">Atlas Digital</span>
                            <span class="px-3 py-1 bg-slate-800 text-slate-300 rounded-lg text-xs font-semibold">GreenLogix</span>
                            <span class="px-3 py-1 bg-slate-800 text-slate-300 rounded-lg text-xs font-semibold">Kandia Solutions</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="max-w-7xl w-full mx-auto px-6 py-6 border-t border-slate-800 text-center sm:text-left flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-4">
            <p>© 2026 MobiliTech — CoRide Application de Covoiturage Entreprise.</p>
            <div class="flex gap-6">
                <span>Casablanca, Maroc</span>
                <span>•</span>
                <span>Mobilité Durable</span>
            </div>
        </footer>

    </div>

</body>
</html>
