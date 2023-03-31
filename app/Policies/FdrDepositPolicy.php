<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FdrDeposit;
use Illuminate\Auth\Access\HandlesAuthorization;

class FdrDepositPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the fdrDeposit can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list fdrdeposits');
    }

    /**
     * Determine whether the fdrDeposit can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrDeposit  $model
     * @return mixed
     */
    public function view(User $user, FdrDeposit $model)
    {
        return $user->hasPermissionTo('view fdrdeposits');
    }

    /**
     * Determine whether the fdrDeposit can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create fdrdeposits');
    }

    /**
     * Determine whether the fdrDeposit can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrDeposit  $model
     * @return mixed
     */
    public function update(User $user, FdrDeposit $model)
    {
        return $user->hasPermissionTo('update fdrdeposits');
    }

    /**
     * Determine whether the fdrDeposit can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrDeposit  $model
     * @return mixed
     */
    public function delete(User $user, FdrDeposit $model)
    {
        return $user->hasPermissionTo('delete fdrdeposits');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrDeposit  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete fdrdeposits');
    }

    /**
     * Determine whether the fdrDeposit can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrDeposit  $model
     * @return mixed
     */
    public function restore(User $user, FdrDeposit $model)
    {
        return false;
    }

    /**
     * Determine whether the fdrDeposit can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FdrDeposit  $model
     * @return mixed
     */
    public function forceDelete(User $user, FdrDeposit $model)
    {
        return false;
    }
}
