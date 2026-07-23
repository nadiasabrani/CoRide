<?php

namespace App\Policies;

use App\Models\Employe;

class EmployePolicy
{
    /**
     * Tout employé authentifié peut consulter l'annuaire des employés
     * (utile pour identifier des collègues avec qui covoiturer).
     */
    public function viewAny(Employe $user): bool
    {
        return true;
    }

    /**
     * Tout employé authentifié peut consulter le profil public d'un collègue.
     */
    public function view(Employe $user, Employe $model): bool
    {
        return true;
    }

    /**
     * La création d'un compte se fait uniquement via l'inscription (register),
     * jamais via une action autorisée par la policy.
     */
    public function create(Employe $user): bool
    {
        return false;
    }

    /**
     * Un employé ne peut modifier que son propre profil.
     */
    public function update(Employe $user, Employe $model): bool
    {
        return $user->id === $model->id;
    }

    /**
     * Un employé ne peut supprimer que son propre compte.
     */
    public function delete(Employe $user, Employe $model): bool
    {
        return $user->id === $model->id;
    }

    public function restore(Employe $user, Employe $model): bool
    {
        return false;
    }

    public function forceDelete(Employe $user, Employe $model): bool
    {
        return false;
    }
}
