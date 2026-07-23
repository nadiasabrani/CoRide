<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Admin فقط يشوف لائحة المستخدمين
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }


    /**
     * Admin يشوف User معين
     */
    public function view(User $user, User $model): bool
    {
        return $user->role === 'admin';
    }


    /**
     * Admin يقدر يزيد User
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }


    /**
     * Admin يقدر يعدل User
     */
    public function update(User $user, User $model): bool
    {
        return $user->role === 'admin';
    }


    /**
     * Admin يقدر يحذف User
     */
    public function delete(User $user, User $model): bool
    {
        return $user->role === 'admin';
    }


    public function restore(User $user, User $model): bool
    {
        return $user->role === 'admin';
    }


    public function forceDelete(User $user, User $model): bool
    {
        return $user->role === 'admin';
    }
}
