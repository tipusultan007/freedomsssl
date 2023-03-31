<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FdrWithdraw;
use Illuminate\Auth\Access\HandlesAuthorization;

class FdrWithdrawPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the fdrWithdraw can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list fdrwithdraws');
    }

    /**
     * Determine whether the fdrWithdraw can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrWithdraw  $model
     * @return mixed
     */
    public function view(User $user, FdrWithdraw $model)
    {
        return $user->hasPermissionTo('view fdrwithdraws');
    }

    /**
     * Determine whether the fdrWithdraw can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create fdrwithdraws');
    }

    /**
     * Determine whether the fdrWithdraw can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrWithdraw  $model
     * @return mixed
     */
    public function update(User $user, FdrWithdraw $model)
    {
        return $user->hasPermissionTo('update fdrwithdraws');
    }

    /**
     * Determine whether the fdrWithdraw can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrWithdraw  $model
     * @return mixed
     */
    public function delete(User $user, FdrWithdraw $model)
    {
        return $user->hasPermissionTo('delete fdrwithdraws');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrWithdraw  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete fdrwithdraws');
    }

    /**
     * Determine whether the fdrWithdraw can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrWithdraw  $model
     * @return mixed
     */
    public function restore(User $user, FdrWithdraw $model)
    {
        return false;
    }

    /**
     * Determine whether the fdrWithdraw can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrWithdraw  $model
     * @return mixed
     */
    public function forceDelete(User $user, FdrWithdraw $model)
    {
        return false;
    }
}
