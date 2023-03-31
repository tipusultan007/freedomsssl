<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DailyLoanCollection;
use Illuminate\Auth\Access\HandlesAuthorization;

class DailyLoanCollectionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dailyLoanCollection can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list dailyloancollections');
    }

    /**
     * Determine whether the dailyLoanCollection can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyLoanCollection  $model
     * @return mixed
     */
    public function view(User $user, DailyLoanCollection $model)
    {
        return $user->hasPermissionTo('view dailyloancollections');
    }

    /**
     * Determine whether the dailyLoanCollection can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create dailyloancollections');
    }

    /**
     * Determine whether the dailyLoanCollection can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyLoanCollection  $model
     * @return mixed
     */
    public function update(User $user, DailyLoanCollection $model)
    {
        return $user->hasPermissionTo('update dailyloancollections');
    }

    /**
     * Determine whether the dailyLoanCollection can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyLoanCollection  $model
     * @return mixed
     */
    public function delete(User $user, DailyLoanCollection $model)
    {
        return $user->hasPermissionTo('delete dailyloancollections');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyLoanCollection  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete dailyloancollections');
    }

    /**
     * Determine whether the dailyLoanCollection can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyLoanCollection  $model
     * @return mixed
     */
    public function restore(User $user, DailyLoanCollection $model)
    {
        return false;
    }

    /**
     * Determine whether the dailyLoanCollection can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyLoanCollection  $model
     * @return mixed
     */
    public function forceDelete(User $user, DailyLoanCollection $model)
    {
        return false;
    }
}
