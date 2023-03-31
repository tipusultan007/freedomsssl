<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DailyLoan;
use Illuminate\Auth\Access\HandlesAuthorization;

class DailyLoanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dailyLoan can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list dailyloans');
    }

    /**
     * Determine whether the dailyLoan can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyLoan  $model
     * @return mixed
     */
    public function view(User $user, DailyLoan $model)
    {
        return $user->hasPermissionTo('view dailyloans');
    }

    /**
     * Determine whether the dailyLoan can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create dailyloans');
    }

    /**
     * Determine whether the dailyLoan can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyLoan  $model
     * @return mixed
     */
    public function update(User $user, DailyLoan $model)
    {
        return $user->hasPermissionTo('update dailyloans');
    }

    /**
     * Determine whether the dailyLoan can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyLoan  $model
     * @return mixed
     */
    public function delete(User $user, DailyLoan $model)
    {
        return $user->hasPermissionTo('delete dailyloans');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyLoan  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete dailyloans');
    }

    /**
     * Determine whether the dailyLoan can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyLoan  $model
     * @return mixed
     */
    public function restore(User $user, DailyLoan $model)
    {
        return false;
    }

    /**
     * Determine whether the dailyLoan can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DailyLoan  $model
     * @return mixed
     */
    public function forceDelete(User $user, DailyLoan $model)
    {
        return false;
    }
}
