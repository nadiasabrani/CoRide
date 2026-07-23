<?php

namespace App\Policies;

use App\Models\Employe;

class UserPolicy
{
    /**
     * Admin فقط يشوف لائحة المستخدمين
     */
    public function viewAny(Employe $user): bool
    {
        return $user->role === 'admin';
    }


    /**
     * Admin يشوف User معين
     */
    public function view(Employe $user, User $model): bool
    {
        return $user->role === 'admin';
    }


    /**
     * Admin يقدر يزيد User
     */
    public function create(Employe $user): bool
    {
        return $user->role === 'admin';
    }


    /**
     * Admin يقدر يعدل User
     */
    public function update(Employe $user, User $model): bool
    {
        return $user->role === 'admin';
    }


    /**
     * Admin يقدر يحذف User
     */
    public function delete(Employe $user, User $model): bool
    {
        return $user->role === 'admin';
    }


    public function restore(Employe $user, User $model): bool
    {
        return $user->role === 'admin';
    }


    public function forceDelete(Employe $user, User $model): bool
    {
        return $user->role === 'admin';
    }
}
