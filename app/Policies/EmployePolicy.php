<?php

namespace App\Policies;

use App\Models\Employe;

class EmployePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Employe $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Employe $user, User $model): bool
    {
        return $user->id === $model->id || $user->role === 'admin';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Employe $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Employe $user, User $model): bool
    {
        return $user->id === $model->id || $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Employe $user, User $model): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Employe $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Employe $user, User $model): bool
    {
        return false;
    }
}
