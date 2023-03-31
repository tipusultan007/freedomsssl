<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SavingsCollection;
use Illuminate\Auth\Access\HandlesAuthorization;

class SavingsCollectionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the savingsCollection can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list savingscollections');
    }

    /**
     * Determine whether the savingsCollection can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SavingsCollection  $model
     * @return mixed
     */
    public function view(User $user, SavingsCollection $model)
    {
        return $user->hasPermissionTo('view savingscollections');
    }

    /**
     * Determine whether the savingsCollection can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create savingscollections');
    }

    /**
     * Determine whether the savingsCollection can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SavingsCollection  $model
     * @return mixed
     */
    public function update(User $user, SavingsCollection $model)
    {
        return $user->hasPermissionTo('update savingscollections');
    }

    /**
     * Determine whether the savingsCollection can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SavingsCollection  $model
     * @return mixed
     */
    public function delete(User $user, SavingsCollection $model)
    {
        return $user->hasPermissionTo('delete savingscollections');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SavingsCollection  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete savingscollections');
    }

    /**
     * Determine whether the savingsCollection can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SavingsCollection  $model
     * @return mixed
     */
    public function restore(User $user, SavingsCollection $model)
    {
        return false;
    }

    /**
     * Determine whether the savingsCollection can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SavingsCollection  $model
     * @return mixed
     */
    public function forceDelete(User $user, SavingsCollection $model)
    {
        return false;
    }
}
