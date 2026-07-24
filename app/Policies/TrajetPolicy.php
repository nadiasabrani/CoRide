<?php

namespace App\Policies;

use App\Models\Employe;
use App\Models\Trajet;

class TrajetPolicy
{
    /**
     * Tout employé connecté peut voir la liste des trajets.
     */
    public function viewAny(Employe $employe): bool
    {
        return true;
    }

    /**
     * Tout employé connecté peut voir le détail d'un trajet.
     */
    public function view(Employe $employe, Trajet $trajet): bool
    {
        return true;
    }

    /**
     * Un employé ayant le rôle conducteur ou les_deux peut créer un trajet.
     */
    public function create(Employe $employe): bool
    {
        return in_array($employe->role, ['conducteur', 'les_deux']);
    }

    /**
     * Seul le conducteur propriétaire peut modifier son trajet.
     */
    public function update(Employe $employe, Trajet $trajet): bool
    {
        return $trajet->conducteur_id === $employe->id;
    }

    /**
     * Seul le conducteur propriétaire peut supprimer un trajet,
     * et uniquement si aucune réservation n'est confirmée.
     */
    public function delete(Employe $employe, Trajet $trajet): bool
    {
        if ($trajet->conducteur_id !== $employe->id) {
            return false;
        }

        return !$trajet->reservations()
            ->where('statut', 'confirmee')
            ->exists();
    }

    public function restore(Employe $employe, Trajet $trajet): bool
    {
        return false;
    }

    public function forceDelete(Employe $employe, Trajet $trajet): bool
    {
        return false;
    }
}
