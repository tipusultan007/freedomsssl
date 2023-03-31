<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DpsLoanCollection;
use Illuminate\Auth\Access\HandlesAuthorization;

class DpsLoanCollectionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dpsLoanCollection can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list dpsloancollections');
    }

    /**
     * Determine whether the dpsLoanCollection can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsLoanCollection  $model
     * @return mixed
     */
    public function view(User $user, DpsLoanCollection $model)
    {
        return $user->hasPermissionTo('view dpsloancollections');
    }

    /**
     * Determine whether the dpsLoanCollection can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create dpsloancollections');
    }

    /**
     * Determine whether the dpsLoanCollection can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsLoanCollection  $model
     * @return mixed
     */
    public function update(User $user, DpsLoanCollection $model)
    {
        return $user->hasPermissionTo('update dpsloancollections');
    }

    /**
     * Determine whether the dpsLoanCollection can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsLoanCollection  $model
     * @return mixed
     */
    public function delete(User $user, DpsLoanCollection $model)
    {
        return $user->hasPermissionTo('delete dpsloancollections');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsLoanCollection  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete dpsloancollections');
    }

    /**
     * Determine whether the dpsLoanCollection can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsLoanCollection  $model
     * @return mixed
     */
    public function restore(User $user, DpsLoanCollection $model)
    {
        return false;
    }

    /**
     * Determine whether the dpsLoanCollection can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DpsLoanCollection  $model
     * @return mixed
     */
    public function forceDelete(User $user, DpsLoanCollection $model)
    {
        return false;
    }
}
