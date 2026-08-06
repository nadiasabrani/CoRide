<nav x-data="{ open: false }" class="bg-[#111827] border-b border-white/10 sticky top-0 z-50 shadow-md">
    @php
        $user = Auth::user();
        $isConducteur = in_array($user->role, ['conducteur', 'les_deux']);
        $isPassager   = in_array($user->role, ['passager', 'les_deux']);
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    <div class="h-9 w-9 bg-blue-600 rounded-lg flex items-center justify-center text-white shadow-lg shadow-blue-500/20 group-hover:bg-blue-500 transition">
                        <svg class="h-5 w-5 stroke-[2.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h8m-8 4h8m-4 4h4M3 9l4-4m0 0l4 4M7 5v14"/>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-display font-extrabold text-xl tracking-tight text-white">CoRide</span>
                        <span class="text-[10px] font-mono uppercase text-blue-400 font-semibold tracking-wider -mt-1">MobiliTech</span>
                    </div>
                </a>
            </div>

            <!-- Nav Links -->
            <div class="hidden sm:flex items-center gap-2">
                <a href="{{ route('dashboard') }}"
                   class="px-3.5 py-2 rounded-lg text-sm font-semibold transition {{ request()->routeIs('dashboard') ? 'bg-blue-600/15 text-blue-400 border border-blue-500/30' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    🏠 Dashboard
                </a>

                @if($isPassager)
                    <a href="{{ route('trajets.search') }}"
                       class="px-3.5 py-2 rounded-lg text-sm font-semibold transition {{ request()->routeIs('trajets.search') ? 'bg-blue-600/15 text-blue-400 border border-blue-500/30' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        🔍 Recherche
                    </a>
                @endif

                <a href="{{ route('trajets.index') }}"
                   class="px-3.5 py-2 rounded-lg text-sm font-semibold transition {{ request()->routeIs('trajets.index') ? 'bg-blue-600/15 text-blue-400 border border-blue-500/30' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    🚗 Trajets
                </a>

                @if($isPassager)
                    <a href="{{ route('reservations.index') }}"
                       class="px-3.5 py-2 rounded-lg text-sm font-semibold transition {{ request()->routeIs('reservations.index') ? 'bg-blue-600/15 text-blue-400 border border-blue-500/30' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        📋 Réservations
                    </a>
                @endif

                @if($isConducteur)
                    <a href="{{ route('reservations.conducteur.index') }}"
                       class="px-3.5 py-2 rounded-lg text-sm font-semibold transition {{ request()->routeIs('reservations.conducteur.index') ? 'bg-blue-600/15 text-blue-400 border border-blue-500/30' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        🎛️ Gestion Conducteur
                    </a>
                @endif
            </div>

            <!-- Actions & User Profile -->
            <div class="hidden sm:flex items-center gap-3">
                @if($isConducteur)
                    <a href="{{ route('trajets.create') }}" class="btn-pro-primary text-xs py-2 px-3.5">
                        ➕ Publier un trajet
                    </a>
                @endif

                <!-- User Dropdown -->
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg border border-white/10 hover:border-white/20 bg-white/5 transition text-left">
                            <div class="h-7 w-7 rounded-md bg-gradient-to-tr from-blue-600 to-indigo-500 text-white font-bold flex items-center justify-center text-xs">
                                {{ strtoupper(substr($user->nom, 0, 2)) }}
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white leading-none">{{ $user->nom }}</p>
                                <p class="text-[10px] font-mono text-blue-400 capitalize mt-0.5">{{ str_replace('_', ' ', $user->role) }}</p>
                            </div>
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-[#1E293B] border border-white/10 rounded-lg shadow-xl overflow-hidden py-1 text-sm">
                            <div class="px-4 py-2.5 border-b border-white/10">
                                <p class="text-xs font-mono text-slate-400 uppercase">Utilisateur</p>
                                <p class="text-xs font-medium text-white truncate mt-0.5">{{ $user->email }}</p>
                            </div>
                            <x-dropdown-link :href="route('profile.edit')">
                                👤 Mon Profil
                            </x-dropdown-link>
                            @if($isConducteur)
                                <x-dropdown-link :href="route('trajets.create')">
                                    ➕ Publier un trajet
                                </x-dropdown-link>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    🚪 Déconnexion
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger button -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-md text-slate-300 hover:bg-white/10 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#111827] border-t border-white/10 py-3 px-4 space-y-2">
        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-white/5">🏠 Dashboard</a>
        @if($isPassager)
            <a href="{{ route('trajets.search') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-white/5">🔍 Recherche</a>
        @endif
        <a href="{{ route('trajets.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-white/5">🚗 Trajets</a>
        @if($isPassager)
            <a href="{{ route('reservations.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-white/5">📋 Réservations</a>
        @endif
        @if($isConducteur)
            <a href="{{ route('reservations.conducteur.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-white/5">🎛️ Gestion Conducteur</a>
        @endif
        <div class="pt-3 border-t border-white/10 flex items-center justify-between">
            <span class="text-xs text-slate-300 font-semibold">{{ $user->nom }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs text-rose-400 font-semibold hover:underline">Déconnexion</button>
            </form>
        </div>
    </div>
</nav>
