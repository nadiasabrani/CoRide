<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CoRide — Solution de Covoiturage Entreprise MobiliTech</title>
    <meta name="description" content="Solution de covoiturage entreprise intelligente avec algorithme de scoring IA par MobiliTech.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0B0F19] text-slate-100 font-sans antialiased min-h-screen flex flex-col">

    <!-- Header Navigation -->
    <header class="bg-[#111827] border-b border-white/10 sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl w-full mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-500/25">
                    <svg class="h-6 w-6 stroke-[2.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h8m-8 4h8m-4 4h4M3 9l4-4m0 0l4 4M7 5v14"/>
                    </svg>
                </div>
                <div>
                    <span class="font-display font-extrabold text-2xl tracking-tight text-white block">CoRide</span>
                    <span class="text-[10px] font-mono uppercase text-blue-400 font-semibold tracking-wider block -mt-1">by MobiliTech</span>
                </div>
            </div>

            <nav class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-pro-primary">
                            Tableau de bord →
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-300 hover:text-white font-semibold text-sm px-4 py-2 transition">
                            Se connecter
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-pro-primary">
                                S'inscrire
                            </a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <!-- Route Marquee Ticker -->
    <div class="bg-[#090D16] border-b border-white/10 py-2.5 overflow-hidden">
        @php
            $routes = [
                ['CASABLANCA', 'RABAT', '07:30', '95%'],
                ['RABAT', 'CASABLANCA', '18:15', '88%'],
                ['CASABLANCA', 'MOHAMMEDIA', '08:00', '97%'],
                ['SALÉ', 'RABAT', '07:45', '91%'],
                ['CASABLANCA', 'EL JADIDA', '17:30', '84%'],
            ];
        @endphp
        <div class="flex whitespace-nowrap gap-12 font-mono text-xs text-slate-300 animate-marquee">
            @for ($i = 0; $i < 2; $i++)
                @foreach ($routes as $r)
                    <span class="inline-flex items-center gap-3 shrink-0">
                        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                        <strong class="text-white">{{ $r[0] }}</strong> → <strong class="text-white">{{ $r[1] }}</strong>
                        <span class="text-slate-400">•</span>
                        <span class="text-blue-400 font-semibold">{{ $r[2] }}</span>
                        <span class="text-slate-400">•</span>
                        <span class="text-emerald-400 font-semibold">{{ $r[3] }} compatibilité</span>
                    </span>
                @endforeach
            @endfor
        </div>
    </div>

    <!-- Hero Section -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-6 py-16 lg:py-24 grid lg:grid-cols-2 gap-12 items-center">
        
        <!-- Hero Text -->
        <div class="space-y-8">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-500/10 border border-blue-500/30 text-blue-400 text-xs font-mono font-bold">
                <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                SOLUTION MOBILITÉ D'ENTREPRISE
            </div>

            <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight tracking-tight">
                Le même trajet.<br>
                <span class="text-blue-500">Une seule voiture.</span>
            </h1>

            <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-xl">
                CoRide connecte les salariés d'entreprises partenaires qui effectuent le même trajet domicile-travail. Grâce à un algorithme de scoring précis, chaque suggestion est automatiquement optimisée et expliquée.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 pt-2">
                <a href="{{ route('register') }}" class="btn-pro-primary text-base py-3.5 px-8">
                    Publier ou réserver un trajet →
                </a>
                <a href="{{ route('login') }}" class="btn-pro-secondary text-base py-3.5 px-6">
                    Espace employé
                </a>
            </div>

            <!-- Stats Bar -->
            <div class="grid grid-cols-3 gap-6 pt-6 border-t border-white/10 max-w-lg">
                <div>
                    <p class="font-display text-3xl font-extrabold text-white">5</p>
                    <p class="text-xs font-mono text-slate-400 uppercase mt-1">Entreprises</p>
                </div>
                <div>
                    <p class="font-display text-3xl font-extrabold text-blue-400">0–100</p>
                    <p class="text-xs font-mono text-slate-400 uppercase mt-1">Score IA</p>
                </div>
                <div>
                    <p class="font-display text-3xl font-extrabold text-emerald-400">100%</p>
                    <p class="text-xs font-mono text-slate-400 uppercase mt-1">Eco-Responsable</p>
                </div>
            </div>
        </div>

        <!-- Hero Trajet Card Mockup -->
        <div class="pro-card p-8 space-y-6">
            <div class="flex items-center justify-between border-b border-white/10 pb-5">
                <div class="flex items-center gap-3">
                    <div class="h-11 w-11 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 font-bold text-white flex items-center justify-center font-display text-base">
                        KB
                    </div>
                    <div>
                        <p class="font-bold text-white text-base">Karim Benali</p>
                        <p class="text-xs text-slate-400 font-medium">MobiliTech • Conducteur</p>
                    </div>
                </div>
                <span class="pro-badge pro-badge-emerald">3 places dispo</span>
            </div>

            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-mono text-slate-400 uppercase">Départ</p>
                    <p class="text-xl font-bold text-white">Casablanca</p>
                    <p class="text-xs font-mono text-blue-400 font-semibold mt-0.5">07:30</p>
                </div>
                <div class="flex-1 px-6 text-center">
                    <span class="text-[11px] font-mono text-slate-400">45 km</span>
                    <div class="route-line-pro my-2"></div>
                    <span class="text-[11px] font-mono text-slate-400">LUN–VEN</span>
                </div>
                <div class="text-right">
                    <p class="text-xs font-mono text-slate-400 uppercase">Arrivée</p>
                    <p class="text-xl font-bold text-white">Rabat</p>
                    <p class="text-xs font-mono text-emerald-400 font-bold mt-0.5">50 DH</p>
                </div>
            </div>

            <!-- Score IA Box -->
            <div class="bg-[#0B0F19] border border-blue-500/30 rounded-xl p-4 space-y-2.5">
                <div class="flex justify-between items-center text-xs">
                    <span class="font-bold text-blue-400 uppercase tracking-wider font-mono">Score de compatibilité IA</span>
                    <span class="font-bold font-mono text-sm text-emerald-400">95/100</span>
                </div>
                <div class="w-full bg-slate-800 rounded-full h-2 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-emerald-400 h-2 rounded-full w-[95%]"></div>
                </div>
                <p class="text-xs text-slate-300 leading-snug">
                    Point de départ idéal, itinéraire direct et créneau horaire identique.
                </p>
            </div>
        </div>
    </main>

    <!-- Why Section -->
    <section class="border-t border-white/10 bg-[#0E1422] py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="max-w-xl mb-12">
                <span class="text-xs font-mono text-blue-400 font-bold uppercase tracking-widest">Pourquoi CoRide</span>
                <h2 class="font-display text-3xl font-extrabold text-white mt-2">
                    Le trajet domicile-travail, réinventé pour l'entreprise
                </h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="pro-card p-6 space-y-3">
                    <div class="h-10 w-10 rounded-lg bg-blue-500/10 border border-blue-500/20 text-blue-400 font-bold flex items-center justify-center font-mono">01</div>
                    <h3 class="font-bold text-white text-lg">Score IA Transparent</h3>
                    <p class="text-sm text-slate-300 leading-relaxed">Chaque proposition de covoiturage est évaluée scientifiquement sur 100 et expliquée clairement.</p>
                </div>
                <div class="pro-card p-6 space-y-3">
                    <div class="h-10 w-10 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-bold flex items-center justify-center font-mono">02</div>
                    <h3 class="font-bold text-white text-lg">Réseau d'Entreprise Sécurisé</h3>
                    <p class="text-sm text-slate-300 leading-relaxed">Espace privé réservé exclusivement aux employés vérifiés des entreprises partenaires.</p>
                </div>
                <div class="pro-card p-6 space-y-3">
                    <div class="h-10 w-10 rounded-lg bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 font-bold flex items-center justify-center font-mono">03</div>
                    <h3 class="font-bold text-white text-lg">Partage de Frais Équitable</h3>
                    <p class="text-sm text-slate-300 leading-relaxed">Tarification fixe par trajet, transparente et sans commission cachée pour tous les collaborateurs.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-white/10 bg-[#090D16] py-6 text-xs text-slate-400 font-mono">
        <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p>© 2026 MOBILITECH — CORIDE COVOITURAGE ENTREPRISE</p>
            <div class="flex gap-6">
                <span>CASABLANCA, MAROC</span>
                <span>•</span>
                <span class="text-emerald-400 font-semibold">SOLUTION MOBILITÉ DURABLE</span>
            </div>
        </div>
    </footer>

</body>
</html>
