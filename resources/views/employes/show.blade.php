<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-[var(--text-heading)] leading-tight">
                Profil de {{ $employe->nom }}
            </h2>
            <a href="{{ route('employes.index') }}" class="btn-pro-primary bg-gray-600 hover:bg-gray-700 focus:ring-gray-500">
                <svg class="w-4 h-4 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Retour à l'annuaire
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="pro-card">
                <h3 class="text-lg font-medium text-[var(--text-heading)] mb-6 border-b border-[var(--border-color)] pb-4">
                    Informations du profil
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <span class="text-sm text-[var(--text-muted)] font-medium uppercase tracking-wider">Nom complet</span>
                        <p class="text-[var(--text-normal)] font-medium">{{ $employe->nom }}</p>
                    </div>
                    
                    <div class="space-y-1">
                        <span class="text-sm text-[var(--text-muted)] font-medium uppercase tracking-wider">Email</span>
                        <p class="text-[var(--text-normal)] font-medium">{{ $employe->email }}</p>
                    </div>
                    
                    <div class="space-y-1">
                        <span class="text-sm text-[var(--text-muted)] font-medium uppercase tracking-wider">Entreprise</span>
                        <p class="text-[var(--text-normal)] font-medium">{{ $employe->entreprise->nom ?? '—' }}</p>
                    </div>
                    
                    <div class="space-y-1">
                        <span class="text-sm text-[var(--text-muted)] font-medium uppercase tracking-wider">Ville de résidence</span>
                        <p class="text-[var(--text-normal)] font-medium">{{ $employe->ville_residence ?? '—' }}</p>
                    </div>
                    
                    <div class="space-y-1 md:col-span-2">
                        <span class="text-sm text-[var(--text-muted)] font-medium uppercase tracking-wider block mb-1">Rôle</span>
                        <span class="pro-badge {{ $employe->role === 'admin_entreprise' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'bg-brand-500/20 text-brand-300 border border-brand-500/30' }}">
                            {{ str_replace('_', ' ', $employe->role) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
