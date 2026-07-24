<?php

namespace App\Policies;

use App\Models\Employe;
use App\Models\Trajet;
use Illuminate\Auth\Access\Response;

class TrajetPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Employe $employe): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Employe $employe, Trajet $trajet): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Employe $employe): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Employe $employe, Trajet $trajet): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
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

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Employe $employe, Trajet $trajet): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Employe $employe, Trajet $trajet): bool
    {
        return false;
    }
}
