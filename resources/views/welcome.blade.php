<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CoRide — Mobility Solutions by MobiliTech</title>
    <meta name="description" content="Solution de covoiturage entreprise intelligente proposée par MobiliTech avec algorithme de compatibilité IA.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-white text-brand-900 antialiased selection:bg-accent-200 selection:text-brand-900">

    <div class="min-h-screen flex flex-col">

        <!-- Navigation Header -->
        <header class="max-w-7xl w-full mx-auto px-6 py-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 bg-brand-600 rounded-lg flex items-center justify-center shadow-sm shadow-brand-600/20 rotate-3">
                    <svg class="h-6 w-6 text-white -rotate-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h8m-8 4h8m-4 4h4M3 9l4-4m0 0l4 4M7 5v14"/>
                    </svg>
                </div>
                <div>
                    <span class="font-display text-2xl font-bold tracking-tight text-brand-900">CoRide</span>
                    <span class="text-[11px] font-mono text-brand-500 block -mt-1 tracking-wider uppercase">by MobiliTech</span>
                </div>
            </div>

            <nav class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white font-semibold px-5 py-2.5 rounded-lg shadow-sm shadow-brand-600/20 transition duration-200">
                            Tableau de bord →
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="text-slate-600 hover:text-brand-700 font-medium px-4 py-2 transition">
                            Se connecter
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white font-semibold px-5 py-2.5 rounded-lg shadow-sm shadow-brand-600/20 transition duration-200">
                                S'inscrire
                            </a>
                        @endif
                    @endauth
                @endif
            </nav>
        </header>

        <!-- Live route ticker — signature element, a departure-board style marquee -->
        <div class="route-ticker bg-brand-900 py-2.5">
            @php
                $routes = [
                    ['CASABLANCA', 'RABAT', '07:30', '95%'],
                    ['RABAT', 'CASABLANCA', '18:15', '88%'],
                    ['CASABLANCA', 'MOHAMMEDIA', '08:00', '97%'],
                    ['SALÉ', 'RABAT', '07:45', '91%'],
                    ['CASABLANCA', 'EL JADIDA', '17:30', '84%'],
                ];
            @endphp
            <div class="route-ticker-track font-mono text-xs text-brand-200">
                @for ($i = 0; $i < 2; $i++)
                    @foreach ($routes as $r)
                        <span class="flex items-center gap-2 shrink-0">
                            <span class="h-1.5 w-1.5 rounded-full bg-accent-400"></span>
                            {{ $r[0] }} → {{ $r[1] }}
                            <span class="text-brand-400">·</span>
                            {{ $r[2] }}
                            <span class="text-brand-400">·</span>
                            <span class="text-accent-400">{{ $r[3] }} compat.</span>
                        </span>
                    @endforeach
                @endfor
            </div>
        </div>

        <!-- Hero Section -->
        <main class="relative dot-grid overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 py-20 lg:py-28 grid lg:grid-cols-[1.15fr_1fr] items-center gap-16">
                <div class="space-y-8">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white border border-accent-200 text-accent-700 text-xs font-mono font-semibold">
                        <span class="flex h-1.5 w-1.5 rounded-full bg-accent-500 animate-pulse"></span>
                        SOLUTION MOBILITÉ D'ENTREPRISE
                    </div>

                    <h1 class="font-display text-5xl sm:text-6xl lg:text-7xl font-bold tracking-tight leading-[0.98] text-brand-900">
                        Le même trajet.<br>
                        <span class="text-brand-600">Une seule voiture.</span>
                    </h1>

                    <p class="text-lg text-slate-600 leading-relaxed max-w-lg">
                        CoRide connecte les salariés d'entreprises partenaires qui font déjà le même chemin, grâce à un algorithme de scoring qui explique chaque suggestion — ville, horaire, récurrence.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center justify-center gap-3 bg-brand-600 hover:bg-brand-500 text-white font-semibold px-8 py-4 rounded-lg text-base shadow-md shadow-brand-600/25 hover:shadow-lg hover:shadow-brand-600/30 hover:-translate-y-0.5 transition duration-200">
                            Publier ou réserver un trajet
                        </a>
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-semibold px-6 py-4 rounded-lg transition duration-200">
                            Espace employé
                        </a>
                    </div>

                    <div class="flex items-center gap-8 pt-4">
                        <div>
                            <p class="font-display text-3xl font-bold text-brand-900">5</p>
                            <p class="text-xs text-slate-500 font-mono">ENTREPRISES</p>
                        </div>
                        <div class="h-8 w-px bg-slate-200"></div>
                        <div>
                            <p class="font-display text-3xl font-bold text-brand-600">0–100</p>
                            <p class="text-xs text-slate-500 font-mono">SCORE IA</p>
                        </div>
                        <div class="h-8 w-px bg-slate-200"></div>
                        <div>
                            <p class="font-display text-3xl font-bold text-accent-600">100%</p>
                            <p class="text-xs text-slate-500 font-mono">ÉCO-RESP.</p>
                        </div>
                    </div>
                </div>

                <!-- Hero Card Mockup — tilted for a more dynamic, less templated feel -->
                <div class="relative">
                    <div class="absolute -inset-4 bg-accent-100/60 rounded-3xl rotate-3"></div>
                    <div class="relative bg-white border border-slate-200 rounded-2xl p-6 sm:p-7 shadow-xl shadow-brand-900/10 -rotate-2 hover:rotate-0 transition duration-300 space-y-5">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 bg-brand-50 rounded-full flex items-center justify-center text-brand-700 font-bold font-display">
                                    KB
                                </div>
                                <div>
                                    <p class="font-bold text-brand-900">Karim Benali</p>
                                    <p class="text-xs text-slate-500">MobiliTech • Conducteur</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-accent-50 text-accent-700 rounded-full text-xs font-mono font-semibold">3 places</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[11px] text-slate-400 uppercase tracking-wider font-mono">Départ</p>
                                <p class="text-xl font-bold text-brand-900">Casablanca</p>
                                <p class="text-xs text-brand-600 font-mono">07:30</p>
                            </div>
                            <div class="flex flex-col items-center gap-1 px-4">
                                <span class="text-[11px] text-slate-400 font-mono">45 km</span>
                                <div class="route-line w-20"><span class="route-car"></span></div>
                                <span class="text-[11px] text-slate-400 font-mono">LUN–VEN</span>
                            </div>
                            <div class="text-right">
                                <p class="text-[11px] text-slate-400 uppercase tracking-wider font-mono">Arrivée</p>
                                <p class="text-xl font-bold text-brand-900">Rabat</p>
                                <p class="text-xs text-accent-600 font-bold font-mono">50 DH</p>
                            </div>
                        </div>

                        <div class="bg-brand-50 border border-brand-100 rounded-xl p-4 space-y-2">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-brand-700">Score de compatibilité IA</span>
                                <span class="font-bold text-accent-600 font-mono text-sm">95/100</span>
                            </div>
                            <div class="w-full bg-white rounded-full h-2 border border-brand-100">
                                <div class="bg-gradient-to-r from-brand-500 to-accent-500 h-2 rounded-full w-[95%]"></div>
                            </div>
                            <p class="text-xs text-slate-600">
                                Ville de départ idéale, itinéraire direct et créneau horaire identique.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Pourquoi CoRide — the "why", numbered with oversized ghost figures -->
        <section class="py-20 lg:py-28 border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-6">
                <div class="max-w-xl mb-14">
                    <span class="text-xs font-mono font-semibold uppercase tracking-widest text-brand-600">Pourquoi CoRide</span>
                    <h2 class="font-display text-3xl sm:text-4xl font-bold text-brand-900 mt-3">
                        Le trajet domicile-travail, sans les tracas
                    </h2>
                </div>

                <div class="grid md:grid-cols-3 gap-x-8 gap-y-12">
                    <div class="relative">
                        <span class="absolute -top-10 -left-2 font-display text-8xl font-bold text-brand-50 select-none">01</span>
                        <div class="relative">
                            <h3 class="font-display font-bold text-xl text-brand-900 mb-2">Score IA expliqué</h3>
                            <p class="text-sm text-slate-600 leading-relaxed">Chaque suggestion est notée sur 100 et justifiée : ville de départ, horaire, récurrence — jamais une boîte noire.</p>
                        </div>
                    </div>
                    <div class="relative">
                        <span class="absolute -top-10 -left-2 font-display text-8xl font-bold text-brand-50 select-none">02</span>
                        <div class="relative">
                            <h3 class="font-display font-bold text-xl text-brand-900 mb-2">Réservé aux collègues</h3>
                            <p class="text-sm text-slate-600 leading-relaxed">Un espace fermé par entreprise partenaire : on partage la route avec des gens qu'on connaît déjà.</p>
                        </div>
                    </div>
                    <div class="relative">
                        <span class="absolute -top-10 -left-2 font-display text-8xl font-bold text-brand-50 select-none">03</span>
                        <div class="relative">
                            <h3 class="font-display font-bold text-xl text-brand-900 mb-2">Frais partagés, clairs</h3>
                            <p class="text-sm text-slate-600 leading-relaxed">Le conducteur fixe un tarif par trajet, affiché avant réservation. Pas de surprise, pas de négociation.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Comment ça marche — a journey connected by the route-line motif -->
        <section class="bg-brand-900 dot-grid-dark py-20 lg:py-28">
            <div class="max-w-7xl mx-auto px-6">
                <div class="max-w-xl mb-16">
                    <span class="text-xs font-mono font-semibold uppercase tracking-widest text-accent-400">Comment ça marche</span>
                    <h2 class="font-display text-3xl sm:text-4xl font-bold text-white mt-3">
                        Trois étapes, du premier trajet au dernier
                    </h2>
                </div>

                <div class="grid md:grid-cols-3 gap-8 relative">
                    <div class="hidden md:block absolute top-6 left-[16.6%] right-[16.6%]">
                        <div class="route-line"><span class="route-car"></span></div>
                    </div>

                    <div>
                        <div class="h-12 w-12 rounded-full bg-white text-brand-900 font-display font-bold flex items-center justify-center mb-5 relative z-10">1</div>
                        <h3 class="font-display font-bold text-white mb-2">Publiez ou recherchez</h3>
                        <p class="text-sm text-brand-200 leading-relaxed">Conducteur : publiez vos trajets récurrents. Passager : cherchez un trajet compatible avec votre horaire.</p>
                    </div>
                    <div>
                        <div class="h-12 w-12 rounded-full bg-white text-brand-900 font-display font-bold flex items-center justify-center mb-5 relative z-10">2</div>
                        <h3 class="font-display font-bold text-white mb-2">Consultez le score IA</h3>
                        <p class="text-sm text-brand-200 leading-relaxed">CoRide calcule et explique la compatibilité de chaque trajet avant que vous ne réserviez.</p>
                    </div>
                    <div>
                        <div class="h-12 w-12 rounded-full bg-accent-400 text-brand-900 font-display font-bold flex items-center justify-center mb-5 relative z-10">3</div>
                        <h3 class="font-display font-bold text-white mb-2">Réservez et roulez</h3>
                        <p class="text-sm text-brand-200 leading-relaxed">Le conducteur confirme, et vous partagez la route — moins cher, moins de voitures, moins de stress.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="max-w-7xl w-full mx-auto px-6 py-6 border-t border-slate-100 text-center sm:text-left flex flex-col sm:flex-row justify-between items-center text-xs text-slate-400 gap-4 font-mono">
            <p>© 2026 MOBILITECH — CORIDE COVOITURAGE ENTREPRISE</p>
            <div class="flex gap-6">
                <span>CASABLANCA, MAROC</span>
                <span>•</span>
                <span>MOBILITÉ DURABLE</span>
            </div>
        </footer>

    </div>

</body>
</html>
